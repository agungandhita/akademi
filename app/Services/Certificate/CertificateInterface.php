<?php

namespace App\Services\Certificate;

use App\DTOs\Certificate\UpdateCertificateDTO;
use App\Models\Enrollment;
use App\Models\Training;

interface CertificateInterface
{
    /**
     * Dapatkan pelatihan berdasarkan ID.
     */
    public function getTraining(int $trainingId): Training;

    /**
     * Dapatkan data sertifikat lengkap (pelatihan, peserta, nomor, dll).
     *
     * @return array<string, mixed>
     */
    public function getCertificateData(int $trainingId, ?int $enrollmentId = null, ?int $userId = null): array;

    /**
     * Perbarui pengaturan sertifikat untuk pelatihan tertentu.
     */
    public function updateCertificateSettings(int $trainingId, UpdateCertificateDTO $dto): Training;

    /**
     * Cek apakah user berhak mengakses sertifikat pelatihan ini.
     */
    public function canUserAccessCertificate(int $trainingId, int $userId): bool;

    /**
     * Dapatkan enrollment pendaftaran peserta.
     */
    public function getEnrollment(int $trainingId, int $userId): ?Enrollment;

    /**
     * Dapatkan enrollment berdasarkan ID.
     */
    public function getEnrollmentById(int $enrollmentId): ?Enrollment;
}

