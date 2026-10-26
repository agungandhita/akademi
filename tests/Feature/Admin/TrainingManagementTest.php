<?php

use App\Enums\SessionType;
use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\TrainingSession;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();

    $this->category = TrainingCategory::create([
        'name' => 'Teknologi Informasi',
        'slug' => 'teknologi-informasi',
    ]);

    $this->tentor = User::create([
        'name' => 'Instruktur Handal',
        'email' => 'tentor.handal@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Tentor,
        'is_active' => true,
    ]);
});

test('admin dapat melihat daftar program pelatihan dengan filter (ADM-05)', function () {
    Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Fullstack Laravel Mastery',
        'slug' => 'fullstack-laravel-mastery',
        'description' => 'Kursus lengkap Laravel.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'is_free' => false,
        'price' => 250000,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(10)->toDateString(),
        'meeting_url' => 'https://zoom.us/j/1234567890',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.trainings.index'));

    $response->assertOk()
        ->assertSee('Manajemen Pelatihan')
        ->assertSee('Fullstack Laravel Mastery')
        ->assertSee('Rp 250.000');
});

test('admin berhasil membuat program pelatihan mode Online dengan meeting_url', function () {
    $trainingData = [
        'category_id' => $this->category->id,
        'title' => 'Workshop UI/UX Figma untuk Guru SMK',
        'description' => 'Pelatihan desain UI/UX interaktif.',
        'audience' => TrainingAudience::Guru->value,
        'mode' => TrainingMode::Online->value,
        'status' => TrainingStatus::Draft->value,
        'is_free' => '1',
        'price' => 0,
        'quota' => 50,
        'start_date' => now()->addDays(7)->toDateString(),
        'end_date' => now()->addDays(9)->toDateString(),
        'meeting_url' => 'https://meet.google.com/test-room',
        'instructors' => [$this->tentor->id],
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.store'), $trainingData);

    $training = Training::where('slug', 'workshop-uiux-figma-untuk-guru-smk')->first();
    expect($training)->not->toBeNull();
    $response->assertRedirect(route('admin.trainings.show', $training->id));

    expect($training->mode)->toBe(TrainingMode::Online);
    expect($training->meeting_url)->toBe('https://meet.google.com/test-room');
    expect($training->instructors)->toHaveCount(1);
    expect($training->instructors->first()->id)->toBe($this->tentor->id);
});

test('admin berhasil membuat program pelatihan mode Offline dengan location', function () {
    $trainingData = [
        'category_id' => $this->category->id,
        'title' => 'Pelatihan Robotika Vokasi Industri',
        'description' => 'Workshop tatap muka perakitan robot industri.',
        'audience' => TrainingAudience::Vokasi->value,
        'mode' => TrainingMode::Offline->value,
        'status' => TrainingStatus::Published->value,
        'is_free' => '0',
        'price' => 500000,
        'quota' => 25,
        'start_date' => now()->addDays(14)->toDateString(),
        'end_date' => now()->addDays(16)->toDateString(),
        'location' => 'Balai Diklat Industri Surabaya, Lab Otomasi',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.store'), $trainingData);

    $training = Training::where('slug', 'pelatihan-robotika-vokasi-industri')->first();
    expect($training)->not->toBeNull();
    $response->assertRedirect(route('admin.trainings.show', $training->id));

    expect($training->mode)->toBe(TrainingMode::Offline);
    expect($training->location)->toBe('Balai Diklat Industri Surabaya, Lab Otomasi');
    expect($training->price)->toBe('500000.00');
});

test('validasi mode Online gagal jika meeting_url tidak diisi (Business Rule 7)', function () {
    $trainingData = [
        'category_id' => $this->category->id,
        'title' => 'Webinar Tanpa URL Meeting',
        'description' => 'Deskripsi webinar.',
        'audience' => TrainingAudience::Umum->value,
        'mode' => TrainingMode::Online->value,
        'status' => TrainingStatus::Draft->value,
        'is_free' => '1',
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'meeting_url' => '', // kosong
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.store'), $trainingData);

    $response->assertSessionHasErrors('meeting_url');
});

test('validasi mode Offline gagal jika lokasi tidak diisi (Business Rule 7)', function () {
    $trainingData = [
        'category_id' => $this->category->id,
        'title' => 'Pelatihan Tanpa Lokasi Fisik',
        'description' => 'Deskripsi offline.',
        'audience' => TrainingAudience::Guru->value,
        'mode' => TrainingMode::Offline->value,
        'status' => TrainingStatus::Draft->value,
        'is_free' => '1',
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'location' => '', // kosong
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.store'), $trainingData);

    $response->assertSessionHasErrors('location');
});

test('admin dapat memperbarui data pelatihan', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Judul Lama',
        'slug' => 'pelatihan-judul-lama',
        'description' => 'Deskripsi lama.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Draft,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://meet.google.com/old-url',
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.trainings.update', $training->id), [
            'category_id' => $this->category->id,
            'title' => 'Pelatihan Judul Baru & Publikasi',
            'slug' => 'pelatihan-judul-baru-publikasi',
            'description' => 'Deskripsi yang telah disempurnakan.',
            'audience' => TrainingAudience::Guru->value,
            'mode' => TrainingMode::Online->value,
            'status' => TrainingStatus::Published->value,
            'is_free' => '0',
            'price' => 150000,
            'quota' => 40,
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(12)->toDateString(),
            'meeting_url' => 'https://meet.google.com/new-url',
        ]);

    $response->assertRedirect(route('admin.trainings.show', $training->id));

    $freshTraining = $training->fresh();
    expect($freshTraining->title)->toBe('Pelatihan Judul Baru & Publikasi');
    expect($freshTraining->status)->toBe(TrainingStatus::Published);
    expect($freshTraining->price)->toBe('150000.00');
});

test('admin dapat menghapus pelatihan (soft delete)', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Akan Dihapus',
        'slug' => 'pelatihan-akan-dihapus',
        'description' => 'Deskripsi.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Draft,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://meet.google.com/test',
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.trainings.destroy', $training->id));

    $response->assertRedirect(route('admin.trainings.index'));

    expect($training->fresh()->trashed())->toBeTrue();
    $this->assertSoftDeleted('trainings', ['id' => $training->id]);
});

test('admin dapat menambahkan dan menghapus sesi pelatihan (ADM-06)', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Bersesi',
        'slug' => 'pelatihan-bersesi',
        'description' => 'Deskripsi.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Blended,
        'status' => TrainingStatus::Published,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(10)->toDateString(),
    ]);

    // Tambah Sesi
    $sessionData = [
        'title' => 'Sesi 1: Pengenalan Konsep & Arsitektur',
        'session_date' => now()->addDays(5)->toDateString(),
        'start_time' => '09:00',
        'end_time' => '12:00',
        'session_type' => SessionType::Online->value,
        'meeting_url' => 'https://meet.google.com/sesi-1',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.sessions.store', $training->id), $sessionData);

    $response->assertRedirect();

    $session = TrainingSession::where('training_id', $training->id)->first();
    expect($session)->not->toBeNull();
    expect($session->title)->toBe('Sesi 1: Pengenalan Konsep & Arsitektur');
    expect($session->session_type)->toBe(SessionType::Online);

    // Hapus Sesi
    $deleteResponse = $this->actingAs($this->admin)
        ->delete(route('admin.trainings.sessions.destroy', [$training->id, $session->id]));

    $deleteResponse->assertRedirect();
    expect(TrainingSession::find($session->id))->toBeNull();
});

test('admin dapat menugaskan dan menyinkronkan instruktur ke pelatihan (ADM-07)', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Multi Tentor',
        'slug' => 'pelatihan-multi-tentor',
        'description' => 'Deskripsi.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Draft,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://meet.google.com/multi',
    ]);

    $tentorDua = User::create([
        'name' => 'Instruktur Kedua',
        'email' => 'tentor.dua@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Tentor,
        'is_active' => true,
    ]);

    // Sinkronisasi instruktur
    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.instructors.sync', $training->id), [
            'instructors' => [$this->tentor->id, $tentorDua->id],
        ]);

    $response->assertRedirect();

    $freshTraining = $training->fresh();
    expect($freshTraining->instructors)->toHaveCount(2);
    expect($freshTraining->instructors->pluck('id')->toArray())
        ->toContain($this->tentor->id)
        ->toContain($tentorDua->id);
});

test('admin berhasil membuat program pelatihan dengan mengunggah gambar poster thumbnail', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('poster-pelatihan.jpg', 1280, 720);

    $trainingData = [
        'category_id' => $this->category->id,
        'title' => 'Pelatihan AI Guru Berposter',
        'description' => 'Pelatihan lengkap dengan poster.',
        'audience' => TrainingAudience::Guru->value,
        'mode' => TrainingMode::Online->value,
        'status' => TrainingStatus::Draft->value,
        'is_free' => '1',
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://meet.google.com/poster-test',
        'thumbnail' => $file,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.store'), $trainingData);

    $training = Training::where('slug', 'pelatihan-ai-guru-berposter')->first();
    expect($training)->not->toBeNull();
    $response->assertRedirect(route('admin.trainings.show', $training->id));

    expect($training->thumbnail)->not->toBeNull();
    Storage::disk('public')->assertExists($training->thumbnail);
});

test('validasi gagal jika pelatihan berbayar tetapi harga tidak diisi', function () {
    $trainingData = [
        'category_id' => $this->category->id,
        'title' => 'Pelatihan Berbayar Tanpa Nominal',
        'description' => 'Deskripsi pelatihan.',
        'audience' => TrainingAudience::Umum->value,
        'mode' => TrainingMode::Online->value,
        'status' => TrainingStatus::Draft->value,
        'is_free' => '0',
        'price' => null,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://meet.google.com/test',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.store'), $trainingData);

    $response->assertSessionHasErrors('price');
});

test('admin berhasil mengubah pelatihan dan mengunggah berkas poster baru', function () {
    Storage::fake('public');

    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Poster Lama',
        'slug' => 'pelatihan-poster-lama',
        'description' => 'Deskripsi.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Draft,
        'is_free' => true,
        'price' => 0,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://meet.google.com/old',
    ]);

    $newFile = UploadedFile::fake()->image('poster-baru.png', 800, 600);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.trainings.update', $training->id), [
            'category_id' => $this->category->id,
            'title' => 'Pelatihan Poster Telah Diperbarui',
            'slug' => 'pelatihan-poster-telah-diperbarui',
            'description' => 'Deskripsi baru.',
            'audience' => TrainingAudience::Guru->value,
            'mode' => TrainingMode::Online->value,
            'status' => TrainingStatus::Published->value,
            'is_free' => '0',
            'price' => 200000,
            'start_date' => now()->addDays(10)->toDateString(),
            'end_date' => now()->addDays(12)->toDateString(),
            'meeting_url' => 'https://meet.google.com/new',
            'thumbnail' => $newFile,
        ]);

    $response->assertRedirect(route('admin.trainings.show', $training->id));

    $freshTraining = $training->fresh();
    expect($freshTraining->thumbnail)->not->toBeNull();
    Storage::disk('public')->assertExists($freshTraining->thumbnail);
    expect($freshTraining->is_free)->toBeFalse();
    expect($freshTraining->price)->toBe('200000.00');
});

test('admin berhasil membuat program pelatihan dengan fasilitas peserta dan menampilkannya di halaman detail', function () {
    $trainingData = [
        'category_id' => $this->category->id,
        'title' => 'Pelatihan AI Coding Agent Batch 1',
        'description' => 'Pelatihan otomatisasi pemrograman dengan AI.',
        'audience' => TrainingAudience::Umum->value,
        'mode' => TrainingMode::Online->value,
        'status' => TrainingStatus::Published->value,
        'is_free' => '1',
        'price' => 0,
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(5)->toDateString(),
        'meeting_url' => 'https://meet.google.com/ai-class',
        'facilities' => [
            'E-Sertifikat 32 JP Terverifikasi Nasional',
            'Modul Ajar & Bahan Tayang Digital Lengkap',
            'Voucher Cloud Hosting 6 Bulan',
        ],
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.trainings.store'), $trainingData);

    $training = Training::where('slug', 'pelatihan-ai-coding-agent-batch-1')->first();
    expect($training)->not->toBeNull();
    $response->assertRedirect(route('admin.trainings.show', $training->id));

    expect($training->facilities)->toBeArray();
    expect($training->facilities)->toContain('E-Sertifikat 32 JP Terverifikasi Nasional');
    expect($training->facilities)->toContain('Voucher Cloud Hosting 6 Bulan');

    $detailResponse = $this->actingAs($this->admin)
        ->get(route('admin.trainings.show', $training->id));

    $detailResponse->assertOk()
        ->assertSee('Fasilitas &amp; Manfaat Peserta Pelatihan', false)
        ->assertSee('E-Sertifikat 32 JP Terverifikasi Nasional')
        ->assertSee('Voucher Cloud Hosting 6 Bulan');
});

