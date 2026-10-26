<?php

namespace Database\Seeders;

use App\Enums\EnrollmentStatus;
use App\Enums\ModuleStatus;
use App\Enums\ModuleType;
use App\Enums\ParticipantType;
use App\Enums\SessionType;
use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Enrollment;
use App\Models\Module;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\TrainingSession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class LiveUploadedDataSeeder extends Seeder
{
    /**
     * Jalankan seeder data live yang telah diunggah di sistem.
     * Menggunakan updateOrCreate agar aman dijalankan berkali-kali (idempotent).
     */
    public function run(): void
    {
        // 1. Kategori Pelatihan
        $category = TrainingCategory::updateOrCreate(
            ['slug' => 'pendidikan'],
            [
                'name' => 'pendidikan',
                'description' => 'oke',
            ]
        );

        // 2. Akun Administrator
        $admin = User::updateOrCreate(
            ['email' => 'admin@akademipelatihan.com'],
            [
                'name' => 'Administrator Akademi',
                'password' => '$2y$12$HY2FB78RLu7ywDawO2Fpp.DMiArM/z4a2v56jEffRcslMjqCAX0FO',
                'role' => UserRole::Admin,
                'institution' => 'Akademi Pelatihan Indonesia',
                'phone' => '081234567890',
                'bio' => 'Administrator pengelola platform Akademi Pelatihan Indonesia.',
                'expertise' => 'Sistem & Kurikulum',
                'is_active' => true,
                'email_verified_at' => Carbon::parse('2026-10-22 15:58:15'),
            ]
        );

        // 3. Akun Tentor / Instruktur
        $tentorSaminto = User::updateOrCreate(
            ['email' => 'saminto@gmail.com'],
            [
                'name' => 'Saminto, S.Sos., M.M',
                'password' => '$2y$12$fZvRK4/gx1E2d9LtjSBgje3sYvxaJn0cSdAm2oKSsPhYsDWhRJDry',
                'role' => UserRole::Tentor,
                'participant_type' => null,
                'phone' => '087851601089',
                'bio' => 'praktisi pendidikan dan trainer profesional yang berfokus pada pengembangan sumber daya manusia, neurosains pembelajaran, stimulasi kognitif anak, komunikasi edukatif, serta peningkatan mutu sekolah. Berbekal pendidikan Magister Manajemen dan berbagai sertifikasi profesional, beliau aktif berbagi pengetahuan melalui seminar, pelatihan, dan workshop untuk meningkatkan kompetensi pendidik serta mengoptimalkan potensi peserta didik.',
                'expertise' => 'Konsultan Pendidikan & Pengembangan Mutu Sekolah',
                'avatar' => 'avatars/mjcSCQVHVCSrWDK2Q6n6w5Ts2Sq7VioCLtEL62xR.png',
                'is_active' => true,
            ]
        );

        $tentorRasmian = User::updateOrCreate(
            ['email' => 'rasmian@gmail.com'],
            [
                'name' => 'Rasmian, S.Pd., M.Pd',
                'password' => '$2y$12$MB3S3Ue3soGuwQHRMJV4luoNx9nUys5JGwS5QcYG1mFBeZgUOLTXa',
                'role' => UserRole::Tentor,
                'participant_type' => null,
                'phone' => '082231719219',
                'bio' => 'Rasmian, S.Pd., M.Pd. adalah Pengawas Sekolah di Cabang Dinas Pendidikan Wilayah Kabupaten Lamongan. Berpengalaman lebih dari 30 tahun di dunia pendidikan, beliau aktif sebagai fasilitator, instruktur Guru Penggerak, konsultan pendidikan, serta penulis buku. Beliau berkomitmen untuk meningkatkan kualitas pendidikan dan mengembangkan profesionalisme guru melalui inovasi dan pendampingan berkelanjutan.',
                'expertise' => 'Coach bidang pendidikan',
                'avatar' => 'avatars/OLYuv9Os210PhUqSwUV5FnY3Olo7PjSP8DAmPlra.jpg',
                'is_active' => true,
            ]
        );

        // 4. Akun Peserta Terdaftar
        $pesertaSatria = User::updateOrCreate(
            ['email' => 'satriapinandhita80@gmail.com'],
            [
                'name' => 'M Satria Pinandhita',
                'password' => '$2y$12$XEMoKPW9VnJLZPbnwmL/YuTaYpR7I6LufSCsx.2CJ/ySwhtPCl6r6',
                'role' => UserRole::Peserta,
                'participant_type' => ParticipantType::Guru,
                'institution' => 'SMP Wachid Hasjim Maduran',
                'phone' => '082231719219',
                'is_active' => true,
            ]
        );

        $pesertaAgung = User::updateOrCreate(
            ['email' => 'agungandhita@gmail.com'],
            [
                'name' => 'agung andhita',
                'password' => '$2y$12$KL1IrAEsonWzogAvQI1/Ze.Dy3w2ltAX1u.9WJjfWlkJ24WfmeEA6',
                'role' => UserRole::Peserta,
                'participant_type' => ParticipantType::Praktisi,
                'institution' => 'Wahas',
                'phone' => '082231719219',
                'is_active' => true,
            ]
        );

        // 5. Data Pelatihan
        $training = Training::updateOrCreate(
            ['slug' => 'balok-pintar-anak-cerdas-melejitkan-otak-dan-logika-anak-lewat-permainan-sederhana'],
            [
                'category_id' => $category->id,
                'title' => 'Balok Pintar Anak Cerdas (Melejitkan Otak dan Logika Anak Lewat Permainan Sederhana)',
                'description' => 'Program pengembangan kecerdasan anak melalui permainan edukatif Balok Pintar Anak Cerdas. Kegiatan ini dirancang untuk melatih kemampuan berpikir logis, kreativitas, konsentrasi, pemecahan masalah, dan keterampilan motorik anak melalui permainan balok sederhana yang menyenangkan. Melalui program ini, anak diharapkan mampu mengembangkan potensi diri, meningkatkan daya pikir, serta membangun fondasi kecerdasan sejak dini dengan cara belajar sambil bermain.',
                'facilities' => [
                    'Modul Ajar & Bahan Tayang Digital Lengkap',
                    'Grup Komunitas Bimbingan WhatsApp / Telegram',
                    'E-Sertifikat 16 JP Terverifikasi Nasional',
                    'Handout',
                    'Snack',
                ],
                'thumbnail' => 'trainings/thumbnails/VazNgIi0I9MUxkPkTGDeUSwfmso9LMjxdeFG8ygQ.jpg',
                'audience' => TrainingAudience::Guru,
                'mode' => TrainingMode::Offline,
                'status' => TrainingStatus::Published,
                'is_free' => true,
                'price' => 0.00,
                'quota' => 150,
                'registration_start' => Carbon::parse('2026-10-25'),
                'registration_end' => Carbon::parse('2026-11-12'),
                'start_date' => Carbon::parse('2026-11-15'),
                'end_date' => Carbon::parse('2026-11-15'),
                'location' => 'Yayasan Pondok Pesantren Aisyatul Wachidah, Desa Turi, Kecamatan Maduran, Kabupaten Lamongan',
                'meeting_url' => null,
                'created_by' => $admin->id,
            ]
        );

        // 6. Penugasan Instruktur (Pivot)
        $training->instructors()->syncWithoutDetaching([
            $tentorSaminto->id,
            $tentorRasmian->id,
        ]);

        // 7. Sesi Pelatihan
        TrainingSession::updateOrCreate(
            [
                'training_id' => $training->id,
                'title' => 'Implentasi Balok Pintar Cerdas',
            ],
            [
                'session_type' => SessionType::Offline,
                'session_date' => Carbon::parse('2026-11-15'),
                'start_time' => '08:00:00',
                'end_time' => '15:00:00',
                'location' => 'Yayasan Pondok Pesantren Aisyatul Wachidah, Desa Turi, Kecamatan Maduran, Kabupaten Lamongan',
                'meeting_url' => null,
                'notes' => null,
            ]
        );

        // 8. Modul Materi Pembelajaran
        Module::updateOrCreate(
            [
                'training_id' => $training->id,
                'title' => 'ok',
            ],
            [
                'created_by' => $tentorRasmian->id,
                'description' => 'ok',
                'type' => ModuleType::Pdf,
                'content' => null,
                'file_path' => 'modules/VTSxUG9aEWPmyblsuvufPDAtCy33Be4ClFSoZmcd.pdf',
                'url' => null,
                'sort_order' => 1,
                'status' => ModuleStatus::Published,
            ]
        );

        // 9. Pendaftaran Peserta (Enrollments)
        Enrollment::updateOrCreate(
            [
                'user_id' => $pesertaSatria->id,
                'training_id' => $training->id,
            ],
            [
                'status' => EnrollmentStatus::Registered,
                'enrolled_at' => Carbon::parse('2026-10-26 17:08:01'),
            ]
        );

        Enrollment::updateOrCreate(
            [
                'user_id' => $pesertaAgung->id,
                'training_id' => $training->id,
            ],
            [
                'status' => EnrollmentStatus::Registered,
                'enrolled_at' => Carbon::parse('2026-10-26 18:48:21'),
            ]
        );
    }
}
