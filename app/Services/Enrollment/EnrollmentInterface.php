<?php

namespace App\Services\Enrollment;

use App\Models\Enrollment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EnrollmentInterface
{
    /**
     * Mengambil daftar peserta terdaftar pada suatu pelatihan dengan paginasi dan filter.
     *
     * @return LengthAwarePaginator<Enrollment>
     */
    public function getParticipantsByTraining(
        int $trainingId,
        ?string $search = null,
        ?string $status = null,
        int $perPage = 15
    ): LengthAwarePaginator;

    /**
     * Mengambil seluruh data peserta pada suatu pelatihan (untuk ekspor CSV).
     *
     * @return Collection<int, Enrollment>
     */
    public function getAllParticipantsByTraining(int $trainingId): Collection;

    /**
     * Mendaftarkan pengguna (peserta) ke suatu pelatihan.
     */
    public function enroll(int $userId, int $trainingId): Enrollment;

    /**
     * Membatalkan pendaftaran pelatihan.
     */
    public function cancel(int $userId, int $trainingId): Enrollment;

    /**
     * Mengambil statistik status pendaftaran untuk suatu pelatihan.
     *
     * @return array{total: int, registered: int, cancelled: int, completed: int}
     */
    public function getEnrollmentCounts(int $trainingId): array;

    /**
     * Mengambil total seluruh pendaftaran aktif di sistem.
     */
    public function getTotalActiveEnrollmentCount(): int;

    /**
     * Memeriksa apakah pengguna telah terdaftar aktif pada pelatihan.
     */
    public function isUserEnrolled(int $userId, int $trainingId): bool;

    /**
     * Mengambil seluruh pelatihan yang diikuti oleh peserta tertentu.
     *
     * @return Collection<int, Enrollment>
     */
    public function getParticipantTrainings(int $userId): Collection;

    /**
     * Mengambil ringkasan statistik pembelajaran peserta.
     *
     * @return array{enrolledCount: int, completedCount: int, upcomingSessionsCount: int}
     */
    public function getParticipantStats(int $userId): array;
}
