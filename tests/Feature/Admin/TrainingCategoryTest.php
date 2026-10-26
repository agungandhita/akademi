<?php

use App\Models\TrainingCategory;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);
    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();
});

test('admin dapat melihat daftar kategori pelatihan (ADM-04)', function () {
    TrainingCategory::create([
        'name' => 'Data Science & Analytics',
        'slug' => 'data-science-analytics',
        'description' => 'Pelatihan pengolahan data dan analitik bisnis.',
    ]);

    $response = $this->actingAs($this->admin)
        ->get(route('admin.categories.index'));

    $response->assertOk()
        ->assertSee('Kategori Pelatihan')
        ->assertSee('Data Science &amp; Analytics', false);
});

test('admin dapat membuat kategori pelatihan baru dengan auto slug', function () {
    $categoryData = [
        'name' => 'Pemrograman Web Modern',
        'description' => 'Kategori untuk pelatihan pengembangan web terkini.',
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('admin.categories.store'), $categoryData);

    $response->assertRedirect(route('admin.categories.index'));

    $category = TrainingCategory::where('slug', 'pemrograman-web-modern')->first();
    expect($category)->not->toBeNull();
    expect($category->name)->toBe('Pemrograman Web Modern');
    expect($category->description)->toBe('Kategori untuk pelatihan pengembangan web terkini.');
});

test('admin dapat mengubah kategori pelatihan', function () {
    $category = TrainingCategory::create([
        'name' => 'Kategori Awal',
        'slug' => 'kategori-awal',
        'description' => 'Deskripsi awal.',
    ]);

    $response = $this->actingAs($this->admin)
        ->put(route('admin.categories.update', $category->id), [
            'name' => 'Kategori Diperbarui',
            'slug' => 'kategori-diperbarui',
            'description' => 'Deskripsi yang telah disempurnakan.',
        ]);

    $response->assertRedirect(route('admin.categories.index'));

    $freshCategory = $category->fresh();
    expect($freshCategory->name)->toBe('Kategori Diperbarui');
    expect($freshCategory->slug)->toBe('kategori-diperbarui');
});

test('admin dapat menghapus kategori pelatihan', function () {
    $category = TrainingCategory::create([
        'name' => 'Kategori Dihapus',
        'slug' => 'kategori-dihapus',
    ]);

    $response = $this->actingAs($this->admin)
        ->delete(route('admin.categories.destroy', $category->id));

    $response->assertRedirect(route('admin.categories.index'));

    expect($category->fresh()->trashed())->toBeTrue();
    $this->assertSoftDeleted('training_categories', ['id' => $category->id]);
});
