<?php

namespace App\Http\Controllers\Peserta;

use App\Enums\ModuleStatus;
use App\Http\Controllers\Controller;
use App\Services\Enrollment\EnrollmentInterface;
use App\Services\Module\ModuleInterface;
use App\Services\Training\TrainingInterface;
use Illuminate\View\View;

class PesertaDashboardController extends Controller
{
    public function __construct(
        protected readonly EnrollmentInterface $enrollmentService,
        protected readonly TrainingInterface $trainingService,
        protected readonly ModuleInterface $moduleService,
    ) {}

    public function index(): View
    {
        $userId = (int) auth()->id();
        $stats = $this->enrollmentService->getParticipantStats($userId);
        $enrolledTrainings = $this->enrollmentService->getParticipantTrainings($userId);

        return view('admin.peserta.index', [
            'currentRole' => 'peserta',
            'title' => 'Portal Pembelajaran Peserta - Akademi Pelatihan',
            'enrolledCount' => $stats['enrolledCount'],
            'completedModules' => $stats['completedCount'],
            'totalModules' => $stats['enrolledCount'],
            'upcomingSessionsCount' => $stats['upcomingSessionsCount'],
            'enrolledTrainings' => $enrolledTrainings,
        ]);
    }

    public function trainings(): View
    {
        $userId = (int) auth()->id();
        $enrolledTrainings = $this->enrollmentService->getParticipantTrainings($userId);

        return view('admin.peserta.trainings', [
            'currentRole' => 'peserta',
            'title' => 'Pelatihan Saya - Akademi Pelatihan',
            'enrolledTrainings' => $enrolledTrainings,
        ]);
    }

    /**
     * Tampilkan ruang belajar pelatihan beserta kurikulum modul (PST-05, PST-07).
     */
    public function showTraining(int $trainingId): View
    {
        $userId = (int) auth()->id();

        // PST-05: Akses hanya diperbolehkan untuk peserta yang terdaftar
        if (! $this->enrollmentService->isUserEnrolled($userId, $trainingId)) {
            abort(403, 'Anda belum terdaftar pada program pelatihan ini.');
        }

        $training = $this->trainingService->getById($trainingId);
        $modules = $this->moduleService->getByTraining($trainingId, publishedOnly: true);

        return view('admin.peserta.training-detail', [
            'currentRole' => 'peserta',
            'title' => "Ruang Belajar: {$training->title} - Akademi Pelatihan",
            'training' => $training,
            'modules' => $modules,
        ]);
    }

    /**
     * Membaca / mengakses modul pembelajaran (PST-05).
     */
    public function showModule(int $trainingId, int $moduleId): View
    {
        $userId = (int) auth()->id();

        // PST-05: Proteksi otorisasi modul hanya untuk peserta terdaftar
        if (! $this->enrollmentService->isUserEnrolled($userId, $trainingId)) {
            abort(403, 'Anda belum terdaftar pada program pelatihan ini.');
        }

        $training = $this->trainingService->getById($trainingId);
        $module = $this->moduleService->getById($moduleId);

        // Validasi modul sesuai pelatihan dan berstatus published
        if ($module->training_id !== $training->id || $module->status !== ModuleStatus::Published) {
            abort(404, 'Modul pembelajaran tidak ditemukan atau belum dipublikasikan.');
        }

        $modules = $this->moduleService->getByTraining($trainingId, publishedOnly: true);

        $currentIndex = $modules->search(fn ($m) => $m->id === $module->id);
        $prevModule = $currentIndex > 0 ? $modules->get($currentIndex - 1) : null;
        $nextModule = ($currentIndex !== false && $currentIndex < $modules->count() - 1)
            ? $modules->get($currentIndex + 1)
            : null;

        return view('admin.peserta.module-detail', [
            'currentRole' => 'peserta',
            'title' => "{$module->title} - Modul {$training->title}",
            'training' => $training,
            'module' => $module,
            'modules' => $modules,
            'prevModule' => $prevModule,
            'nextModule' => $nextModule,
        ]);
    }
}
