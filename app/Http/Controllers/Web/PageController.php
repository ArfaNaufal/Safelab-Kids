<?php

namespace App\Http\Controllers\Web;

use App\Application\Services\ExperimentService;
use App\Application\Services\ProgressService;
use App\Application\Services\QuizService;
use App\Http\Controllers\Controller;
use App\Models\Experiment;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public const QUIZ_PASSING_SCORE = 80;
    private const STATUS_STARTED = 'started';
    private const STATUS_COMPLETED = 'completed';
    private const STATUS_QUIZ_PENDING = 'quiz_pending';

    public function __construct(
        private ExperimentService $experimentService,
        private ProgressService $progressService,
        private QuizService $quizService
    ) {
    }

    public function index()
    {
        $popularExperiments = $this->experimentService->popularExperiments();
        $totalExperimentCount = $this->experimentService->experimentCount();

        return view('pages.index', compact('popularExperiments', 'totalExperimentCount'));
    }

    public function catalog(Request $request)
    {
        $filters = [
            'search' => $request->query('q'),
            'category' => $request->query('category'),
            'difficulty' => $request->query('difficulty'),
        ];

        $experiments = $this->experimentService->listExperiments($filters);
        $categories = $this->experimentService->categories();
        $difficulties = ['Mudah', 'Sedang', 'Sulit'];

        $progressMap = [];
        if (Auth::check()) {
            $progressMap = $this->progressService->progressMapForUser(Auth::id());
        }

        return view('pages.catalog', compact('experiments', 'categories', 'difficulties', 'progressMap'))
            ->with('search', $filters['search'] ?? '')
            ->with('selectedCategory', $filters['category'] ?? '')
            ->with('selectedDifficulty', $filters['difficulty'] ?? '');
    }

    public function simulation($id)
    {
        $experiment = $this->experimentService->findOrFail((int) $id);
        $steps = is_array($experiment->simulation_data['steps'] ?? null) ? $experiment->simulation_data['steps'] : [];
        $totalSteps = max(1, count($steps));

        $currentStep = 1;
        $progressStatus = 'not_started';

        if (Auth::check()) {
            $progress = $this->progressService->findProgress(Auth::id(), $experiment->id);

            if ($progress) {
                $currentStep = max(1, min($progress->current_step ?? 1, $totalSteps));

                if ($progress->status === self::STATUS_COMPLETED) {
                    $progressStatus = self::STATUS_COMPLETED;
                    $currentStep = $totalSteps;
                } elseif ($progress->status === self::STATUS_QUIZ_PENDING) {
                    $progressStatus = self::STATUS_QUIZ_PENDING;
                    $currentStep = $totalSteps;
                } else {
                    $progressStatus = self::STATUS_STARTED;
                }
            }
        }

        return view('pages.simulation', compact('experiment', 'currentStep', 'totalSteps', 'progressStatus'));
    }

    public function progress(Request $request, $id)
    {
        $experiment = $this->experimentService->findOrFail((int) $id);
        $steps = is_array($experiment->simulation_data['steps'] ?? null) ? $experiment->simulation_data['steps'] : [];
        $totalSteps = max(1, count($steps));

        $validated = $request->validate([
            'step' => "required|integer|min:1|max:{$totalSteps}",
            'status' => 'required|in:started,completed,reset',
        ]);

        $status = $validated['status'];
        $currentStep = $validated['step'];

        if ($status === 'reset') {
            $status = self::STATUS_STARTED;
            $currentStep = 1;
        }

        if ($status === self::STATUS_COMPLETED && $currentStep >= $totalSteps) {
            $status = self::STATUS_QUIZ_PENDING;
            $currentStep = $totalSteps;
        }

        $score = $status === self::STATUS_COMPLETED ? $experiment->points_reward : null;

        $this->progressService->saveProgress(
            Auth::id(),
            $experiment->id,
            $currentStep,
            $status,
            $score
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'current_step' => $currentStep,
                'total_steps' => $totalSteps,
                'progress_status' => $status,
            ],
        ], 200);
    }

    public function dashboard()
    {
        $user = Auth::user();

        $recentActivities = $this->progressService->recentActivities($user->id);
        $completedCount = $this->progressService->completedCount($user->id);
        $badgeCount = $this->progressService->completedBadgeCount($user->id);
        $favoriteTopic = $this->progressService->favoriteTopic($user->id);

        $weekDays = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'];
        $weeklyData = array_fill_keys($weekDays, 0);
        $dayMap = ['Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum'];

        $weeklyActivities = $this->progressService->progressBetween(
            $user->id,
            now()->startOfWeek()->toDateTimeString(),
            now()->endOfWeek()->toDateTimeString()
        );

        $weeklyActivities->each(function ($activity) use (&$weeklyData, $dayMap) {
            $dayName = $activity->created_at->format('D');
            if (isset($dayMap[$dayName])) {
                $weeklyData[$dayMap[$dayName]]++;
            }
        });

        return view('pages.dashboard', compact('user', 'recentActivities', 'completedCount', 'badgeCount', 'favoriteTopic', 'weeklyData'));
    }

    public function quiz($id)
    {
        $experimentId = (int) $id;
        $experiment = $this->experimentService->findOrFail($experimentId);
        $steps = is_array($experiment->simulation_data['steps'] ?? null) ? $experiment->simulation_data['steps'] : [];
        $totalSteps = max(1, count($steps));

        $progress = $this->progressService->findProgress(Auth::id(), $experimentId);

        if (! $progress || $progress->current_step < $totalSteps) {
            return redirect()->route('simulation', $experimentId)
                ->with('error', 'Selesaikan simulasi terlebih dahulu sebelum mengikuti kuis.');
        }

        if ($progress->status === self::STATUS_STARTED) {
            $this->progressService->saveProgress(Auth::id(), $experimentId, $progress->current_step, self::STATUS_QUIZ_PENDING, $progress->score);
            $progress->refresh();
        }

        $questions = $this->quizService->questionsForExperiment($experimentId);

        return view('pages.quiz', compact('experiment', 'questions'));
    }

    public function submitQuiz(Request $request, $id)
    {
        $experimentId = (int) $id;
        $experiment = $this->experimentService->findOrFail($experimentId);

        $quizResult = $this->quizService->createQuizResult(Auth::id(), $experiment, $request->all());
        $progress = $this->progressService->findProgress(Auth::id(), $experimentId);

        $passed = $quizResult->score >= self::QUIZ_PASSING_SCORE;
        $bonusPoints = (int) round($experiment->points_reward * 0.5 * ($quizResult->score / 100));

        if ($progress) {
            if ($passed) {
                $totalAward = $experiment->points_reward + $bonusPoints;
                Auth::user()->increment('total_points', $totalAward);
                $progress->update([
                    'status' => self::STATUS_COMPLETED,
                    'completed_at' => now(),
                    'score' => $totalAward,
                ]);
            } else {
                $progress->update(['status' => self::STATUS_QUIZ_PENDING]);
            }
        }

        return redirect()->route('quiz.results', ['id' => $experimentId, 'result' => $quizResult->id]);
    }

    public function quizResults($id)
    {
        $experimentId = (int) $id;
        $resultId = (int) request()->query('result');

        if (! $resultId) {
            return redirect()->route('catalog')->with('error', 'Hasil kuis tidak ditemukan.');
        }

        $experiment = $this->experimentService->findOrFail($experimentId);
        $result = QuizResult::findOrFail($resultId);

        if ((int) $result->user_id !== (int) Auth::id() || (int) $result->experiment_id !== $experimentId) {
            abort(403, 'Anda tidak diizinkan mengakses hasil kuis ini.');
        }

        return view('pages.quiz-results', compact('experiment', 'result'));
    }
}
