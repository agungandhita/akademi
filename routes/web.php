<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BeritaController;
use App\Services\Post\PostInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TentorController;
use App\Http\Controllers\Admin\TrainingCategoryController;
use App\Http\Controllers\Admin\TrainingController;
use App\Http\Controllers\Admin\TrainingParticipantController as AdminTrainingParticipantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Peserta\PesertaDashboardController;
use App\Http\Controllers\Tentor\TentorDashboardController;
use App\Http\Controllers\Tentor\TentorModuleController;
use App\Http\Controllers\Tentor\TrainingParticipantController as TentorTrainingParticipantController;

Route::get('/', function (PostInterface $postService) {
    return view('frontend.beranda.index', [
        'recentPosts' => $postService->getRecentPublished(4),
        'title' => 'Akademi Pelatihan - Akselerasi Karir & Keahlian Digital',
        'metaDescription' => 'Platform terpercaya untuk peningkatan kompetensi guru, siswa, dan masyarakat umum dengan kurikulum standar nasional terakreditasi.',
    ]);
})->name('home');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
Route::get('/agenda/{slug}', [AgendaController::class, 'show'])->name('agenda.detail');
Route::post('/agenda/{slug}/daftar', [AgendaController::class, 'enroll'])->name('agenda.enroll');

Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.detail');

Route::get('/kontak', function () {
    return view('frontend.kontak.index', [
        'title' => 'Kontak Layanan - Akademi Pelatihan',
        'metaDescription' => 'Hubungi tim layanan terpadu Akademi Pelatihan untuk konsultasi program, kemitraan in-house lembaga, dan verifikasi sertifikat.',
    ]);
})->name('kontak');

Route::post('/kontak', function (Request $request) {
    // Validasi field sesuai canonical form contract: name, email, subject, message
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
    ]);

    Alert::success('Pesan Terkirim', 'Terima kasih ' . htmlspecialchars($request->name) . ', tim Akademi Pelatihan akan segera menghubungi Anda!');
    return redirect()->route('kontak');
});

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.post');

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin');

    // ADM-02: Manajemen Pengguna
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('admin.users.toggle-active');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // ADM-03: Buat Akun Tentor
    Route::get('/tentor/create', [TentorController::class, 'create'])->name('admin.tentor.create');
    Route::post('/tentor', [TentorController::class, 'store'])->name('admin.tentor.store');

    // ADM-04: Kategori Pelatihan
    Route::resource('categories', TrainingCategoryController::class, ['as' => 'admin'])->except(['show']);

    // ADM-05, ADM-06, ADM-07: Pelatihan, Sesi, Penugasan Tentor
    Route::resource('trainings', TrainingController::class, ['as' => 'admin']);
    Route::post('/trainings/{training}/sessions', [TrainingController::class, 'storeSession'])->name('admin.trainings.sessions.store');
    Route::delete('/trainings/{training}/sessions/{session}', [TrainingController::class, 'destroySession'])->name('admin.trainings.sessions.destroy');
    Route::post('/trainings/{training}/instructors', [TrainingController::class, 'syncInstructors'])->name('admin.trainings.instructors.sync');

    // ADM-08: Daftar Peserta Pelatihan & Ekspor CSV
    Route::get('/trainings/{training}/participants', [AdminTrainingParticipantController::class, 'index'])->name('admin.trainings.participants');
    Route::get('/trainings/{training}/participants/export', [AdminTrainingParticipantController::class, 'export'])->name('admin.trainings.participants.export');
    Route::delete('/trainings/{training}/participants/{enrollment}', [AdminTrainingParticipantController::class, 'destroy'])->name('admin.trainings.participants.destroy');

    // ADM-10: Berita & Artikel (Bisa diakses melalui URL /admin/posts maupun /admin/berita)
    Route::resource('posts', PostController::class, ['as' => 'admin']);
    Route::resource('berita', PostController::class, [
        'names' => [
            'index' => 'admin.berita.index',
            'create' => 'admin.berita.create',
            'store' => 'admin.berita.store',
            'show' => 'admin.berita.show',
            'edit' => 'admin.berita.edit',
            'update' => 'admin.berita.update',
            'destroy' => 'admin.berita.destroy',
        ],
        'parameters' => ['berita' => 'post'],
    ]);
});

Route::middleware(['auth', 'role:tentor'])->prefix('tentor')->group(function () {
    // TNT-01: Dashboard Instruktur
    Route::get('/', [TentorDashboardController::class, 'index'])->name('tentor');

    // TNT-02: Pelatihan Ditugaskan
    Route::get('/pelatihan', [TentorDashboardController::class, 'trainings'])->name('tentor.trainings');

    // TNT-06: Daftar Peserta Pelatihan (Read-only)
    Route::get('/trainings/{training}/participants', [TentorTrainingParticipantController::class, 'index'])->name('tentor.trainings.participants');

    // TNT-03 s.d. TNT-05: Modul Pembelajaran (CRUD)
    Route::resource('modul', TentorModuleController::class, ['as' => 'tentor'])->parameters(['modul' => 'module'])->names([
        'index' => 'tentor.modules.index',
        'create' => 'tentor.modules.create',
        'store' => 'tentor.modules.store',
        'edit' => 'tentor.modules.edit',
        'update' => 'tentor.modules.update',
        'destroy' => 'tentor.modules.destroy',
    ])->except(['show']);

    // TNT-07: Profil & Keahlian Instruktur
    Route::get('/profil', [TentorDashboardController::class, 'profile'])->name('tentor.profile');
    Route::put('/profil', [TentorDashboardController::class, 'updateProfile'])->name('tentor.profile.update');
});

Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->group(function () {
    Route::get('/', [PesertaDashboardController::class, 'index'])->name('peserta');
    Route::get('/pelatihan', [PesertaDashboardController::class, 'trainings'])->name('peserta.trainings');
    // PST-05, PST-07: Ruang Belajar & Akses Modul Pembelajaran
    Route::get('/pelatihan/{training}', [PesertaDashboardController::class, 'showTraining'])->name('peserta.trainings.show');
    Route::get('/pelatihan/{training}/modul/{module}', [PesertaDashboardController::class, 'showModule'])->name('peserta.trainings.modules.show');
});
