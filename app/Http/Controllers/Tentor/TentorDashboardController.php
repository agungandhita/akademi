<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tentor\Profile\UpdateTentorProfileRequest;
use App\Services\Module\ModuleInterface;
use App\Services\Training\TrainingInterface;
use App\Services\User\UserInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class TentorDashboardController extends Controller
{
    public function __construct(
        protected readonly TrainingInterface $trainingService,
        protected readonly ModuleInterface $moduleService,
        protected readonly UserInterface $userService,
    ) {}

    /**
     * Tampilkan halaman dashboard utama instruktur/tentor.
     */
    public function index(): View
    {
        $tentor = auth()->user();
        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();
        $totalStudents = $assignedTrainings->sum('active_enrollments_count');
        $totalModules = $tentor ? $this->moduleService->countByTentor($tentor->id) : 0;

        return view('admin.tentor.index', [
            'currentRole' => 'tentor',
            'title' => 'Dashboard Tentor & Instruktur - Akademi Pelatihan',
            'assignedTrainings' => $assignedTrainings,
            'assignedCount' => $assignedTrainings->count(),
            'totalStudents' => $totalStudents,
            'totalModules' => $totalModules,
        ]);
    }

    /**
     * Tampilkan seluruh pelatihan yang ditugaskan kepada tentor (TNT-02).
     */
    public function trainings(): View
    {
        $tentor = auth()->user();
        $assignedTrainings = $tentor ? $this->trainingService->getByInstructor($tentor->id) : collect();

        return view('admin.tentor.trainings', [
            'currentRole' => 'tentor',
            'title' => 'Pelatihan Ditugaskan - Portal Instruktur',
            'assignedTrainings' => $assignedTrainings,
        ]);
    }

    /**
     * Tampilkan formulir edit profil & keahlian tentor (TNT-07).
     */
    public function profile(): View
    {
        $tentor = auth()->user();

        return view('admin.tentor.profile', [
            'currentRole' => 'tentor',
            'title' => 'Profil & Keahlian Instruktur - Akademi Pelatihan',
            'user' => $tentor,
        ]);
    }

    /**
     * Simpan pembaruan profil & keahlian tentor.
     */
    public function updateProfile(UpdateTentorProfileRequest $request): RedirectResponse
    {
        $tentor = auth()->user();

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $dto = $request->toDTO($avatarPath);
        $this->userService->update($tentor->id, $dto);

        Alert::success('Profil Diperbarui', 'Informasi profil dan bidang keahlian Anda berhasil disimpan.');

        return redirect()->route('tentor.profile');
    }
}
