<?php

use App\Enums\ModuleStatus;
use App\Enums\ModuleType;
use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Module;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->seed(AdminUserSeeder::class);

    $this->admin = User::where('email', 'admin@akademipelatihan.com')->first();

    $this->tentor = User::create([
        'name' => 'Instruktur Handal',
        'email' => 'tentor.handal@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Tentor,
        'expertise' => 'Digital Pedagogy & STEM',
        'is_active' => true,
    ]);

    $this->category = TrainingCategory::create([
        'name' => 'Teknologi Pendidikan',
        'slug' => 'teknologi-pendidikan',
    ]);

    $this->training = Training::create([
        'category_id' => $this->category->id,
        'title' => 'Pemanfaatan AI untuk Guru Abad 21',
        'slug' => 'pemanfaatan-ai-untuk-guru-abad-21',
        'description' => 'Pelatihan intensif integrasi AI di ruang kelas.',
        'mode' => TrainingMode::Online,
        'audience' => TrainingAudience::Guru,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'created_by' => $this->admin->id,
    ]);

    // Tugaskan pelatihan ke tentor
    $this->training->instructors()->attach($this->tentor->id);
});

test('tentor dapat mengakses dashboard instruktur (TNT-01)', function () {
    $response = $this->actingAs($this->tentor)->get(route('tentor'));

    $response->assertOk()
        ->assertSee('Dashboard Tentor &amp; Instruktur', false)
        ->assertSee('Pemanfaatan AI untuk Guru Abad 21');
});

test('tentor hanya melihat pelatihan yang ditugaskan kepadanya (TNT-02)', function () {
    // Pelatihan lain yang tidak ditugaskan ke tentor
    Training::create([
        'category_id' => $this->category->id,
        'title' => 'Pelatihan Khusus Lain',
        'slug' => 'pelatihan-khusus-lain',
        'description' => 'Bukan untuk tentor ini.',
        'mode' => TrainingMode::Online,
        'audience' => TrainingAudience::Umum,
        'status' => TrainingStatus::Published,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'created_by' => $this->admin->id,
    ]);

    $response = $this->actingAs($this->tentor)->get(route('tentor.trainings'));

    $response->assertOk()
        ->assertSee('Pemanfaatan AI untuk Guru Abad 21')
        ->assertDontSee('Pelatihan Khusus Lain');
});

test('tentor dapat menambahkan modul materi baru pada pelatihan published (TNT-03 s.d. TNT-05)', function () {
    $response = $this->actingAs($this->tentor)->post(route('tentor.modules.store'), [
        'training_id' => $this->training->id,
        'title' => 'Pengenalan Model Prompt AI',
        'description' => 'Dasar perancangan prompt interaktif untuk guru.',
        'type' => ModuleType::Text->value,
        'content' => 'Ini adalah konten lengkap materi perancangan prompt.',
        'sort_order' => 1,
        'status' => ModuleStatus::Published->value,
    ]);

    $response->assertRedirect(route('tentor.modules.index', ['training_id' => $this->training->id]));

    $module = Module::where('title', 'Pengenalan Model Prompt AI')->first();
    expect($module)->not->toBeNull();
    expect($module->training_id)->toBe($this->training->id);
    expect($module->created_by)->toBe($this->tentor->id);
    expect($module->type)->toBe(ModuleType::Text);
    expect($module->status)->toBe(ModuleStatus::Published);
});

test('tentor dapat mengunggah modul bertipe berkas PDF (TNT-04)', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('panduan_ai.pdf', 500, 'application/pdf');

    $response = $this->actingAs($this->tentor)->post(route('tentor.modules.store'), [
        'training_id' => $this->training->id,
        'title' => 'E-Book Panduan AI',
        'type' => ModuleType::Pdf->value,
        'file' => $file,
        'sort_order' => 2,
        'status' => ModuleStatus::Published->value,
    ]);

    $response->assertRedirect();

    $module = Module::where('title', 'E-Book Panduan AI')->first();
    expect($module)->not->toBeNull();
    expect($module->type)->toBe(ModuleType::Pdf);
    expect($module->file_path)->not->toBeNull();
    Storage::disk('public')->assertExists($module->file_path);
});

test('tentor tidak dapat menambah modul pada pelatihan yang berstatus draft (TNT-03)', function () {
    $draftTraining = Training::create([
        'category_id' => $this->category->id,
        'title' => 'Pelatihan Masih Draft',
        'slug' => 'pelatihan-masih-draft',
        'description' => 'Belum terbit.',
        'mode' => TrainingMode::Online,
        'audience' => TrainingAudience::Guru,
        'status' => TrainingStatus::Draft,
        'start_date' => now()->addDays(2)->toDateString(),
        'end_date' => now()->addDays(4)->toDateString(),
        'created_by' => $this->admin->id,
    ]);
    $draftTraining->instructors()->attach($this->tentor->id);

    $response = $this->actingAs($this->tentor)->post(route('tentor.modules.store'), [
        'training_id' => $draftTraining->id,
        'title' => 'Modul Dilarang',
        'type' => ModuleType::Text->value,
        'content' => 'Konten...',
        'sort_order' => 1,
        'status' => ModuleStatus::Published->value,
    ]);

    $response->assertSessionHasErrors('training_id');
    expect(Module::where('title', 'Modul Dilarang')->exists())->toBeFalse();
});

test('tentor lain tidak dapat mengubah modul dari pelatihan yang bukan penugasannya', function () {
    $tentorLain = User::create([
        'name' => 'Tentor Lain',
        'email' => 'tentor.lain@example.com',
        'password' => bcrypt('password123'),
        'role' => UserRole::Tentor,
        'is_active' => true,
    ]);

    $module = Module::create([
        'training_id' => $this->training->id,
        'created_by' => $this->tentor->id,
        'title' => 'Modul Eksklusif',
        'type' => ModuleType::Text,
        'content' => 'Isi',
        'sort_order' => 1,
        'status' => ModuleStatus::Published,
    ]);

    $response = $this->actingAs($tentorLain)->put(route('tentor.modules.update', $module->id), [
        'title' => 'Modul Diretas',
        'type' => ModuleType::Text->value,
        'content' => 'Diubah',
        'sort_order' => 1,
        'status' => ModuleStatus::Published->value,
    ]);

    $response->assertForbidden();
});

test('tentor dapat memperbarui profil dan bidang keahliannya (TNT-07)', function () {
    $response = $this->actingAs($this->tentor)->put(route('tentor.profile.update'), [
        'name' => 'Instruktur Handal, M.Kom',
        'email' => 'tentor.handal@example.com',
        'phone' => '081234567899',
        'institution' => 'Pusat Inovasi Guru',
        'expertise' => 'Artificial Intelligence & Data Literacy',
        'bio' => 'Pengajar bersertifikasi internasional Google Certified Educator.',
    ]);

    $response->assertRedirect(route('tentor.profile'));

    $freshTentor = $this->tentor->fresh();
    expect($freshTentor->name)->toBe('Instruktur Handal, M.Kom');
    expect($freshTentor->institution)->toBe('Pusat Inovasi Guru');
    expect($freshTentor->expertise)->toBe('Artificial Intelligence & Data Literacy');
});
