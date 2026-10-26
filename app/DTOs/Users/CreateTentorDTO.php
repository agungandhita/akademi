<?php

namespace App\DTOs\Users;

class CreateTentorDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $bio = null,
        public readonly ?string $expertise = null,
        public readonly ?string $phone = null,
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
            password: $data['password'],
            bio: $data['bio'] ?? null,
            expertise: $data['expertise'] ?? null,
            phone: $data['phone'] ?? null,
            avatar: $data['avatar'] ?? null,
        );
    }
}
