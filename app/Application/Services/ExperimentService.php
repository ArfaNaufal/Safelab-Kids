<?php

namespace App\Application\Services;

use App\Domain\Contracts\ExperimentRepositoryInterface;
use App\Models\Experiment;
use Illuminate\Database\Eloquent\Collection;

class ExperimentService
{
    public function __construct(private ExperimentRepositoryInterface $experimentRepository)
    {
    }

    public function listExperiments(array $filters = []): Collection
    {
        return $this->experimentRepository->all($filters);
    }

    public function popularExperiments(int $limit = 3): Collection
    {
        return $this->experimentRepository->popular($limit);
    }

    public function experimentCount(): int
    {
        return $this->experimentRepository->count();
    }

    public function categories(): array
    {
        return $this->experimentRepository->categories();
    }

    public function findOrFail(int $id): Experiment
    {
        return $this->experimentRepository->findOrFail($id);
    }

    public function createExperiment(array $data): Experiment
    {
        return $this->experimentRepository->create($data);
    }

    public function updateExperiment(Experiment $experiment, array $data): bool
    {
        return $this->experimentRepository->update($experiment, $data);
    }

    public function deleteExperiment(Experiment $experiment): bool
    {
        return $this->experimentRepository->delete($experiment);
    }
}
