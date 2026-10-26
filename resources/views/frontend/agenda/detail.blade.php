@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-20 bg-surface">
    <div class="flex flex-col w-full">

        <!-- ========================================== -->
        <!-- 1. TOP UTILITY BAR: BREADCRUMB & PROGRAM ID -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-low py-3 border-b border-outline-variant/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-wrap items-center justify-between gap-3">
                <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-on-surface-variant text-xs sm:text-sm flex-wrap">
                    <a class="hover:text-secondary flex items-center gap-1 transition-colors font-medium" href="{{ url('/') }}">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <a class="hover:text-secondary transition-colors font-medium" href="{{ url('/agenda') }}">
                        Agenda Pelatihan
                    </a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <span class="text-on-surface font-semibold truncate max-w-[240px] sm:max-w-md">
                        {{ $training->title }}
                    </span>
                </nav>
                <div class="flex items-center gap-2 text-on-surface-variant text-xs font-medium">
                    <span class="inline-flex h-2 w-2 rounded-full bg-secondary animate-pulse"></span>
                    <span>Kode Program: <strong class="text-primary font-bold">#TRN-{{ str_pad($training->id, 4, '0', STR_PAD_LEFT) }}</strong></span>
                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 2. HERO HEADER OVERVIEW                    -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-lowest border-b border-outline-variant/60 shadow-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
                <div class="flex flex-col gap-5">
                    
                    <!-- Badges & Status -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container text-secondary font-headline text-xs font-bold">
                            <span class="material-symbols-outlined text-[16px]">school</span>
                            {{ $training->audience->label() }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-container text-on-surface-variant font-headline text-xs font-semibold">
                            <span class="material-symbols-outlined text-[16px]">{{ $training->mode->icon() }}</span>
                            {{ $training->mode->label() }}
                        </span>

                        @if($training->is_free)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-900 font-headline text-xs font-bold">
                                <span class="material-symbols-outlined text-[16px] text-emerald-700">redeem</span>
                                100% Gratis
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-headline text-xs font-bold shadow-2xs">
                                <span class="material-symbols-outlined text-[16px]">monetization_on</span>
                                Rp {{ number_format($training->price, 0, ',', '.') }}
                            </span>
                        @endif

                        @if($training->registration_start && now()->lt($training->registration_start))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-800 font-headline text-xs font-bold ml-auto sm:ml-0 border border-amber-200">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                Segera Dibuka
                            </span>
                        @elseif($training->registration_end && now()->gt($training->registration_end))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-800 font-headline text-xs font-bold ml-auto sm:ml-0 border border-red-200">
                                <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                Pendaftaran Ditutup
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 font-headline text-xs font-bold ml-auto sm:ml-0 border border-emerald-200">
                                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                Pendaftaran Dibuka
                            </span>
                        @endif
                    </div>

                    <!-- Title & Subtitle -->
                    <div class="flex flex-col gap-2 max-w-5xl">
                        <h1 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary tracking-tight leading-tight">
                            {{ $training->title }}
                        </h1>
                        <p class="text-sm sm:text-base text-on-surface-variant max-w-4xl leading-relaxed">
                            Program pelatihan intensif kategori <strong>{{ $training->category?->name ?? 'Pengembangan Kompetensi' }}</strong> yang dirancang untuk membekali {{ strtolower($training->audience->label()) }} dengan kurikulum standar mutu nasional.
                        </p>
                    </div>

                    <!-- Key Meta Snapshot Strip -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-3 bg-surface-container-low p-4 sm:p-5 rounded-xl border border-outline-variant/60">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-secondary shadow-xs">
                                <span class="material-symbols-outlined">calendar_today</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] sm:text-[11px] text-outline uppercase tracking-wider font-semibold">Tanggal Kegiatan</span>
                                <span class="font-headline text-xs sm:text-sm font-bold text-on-surface">
                                    {{ $training->start_date->format('d M') }} – {{ $training->end_date->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-secondary shadow-xs">
                                <span class="material-symbols-outlined">schedule</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] sm:text-[11px] text-outline uppercase tracking-wider font-semibold">Durasi Pelatihan</span>
                                <span class="font-headline text-xs sm:text-sm font-bold text-on-surface">
                                    {{ $training->start_date->diffInDays($training->end_date) + 1 }} Hari Kegiatan
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-secondary shadow-xs">
                                <span class="material-symbols-outlined">cast_for_education</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] sm:text-[11px] text-outline uppercase tracking-wider font-semibold">Metode Belajar</span>
                                <span class="font-headline text-xs sm:text-sm font-bold text-on-surface truncate max-w-[140px] sm:max-w-none">
                                    {{ $training->mode->label() }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-surface-container-lowest flex items-center justify-center text-secondary shadow-xs">
                                <span class="material-symbols-outlined">category</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] sm:text-[11px] text-outline uppercase tracking-wider font-semibold">Kategori Bidang</span>
                                <span class="font-headline text-xs sm:text-sm font-bold text-on-surface truncate max-w-[140px] sm:max-w-none">
                                    {{ $training->category?->name ?? 'Pelatihan Umum' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 3. MAIN BODY CONTENT (TWO COLUMNS LAYOUT)  -->
        <!-- ========================================== -->
        <section class="w-full py-10 lg:py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Left Column: Detailed Content (8 cols) -->
                    <div class="lg:col-span-8 flex flex-col gap-8">
                        
                        <!-- Event Media Presentation Card (Poster Banner) -->
                        @php
                            $bannerUrl = null;
                            if ($training->thumbnail) {
                                $bannerUrl = \Illuminate\Support\Str::startsWith($training->thumbnail, ['http://', 'https://'])
                                    ? $training->thumbnail
                                    : asset('storage/' . $training->thumbnail);
                            }
                        @endphp
                        <div class="bg-surface-container-lowest rounded-2xl shadow-sm overflow-hidden flex flex-col border border-outline-variant/60">
                            <div class="relative w-full h-[280px] sm:h-[400px] overflow-hidden bg-primary-container">
                                @if($bannerUrl)
                                    <img class="w-full h-full object-cover" 
                                         alt="{{ $training->title }}" 
                                         src="{{ $bannerUrl }}" />
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center p-8 bg-linear-to-br from-primary to-primary-container text-white text-center">
                                        <span class="material-symbols-outlined text-6xl text-white/50 mb-2">school</span>
                                        <span class="font-headline text-lg font-bold">{{ $training->title }}</span>
                                        <span class="text-xs text-white/80 mt-1">Akademi Pelatihan Indonesia</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-primary/85 via-primary/20 to-transparent flex items-end p-5 sm:p-7">
                                    <div class="flex flex-wrap items-center justify-between gap-3 w-full text-white">
                                        <div class="flex items-center gap-3">
                                            <span class="material-symbols-outlined text-tertiary-fixed-dim text-[32px]">workspace_premium</span>
                                            <div class="flex flex-col">
                                                <span class="font-headline text-base sm:text-lg font-bold text-white">E-Sertifikat Resmi Terverifikasi</span>
                                                <span class="text-xs text-white/80">Terhubung ke Pangkalan Data Nasional Akademi Pelatihan</span>
                                            </div>
                                        </div>
                                        <div class="px-3 py-1.5 rounded-lg bg-secondary text-white font-headline text-xs font-bold tracking-wide flex items-center gap-1 shadow-md">
                                            <span class="material-symbols-outlined text-[16px]">military_tech</span>
                                            Terstandarisasi
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Navigation Anchor Strip -->
                            <div class="bg-surface-container-low px-4 py-3 flex items-center gap-4 overflow-x-auto text-on-surface-variant text-xs sm:text-sm font-semibold border-t border-outline-variant/50">
                                <a class="hover:text-secondary whitespace-nowrap py-1 transition-colors" href="#deskripsi">Deskripsi</a>
                                <span class="text-outline-variant">•</span>
                                <a class="hover:text-secondary whitespace-nowrap py-1 transition-colors" href="#akses">Akses &amp; Lokasi</a>
                                <span class="text-outline-variant">•</span>
                                <a class="hover:text-secondary whitespace-nowrap py-1 transition-colors" href="#silabus">Sesi Pertemuan</a>
                                <span class="text-outline-variant">•</span>
                                <a class="hover:text-secondary whitespace-nowrap py-1 transition-colors" href="#fasilitator">Instruktur</a>
                                <span class="text-outline-variant">•</span>
                                <a class="hover:text-secondary whitespace-nowrap py-1 transition-colors" href="#fasilitas">Fasilitas</a>
                            </div>
                        </div>

                        <!-- Section: Deskripsi Lengkap -->
                        <article class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl shadow-xs border border-outline-variant/60 flex flex-col gap-4" id="deskripsi">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary text-[26px]">description</span>
                                <h2 class="font-headline text-xl font-bold text-primary">Deskripsi Lengkap Pelatihan</h2>
                            </div>
                            <div class="text-xs sm:text-sm text-on-surface leading-relaxed whitespace-pre-line">
                                {{ $training->description }}
                            </div>
                            
                            <div class="bg-surface-container-low p-4 sm:p-5 rounded-xl flex items-start gap-3.5 mt-2 border border-outline-variant/50">
                                <span class="material-symbols-outlined text-secondary text-[24px] mt-0.5">lightbulb</span>
                                <div class="flex flex-col gap-1">
                                    <span class="font-headline text-xs sm:text-sm font-bold text-primary">Kompetensi Terapan Nyata</span>
                                    <span class="text-xs text-on-surface-variant leading-relaxed">
                                        Setiap modul dan tugas terstruktur disiapkan untuk menghasilkan portofolio langsung pakai yang relevan dengan perkembangan keahlian masa kini.
                                    </span>
                                </div>
                            </div>
                        </article>

                        <!-- Section: Akses & Lokasi Pelaksanaan -->
                        <section class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl shadow-xs border border-outline-variant/60 flex flex-col gap-4" id="akses">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary text-[26px]">explore</span>
                                <h2 class="font-headline text-xl font-bold text-primary">Akses &amp; Lokasi Pelaksanaan</h2>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-1">
                                @if($training->location)
                                    <div class="p-4 rounded-xl bg-surface-container-low flex flex-col gap-1.5 border border-outline-variant/40">
                                        <div class="flex items-center gap-2 text-primary font-headline text-xs font-bold">
                                            <span class="material-symbols-outlined text-secondary text-[20px]">location_on</span>
                                            <span>Venue Tatap Muka Fisik</span>
                                        </div>
                                        <p class="text-xs text-on-surface font-medium leading-relaxed">
                                            {{ $training->location }}
                                        </p>
                                        <span class="text-[11px] text-outline">Harap hadir 15 menit sebelum sesi pelatihan dimulai.</span>
                                    </div>
                                @endif

                                @if($training->meeting_url)
                                    <div class="p-4 rounded-xl bg-surface-container-low flex flex-col gap-1.5 border border-outline-variant/40">
                                        <div class="flex items-center gap-2 text-primary font-headline text-xs font-bold">
                                            <span class="material-symbols-outlined text-secondary text-[20px]">videocam</span>
                                            <span>Pertemuan Virtual Daring</span>
                                        </div>
                                        <p class="text-xs text-on-surface font-medium leading-relaxed">
                                            Tatap muka daring diselenggarakan melalui Zoom Meeting / Google Meet interaktif.
                                        </p>
                                        <span class="text-[11px] text-secondary font-semibold">Tautan resmi dibagikan kepada peserta yang terdaftar resmi.</span>
                                    </div>
                                @endif

                                @if(!$training->location && !$training->meeting_url)
                                    <div class="md:col-span-2 p-4 rounded-xl bg-surface-container-low text-xs text-outline italic border border-outline-variant/40">
                                        Informasi detail ruangan dan tautan ruang temu akan diumumkan melalui dashboard peserta sebelum pelaksanaan.
                                    </div>
                                @endif
                            </div>
                        </section>

                        <!-- Section: Silabus & Jadwal Sesi -->
                        <section class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl shadow-xs border border-outline-variant/60 flex flex-col gap-5" id="silabus">
                            <div class="flex flex-wrap items-center justify-between gap-3 pb-2 border-b border-outline-variant/40">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-secondary text-[26px]">format_list_bulleted</span>
                                    <div>
                                        <h2 class="font-headline text-xl font-bold text-primary">Agenda &amp; Sesi Pertemuan</h2>
                                        <p class="text-xs text-outline">Rangkaian sesi terstruktur yang dibimbing oleh instruktur ahli</p>
                                    </div>
                                </div>
                                <span class="text-xs bg-surface-container text-primary font-bold px-3 py-1 rounded-full">
                                    {{ $training->sessions->count() }} Sesi Terjadwal
                                </span>
                            </div>

                            <div class="flex flex-col gap-3">
                                @forelse($training->sessions as $index => $session)
                                    <div class="rounded-xl bg-surface-container-low p-4 sm:p-5 flex flex-col gap-2.5 border border-outline-variant/50">
                                        <div class="flex flex-wrap items-center justify-between gap-2">
                                            <div class="flex items-center gap-3">
                                                <span class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-bold text-xs">
                                                    {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                                                </span>
                                                <span class="font-headline text-xs sm:text-sm font-bold text-primary">
                                                    {{ $session->title }}
                                                </span>
                                            </div>
                                            <span class="text-xs px-2.5 py-0.5 rounded-md bg-surface-container-highest text-primary font-bold">
                                                {{ $session->session_type->label() }}
                                            </span>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-4 text-xs text-on-surface-variant font-medium pt-1 border-t border-outline-variant/40">
                                            <span class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-secondary text-[16px]">calendar_today</span>
                                                <span>{{ $session->session_date->format('d M Y') }}</span>
                                            </span>
                                            <span class="flex items-center gap-1.5">
                                                <span class="material-symbols-outlined text-secondary text-[16px]">schedule</span>
                                                <span>{{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }} WIB</span>
                                            </span>
                                            @if($session->location)
                                                <span class="flex items-center gap-1.5">
                                                    <span class="material-symbols-outlined text-secondary text-[16px]">location_on</span>
                                                    <span>{{ $session->location }}</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-6 rounded-xl bg-surface-container-low text-center border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-3xl text-outline mb-1">event_available</span>
                                        <p class="text-xs font-semibold text-primary">Jadwal Sesi Terstruktur</p>
                                        <p class="text-[11px] text-outline mt-0.5">Rincian jam dan modul ajar per sesi akan dipublikasikan oleh instruktur pengampu menjelang hari pelaksanaan.</p>
                                    </div>
                                @endforelse
                            </div>
                        </section>

                        <!-- Section: Instruktur Pengampu -->
                        <section class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl shadow-xs border border-outline-variant/60 flex flex-col gap-4" id="fasilitator">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary text-[26px]">co_present</span>
                                <div>
                                    <h2 class="font-headline text-xl font-bold text-primary">Instruktur / Tentor Pengampu</h2>
                                    <p class="text-xs text-outline">Praktisi dan akademisi berpengalaman di bidangnya</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-1">
                                @forelse($training->instructors as $instructor)
                                    @php
                                        $instAvatar = null;
                                        if ($instructor->avatar) {
                                            $instAvatar = \Illuminate\Support\Str::startsWith($instructor->avatar, ['http://', 'https://'])
                                                ? $instructor->avatar
                                                : asset('storage/' . $instructor->avatar);
                                        }
                                    @endphp
                                    <div class="p-5 rounded-xl bg-surface-container-low flex flex-col gap-3 border border-outline-variant/40">
                                        <div class="flex items-center gap-3.5">
                                            @if($instAvatar)
                                                <img src="{{ $instAvatar }}" alt="{{ $instructor->name }}" class="w-14 h-14 rounded-full object-cover shrink-0 ring-2 ring-secondary/20 shadow-xs" />
                                            @else
                                                <div class="w-14 h-14 rounded-full bg-secondary text-white flex items-center justify-center font-headline text-lg font-bold shadow-xs shrink-0 ring-2 ring-secondary/20">
                                                    {{ strtoupper(substr($instructor->name, 0, 2)) }}
                                                </div>
                                            @endif
                                            <div class="flex flex-col min-w-0">
                                                <h3 class="font-headline text-sm font-bold text-primary truncate">{{ $instructor->name }}</h3>
                                                <span class="text-xs text-secondary font-semibold truncate">{{ $instructor->expertise ?? 'Instruktur Ahli' }}</span>
                                                <span class="text-[11px] text-on-surface-variant truncate">{{ $instructor->institution ?? 'Akademi Pelatihan Indonesia' }}</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-on-surface-variant leading-relaxed">
                                            {{ $instructor->bio ?? 'Berdedikasi dalam membina dan meningkatkan kapasitas keahlian peserta dengan pendekatan aplikatif dan interaktif.' }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="sm:col-span-2 p-5 rounded-xl bg-surface-container-low text-center border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-3xl text-outline mb-1">co_present</span>
                                        <p class="text-xs font-semibold text-primary">Instruktur Terstandarisasi</p>
                                        <p class="text-[11px] text-outline mt-0.5">Program ini diampu oleh instruktur bersertifikasi dari jejaring Dewan Kurikulum Akademi Pelatihan Indonesia.</p>
                                    </div>
                                @endforelse
                            </div>
                        </section>

                        <!-- Section: Fasilitas Peserta -->
                        <section class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl shadow-xs border border-outline-variant/60 flex flex-col gap-5" id="fasilitas">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary text-[26px]">inventory_2</span>
                                <h2 class="font-headline text-xl font-bold text-primary">Fasilitas Peserta Pelatihan</h2>
                            </div>

                            @if(!empty($training->facilities) && count($training->facilities) > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-1">
                                    @foreach($training->facilities as $fac)
                                        <div class="p-4 rounded-xl bg-surface-container-low flex items-start gap-3 border border-outline-variant/40 hover:border-secondary/50 transition-colors">
                                            <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0 mt-0.5">
                                                <span class="material-symbols-outlined text-[20px]">verified</span>
                                            </div>
                                            <div>
                                                <span class="font-headline text-sm font-bold text-primary block">{{ $fac }}</span>
                                                <span class="text-xs text-on-surface-variant">Fasilitas resmi yang otomatis diperoleh setiap peserta terdaftar.</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-1">
                                    <div class="p-4 rounded-xl bg-surface-container-low flex items-start gap-3 border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-secondary text-[22px] shrink-0 mt-0.5">verified</span>
                                        <div>
                                            <span class="font-headline text-xs font-bold text-primary block">E-Sertifikat Resmi</span>
                                            <span class="text-xs text-on-surface-variant">Sertifikat ber-barcode resmi dapat diverifikasi pada basis data nasional.</span>
                                        </div>
                                    </div>

                                    <div class="p-4 rounded-xl bg-surface-container-low flex items-start gap-3 border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-secondary text-[22px] shrink-0 mt-0.5">menu_book</span>
                                        <div>
                                            <span class="font-headline text-xs font-bold text-primary block">Akses Materi &amp; Modul Ajar</span>
                                            <span class="text-xs text-on-surface-variant">Modul terstruktur, bahan tayang, dan panduan praktikum siap unduh.</span>
                                        </div>
                                    </div>

                                    <div class="p-4 rounded-xl bg-surface-container-low flex items-start gap-3 border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-secondary text-[22px] shrink-0 mt-0.5">groups</span>
                                        <div>
                                            <span class="font-headline text-xs font-bold text-primary block">Grup Diskusi &amp; Bimbingan</span>
                                            <span class="text-xs text-on-surface-variant">Forum tanya jawab langsung bersama narasumber dan sesama peserta.</span>
                                        </div>
                                    </div>

                                    <div class="p-4 rounded-xl bg-surface-container-low flex items-start gap-3 border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-secondary text-[22px] shrink-0 mt-0.5">workspace_premium</span>
                                        <div>
                                            <span class="font-headline text-xs font-bold text-primary block">Akses Rekaman Sesi</span>
                                            <span class="text-xs text-on-surface-variant">Dapat ditonton ulang kapan saja melalui portal peserta.</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </section>

                    </div>

                    <!-- Right Column: Sticky Booking Card & Registration Panel (4 cols) -->
                    <div class="lg:col-span-4 flex flex-col gap-6 sticky top-24">
                        
                        <!-- Main Registration Box -->
                        <div class="bg-surface-container-lowest rounded-2xl shadow-xl p-6 sm:p-7 flex flex-col gap-5 border border-outline-variant/60">
                            
                            <!-- Pricing Row -->
                            <div class="flex flex-col gap-1">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-outline uppercase tracking-wider font-semibold">Investasi Pelatihan</span>
                                    @if($training->is_free)
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-headline text-xs font-bold">100% Gratis</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed font-headline text-xs font-bold">Tarif Resmi</span>
                                    @endif
                                </div>
                                <div class="flex items-baseline gap-2 mt-1">
                                    @if($training->is_free)
                                        <span class="font-headline text-3xl font-extrabold text-tertiary">GRATIS</span>
                                    @else
                                        <span class="font-headline text-3xl font-extrabold text-secondary">Rp {{ number_format($training->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>
                                <span class="text-[11px] text-on-surface-variant font-medium">
                                    {{ $training->is_free ? 'Pendaftaran bebas biaya untuk seluruh peserta' : 'Biaya resmi termasuk modul, bimbingan, & sertifikasi' }}
                                </span>
                            </div>

                            <!-- Quota Indicator Box -->
                            <div class="bg-surface-container-low p-4 rounded-xl flex flex-col gap-2 border border-outline-variant/40">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-on-surface font-bold flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[16px] text-secondary">people</span>
                                        <span>Batas Kuota Peserta</span>
                                    </span>
                                    <span class="font-extrabold text-primary">
                                        {{ $training->quota ? $training->quota . ' Peserta' : 'Tanpa Batas Kuota' }}
                                    </span>
                                </div>
                                <div class="text-[11px] text-outline">
                                    {{ $training->quota ? 'Pendaftaran ditutup otomatis jika kuota terpenuhi' : 'Terbuka fleksibel selama masa pendaftaran berlangsung' }}
                                </div>
                            </div>

                            <!-- Deadline Alert -->
                            <div class="flex items-center gap-3 p-3 bg-surface-container rounded-xl text-primary border border-outline-variant/40">
                                <span class="material-symbols-outlined text-secondary text-[24px]">timer</span>
                                <div class="flex flex-col">
                                    <span class="font-headline text-xs font-bold">Masa Pendaftaran:</span>
                                    <span class="text-[11px] text-on-surface-variant">
                                        @if($training->registration_start && $training->registration_end)
                                            {{ $training->registration_start->format('d M') }} - {{ $training->registration_end->format('d M Y') }}
                                        @elseif($training->registration_end)
                                            s.d. {{ $training->registration_end->format('d M Y') }}
                                        @else
                                            Terbuka hingga hari H ({{ $training->start_date->format('d M Y') }})
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Primary CTA Button -->
                            <div class="flex flex-col gap-2 pt-1">
                                <a href="{{ route('register') }}" 
                                   class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-secondary text-white font-headline text-sm font-bold shadow-md hover:bg-secondary-container transition-all text-center">
                                    <span>Daftar Pelatihan Sekarang</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                                <p class="text-[11px] text-outline text-center leading-relaxed">
                                    Sudah memiliki akun? <a href="{{ route('login') }}" class="text-secondary font-bold hover:underline">Masuk di sini</a> untuk mendaftar lebih cepat.
                                </p>
                            </div>

                            <!-- Secondary Actions -->
                            <div class="pt-3 border-t border-outline-variant/50 flex flex-col gap-2.5">
                                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Akademi Pelatihan, saya ingin bertanya mengenai program: ' . $training->title) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="flex items-center justify-center gap-1.5 text-secondary hover:underline text-xs font-semibold py-1">
                                    <span class="material-symbols-outlined text-[16px]">chat</span>
                                    <span>Tanya Panitia via WhatsApp</span>
                                </a>
                            </div>

                        </div>

                        <!-- Trust & Security Verification Card -->
                        <div class="bg-surface-container-lowest rounded-2xl shadow-sm p-5 flex flex-col gap-3.5 border border-outline-variant/60">
                            <span class="font-headline text-xs text-primary font-bold tracking-wide uppercase">Jaminan &amp; Keamanan</span>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary shrink-0">
                                    <span class="material-symbols-outlined text-[18px]">qr_code_2</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline text-xs font-bold text-on-surface">100% Verifikasi QR-Code</span>
                                    <span class="text-[11px] text-outline">Nomor sertifikat resmi tersinkronisasi</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary shrink-0">
                                    <span class="material-symbols-outlined text-[18px]">all_inclusive</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-headline text-xs font-bold text-on-surface">Akses Bahan Ajar</span>
                                    <span class="text-[11px] text-outline">Modul materi dapat diakses tanpa kedaluwarsa</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    </div>
</div>
@endsection
