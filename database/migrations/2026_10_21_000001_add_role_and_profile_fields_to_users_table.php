<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('peserta')->after('password');
            $table->string('participant_type')->nullable()->after('role');
            $table->string('institution')->nullable()->after('participant_type');
            $table->string('phone')->nullable()->after('institution');
            $table->text('bio')->nullable()->after('phone');
            $table->string('expertise')->nullable()->after('bio');
            $table->string('avatar')->nullable()->after('expertise');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'role',
                'participant_type',
                'institution',
                'phone',
                'bio',
                'expertise',
                'avatar',
                'is_active',
            ]);
        });
    }
};
