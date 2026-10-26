<?php

namespace App\Services\User;

use App\DTOs\Users\CreateTentorDTO;
use App\DTOs\Users\UpdateUserDTO;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserInterface
{
    public function getAllPaginated(?string $search = null, ?string $role = null, int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->when(! empty($search), function (Builder $query) use ($search) {
                $query->where(function (Builder $q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('institution', 'like', "%{$search}%");
                });
            })
            ->when(! empty($role), function (Builder $query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getById(int $id): User
    {
        return User::with(['createdTrainings.category', 'assignedTrainings.category'])->findOrFail($id);
    }

    public function createTentor(CreateTentorDTO $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'role' => UserRole::Tentor,
            'bio' => $dto->bio,
            'expertise' => $dto->expertise,
            'phone' => $dto->phone,
            'avatar' => $dto->avatar,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }

    public function update(int $id, UpdateUserDTO $dto): User
    {
        $user = $this->getById($id);

        $payload = [
            'name' => $dto->name,
            'email' => $dto->email,
            'phone' => $dto->phone,
            'institution' => $dto->institution,
            'bio' => $dto->bio,
            'expertise' => $dto->expertise,
        ];

        if ($dto->is_active !== null) {
            $payload['is_active'] = $dto->is_active;
        }

        if ($dto->participant_type !== null) {
            $payload['participant_type'] = $dto->participant_type;
        }

        if ($dto->avatar !== null) {
            $payload['avatar'] = $dto->avatar;
        }

        $user->update($payload);

        return $user;
    }

    public function toggleActive(int $id): User
    {
        $user = $this->getById($id);
        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        return $user;
    }

    public function delete(int $id): bool
    {
        $user = $this->getById($id);

        return (bool) $user->delete();
    }

    public function getAllTentors(): Collection
    {
        return User::role(UserRole::Tentor)->active()->orderBy('name')->get();
    }

    public function getUserRoleCounts(): array
    {
        $adminCount = User::role(UserRole::Admin)->count();
        $tentorCount = User::role(UserRole::Tentor)->count();
        $pesertaCount = User::role(UserRole::Peserta)->count();

        return [
            'total' => $adminCount + $tentorCount + $pesertaCount,
            'admin' => $adminCount,
            'tentor' => $tentorCount,
            'peserta' => $pesertaCount,
        ];
    }
}
