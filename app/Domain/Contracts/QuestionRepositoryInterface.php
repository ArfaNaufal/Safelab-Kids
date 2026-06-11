<?php

namespace App\Domain\Contracts;

use App\Models\Experiment;
use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

interface QuestionRepositoryInterface
{
    public function getByExperiment(Experiment $experiment): Collection;
    public function create(Experiment $experiment, string $questionText, array $answerTexts, int $correctIndex): Question;
    public function update(Question $question, string $questionText, array $answerTexts, int $correctIndex): bool;
    public function delete(Question $question): bool;
}
