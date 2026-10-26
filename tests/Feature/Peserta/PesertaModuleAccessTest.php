<?php

use App\Enums\EnrollmentStatus;
use App\Enums\ModuleStatus;
use App\Enums\ModuleType;
use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->peserta = User::create([
        'name' => 'Peserta Uji',
        'email' => 'peserta.uji@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $this->admin = User::create([
        'name' => 'Admin Sistem',
        'email' => 'admin.modul@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Admin,
        'is_active' => true,
    ]);

    $category = \App\Models\TrainingCategory::create([
        'name' => 'Teknologi Informasi',
        'slug' => 'teknologi-informasi',
    ]);

    $this->training = Training::create([
        'category_id' => $category->id,
        'title' => 'Pelatihan AI Dasar',
        'slug' => 'pelatihan-ai-dasar',
        'description' => 'Materi pelatihan kecerdasan buatan.',
        'mode' => TrainingMode::Online,
        'audience' => TrainingAudience::Guru,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(1)->toDateString(),
        'end_date' => now()->addDays(3)->toDateString(),
        'created_by' => $this->admin->id,
    ]);

    // Daftarkan peserta
    $this->enrollment = Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    // Buat modul published
    $this->publishedModule = Module::create([
        'training_id' => $this->training->id,
        'created_by' => $this->admin->id,
        'title' => 'Modul 1: Pengenalan AI',
        'description' => 'Konsep dasar kecerdasan buatan.',
        'type' => ModuleType::Text,
        'content' => 'Ini adalah konten lengkap bacaan modul 1.',
        'sort_order' => 1,
        'status' => ModuleStatus::Published,
    ]);

    // Buat modul draft
    $this->draftModule = Module::create([
        'training_id' => $this->training->id,
        'created_by' => $this->admin->id,
        'title' => 'Modul 2: AI Lanjutan (Draft)',
        'description' => 'Belum siap dipublikasikan.',
        'type' => ModuleType::Text,
        'content' => 'Draft materi lanjutan...',
        'sort_order' => 2,
        'status' => ModuleStatus::Draft,
    ]);
});

test('peserta terdaftar dapat mengakses ruang belajar pelatihan (PST-05)', function () {
    $response = $this->actingAs($this->peserta)->get(route('peserta.trainings.show', $this->training->id));

    $response->assertOk();
    $response->assertSee('Ruang Belajar Peserta');
    $response->assertSee('Pelatihan AI Dasar');
    $response->assertSee('Modul 1: Pengenalan AI');
    // Modul draft tidak boleh tampil di ruang belajar peserta
    $response->assertDontSee('Modul 2: AI Lanjutan (Draft)');
});

test('peserta terdaftar dapat membaca modul berstatus published (PST-05)', function () {
    $response = $this->actingAs($this->peserta)->get(route('peserta.trainings.modules.show', [
        $this->training->id,
        $this->publishedModule->id,
    ]));

    $response->assertOk();
    $response->assertSee('Modul 1: Pengenalan AI');
    $response->assertSee('Ini adalah konten lengkap bacaan modul 1.');
});

test('peserta yang tidak terdaftar mendapat 403 saat mengakses modul (PST-05 / PRD M5)', function () {
    $pesertaLain = User::create([
        'name' => 'Peserta Lain',
        'email' => 'peserta.lain@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $response = $this->actingAs($pesertaLain)->get(route('peserta.trainings.modules.show', [
        $this->training->id,
        $this->publishedModule->id,
    ]));

    $response->assertForbidden();
});

test('peserta tidak dapat membuka modul yang berstatus draft (404 Not Found)', function () {
    $response = $this->actingAs($this->peserta)->get(route('peserta.trainings.modules.show', [
        $this->training->id,
        $this->draftModule->id,
    ]));

    $response->assertNotFound();
});

test('halaman agenda detail menampilkan kurikulum modul terbit', function () {
    $response = $this->actingAs($this->peserta)->get(route('agenda.detail', $this->training->slug));

    $response->assertOk();
    $response->assertSee('Kurikulum &amp; Modul Pembelajaran', false);
    $response->assertSee('Modul 1: Pengenalan AI');
    $response->assertSee('Buka Modul');
});
