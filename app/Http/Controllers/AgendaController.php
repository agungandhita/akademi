<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Services\Enrollment\EnrollmentInterface;
use App\Services\Training\TrainingInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class AgendaController extends Controller
{
    public function __construct(
        protected TrainingInterface $trainingService,
        protected EnrollmentInterface $enrollmentService,
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

        $isEnrolled = false;
        if (auth()->check()) {
            $isEnrolled = $this->enrollmentService->isUserEnrolled(auth()->id(), $training->id);
        }

        return view('frontend.agenda.detail', [
            'training' => $training,
            'isEnrolled' => $isEnrolled,
            'slug' => $slug,
            'title' => "{$training->title} - Agenda Pelatihan",
            'metaDescription' => "Informasi silabus, jadwal sesi, profil instruktur, dan pendaftaran resmi program pelatihan {$training->title}.",
        ]);
    }

    public function enroll(string $slug): RedirectResponse
    {
        $user = auth()->user();
        if (! $user || $user->role !== UserRole::Peserta) {
            Alert::error('Akses Ditolak', 'Hanya akun peserta yang dapat mendaftar pelatihan ini.');

            return redirect()->route('agenda.detail', $slug);
        }

        $training = $this->trainingService->getBySlug($slug);

        try {
            $this->enrollmentService->enroll($user->id, $training->id);
            if ($training->whatsapp_group_link) {
                session()->flash('enrolled_whatsapp_popup', true);
            } else {
                Alert::success('Pendaftaran Berhasil!', "Selamat, Anda telah terdaftar pada program pelatihan \"{$training->title}\".");
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $message = ! empty($errors) ? implode(' ', array_map(fn ($err) => implode(' ', $err), $errors)) : 'Pendaftaran gagal diproses.';
            Alert::error('Pendaftaran Gagal', $message);
        } catch (\Throwable $e) {
            Alert::error('Pendaftaran Gagal', 'Terjadi kendala saat memproses pendaftaran. Silakan coba kembali.');
        }

        return redirect()->route('agenda.detail', $slug);
    }
}
