<?php

namespace App\DTOs\Users;

use App\Enums\ParticipantType;

class UpdateUserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone = null,
        public readonly ?string $institution = null,
        public readonly ?string $bio = null,
        public readonly ?string $expertise = null,
        public readonly ?bool $is_active = null,
        public readonly ?ParticipantType $participant_type = null,
        public readonly ?string $avatar = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'] ?? null,
            institution: $data['institution'] ?? null,
            bio: $data['bio'] ?? null,
            expertise: $data['expertise'] ?? null,
            is_active: isset($data['is_active']) ? (bool) $data['is_active'] : null,
            participant_type: isset($data['participant_type']) 
                ? ($data['participant_type'] instanceof ParticipantType 
                    ? $data['participant_type'] 
                    : ParticipantType::tryFrom($data['participant_type']))
                : null,
            avatar: $data['avatar'] ?? null,
        );
    }
}
