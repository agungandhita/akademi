<?php

use App\Enums\ParticipantType;
use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();
});

test('admin dapat melihat daftar pengguna (ADM-02)', function () {
    $user1 = User::create([
        'name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index'));

    $response->assertOk()
        ->assertSee('Manajemen Pengguna')
        ->assertSee('Budi Santoso')
        ->assertSee('budi@example.com');
});

test('admin dapat mencari pengguna berdasarkan nama atau email', function () {
    User::create([
        'name' => 'Siti Nurhaliza',
        'email' => 'siti@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
    ]);

    User::create([
        'name' => 'Ahmad Dahlan',
        'email' => 'ahmad@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index', ['search' => 'Siti']));

    $response->assertOk()
        ->assertSee('Siti Nurhaliza')
        ->assertDontSee('Ahmad Dahlan');
});

test('admin dapat menyaring pengguna berdasarkan role', function () {
    User::create([
        'name' => 'Tentor Hebat',
        'email' => 'tentorhebat@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Tentor,
    ]);

    User::create([
        'name' => 'Bambang Peserta Baru',
        'email' => 'pesertabaru@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.index', ['role' => 'tentor']));

    $response->assertOk()
        ->assertSee('Tentor Hebat')
        ->assertDontSee('Bambang Peserta Baru');
});

test('admin dapat mengaktifkan dan menonaktifkan akun pengguna (toggle active)', function () {
    $user = User::create([
        'name' => 'Target User',
        'email' => 'target@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    // Nonaktifkan
    $response = $this->actingAs($this->admin)
        ->patch(route('admin.users.toggle-active', $user->id));

    $response->assertRedirect();
    expect($user->fresh()->is_active)->toBeFalse();

    // Aktifkan kembali
    $this->actingAs($this->admin)
        ->patch(route('admin.users.toggle-active', $user->id));

    expect($user->fresh()->is_active)->toBeTrue();
});

test('admin dapat memperbarui data pengguna', function () {
    $user = User::create([
        'name' => 'User Lama',
        'email' => 'userlama@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.users.update', $user->id), [
            'name' => 'User Terupdate',
            'email' => 'userlama@example.com',
            'phone' => '081234567890',
            'institution' => 'SMK Negeri 1 Surabaya',
            'participant_type' => ParticipantType::Guru->value,
            'is_active' => true,
        ]);

    $response->assertRedirect(route('admin.users.index'));

    $freshUser = $user->fresh();
    expect($freshUser->name)->toBe('User Terupdate');
    expect($freshUser->institution)->toBe('SMK Negeri 1 Surabaya');
    expect($freshUser->participant_type)->toBe(ParticipantType::Guru);
});

test('admin dapat menghapus akun pengguna (soft delete)', function () {
    $user = User::create([
        'name' => 'User Dihapus',
        'email' => 'delete@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.users.destroy', $user->id));

    $response->assertRedirect(route('admin.users.index'));

    expect($user->fresh()->trashed())->toBeTrue();
    $this->assertSoftDeleted('users', ['id' => $user->id]);
});

test('admin dapat melihat halaman detail pengguna (show user detail)', function () {
    $tentor = User::create([
        'name' => 'Prof. Budi Raharjo',
        'email' => 'budi.raharjo@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Tentor,
        'institution' => 'Institut Teknologi Bandung',
        'phone' => '081234567899',
        'expertise' => 'Cyber Security & Cryptography',
        'bio' => 'Dosen dan praktisi keamanan siber terkemuka.',
        'is_active' => true,
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.users.show', $tentor->id));

    $response->assertOk()
        ->assertSee('Prof. Budi Raharjo')
        ->assertSee('budi.raharjo@example.com')
        ->assertSee('Institut Teknologi Bandung')
        ->assertSee('Cyber Security &amp; Cryptography', false)
        ->assertSee('Dosen dan praktisi keamanan siber terkemuka.')
        ->assertSee('Informasi Kontak &amp; Akun', false);
});

test('peserta tidak memiliki izin untuk melihat detail pengguna lain (403)', function () {
    $peserta = User::create([
        'name' => 'Peserta Biasa',
        'email' => 'pesertabiasa@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $targetUser = User::create([
        'name' => 'Target User',
        'email' => 'targetuser@example.com',
        'password' => bcrypt('password'),
        'role' => UserRole::Peserta,
        'is_active' => true,
    ]);

    $this->actingAs($peserta)
        ->get(route('admin.users.show', $targetUser->id))
        ->assertForbidden();
});
