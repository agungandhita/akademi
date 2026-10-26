<?php

namespace App\DTOs\Users;

use App\Enums\ParticipantType;

class RegisterPesertaDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly ParticipantType $participantType,
        public readonly ?string $institution = null,
        public readonly ?string $phone = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $participantType = $data['participant_type'] instanceof ParticipantType
            ? $data['participant_type']
            : self::resolveParticipantType($data['participant_type'] ?? 'umum');

        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            participantType: $participantType,
            institution: $data['institution'] ?? null,
            phone: $data['phone'] ?? null,
        );
    }

    public static function resolveParticipantType(string $raw): ParticipantType
    {
        return match (strtolower(trim($raw))) {
            'guru', 'guru & tenaga pendidik' => ParticipantType::Guru,
            'siswa', 'mahasiswa / pelajar', 'pelajar', 'mahasiswa' => ParticipantType::Siswa,
            'praktisi', 'profesional', 'profesional & praktisi', 'profesional / praktisi' => ParticipantType::Praktisi,
            default => ParticipantType::Umum,
        };
    }
}
