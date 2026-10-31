<?php

namespace App\Services\Enrollment;

use App\Enums\EnrollmentStatus;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Enrollment;
use App\Models\Training;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class EnrollmentService implements EnrollmentInterface
{
    public function getParticipantsByTraining(
        int $trainingId,
        ?string $search = null,
        ?string $status = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        return Enrollment::with(['user', 'training'])
            ->where('training_id', $trainingId)
            ->filter($search, $status)
            ->latest('enrolled_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getAllParticipantsByTraining(int $trainingId): Collection
    {
        return Enrollment::with(['user', 'training'])
            ->where('training_id', $trainingId)
            ->latest('enrolled_at')
            ->get();
    }

    public function getNonEnrolledUsers(int $trainingId): Collection
    {
        return User::where('role', UserRole::Peserta->value)
            ->where('is_active', true)
            ->whereNotNull('phone')
            ->where('phone', '!=', '')
            ->whereDoesntHave('enrollments', function ($query) use ($trainingId) {
                $query->where('training_id', $trainingId)
                    ->where('status', '!=', EnrollmentStatus::Cancelled->value);
            })
            ->orderBy('name')
            ->get();
    }

    public function enroll(int $userId, int $trainingId): Enrollment
    {
        $training = Training::findOrFail($trainingId);

        if ($training->status !== TrainingStatus::Published) {
            throw ValidationException::withMessages([
                'training' => 'Pelatihan belum dipublikasikan atau pendaftaran belum dibuka.',
            ]);
        }

        if ($training->registration_start && $training->registration_start->startOfDay()->isFuture()) {
            throw ValidationException::withMessages([
                'registration' => 'Pendaftaran untuk pelatihan ini belum dibuka (dibuka pada '.$training->registration_start->format('d M Y').').',
            ]);
        }

        if ($training->registration_end && $training->registration_end->endOfDay()->isPast()) {
            throw ValidationException::withMessages([
                'registration' => 'Masa pendaftaran untuk pelatihan ini telah berakhir.',
            ]);
        }

        $existing = Enrollment::where('user_id', $userId)
            ->where('training_id', $trainingId)
            ->first();

        if ($existing && $existing->status !== EnrollmentStatus::Cancelled) {
            throw ValidationException::withMessages([
                'user' => 'Anda sudah terdaftar aktif pada pelatihan ini.',
            ]);
        }

        if ($training->quota !== null) {
            $activeCount = Enrollment::where('training_id', $trainingId)
                ->where('status', '!=', EnrollmentStatus::Cancelled->value)
                ->count();

            if ($activeCount >= $training->quota) {
                throw ValidationException::withMessages([
                    'quota' => 'Mohon maaf, kuota pendaftaran untuk pelatihan ini sudah penuh.',
                ]);
            }
        }

        if ($existing) {
            $existing->update([
                'status' => EnrollmentStatus::Registered,
                'enrolled_at' => now(),
                'cancelled_at' => null,
            ]);

            return $existing;
        }

        return Enrollment::create([
            'user_id' => $userId,
            'training_id' => $trainingId,
            'status' => EnrollmentStatus::Registered,
            'enrolled_at' => now(),
        ]);
    }

    public function cancel(int $userId, int $trainingId): Enrollment
    {
        $enrollment = Enrollment::where('user_id', $userId)
            ->where('training_id', $trainingId)
            ->firstOrFail();

        $enrollment->update([
            'status' => EnrollmentStatus::Cancelled,
            'cancelled_at' => now(),
        ]);

        return $enrollment;
    }

    public function getEnrollmentCounts(int $trainingId): array
    {
        $total = Enrollment::where('training_id', $trainingId)->count();
        $registered = Enrollment::where('training_id', $trainingId)
            ->where('status', EnrollmentStatus::Registered->value)
            ->count();
        $cancelled = Enrollment::where('training_id', $trainingId)
            ->where('status', EnrollmentStatus::Cancelled->value)
            ->count();
        $completed = Enrollment::where('training_id', $trainingId)
            ->where('status', EnrollmentStatus::Completed->value)
            ->count();

        return [
            'total' => $total,
            'registered' => $registered,
            'cancelled' => $cancelled,
            'completed' => $completed,
        ];
    }

    public function getTotalActiveEnrollmentCount(): int
    {
        return Enrollment::where('status', EnrollmentStatus::Registered->value)->count();
    }

    public function isUserEnrolled(int $userId, int $trainingId): bool
    {
        return Enrollment::where('user_id', $userId)
            ->where('training_id', $trainingId)
            ->where('status', '!=', EnrollmentStatus::Cancelled->value)
            ->exists();
    }

    public function getParticipantTrainings(int $userId): Collection
    {
        return Enrollment::with(['training.category', 'training.sessions', 'training.instructors'])
            ->where('user_id', $userId)
            ->where('status', '!=', EnrollmentStatus::Cancelled->value)
            ->latest('enrolled_at')
            ->get();
    }

    public function getParticipantStats(int $userId): array
    {
        $enrollments = Enrollment::with('training.sessions')
            ->where('user_id', $userId)
            ->where('status', '!=', EnrollmentStatus::Cancelled->value)
            ->get();

        $enrolledCount = $enrollments->count();
        $completedCount = $enrollments->where('status', EnrollmentStatus::Completed)->count();

        $today = now()->toDateString();
        $upcomingSessionsCount = 0;
        foreach ($enrollments as $enrollment) {
            if ($enrollment->training) {
                $upcomingSessionsCount += $enrollment->training->sessions
                    ->filter(fn ($s) => $s->session_date && $s->session_date->toDateString() >= $today)
                    ->count();
            }
        }

        return [
            'enrolledCount' => $enrolledCount,
            'completedCount' => $completedCount,
            'upcomingSessionsCount' => $upcomingSessionsCount,
        ];
    }

    public function delete(int $enrollmentId): bool
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);

        return (bool) $enrollment->delete();
    }
}
