<?php

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    // Seed admin default user
    $this->seed(AdminUserSeeder::class);
});

test('seeder admin berhasil memasukkan akun administrator default', function () {
    $admin = User::where('email', 'admin@akademipelatihan.com')->first();

    expect($admin)->not->toBeNull();
    expect($admin->role)->toBe(UserRole::Admin);
    expect($admin->is_active)->toBeTrue();
    expect($admin->isAdmin())->toBeTrue();
});

test('admin dapat melakukan login dengan kredensial yang valid dan dialihkan ke /admin', function () {
    $response = $this->post('/login', [
        'email' => 'admin@akademipelatihan.com',
        'password' => 'password',
    ]);

    $response->assertRedirect('/admin');
    $this->assertAuthenticated();
});

test('pengguna nonaktif tidak dapat melakukan login (AUTH-06)', function () {
    $inactiveUser = User::create([
        'name' => 'Akun Dinonaktifkan',
        'email' => 'nonaktif@example.com',
        'password' => Hash::make('password123'),
        'role' => UserRole::Peserta,
        'is_active' => false,
    ]);

    $response = $this->post('/login', [
        'email' => 'nonaktif@example.com',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});

test('tamu tidak terautentikasi dialihkan ke /login saat mengakses area dashboard', function () {
    $this->get('/admin')->assertRedirect('/login');
    $this->get('/tentor')->assertRedirect('/login');
    $this->get('/peserta')->assertRedirect('/login');
});

test('administrator memiliki hak akses ke /admin', function () {
    $admin = User::where('email', 'admin@akademipelatihan.com')->first();

    $this->actingAs($admin)
        ->get('/admin')
        ->assertOk()
        ->assertSee('Dashboard Manajemen Akademi Pelatihan');
});

test('peserta ditolak mengakses /admin dengan status 403 (role middleware)', function () {
    $peserta = User::create([
        'name' => 'Peserta Pelatihan',
        'email' => 'peserta@example.com',
        'password' => Hash::make('password123'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $this->actingAs($peserta)
        ->get('/admin')
        ->assertForbidden();
});

test('tentor dapat mengakses /tentor dan ditolak mengakses /admin', function () {
    $tentor = User::create([
        'name' => 'Instruktur Utama',
        'email' => 'tentor@example.com',
        'password' => Hash::make('password123'),
        'role' => UserRole::Tentor,
        'is_active' => true,
    ]);

    $this->actingAs($tentor)
        ->get('/tentor')
        ->assertOk()
        ->assertSee('Dashboard Tentor &amp; Instruktur', false);

    $this->actingAs($tentor)
        ->get('/admin')
        ->assertForbidden();
});

test('pengguna dapat melakukan logout dan sesi dihapus', function () {
    $admin = User::where('email', 'admin@akademipelatihan.com')->first();

    $this->actingAs($admin)
        ->post('/logout')
        ->assertRedirect('/login');

    $this->assertGuest();
});
