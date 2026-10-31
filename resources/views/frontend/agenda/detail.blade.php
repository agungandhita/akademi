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
                            @if($bannerUrl)
                                <!-- Poster Image Full Display (No Crop) -->
                                <div class="relative w-full bg-surface-container-low/60 flex items-center justify-center overflow-hidden">
                                    <img class="w-full h-auto max-h-[85vh] object-contain mx-auto" 
                                         alt="{{ $training->title }}" 
                                         src="{{ $bannerUrl }}" />
                                </div>
                            @else
                                <div class="w-full h-[280px] sm:h-[360px] flex flex-col items-center justify-center p-8 bg-primary bg-gradient-to-br from-primary to-primary-container text-white text-center">
                                    <span class="material-symbols-outlined text-6xl text-white/50 mb-2">school</span>
                                    <span class="font-headline text-lg font-bold">{{ $training->title }}</span>
                                    <span class="text-xs text-white/80 mt-1">Akademi Pelatihan Indonesia</span>
                                </div>
                            @endif

                            <!-- Certificate Guarantee Strip (Cleanly Placed Below Poster) -->
                            <div class="bg-primary px-5 py-3.5 sm:px-6 flex flex-wrap items-center justify-between gap-3 text-white border-t border-primary/20">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-[28px] shrink-0">workspace_premium</span>
                                    <div class="flex flex-col">
                                        <span class="font-headline text-xs sm:text-sm font-bold text-white leading-tight">E-Sertifikat Resmi Terverifikasi</span>
                                        <span class="text-[11px] text-white/80">Terhubung ke Pangkalan Data Nasional Akademi Pelatihan</span>
                                    </div>
                                </div>
                                <div class="px-2.5 py-1 rounded-lg bg-secondary text-white font-headline text-[11px] font-bold tracking-wide flex items-center gap-1 shadow-xs shrink-0">
                                    <span class="material-symbols-outlined text-[14px]">military_tech</span>
                                    <span>Terstandarisasi</span>
                                </div>
                            </div>

                            <!-- Quick Navigation Anchor Strip -->
                            <div class="bg-surface-container-low px-4 py-3 flex items-center gap-4 overflow-x-auto text-on-surface-variant text-xs sm:text-sm font-semibold border-t border-outline-variant/50">
                                <a class="hover:text-secondary whitespace-nowrap py-1 transition-colors" href="#deskripsi">Deskripsi</a>
                                <span class="text-outline-variant">•</span>
                                <a class="hover:text-secondary whitespace-nowrap py-1 transition-colors" href="#modul">Kurikulum &amp; Modul</a>
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

                        <!-- Section: Kurikulum & Modul Pembelajaran (PST-05, TNT-04) -->
                        <section class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl shadow-xs border border-outline-variant/60 flex flex-col gap-5" id="modul">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-secondary text-[26px]">menu_book</span>
                                    <div>
                                        <h2 class="font-headline text-xl font-bold text-primary">Kurikulum &amp; Modul Pembelajaran</h2>
                                        <p class="text-xs text-outline">Modul ajar, dokumen resmi, dan materi penunjang dari instruktur</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold self-start sm:self-auto">
                                    {{ $training->modules->count() }} Modul Tersedia
                                </span>
                            </div>

                            <div class="divide-y divide-outline-variant/30 border border-outline-variant/40 rounded-xl overflow-hidden bg-surface-container-low/20">
                                @forelse ($training->modules as $idx => $modul)
                                    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-surface-container-low/50 transition-colors">
                                        <div class="flex items-start gap-3.5 flex-1">
                                            <div class="w-10 h-10 rounded-xl {{ $modul->type->badgeClass() }} flex items-center justify-center shrink-0 font-bold shadow-2xs">
                                                <span class="material-symbols-outlined text-[20px]">{{ $modul->type->icon() }}</span>
                                            </div>
                                            <div class="min-w-0 flex-1 space-y-1">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-[10px] font-bold text-outline uppercase tracking-wider">
                                                        Modul #{{ $modul->sort_order ?: ($idx + 1) }}
                                                    </span>
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $modul->type->badgeClass() }}">
                                                        {{ $modul->type->label() }}
                                                    </span>
                                                </div>
                                                <h3 class="font-headline text-sm font-bold text-primary">
                                                    {{ $modul->title }}
                                                </h3>
                                                @if($modul->description)
                                                    <p class="text-xs text-on-surface-variant line-clamp-1">
                                                        {{ $modul->description }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="self-end sm:self-center shrink-0">
                                            @if($isEnrolled)
                                                <a href="{{ route('peserta.trainings.modules.show', [$training->id, $modul->id]) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-colors">
                                                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                                    <span>Buka Modul</span>
                                                </a>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container text-outline text-xs font-semibold" title="Daftar pelatihan ini untuk membuka akses penuh ke modul materi">
                                                    <span class="material-symbols-outlined text-[14px]">lock</span>
                                                    <span>Terkunci</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center text-xs text-on-surface-variant">
                                        <span class="material-symbols-outlined text-3xl text-outline mb-1">menu_book</span>
                                        <p class="font-semibold text-primary">Modul Pembelajaran Dalam Penyusunan</p>
                                        <p class="text-outline text-[11px] mt-0.5">Materi tayang, dokumen bacaan, dan tugas mandiri akan dipublikasikan oleh instruktur.</p>
                                    </div>
                                @endforelse
                            </div>
                        </section>

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

                                @if(!empty($isEnrolled) && $training->whatsapp_group_link)
                                    <div class="p-4 rounded-xl bg-emerald-50/70 border border-emerald-200/80 flex flex-col gap-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2 text-emerald-950 font-headline text-xs font-bold">
                                                <span class="material-symbols-outlined text-[#25D366] text-[20px]">chat</span>
                                                <span>Grup WhatsApp Koordinasi</span>
                                            </div>
                                            <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-200 text-emerald-900 font-bold">Terdaftar</span>
                                        </div>
                                        <p class="text-xs text-emerald-900/90 leading-relaxed">
                                            Grup koordinasi peserta untuk tanya jawab, pengumuman jadwal sesi, dan interaksi bersama instruktur.
                                        </p>
                                        <div class="pt-1">
                                            <a href="{{ $training->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer" 
                                               class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-[#25D366] hover:bg-[#20ba5a] text-white text-xs font-bold transition-all shadow-2xs">
                                                <span>Masuk Grup WhatsApp</span>
                                                <span class="material-symbols-outlined text-[14px]">open_in_new</span>
                                            </a>
                                        </div>
                                    </div>
                                @elseif(empty($isEnrolled) && $training->whatsapp_group_link)
                                    <div class="p-4 rounded-xl bg-surface-container-low flex flex-col gap-1.5 border border-outline-variant/40">
                                        <div class="flex items-center gap-2 text-primary font-headline text-xs font-bold">
                                            <span class="material-symbols-outlined text-emerald-600 text-[20px]">chat</span>
                                            <span>Grup WhatsApp Koordinasi</span>
                                        </div>
                                        <p class="text-xs text-on-surface-variant leading-relaxed">
                                            Tersedia grup WhatsApp resmi untuk bimbingan langsung instruktur. Tautan undangan akan diberikan kepada Anda setelah berhasil mendaftar pelatihan ini.
                                        </p>
                                    </div>
                                @endif

                                @if(!$training->location && !$training->meeting_url && !$training->whatsapp_group_link)
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

                            <!-- Realtime Quota Indicator Box -->
                            @if($training->quota)
                                @php
                                    $percent = min(100, round(($training->enrolled_count / $training->quota) * 100));
                                @endphp
                                <div class="bg-surface-container-low p-4 rounded-xl flex flex-col gap-2.5 border border-outline-variant/40">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-on-surface font-bold flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[18px] text-secondary">event_seat</span>
                                            <span>Sisa Kuota Peserta</span>
                                        </span>
                                        @if($training->remaining_quota > 0)
                                            <span class="font-extrabold text-xs px-2.5 py-0.5 rounded-full {{ $training->remaining_quota <= 15 ? 'bg-amber-100 text-amber-800 border border-amber-300' : 'bg-primary/10 text-primary border border-primary/20' }}">
                                                Sisa {{ $training->remaining_quota }} Kursi
                                            </span>
                                        @else
                                            <span class="font-extrabold text-xs px-2.5 py-0.5 rounded-full bg-error-container text-error border border-error/20">
                                                Kuota Penuh
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Realtime Progress Bar -->
                                    <div class="space-y-1.5">
                                        <div class="w-full bg-surface-container-highest rounded-full h-2 overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500 {{ $training->remaining_quota <= 0 ? 'bg-error' : ($training->remaining_quota <= 15 ? 'bg-amber-500' : 'bg-secondary') }}" 
                                                 style="width: {{ $percent }}%"></div>
                                        </div>
                                        <div class="flex justify-between items-center text-[11px] text-on-surface-variant font-medium">
                                            <span><strong class="text-primary font-bold">{{ $training->enrolled_count }}</strong> orang terdaftar</span>
                                            <span>Total Kuota: {{ $training->quota }} Peserta</span>
                                        </div>
                                    </div>

                                    <div class="text-[11px] text-outline pt-0.5 border-t border-outline-variant/30">
                                        @if($training->is_registration_ended)
                                            <span class="text-outline font-semibold">Pendaftaran ditutup karena waktu pendaftaran telah berakhir.</span>
                                        @elseif($training->is_quota_full)
                                            <span class="text-error font-semibold">Pendaftaran ditutup karena kuota peserta telah terpenuhi.</span>
                                        @elseif($training->is_registration_not_started)
                                            <span class="text-amber-700 font-semibold">Pendaftaran belum dibuka (dimulai pada {{ $training->registration_start ? $training->registration_start->format('d M Y') : 'segera' }}).</span>
                                        @else
                                            Pendaftaran ditutup otomatis jika kuota terpenuhi
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="bg-surface-container-low p-4 rounded-xl flex flex-col gap-2 border border-outline-variant/40">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-on-surface font-bold flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-[18px] text-secondary">group</span>
                                            <span>Status Kuota Peserta</span>
                                        </span>
                                        <span class="font-extrabold text-xs px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            Kuota Terbuka
                                        </span>
                                    </div>
                                    <div class="text-[11px] text-on-surface-variant">
                                        <strong class="text-primary font-bold">{{ $training->enrolled_count }}</strong> orang sudah mendaftar (Tanpa Batas Kuota)
                                    </div>
                                    <div class="text-[11px] text-outline">
                                        @if($training->is_registration_ended)
                                            <span class="text-outline font-semibold">Pendaftaran telah berakhir.</span>
                                        @elseif($training->is_registration_not_started)
                                            <span class="text-amber-700 font-semibold">Pendaftaran dimulai pada {{ $training->registration_start ? $training->registration_start->format('d M Y') : 'segera' }}.</span>
                                        @else
                                            Terbuka fleksibel selama masa pendaftaran berlangsung
                                        @endif
                                    </div>
                                </div>
                            @endif

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
                                @if(!empty($isEnrolled))
                                    <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center gap-2.5">
                                        <span class="material-symbols-outlined text-[24px] text-emerald-600 shrink-0">verified</span>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-xs">Anda Sudah Terdaftar</span>
                                            <span class="text-[11px] text-emerald-700">Silakan akses jadwal dan materi di portal peserta.</span>
                                        </div>
                                    </div>
                                    @if($training->whatsapp_group_link)
                                        <a href="{{ $training->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer" 
                                           class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#25D366] hover:bg-[#20ba5a] text-white font-headline text-xs font-bold transition-all text-center shadow-xs hover:scale-[1.01]">
                                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                                            </svg>
                                            <span>Gabung Grup WhatsApp Pelatihan</span>
                                            <span class="material-symbols-outlined text-[15px]">open_in_new</span>
                                        </a>
                                    @endif
                                    <a href="{{ route('peserta') }}" 
                                       class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-primary text-white font-headline text-xs font-bold hover:bg-primary-container transition-all text-center shadow-xs">
                                        <span class="material-symbols-outlined text-[16px]">school</span>
                                        <span>Buka Portal Pembelajaran Peserta</span>
                                    </a>
                                @elseif($training->is_registration_ended)
                                    <!-- Waktu Pendaftaran Habis: Tombol Pendaftaran Di-hidden -->
                                    <div class="p-3.5 rounded-xl bg-surface-container-high/60 border border-outline-variant/60 text-outline flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[24px] text-outline/80 shrink-0">event_busy</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline text-xs font-bold text-on-surface">Pendaftaran Telah Ditutup</span>
                                            <span class="text-[11px] text-on-surface-variant">
                                                Masa pendaftaran untuk pelatihan ini sudah berakhir pada {{ $training->registration_end ? $training->registration_end->format('d M Y') : 'hari ini' }}.
                                            </span>
                                        </div>
                                    </div>
                                @elseif($training->is_quota_full)
                                    <!-- Kuota Penuh -->
                                    <div class="p-3.5 rounded-xl bg-error-container/30 border border-error/30 text-error flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[24px] text-error shrink-0">group_off</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline text-xs font-bold text-error">Kuota Penuh</span>
                                            <span class="text-[11px] text-on-error-container">Seluruh kuota peserta telah terpenuhi (0 kursi tersisa).</span>
                                        </div>
                                    </div>
                                    <button type="button" disabled 
                                            class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-surface-container-high text-outline font-headline text-sm font-bold cursor-not-allowed border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-[18px]">block</span>
                                        <span>Kuota Penuh</span>
                                    </button>
                                @elseif($training->is_registration_not_started)
                                    <!-- Pendaftaran Belum Dibuka: Belum Bisa Dilakukan -->
                                    <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 flex items-center gap-3">
                                        <span class="material-symbols-outlined text-[24px] text-amber-600 shrink-0">schedule</span>
                                        <div class="flex flex-col">
                                            <span class="font-headline text-xs font-bold text-amber-950">Pendaftaran Belum Dibuka</span>
                                            <span class="text-[11px] text-amber-800">
                                                Pendaftaran baru akan dibuka pada {{ $training->registration_start ? $training->registration_start->format('d M Y') : 'segera' }}.
                                            </span>
                                        </div>
                                    </div>
                                    <button type="button" disabled 
                                            class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-surface-container-high text-outline font-headline text-sm font-bold cursor-not-allowed border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-[18px]">lock_clock</span>
                                        <span>Pendaftaran Belum Dibuka</span>
                                    </button>
                                @else
                                    @auth
                                        @if(auth()->user()->role === \App\Enums\UserRole::Peserta)
                                            <form action="{{ route('agenda.enroll', $training->slug) }}" method="POST">
                                                @csrf
                                                <button type="submit" 
                                                        class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-secondary text-white font-headline text-sm font-bold shadow-md hover:bg-secondary-container transition-all text-center cursor-pointer">
                                                    <span>Daftar Pelatihan Sekarang</span>
                                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                                </button>
                                            </form>
                                        @elseif(auth()->user()->role === \App\Enums\UserRole::Admin)
                                            <a href="{{ route('admin.trainings.show', $training->id) }}" 
                                               class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-primary text-white font-headline text-sm font-bold shadow-md hover:bg-primary-container transition-all text-center">
                                                <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
                                                <span>Kelola di Panel Admin</span>
                                            </a>
                                        @elseif(auth()->user()->role === \App\Enums\UserRole::Tentor)
                                            <a href="{{ route('tentor') }}" 
                                               class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-primary text-white font-headline text-sm font-bold shadow-md hover:bg-primary-container transition-all text-center">
                                                <span class="material-symbols-outlined text-[18px]">co_present</span>
                                                <span>Panel Instruktur</span>
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('register') }}" 
                                           class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-xl bg-secondary text-white font-headline text-sm font-bold shadow-md hover:bg-secondary-container transition-all text-center">
                                            <span>Daftar Pelatihan Sekarang</span>
                                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                        </a>
                                        <p class="text-[11px] text-outline text-center leading-relaxed">
                                            Sudah memiliki akun? <a href="{{ route('login') }}" class="text-secondary font-bold hover:underline">Masuk di sini</a> untuk mendaftar lebih cepat.
                                        </p>
                                    @endauth
                                @endif
                            </div>

                            <!-- Secondary Actions -->
                            <div class="pt-3 border-t border-outline-variant/50 flex flex-col gap-2">
                                @php
                                    $shareMessage = "Halo! Ada info program pelatihan bermanfaat: *" . $training->title . "* di Akademi Pelatihan.\n\n"
                                        . "✨ Fasilitas: E-Sertifikat Resmi Terverifikasi, Modul Lengkap & Grup Diskusi.\n\n"
                                        . "📌 Panduan Langkah Pendaftaran:\n"
                                        . "1️⃣ Buka link pendaftaran: " . url()->current() . "\n"
                                        . "2️⃣ Masuk / Login akun (atau Daftar Baru)\n"
                                        . "3️⃣ Pilih & konfirmasi pendaftaran pelatihan\n"
                                        . "4️⃣ Gabung Grup WhatsApp resmi peserta\n\n"
                                        . "Yuk daftar sebelum kuota penuh: " . url()->current();
                                @endphp

                                <a href="https://api.whatsapp.com/send?text={{ rawurlencode($shareMessage) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="w-full flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-900 border border-emerald-200 text-xs font-bold transition-all shadow-2xs">
                                    <svg class="w-4 h-4 fill-current text-[#25D366] shrink-0" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                                    </svg>
                                    <span>Bagikan ke WhatsApp</span>
                                </a>

                                <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Akademi Pelatihan, saya ingin bertanya mengenai program: ' . $training->title) }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="flex items-center justify-center gap-1.5 text-secondary hover:underline text-xs font-semibold py-1">
                                    <span class="material-symbols-outlined text-[16px]">chat</span>
                                    <span>Tanya Panitia via WhatsApp</span>
                                </a>
                            </div>

                        </div>

                        <!-- Step by Step Registration Guide Card -->
                        <div class="bg-surface-container-lowest rounded-2xl shadow-sm p-5 sm:p-6 flex flex-col gap-3.5 border border-outline-variant/60">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-secondary text-[20px]">format_list_numbered</span>
                                <span class="font-headline text-xs text-primary font-bold tracking-wide uppercase">Panduan Langkah Pendaftaran</span>
                            </div>

                            <div class="flex flex-col gap-3 text-xs">
                                <div class="flex items-start gap-2.5">
                                    <span class="w-5 h-5 rounded-full bg-secondary/10 text-secondary font-headline font-bold text-[11px] flex items-center justify-center shrink-0 mt-0.5">1</span>
                                    <div>
                                        <strong class="font-bold text-primary block">Masuk / Registrasi Akun</strong>
                                        <span class="text-[11px] text-on-surface-variant leading-relaxed">
                                            @auth
                                                Anda saat ini sudah masuk sebagai <strong>{{ auth()->user()->name }}</strong>.
                                            @else
                                                <a href="{{ route('login') }}" class="text-secondary font-bold underline">Login</a> jika sudah punya akun, atau <a href="{{ route('register') }}" class="text-secondary font-bold underline">Daftar Akun Baru</a>.
                                            @endauth
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <span class="w-5 h-5 rounded-full bg-secondary/10 text-secondary font-headline font-bold text-[11px] flex items-center justify-center shrink-0 mt-0.5">2</span>
                                    <div>
                                        <strong class="font-bold text-primary block">Pilih &amp; Klik Tombol Daftar</strong>
                                        <span class="text-[11px] text-on-surface-variant leading-relaxed">Konfirmasi keikutsertaan Anda dengan menekan tombol pendaftaran pada kartu di atas.</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <span class="w-5 h-5 rounded-full bg-secondary/10 text-secondary font-headline font-bold text-[11px] flex items-center justify-center shrink-0 mt-0.5">3</span>
                                    <div>
                                        <strong class="font-bold text-primary block">Gabung Grup WhatsApp Resmi</strong>
                                        <span class="text-[11px] text-on-surface-variant leading-relaxed">Setelah mendaftar, langsung klik tautan untuk bergabung ke grup WhatsApp peserta pelatihan.</span>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <span class="w-5 h-5 rounded-full bg-secondary/10 text-secondary font-headline font-bold text-[11px] flex items-center justify-center shrink-0 mt-0.5">4</span>
                                    <div>
                                        <strong class="font-bold text-primary block">Akses Pembelajaran di Portal</strong>
                                        <span class="text-[11px] text-on-surface-variant leading-relaxed">Jadwal sesi temu daring, modul ajar, dan e-sertifikat dapat diakses lengkap di portal peserta.</span>
                                    </div>
                                </div>
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

@if(session('enrolled_whatsapp_popup') && $training->whatsapp_group_link)
    <!-- Modal Popup Gabung Grup WhatsApp Pendaftaran Berhasil -->
    <div id="whatsappModal" class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs p-3 sm:p-4 transition-opacity duration-300" onclick="if(event.target === this) closeWhatsappModal()" style="overscroll-behavior: contain;">
        <div class="min-h-full flex items-center justify-center py-4">
            <div class="bg-surface-container-lowest rounded-2xl shadow-2xl max-w-md w-full p-6 sm:p-7 border border-outline-variant/60 relative overflow-hidden flex flex-col items-center text-center animate-in fade-in zoom-in-95 duration-200 my-auto">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-[#25D366]"></div>

                <!-- Close Button -->
                <button type="button" onclick="closeWhatsappModal()" class="absolute top-4 right-4 text-outline hover:text-on-surface p-1 rounded-lg hover:bg-surface-container transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>

                <!-- Icon Hero -->
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 flex items-center justify-center text-[#25D366] mb-4 shadow-sm ring-8 ring-emerald-50">
                    <svg class="w-9 h-9 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                    </svg>
                </div>

                <!-- Title & Program -->
                <h3 class="font-headline text-lg sm:text-xl font-extrabold text-primary">
                    Pendaftaran Berhasil! 🎉
                </h3>
                <p class="text-xs font-semibold text-secondary mt-1 max-w-sm truncate">
                    {{ $training->title }}
                </p>

                <!-- Description -->
                <p class="text-xs text-on-surface-variant leading-relaxed mt-3">
                    Selamat, Anda telah resmi terdaftar! Silakan segera bergabung ke <strong>Grup WhatsApp Koordinasi</strong> untuk mendapatkan tautan live meeting, bimbingan langsung narasumber, dan jadwal teknis pelatihan.
                </p>

                <!-- Actions -->
                <div class="w-full flex flex-col gap-2.5 mt-6">
                    <a href="{{ $training->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                       onclick="closeWhatsappModal()"
                       class="w-full py-3 px-4 rounded-xl bg-[#25D366] hover:bg-[#20ba5a] text-white font-headline text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-md transition-all hover:scale-[1.02] active:scale-[0.98]">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                        </svg>
                        <span>Gabung Grup WhatsApp Sekarang</span>
                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    </a>
                    <button type="button" onclick="closeWhatsappModal()"
                            class="w-full py-2.5 px-4 rounded-xl border border-outline-variant hover:bg-surface-container text-xs font-semibold text-on-surface-variant transition-colors">
                        Nanti Saja / Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function closeWhatsappModal() {
            const modal = document.getElementById('whatsappModal');
            if (modal) {
                modal.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => modal.remove(), 250);
            }
        }
    </script>
@endif
@endsection
