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
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();

    $this->category = TrainingCategory::create([
        'name' => 'Kategori Sertifikasi',
        'slug' => 'kategori-sertifikasi',
    ]);

    $this->training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Transformasi Digital',
        'slug' => 'pelatihan-transformasi-digital',
        'description' => 'Pelatihan transformasi digital untuk pendidik.',
        'audience' => TrainingAudience::Guru,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
    ]);

    $this->peserta = User::create([
        'name' => 'Ahmad Dahlan',
        'email' => 'ahmad@example.com',
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
});

test('admin dapat membuka halaman konfigurasi sertifikat pelatihan', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.trainings.certificate.edit', $this->training->id));

    $response->assertOk();
    $response->assertSee('Pengaturan Sertifikat Pelatihan');
    $response->assertSee($this->training->title);
});

test('admin dapat memperbarui konfigurasi nomor kegiatan, tanggal, dan tanda tangan sertifikat', function () {
    Storage::fake('public');

    $leftSignature = UploadedFile::fake()->image('ttd_ketua.png');
    $rightSignature = UploadedFile::fake()->image('ttd_pimpinan.png');

    $response = $this->actingAs($this->admin)
        ->put(route('admin.trainings.certificate.update', $this->training->id), [
            'certificate_number' => '045/AP/XI/2026',
            'certificate_date' => '25 November 2026',
            'certificate_signer_left_title' => 'Ketua Panitia Pelaksana',
            'certificate_signer_left_name' => 'Dr. Hendra Wijaya, M.Pd',
            'certificate_signer_left_nip' => 'NIP. 19820315 200501 1 002',
            'certificate_signer_left_signature' => $leftSignature,
            'certificate_signer_right_title' => 'Direktur Utama Akademi Pelatihan',
            'certificate_signer_right_name' => 'Prof. Dr. Ir. Budi Santoso',
            'certificate_signer_right_nip' => 'NIP. 19750820 199903 1 001',
            'certificate_signer_right_signature' => $rightSignature,
            'is_certificate_enabled' => '1',
        ]);

    $response->assertRedirect(route('admin.trainings.certificate.edit', $this->training->id));

    $this->training->refresh();

    expect($this->training->certificate_number)->toBe('045/AP/XI/2026')
        ->and($this->training->certificate_date)->toBe('25 November 2026')
        ->and($this->training->certificate_signer_left_name)->toBe('Dr. Hendra Wijaya, M.Pd')
        ->and($this->training->certificate_signer_right_name)->toBe('Prof. Dr. Ir. Budi Santoso')
        ->and($this->training->is_certificate_enabled)->toBeTrue();

    Storage::disk('public')->assertExists($this->training->certificate_signer_left_signature);
    Storage::disk('public')->assertExists($this->training->certificate_signer_right_signature);
});

test('admin dapat mempratinjau sertifikat pelatihan', function () {
    $this->training->update([
        'certificate_number' => '088/AP/XII/2026',
        'certificate_signer_right_name' => 'Prof. Dr. Ir. Budi Santoso',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.trainings.certificate.preview', $this->training->id));

    $response->assertOk();
    $response->assertSee('NOMOR KEGIATAN: 088/AP/XII/2026');
    $response->assertSee(strtoupper($this->training->title));
    $response->assertSee('Mode Pratinjau Admin');
});

test('admin dapat melihat dan mencetak sertifikat peserta tertentu dari daftar pendaftar', function () {
    $this->training->update([
        'certificate_number' => '099/AP/XII/2026',
        'is_certificate_enabled' => true,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.trainings.participants.certificate', [$this->training->id, $this->enrollment->id]));

    $response->assertOk();
    $response->assertSee('Ahmad Dahlan');
    $response->assertSee('NOMOR KEGIATAN: 099/AP/XII/2026');
    $response->assertSee(strtoupper($this->training->title));
});

test('user non-admin ditolak saat mengakses rute konfigurasi sertifikat admin', function () {
    $response = $this->actingAs($this->peserta)
        ->get(route('admin.trainings.certificate.edit', $this->training->id));

    $response->assertForbidden();
});

