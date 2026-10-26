@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-20 bg-surface">
    <div class="flex flex-col w-full">

        <!-- ========================================== -->
        <!-- 1. PAGE HEADER & SERVICE STATUS BANNER     -->
        <!-- ========================================== -->
        <section class="relative w-full overflow-hidden bg-gradient-to-b from-surface-container-high/60 via-surface to-surface pb-12 pt-6 sm:pt-10 px-4 sm:px-6 lg:px-8 border-b border-outline-variant/50">
            <div class="pointer-events-none absolute -right-20 -top-20 h-96 w-96 rounded-full bg-secondary-fixed/30 blur-3xl"></div>
            <div class="pointer-events-none absolute left-1/4 top-1/2 h-72 w-72 rounded-full bg-tertiary-fixed/20 blur-3xl"></div>

            <div class="mx-auto max-w-7xl">
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb" class="mb-6 flex items-center gap-2 text-on-surface-variant text-xs sm:text-sm">
                    <a class="flex items-center gap-1 transition-colors hover:text-secondary font-medium" href="{{ url('/') }}">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <span class="font-semibold text-primary">Kontak &amp; Layanan</span>
                </nav>

                <!-- Page Header -->
                <div class="relative max-w-3xl">
                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-secondary-fixed px-3 py-1 text-on-secondary-fixed font-headline text-xs font-bold shadow-xs">
                        <span class="material-symbols-outlined text-[16px] text-secondary">headset_mic</span>
                        <span>Pusat Bantuan &amp; Konsultasi Resmi</span>
                    </div>
                    <h1 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-primary leading-tight">
                        Hubungi Akademi Pelatihan
                    </h1>
                    <p class="mt-3 text-base sm:text-lg leading-relaxed text-on-surface-variant">
                        Punya pertanyaan seputar program pelatihan, kerjasama institusi, atau pendaftaran lembaga? Tim layanan terpadu kami siap membantu kebutuhan peningkatan kompetensi Anda.
                    </p>
                </div>

                <!-- Live Service Status Banner -->
                <div class="mt-8 flex flex-wrap items-center justify-between gap-4 rounded-xl bg-surface-container-lowest p-4 sm:p-5 shadow-xs border border-outline-variant/60">
                    <div class="flex items-center gap-3">
                        <div class="relative flex h-3.5 w-3.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-secondary opacity-75"></span>
                            <span class="relative inline-flex h-3.5 w-3.5 rounded-full bg-secondary"></span>
                        </div>
                        <div>
                            <span class="font-headline text-xs sm:text-sm font-bold text-primary">Status Pelayanan: Beroperasi Normal</span>
                            <p class="text-xs text-on-surface-variant">Jam respons rata-rata: &lt; 25 menit pada jam operasional kerja.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 sm:gap-6 text-xs text-on-surface-variant font-medium">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-secondary">verified_user</span>
                            <span>Kanal Resmi Terverifikasi</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-on-tertiary-container">lock</span>
                            <span>Perlindungan Data ISO 27001</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- 2. MAIN 2-COLUMN CONTENT GRID              -->
        <!-- ========================================== -->
        <section class="w-full py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-12 items-start">
                    
                    <!-- Left Column: Interactive Contact Form (7 cols) -->
                    <div class="lg:col-span-7">
                        <div class="rounded-xl bg-surface-container-lowest p-6 sm:p-8 shadow-xs border border-outline-variant/70">
                            <div class="mb-6">
                                <span class="font-headline text-xs font-bold uppercase tracking-wider text-secondary">Formulir Terpadu</span>
                                <h2 class="font-headline text-2xl font-extrabold tracking-tight text-primary mt-1">Kirim Pesan atau Pertanyaan</h2>
                                <p class="mt-1 text-xs sm:text-sm text-on-surface-variant">Isi rincian formulir di bawah ini dengan lengkap untuk disposisi pesan ke unit layanan terkait.</p>
                            </div>

                            <form action="{{ url('/kontak') }}" method="POST" class="space-y-4 sm:space-y-5" id="contactForm">
                                @csrf

                                <!-- Name & Email Rows -->
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="font-headline text-xs font-bold text-on-surface" for="fullname">
                                            Nama Lengkap <span class="text-error">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined pointer-events-none absolute left-3 top-3 text-[18px] text-outline">person</span>
                                            <input type="text" 
                                                   id="fullname" 
                                                   name="fullname" 
                                                   placeholder="Contoh: Budi Santoso, M.Pd" 
                                                   required 
                                                   class="w-full rounded-lg bg-surface-container-low py-2.5 pl-10 pr-3.5 text-xs sm:text-sm text-on-surface placeholder:text-outline focus:bg-white focus:outline-none focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="font-headline text-xs font-bold text-on-surface" for="email">
                                            Alamat Email Aktif <span class="text-error">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined pointer-events-none absolute left-3 top-3 text-[18px] text-outline">mail</span>
                                            <input type="email" 
                                                   id="email" 
                                                   name="email" 
                                                   placeholder="nama@instansi.ac.id" 
                                                   required 
                                                   class="w-full rounded-lg bg-surface-container-low py-2.5 pl-10 pr-3.5 text-xs sm:text-sm text-on-surface placeholder:text-outline focus:bg-white focus:outline-none focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone & Category Rows -->
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="font-headline text-xs font-bold text-on-surface" for="phone">
                                            Nomor WhatsApp <span class="font-normal text-outline text-[11px]">(Aktif)</span>
                                        </label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined pointer-events-none absolute left-3 top-3 text-[18px] text-outline">phone_iphone</span>
                                            <input type="tel" 
                                                   id="phone" 
                                                   name="phone" 
                                                   placeholder="0812-xxxx-xxxx" 
                                                   class="w-full rounded-lg bg-surface-container-low py-2.5 pl-10 pr-3.5 text-xs sm:text-sm text-on-surface placeholder:text-outline focus:bg-white focus:outline-none focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1.5">
                                        <label class="font-headline text-xs font-bold text-on-surface" for="category">
                                            Kategori Kepentingan <span class="text-error">*</span>
                                        </label>
                                        <div class="relative">
                                            <span class="material-symbols-outlined pointer-events-none absolute left-3 top-3 text-[18px] text-outline">category</span>
                                            <select id="category" 
                                                    name="category" 
                                                    required 
                                                    class="w-full appearance-none rounded-lg bg-surface-container-low py-2.5 pl-10 pr-10 text-xs sm:text-sm text-on-surface focus:bg-white focus:outline-none focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all cursor-pointer">
                                                <option value="">Pilih Kategori</option>
                                                <option value="guru">Informasi Pelatihan Guru &amp; Pendidik</option>
                                                <option value="umum">Program Pelatihan Masyarakat / Umum</option>
                                                <option value="inhouse">Kerjasama Instansi &amp; Khusus (In-House)</option>
                                                <option value="sertifikasi">Verifikasi Sertifikat &amp; Administrasi</option>
                                                <option value="lainnya">Pertanyaan Umum Lainnya</option>
                                            </select>
                                            <span class="material-symbols-outlined pointer-events-none absolute right-3 top-3 text-[18px] text-outline">expand_more</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Message Body -->
                                <div class="flex flex-col gap-1.5">
                                    <label class="font-headline text-xs font-bold text-on-surface" for="message">
                                        Pesan / Uraian Kebutuhan <span class="text-error">*</span>
                                    </label>
                                    <textarea id="message" 
                                              name="message" 
                                              rows="4" 
                                              placeholder="Tuliskan secara ringkas kebutuhan pelatihan, jumlah estimasi peserta, atau kendala sertifikasi yang ingin ditanyakan..." 
                                              required 
                                              class="w-full rounded-lg bg-surface-container-low p-3.5 text-xs sm:text-sm text-on-surface placeholder:text-outline focus:bg-white focus:outline-none focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all"></textarea>
                                </div>

                                <!-- Privacy Policy Checkbox -->
                                <div class="pt-1">
                                    <label class="flex items-start gap-2.5 cursor-pointer">
                                        <input type="checkbox" 
                                               id="privacy-agree" 
                                               required 
                                               class="mt-0.5 h-4 w-4 rounded bg-surface-container text-secondary focus:ring-secondary cursor-pointer" />
                                        <span class="text-xs text-on-surface-variant leading-relaxed">
                                            Saya menyetujui bahwa data informasi yang diberikan digunakan oleh tim Akademi Pelatihan untuk keperluan komunikasi dan konsultasi program sesuai kebijakan privasi institusi.
                                        </span>
                                    </label>
                                </div>

                                <!-- Action Bar -->
                                <div class="pt-3 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <button type="submit" 
                                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-secondary px-6 py-3 font-headline text-xs sm:text-sm font-bold text-white shadow-md transition-all hover:bg-secondary-container hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-secondary cursor-pointer">
                                        <span>Kirim Pesan Sekarang</span>
                                        <span class="material-symbols-outlined text-[18px]">send</span>
                                    </button>
                                    <div class="flex items-center gap-1.5 text-on-surface-variant text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary-fixed-dim">schedule</span>
                                        <span>Merespons dalam 1x24 jam kerja</span>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <!-- Right Column: Channels & Institutional Partnership (5 cols) -->
                    <div class="lg:col-span-5 flex flex-col gap-6">
                        
                        <!-- Quick Contact Card -->
                        <div class="rounded-xl bg-surface-container-lowest p-6 shadow-xs border border-outline-variant/70">
                            <h3 class="mb-4 font-headline text-lg font-bold tracking-tight text-primary">
                                Saluran Komunikasi Resmi
                            </h3>
                            <div class="space-y-4">
                                
                                <!-- Location -->
                                <div class="flex items-start gap-3.5 rounded-lg bg-surface-container-low/70 p-3.5 transition-colors hover:bg-surface-container-low">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-secondary-fixed text-on-secondary-fixed font-bold">
                                        <span class="material-symbols-outlined text-[20px]">apartment</span>
                                    </div>
                                    <div>
                                        <h4 class="font-headline text-xs font-bold text-primary">Kantor Layanan Terpadu</h4>
                                        <p class="text-xs text-on-surface-variant mt-0.5 leading-relaxed">
                                            Gedung Pusat Sertifikasi &amp; Inovasi Diklat, Lantai 4<br />
                                            Jl. Gatot Subroto Kav. 52, Semanggi, Jakarta Selatan 12930
                                        </p>
                                    </div>
                                </div>

                                <!-- WhatsApp -->
                                <div class="flex items-start gap-3.5 rounded-lg bg-surface-container-low/70 p-3.5 transition-colors hover:bg-surface-container-low">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-tertiary-fixed text-on-tertiary-fixed font-bold">
                                        <span class="material-symbols-outlined text-[20px]">chat</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-headline text-xs font-bold text-primary">WhatsApp Konsultasi</h4>
                                            <span class="rounded bg-secondary-fixed px-2 py-0.5 text-[10px] font-bold text-on-secondary-fixed">
                                                Respons Cepat
                                            </span>
                                        </div>
                                        <p class="text-xs font-bold text-secondary mt-0.5">+62 811-9876-5432</p>
                                        <p class="text-[11px] text-outline">Konsultasi pendaftaran, jadwal, &amp; kurikulum.</p>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="flex items-start gap-3.5 rounded-lg bg-surface-container-low/70 p-3.5 transition-colors hover:bg-surface-container-low">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container-highest text-primary font-bold">
                                        <span class="material-symbols-outlined text-[20px]">mark_email_read</span>
                                    </div>
                                    <div>
                                        <h4 class="font-headline text-xs font-bold text-primary">Email Layanan &amp; Kemitraan</h4>
                                        <p class="text-xs text-on-surface-variant mt-0.5">layanan@akademipelatihan.id</p>
                                        <p class="text-xs text-on-surface-variant">kerjasama@akademipelatihan.id</p>
                                    </div>
                                </div>

                                <!-- Working Hours -->
                                <div class="flex items-start gap-3.5 rounded-lg bg-surface-container-low/70 p-3.5 transition-colors hover:bg-surface-container-low">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-surface-container text-on-surface font-bold">
                                        <span class="material-symbols-outlined text-[20px]">schedule</span>
                                    </div>
                                    <div class="w-full">
                                        <h4 class="font-headline text-xs font-bold text-primary">Jam Operasional Layanan</h4>
                                        <div class="mt-1 space-y-1 text-xs text-on-surface-variant">
                                            <div class="flex justify-between">
                                                <span>Senin – Jumat</span>
                                                <span class="font-bold text-primary">08:00 – 17:00 WIB</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span>Sabtu</span>
                                                <span class="font-bold text-primary">08:00 – 14:00 WIB</span>
                                            </div>
                                            <div class="flex justify-between text-outline text-[11px]">
                                                <span>Minggu &amp; Libur Nasional</span>
                                                <span>Tutup</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Institutional Partnership Special Card -->
                        <div class="relative overflow-hidden rounded-xl bg-primary-container p-6 text-white shadow-md border border-primary">
                            <div class="pointer-events-none absolute -bottom-10 -right-10 h-44 w-44 rounded-full bg-secondary/30 blur-2xl"></div>
                            <div class="relative z-10 flex flex-col gap-3">
                                <div class="inline-flex w-fit items-center gap-1.5 rounded-full bg-secondary px-3 py-1 font-headline text-[11px] font-bold text-white">
                                    <span class="material-symbols-outlined text-[14px]">school</span>
                                    <span>Program In-House Diklat</span>
                                </div>
                                <h3 class="font-headline text-base sm:text-lg font-bold text-white">
                                    Kerjasama Khusus Sekolah &amp; Korporasi?
                                </h3>
                                <p class="text-xs text-on-primary-container leading-relaxed">
                                    Jadwalkan sesi presentasi kurikulum pelatihan khusus institusi Anda. Kami menyediakan skema blended-learning, sertifikasi BNSP, dan sertifikat angka kredit guru.
                                </p>
                                <div class="mt-2 pt-2 flex items-center justify-between">
                                    <a class="inline-flex items-center gap-1.5 rounded-lg bg-white px-4 py-2 font-headline text-xs font-bold text-primary transition-all hover:bg-surface-bright shadow-xs" href="mailto:kerjasama@akademipelatihan.id?subject=Permohonan%20Presentasi%20Pelatihan%20Institusi">
                                        <span>Jadwalkan Diskusi</span>
                                        <span class="material-symbols-outlined text-[16px]">calendar_month</span>
                                    </a>
                                    <span class="text-[11px] text-on-primary-container">Dokumen MoU Siap</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 3. LOCATION & TRANSPORTATION GUIDE         -->
        <!-- ========================================== -->
        <section class="w-full pb-12 sm:pb-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-xl bg-surface-container-lowest shadow-xs border border-outline-variant/70">
                    <div class="grid grid-cols-1 lg:grid-cols-12">
                        
                        <!-- Map Visual Display (8 cols) -->
                        <div class="lg:col-span-8 relative min-h-[280px] bg-primary-container overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=1200&q=80" 
                                 alt="Peta Lokasi Gedung Pusat" 
                                 class="w-full h-full object-cover opacity-80" />
                            <div class="absolute inset-0 bg-primary/40 backdrop-blur-[1px] flex items-center justify-center p-4">
                                <div class="flex items-center gap-2 rounded-xl bg-white/95 px-5 py-3 shadow-xl backdrop-blur-xs">
                                    <span class="material-symbols-outlined text-secondary text-2xl">location_on</span>
                                    <div>
                                        <p class="font-headline text-xs sm:text-sm font-bold text-primary">Gedung Pusat Akademi Pelatihan</p>
                                        <p class="text-[11px] text-on-surface-variant">Jl. Gatot Subroto Kav. 52, Semanggi, Jakarta Selatan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Transportation Details (4 cols) -->
                        <div class="lg:col-span-4 flex flex-col justify-between p-6 bg-surface-container-low/40">
                            <div>
                                <span class="font-headline text-xs font-bold uppercase tracking-wider text-secondary">Panduan Transportasi</span>
                                <h4 class="mt-1 font-headline text-lg font-bold text-primary">Aksesibilitas Kampus &amp; Diklat</h4>
                                <p class="mt-2 text-xs text-on-surface-variant leading-relaxed">Terletak strategis di kawasan protokol Jakarta dengan kemudahan integrasi transportasi publik:</p>
                                <ul class="mt-4 space-y-2.5 text-xs text-on-surface-variant">
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-secondary">directions_bus</span>
                                        <span>Halte TransJakarta Semanggi (3 menit jalan kaki)</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-secondary">train</span>
                                        <span>Stasiun MRT Bendungan Hilir (Exit B)</span>
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-secondary">local_parking</span>
                                        <span>Area Parkir Kendaraan Roda 2 &amp; 4 Luas</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="pt-6">
                                <a class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-outline-variant bg-surface-container-lowest py-2.5 font-headline text-xs font-bold text-primary hover:bg-surface-container transition-all shadow-xs" 
                                   href="https://maps.google.com" 
                                   rel="noopener noreferrer" 
                                   target="_blank">
                                    <span>Buka Petunjuk Arah di Google Maps</span>
                                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 4. FAQ SECTION (ACCORDION)                 -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-low/50 py-12 sm:py-16 border-t border-outline-variant/50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <div class="mb-10 text-center max-w-2xl mx-auto">
                    <span class="font-headline text-xs font-bold uppercase tracking-wider text-secondary">Pusat Jawaban Cepat</span>
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold tracking-tight text-primary mt-1">
                        Pertanyaan yang Sering Diajukan
                    </h2>
                    <p class="mt-2 text-xs sm:text-sm text-on-surface-variant">
                        Temukan tanggapan langsung mengenai mekanisme pendaftaran, legalitas sertifikat, dan dukungan pelatihan.
                    </p>
                </div>

                <div class="mx-auto max-w-4xl space-y-3" id="faqAccordionGroup">
                    
                    <!-- FAQ 1 -->
                    <div class="rounded-xl bg-surface-container-lowest shadow-xs border border-outline-variant/60 transition-all">
                        <button type="button" class="faq-btn flex w-full items-center justify-between p-4 sm:p-5 text-left focus:outline-none" data-target="faq-1">
                            <span class="font-headline text-xs sm:text-sm font-bold text-primary flex items-center gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary-fixed text-[11px] font-bold text-on-secondary-fixed">1</span>
                                Bagaimana cara mendaftar program pelatihan di Akademi Pelatihan?
                            </span>
                            <span class="material-symbols-outlined text-outline transition-transform duration-200" id="icon-faq-1">expand_more</span>
                        </button>
                        <div class="hidden px-5 pb-5 pt-0" id="body-faq-1">
                            <div class="rounded-lg bg-surface-container-low/60 p-4 text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                Pendaftaran dapat dilakukan secara mandiri melalui menu <strong>Agenda Pelatihan</strong> di situs resmi ini. Pilih topik pelatihan yang diinginkan, klik <em>Daftar</em>, kemudian lengkapi profil kepesertaan Anda. Akses materi dan link kelas daring (atau tiket tatap muka) akan dikirimkan langsung ke email dan WhatsApp terdaftar segera setelah proses konfirmasi selesai.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="rounded-xl bg-surface-container-lowest shadow-xs border border-outline-variant/60 transition-all">
                        <button type="button" class="faq-btn flex w-full items-center justify-between p-4 sm:p-5 text-left focus:outline-none" data-target="faq-2">
                            <span class="font-headline text-xs sm:text-sm font-bold text-primary flex items-center gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary-fixed text-[11px] font-bold text-on-secondary-fixed">2</span>
                                Apakah sertifikat yang diterbitkan dapat diverifikasi keasliannya?
                            </span>
                            <span class="material-symbols-outlined text-outline transition-transform duration-200" id="icon-faq-2">expand_more</span>
                        </button>
                        <div class="hidden px-5 pb-5 pt-0" id="body-faq-2">
                            <div class="rounded-lg bg-surface-container-low/60 p-4 text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                Ya, seluruh sertifikat resmi yang dikeluarkan oleh Akademi Pelatihan memuat <strong>Kode Verifikasi Unik (QR Code)</strong> dan terdaftar dalam pangkalan data nasional. Pengawas sekolah, dinas, atau HRD perusahaan dapat melakukan verifikasi otentisitas secara instan tanpa dipungut biaya.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="rounded-xl bg-surface-container-lowest shadow-xs border border-outline-variant/60 transition-all">
                        <button type="button" class="faq-btn flex w-full items-center justify-between p-4 sm:p-5 text-left focus:outline-none" data-target="faq-3">
                            <span class="font-headline text-xs sm:text-sm font-bold text-primary flex items-center gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary-fixed text-[11px] font-bold text-on-secondary-fixed">3</span>
                                Apakah tersedia pelatihan khusus untuk kelompok sekolah atau korporasi?
                            </span>
                            <span class="material-symbols-outlined text-outline transition-transform duration-200" id="icon-faq-3">expand_more</span>
                        </button>
                        <div class="hidden px-5 pb-5 pt-0" id="body-faq-3">
                            <div class="rounded-lg bg-surface-container-low/60 p-4 text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                Tentu. Kami menyediakan layanan <strong>In-House Training (IHT)</strong> yang silabus serta pembelajarannya disesuaikan dengan kebutuhan internal lembaga Anda, seperti Workshop Kurikulum Merdeka Terapan, Audit Digital Sekolah, maupun Peningkatan Manajemen Yayasan. Silakan hubungi divisi kemitraan kami melalui formulir kontak di atas.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="rounded-xl bg-surface-container-lowest shadow-xs border border-outline-variant/60 transition-all">
                        <button type="button" class="faq-btn flex w-full items-center justify-between p-4 sm:p-5 text-left focus:outline-none" data-target="faq-4">
                            <span class="font-headline text-xs sm:text-sm font-bold text-primary flex items-center gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-secondary-fixed text-[11px] font-bold text-on-secondary-fixed">4</span>
                                Bagaimana jika saya berhalangan hadir pada sesi pelatihan terjadwal?
                            </span>
                            <span class="material-symbols-outlined text-outline transition-transform duration-200" id="icon-faq-4">expand_more</span>
                        </button>
                        <div class="hidden px-5 pb-5 pt-0" id="body-faq-4">
                            <div class="rounded-lg bg-surface-container-low/60 p-4 text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                                Setiap peserta program resmi memperoleh rekaman siaran ulang resolusi tinggi, modul bahan ajar interaktif, dan kuis susulan melalui Learning Management System (LMS) kami yang dapat diakses selama 6 bulan penuh. Anda tetap memenuhi syarat kelulusan sertifikasi setelah menuntaskan seluruh tugas mandiri yang ditentukan fasilitator.
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </div>
</div>

<!-- ========================================== -->
<!-- CLIENT-SIDE ACCORDION SCRIPT               -->
<!-- ========================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const faqButtons = document.querySelectorAll('.faq-btn');
    faqButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const body = document.getElementById('body-' + targetId);
            const icon = document.getElementById('icon-' + targetId);
            
            if (!body || !icon) return;

            const isCurrentlyHidden = body.classList.contains('hidden');

            // Close all
            document.querySelectorAll('#faqAccordionGroup [id^="body-faq-"]').forEach(b => b.classList.add('hidden'));
            document.querySelectorAll('#faqAccordionGroup [id^="icon-faq-"]').forEach(i => i.classList.remove('rotate-180'));

            // If it was hidden, open it
            if (isCurrentlyHidden) {
                body.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });
});
</script>
@endsection
