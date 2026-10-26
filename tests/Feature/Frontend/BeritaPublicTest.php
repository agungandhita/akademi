<?php

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();
});

test('halaman berita menampilkan pesan kosong jika admin belum menerbitkan postingan', function () {
    Post::query()->forceDelete();

    $response = $this->get(route('berita'));

    $response->assertOk()
        ->assertSee('Belum Ada Publikasi')
        ->assertSee('Saat ini belum ada berita atau artikel yang diterbitkan oleh administrator.');
});

test('beranda tidak menampilkan seksi berita jika belum ada inputan berita terbit dari admin', function () {
    Post::query()->forceDelete();

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertDontSee('id="berita-section"', false);
});

test('konten yang diterbitkan admin tampil di halaman publik berita dan beranda', function () {
    $post = Post::create([
        'author_id' => $this->admin->id,
        'title' => 'Inovasi Pembelajaran Digital 2026',
        'slug' => 'inovasi-pembelajaran-digital-2026',
        'type' => PostType::Berita,
        'excerpt' => 'Kajian kurikulum digital baru terakreditasi.',
        'content' => 'Isi lengkap artikel inovasi pembelajaran digital.',
        'status' => PostStatus::Published,
        'published_at' => now(),
    ]);

    // Halaman daftar berita
    $responseBerita = $this->get(route('berita'));
    $responseBerita->assertOk()
        ->assertSee('Inovasi Pembelajaran Digital 2026')
        ->assertSee('Kajian kurikulum digital baru terakreditasi.');

    // Halaman beranda
    $responseHome = $this->get(route('home'));
    $responseHome->assertOk()
        ->assertSee('id="berita-section"', false)
        ->assertSee('Inovasi Pembelajaran Digital 2026');

    // Halaman detail
    $responseDetail = $this->get(route('berita.detail', $post->slug));
    $responseDetail->assertOk()
        ->assertSee('Inovasi Pembelajaran Digital 2026')
        ->assertSee('Isi lengkap artikel inovasi pembelajaran digital.');
});

test('postingan draft tidak tampil di publik dan detail menghasilkan 404', function () {
    $draft = Post::create([
        'author_id' => $this->admin->id,
        'title' => 'Postingan Masih Konsep',
        'slug' => 'postingan-masih-konsep',
        'type' => PostType::Artikel,
        'excerpt' => 'Hanya admin yang tahu.',
        'content' => 'Rahasia redaksi.',
        'status' => PostStatus::Draft,
        'published_at' => null,
    ]);

    $responseBerita = $this->get(route('berita'));
    $responseBerita->assertDontSee('Postingan Masih Konsep');

    $responseDetail = $this->get(route('berita.detail', $draft->slug));
    $responseDetail->assertNotFound();
});
