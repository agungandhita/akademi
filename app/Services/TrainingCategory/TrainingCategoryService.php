<?php

namespace App\Services\TrainingCategory;

use App\Models\TrainingCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TrainingCategoryService implements TrainingCategoryInterface
{
    public function getAllPaginated(?string $search = null, int $perPage = 15): LengthAwarePaginator
    {
        return TrainingCategory::search($search)
            ->withCount('trainings')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getAll(): Collection
    {
        return TrainingCategory::orderBy('name')->get();
    }

    public function getById(int $id): TrainingCategory
    {
        return TrainingCategory::findOrFail($id);
    }

    public function create(array $data): TrainingCategory
    {
        return TrainingCategory::create([
            'name' => $data['name'],
            'slug' => ! empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);
    }

    public function update(int $id, array $data): TrainingCategory
    {
        $category = $this->getById($id);

        $category->update([
            'name' => $data['name'],
            'slug' => ! empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']),
            'description' => $data['description'] ?? null,
        ]);

        return $category;
    }

    public function delete(int $id): bool
    {
        $category = $this->getById($id);

        return (bool) $category->delete();
    }
}
