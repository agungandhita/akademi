<?php

namespace App\Http\Controllers\Tentor;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Services\Enrollment\EnrollmentInterface;
use App\Services\Training\TrainingInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrainingParticipantController extends Controller
{
    public function __construct(
        protected TrainingInterface $trainingService,
        protected EnrollmentInterface $enrollmentService,
    ) {}

    public function index(Request $request, int $trainingId): View
    {
        $training = $this->trainingService->getById($trainingId);

        // TNT-02 & TNT-06: Hanya tentor yang ditugaskan yang dapat melihat peserta
        $isAssigned = $request->user()
            ->assignedTrainings()
            ->where('trainings.id', $trainingId)
            ->exists();

        if (! $isAssigned) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat peserta pada pelatihan ini.');
        }

        $search = $request->query('search');
        $status = $request->query('status');

        $participants = $this->enrollmentService->getParticipantsByTraining(
            trainingId: $trainingId,
            search: $search,
            status: $status,
            perPage: 15
        );

        $counts = $this->enrollmentService->getEnrollmentCounts($trainingId);

        return view('admin.tentor.participants', [
            'training' => $training,
            'participants' => $participants,
            'counts' => $counts,
            'statuses' => EnrollmentStatus::cases(),
            'currentRole' => 'tentor',
            'title' => "Peserta Pelatihan: {$training->title} - Portal Tentor",
        ]);
    }
}
