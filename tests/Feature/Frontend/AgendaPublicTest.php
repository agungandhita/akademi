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

    $this->category = TrainingCategory::create([
        'name' => 'Koding & Pemrograman',
        'slug' => 'koding-pemrograman',
    ]);

    $this->tentor = User::create([
        'name' => 'M Satria Pinandhita, S.Kom',
        'email' => 'satria@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Tentor,
        'expertise' => 'Laravel & Vue.js',
        'is_active' => true,
    ]);
});

test('pengunjung publik dapat melihat halaman detail pelatihan sesuai data yang diinputkan di admin', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Mastering Laravel 13 Fullstack',
        'slug' => 'mastering-laravel-13-fullstack',
        'description' => 'Kursus intensif arsitektur Laravel dan pengembangan web modern.',
        'audience' => TrainingAudience::Siswa,
        'mode' => TrainingMode::Offline,
        'status' => TrainingStatus::Published,
        'is_free' => true,
        'price' => 0,
        'quota' => 30,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'location' => 'Lab Komputer Kampus C',
        'facilities' => [
            'E-Sertifikat 32 JP Terverifikasi Nasional',
            'Modul Ajar & Bahan Tayang Digital Lengkap',
        ],
    ]);

    $training->instructors()->attach($this->tentor->id);

    $response = $this->get(route('agenda.detail', $training->slug));

    $response->assertOk()
        ->assertSee('Mastering Laravel 13 Fullstack')
        ->assertSee('Koding & Pemrograman')
        ->assertSee('Kursus intensif arsitektur Laravel')
        ->assertSee('M Satria Pinandhita, S.Kom')
        ->assertSee('Laravel & Vue.js')
        ->assertSee('100% Gratis')
        ->assertSee('30 Peserta')
        ->assertSee('Lab Komputer Kampus C')
        ->assertSee('E-Sertifikat 32 JP Terverifikasi Nasional')
        ->assertSee('Modul Ajar & Bahan Tayang Digital Lengkap');
});

test('halaman detail agenda mengembalikan 404 jika slug pelatihan tidak ditemukan', function () {
    $response = $this->get(route('agenda.detail', 'slug-yang-tidak-ada-12345'));

    $response->assertNotFound();
});

test('pengunjung publik dapat melihat halaman katalog daftar agenda pelatihan', function () {
    $this->seed(\Database\Seeders\TrainingAgendaSeeder::class);

    $response = $this->get(route('agenda'));

    $response->assertOk()
        ->assertSee('Daftar Agenda Pelatihan Aktif')
        ->assertSee('Penerapan Pembelajaran Berbasis AI dan Gamifikasi')
        ->assertSee('Bootcamp Intensif Fullstack Web Development')
        ->assertSee('Sertifikasi Pemrograman PLC &amp; Otomasi Robotika', false);
});
