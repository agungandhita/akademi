<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@akademipelatihan.com'],
            [
                'name' => 'Administrator Akademi',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'participant_type' => null,
                'institution' => 'Akademi Pelatihan Indonesia',
                'phone' => '081234567890',
                'bio' => 'Administrator pengelola platform Akademi Pelatihan Indonesia.',
                'expertise' => 'Sistem & Kurikulum',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
