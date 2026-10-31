<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Services\Enrollment\EnrollmentInterface;
use App\Services\Training\TrainingInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TrainingParticipantController extends Controller
{
    public function __construct(
        protected TrainingInterface $trainingService,
        protected EnrollmentInterface $enrollmentService,
    ) {}

    public function index(Request $request, int $trainingId): View
    {
        $training = $this->trainingService->getById($trainingId);
        $search = $request->query('search');
        $status = $request->query('status');

        $participants = $this->enrollmentService->getParticipantsByTraining(
            trainingId: $trainingId,
            search: $search,
            status: $status,
            perPage: 15
        );

        $counts = $this->enrollmentService->getEnrollmentCounts($trainingId);
        $allParticipants = $this->enrollmentService->getAllParticipantsByTraining($trainingId);
        $nonEnrolledUsers = $this->enrollmentService->getNonEnrolledUsers($trainingId);

        return view('admin.trainings.participants', [
            'training' => $training,
            'participants' => $participants,
            'allParticipants' => $allParticipants,
            'nonEnrolledUsers' => $nonEnrolledUsers,
            'counts' => $counts,
            'statuses' => EnrollmentStatus::cases(),
            'currentRole' => 'admin',
            'title' => "Daftar Peserta: {$training->title} - Akademi Pelatihan",
        ]);
    }

    public function export(int $trainingId): StreamedResponse
    {
        $training = $this->trainingService->getById($trainingId);
        $participants = $this->enrollmentService->getAllParticipantsByTraining($trainingId);
        $fileName = 'peserta_' . $training->slug . '_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($participants) {
            $handle = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'No',
                'Nama Lengkap',
                'Email',
                'No. Telepon / WhatsApp',
                'Tipe Peserta',
                'Institusi / Lembaga',
                'Status Pendaftaran',
                'Tanggal Mendaftar',
            ]);

            foreach ($participants as $index => $enrollment) {
                fputcsv($handle, [
                    $index + 1,
                    $enrollment->user?->name ?? '—',
                    $enrollment->user?->email ?? '—',
                    $enrollment->user?->phone ?? '—',
                    $enrollment->user?->participant_type?->label() ?? '—',
                    $enrollment->user?->institution ?? '—',
                    $enrollment->status?->label() ?? '—',
                    $enrollment->enrolled_at ? $enrollment->enrolled_at->format('d/m/Y H:i') : '—',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Hapus pendaftaran peserta dari program pelatihan (ADM-08).
     */
    public function destroy(int $trainingId, int $enrollmentId): RedirectResponse
    {
        $this->enrollmentService->delete($enrollmentId);

        Alert::success('Berhasil Dihapus', 'Pendaftaran peserta berhasil dihapus dari pelatihan.');

        return redirect()->route('admin.trainings.participants', $trainingId);
    }
}
