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
use App\Http\Controllers\Admin\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes - Akademi Pelatihan
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. PUBLIC MARKETING & KNOWLEDGE BASE
// ==========================================

Route::get('/', function (PostInterface $postService) {
    return view('frontend.beranda.index', [
        'recentPosts' => $postService->getRecentPublished(4),
        'title' => 'Akademi Pelatihan - Akselerasi Karir & Keahlian Digital',
        'metaDescription' => 'Platform terpercaya untuk peningkatan kompetensi guru, siswa, dan masyarakat umum dengan kurikulum standar nasional terakreditasi.',
    ]);
})->name('home');

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda');
Route::get('/agenda/{slug}', [AgendaController::class, 'show'])->name('agenda.detail');

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
    Route::get('/', function () {
        return view('admin.tentor.index', [
            'currentRole' => 'tentor',
            'title' => 'Dashboard Tentor & Instruktur - Akademi Pelatihan',
        ]);
    })->name('tentor');
});

Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->group(function () {
    Route::get('/', function () {
        return view('admin.peserta.index', [
            'currentRole' => 'peserta',
            'title' => 'Portal Pembelajaran Peserta - Akademi Pelatihan',
        ]);
    })->name('peserta');
});
