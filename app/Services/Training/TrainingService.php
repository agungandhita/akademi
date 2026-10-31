<?php

namespace App\Services\Training;

use App\DTOs\Trainings\CreateTrainingDTO;
use App\DTOs\Trainings\UpdateTrainingDTO;
use App\Enums\EnrollmentStatus;
use App\Enums\SessionType;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Models\Training;
use App\Models\TrainingSession;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TrainingService implements TrainingInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Training::filter($filters)
            ->with(['category', 'creator'])
            ->withCount([
                'instructors',
                'sessions',
                'enrollments as active_enrollments_count' => function ($query) {
                    $query->where('status', '!=', EnrollmentStatus::Cancelled->value);
                },
            ])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getById(int $id): Training
    {
        return Training::with(['category', 'creator', 'instructors', 'sessions', 'modules' => fn ($query) => $query->ordered()])
            ->withCount(['enrollments as active_enrollments_count' => function ($query) {
                $query->where('status', '!=', EnrollmentStatus::Cancelled->value);
            }])
            ->findOrFail($id);
    }

    public function getBySlug(string $slug): Training
    {
        return Training::with(['category', 'creator', 'instructors', 'sessions', 'modules' => fn ($query) => $query->published()->ordered()])
            ->withCount(['enrollments as active_enrollments_count' => function ($query) {
                $query->where('status', '!=', EnrollmentStatus::Cancelled->value);
            }])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function create(CreateTrainingDTO $dto): Training
    {
        return Training::create([
            'category_id' => $dto->category_id,
            'title' => $dto->title,
            'slug' => Str::slug($dto->title),
            'description' => $dto->description,
            'facilities' => $dto->facilities,
            'thumbnail' => $dto->thumbnail,
            'audience' => $dto->audience,
            'mode' => $dto->mode,
            'status' => $dto->status,
            'is_free' => $dto->is_free,
            'price' => $dto->price,
            'quota' => $dto->quota,
            'registration_start' => $dto->registration_start,
            'registration_end' => $dto->registration_end,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
            'location' => $dto->location,
            'meeting_url' => $dto->meeting_url,
            'whatsapp_group_link' => $dto->whatsapp_group_link,
            'created_by' => $dto->created_by,
        ]);
    }

    public function update(int $id, UpdateTrainingDTO $dto): Training
    {
        $training = $this->getById($id);

        $training->update([
            'category_id' => $dto->category_id,
            'title' => $dto->title,
            'slug' => Str::slug($dto->title),
            'description' => $dto->description,
            'facilities' => $dto->facilities ?? $training->facilities,
            'thumbnail' => $dto->thumbnail ?? $training->thumbnail,
            'audience' => $dto->audience,
            'mode' => $dto->mode,
            'status' => $dto->status,
            'is_free' => $dto->is_free,
            'price' => $dto->price,
            'quota' => $dto->quota,
            'registration_start' => $dto->registration_start,
            'registration_end' => $dto->registration_end,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
            'location' => $dto->location,
            'meeting_url' => $dto->meeting_url,
            'whatsapp_group_link' => $dto->whatsapp_group_link,
        ]);

        return $training;
    }

    public function delete(int $id): bool
    {
        $training = $this->getById($id);

        return (bool) $training->delete();
    }

    public function syncInstructors(int $trainingId, array $instructorIds): Training
    {
        $training = $this->getById($trainingId);
        $training->instructors()->sync($instructorIds);

        return $training->load('instructors');
    }

    public function addSession(int $trainingId, array $sessionData): TrainingSession
    {
        $training = $this->getById($trainingId);

        return $training->sessions()->create([
            'title' => $sessionData['title'],
            'session_type' => $sessionData['session_type'] instanceof SessionType 
                ? $sessionData['session_type'] 
                : SessionType::from($sessionData['session_type']),
            'session_date' => $sessionData['session_date'],
            'start_time' => $sessionData['start_time'],
            'end_time' => $sessionData['end_time'],
            'location' => $sessionData['location'] ?? null,
            'meeting_url' => $sessionData['meeting_url'] ?? null,
            'notes' => $sessionData['notes'] ?? null,
        ]);
    }

    public function deleteSession(int $sessionId): bool
    {
        $session = TrainingSession::findOrFail($sessionId);

        return (bool) $session->delete();
    }

    public function getTrainingStatusCounts(): array
    {
        $total = Training::count();
        $published = Training::where('status', TrainingStatus::Published->value)->count();
        $draft = Training::where('status', TrainingStatus::Draft->value)->count();
        $closed = Training::where('status', TrainingStatus::Closed->value)->count();
        $archived = Training::where('status', TrainingStatus::Archived->value)->count();

        return [
            'total' => $total,
            'published' => $published,
            'draft' => $draft,
            'closed' => $closed,
            'archived' => $archived,
        ];
    }

    public function getTrainingModeCounts(): array
    {
        return [
            'online' => Training::where('mode', TrainingMode::Online->value)->count(),
            'offline' => Training::where('mode', TrainingMode::Offline->value)->count(),
            'blended' => Training::where('mode', TrainingMode::Blended->value)->count(),
        ];
    }

    public function getRecentTrainings(int $limit = 5): Collection
    {
        return Training::with(['category', 'instructors'])
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getByInstructor(int $instructorId): Collection
    {
        return Training::whereHas('instructors', function ($query) use ($instructorId) {
            $query->where('users.id', $instructorId);
        })
        ->with(['category', 'sessions', 'modules'])
        ->withCount([
            'enrollments as active_enrollments_count' => function ($query) {
                $query->where('status', '!=', EnrollmentStatus::Cancelled->value);
            },
            'modules',
        ])
        ->latest()
        ->get();
    }
}
