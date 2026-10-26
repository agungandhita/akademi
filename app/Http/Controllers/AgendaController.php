<?php

namespace App\Http\Controllers;

use App\Services\Training\TrainingInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function __construct(
        protected TrainingInterface $trainingService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category_id', 'mode', 'status', 'audience']);
        $trainings = $this->trainingService->getAllPaginated($filters, 9);

        return view('frontend.agenda.index', [
            'trainings' => $trainings,
            'title' => 'Agenda Pelatihan - Akademi Pelatihan',
            'metaDescription' => 'Daftar jadwal workshop, seminar, dan sertifikasi kompetensi untuk guru, siswa, dan profesional se-Indonesia.',
        ]);
    }

    public function show(string $slug): View
    {
        $training = $this->trainingService->getBySlug($slug);

        return view('frontend.agenda.detail', [
            'training' => $training,
            'slug' => $slug,
            'title' => "{$training->title} - Agenda Pelatihan",
            'metaDescription' => "Informasi silabus, jadwal sesi, profil instruktur, dan pendaftaran resmi program pelatihan {$training->title}.",
        ]);
    }
}
