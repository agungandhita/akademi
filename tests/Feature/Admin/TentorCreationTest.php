<?php

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();
});

test('admin dapat mengakses halaman form tambah tentor (ADM-03)', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('admin.tentor.create'));

    $response->assertOk()
        ->assertSee('Buat Akun Tentor Baru')
        ->assertSee('Foto Profil Instruktur / Tentor')
        ->assertSee('Nama Lengkap')
        ->assertSee('Bidang Keahlian');
});

test('admin berhasil membuat akun tentor baru beserta unggahan foto profil', function () {
    $avatarFile = UploadedFile::fake()->image('tentor-rian.jpg', 400, 400);

    $tentorData = [
        'name' => 'Dr. Rian Pratama, M.Kom',
        'email' => 'rian.pratama@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'phone' => '081298765432',
        'expertise' => 'Artificial Intelligence & Machine Learning',
        'bio' => 'Praktisi AI berpengalaman lebih dari 8 tahun di industri teknologi.',
        'avatar' => $avatarFile,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.tentor.store'), $tentorData);

    $response->assertRedirect(route('admin.users.index', ['role' => 'tentor']));

    $tentor = User::where('email', 'rian.pratama@example.com')->first();
    expect($tentor)->not->toBeNull();
    expect($tentor->role)->toBe(UserRole::Tentor);
    expect($tentor->is_active)->toBeTrue();
    expect($tentor->expertise)->toBe('Artificial Intelligence & Machine Learning');
    expect($tentor->phone)->toBe('081298765432');
    expect($tentor->avatar)->not->toBeNull();

    Storage::disk('public')->assertExists($tentor->avatar);
});

test('validasi pembuatan akun tentor gagal jika foto profil tidak diunggah', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.tentor.store'), [
            'name' => 'Tentor Tanpa Foto',
            'email' => 'tanpafoto@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // avatar tidak dikirimkan
        ]);

    $response->assertSessionHasErrors('avatar');
});

test('validasi pembuatan akun tentor gagal jika file yang diunggah bukan gambar', function () {
    $pdfFile = UploadedFile::fake()->create('dokumen.pdf', 500, 'application/pdf');

    $response = $this->actingAs($this->admin)
        ->post(route('admin.tentor.store'), [
            'name' => 'Tentor File PDF',
            'email' => 'tentor.pdf@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'avatar' => $pdfFile,
        ]);

    $response->assertSessionHasErrors('avatar');
});

test('validasi pembuatan akun tentor gagal jika email sudah digunakan', function () {
    User::create([
        'name' => 'Pengguna Lama',
        'email' => 'terdaftar@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Peserta,
    ]);

    $response = $this->actingAs($this->admin)
        ->post(route('admin.tentor.store'), [
            'name' => 'Tentor Baru',
            'email' => 'terdaftar@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'avatar' => UploadedFile::fake()->image('tentor.jpg'),
        ]);

    $response->assertSessionHasErrors('email');
});

test('validasi pembuatan akun tentor gagal jika password kurang dari 8 karakter', function () {
    $response = $this->actingAs($this->admin)
        ->post(route('admin.tentor.store'), [
            'name' => 'Tentor Baru',
            'email' => 'tentor.baru@example.com',
            'password' => 'pendek',
            'password_confirmation' => 'pendek',
            'avatar' => UploadedFile::fake()->image('tentor.jpg'),
        ]);

    $response->assertSessionHasErrors('password');
});
