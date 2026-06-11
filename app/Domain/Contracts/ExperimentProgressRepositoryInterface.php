<?php

namespace App\Domain\Contracts;

use App\Models\ExperimentProgress;
use Illuminate\Database\Eloquent\Collection;

interface ExperimentProgressRepositoryInterface
{
    public function getByUser(int $userId): Collection;
    public function getByUserAndExperiment(int $userId, int $experimentId): ?ExperimentProgress;
    public function updateOrCreate(array $criteria, array $values): ExperimentProgress;
    public function recentByUser(int $userId, int $limit = 5): Collection;
    public function betweenForUser(int $userId, string $from, string $to): Collection;
    public function countCompletedByUser(int $userId): int;
    public function countDistinctCompletedByUser(int $userId): int;
    public function favoriteCategoryForUser(int $userId): string;
}
