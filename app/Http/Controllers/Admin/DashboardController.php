<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Training\TrainingInterface;
use App\Services\User\UserInterface;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        protected UserInterface $userService,
        protected TrainingInterface $trainingService,
    ) {}

    public function index(): View
    {
        $userCounts = $this->userService->getUserRoleCounts();
        $trainingCounts = $this->trainingService->getTrainingStatusCounts();

        return view('admin.dashboard.index', [
            'currentRole' => 'admin',
            'title' => 'Dashboard Administrator - Akademi Pelatihan',
            'totalPeserta' => $userCounts['peserta'],
            'totalUsers' => $userCounts['total'],
            'userCounts' => $userCounts,
            'totalProgram' => $trainingCounts['total'],
            'trainingCounts' => $trainingCounts,
            'totalPendaftaran' => 0, // Dihitung di M4
            'totalPesan' => 0,       // Dihitung di M6
        ]);
    }
}
