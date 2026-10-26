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

test('tamu atau non-admin tidak dapat mengakses manajemen berita dan artikel (ADM-10)', function () {
    $response = $this->get(route('admin.posts.index'));
    $response->assertRedirect(route('login'));
});

test('admin dapat melihat daftar berita dan artikel (ADM-10)', function () {
    Post::create([
        'author_id' => $this->admin->id,
        'title' => 'Uji Coba Berita Nasional',
        'slug' => 'uji-coba-berita-nasional',
        'type' => PostType::Berita,
        'excerpt' => 'Ringkasan singkat berita nasional.',
        'content' => 'Isi lengkap berita nasional.',
        'status' => PostStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.posts.index'));

    $response->assertOk()
        ->assertSee('Manajemen Berita &amp; Artikel', false)
        ->assertSee('Uji Coba Berita Nasional');
});

test('admin dapat membuka halaman form tambah konten baru', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.posts.create'));

    $response->assertOk()
        ->assertSee('Tulis Berita / Artikel Baru');
});

test('admin dapat membuat konten berita baru dengan slug otomatis', function () {
    $postData = [
        'title' => 'Judul Berita Baru Akademi',
        'type' => 'berita',
        'excerpt' => 'Ini adalah ringkasan berita yang baru dibuat oleh admin.',
        'content' => 'Ini adalah materi konten artikel yang sangat lengkap dan berbobot.',
        'status' => 'published',
        'published_at' => now()->format('Y-m-d H:i:s'),
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.posts.store'), $postData);

    $response->assertRedirect(route('admin.posts.index'));

    $post = Post::where('slug', 'judul-berita-baru-akademi')->first();
    expect($post)->not->toBeNull();
    expect($post->title)->toBe('Judul Berita Baru Akademi');
    expect($post->type)->toBe(PostType::Berita);
    expect($post->status)->toBe(PostStatus::Published);
    expect($post->author_id)->toBe($this->admin->id);
});

test('admin dapat melihat halaman detail konten', function () {
    $post = Post::create([
        'author_id' => $this->admin->id,
        'title' => 'Post Untuk Dilihat',
        'slug' => 'post-untuk-dilihat',
        'type' => PostType::Artikel,
        'excerpt' => 'Ringkasan artikel.',
        'content' => 'Konten lengkap artikel.',
        'status' => PostStatus::Published,
        'published_at' => now(),
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.posts.show', $post->id));

    $response->assertOk()
        ->assertSee('Post Untuk Dilihat')
        ->assertSee('Ringkasan artikel.');
});

test('admin dapat memperbarui konten berita atau artikel', function () {
    $post = Post::create([
        'author_id' => $this->admin->id,
        'title' => 'Judul Lama',
        'slug' => 'judul-lama',
        'type' => PostType::Berita,
        'excerpt' => 'Ringkasan lama.',
        'content' => 'Konten lama.',
        'status' => PostStatus::Draft,
        'published_at' => null,
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.posts.update', $post->id), [
            'title' => 'Judul Baru Diperbarui',
            'type' => 'artikel',
            'excerpt' => 'Ringkasan yang sudah direvisi.',
            'content' => 'Konten yang sudah direvisi lengkap.',
            'status' => 'published',
            'published_at' => now()->format('Y-m-d H:i:s'),
        ]);

    $response->assertRedirect(route('admin.posts.index'));

    $fresh = $post->fresh();
    expect($fresh->title)->toBe('Judul Baru Diperbarui');
    expect($fresh->type)->toBe(PostType::Artikel);
    expect($fresh->status)->toBe(PostStatus::Published);
    expect($fresh->slug)->toBe('judul-baru-diperbarui');
});

test('admin dapat menghapus konten (soft delete)', function () {
    $post = Post::create([
        'author_id' => $this->admin->id,
        'title' => 'Post Untuk Dihapus',
        'slug' => 'post-untuk-dihapus',
        'type' => PostType::Berita,
        'excerpt' => 'Ringkasan.',
        'content' => 'Konten.',
        'status' => PostStatus::Draft,
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.posts.destroy', $post->id));

    $response->assertRedirect(route('admin.posts.index'));

    expect(Post::find($post->id))->toBeNull();
    expect(Post::withTrashed()->find($post->id))->not->toBeNull();
});
