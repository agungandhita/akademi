<?php

namespace Database\Seeders;

use App\Enums\SessionType;
use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use App\Enums\UserRole;
use App\Models\Training;
use App\Models\TrainingCategory;
use App\Models\TrainingSession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrainingAgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Dapatkan atau Buat Admin Pembuat
        $admin = User::firstOrCreate(
            ['email' => 'admin@akademipelatihan.com'],
            [
                'name' => 'Administrator Akademi',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'institution' => 'Akademi Pelatihan Indonesia',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Buat Kategori Pelatihan Beragam
        $categories = [
            'pedagogik' => TrainingCategory::firstOrCreate(
                ['slug' => 'pedagogik-kurikulum-guru'],
                ['name' => 'Pedagogik & Kurikulum Guru', 'description' => 'Pelatihan kompetensi mengajar, modul ajar kurikulum merdeka, dan asesmen digital.']
            ),
            'teknologi' => TrainingCategory::firstOrCreate(
                ['slug' => 'teknologi-koding'],
                ['name' => 'Teknologi & Koding', 'description' => 'Pengembangan perangkat lunak, web modern, AI, dan mikrokontroler IoT.']
            ),
            'vokasi' => TrainingCategory::firstOrCreate(
                ['slug' => 'vokasi-teknik-industri'],
                ['name' => 'Vokasi & Teknik Industri', 'description' => 'Keterampilan teknik manufaktur, otomasi industri, PLC, dan pengelasan standar SKKNI.']
            ),
            'desain' => TrainingCategory::firstOrCreate(
                ['slug' => 'desain-grafis-multimedia'],
                ['name' => 'Desain Grafis & Multimedia', 'description' => 'Desain antarmuka UI/UX Figma, creative asset, dan multimedia edukasi.']
            ),
            'bisnis' => TrainingCategory::firstOrCreate(
                ['slug' => 'bisnis-digital-marketing'],
                ['name' => 'Bisnis Digital & Marketing', 'description' => 'Optimasi iklan berbayar, digital marketing funnel, dan manajemen finansial praktis.']
            ),
            'leadership' => TrainingCategory::firstOrCreate(
                ['slug' => 'kepemimpinan-public-speaking'],
                ['name' => 'Kepemimpinan & Public Speaking', 'description' => 'Penguasaan panggung, retorika vokal persuasif, dan kepemimpinan visioner.']
            ),
        ];

        // 3. Buat Tentor/Instruktur Pengampu dengan Foto Avatar & Keahlian
        $tentor1 = User::updateOrCreate(
            ['email' => 'hendra.gunawan@akademipelatihan.com'],
            [
                'name' => 'Dr. Hendra Gunawan, M.Pd.',
                'password' => Hash::make('password123'),
                'role' => UserRole::Tentor,
                'phone' => '081234567801',
                'institution' => 'Pusat Kurikulum & Pembelajaran Mandiri',
                'expertise' => 'Pedagogik & GenAI Edukasi',
                'bio' => 'Konsultan kurikulum nasional dengan pengalaman 15 tahun mendampingi ribuan guru mengadopsi teknologi digital di sekolah.',
                'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=400&q=80',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $tentor2 = User::updateOrCreate(
            ['email' => 'rizky.ramadhan@akademipelatihan.com'],
            [
                'name' => 'Rizky Ramadhan, S.Kom., M.T.',
                'password' => Hash::make('password123'),
                'role' => UserRole::Tentor,
                'phone' => '081234567802',
                'institution' => 'Tech Nusantara Labs',
                'expertise' => 'Fullstack Laravel & Cloud Architecture',
                'bio' => 'Senior Lead Software Architect yang aktif berkontribusi pada open source dan membimbing talenta pengembang web modern.',
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=400&q=80',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $tentor3 = User::updateOrCreate(
            ['email' => 'budi.santoso@akademipelatihan.com'],
            [
                'name' => 'Budi Santoso, S.T., M.Eng.',
                'password' => Hash::make('password123'),
                'role' => UserRole::Tentor,
                'phone' => '081234567803',
                'institution' => 'Balai Otomasi & Manufaktur Industri',
                'expertise' => 'PLC Automation & Industrial Robotics',
                'bio' => 'Asesor tersertifikasi BNSP dalam perancangan sistem kendali otomasi pabrik dan implementasi lengan robotika industri.',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $tentor4 = User::updateOrCreate(
            ['email' => 'siti.nurhaliza@akademipelatihan.com'],
            [
                'name' => 'Siti Nurhaliza, S.Ds.',
                'password' => Hash::make('password123'),
                'role' => UserRole::Tentor,
                'phone' => '081234567804',
                'institution' => 'Studio Kreatif Digital Aurora',
                'expertise' => 'UI/UX Design Systems & Figma Tokens',
                'bio' => 'Product Designer yang merancang arsitektur antarmuka digital untuk berbagai aplikasi berskala jutaan pengguna.',
                'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $tentor5 = User::updateOrCreate(
            ['email' => 'amanda.pradipta@akademipelatihan.com'],
            [
                'name' => 'Amanda Pradipta, S.I.Kom.',
                'password' => Hash::make('password123'),
                'role' => UserRole::Tentor,
                'phone' => '081234567805',
                'institution' => 'Vocal & Leadership Institute',
                'expertise' => 'Public Speaking & Executive Persuasion',
                'bio' => 'Pelatih wicara publik yang kerap memfasilitasi pelatihan komunikasi persuasif bagi manajer, eksekutif, dan pendidik.',
                'avatar' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 4. Daftar 10 Data Pelatihan (Online, Offline, Blended)
        $trainingsData = [
            // 1. ONLINE - Guru - Gratis
            [
                'title' => 'Penerapan Pembelajaran Berbasis AI dan Gamifikasi untuk Pendidik Abad 21',
                'slug' => 'penerapan-pembelajaran-berbasis-ai-dan-gamifikasi-untuk-pendidik-abad-21',
                'category_id' => $categories['pedagogik']->id,
                'description' => "Transformasi modul ajar konvensional menggunakan prompt engineering praktis, evaluasi adaptif, dan platform permainan edukatif interaktif.\n\nPelatihan ini membedah pemanfaatan kecerdasan buatan (GenAI) dalam merancang bahan tayang dinamis, bank soal berbobot taksonomi Bloom, serta integrasi platform gamifikasi kelas seperti Quizizz dan Kahoot Pro.",
                'audience' => TrainingAudience::Guru,
                'mode' => TrainingMode::Online,
                'status' => TrainingStatus::Published,
                'is_free' => true,
                'price' => 0,
                'quota' => 150,
                'registration_start' => Carbon::now()->subDays(5),
                'registration_end' => Carbon::now()->addDays(12),
                'start_date' => Carbon::now()->addDays(14),
                'end_date' => Carbon::now()->addDays(16),
                'meeting_url' => 'https://meet.google.com/edu-ai-game',
                'location' => null,
                'thumbnail' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Modul Ajar & Bahan Tayang Digital Lengkap',
                    'Akses Rekaman Video Sesi Penuh Seumur Hidup',
                    'Grup Komunitas Bimbingan WhatsApp / Telegram',
                    'Paket Prompt AI Praktik Siap Pakai',
                ],
                'instructors' => [$tentor1->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1: Pengenalan Ekosistem GenAI & Prompt Engineering Dasar Guru',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(14)->toDateString(),
                        'start_time' => '09:00:00',
                        'end_time' => '11:30:00',
                        'meeting_url' => 'https://meet.google.com/edu-ai-game',
                        'notes' => 'Harap siapkan akun Google aktif dan peramban Chrome versi terkini.',
                    ],
                    [
                        'title' => 'Sesi 2: Desain Gamifikasi Interaktif Pembelajaran Quizizz & Kahoot Pro',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(15)->toDateString(),
                        'start_time' => '13:00:00',
                        'end_time' => '15:30:00',
                        'meeting_url' => 'https://meet.google.com/edu-ai-game',
                        'notes' => 'Praktik langsung membuat ruang kuis interaktif dengan skor langsung.',
                    ],
                    [
                        'title' => 'Sesi 3: Simulasi Penyusunan Modul Ajar Berbasis Kurikulum Merdeka',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(16)->toDateString(),
                        'start_time' => '09:00:00',
                        'end_time' => '12:00:00',
                        'meeting_url' => 'https://meet.google.com/edu-ai-game',
                        'notes' => 'Presentasi karya perwakilan peserta dan review langsung oleh pemateri.',
                    ],
                ],
            ],

            // 2. OFFLINE - Siswa/Mahasiswa - Berbayar
            [
                'title' => 'Bootcamp Intensif Fullstack Web Development dengan Laravel 13 & Vue.js',
                'slug' => 'bootcamp-intensif-fullstack-web-development-dengan-laravel-13-vuejs',
                'category_id' => $categories['teknologi']->id,
                'description' => "Pelatihan tatap muka intensif mempelajari arsitektur web modern skala industri menggunakan framework Laravel 13 dan Vue.js Composition API.\n\nFokus kurikulum mencakup clean architecture (Service & DTO Pattern), Eloquent ORM efisien, autentikasi session multi-role, pembuatan REST API handal, hingga deployment otomatis di server cloud.",
                'audience' => TrainingAudience::Siswa,
                'mode' => TrainingMode::Offline,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 450000,
                'quota' => 35,
                'registration_start' => Carbon::now()->subDays(3),
                'registration_end' => Carbon::now()->addDays(8),
                'start_date' => Carbon::now()->addDays(10),
                'end_date' => Carbon::now()->addDays(12),
                'meeting_url' => null,
                'location' => 'Lab Komputer Kampus Pusat Akademi, Jl. Gatot Subroto No. 45, Jakarta Selatan',
                'thumbnail' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Akses Source Code Proyek GitHub Repository',
                    'Konsultasi Langsung & Review Karya Bersama Tentor',
                    'Makan Siang & Coffee Break 3 Hari Pelatihan',
                    'Modul Ajar & Bahan Tayang Digital Lengkap',
                ],
                'instructors' => [$tentor2->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1: Arsitektur Modern Laravel 13, Migrations & Service Pattern',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(10)->toDateString(),
                        'start_time' => '08:30:00',
                        'end_time' => '12:00:00',
                        'location' => 'Ruang Lab 1 Gedung C',
                        'notes' => 'Peserta diwajibkan membawa laptop dengan PHP 8.3 dan Node.js terpasang.',
                    ],
                    [
                        'title' => 'Sesi 2: Integrasi REST API & State Management Vue 3 Composition API',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(11)->toDateString(),
                        'start_time' => '13:00:00',
                        'end_time' => '16:30:00',
                        'location' => 'Ruang Lab 1 Gedung C',
                        'notes' => 'Membangun antarmuka SPA interaktif yang reaktif.',
                    ],
                    [
                        'title' => 'Sesi 3: Deployment Production, CI/CD Pipeline & Keamanan Web',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(12)->toDateString(),
                        'start_time' => '09:00:00',
                        'end_time' => '15:00:00',
                        'location' => 'Ruang Lab 1 Gedung C',
                        'notes' => 'Live deployment aplikasi ke server VPS Linux.',
                    ],
                ],
            ],

            // 3. BLENDED - Vokasi - Berbayar
            [
                'title' => 'Sertifikasi Pemrograman PLC & Otomasi Robotika Lengan Industri',
                'slug' => 'sertifikasi-pemrograman-plc-dan-otomasi-robotika-lengan-industri',
                'category_id' => $categories['vokasi']->id,
                'description' => "Program hybrid intensif yang menggabungkan pendalaman teori otomasi daring dengan praktik laboratorium langsung menggunakan trainer kit PLC dan lengan robot industri.\n\nKurikulum disusun selaras standar SKKNI bidang manufaktur dan mekatronika modern untuk menyiapkan teknisi bersertifikasi siap kerja.",
                'audience' => TrainingAudience::Vokasi,
                'mode' => TrainingMode::Blended,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 750000,
                'quota' => 25,
                'registration_start' => Carbon::now()->subDays(2),
                'registration_end' => Carbon::now()->addDays(15),
                'start_date' => Carbon::now()->addDays(18),
                'end_date' => Carbon::now()->addDays(22),
                'meeting_url' => 'https://meet.google.com/vokasi-plc-auto',
                'location' => 'Balai Latihan Vokasi Manufaktur, Kawasan Industri Jababeka, Cikarang',
                'thumbnail' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Praktik Langsung Trainer Kit PLC & Lengan Robot',
                    'Sertifikat Fisik Berstandar SKKNI Industri',
                    'Modul Ajar & Bahan Tayang Digital Lengkap',
                    'Paket Template Praktik & Modul Siap Pakai',
                ],
                'instructors' => [$tentor3->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1 (Online): Logika Ladder Diagram & Pengantar Hardware PLC Siemens',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(18)->toDateString(),
                        'start_time' => '19:00:00',
                        'end_time' => '21:30:00',
                        'meeting_url' => 'https://meet.google.com/vokasi-plc-auto',
                        'notes' => 'Teori instalasi software simulator TIA Portal.',
                    ],
                    [
                        'title' => 'Sesi 2 (Online): Desain Human Machine Interface (HMI) & Sensor Integrator',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(19)->toDateString(),
                        'start_time' => '19:00:00',
                        'end_time' => '21:30:00',
                        'meeting_url' => 'https://meet.google.com/vokasi-plc-auto',
                        'notes' => 'Perancangan layout kontrol pada layar sentuh HMI industri.',
                    ],
                    [
                        'title' => 'Sesi 3 (Offline): Praktik Wiring Trainer Kit & Kalibrasi Sensor Lengan Robot',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(21)->toDateString(),
                        'start_time' => '08:30:00',
                        'end_time' => '12:30:00',
                        'location' => 'Bengkel Mekatronika Lantai 1',
                        'notes' => 'Wajib mengenakan safety shoes dan baju wearpack.',
                    ],
                    [
                        'title' => 'Sesi 4 (Offline): Uji Kompetensi Mandiri Pemrograman Siklus Pick-and-Place',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(22)->toDateString(),
                        'start_time' => '13:00:00',
                        'end_time' => '17:00:00',
                        'location' => 'Bengkel Mekatronika Lantai 1',
                        'notes' => 'Asesmen unjuk kerja di hadapan tim penguji teknis.',
                    ],
                ],
            ],

            // 4. ONLINE - Umum - Berbayar
            [
                'title' => 'Masterclass UI/UX Design System: Dari Konsep Wireframe hingga Prototipe Figma',
                'slug' => 'masterclass-ui-ux-design-system-dari-konsep-wireframe-hingga-prototipe-figma',
                'category_id' => $categories['desain']->id,
                'description' => "Kuasai seni mendesain produk digital dengan metodologi Design Thinking dan pembangunan Design System berskala industri.\n\nPelatihan ini memandu pembuatan user flow, high-fidelity wireframe, penggunaan Auto-Layout cerdas, tokens warna dinamis, serta pembuatan prototipe interaktif yang siap diserahkan ke tim engineer.",
                'audience' => TrainingAudience::Umum,
                'mode' => TrainingMode::Online,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 175000,
                'quota' => 90,
                'registration_start' => Carbon::now()->subDays(7),
                'registration_end' => Carbon::now()->addDays(10),
                'start_date' => Carbon::now()->addDays(12),
                'end_date' => Carbon::now()->addDays(13),
                'meeting_url' => 'https://zoom.us/j/8899112233',
                'location' => null,
                'thumbnail' => 'https://images.unsplash.com/photo-1581291518633-83b4ebd1d83e?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Akses File UI Kit Figma Component Library Siap Pakai',
                    'Akses Rekaman Video Sesi Penuh Seumur Hidup',
                    'Konsultasi Langsung & Review Karya Bersama Tentor',
                    'Grup Komunitas Bimbingan WhatsApp / Telegram',
                ],
                'instructors' => [$tentor4->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1: User Research, Information Architecture & UX Wireframing',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(12)->toDateString(),
                        'start_time' => '09:00:00',
                        'end_time' => '12:00:00',
                        'meeting_url' => 'https://zoom.us/j/8899112233',
                        'notes' => 'Menyusun wireframe kerangka dasar dari user persona nyata.',
                    ],
                    [
                        'title' => 'Sesi 2: Membangun Tokens, Auto Layout, dan Variabel Interaktif di Figma',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(13)->toDateString(),
                        'start_time' => '13:30:00',
                        'end_time' => '16:30:00',
                        'meeting_url' => 'https://zoom.us/j/8899112233',
                        'notes' => 'Membangun komponen responsif dan micro-interaction prototipe.',
                    ],
                ],
            ],

            // 5. OFFLINE - Umum - Berbayar
            [
                'title' => 'Pelatihan Eksklusif Public Speaking & Komunikasi Persuasif untuk Pemimpin Muda',
                'slug' => 'pelatihan-eksklusif-public-speaking-dan-komunikasi-persuasif-untuk-pemimpin-muda',
                'category_id' => $categories['leadership']->id,
                'description' => "Tingkatkan rasa percaya diri dan daya pengaruh dalam menyampaikan gagasan di hadapan publik maupun rapat dewan eksekutif.\n\nPelatihan tatap muka interaktif ini membedah teknik olah vokal, bahasa tubuh berwibawa, framing narasi cerita (storytelling), hingga seni negosiasi persuasif tingkat tinggi.",
                'audience' => TrainingAudience::Umum,
                'mode' => TrainingMode::Offline,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 350000,
                'quota' => 30,
                'registration_start' => Carbon::now()->subDays(4),
                'registration_end' => Carbon::now()->addDays(9),
                'start_date' => Carbon::now()->addDays(11),
                'end_date' => Carbon::now()->addDays(12),
                'meeting_url' => null,
                'location' => 'Auditorium Graha Wicara Lantai 3, Jl. Asia Afrika No. 120, Bandung',
                'thumbnail' => 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Workbook Cetak Eksklusif & Panduan Bahasa Tubuh',
                    'Sesi Rekaman Video Pidato Pribadi dengan Evaluasi Khusus',
                    'Lunch Buffet & Coffee Break Premium',
                    'Konsultasi Langsung & Review Karya Bersama Tentor',
                ],
                'instructors' => [$tentor5->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1: Mengatasi Demam Panggung & Seni Retorika Vokal Dinamis',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(11)->toDateString(),
                        'start_time' => '08:30:00',
                        'end_time' => '12:00:00',
                        'location' => 'Main Ballroom Graha Wicara Bandung',
                        'notes' => 'Dresscode rapi formal bisnis.',
                    ],
                    [
                        'title' => 'Sesi 2: Praktik Storytelling Bisnis & Simulasi Pidato Spontan (Elevator Pitch)',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(12)->toDateString(),
                        'start_time' => '13:00:00',
                        'end_time' => '17:00:00',
                        'location' => 'Main Ballroom Graha Wicara Bandung',
                        'notes' => 'Setiap peserta unjuk bicara di atas panggung dengan feedback langsung.',
                    ],
                ],
            ],

            // 6. BLENDED - Umum - Berbayar
            [
                'title' => 'Optimalisasi Digital Marketing & Strategi Iklan Berbayar Meta & Google Ads',
                'slug' => 'optimalisasi-digital-marketing-dan-strategi-iklan-berbayar-meta-dan-google-ads',
                'category_id' => $categories['bisnis']->id,
                'description' => "Panduan praktis menjalankan kampanye promosi digital berkinerja tinggi dengan Return on Ad Spend (ROAS) optimal.\n\nPelatihan ini mengupas tuntas struktur campaign funnel, pixel tracking server-side, targeting audiens berbasis minat dan lookalike, serta analisis metrik Google Analytics 4.",
                'audience' => TrainingAudience::Umum,
                'mode' => TrainingMode::Blended,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 299000,
                'quota' => 50,
                'registration_start' => Carbon::now()->subDays(6),
                'registration_end' => Carbon::now()->addDays(14),
                'start_date' => Carbon::now()->addDays(16),
                'end_date' => Carbon::now()->addDays(18),
                'meeting_url' => 'https://meet.google.com/ads-marketing-pro',
                'location' => 'Kreatif Hub Surabaya, Jl. Basuki Rahmat No. 88, Surabaya',
                'thumbnail' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Template Lembar Kerja ROI & Tracking Sheet Google Looker Studio',
                    'Akses Rekaman Video Sesi Penuh Seumur Hidup',
                    'Grup Komunitas Bimbingan WhatsApp / Telegram',
                    'Konsultasi Langsung & Review Karya Bersama Tentor',
                ],
                'instructors' => [$tentor4->id, $tentor5->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1 (Online): Struktur Funnel Penjualan & Riset Audiens Tertarget',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(16)->toDateString(),
                        'start_time' => '19:30:00',
                        'end_time' => '21:30:00',
                        'meeting_url' => 'https://meet.google.com/ads-marketing-pro',
                        'notes' => 'Eksplorasi target pasar menggunakan Meta Audience Insights.',
                    ],
                    [
                        'title' => 'Sesi 2 (Online): Setup Konversi Piksel Meta & Tracking GA4',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(17)->toDateString(),
                        'start_time' => '19:30:00',
                        'end_time' => '21:30:00',
                        'meeting_url' => 'https://meet.google.com/ads-marketing-pro',
                        'notes' => 'Pemasangan event tracking di website WordPress / Laravel.',
                    ],
                    [
                        'title' => 'Sesi 3 (Offline): Bedah Kasus Iklan Nyata & Simulasi Budgeting Kampanye',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(18)->toDateString(),
                        'start_time' => '09:00:00',
                        'end_time' => '15:00:00',
                        'location' => 'Creative Lab Kreatif Hub Surabaya',
                        'notes' => 'Peserta membawa materi kampanye bisnis masing-masing.',
                    ],
                ],
            ],

            // 7. ONLINE - Guru - Gratis
            [
                'title' => 'Webinar Nasional Asesmen Kompetensi & Pembuatan Portofolio Siswa Berbasis Digital',
                'slug' => 'webinar-nasional-asesmen-kompetensi-dan-pembuatan-portofolio-siswa-berbasis-digital',
                'category_id' => $categories['pedagogik']->id,
                'description' => "Strategi implementasi asesmen formatif dan sumatif yang bermakna bagi siswa, dilengkapi dengan panduan penyusunan portofolio digital berbasis cloud.\n\nPendidik diajak merancang rubrik penilaian autentik yang terintegrasi pada sistem rapor pendidikan nasional.",
                'audience' => TrainingAudience::Guru,
                'mode' => TrainingMode::Online,
                'status' => TrainingStatus::Published,
                'is_free' => true,
                'price' => 0,
                'quota' => 300,
                'registration_start' => Carbon::now()->subDays(10),
                'registration_end' => Carbon::now()->addDays(6),
                'start_date' => Carbon::now()->addDays(8),
                'end_date' => Carbon::now()->addDays(9),
                'meeting_url' => 'https://zoom.us/j/9988776655',
                'location' => null,
                'thumbnail' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Modul Ajar & Bahan Tayang Digital Lengkap',
                    'Akses Rekaman Video Sesi Penuh Seumur Hidup',
                    'Grup Komunitas Bimbingan WhatsApp / Telegram',
                ],
                'instructors' => [$tentor1->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1: Konsep Asesmen Autentik & Rubrik Evaluasi Kinerja Siswa',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(8)->toDateString(),
                        'start_time' => '09:00:00',
                        'end_time' => '11:30:00',
                        'meeting_url' => 'https://zoom.us/j/9988776655',
                        'notes' => 'Membahas instrumen observasi minat dan bakat murid.',
                    ],
                    [
                        'title' => 'Sesi 2: Penyusunan Digital Student Portfolio Menggunakan Google Sites',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(9)->toDateString(),
                        'start_time' => '13:00:00',
                        'end_time' => '15:30:00',
                        'meeting_url' => 'https://zoom.us/j/9988776655',
                        'notes' => 'Praktik langsung pembuatan portofolio siswa yang rapi dan menarik.',
                    ],
                ],
            ],

            // 8. OFFLINE - Vokasi - Berbayar
            [
                'title' => 'Workshop Teknik Pengelasan SMAW & GTAW Tingkat Lanjut untuk Industri Karoseri',
                'slug' => 'workshop-teknik-pengelasan-smaw-dan-gtaw-tingkat-lanjut-untuk-industri-karoseri',
                'category_id' => $categories['vokasi']->id,
                'description' => "Penguasaan teknik pengelasan Shielded Metal Arc Welding (SMAW) dan Gas Tungsten Arc Welding (GTAW/Argon) berstandar internasional AWS D1.1.\n\nDitujukan untuk teknisi perbengkelan, SMK teknik mesin, dan praktisi manufaktur karoseri yang ingin meningkatkan mutu sambungan las presisi bebas cacat.",
                'audience' => TrainingAudience::Vokasi,
                'mode' => TrainingMode::Offline,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 650000,
                'quota' => 20,
                'registration_start' => Carbon::now()->subDays(5),
                'registration_end' => Carbon::now()->addDays(11),
                'start_date' => Carbon::now()->addDays(13),
                'end_date' => Carbon::now()->addDays(15),
                'meeting_url' => null,
                'location' => 'Bengkel Logam & Pengelasan Balai Latihan Kerja Mandiri, Semarang',
                'thumbnail' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Peralatan Keselamatan Kerja K3 Lengkap (APD) saat Praktik',
                    'Bahan Pelat Baja Uji Standar AWS (American Welding Society)',
                    'Modul Ajar & Bahan Tayang Digital Lengkap',
                    'Konsultasi Langsung & Review Karya Bersama Tentor',
                ],
                'instructors' => [$tentor3->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1: K3 Pengelasan & Prosedur Pencegahan Cacat Las Porosity & Undercut',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(13)->toDateString(),
                        'start_time' => '08:30:00',
                        'end_time' => '11:30:00',
                        'location' => 'Ruang Teori Bengkel Pengelasan Semarang',
                        'notes' => 'Pengenalan simbol las dan metalurgi dasar pelat baja.',
                    ],
                    [
                        'title' => 'Sesi 2: Praktik Posisi Pengelasan 3G & 4G SMAW pada Pelat Baja Karbon',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(14)->toDateString(),
                        'start_time' => '12:30:00',
                        'end_time' => '16:30:00',
                        'location' => 'Bilik Las Bengkel Mesin Semarang',
                        'notes' => 'Uji visual dan uji tekuk (bend test) pada hasil sambungan.',
                    ],
                    [
                        'title' => 'Sesi 3: Teknik Pengelasan GTAW (Argon) Logam Stainless Steel & Aluminium',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(15)->toDateString(),
                        'start_time' => '08:30:00',
                        'end_time' => '15:00:00',
                        'location' => 'Bilik Las Bengkel Mesin Semarang',
                        'notes' => 'Penyempurnaan penetrasi akar las pada pipa tipis.',
                    ],
                ],
            ],

            // 9. BLENDED - Siswa/Mahasiswa - Berbayar
            [
                'title' => 'Peningkatan Literasi Sains & Eksperimen STEM Interaktif Berbasis Mikrokontroler',
                'slug' => 'peningkatan-literasi-sains-dan-eksperimen-stem-interaktif-berbasis-mikrokontroler',
                'category_id' => $categories['teknologi']->id,
                'description' => "Pengembangan pola pikir komputasional (computational thinking) dan kemampuan rekayasa sains melalui perakitan sensor Internet of Things (IoT).\n\nPeserta belajar memprogram mikrokontroler Arduino/ESP32, membaca sensor lingkungan, hingga memvisualisasikan data grafik secara real-time.",
                'audience' => TrainingAudience::Siswa,
                'mode' => TrainingMode::Blended,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 225000,
                'quota' => 45,
                'registration_start' => Carbon::now()->subDays(3),
                'registration_end' => Carbon::now()->addDays(16),
                'start_date' => Carbon::now()->addDays(19),
                'end_date' => Carbon::now()->addDays(21),
                'meeting_url' => 'https://meet.google.com/stem-arduino-class',
                'location' => 'Maker Space STEM Laboratory, Jl. Malioboro No. 56, Yogyakarta',
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Kit Eksperimen Mikrokontroler Sensor IoT untuk Praktik',
                    'Source Code Arduino & Dokumentasi Sirkuit Fritzing',
                    'Akses Rekaman Video Sesi Penuh Seumur Hidup',
                    'Konsultasi Langsung & Review Karya Bersama Tentor',
                ],
                'instructors' => [$tentor2->id, $tentor3->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1 (Online): Pemahaman Dasar Sensor Suhu, Kelembaban, dan Logika C++',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(19)->toDateString(),
                        'start_time' => '19:00:00',
                        'end_time' => '21:00:00',
                        'meeting_url' => 'https://meet.google.com/stem-arduino-class',
                        'notes' => 'Simulasi sirkuit menggunakan platform virtual Wokwi.',
                    ],
                    [
                        'title' => 'Sesi 2 (Online): Pengiriman Data Telemetri Sederhana ke Cloud Server',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(20)->toDateString(),
                        'start_time' => '19:00:00',
                        'end_time' => '21:00:00',
                        'meeting_url' => 'https://meet.google.com/stem-arduino-class',
                        'notes' => 'Menghubungkan mikrokontroler dengan WiFi lokal.',
                    ],
                    [
                        'title' => 'Sesi 3 (Offline): Perakitan Stasiun Cuaca Mandiri & Pameran Hasil Proyek',
                        'session_type' => SessionType::Offline,
                        'session_date' => Carbon::now()->addDays(21)->toDateString(),
                        'start_time' => '09:00:00',
                        'end_time' => '15:00:00',
                        'location' => 'Ruang Workshop Maker Space Yogyakarta',
                        'notes' => 'Peserta merakit fisik hardware dan demo unjuk kerja.',
                    ],
                ],
            ],

            // 10. ONLINE - Umum - Berbayar
            [
                'title' => 'Manajemen Finansial & Penyusunan Laporan Keuangan UMKM Berbasis Spreadsheet',
                'slug' => 'manajemen-finansial-dan-penyusunan-laporan-keuangan-umkm-berbasis-spreadsheet',
                'category_id' => $categories['bisnis']->id,
                'description' => "Tata kelola keuangan usaha mikro dan kecil yang rapi dan terukur tanpa perlu software akuntansi mahal yang rumit.\n\nPelatihan ini mengajarkan pemisahan arus kas pribadi vs usaha, pencatatan kas masuk-keluar, pembukuan persediaan barang, serta penyusunan laporan laba-rugi otomatis menggunakan template spreadsheet dinamis.",
                'audience' => TrainingAudience::Umum,
                'mode' => TrainingMode::Online,
                'status' => TrainingStatus::Published,
                'is_free' => false,
                'price' => 120000,
                'quota' => 75,
                'registration_start' => Carbon::now()->subDays(8),
                'registration_end' => Carbon::now()->addDays(7),
                'start_date' => Carbon::now()->addDays(9),
                'end_date' => Carbon::now()->addDays(10),
                'meeting_url' => 'https://meet.google.com/finance-umkm-spread',
                'location' => null,
                'thumbnail' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?auto=format&fit=crop&w=800&q=80',
                'facilities' => [
                    'E-Sertifikat 32 JP Terverifikasi Nasional',
                    'Template Otomatis Laba-Rugi, Neraca & Arus Kas Excel/Google Sheets',
                    'Akses Rekaman Video Sesi Penuh Seumur Hidup',
                    'Grup Komunitas Bimbingan WhatsApp / Telegram',
                    'Konsultasi Langsung & Review Karya Bersama Tentor',
                ],
                'instructors' => [$tentor4->id],
                'sessions' => [
                    [
                        'title' => 'Sesi 1: Pemisahan Keuangan Pribadi vs Usaha & Pencatatan Transaksi Harian',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(9)->toDateString(),
                        'start_time' => '19:30:00',
                        'end_time' => '21:30:00',
                        'meeting_url' => 'https://meet.google.com/finance-umkm-spread',
                        'notes' => 'Praktik mengisi jurnal kas masuk dan pengeluaran operasional.',
                    ],
                    [
                        'title' => 'Sesi 2: Penyusunan Laporan Laba Rugi Otomatis & Analisis Titik Impas (BEP)',
                        'session_type' => SessionType::Online,
                        'session_date' => Carbon::now()->addDays(10)->toDateString(),
                        'start_time' => '19:30:00',
                        'end_time' => '21:30:00',
                        'meeting_url' => 'https://meet.google.com/finance-umkm-spread',
                        'notes' => 'Menghitung batas minimal penjualan untuk mencapai profit usaha.',
                    ],
                ],
            ],
        ];

        // 5. Eksekusi Penyimpanan Setiap Pelatihan Beserta Sesi & Tentor
        foreach ($trainingsData as $item) {
            $sessions = $item['sessions'];
            $instructorIds = $item['instructors'];
            unset($item['sessions'], $item['instructors']);

            $item['created_by'] = $admin->id;

            $training = Training::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );

            // Pasang Instruktur
            $training->instructors()->sync($instructorIds);

            // Pasang Sesi Pertemuan
            // Hapus sesi lama jika seeder dijalankan berulang agar bersih
            $training->sessions()->forceDelete();

            foreach ($sessions as $sessionData) {
                $sessionData['training_id'] = $training->id;
                TrainingSession::create($sessionData);
            }
        }
    }
}
