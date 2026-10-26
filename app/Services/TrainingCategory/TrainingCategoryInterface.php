<?php

namespace App\Services\TrainingCategory;

use App\Models\TrainingCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TrainingCategoryInterface
{
    /**
     * @return LengthAwarePaginator<TrainingCategory>
     */
    public function getAllPaginated(?string $search = null, int $perPage = 15): LengthAwarePaginator;

    /**
     * @return Collection<int, TrainingCategory>
     */
    public function getAll(): Collection;

    public function getById(int $id): TrainingCategory;

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): TrainingCategory;

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(int $id, array $data): TrainingCategory;

    public function delete(int $id): bool;
}
