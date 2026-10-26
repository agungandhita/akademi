<?php

namespace App\DTOs\Modules;

use App\Enums\ModuleStatus;
use App\Enums\ModuleType;

class CreateModuleDTO
{
    public function __construct(
        public readonly int $trainingId,
        public readonly int $createdBy,
        public readonly string $title,
        public readonly ?string $description,
        public readonly ModuleType $type,
        public readonly ?string $content = null,
        public readonly ?string $filePath = null,
        public readonly ?string $url = null,
        public readonly int $sortOrder = 0,
        public readonly ModuleStatus $status = ModuleStatus::Draft,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data, int $createdBy): self
    {
        return new self(
            trainingId: (int) $data['training_id'],
            createdBy: $createdBy,
            title: $data['title'],
            description: $data['description'] ?? null,
            type: $data['type'] instanceof ModuleType ? $data['type'] : ModuleType::from($data['type']),
            content: $data['content'] ?? null,
            filePath: $data['file_path'] ?? null,
            url: $data['url'] ?? null,
            sortOrder: (int) ($data['sort_order'] ?? 0),
            status: isset($data['status'])
                ? ($data['status'] instanceof ModuleStatus ? $data['status'] : ModuleStatus::from($data['status']))
                : ModuleStatus::Draft,
        );
    }
}
