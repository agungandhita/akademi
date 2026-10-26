@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-20 bg-surface">
    <div class="flex flex-col w-full">

        <!-- ========================================== -->
        <!-- 1. TOP GEOMETRIC AMBIENT HEADER            -->
        <!-- ========================================== -->
        <div class="relative w-full overflow-hidden bg-primary py-12 sm:py-16 px-4 sm:px-6 lg:px-8">
            <div class="absolute -right-20 -top-24 w-96 h-96 rounded-full bg-secondary-container/20 blur-3xl pointer-events-none"></div>
            <div class="absolute left-1/3 -bottom-20 w-80 h-80 rounded-full bg-tertiary-fixed-dim/15 blur-2xl pointer-events-none"></div>
            
            <div class="max-w-7xl mx-auto relative z-10 flex flex-col gap-6">
                
                <!-- Breadcrumb -->
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-on-primary-container text-xs sm:text-sm">
                    <a class="hover:text-white transition-colors flex items-center gap-1 font-medium" href="{{ url('/') }}">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        Beranda
                    </a>
                    <span class="material-symbols-outlined text-[14px] opacity-60">chevron_right</span>
                    <span class="text-white font-semibold">Agenda Pelatihan</span>
                </nav>

                <!-- Headline & Subheadline -->
                <div class="max-w-4xl flex flex-col gap-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 w-fit backdrop-blur-xs">
                        <span class="w-2 h-2 rounded-full bg-tertiary-fixed-dim animate-pulse"></span>
                        <span class="font-headline text-xs uppercase tracking-wider text-tertiary-fixed-dim font-bold">
                            Kalender Periode Mei — Juli 2025
                        </span>
                    </div>
                    <h1 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight">
                        Agenda Pelatihan &amp; Pengembangan Kompetensi
                    </h1>
                    <p class="text-base sm:text-lg text-on-primary-container max-w-3xl leading-relaxed">
                        Temukan jadwal workshop, seminar, dan pelatihan intensif terstandarisasi untuk Guru, Tenaga Pendidik, serta Masyarakat Umum guna memperkuat kapabilitas profesional.
                    </p>
                </div>

                <!-- Integrated Multi-Parameter Filter Dock -->
                <div class="w-full bg-surface-container-lowest rounded-xl p-4 sm:p-5 shadow-xl flex flex-col lg:flex-row gap-4 items-stretch lg:items-center mt-2 border border-outline-variant/60">
                    <!-- Search Field -->
                    <div class="flex-1 relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px]">search</span>
                        <input type="text" 
                               id="agendaSearchInput" 
                               placeholder="Cari judul pelatihan, topik, atau kata kunci..." 
                               class="w-full pl-11 pr-4 py-3 bg-surface-container-low text-on-surface rounded-lg placeholder-outline focus:outline-none focus:bg-white text-sm transition-all border border-transparent focus:border-secondary/40 font-medium" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 flex-shrink-0 lg:w-auto">
                        <!-- Target Dropdown -->
                        <div class="relative">
                            <select id="targetFilter" class="w-full appearance-none bg-surface-container-low text-on-surface py-3 pl-4 pr-10 rounded-lg text-sm font-semibold focus:outline-none cursor-pointer border border-transparent focus:border-secondary/40">
                                <option value="all">Semua Sasaran</option>
                                <option value="guru">Guru &amp; Pendidik</option>
                                <option value="siswa">Siswa &amp; Mahasiswa</option>
                                <option value="vokasi">Vokasi &amp; Industri</option>
                                <option value="umum">Masyarakat Umum</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-outline text-lg">expand_more</span>
                        </div>

                        <!-- Format Dropdown -->
                        <div class="relative">
                            <select id="formatFilter" class="w-full appearance-none bg-surface-container-low text-on-surface py-3 pl-4 pr-10 rounded-lg text-sm font-semibold focus:outline-none cursor-pointer border border-transparent focus:border-secondary/40">
                                <option value="all">Semua Format</option>
                                <option value="online">Online (LMS / Daring)</option>
                                <option value="offline">Offline (Tatap Muka)</option>
                                <option value="blended">Blended (Campuran)</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-outline text-lg">tune</span>
                        </div>

                        <!-- Sorting Dropdown -->
                        <div class="relative">
                            <select id="sortFilter" class="w-full appearance-none bg-surface-container-low text-on-surface py-3 pl-4 pr-10 rounded-lg text-sm font-semibold focus:outline-none cursor-pointer border border-transparent focus:border-secondary/40">
                                <option value="date-asc">Tanggal Terdekat</option>
                                <option value="date-desc">Tanggal Terjauh</option>
                                <option value="seat-asc">Sisa Kuota Terbatas</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-3 top-3.5 pointer-events-none text-outline text-lg">sort</span>
                        </div>
                    </div>

                    <button type="button" 
                            id="applyFilterBtn"
                            class="px-6 py-3 bg-secondary hover:bg-secondary-container text-white rounded-lg font-headline text-sm font-bold flex items-center justify-center gap-2 transition-all shadow-md">
                        <span class="material-symbols-outlined text-[18px]">filter_alt</span>
                        <span>Terapkan</span>
                    </button>
                </div>

            </div>
        </div>

        <!-- ========================================== -->
        <!-- 2. FAST SEGMENT NAVIGATION STRIP           -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-low py-4 px-4 sm:px-6 lg:px-8 border-b border-outline-variant/50">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Target Category Segment Tabs -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0" id="categoryTabs">
                    <button type="button" 
                            class="category-tab active px-4 py-2 rounded-lg bg-primary text-white font-headline text-xs sm:text-sm font-bold whitespace-nowrap shadow-xs transition-all" 
                            data-category="all">
                        Semua Kegiatan <span class="ml-1 opacity-80 text-xs">({{ $trainings->total() }})</span>
                    </button>
                    <button type="button" 
                            class="category-tab px-4 py-2 rounded-lg bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-headline text-xs sm:text-sm font-semibold whitespace-nowrap transition-all border border-outline-variant/60" 
                            data-category="guru">
                        Guru &amp; Pendidik
                    </button>
                    <button type="button" 
                            class="category-tab px-4 py-2 rounded-lg bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-headline text-xs sm:text-sm font-semibold whitespace-nowrap transition-all border border-outline-variant/60" 
                            data-category="siswa">
                        Siswa &amp; Mahasiswa
                    </button>
                    <button type="button" 
                            class="category-tab px-4 py-2 rounded-lg bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-headline text-xs sm:text-sm font-semibold whitespace-nowrap transition-all border border-outline-variant/60" 
                            data-category="vokasi">
                        Vokasi &amp; Industri
                    </button>
                    <button type="button" 
                            class="category-tab px-4 py-2 rounded-lg bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-headline text-xs sm:text-sm font-semibold whitespace-nowrap transition-all border border-outline-variant/60" 
                            data-category="umum">
                        Masyarakat Umum
                    </button>
                </div>

                <!-- Quick Status Pills -->
                <div class="flex items-center gap-2 self-start md:self-auto overflow-x-auto">
                    <span class="text-xs text-outline uppercase tracking-wider font-bold hidden xl:inline">Status:</span>
                    <button type="button" class="status-pill active px-3 py-1 rounded-full text-xs font-bold bg-secondary text-white shadow-xs" data-status="all">
                        Semua Status
                    </button>
                    <button type="button" class="status-pill px-3 py-1 rounded-full text-xs font-semibold bg-surface-container-lowest text-on-surface-variant hover:text-on-surface border border-outline-variant/60" data-status="open">
                        Pendaftaran Dibuka
                    </button>
                    <button type="button" class="status-pill px-3 py-1 rounded-full text-xs font-semibold bg-surface-container-lowest text-on-surface-variant hover:text-on-surface border border-outline-variant/60" data-status="soon">
                        Segera Hadir
                    </button>
                </div>

            </div>
        </section>

        <!-- ========================================== -->
        <!-- 3. MAIN AGENDA CARD GRID SECTION           -->
        <!-- ========================================== -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 w-full">
            
            <!-- Result Count & Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-8 gap-2 border-b border-outline-variant/60 mb-8">
                <div class="flex items-center gap-3">
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Daftar Agenda Pelatihan Aktif</h2>
                    <span id="resultCountBadge" class="px-2.5 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold">
                        6 Agenda Ditampilkan
                    </span>
                </div>
                <div class="text-right hidden sm:block">
                    <span class="text-xs text-outline">Pembaruan jadwal kurikulum: Hari ini, terakreditasi resmi</span>
                </div>
            </div>

            <!-- Dynamic Agenda Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="agendaGrid">
                @forelse($trainings as $training)
                    @php
                        $thumbUrl = $training->thumbnail;
                        if ($thumbUrl && !\Illuminate\Support\Str::startsWith($thumbUrl, ['http://', 'https://'])) {
                            $thumbUrl = asset('storage/' . $thumbUrl);
                        }
                        if (!$thumbUrl) {
                            $thumbUrl = 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80';
                        }
                        
                        $isClosed = $training->registration_end && now()->gt($training->registration_end);
                        $isSoon = $training->registration_start && now()->lt($training->registration_start);
                        $statusFilter = $isClosed ? 'closed' : ($isSoon ? 'soon' : 'open');
                        
                        $audienceCategory = match($training->audience) {
                            \App\Enums\TrainingAudience::Guru => 'guru',
                            \App\Enums\TrainingAudience::Siswa => 'siswa',
                            \App\Enums\TrainingAudience::Vokasi => 'vokasi',
                            default => 'umum',
                        };

                        $firstSession = $training->sessions->sortBy('session_date')->first();
                    @endphp

                    <article class="agenda-card bg-surface-container-lowest rounded-xl overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group border border-outline-variant/70"
                             data-category="{{ $audienceCategory }}"
                             data-format="{{ $training->mode->value }}"
                             data-status="{{ $statusFilter }}"
                             data-title="{{ $training->title }}">
                        <div class="relative h-52 overflow-hidden bg-primary-container">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 alt="{{ $training->title }}" 
                                 src="{{ $thumbUrl }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/20 to-transparent"></div>
                            
                            <!-- Badges Top -->
                            <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
                                <span class="px-2.5 py-1 rounded bg-secondary text-white font-headline text-xs font-bold shadow-xs">
                                    {{ $training->audience->label() }}
                                </span>
                                <span class="px-2.5 py-1 rounded bg-surface-container-lowest/90 backdrop-blur-xs text-primary font-headline text-xs font-semibold shadow-xs flex items-center gap-1">
                                    <span class="material-symbols-outlined text-xs text-secondary">{{ $training->mode->icon() }}</span>
                                    <span>{{ $training->mode->label() }}</span>
                                </span>
                            </div>

                            <!-- Badges Bottom -->
                            <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between text-white">
                                <span class="text-xs font-medium flex items-center gap-1 bg-primary/80 backdrop-blur-xs px-2.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-[14px] text-tertiary-fixed-dim">event</span>
                                    {{ $training->start_date->format('d M Y') }}
                                </span>
                                @if($training->quota)
                                    <span class="text-[11px] bg-tertiary-fixed text-on-tertiary-fixed px-2 py-0.5 rounded font-bold">
                                        Kuota: {{ $training->quota }} Peserta
                                    </span>
                                @else
                                    <span class="text-[11px] bg-secondary-fixed text-on-secondary-fixed px-2 py-0.5 rounded font-bold">
                                        Terbuka Luas
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between gap-5">
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2 text-outline text-xs">
                                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                                    @if($firstSession)
                                        <span>{{ substr($firstSession->start_time, 0, 5) }} - {{ substr($firstSession->end_time, 0, 5) }} WIB</span>
                                    @else
                                        <span>{{ $training->start_date->format('d M') }} - {{ $training->end_date->format('d M Y') }}</span>
                                    @endif
                                    <span>•</span>
                                    <span class="font-bold {{ $training->is_free ? 'text-tertiary' : 'text-primary' }}">
                                        {{ $training->is_free ? '100% Gratis' : 'Rp ' . number_format($training->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <h3 class="font-headline text-base sm:text-lg font-bold text-on-surface group-hover:text-secondary transition-colors line-clamp-2 leading-snug">
                                    <a href="{{ route('agenda.detail', $training->slug) }}">
                                        {{ $training->title }}
                                    </a>
                                </h3>
                                <p class="text-xs sm:text-sm text-on-surface-variant line-clamp-2 leading-relaxed">
                                    {{ $training->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-outline-variant/50 flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    @if($isClosed)
                                        <span class="w-2 h-2 rounded-full bg-error"></span>
                                        <span class="text-xs font-bold text-error">Pendaftaran Ditutup</span>
                                    @elseif($isSoon)
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        <span class="text-xs font-bold text-amber-600">Segera Dibuka</span>
                                    @else
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <span class="text-xs font-bold text-emerald-700">Pendaftaran Dibuka</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <a class="px-3 py-1.5 rounded-lg bg-surface-container text-primary font-headline text-xs font-bold hover:bg-surface-container-high transition-all" 
                                       href="{{ route('agenda.detail', $training->slug) }}">
                                        Detail
                                    </a>
                                    <a class="px-3.5 py-1.5 rounded-lg bg-secondary text-white font-headline text-xs font-bold hover:bg-secondary-container transition-all flex items-center gap-1 shadow-xs" 
                                       href="{{ route('register') }}">
                                        <span>Daftar</span>
                                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12 text-outline">
                        <span class="material-symbols-outlined text-4xl mb-2 text-outline/60">school</span>
                        <p class="font-headline font-bold text-base text-primary">Belum Ada Agenda Pelatihan</p>
                        <p class="text-xs text-on-surface-variant">Agenda pelatihan yang diterbitkan akan ditampilkan di sini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Empty State (hidden by default) -->
            <div id="noResultsState" class="hidden text-center py-16 bg-surface-container-low rounded-xl border border-outline-variant/60 my-6">
                <span class="material-symbols-outlined text-4xl text-outline mb-2">event_busy</span>
                <h3 class="font-headline text-lg font-bold text-primary">Tidak Ada Agenda yang Sesuai</h3>
                <p class="text-sm text-on-surface-variant mt-1">Coba sesuaikan kata kunci pencarian atau ubah filter kategori yang dipilih.</p>
                <button type="button" onclick="resetAgendaFilters()" class="mt-4 px-4 py-2 bg-secondary text-white text-xs font-bold rounded-lg shadow-xs hover:bg-secondary-container transition-all">
                    Reset Filter
                </button>
            </div>

            <!-- Pagination & Catalog Control -->
            @if($trainings->hasPages())
                <div class="mt-12 bg-surface-container-lowest rounded-xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xs border border-outline-variant/60">
                    <div class="text-xs sm:text-sm text-on-surface-variant">
                        Menampilkan <span class="font-bold text-primary">{{ $trainings->firstItem() }} - {{ $trainings->lastItem() }}</span> dari <span class="font-bold text-primary">{{ $trainings->total() }}</span> agenda aktif
                    </div>
                    <div>
                        {{ $trainings->links() }}
                    </div>
                </div>
            @endif
        </section>

        <!-- ========================================== -->
        <!-- 4. REGISTRATION STEPS (3 LANGKAH MUDAH)     -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container py-12 sm:py-16 px-4 sm:px-6 lg:px-8 border-y border-outline-variant/50">
            <div class="max-w-7xl mx-auto flex flex-col gap-8">
                
                <div class="text-center max-w-2xl mx-auto flex flex-col gap-2">
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Alur Pendaftaran Pelatihan Sederhana &amp; Transparan</h2>
                    <p class="text-sm sm:text-base text-on-surface-variant">Ikuti tiga tahapan ringkas untuk mengamankan kursi pelatihan dan mengakses materi sertifikasi resmi.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Step 1 -->
                    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-xs flex flex-col gap-3 hover:-translate-y-1 transition-transform border border-outline-variant/60">
                        <div class="w-12 h-12 rounded-xl bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed">
                            <span class="material-symbols-outlined text-2xl text-secondary">event_available</span>
                        </div>
                        <h3 class="font-headline text-lg font-bold text-primary">Pilih Agenda Sesuai Minat</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Telusuri silabus materi, jadwal sesi, profil fasilitator terverifikasi, dan format pertemuan yang paling relevan dengan kebutuhan institusi Anda.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-xs flex flex-col gap-3 hover:-translate-y-1 transition-transform border border-outline-variant/60">
                        <div class="w-12 h-12 rounded-xl bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed">
                            <span class="material-symbols-outlined text-2xl text-secondary">app_registration</span>
                        </div>
                        <h3 class="font-headline text-lg font-bold text-primary">Lengkapi Data Pendaftaran</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Isi formulir biodata peserta atau rombongan sekolah secara digital, konfirmasi kehadiran, dan terima tiket resmi melalui sistem portal.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-surface-container-lowest rounded-xl p-6 shadow-xs flex flex-col gap-3 hover:-translate-y-1 transition-transform border border-outline-variant/60">
                        <div class="w-12 h-12 rounded-xl bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed">
                            <span class="material-symbols-outlined text-2xl text-secondary">workspace_premium</span>
                        </div>
                        <h3 class="font-headline text-lg font-bold text-primary">Akses Pembelajaran &amp; Sertifikat</h3>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Ikuti sesi interaktif bersama narasumber ahli, unduh materi modul lengkap, dan dapatkan e-sertifikat bernomor verifikasi resmi nasional.
                        </p>
                    </div>
                </div>

                <!-- Quick Assistance Banner -->
                <div class="mt-4 p-5 sm:p-6 rounded-xl bg-primary-container text-white flex flex-col md:flex-row items-center justify-between gap-5 border border-primary">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-secondary flex items-center justify-center shrink-0 text-white shadow-xs">
                            <span class="material-symbols-outlined text-2xl">support_agent</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-headline text-base sm:text-lg font-bold">Butuh Pelatihan In-House Khusus Sekolah atau Lembaga?</span>
                            <span class="text-xs sm:text-sm text-on-primary-container">Kami menyediakan kurikulum kustom terakreditasi sesuai kebutuhan khusus organisasi Anda.</span>
                        </div>
                    </div>
                    <a class="px-6 py-3 rounded-lg bg-surface-container-lowest text-primary hover:bg-white font-headline text-xs sm:text-sm font-bold transition-colors whitespace-nowrap shadow-xs" href="{{ url('/kontak') }}">
                        Konsultasi Tim Ahli
                    </a>
                </div>

            </div>
        