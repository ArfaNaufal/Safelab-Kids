<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Contracts\QuestionRepositoryInterface;
use App\Models\Experiment;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class EloquentQuestionRepository implements QuestionRepositoryInterface
{
    public function getByExperiment(Experiment $experiment): Collection
    {
        return $experiment->questions()->with('answers')->get();
    }

    public function create(Experiment $experiment, string $questionText, array $answerTexts, int $correctIndex): Question
    {
        $question = $experiment->questions()->create([
            'question_text' => $questionText,
        ]);

        foreach ($answerTexts as $index => $answerText) {
            $question->answers()->create([
                'answer_text' => $answerText,
                'is_correct' => $index === $correctIndex,
            ]);
        }

        return $question;
    }

    public function update(Question $question, string $questionText, array $answerTexts, int $correctIndex): bool
    {
        $question->update(['question_text' => $questionText]);
        $question->answers()->delete();

        foreach ($answerTexts as $index => $answerText) {
            $question->answers()->create([
                'answer_text' => $answerText,
                'is_correct' => $index === $correctIndex,
            ]);
        }

        return true;
    }

    public function delete(Question $question): bool
    {
        return $question->delete();
    }
}
