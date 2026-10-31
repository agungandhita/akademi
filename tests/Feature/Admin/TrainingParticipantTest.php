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
        'name' => 'Teknologi Pendidikan',
        'slug' => 'teknologi-pendidikan',
    ]);

    $this->training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan AI untuk Guru',
        'slug' => 'pelatihan-ai-untuk-guru',
        'description' => 'Meningkatkan kompetensi guru berbasis AI.',
        'audience' => TrainingAudience::Guru,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
    ]);

    $this->tentor = User::create([
        'name' => 'Instruktur Handal',
        'email' => 'tentor@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Tentor,
        'is_active' => true,
    ]);

    $this->peserta = User::create([
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'phone' => '081234567890',
        'institution' => 'SMA Negeri 1',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);
});

test('tamu tidak terautentikasi dialihkan dari daftar peserta ke login', function () {
    $this->get(route('admin.trainings.participants', $this->training->id))
        ->assertRedirect(route('login'));

    $this->get(route('tentor.trainings.participants', $this->training->id))
        ->assertRedirect(route('login'));
});

test('peserta biasa dilarang mengakses daftar peserta (403)', function () {
    $this->actingAs($this->peserta)
        ->get(route('admin.trainings.participants', $this->training->id))
        ->assertForbidden();

    $this->actingAs($this->peserta)
        ->get(route('tentor.trainings.participants', $this->training->id))
        ->assertForbidden();
});

test('admin dapat melihat halaman daftar peserta pelatihan (ADM-08)', function () {
    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.trainings.participants', $this->training->id));

    $response->assertOk()
        ->assertSee('Daftar Peserta Pelatihan')
        ->assertSee('Pelatihan AI untuk Guru')
        ->assertSee('Budi Santoso')
        ->assertSee('budi@example.com')
        ->assertSee('SMA Negeri 1')
        ->assertSee('Terdaftar');
});

test('admin dapat mengekspor daftar peserta ke CSV (ADM-08)', function () {
    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.trainings.participants.export', $this->training->id));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'text/csv; charset=utf-8');
    expect($response->headers->get('Content-Disposition'))->toContain('attachment; filename="peserta_pelatihan-ai-untuk-guru_');
});

test('tentor yang ditugaskan dapat melihat daftar peserta pelatihannya (TNT-06)', function () {
    // Tugaskan tentor ke pelatihan
    $this->training->instructors()->attach($this->tentor->id);

    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->tentor)
        ->get(route('tentor.trainings.participants', $this->training->id));

    $response->assertOk()
        ->assertSee('Daftar Peserta Pelatihan')
        ->assertSee('Budi Santoso')
        ->assertSee('Terdaftar');
});

test('tentor yang tidak ditugaskan ditolak saat mencoba melihat peserta pelatihan lain (TNT-02)', function () {
    // Tentor tidak di-attach ke $this->training
    $response = $this->actingAs($this->tentor)
        ->get(route('tentor.trainings.participants', $this->training->id));

    $response->assertForbidden();
});

test('pencarian dan filter status peserta berfungsi dengan baik', function () {
    $pesertaDua = User::create([
        'name' => 'Siti Aisyah',
        'email' => 'siti@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    Enrollment::create([
        'user_id' => $pesertaDua->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Completed,
        'enrolled_at' => now(),
        'completed_at' => now(),
    ]);

    // Cari nama Budi
    $this->actingAs($this->admin)
        ->get(route('admin.trainings.participants', ['training' => $this->training->id, 'search' => 'Budi']))
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertDontSee('Siti Aisyah');

    // Filter status Completed
    $this->actingAs($this->admin)
        ->get(route('admin.trainings.participants', ['training' => $this->training->id, 'status' => 'completed']))
        ->assertOk()
        ->assertSee('Siti Aisyah')
        ->assertDontSee('Budi Santoso');
});

test('halaman detail agenda menampilkan sisa kuota secara realtime', function () {
    $this->training->update(['quota' => 150]);

    // Daftarkan 1 peserta
    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->get(route('agenda.detail', $this->training->slug));

    $response->assertOk()
        ->assertSee('Sisa Kuota Peserta')
        ->assertSee('Sisa 149 Kursi')
        ->assertSee('orang terdaftar');
});

test('peserta yang login dapat mendaftar ke pelatihan yang masih memiliki kuota', function () {
    $this->training->update(['quota' => 10]);

    $response = $this->actingAs($this->peserta)
        ->post(route('agenda.enroll', $this->training->slug));

    $response->assertRedirect(route('agenda.detail', $this->training->slug));

    $this->assertDatabaseHas('enrollments', [
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered->value,
    ]);
});

test('pendaftaran ditolak jika kuota pelatihan sudah penuh', function () {
    $this->training->update(['quota' => 1]);

    // Daftarkan user pertama sehingga kuota penuh
    $pesertaLain = User::create([
        'name' => 'Peserta Satu',
        'email' => 'peserta1@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    Enrollment::create([
        'user_id' => $pesertaLain->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->peserta)
        ->post(route('agenda.enroll', $this->training->slug));

    $response->assertRedirect(route('agenda.detail', $this->training->slug));

    // Peserta kedua tidak boleh terdaftar
    $this->assertDatabaseMissing('enrollments', [
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
    ]);
});

test('peserta dapat mengakses portal peserta dan melihat pelatihan yang diikuti', function () {
    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->peserta)
        ->get(route('peserta'));

    $response->assertOk()
        ->assertSee('Portal Pembelajaran Peserta')
        ->assertSee($this->training->title);
});

test('peserta dapat mengakses halaman Pelatihan Saya dari sidebar', function () {
    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->peserta)
        ->get(route('peserta.trainings'));

    $response->assertOk()
        ->assertSee('Pelatihan Saya')
        ->assertSee($this->training->title)
        ->assertSee('1 Pelatihan Aktif');
});

test('tamu tidak bisa mengakses halaman Pelatihan Saya', function () {
    $this->get(route('peserta.trainings'))
        ->assertRedirect(route('login'));
});

test('tombol pendaftaran di-hidden jika waktu pendaftaran sudah berakhir', function () {
    $this->training->update([
        'registration_start' => now()->subDays(10)->toDateString(),
        'registration_end' => now()->subDays(1)->toDateString(),
    ]);

    $response = $this->get(route('agenda.detail', $this->training->slug));

    $response->assertOk()
        ->assertSee('Pendaftaran Telah Ditutup')
        ->assertDontSee('Daftar Pelatihan Sekarang');
});

test('tampil tulisan kuota penuh dan tombol disabled jika kuota sudah terpenuhi', function () {
    $this->training->update([
        'quota' => 1,
        'registration_start' => now()->subDays(2)->toDateString(),
        'registration_end' => now()->addDays(5)->toDateString(),
    ]);

    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $otherUser = User::create([
        'name' => 'Peserta Baru',
        'email' => 'pesertabaru@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $response = $this->actingAs($otherUser)
        ->get(route('agenda.detail', $this->training->slug));

    $response->assertOk()
        ->assertSee('Kuota Penuh')
        ->assertDontSee('Daftar Pelatihan Sekarang');
});

test('pendaftaran belum bisa dilakukan jika waktu pendaftaran belum dibuka', function () {
    $this->training->update([
        'registration_start' => now()->addDays(3)->toDateString(),
        'registration_end' => now()->addDays(10)->toDateString(),
    ]);

    $response = $this->actingAs($this->peserta)
        ->get(route('agenda.detail', $this->training->slug));

    $response->assertOk()
        ->assertSee('Pendaftaran Belum Dibuka')
        ->assertDontSee('Daftar Pelatihan Sekarang');

    // Coba pendaftaran langsung
    $enrollResponse = $this->actingAs($this->peserta)
        ->post(route('agenda.enroll', $this->training->slug));

    $enrollResponse->assertRedirect(route('agenda.detail', $this->training->slug));

    $this->assertDatabaseMissing('enrollments', [
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
    ]);
});

test('admin dapat menghapus pendaftaran peserta dari pelatihan (ADM-08)', function () {
    $enrollment = Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.trainings.participants.destroy', [$this->training->id, $enrollment->id]));

    $response->assertRedirect(route('admin.trainings.participants', $this->training->id));

    $this->assertSoftDeleted('enrollments', [
        'id' => $enrollment->id,
    ]);
});

test('admin dapat mengakses panel broadcast wa blast dan tombol kirim wa pada daftar peserta', function () {
    $this->training->update([
        'whatsapp_group_link' => 'https://chat.whatsapp.com/TEST_BLAST_123',
    ]);

    Enrollment::create([
        'user_id' => $this->peserta->id,
        'training_id' => $this->training->id,
        'status' => EnrollmentStatus::Registered,
        'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.trainings.participants', $this->training->id));

    $response->assertOk()
        ->assertSee('Kirim Pengumuman WA')
        ->assertSee('Broadcast WhatsApp Peserta Pelatihan')
        ->assertSee('Kirim WA')
        ->assertSee('https://chat.whatsapp.com/TEST_BLAST_123')
        ->assertSee('Kirim ke Peserta Berikutnya');
});

