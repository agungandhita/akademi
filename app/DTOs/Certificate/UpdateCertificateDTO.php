<?php

namespace App\DTOs\Certificate;

class UpdateCertificateDTO
{
    public function __construct(
        public readonly ?string $certificate_number = null,
        public readonly ?string $certificate_date = null,
        public readonly ?string $certificate_signer_left_title = 'Ketua Pelaksana',
        public readonly ?string $certificate_signer_left_name = null,
        public readonly ?string $certificate_signer_left_nip = null,
        public readonly ?string $certificate_signer_left_signature = null,
        public readonly ?string $certificate_signer_right_title = 'Pimpinan Akademi Pelatihan',
        public readonly ?string $certificate_signer_right_name = null,
        public readonly ?string $certificate_signer_right_nip = null,
        public readonly ?string $certificate_signer_right_signature = null,
        public readonly bool $is_certificate_enabled = false,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            certificate_number: ! empty($data['certificate_number']) ? trim($data['certificate_number']) : null,
            certificate_date: ! empty($data['certificate_date']) ? trim($data['certificate_date']) : null,
            certificate_signer_left_title: ! empty($data['certificate_signer_left_title']) ? trim($data['certificate_signer_left_title']) : 'Ketua Pelaksana',
            certificate_signer_left_name: ! empty($data['certificate_signer_left_name']) ? trim($data['certificate_signer_left_name']) : null,
            certificate_signer_left_nip: ! empty($data['certificate_signer_left_nip']) ? trim($data['certificate_signer_left_nip']) : null,
            certificate_signer_left_signature: $data['certificate_signer_left_signature'] ?? null,
            certificate_signer_right_title: ! empty($data['certificate_signer_right_title']) ? trim($data['certificate_signer_right_title']) : 'Pimpinan Akademi Pelatihan',
            certificate_signer_right_name: ! empty($data['certificate_signer_right_name']) ? trim($data['certificate_signer_right_name']) : null,
            certificate_signer_right_nip: ! empty($data['certificate_signer_right_nip']) ? trim($data['certificate_signer_right_nip']) : null,
            certificate_signer_right_signature: $data['certificate_signer_right_signature'] ?? null,
            is_certificate_enabled: isset($data['is_certificate_enabled'])
                ? filter_var($data['is_certificate_enabled'], FILTER_VALIDATE_BOOLEAN)
                : false,
        );
    }
}

