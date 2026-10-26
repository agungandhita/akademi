<?php

namespace App\Services\User;

use App\DTOs\Users\CreateTentorDTO;
use App\DTOs\Users\UpdateUserDTO;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserInterface
{
    /**
     * @return LengthAwarePaginator<User>
     */
    public function getAllPaginated(?string $search = null, ?string $role = null, int $perPage = 15): LengthAwarePaginator;

    public function getById(int $id): User;

    public function createTentor(CreateTentorDTO $dto): User;

    public function update(int $id, UpdateUserDTO $dto): User;

    public function toggleActive(int $id): User;

    public function delete(int $id): bool;

    /**
     * @return Collection<int, User>
     */
    public function getAllTentors(): Collection;

    /**
     * @return array{total: int, admin: int, tentor: int, peserta: int}
     */
    public function getUserRoleCounts(): array;
}
