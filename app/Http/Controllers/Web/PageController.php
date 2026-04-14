<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Experiment;
use App\Models\ExperimentProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    public const QUIZ_PASSING_SCORE = 80;
    private const STATUS_STARTED = 'started';
    private const STATUS_COMPLETED = 'completed';
    private const STATUS_QUIZ_PENDING = 'quiz_pending';

    public function index()
    {
        $popularExperiments = Experiment::orderByDesc('points_reward')->take(3)->get();
        $totalExperimentCount = Experiment::count();

        return view('pages.index', compact('popularExperiments', 'totalExperimentCount'));
    }

    public function catalog(Request $request)
    {
        $query = Experiment::query();

        if ($search = $request->query('q')) {
            $query->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        if ($difficulty = $request->query('difficulty')) {
            $query->where('difficulty', $difficulty);
        }

        $experiments = $query->orderBy('title')->get();
        $categories = Experiment::select('category')->distinct()->pluck('category')->toArray();
        $difficulties = ['Mudah', 'Sedang', 'Sulit'];

        $progressMap = [];
        if (Auth::check()) {
            $progressMap = ExperimentProgress::where('user_id', Auth::id())
                ->get()
                ->keyBy('experiment_id');
        }

        return view('pages.catalog', compact('experiments', 'categories', 'difficulties', 'progressMap'))
            ->with('search', $search ?? '')
            ->with('selectedCategory', $category ?? '')
            ->with('selectedDifficulty', $difficulty ?? '');
    }

    public function simulation($id)
    {
        $experiment = Experiment::findOrFail($id);
        $steps = is_array($experiment->simulation_data['steps'] ?? null) ? $experiment->simulation_data['steps'] : [];
        $totalSteps = max(1, count($steps));

        $currentStep = 1;
        $progressStatus = 'not_started';

        if (Auth::check()) {
            $progress = ExperimentProgress::where('user_id', Auth::id())
                ->where('experiment_id', $id)
                ->first();

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
        $experiment = Experiment::findOrFail($id);
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

        $progress = ExperimentProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'experiment_id' => $id],
            [
                'status' => $status,
                'current_step' => $currentStep,
                'completed_at' => $status === self::STATUS_COMPLETED ? now() : null,
                'score' => $status === self::STATUS_COMPLETED ? $experiment->points_reward : null,
            ]
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
        
        $recentActivities = ExperimentProgress::with('experiment')
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();
            
        $completedCount = ExperimentProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $badgeCount = ExperimentProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->distinct('experiment_id')
            ->count('experiment_id');

        $favoriteTopic = ExperimentProgress::select('experiments.category', DB::raw('count(*) as total'))
            ->join('experiments', 'experiment_progress.experiment_id', '=', 'experiments.id')
            ->where('experiment_progress.user_id', $user->id)
            ->where('experiment_progress.status', 'completed')
            ->groupBy('experiments.category')
            ->orderByDesc('total')
            ->value('experiments.category') ?? 'Kimia Dasar';

        $weekDays = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'];
        $weeklyData = array_fill_keys($weekDays, 0);
        $dayMap = ['Mon' => 'Sen', 'Tue' => 'Sel', 'Wed' => 'Rab', 'Thu' => 'Kam', 'Fri' => 'Jum'];

        ExperimentProgress::where('user_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->get()
            ->each(function ($activity) use (&$weeklyData, $dayMap) {
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
        $experiment = Experiment::findOrFail($experimentId);
        $steps = is_array($experiment->simulation_data['steps'] ?? null) ? $experiment->simulation_data['steps'] : [];
        $totalSteps = max(1, count($steps));

        $progress = ExperimentProgress::where('user_id', Auth::id())
            ->where('experiment_id', $experimentId)
            ->first();

        if (!$progress || $progress->current_step < $totalSteps) {
            return redirect()->route('simulation', $experimentId)->with('error', 'Selesaikan simulasi terlebih dahulu sebelum mengikuti kuis.');
        }

        if ($progress->status === self::STATUS_STARTED) {
            $progress->update(['status' => self::STATUS_QUIZ_PENDING]);
        }

        $questions = \App\Models\Question::where('experiment_id', $experimentId)
            ->with('answers')
            ->get();

        return view('pages.quiz', compact('experiment', 'questions'));
    }

    public function submitQuiz(Request $request, $id)
    {
        $experimentId = (int) $id;
        $experiment = Experiment::findOrFail($experimentId);
        
        $questions = \App\Models\Question::where('experiment_id', $experimentId)->get();
        $totalQuestions = count($questions);

        $correctCount = 0;

        foreach ($questions as $question) {
            $userAnswer = $request->input("answer_{$question->id}");
            
            if ($userAnswer) {
                $correctAnswer = $question->answers()->where('is_correct', true)->first();
                if ($correctAnswer && $correctAnswer->id == $userAnswer) {
                    $correctCount++;
                }
            }
        }

        $score = round(($correctCount / $totalQuestions) * 100);

        $quizResult = \App\Models\QuizResult::create([
            'user_id' => Auth::id(),
            'experiment_id' => $experimentId,
            'score' => $score,
            'correct_answers' => $correctCount,
            'total_questions' => $totalQuestions,
        ]);

        $progress = ExperimentProgress::where('user_id', Auth::id())
            ->where('experiment_id', $experimentId)
            ->first();

        $passed = $score >= self::QUIZ_PASSING_SCORE;
        $bonusPoints = round($experiment->points_reward * 0.5 * ($score / 100));

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
                $progress->update([
                    'status' => self::STATUS_QUIZ_PENDING,
                ]);
            }
        }

        return redirect()->route('quiz.results', ['id' => $experimentId, 'result' => $quizResult->id]);
    }

    public function quizResults($id)
    {
        $experimentId = (int) $id;
        $resultId = (int) request()->query('result');

        if (!$resultId) {
            return redirect()->route('catalog')->with('error', 'Hasil kuis tidak ditemukan.');
        }

        $experiment = Experiment::findOrFail($experimentId);
        $result = \App\Models\QuizResult::findOrFail($resultId);

        if ((int) $result->user_id !== (int) Auth::id() || (int) $result->experiment_id !== $experimentId) {
            abort(403, 'Anda tidak diizinkan mengakses hasil kuis ini.');
        }

        return view('pages.quiz-results', compact('experiment', 'result'));
    }

}
