<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Contracts\ExperimentRepositoryInterface;
use App\Models\Experiment;
use Illuminate\Database\Eloquent\Collection;

class EloquentExperimentRepository implements ExperimentRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = Experiment::query();

        if (! empty($filters['search'])) {
            $query->where(function ($sub) use ($filters) {
                $sub->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (! empty($filters['difficulty'])) {
            $query->where('difficulty', $filters['difficulty']);
        }

        return $query->orderBy('title')->get();
    }

    public function popular(int $limit = 3): Collection
    {
        return Experiment::orderByDesc('points_reward')->take($limit)->get();
    }

    public function count(): int
    {
        return Experiment::count();
    }

    public function categories(): array
    {
        return Experiment::select('category')->distinct()->pluck('category')->toArray();
    }

    public function find(int $id): ?Experiment
    {
        return Experiment::find($id);
    }

    public function findOrFail(int $id): Experiment
    {
        return Experiment::findOrFail($id);
    }

    public function create(array $data): Experiment
    {
        return Experiment::create($data);
    }

    public function update(Experiment $experiment, array $data): bool
    {
        return $experiment->update($data);
    }

    public function delete(Experiment $experiment): bool
    {
        return $experiment->delete();
    }
}
