<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Enrollment\EnrollmentInterface;
use App\Services\Training\TrainingInterface;
use App\Services\TrainingCategory\TrainingCategoryInterface;
use App\Services\User\UserInterface;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected UserInterface $userService,
        protected TrainingInterface $trainingService,
        protected TrainingCategoryInterface $categoryService,
        protected EnrollmentInterface $enrollmentService,
    ) {}

    public function index(): View
    {
        $userCounts = $this->userService->getUserRoleCounts();
        $recentUsers = $this->userService->getRecentUsers(5);
        $trainingCounts = $this->trainingService->getTrainingStatusCounts();
        $trainingModeCounts = $this->trainingService->getTrainingModeCounts();
        $recentTrainings = $this->trainingService->getRecentTrainings(5);
        $totalCategories = $this->categoryService->getAll()->count();
        $totalPendaftaran = $this->enrollmentService->getTotalActiveEnrollmentCount();

        return view('admin.dashboard.index', [
            'currentRole' => 'admin',
            'title' => 'Dashboard Administrator - Akademi Pelatihan',
            'totalUsers' => $userCounts['total'],
            'totalPeserta' => $userCounts['peserta'],
            'userCounts' => $userCounts,
            'recentUsers' => $recentUsers,
            'totalProgram' => $trainingCounts['total'],
            'trainingCounts' => $trainingCounts,
            'trainingModeCounts' => $trainingModeCounts,
            'totalCategories' => $totalCategories,
            'recentTrainings' => $recentTrainings,
            'totalPendaftaran' => $totalPendaftaran,
            'totalPesan' => 0,       // Dihitung di M6
        ]);
    }
}
