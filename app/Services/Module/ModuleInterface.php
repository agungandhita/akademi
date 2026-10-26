<?php

namespace App\Services\Module;

use App\DTOs\Modules\CreateModuleDTO;
use App\DTOs\Modules\UpdateModuleDTO;
use App\Models\Module;
use Illuminate\Database\Eloquent\Collection;

interface ModuleInterface
{
    /**
     * @return Collection<int, Module>
     */
    public function getByTraining(int $trainingId, bool $publishedOnly = false): Collection;

    public function getById(int $id): Module;

    public function create(CreateModuleDTO $dto): Module;

    public function update(int $id, UpdateModuleDTO $dto): Module;

    public function delete(int $id): bool;

    public function countByTentor(int $tentorId): int;
}
