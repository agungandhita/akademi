<?php

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
        'name' => 'Pengembangan Web',
        'slug' => 'pengembangan-web',
    ]);

    $this->peserta = User::create([
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);
});

test('admin dapat membuat pelatihan baru dengan tautan grup whatsapp', function () {
    $waLink = 'https://chat.whatsapp.com/LcRV6Bi5pPIJSqyWX8POJM';

    $response = $this->actingAs($this->admin)->post(route('admin.trainings.store'), [
        'category_id' => $this->category->id,
        'title' => 'Pelatihan AI untuk Pengajar',
        'description' => 'Deskripsi lengkap pelatihan penggunaan AI.',
        'audience' => TrainingAudience::Guru->value,
        'mode' => TrainingMode::Online->value,
        'status' => TrainingStatus::Published->value,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(5)->toDateString(),
        'meeting_url' => 'https://meet.google.com/abc-defg-hij',
        'whatsapp_group_link' => $waLink,
        'is_free' => 1,
    ]);

    $response->assertRedirect();
    $training = Training::where('title', 'Pelatihan AI untuk Pengajar')->first();
    expect($training)->not->toBeNull();
    expect($training->whatsapp_group_link)->toBe($waLink);
});

test('admin dapat memperbarui tautan grup whatsapp pada pelatihan', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Flutter Mobile',
        'slug' => 'pelatihan-flutter-mobile',
        'description' => 'Membangun aplikasi mobile.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(6)->toDateString(),
        'meeting_url' => 'https://zoom.us/j/123456789',
        'whatsapp_group_link' => 'https://chat.whatsapp.com/oldlink123',
        'is_free' => true,
        'price' => 0,
    ]);

    $newWaLink = 'https://chat.whatsapp.com/newlink456';

    $response = $this->actingAs($this->admin)->put(route('admin.trainings.update', $training->id), [
        'category_id' => $this->category->id,
        'title' => 'Pelatihan Flutter Mobile Updated',
        'description' => 'Membangun aplikasi mobile.',
        'audience' => TrainingAudience::Umum->value,
        'mode' => TrainingMode::Online->value,
        'status' => TrainingStatus::Published->value,
        'start_date' => now()->addDays(3)->toDateString(),
        'end_date' => now()->addDays(6)->toDateString(),
        'meeting_url' => 'https://zoom.us/j/123456789',
        'whatsapp_group_link' => $newWaLink,
        'is_free' => 1,
    ]);

    $response->assertRedirect();
    $training->refresh();
    expect($training->whatsapp_group_link)->toBe($newWaLink);
});

test('pengunjung atau user yang belum terdaftar tidak dapat melihat tautan grup whatsapp', function () {
    $waLink = 'https://chat.whatsapp.com/SECRET_GROUP_LINK_123';

    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Keamanan Siber',
        'slug' => 'pelatihan-keamanan-siber',
        'description' => 'Kursus dasar cyber security.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'meeting_url' => 'https://zoom.us/j/999888777',
        'whatsapp_group_link' => $waLink,
        'is_free' => true,
        'price' => 0,
    ]);

    // Pengunjung belum login
    $responseGuest = $this->get(route('agenda.detail', $training->slug));
    $responseGuest->assertOk();
    $responseGuest->assertDontSee($waLink);

    // Pengguna login sebagai peserta tapi belum mendaftar
    $responsePeserta = $this->actingAs($this->peserta)->get(route('agenda.detail', $training->slug));
    $responsePeserta->assertOk();
    $responsePeserta->assertDontSee($waLink);
});

test('peserta yang berhasil mendaftar menerima popup wa dan dapat melihat link grup whatsapp', function () {
    $waLink = 'https://chat.whatsapp.com/PUBLIC_FOR_ENROLLED_999';

    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Desain UI/UX',
        'slug' => 'pelatihan-desain-ui-ux',
        'description' => 'Belajar desain interface.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'meeting_url' => 'https://zoom.us/j/999888777',
        'whatsapp_group_link' => $waLink,
        'is_free' => true,
        'price' => 0,
    ]);

    // Pendaftaran oleh peserta
    $enrollResponse = $this->actingAs($this->peserta)->post(route('agenda.enroll', $training->slug));
    $enrollResponse->assertRedirect(route('agenda.detail', $training->slug));
    $enrollResponse->assertSessionHas('enrolled_whatsapp_popup', true);

    // Setelah terdaftar, halaman detail menampilkan tautan grup WhatsApp
    $detailResponse = $this->actingAs($this->peserta)->get(route('agenda.detail', $training->slug));
    $detailResponse->assertOk();
    $detailResponse->assertSee($waLink);
    $detailResponse->assertSee('Gabung Grup WhatsApp Pelatihan');

    // Di halaman Pelatihan Saya (peserta.trainings) juga menampilkan tombol grup WhatsApp
    $trainingsListResponse = $this->actingAs($this->peserta)->get(route('peserta.trainings'));
    $trainingsListResponse->assertOk();
    $trainingsListResponse->assertSee($waLink);
    $trainingsListResponse->assertSee('Grup WA');

    // Di halaman Ruang Belajar (peserta.trainings.show) juga menampilkan card grup WhatsApp
    $roomResponse = $this->actingAs($this->peserta)->get(route('peserta.trainings.show', $training->id));
    $roomResponse->assertOk();
    $roomResponse->assertSee($waLink);
    $roomResponse->assertSee('Grup WhatsApp Pelatihan');
});

test('halaman agenda detail menampilkan panduan langkah pendaftaran dan tombol bagikan ke whatsapp', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan Public Speaking',
        'slug' => 'pelatihan-public-speaking',
        'description' => 'Meningkatkan rasa percaya diri berbicara di depan publik.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://zoom.us/j/123456',
        'is_free' => true,
        'price' => 0,
    ]);

    $response = $this->get(route('agenda.detail', $training->slug));
    $response->assertOk()
        ->assertSee('Panduan Langkah Pendaftaran')
        ->assertSee('Masuk / Registrasi Akun')
        ->assertSee('Gabung Grup WhatsApp Resmi')
        ->assertSee('Bagikan ke WhatsApp');
});

test('admin dapat melihat calon peserta yang belum mendaftar dan tab ajakan daftar pada modal wa blast', function () {
    $training = Training::create([
        'category_id' => $this->category->id,
        'created_by' => $this->admin->id,
        'title' => 'Pelatihan DevOps Modern',
        'slug' => 'pelatihan-devops-modern',
        'description' => 'Mempelajari CI/CD dan Docker.',
        'audience' => TrainingAudience::Umum,
        'mode' => TrainingMode::Online,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(5)->toDateString(),
        'end_date' => now()->addDays(7)->toDateString(),
        'meeting_url' => 'https://zoom.us/j/123456',
        'is_free' => true,
        'price' => 0,
    ]);

    // Buat calon peserta dengan nomor telepon yang belum mendaftar
    $calon = User::create([
        'name' => 'Siti Aisyah',
        'email' => 'siti@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
        'phone' => '081298765432',
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.trainings.participants', $training->id));
    $response->assertOk()
        ->assertSee('Calon Peserta (Ajakan Daftar)')
        ->assertSee('Teks Siap Sebar (Grup Umum)')
        ->assertSee('Siti Aisyah')
        ->assertSee('081298765432')
        ->assertSee('Panduan Langkah Mudah Pendaftaran');
});
