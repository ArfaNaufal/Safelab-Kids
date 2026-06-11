<?php

namespace App\Application\Services;

use App\Models\Experiment;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Database\Eloquent\Collection;

class QuizService
{
    public function questionsForExperiment(int $experimentId): Collection
    {
        return Question::where('experiment_id', $experimentId)
            ->with('answers')
            ->get();
    }

    public function createQuizResult(int $userId, Experiment $experiment, array $answers): QuizResult
    {
        $questions = $this->questionsForExperiment($experiment->id);
        $totalQuestions = $questions->count();

        $correctCount = 0;

        foreach ($questions as $question) {
            $selectedAnswer = $answers['answer_' . $question->id] ?? null;
            $correctAnswer = $question->answers->firstWhere('is_correct', true);

            if ($correctAnswer && (string) $correctAnswer->id === (string) $selectedAnswer) {
                $correctCount++;
            }
        }

        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;

        return QuizResult::create([
            'user_id' => $userId,
            'experiment_id' => $experiment->id,
            'score' => $score,
            'correct_answers' => $correctCount,
            'total_questions' => $totalQuestions,
        ]);
    }
}
