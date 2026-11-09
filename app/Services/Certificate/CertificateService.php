<?php

namespace App\Services\Certificate;

use App\DTOs\Certificate\UpdateCertificateDTO;
use App\Enums\EnrollmentStatus;
use App\Models\Enrollment;
use App\Models\Training;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CertificateService implements CertificateInterface
{
    public function getTraining(int $trainingId): Training
    {
        return Training::with(['category', 'instructors'])->findOrFail($trainingId);
    }

    public function getEnrollment(int $trainingId, int $userId): ?Enrollment
    {
        return Enrollment::with(['user', 'training'])
            ->where('training_id', $trainingId)
            ->where('user_id', $userId)
            ->where('status', '!=', EnrollmentStatus::Cancelled->value)
            ->first();
    }

    public function getEnrollmentById(int $enrollmentId): ?Enrollment
    {
        return Enrollment::with(['user', 'training'])->findOrFail($enrollmentId);
    }

    public function canUserAccessCertificate(int $trainingId, int $userId): bool
    {
        $training = $this->getTraining($trainingId);

        if (! $training->is_certificate_enabled) {
            return false;
        }

        return Enrollment::where('training_id', $trainingId)
            ->where('user_id', $userId)
            ->where('status', '!=', EnrollmentStatus::Cancelled->value)
            ->exists();
    }

    public function updateCertificateSettings(int $trainingId, UpdateCertificateDTO $dto): Training
    {
        $training = $this->getTraining($trainingId);

        $dataToUpdate = [
            'certificate_number' => $dto->certificate_number,
            'certificate_date' => $dto->certificate_date,
            'certificate_signer_left_title' => $dto->certificate_signer_left_title ?? 'Ketua Pelaksana',
            'certificate_signer_left_name' => $dto->certificate_signer_left_name,
            'certificate_signer_left_nip' => $dto->certificate_signer_left_nip,
            'certificate_signer_right_title' => $dto->certificate_signer_right_title ?? 'Pimpinan Akademi Pelatihan',
            'certificate_signer_right_name' => $dto->certificate_signer_right_name,
            'certificate_signer_right_nip' => $dto->certificate_signer_right_nip,
            'is_certificate_enabled' => $dto->is_certificate_enabled,
        ];

        // Handle Left Signature File
        if ($dto->certificate_signer_left_signature !== null) {
            if ($training->certificate_signer_left_signature && Storage::disk('public')->exists($training->certificate_signer_left_signature)) {
                Storage::disk('public')->delete($training->certificate_signer_left_signature);
            }
            $dataToUpdate['certificate_signer_left_signature'] = $dto->certificate_signer_left_signature;
        }

        // Handle Right Signature File
        if ($dto->certificate_signer_right_signature !== null) {
            if ($training->certificate_signer_right_signature && Storage::disk('public')->exists($training->certificate_signer_right_signature)) {
                Storage::disk('public')->delete($training->certificate_signer_right_signature);
            }
            $dataToUpdate['certificate_signer_right_signature'] = $dto->certificate_signer_right_signature;
        }

        $training->update($dataToUpdate);

        return $training->fresh();
    }

    public function getCertificateData(int $trainingId, ?int $enrollmentId = null, ?int $userId = null): array
    {
        $training = $this->getTraining($trainingId);
        $enrollment = null;
        $participantName = 'Nama Peserta';

        if ($enrollmentId) {
            $enrollment = $this->getEnrollmentById($enrollmentId);
            $participantName = $enrollment->user?->name ?? 'Nama Peserta';
        } elseif ($userId) {
            $enrollment = $this->getEnrollment($trainingId, $userId);
            if ($enrollment) {
                $participantName = $enrollment->user?->name ?? 'Nama Peserta';
            } else {
                $user = User::find($userId);
                $participantName = $user?->name ?? 'Nama Peserta';
            }
        }

        // Format Nomor Kegiatan (default if empty: 014/AP/X/2026 or derived from training)
        $certificateNumber = $training->certificate_number;
        if (empty($certificateNumber)) {
            $monthRoman = $this->getRomanMonth(now()->month);
            $year = now()->year;
            $certificateNumber = sprintf('%03d/AP/%s/%d', $training->id, $monthRoman, $year);
        }

        // Format Tanggal Kegiatan
        $certificateDate = $training->certificate_date;
        if (empty($certificateDate)) {
            if ($training->start_date && $training->end_date && $training->start_date != $training->end_date) {
                $start = Carbon::parse($training->start_date)->isoFormat('D MMMM');
                $end = Carbon::parse($training->end_date)->isoFormat('D MMMM Y');
                $certificateDate = "{$start} - {$end}";
            } elseif ($training->start_date) {
                $certificateDate = Carbon::parse($training->start_date)->isoFormat('D MMMM Y');
            } else {
                $certificateDate = Carbon::now()->isoFormat('D MMMM Y');
            }
        }

        return [
            'training' => $training,
            'enrollment' => $enrollment,
            'participantName' => $participantName,
            'certificateNumber' => $certificateNumber,
            'certificateDate' => $certificateDate,
            'signerLeftTitle' => $training->certificate_signer_left_title ?: 'Ketua Pelaksana',
            'signerLeftName' => $training->certificate_signer_left_name ?: 'Nama Ketua Pelaksana',
            'signerLeftNip' => $training->certificate_signer_left_nip ?: 'NIP. ............................',
            'signerLeftSignatureUrl' => $training->certificate_signer_left_signature_url,
            'signerRightTitle' => $training->certificate_signer_right_title ?: 'Pimpinan Akademi Pelatihan',
            'signerRightName' => $training->certificate_signer_right_name ?: 'Nama Pimpinan',
            'signerRightNip' => $training->certificate_signer_right_nip ?: 'NIP. ............................',
            'signerRightSignatureUrl' => $training->certificate_signer_right_signature_url,
        ];
    }

    private function getRomanMonth(int $month): string
    {
        $romans = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
        ];

        return $romans[$month] ?? 'I';
    }
}

