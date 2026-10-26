<?php

namespace App\Services\Training;

use App\DTOs\Trainings\CreateTrainingDTO;
use App\DTOs\Trainings\UpdateTrainingDTO;
use App\Models\Training;
use App\Models\TrainingSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TrainingInterface
{
    /**
     * @param  array<string, mixed>  $filters
     * @return LengthAwarePaginator<Training>
     */
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function getById(int $id): Training;

    public function getBySlug(string $slug): Training;

    public function create(CreateTrainingDTO $dto): Training;

    public function update(int $id, UpdateTrainingDTO $dto): Training;

    public function delete(int $id): bool;

    /**
     * @param  array<int>  $instructorIds
     */
    public function syncInstructors(int $trainingId, array $instructorIds): Training;

    /**
     * @param  array<string, mixed>  $sessionData
     */
    public function addSession(int $trainingId, array $sessionData): TrainingSession;

    public function deleteSession(int $sessionId): bool;

    /**
     * @return array{total: int, published: int, draft: int, closed: int, archived: int}
     */
     public function getTrainingStatusCounts(): array;

    /**
     * @return array{online: int, blended: int, offline: int}
     */
    public function getTrainingModeCounts(): array;

    /**
     * @return Collection<int, Training>
     */
    public function getRecentTrainings(int $limit = 5): Collection;

    /**
     * @return Collection<int, Training>
     */
    public function getByInstructor(int $instructorId): Collection;
}
