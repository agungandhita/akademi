<?php

namespace App\Services\Module;

use App\DTOs\Modules\CreateModuleDTO;
use App\DTOs\Modules\UpdateModuleDTO;
use App\Enums\TrainingStatus;
use App\Models\Module;
use App\Models\Training;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class ModuleService implements ModuleInterface
{
    public function getByTraining(int $trainingId, bool $publishedOnly = false): Collection
    {
        return Module::query()
            ->where('training_id', $trainingId)
            ->when($publishedOnly, fn ($q) => $q->published())
            ->ordered()
            ->get();
    }

    public function getById(int $id): Module
    {
        return Module::with(['training', 'creator'])->findOrFail($id);
    }

    public function create(CreateModuleDTO $dto): Module
    {
        $training = Training::findOrFail($dto->trainingId);

        // TNT-03: Pelatihan harus berstatus published
        if ($training->status !== TrainingStatus::Published) {
            throw new InvalidArgumentException('Modul pembelajaran hanya dapat ditambahkan pada pelatihan yang berstatus published (terbit).');
        }

        return Module::create([
            'training_id' => $dto->trainingId,
            'created_by' => $dto->createdBy,
            'title' => $dto->title,
            'description' => $dto->description,
            'type' => $dto->type,
            'content' => $dto->content,
            'file_path' => $dto->filePath,
            'url' => $dto->url,
            'sort_order' => $dto->sortOrder,
            'status' => $dto->status,
        ]);
    }

    public function update(int $id, UpdateModuleDTO $dto): Module
    {
        $module = $this->getById($id);

        if ($module->training->status !== TrainingStatus::Published) {
            throw new InvalidArgumentException('Modul pembelajaran hanya dapat diperbarui pada pelatihan yang berstatus published (terbit).');
        }

        $payload = [
            'title' => $dto->title,
            'description' => $dto->description,
            'type' => $dto->type,
            'content' => $dto->content,
            'url' => $dto->url,
            'sort_order' => $dto->sortOrder,
            'status' => $dto->status,
        ];

        if ($dto->filePath !== null) {
            // Hapus berkas lama jika ada berkas baru diunggah
            if ($module->file_path && Storage::disk('public')->exists($module->file_path)) {
                Storage::disk('public')->delete($module->file_path);
            }
            $payload['file_path'] = $dto->filePath;
        }

        $module->update($payload);

        return $module;
    }

    public function delete(int $id): bool
    {
        $module = $this->getById($id);

        if ($module->training->status !== TrainingStatus::Published) {
            throw new InvalidArgumentException('Modul pembelajaran hanya dapat dihapus pada pelatihan yang berstatus published (terbit).');
        }

        return (bool) $module->delete();
    }

    public function countByTentor(int $tentorId): int
    {
        return Module::whereHas('training', function ($q) use ($tentorId) {
            $q->whereHas('instructors', function ($iq) use ($tentorId) {
                $iq->where('users.id', $tentorId);
            });
        })->count();
    }
}
