<?php

namespace App\Application\Services;

use App\Domain\Contracts\ExperimentProgressRepositoryInterface;
use App\Models\ExperimentProgress;
use Illuminate\Database\Eloquent\Collection;

class ProgressService
{
    public function __construct(private ExperimentProgressRepositoryInterface $progressRepository)
    {
    }

    public function progressMapForUser(int $userId): Collection
    {
        return $this->progressRepository->getByUser($userId);
    }

    public function findProgress(int $userId, int $experimentId): ?ExperimentProgress
    {
        return $this->progressRepository->getByUserAndExperiment($userId, $experimentId);
    }

    public function saveProgress(int $userId, int $experimentId, int $currentStep, string $status, ?int $score = null): ExperimentProgress
    {
        return $this->progressRepository->updateOrCreate([
            'user_id' => $userId,
            'experiment_id' => $experimentId,
        ], [
            'status' => $status,
            'current_step' => $currentStep,
            'completed_at' => $status === 'completed' ? now() : null,
            'score' => $score,
        ]);
    }

    public function recentActivities(int $userId, int $limit = 5): Collection
    {
        return $this->progressRepository->recentByUser($userId, $limit);
    }

    public function progressBetween(int $userId, string $from, string $to): Collection
    {
        return $this->progressRepository->betweenForUser($userId, $from, $to);
    }

    public function completedCount(int $userId): int
    {
        return $this->progressRepository->countCompletedByUser($userId);
    }

    public function completedBadgeCount(int $userId): int
    {
        return $this->progressRepository->countDistinctCompletedByUser($userId);
    }

    public function favoriteTopic(int $userId): string
    {
        return $this->progressRepository->favoriteCategoryForUser($userId);
    }
}
