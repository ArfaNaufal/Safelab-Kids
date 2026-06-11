<?php

namespace App\Application\Services;

use App\Domain\Contracts\QuestionRepositoryInterface;
use App\Models\Experiment;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{
    public function __construct(private QuestionRepositoryInterface $questionRepository)
    {
    }

    public function listForExperiment(Experiment $experiment): Collection
    {
        return $this->questionRepository->getByExperiment($experiment);
    }

    public function createQuestion(Experiment $experiment, string $questionText, array $answerTexts, int $correctIndex): Question
    {
        return $this->questionRepository->create($experiment, $questionText, $answerTexts, $correctIndex);
    }

    public function updateQuestion(Question $question, string $questionText, array $answerTexts, int $correctIndex): bool
    {
        return $this->questionRepository->update($question, $questionText, $answerTexts, $correctIndex);
    }

    public function removeQuestion(Question $question): bool
    {
        return $this->questionRepository->delete($question);
    }
}
