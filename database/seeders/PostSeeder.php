<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Enums\PostType;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        if (! $admin) {
            return;
        }

        $posts = [
            [
                'title' => 'Peluncuran Platform Akademi Pelatihan: Standarisasi Kompetensi Digital Nasional',
                'slug' => 'peluncuran-platform-akademi-pelatihan-standarisasi-kompetensi-digital-nasional',
                'type' => PostType::Berita,
                'excerpt' => 'Akademi Pelatihan resmi meluncurkan ekosistem pembelajaran terintegrasi untuk guru, siswa, dan profesional umum guna mengakselerasi kesiapan talenta masa depan.',
                'content' => "Jakarta — Dalam rangka menjawab tantangan transformasi industri dan kebutuhan integrasi kecakapan digital abad ke-21, Akademi Pelatihan secara resmi mengumumkan pembukaan portal pembelajaran terpadu.\n\nMelalui platform ini, para pendidik dan talenta muda dapat mengakses kurikulum berbasis standar kompetensi kerja nasional (SKKNI) secara gratis pada fase inisiasi program.\n\nDirektur Program Kurikulum menyatakan bahwa setiap modul dan sesi pelatihan dibimbing langsung oleh praktisi industri teruji serta asesor kompetensi berlisensi.",
                'status' => PostStatus::Published,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Strategi Penerapan Kecerdasan Buatan (AI) Dalam Manajemen Kelas Modern',
                'slug' => 'strategi-penerapan-kecerdasan-buatan-ai-dalam-manajemen-kelas-modern',
                'type' => PostType::Artikel,
                'excerpt' => 'Panduan komprehensif bagi guru dan instruktur dalam memanfaatkan perangkat AI generatif untuk merancang rubrik asesmen adaptif dan materi interaktif.',
                'content' => "Perkembangan Artificial Intelligence (AI) membawa pergeseran fundamental dalam pedagogi pembelajaran. Bukan lagi sekadar alat otomatisasi tugas administratif, AI kini menjadi mitra kognitif pendidik.\n\nLangkah pertama dalam adopsi AI adalah mengidentifikasi kebutuhan spesifik peserta didik. Guru dapat menggunakan model prompt engineering terstruktur untuk menyusun skenario studi kasus kontekstual.\n\nSelain itu, etika penggunaan data siswa dan integritas akademik harus tetap menjadi pilar utama dalam setiap tahapan implementasi teknologi di ruang kelas.",
                'status' => PostStatus::Published,
                'published_at' => now()->subDay(),
            ],
            [
                'title' => 'Draft Kerangka Kurikulum Vokasi Bidang Cloud Architecture 2026',
                'slug' => 'draft-kerangka-kurikulum-vokasi-bidang-cloud-architecture-2026',
                'type' => PostType::Artikel,
                'excerpt' => 'Rancangan silabus pelatihan vokasi untuk kompetensi rekayasa arsitektur awan dan keamanan infrastruktur data skala besar.',
                'content' => "Dokumen ini merupakan draf kerja tim kurikulum internal untuk pelatihan vokasi lanjutan yang direncanakan tayang pada kuartal mendatang.",
                'status' => PostStatus::Draft,
                'published_at' => null,
            ],
        ];

        foreach ($posts as $item) {
            Post::firstOrCreate(
                ['slug' => $item['slug']],
                array_merge($item, ['author_id' => $admin->id])
            );
        }
    }
}
