<?php

use App\Enums\ParticipantType;
use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
});

test('halaman register dapat diakses oleh tamu', function () {
    $response = $this->get('/register');

    $response->assertOk();
    $response->assertSee('Daftar Akun Akademi Pelatihan');
});

test('peserta baru dapat mendaftar dan akun tersimpan di database (AUTH-01)', function () {
    $response = $this->post('/register', [
        'name' => 'Ahmad Dahlan',
        'email' => 'ahmad.dahlan@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'participant_type' => 'Guru & Tenaga Pendidik',
        'institution' => 'SMAN 1 Yogyakarta',
        'phone' => '081234567899',
    ]);

    $response->assertRedirect('/login');

    $user = User::where('email', 'ahmad.dahlan@example.com')->first();

    expect($user)->not->toBeNull();
    expect($user->name)->toBe('Ahmad Dahlan');
    expect($user->role)->toBe(UserRole::Peserta);
    expect($user->participant_type)->toBe(ParticipantType::Guru);
    expect($user->is_active)->toBeTrue();
    expect($user->institution)->toBe('SMAN 1 Yogyakarta');
});

test('peserta yang baru mendaftar dapat login dengan kredensialnya', function () {
    $this->post('/register', [
        'name' => 'Siti Nurhaliza',
        'email' => 'siti@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'participant_type' => 'siswa',
        'institution' => 'Universitas Indonesia',
        'phone' => '08987654321',
    ])->assertRedirect('/login');

    $response = $this->post('/login', [
        'email' => 'siti@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/peserta');
    $this->assertAuthenticated();
});

test('pendaftaran dengan email yang sudah ada menghasilkan error validasi', function () {
    $response = $this->post('/register', [
        'name' => 'Duplikat Admin',
        'email' => 'admin@akademipelatihan.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'participant_type' => 'umum',
    ]);

    $response->assertSessionHasErrors('email');
});

test('pendaftaran dengan password konfirmasi tidak cocok ditolak', function () {
    $response = $this->post('/register', [
        'name' => 'Salah Password',
        'email' => 'salah@example.com',
        'password' => 'password123',
        'password_confirmation' => 'berbeda456',
        'participant_type' => 'umum',
    ]);

    $response->assertSessionHasErrors('password');
});
