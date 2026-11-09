<?php

use App\Enums\EnrollmentStatus;
use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Enrollment;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();

    $this->category = TrainingCategory::create([
        'name' => 'Kategori Guru',
        'slug' => 'kategori-guru',
    ]);

    $this->training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Workshop AI untuk Guru Penggerak',
        'slug' => 'workshop-ai-untuk-guru-penggerak',
        'description' => 'Meningkatkan kecakapan teknologi pendidik.',
        'audience' => TrainingAudience::Guru,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(5)->toDateString(),
        'certificate_number' => '077/AP/XI/2026',
        'certificate_date' => '20 November 2026',
        'certificate_signer_left_title' => 'Ketua Pelaksana',
        'certificate_signer_left_name' => 'Drs. H. Mulyadi, M.Pd',
        'certificate_signer_left_nip' => 'NIP. 19700101 199501 1 001',
        'certificate_signer_right_title' => 'Pimpinan Akademi Pelatihan',
        'certificate_signer_right_name' => 'Prof. Dr. Ir. H. Budi Santoso',
        'certificate_signer_right_nip' => 'NIP. 19750820 199903 1 001',
        'is_certificate_enabled' => true,
    ]);

    $this->peserta = User::create([
        'name' => 'Siti Nurhaliza, S.Pd',
        'email' => 'siti@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $this->enrollment = Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $this->otherPeserta = User::create([
        'name' => 'Peserta Lain',
        'email' => 'lain@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);
});

test('peserta terdaftar dapat mengakses dan mencetak sertifikat saat sudah diterbitkan', function () {
    $response = $this->actingAs($this->peserta)
        ->get(route('peserta.trainings.certificate', $this->training->id));

    $response->assertOk();
    $response->assertSee('Siti Nurhaliza, S.Pd');
    $response->assertSee(strtoupper($this->training->title));
    $response->assertSee('NOMOR KEGIATAN: 077/AP/XI/2026');
    $response->assertSee('20 November 2026');
    $response->assertSee('Drs. H. Mulyadi, M.Pd');
    $response->assertSee('Prof. Dr. Ir. H. Budi Santoso');
});

test('peserta terdaftar mendapat error 403 jika sertifikat belum diaktifkan oleh admin', function () {
    $this->training->update(['is_certificate_enabled' => false]);

    $response = $this->actingAs($this->peserta)
        ->get(route('peserta.trainings.certificate', $this->training->id));

    $response->assertForbidden();
});

test('peserta yang tidak terdaftar pada pelatihan ditolak saat mencoba membuka sertifikat', function () {
    $response = $this->actingAs($this->otherPeserta)
        ->get(route('peserta.trainings.certificate', $this->training->id));

    $response->assertForbidden();
});

test('peserta dengan status pendaftaran dibatalkan tidak dapat membuka sertifikat', function () {
    $this->enrollment->update(['status' => EnrollmentStatus::Cancelled]);

    $response = $this->actingAs($this->peserta)
        ->get(route('peserta.trainings.certificate', $this->training->id));

    $response->assertForbidden();
});

test('tamu yang belum login diarahkan ke halaman login saat mencoba membuka sertifikat', function () {
    $response = $this->get(route('peserta.trainings.certificate', $this->training->id));

    $response->assertRedirect(route('login'));
});

