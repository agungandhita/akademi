# PRD: akademipelatihan.com

> Dokumen ini adalah sumber kebenaran (single source of truth) untuk pengembangan. Jika ada konflik antara kode dan dokumen ini, tanyakan dulu sebelum mengubah salah satunya.

## 1. Ringkasan

**akademipelatihan.com** adalah platform pelatihan berbasis web untuk guru, siswa, dan masyarakat umum. Pelatihan dapat berformat **online**, **offline**, atau **blended**, di berbagai bidang termasuk pelatihan vokasi.

**Fase 1 (branding):** semua pelatihan gratis.
**Fase 2 (monetisasi):** pelatihan berbayar. Struktur data disiapkan sejak awal, fiturnya belum dibangun.

## 2. Tujuan & Metrik

| Tujuan | Metrik keberhasilan (3 bulan pertama) |
|---|---|
| Membangun brand sebagai akademi pelatihan | Jumlah akun peserta terdaftar |
| Menjaring peserta dari tiga segmen | Distribusi peserta: guru / siswa / umum |
| Memastikan pelatihan benar-benar diikuti | Jumlah pendaftaran pelatihan, persentase modul dibaca |
| Konten website hidup | Jumlah berita/artikel terbit per bulan |

> Nilai target angka ditentukan pemilik produk (Udi). Isi di bagian "Pertanyaan Terbuka".

## 3. Ruang Lingkup

### 3.1 Masuk MVP
- Halaman publik: Beranda, Berita & Artikel, Agenda Pelatihan, Kontak
- Auth: register (khusus peserta), login, logout, lupa password, verifikasi email
- 3 role: Admin, Tentor, Peserta
- Manajemen pelatihan (online/offline/blended), kategori, jadwal sesi
- Modul pelatihan (diunggah tentor), dibaca peserta
- Pendaftaran peserta ke pelatihan (gratis)
- Manajemen berita & artikel
- Manajemen user, termasuk pembuatan akun tentor oleh admin
- Pesan kontak masuk dan dikelola admin

### 3.2 Di Luar MVP (Fase 2+)
- Pembayaran, invoice, kupon
- Sertifikat otomatis
- Kuis/ujian, penilaian, forum diskusi
- Presensi offline via QR
- Integrasi Zoom/Google Meet otomatis (MVP cukup tautan manual)
- Notifikasi WhatsApp
- Aplikasi mobile

## 4. Pengguna & Role

| Role | Cara mendapat akun | Ringkasan tugas |
|---|---|---|
| **Admin** | Seeder / dibuat admin lain | Mengelola seluruh isi dan pengguna website |
| **Tentor/Instruktur** | **Hanya dibuat oleh Admin** (tidak bisa register sendiri) | Mengisi modul pada pelatihan yang ditugaskan kepadanya |
| **Peserta** | Register mandiri | Memilih pelatihan, mendaftar, membaca deskripsi dan modul |

Tipe peserta (dipilih saat register): `guru`, `siswa`, `umum`.

## 5. Kebutuhan Fungsional

Prioritas: **P0** wajib MVP, **P1** sebaiknya ada, **P2** nanti.

### 5.1 Publik (tanpa login)

| ID | Kebutuhan | Prioritas |
|---|---|---|
| PUB-01 | Beranda: hero, ringkasan program, pelatihan unggulan/terbaru, agenda terdekat, berita terbaru, CTA daftar | P0 |
| PUB-02 | Berita & Artikel: daftar berpaginasi, filter tipe (berita/artikel), pencarian judul, halaman detail berslug | P0 |
| PUB-03 | Agenda Pelatihan: daftar pelatihan terbit, filter mode (online/offline/blended), sasaran (guru/siswa/umum/vokasi), kategori, status pendaftaran | P0 |
| PUB-04 | Detail pelatihan: deskripsi, mode, jadwal sesi, lokasi/tautan (tautan hanya terlihat peserta terdaftar), tentor, kuota, tombol daftar | P0 |
| PUB-05 | Kontak: form (nama, email, subjek, pesan) + info kontak + validasi + proteksi spam (honeypot + throttle) | P0 |
| PUB-06 | SEO dasar: title, meta description, Open Graph, sitemap.xml | P1 |

### 5.2 Autentikasi

| ID | Kebutuhan | Prioritas |
|---|---|---|
| AUTH-01 | Register peserta: nama, email, password, konfirmasi password, tipe peserta, institusi (opsional), no. HP (opsional) | P0 |
| AUTH-02 | Login email + password, ingat saya | P0 |
| AUTH-03 | Redirect setelah login sesuai role (admin → `/admin`, tentor → `/tentor`, peserta → `/peserta`) | P0 |
| AUTH-04 | Lupa/reset password via email | P0 |
| AUTH-05 | Verifikasi email | P1 |
| AUTH-06 | Akun nonaktif (`is_active = false`) tidak bisa login | P0 |
| AUTH-07 | Rate limit login | P0 |

### 5.3 Admin

| ID | Kebutuhan | Prioritas |
|---|---|---|
| ADM-01 | Dashboard: total user per role, total pelatihan per status, total pendaftaran, pesan kontak belum dibaca | P0 |
| ADM-02 | Manajemen user: daftar, cari, filter role, lihat, ubah, aktif/nonaktif, reset password, hapus (soft delete) | P0 |
| ADM-03 | Buat akun tentor (nama, email, password awal, bio, keahlian) | P0 |
| ADM-04 | CRUD kategori pelatihan | P0 |
| ADM-05 | CRUD pelatihan: judul, deskripsi, thumbnail, kategori, sasaran, mode, kuota, periode pendaftaran, tanggal pelaksanaan, lokasi (offline/blended), tautan meeting (online/blended), status (`draft`, `published`, `closed`, `archived`) | P0 |
| ADM-06 | Kelola sesi pelatihan (untuk blended: tiap sesi bertipe online atau offline) | P0 |
| ADM-07 | Tugaskan satu atau lebih tentor ke pelatihan | P0 |
| ADM-08 | Lihat daftar peserta per pelatihan, ekspor CSV | P1 |
| ADM-09 | Moderasi modul: sembunyikan/hapus modul yang diunggah tentor | P1 |
| ADM-10 | CRUD berita & artikel: judul, slug otomatis, ringkasan, isi (rich text), cover, tipe, status (`draft`/`published`), tanggal terbit | P0 |
| ADM-11 | Kelola pesan kontak: daftar, tandai dibaca, hapus | P0 |
| ADM-12 | Pengaturan situs (nama, kontak, sosmed) | P2 |

### 5.4 Tentor/Instruktur

| ID | Kebutuhan | Prioritas |
|---|---|---|
| TNT-01 | Dashboard: pelatihan yang ditugaskan, jumlah peserta terdaftar | P0 |
| TNT-02 | Hanya melihat pelatihan yang ditugaskan kepadanya | P0 |
| TNT-03 | CRUD modul pada pelatihan yang ditugaskan **dan berstatus `published`** | P0 |
| TNT-04 | Tipe modul: `teks` (rich text), `pdf` (unggah), `video` (tautan YouTube/Drive), `tautan` (URL eksternal) | P0 |
| TNT-05 | Urutan modul dapat diatur; status modul `draft`/`published` | P0 |
| TNT-06 | Lihat daftar peserta pelatihannya (read-only) | P1 |
| TNT-07 | Edit profil (bio, foto, keahlian) | P1 |

### 5.5 Peserta

| ID | Kebutuhan | Prioritas |
|---|---|---|
| PST-01 | Dashboard: pelatihan yang diikuti, progres, agenda terdekat | P0 |
| PST-02 | Telusuri pelatihan, baca deskripsi | P0 |
| PST-03 | Daftar ke pelatihan (satu klik, gratis). Ditolak jika kuota penuh, periode pendaftaran tutup, atau sudah terdaftar | P0 |
| PST-04 | Batalkan pendaftaran selama pelatihan belum dimulai | P1 |
| PST-05 | Baca modul **hanya** pada pelatihan yang diikuti, urut sesuai `order` | P0 |
| PST-06 | Tandai modul selesai, progres persen per pelatihan | P1 |
| PST-07 | Lihat tautan meeting/lokasi untuk sesi pada pelatihan yang diikuti | P0 |
| PST-08 | Edit profil dan ganti password | P0 |

## 6. Aturan Bisnis

1. Hanya pelatihan berstatus `published` yang tampil di publik dan bisa didaftar.
2. Pendaftaran hanya dalam rentang `registration_start`–`registration_end` dan selama kuota tersedia (kuota `NULL` = tanpa batas).
3. Satu peserta hanya bisa terdaftar satu kali per pelatihan (unique `user_id + training_id`).
4. Tentor tidak bisa register sendiri; akun tentor hanya dibuat Admin.
5. Modul hanya bisa ditambah tentor pada pelatihan yang ia ditugaskan dan berstatus `published`.
6. Peserta hanya bisa membuka modul `published` dari pelatihan yang ia ikuti (dicek di policy, bukan hanya disembunyikan di UI).
7. Mode pelatihan menentukan field wajib: `online` → tautan meeting; `offline` → lokasi; `blended` → keduanya melalui sesi.
8. Semua pelatihan Fase 1 bernilai `price = 0` dan `is_free = true`. Kolom harga sudah ada agar Fase 2 tidak perlu migrasi besar.
9. Pelatihan `closed`/`archived` tetap bisa dibaca peserta lama, tapi tidak menerima pendaftaran baru.

## 7. Model Data

Semua tabel memakai `id` bigint, `timestamps`; entitas utama memakai `softDeletes`.

**users**: name, email (unique), password, role enum(`admin`,`tentor`,`peserta`) default `peserta`, participant_type enum(`guru`,`siswa`,`umum`) nullable, institution, phone, bio, expertise, avatar, is_active bool default true, email_verified_at, remember_token

**training_categories**: name, slug (unique), description

**trainings**: category_id FK, title, slug (unique), description (longText), thumbnail, audience enum(`guru`,`siswa`,`umum`,`vokasi`), mode enum(`online`,`offline`,`blended`), status enum(`draft`,`published`,`closed`,`archived`), is_free bool default true, price decimal(12,2) default 0, quota unsigned int nullable, registration_start, registration_end, start_date, end_date, location nullable, meeting_url nullable, created_by FK users

**training_instructors** (pivot): training_id, user_id, unique(training_id, user_id)

**training_sessions**: training_id FK, title, session_type enum(`online`,`offline`), session_date, start_time, end_time, location nullable, meeting_url nullable, notes

**modules**: training_id FK, created_by FK users, title, description, type enum(`text`,`pdf`,`video`,`link`), content (longText nullable), file_path nullable, url nullable, sort_order unsigned int, status enum(`draft`,`published`)

**enrollments**: user_id FK, training_id FK, status enum(`registered`,`cancelled`,`completed`), enrolled_at, cancelled_at, completed_at, unique(user_id, training_id)

**module_progress**: enrollment_id FK, module_id FK, completed_at, unique(enrollment_id, module_id)

**posts**: author_id FK, title, slug (unique), type enum(`berita`,`artikel`), excerpt, content (longText), cover, status enum(`draft`,`published`), published_at

**contact_messages**: name, email, subject, message, is_read bool default false

Relasi inti: User 1—N Enrollment N—1 Training; Training N—N User (tentor) via training_instructors; Training 1—N Module; Training 1—N TrainingSession; Training N—1 TrainingCategory; User 1—N Post.

## 8. Struktur Halaman & Route

**Publik**
- `GET /` beranda
- `GET /berita` , `GET /berita/{slug}`
- `GET /agenda` , `GET /agenda/{slug}`
- `GET /kontak` , `POST /kontak`

**Auth**: `/login`, `/register`, `/forgot-password`, `/reset-password/{token}`, `/email/verify`, `POST /logout`

**Admin** (prefix `/admin`, middleware `auth` + `role:admin`)
`dashboard`, `users`, `tentor` (buat akun), `kategori`, `pelatihan` (+ `sesi`, `tentor`, `peserta`), `posts`, `pesan`

**Tentor** (prefix `/tentor`, middleware `auth` + `role:tentor`)
`dashboard`, `pelatihan`, `pelatihan/{training}/modul` (CRUD), `profil`

**Peserta** (prefix `/peserta`, middleware `auth` + `role:peserta`)
`dashboard`, `pelatihan-saya`, `pelatihan-saya/{training}`, `pelatihan-saya/{training}/modul/{module}`, `POST agenda/{training}/daftar`, `profil`

## 9. Kebutuhan Non-Fungsional

- **Keamanan:** CSRF, validasi via Form Request, otorisasi via Policy + middleware role, password hashing bawaan Laravel, throttle login/kontak, unggahan dibatasi tipe dan ukuran (PDF maks 10 MB, gambar maks 2 MB), file disimpan di disk `public` dengan nama acak.
- **Performa:** eager loading (cegah N+1), paginasi semua daftar, index pada slug, status, foreign key.
- **Responsif:** mobile-first. Banyak peserta (guru dan siswa) mengakses lewat ponsel.
- **Aksesibilitas:** kontras cukup, label form jelas, navigasi keyboard.
- **Bahasa:** seluruh UI dalam Bahasa Indonesia; kode, nama tabel, dan nama variabel dalam Bahasa Inggris.
- **Hosting:** kompatibel dengan shared hosting/cPanel (tanpa dependensi yang butuh proses daemon pada MVP; queue memakai driver `sync` atau `database`).

## 10. Stack & Konvensi Teknis

- **Framework:** Laravel 13, PHP sesuai persyaratan Laravel 13
- **Frontend:** Blade + Tailwind CSS via Vite, JavaScript vanilla/Alpine seperlunya
- **Notifikasi/konfirmasi UI:** SweetAlert2 (flash message sukses/gagal, konfirmasi hapus)
- **Database:** MySQL
- **Role:** kolom `role` (enum) pada `users` + middleware `role` + Policy. Hanya 3 role tetap, jadi paket permission tidak diperlukan.
- **Struktur:** controller tipis; logika bisnis di Action/Service class; validasi di Form Request; otorisasi di Policy.
- **Penamaan:** model singular (`Training`), tabel plural snake_case, route name berpola `admin.trainings.index`.
- **Layout Blade:** `layouts/public`, `layouts/dashboard` (satu layout, sidebar dinamis per role).
- **Seeder:** 1 admin, kategori contoh, beberapa pelatihan contoh, 1 tentor contoh (hanya untuk lingkungan lokal).
- **Test:** Feature test minimal untuk auth, otorisasi per role, pendaftaran pelatihan (kuota/duplikat/periode), dan akses modul.

## 11. Roadmap Pengerjaan (Milestone)

Setiap milestone dikerjakan berurutan dan harus lolos kriteria penerimaan sebelum lanjut.

### M1 — Fondasi
Instal Laravel 13, Tailwind + Vite, SweetAlert2, konfigurasi `.env` MySQL, layout dasar, kolom `role` + middleware `role`, seeder admin.
**Selesai jika:** `npm run build` dan `php artisan migrate --seed` berjalan tanpa error; login admin berhasil menuju `/admin`.

### M2 — Autentikasi
AUTH-01 s.d. AUTH-07, redirect per role, halaman profil dasar.
**Selesai jika:** peserta bisa register/login/reset password; akun nonaktif ditolak; tentor tidak bisa register; test auth lulus.

### M3 — Admin: User, Kategori, Pelatihan
ADM-01 s.d. ADM-07.
**Selesai jika:** admin bisa membuat tentor, kategori, pelatihan (3 mode) lengkap dengan sesi dan penugasan tentor; validasi field wajib per mode berjalan.

### M4 — Halaman Publik & Pendaftaran
PUB-01, PUB-03, PUB-04, PST-02, PST-03, aturan bisnis 1–3.
**Selesai jika:** pengunjung bisa menelusuri/filter agenda; peserta bisa mendaftar; kuota penuh/duplikat/di luar periode ditolak dengan pesan SweetAlert.

### M5 — Modul (Tentor & Peserta)
TNT-01 s.d. TNT-05, PST-01, PST-05, PST-07.
**Selesai jika:** tentor hanya melihat pelatihannya; peserta non-terdaftar mendapat 403 saat membuka modul; unggah PDF tervalidasi.

### M6 — Berita, Artikel & Kontak
ADM-10, ADM-11, PUB-02, PUB-05.
**Selesai jika:** admin bisa menerbitkan konten dan muncul di beranda/halaman berita; form kontak tersimpan dan bisa dibaca admin.

### M7 — Penyempurnaan
PST-04, PST-06, ADM-08, ADM-09, TNT-06, TNT-07, PUB-06, AUTH-05, dashboard lengkap, polesan UI, audit responsif dan keamanan.
**Selesai jika:** semua kebutuhan P0 dan P1 terpenuhi; seluruh test lulus.

## 12. Fase 2 (Referensi, Jangan Dikerjakan Sekarang)
Pembayaran (tabel `orders`, `payments`), kupon, sertifikat PDF, kuis, presensi QR, notifikasi WhatsApp, laporan.

## 13. Asumsi
- Satu bahasa (Indonesia).
- Satu organisasi pengelola (bukan multi-tenant).
- Admin dapat lebih dari satu orang.
- Pendaftaran pelatihan otomatis disetujui (tanpa persetujuan manual admin).

## 14. Pertanyaan Terbuka (Diisi Pemilik Produk)
1. Apakah pendaftaran perlu persetujuan admin untuk pelatihan tertentu?
2. Apakah peserta wajib verifikasi email sebelum mendaftar pelatihan?
3. Apakah modul PDF boleh diunduh peserta, atau hanya dibaca di browser?
4. Target angka metrik pada bagian 2.
5. Nama kontak resmi (email, WhatsApp, alamat) untuk halaman Kontak.
6. Apakah siswa di bawah 18 tahun perlu data tambahan (mis. persetujuan orang tua)?

## 15. Instruksi untuk AI Agent

- Baca dokumen ini penuh sebelum mengubah kode. Kerjakan **satu milestone per sesi**, jangan lompat.
- Sebelum menulis kode, buat rencana singkat (file yang akan dibuat/diubah) dan tunggu persetujuan.
- Patuhi bagian 6 (Aturan Bisnis) dan 10 (Konvensi). Jangan menambah paket/library di luar stack tanpa bertanya.
- Jangan membangun fitur dari bagian 3.2 atau 12.
- Setelah selesai tiap milestone: jalankan `php artisan test` dan `npm run build`, lalu laporkan hasil dan ringkas perubahan.
- Jika ada ambiguitas atau kebutuhan yang belum tercakup, tanyakan; jangan berasumsi diam-diam.
- Jangan menjalankan perintah destruktif (`migrate:fresh`, hapus file) tanpa konfirmasi.