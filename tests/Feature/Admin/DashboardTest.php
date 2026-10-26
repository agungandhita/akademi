<?php

use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();
});

test('tamu tidak terautentikasi dialihkan dari dashboard admin ke login', function () {
    $this->get(route('admin'))
        ->assertRedirect(route('login'));
});

test('peserta tidak memiliki izin mengakses dashboard admin (403)', function () {
    $peserta = User::create([
        'name' => 'Peserta Biasa',
        'email' => 'peserta@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $this->actingAs($peserta)
        ->get(route('admin'))
        ->assertForbidden();
});

test('admin dapat melihat dashboard dan metrik agregat statistik real-time (ADM-01)', function () {
    // Buat data kategori & pelatihan
    $category = TrainingCategory::create([
        'name' => 'Kecerdasan Buatan',
        'slug' => 'kecerdasan-buatan',
    ]);

    Training::create([
        'category_id' => $category->id,
        'created_by' => $this->admin->id,
        'title' => 'Mastering AI untuk Pengajar',
        'slug' => 'mastering-ai-untuk-pengajar',
        'description' => 'Pelatihan AI terkini.',
        'audience' => TrainingAudience::Guru,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://meet.google.com/abc-defg-hij',
    ]);

    // Buat peserta
    User::create([
        'name' => 'Peserta Satu',
        'email' => 'peserta1@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin'));

    $response->assertOk()
        ->assertSee('Dashboard Manajemen Akademi Pelatihan')
        ->assertSee('Total Pengguna')
        ->assertSee('Pelatihan');
});
