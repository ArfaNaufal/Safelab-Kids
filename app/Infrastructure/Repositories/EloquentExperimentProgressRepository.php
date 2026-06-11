<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Contracts\ExperimentProgressRepositoryInterface;
use App\Models\ExperimentProgress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentExperimentProgressRepository implements ExperimentProgressRepositoryInterface
{
    public function getByUser(int $userId): Collection
    {
        return ExperimentProgress::where('user_id', $userId)->get()->keyBy('experiment_id');
    }

    public function getByUserAndExperiment(int $userId, int $experimentId): ?ExperimentProgress
    {
        return ExperimentProgress::where('user_id', $userId)
            ->where('experiment_id', $experimentId)
            ->first();
    }

    public function updateOrCreate(array $criteria, array $values): ExperimentProgress
    {
        return ExperimentProgress::updateOrCreate($criteria, $values);
    }

    public function recentByUser(int $userId, int $limit = 5): Collection
    {
        return ExperimentProgress::with('experiment')
            ->where('user_id', $userId)
            ->orderBy('updated_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function betweenForUser(int $userId, string $from, string $to): Collection
    {
        return ExperimentProgress::where('user_id', $userId)
            ->whereBetween('created_at', [$from, $to])
            ->get();
    }

    public function countCompletedByUser(int $userId): int
    {
        return ExperimentProgress::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
    }

    public function countDistinctCompletedByUser(int $userId): int
    {
        return ExperimentProgress::where('user_id', $userId)
            ->where('status', 'completed')
            ->distinct('experiment_id')
            ->count('experiment_id');
    }

    public function favoriteCategoryForUser(int $userId): string
    {
        $favorite = ExperimentProgress::select('experiments.category', DB::raw('count(*) as total'))
            ->join('experiments', 'experiment_progress.experiment_id', '=', 'experiments.id')
            ->where('experiment_progress.user_id', $userId)
            ->where('experiment_progress.status', 'completed')
            ->groupBy('experiments.category')
            ->orderByDesc('total')
            ->value('experiments.category');

        return $favorite ?? 'Kimia Dasar';
    }
}
