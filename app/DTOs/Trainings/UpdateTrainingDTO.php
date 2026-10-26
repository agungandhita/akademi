<?php

namespace App\DTOs\Trainings;

use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;

class UpdateTrainingDTO
{
    public function __construct(
        public readonly int $category_id,
        public readonly string $title,
        public readonly string $description,
        public readonly TrainingAudience $audience,
        public readonly TrainingMode $mode,
        public readonly TrainingStatus $status,
        public readonly string $start_date,
        public readonly string $end_date,
        public readonly bool $is_free = true,
        public readonly float $price = 0.00,
        public readonly ?int $quota = null,
        public readonly ?string $registration_start = null,
        public readonly ?string $registration_end = null,
        public readonly ?string $location = null,
        public readonly ?string $meeting_url = null,
        public readonly ?string $thumbnail = null,
        public readonly ?array $facilities = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $isFree = isset($data['is_free']) ? filter_var($data['is_free'], FILTER_VALIDATE_BOOLEAN) : true;
        $price = ! empty($data['price']) ? (float) $data['price'] : 0.00;
        $facilities = isset($data['facilities']) && is_array($data['facilities'])
            ? array_values(array_filter(array_map('trim', $data['facilities'])))
            : null;

        return new self(
            category_id: (int) $data['category_id'],
            title: $data['title'],
            description: $data['description'],
            audience: $data['audience'] instanceof TrainingAudience ? $data['audience'] : TrainingAudience::from($data['audience']),
            mode: $data['mode'] instanceof TrainingMode ? $data['mode'] : TrainingMode::from($data['mode']),
            status: $data['status'] instanceof TrainingStatus ? $data['status'] : TrainingStatus::from($data['status']),
            start_date: $data['start_date'],
            end_date: $data['end_date'],
            is_free: $isFree,
            price: $isFree ? 0.00 : $price,
            quota: ! empty($data['quota']) ? (int) $data['quota'] : null,
            registration_start: $data['registration_start'] ?? null,
            registration_end: $data['registration_end'] ?? null,
            location: $data['location'] ?? null,
            meeting_url: $data['meeting_url'] ?? null,
            thumbnail: $data['thumbnail'] ?? null,
            facilities: $facilities,
        );
    }
}
