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
        Schema::table('trainings', function (Blueprint $table) {
            $table->string('certificate_number')->nullable()->after('whatsapp_group_link');
            $table->string('certificate_date')->nullable()->after('certificate_number');
            $table->string('certificate_signer_left_title')->nullable()->default('Ketua Pelaksana')->after('certificate_date');
            $table->string('certificate_signer_left_name')->nullable()->after('certificate_signer_left_title');
            $table->string('certificate_signer_left_nip')->nullable()->after('certificate_signer_left_name');
            $table->string('certificate_signer_left_signature')->nullable()->after('certificate_signer_left_nip');
            $table->string('certificate_signer_right_title')->nullable()->default('Pimpinan Akademi Pelatihan')->after('certificate_signer_left_signature');
            $table->string('certificate_signer_right_name')->nullable()->after('certificate_signer_right_title');
            $table->string('certificate_signer_right_nip')->nullable()->after('certificate_signer_right_name');
            $table->string('certificate_signer_right_signature')->nullable()->after('certificate_signer_right_nip');
            $table->boolean('is_certificate_enabled')->default(false)->after('certificate_signer_right_signature');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->dropColumn([
                'certificate_number',
                'certificate_date',
                'certificate_signer_left_title',
                'certificate_signer_left_name',
                'certificate_signer_left_nip',
                'certificate_signer_left_signature',
                'certificate_signer_right_title',
                'certificate_signer_right_name',
                'certificate_signer_right_nip',
                'certificate_signer_right_signature',
                'is_certificate_enabled',
            ]);
        });
    }
};

