<?php

namespace App\Domain\Contracts;

use App\Models\Experiment;
use Illuminate\Database\Eloquent\Collection;

interface ExperimentRepositoryInterface
{
    public function all(array $filters = []): Collection;
    public function popular(int $limit = 3): Collection;
    public function count(): int;
    public function categories(): array;
    public function find(int $id): ?Experiment;
    public function findOrFail(int $id): Experiment;
    public function create(array $data): Experiment;
    public function update(Experiment $experiment, array $data): bool;
    public function delete(Experiment $experiment): bool;
}
