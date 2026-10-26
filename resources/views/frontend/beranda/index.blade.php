@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-20 bg-surface">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <div class="flex flex-col w-full">

            <!-- ========================================== -->
            <!-- 1. HERO SECTION                            -->
            <!-- ========================================== -->
            <section class="relative w-full pb-12 sm:pb-16 overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
                    
                    <!-- Left Content Column -->
                    <div class="lg:col-span-7 flex flex-col gap-6">
                        <div class="inline-flex items-center gap-2 self-start px-3.5 py-1.5 rounded-full bg-surface-container-high text-secondary border border-outline-variant/60">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                            <span class="font-headline text-xs font-bold uppercase tracking-wider">Standar Kompetensi Nasional Terpercaya</span>
                        </div>

                        <div class="flex flex-col gap-3">
                            <h1 class="font-headline text-3xl sm:text-4xl md:text-5xl font-extrabold text-primary tracking-tight leading-tight">
                                Belajar, Berkembang, dan Tingkatkan Kompetensi Bersama <span class="text-secondary">Akademi Pelatihan</span>
                            </h1>
                            <p class="text-base sm:text-lg text-on-surface-variant max-w-2xl leading-relaxed">
                                Temukan berbagai program pelatihan, workshop, dan kegiatan pengembangan kompetensi untuk guru, tenaga pendidik, serta masyarakat umum secara terpadu dan profesional.
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 pt-2">
                            <a class="inline-flex items-center gap-2 px-6 py-3.5 rounded-lg bg-secondary text-white font-headline text-sm font-bold shadow-md hover:bg-secondary-container transition-all" href="{{ url('/agenda') }}">
                                <span>Jelajahi Pelatihan</span>
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                            <a class="inline-flex items-center gap-2 px-6 py-3.5 rounded-lg bg-surface-container-lowest text-primary border border-outline-variant/80 shadow-xs hover:bg-surface-container transition-all font-headline text-sm font-semibold" href="{{ url('/kontak') }}">
                                <span>Hubungi Kami</span>
                                <span class="material-symbols-outlined text-[18px]">support_agent</span>
                            </a>
                        </div>

                        <!-- Metric Badges Row -->
                        <div class="grid grid-cols-3 gap-4 pt-4 mt-2 bg-surface-container-low p-4 sm:p-5 rounded-xl border border-outline-variant/50">
                            <div class="flex flex-col">
                                <span class="font-headline text-2xl sm:text-3xl text-primary font-black">120+</span>
                                <span class="text-[11px] sm:text-xs text-on-surface-variant uppercase tracking-wider font-semibold">Agenda Terlaksana</span>
                            </div>
                            <div class="flex flex-col border-x border-outline-variant/60 px-3 sm:px-4">
                                <span class="font-headline text-2xl sm:text-3xl text-secondary font-black">15.000+</span>
                                <span class="text-[11px] sm:text-xs text-on-surface-variant uppercase tracking-wider font-semibold">Alumni Terdaftar</span>
                            </div>
                            <div class="flex flex-col pl-2 sm:pl-3">
                                <span class="font-headline text-2xl sm:text-3xl text-secondary-container font-black">98%</span>
                                <span class="text-[11px] sm:text-xs text-on-surface-variant uppercase tracking-wider font-semibold">Indeks Kepuasan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Visual Column: Sliding Tentor Showcase (Ultra-Modern 3D Glassmorphism) -->
                    <div class="lg:col-span-5 relative flex justify-center items-center py-6 sm:py-8">
                        <div class="w-full relative max-w-[360px] sm:max-w-[400px] select-none" id="tentorHeroSliderWrapper">
                            
                            <!-- Multi-layered Ambient Glow Backdrops -->
                            <div class="absolute -top-10 -left-10 w-64 h-64 bg-amber-400/20 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-secondary/25 rounded-full blur-3xl pointer-events-none"></div>

                            <!-- 1. Central Vertical Rounded Frame Capsule (Poster Canvas) -->
                            <div class="relative w-full aspect-[4/5] min-h-[450px] sm:min-h-[500px] rounded-[2.5rem] shadow-[0_25px_60px_-15px_rgba(0,0,0,0.35)] border border-white/60 overflow-hidden bg-slate-900" id="tentorHeroSlider">
                                
                                <!-- Slides Carousel Track (The visual portrait slides inside capsule) -->
                                <div class="relative w-full h-full overflow-hidden">
                                    <div class="flex h-full transition-transform duration-700 ease-out" id="tentorSlideTrack">
                                        
                                        <!-- Slide 1: Saminto, S.Sos, M.M -->
                                        <div class="w-full min-w-full max-w-full h-full flex-shrink-0 relative overflow-hidden bg-gradient-to-b from-[#ff5e36] via-[#ea580c] to-[#0c1a30] flex items-end justify-center">
                                            <div class="absolute inset-0 bg-radial from-amber-300/30 via-transparent to-transparent pointer-events-none"></div>
                                            <img class="h-[92%] w-auto max-w-full object-contain object-bottom drop-shadow-[0_20px_25px_rgba(0,0,0,0.5)] transition-transform duration-700 hover:scale-105" 
                                                alt="Saminto, S.Sos, M.M - Master Trainer & Pembina Akademi Pelatihan" 
                                                src="{{ asset('img/tentor/saminto-sos-mm.png') }}" />
                                            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-950/80 to-transparent pointer-events-none"></div>
                                        </div>

                                        <!-- Slide 2: Rasmian, S.Pd -->
                                        <div class="w-full min-w-full max-w-full h-full flex-shrink-0 relative overflow-hidden bg-gradient-to-b from-[#1e3a8a] via-[#172554] to-[#0c1a30] flex items-end justify-center">
                                            <div class="absolute inset-0 bg-radial from-blue-400/25 via-transparent to-transparent pointer-events-none"></div>
                                            <img class="h-[92%] w-auto max-w-full object-contain object-bottom drop-shadow-[0_20px_25px_rgba(0,0,0,0.5)] transition-transform duration-700 hover:scale-105" 
                                                alt="Rasmian, S.Pd - Konsultan Pendidikan & Pengawas Sekolah Jenjang SMA" 
                                                src="{{ asset('img/tentor/rasmian-spd.png') }}" />
                                            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-950/80 to-transparent pointer-events-none"></div>
                                        </div>

                                        <!-- Slide 3: M. Satria Pinandhita A, S.Kom -->
                                        <div class="w-full min-w-full max-w-full h-full flex-shrink-0 relative overflow-hidden bg-gradient-to-b from-[#1e40af] via-[#1e3a8a] to-[#0b172b] flex items-end justify-center">
                                            <img class="h-full w-full object-cover object-top transition-transform duration-700 hover:scale-105" 
                                                alt="M. Satria Pinandhita A, S.Kom - Software Development & AI Analyst, Fasil KKA Kemendikdasmen" 
                                                src="{{ asset('img/tentor/m-satria-pa.jpg') }}" />
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent pointer-events-none"></div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Top Controls Inside Capsule: Prev/Next Buttons -->
                                <div class="absolute top-4 right-4 flex items-center gap-1.5 z-10">
                                    <button type="button" 
                                        onclick="prevTentorSlide()" 
                                        aria-label="Sebelumnya" 
                                        class="w-8 h-8 rounded-full bg-white/85 hover:bg-white text-slate-800 shadow-md flex items-center justify-center transition-all backdrop-blur-md active:scale-90 hover:scale-105">
                                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                    </button>
                                    <button type="button" 
                                        onclick="nextTentorSlide()" 
                                        aria-label="Berikutnya" 
                                        class="w-8 h-8 rounded-full bg-white/85 hover:bg-white text-slate-800 shadow-md flex items-center justify-center transition-all backdrop-blur-md active:scale-90 hover:scale-105">
                                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                    </button>
                                </div>

                            </div>


                            <!-- Bottom-Right Frosted Glass Featured Profile Card (Nike Shoes Jordan equivalent) -->
                            <div class="absolute -bottom-6 sm:-bottom-8 -right-2 sm:-right-6 z-20 bg-white/85 backdrop-blur-xl border border-white/90 shadow-[0_25px_50px_rgba(0,0,0,0.2)] rounded-3xl p-3.5 sm:p-4 flex items-center gap-3.5 max-w-[320px] sm:max-w-[350px] w-full transition-all duration-300 hover:scale-[1.02] pointer-events-auto">
                                <!-- Thumbnail Box -->
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-gradient-to-br from-primary to-secondary p-0.5 shrink-0 shadow-md overflow-hidden flex items-center justify-center">
                                    <img id="tentorThumb" src="{{ asset('img/tentor/saminto-sos-mm.png') }}" alt="Tentor Thumbnail" class="w-full h-full object-cover object-top rounded-[14px] bg-slate-100" />
                                </div>
                                
                                <!-- Information -->
                                <div class="flex flex-col flex-1 min-w-0">
                                    <h4 class="font-headline font-black text-slate-900 text-sm sm:text-base leading-tight truncate" id="tentorName">
                                        Saminto, S.Sos, M.M
                                    </h4>
                                    <p class="text-[11px] sm:text-xs text-slate-600 font-medium truncate mt-0.5" id="tentorRole">
                                        Konsultan Pendidikan &amp; Pengembangan Mutu Sekolah
                                    </p>
                                    <div class="mt-2 pt-1.5 border-t border-slate-200/60 flex items-center">
                                        <span class="font-headline font-extrabold text-xs sm:text-sm text-slate-900" id="tentorExp">
                                            15+ Th Pengalaman
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Dot Indicators (Positioned bottom-left) -->
                            <div class="absolute -bottom-10 left-4 flex items-center gap-1.5 z-10" id="tentorDotsContainer">
                                <button type="button" onclick="goToTentorSlide(0)" class="tentor-dot h-1.5 rounded-full transition-all duration-300 w-6 bg-secondary" aria-label="Slide 1"></button>
                                <button type="button" onclick="goToTentorSlide(1)" class="tentor-dot h-1.5 rounded-full transition-all duration-300 w-2 bg-outline-variant/70 hover:bg-secondary/60" aria-label="Slide 2"></button>
                                <button type="button" onclick="goToTentorSlide(2)" class="tentor-dot h-1.5 rounded-full transition-all duration-300 w-2 bg-outline-variant/70 hover:bg-secondary/60" aria-label="Slide 3"></button>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

            <section class="w-full py-12 sm:py-16 mt-4">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                    <div class="flex flex-col gap-1 max-w-2xl">
                        <span class="font-headline text-xs font-bold text-secondary uppercase tracking-wider">Segmentasi Terarah</span>
                        <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">Kategori Sasaran Program</h2>
                        <p class="text-sm sm:text-base text-on-surface-variant">
                            Temukan program pengembangan yang dirancang tepat sesuai latar belakang, jenjang profesi, dan sasaran kompetensi Anda.
                        </p>
                    </div>
                    <a class="text-secondary font-headline text-sm font-bold inline-flex items-center gap-1 hover:text-secondary-container transition-colors" href="{{ url('/agenda') }}">
                        <span>Semua Kategori</span>
                        <span class="material-symbols-outlined text-[18px]">east</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="group bg-surface-container-lowest rounded-xl p-6 shadow-xs border border-outline-variant/70 hover:shadow-lg hover:border-secondary/30 transition-all flex flex-col justify-between">
                        <div class="flex flex-col gap-4">
                            <div class="w-12 h-12 rounded-lg bg-primary-fixed flex items-center justify-center text-primary group-hover:bg-secondary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">school</span>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <h3 class="font-headline text-lg font-bold text-primary">Guru &amp; Tenaga Pendidik</h3>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    Peningkatan pedagogik, implementasi Kurikulum Merdeka, pengelolaan ruang kelas digital, serta metodologi evaluasi berbasis asesmen autentik.
                                </p>
                            </div>
                        </div>
                        <div class="pt-4 mt-4 border-t border-outline-variant/40 flex items-center justify-between">
                            <span class="text-xs text-secondary font-bold">48 Modul Terbuka</span>
                            <a class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary hover:bg-secondary hover:text-white transition-colors" href="#agenda-section" onclick="filterAgenda('guru')">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="group bg-surface-container-lowest rounded-xl p-6 shadow-xs border border-outline-variant/70 hover:shadow-lg hover:border-secondary/30 transition-all flex flex-col justify-between">
                        <div class="flex flex-col gap-4">
                            <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary group-hover:bg-secondary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">public</span>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <h3 class="font-headline text-lg font-bold text-primary">Masyarakat Umum</h3>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    Pengembangan keterampilan interpersonal, retorika publik, literasi finansial keluarga, serta penguasaan keahlian digital esensial masa kini.
                                </p>
                            </div>
                        </div>
                        <div class="pt-4 mt-4 border-t border-outline-variant/40 flex items-center justify-between">
                            <span class="text-xs text-secondary font-bold">32 Modul Terbuka</span>
                            <a class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary hover:bg-secondary hover:text-white transition-colors" href="#agenda-section" onclick="filterAgenda('umum')">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="group bg-surface-container-lowest rounded-xl p-6 shadow-xs border border-outline-variant/70 hover:shadow-lg hover:border-secondary/30 transition-all flex flex-col justify-between">
                        <div class="flex flex-col gap-4">
                            <div class="w-12 h-12 rounded-lg bg-tertiary-fixed flex items-center justify-center text-tertiary-container group-hover:bg-secondary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">badge</span>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <h3 class="font-headline text-lg font-bold text-primary">Mahasiswa &amp; Fresh Graduate</h3>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    Kesiapan masuki dunia kerja, persiapan uji kompetensi industri, kepemimpinan organisasi, serta standarisasi portofolio rekrutmen unggulan.
                                </p>
                            </div>
                        </div>
                        <div class="pt-4 mt-4 border-t border-outline-variant/40 flex items-center justify-between">
                            <span class="text-xs text-secondary font-bold">24 Modul Terbuka</span>
                            <a class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary hover:bg-secondary hover:text-white transition-colors" href="#agenda-section" onclick="filterAgenda('umum')">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="group bg-surface-container-lowest rounded-xl p-6 shadow-xs border border-outline-variant/70 hover:shadow-lg hover:border-secondary/30 transition-all flex flex-col justify-between">
                        <div class="flex flex-col gap-4">
                            <div class="w-12 h-12 rounded-lg bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed-variant group-hover:bg-secondary group-hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[26px]">psychology</span>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <h3 class="font-headline text-lg font-bold text-primary">Profesional &amp; Praktisi</h3>
                                <p class="text-xs text-on-surface-variant leading-relaxed">
                                    Manajemen strategis terstruktur, kepemimpinan adaptif lintas divisi, analisis data keputusan, dan pelatihan berbasis standar SKKNI.
                                </p>
                            </div>
                        </div>
                        <div class="pt-4 mt-4 border-t border-outline-variant/40 flex items-center justify-between">
                            <span class="text-xs text-secondary font-bold">19 Modul Terbuka</span>
                            <a class="w-8 h-8 rounded-full bg-surface-container-low flex items-center justify-center text-primary hover:bg-secondary hover:text-white transition-colors" href="#agenda-section" onclick="filterAgenda('semua')">
                                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ========================================== -->
            <!-- 3. AGENDA PELATIHAN TERBARU                -->
            <!-- ========================================== -->
            <section class="w-full py-12 sm:py-16" id="agenda-section">
                <div class="flex flex-col gap-4 mb-8">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                        <div>
                            <span class="font-headline text-xs font-bold text-secondary uppercase tracking-wider">Jadwal Terjadwal</span>
                            <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">Agenda Pelatihan Terbaru</h2>
                        </div>
                        <!-- Search Bar -->
                        <div class="relative w-full md:w-80">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                            <input class="w-full pl-10 pr-4 py-2.5 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-secondary shadow-xs" 
                                id="agendaSearch" placeholder="Cari topik pelatihan..." type="text" />
                        </div>
                    </div>

                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap items-center gap-2 pt-2" id="filterContainer">
                        <button class="filter-btn px-4 py-2 rounded-lg font-headline text-xs sm:text-sm font-bold bg-secondary text-white transition-colors cursor-pointer" onclick="setFilter(this, 'semua')">
                            Semua Pelatihan
                        </button>
                        <button class="filter-btn px-4 py-2 rounded-lg font-headline text-xs sm:text-sm font-semibold bg-surface-container-lowest border border-outline-variant text-on-surface hover:bg-surface-container transition-colors cursor-pointer" onclick="setFilter(this, 'guru')">
                            Guru &amp; Tenaga Pendidik
                        </button>
                        <button class="filter-btn px-4 py-2 rounded-lg font-headline text-xs sm:text-sm font-semibold bg-surface-container-lowest border border-outline-variant text-on-surface hover:bg-surface-container transition-colors cursor-pointer" onclick="setFilter(this, 'umum')">
                            Masyarakat Umum
                        </button>
                        <button class="filter-btn px-4 py-2 rounded-lg font-headline text-xs sm:text-sm font-semibold bg-surface-container-lowest border border-outline-variant text-on-surface hover:bg-surface-container transition-colors cursor-pointer" onclick="setFilter(this, 'online')">
                            Online
                        </button>
                        <button class="filter-btn px-4 py-2 rounded-lg font-headline text-xs sm:text-sm font-semibold bg-surface-container-lowest border border-outline-variant text-on-surface hover:bg-surface-container transition-colors cursor-pointer" onclick="setFilter(this, 'offline')">
                            Offline
                        </button>
                    </div>
                </div>

                <!-- Agenda Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="agendaGrid">
                    
                    <!-- Agenda 1 -->
                    <article class="agenda-card bg-surface-container-lowest rounded-xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-md transition-all flex flex-col justify-between" data-cat="guru online">
                        <div>
                            <div class="relative h-48 w-full overflow-hidden">
                                <img class="w-full h-full object-cover" 
                                    alt="Pelatihan Koding dan AI SMK" 
                                    src="{{ asset('img/kegiatan/pelatihan-ai-smkn1-kalitengah.jpg') }}" />
                                <div class="absolute top-3 left-3 bg-primary text-white font-headline text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Guru &amp; Pendidik
                                </div>
                                <div class="absolute bottom-3 right-3 bg-surface-container-lowest/90 backdrop-blur-sm text-secondary font-headline text-xs font-bold px-2.5 py-0.5 rounded shadow-xs">
                                    SMKN 1 Kalitengah
                                </div>
                            </div>
                            <div class="p-5 flex flex-col gap-2.5">
                                <div class="flex items-center gap-2 text-xs text-on-surface-variant font-medium">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">event</span>
                                    <span>23 Agustus 2025</span>
                                    <span>•</span>
                                    <span class="material-symbols-outlined text-[16px] text-secondary">schedule</span>
                                    <span>07:30 - 15:00 WIB</span>
                                </div>
                                <h3 class="font-headline text-base font-bold text-primary hover:text-secondary transition-colors cursor-pointer leading-snug">
                                    Pelatihan Koding &amp; Kecerdasan Artifisial Tingkat SMK Kejuruan
                                </h3>
                                <p class="text-xs text-on-surface-variant line-clamp-2 leading-relaxed">
                                    Pelatihan intensif kurikulum koding dan teknologi kecerdasan artifisial terapan untuk instruktur dan guru vokasi.
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0 flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-secondary-container"></span>
                                <span class="text-xs font-bold text-secondary">Terakreditasi</span>
                            </div>
                            <a href="{{ url('/agenda') }}" class="px-3.5 py-1.5 rounded-lg bg-surface-container text-primary hover:bg-secondary hover:text-white transition-colors font-headline text-xs font-bold">
                                Lihat Detail
                            </a>
                        </div>
                    </article>

                    <!-- Agenda 2 -->
                    <article class="agenda-card bg-surface-container-lowest rounded-xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-md transition-all flex flex-col justify-between" data-cat="umum offline">
                        <div>
                            <div class="relative h-48 w-full overflow-hidden">
                                <img class="w-full h-full object-cover" 
                                    alt="Presentasi OJT KKA SMA" 
                                    src="{{ asset('img/kegiatan/presentasi-ojt-sman2-lamongan.jpg') }}" />
                                <div class="absolute top-3 left-3 bg-secondary text-white font-headline text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Guru &amp; Instruktur
                                </div>
                                <div class="absolute bottom-3 right-3 bg-surface-container-lowest/90 backdrop-blur-sm text-primary font-headline text-xs font-bold px-2.5 py-0.5 rounded shadow-xs">
                                    SMAN 2 Lamongan
                                </div>
                            </div>
                            <div class="p-5 flex flex-col gap-2.5">
                                <div class="flex items-center gap-2 text-xs text-on-surface-variant font-medium">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">event</span>
                                    <span>25 - 29 Juni 2025</span>
                                    <span>•</span>
                                    <span class="material-symbols-outlined text-[16px] text-secondary">schedule</span>
                                    <span>08:30 - 15:30 WIB</span>
                                </div>
                                <h3 class="font-headline text-base font-bold text-primary hover:text-secondary transition-colors cursor-pointer leading-snug">
                                    On the Job Training (OJT): Rencana Tindak Lanjut Pembelajaran AI
                                </h3>
                                <p class="text-xs text-on-surface-variant line-clamp-2 leading-relaxed">
                                    Pendampingan praktis penyusunan modul ajar berbasis AI dan pemecahan kendala pembelajaran di ruang kelas.
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0 flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-secondary-container"></span>
                                <span class="text-xs font-bold text-secondary">Tersedia</span>
                            </div>
                            <a href="{{ url('/agenda') }}" class="px-3.5 py-1.5 rounded-lg bg-surface-container text-primary hover:bg-secondary hover:text-white transition-colors font-headline text-xs font-bold">
                                Lihat Detail
                            </a>
                        </div>
                    </article>

                    <!-- Agenda 3 -->
                    <article class="agenda-card bg-surface-container-lowest rounded-xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-md transition-all flex flex-col justify-between" data-cat="guru offline">
                        <div>
                            <div class="relative h-48 w-full overflow-hidden">
                                <img class="w-full h-full object-cover" 
                                    alt="Digital Skills Lab Komputer" 
                                    src="{{ asset('img/kegiatan/digital-skills-lab-komputer.jpg') }}" />
                                <div class="absolute top-3 left-3 bg-primary text-white font-headline text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                    Siswa &amp; Umum
                                </div>
                                <div class="absolute bottom-3 right-3 bg-surface-container-lowest/90 backdrop-blur-sm text-secondary font-headline text-xs font-bold px-2.5 py-0.5 rounded shadow-xs">
                                    Lab Komputer
                                </div>
                            </div>
                            <div class="p-5 flex flex-col gap-2.5">
                                <div class="flex items-center gap-2 text-xs text-on-surface-variant font-medium">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">event</span>
                                    <span>10 Juli 2025</span>
                                    <span>•</span>
                                    <span class="material-symbols-outlined text-[16px] text-secondary">schedule</span>
                                    <span>08:00 - 14:00 WIB</span>
                                </div>
                                <h3 class="font-headline text-base font-bold text-primary hover:text-secondary transition-colors cursor-pointer leading-snug">
                                    Digital Skills: Fundamental Hardware, Software, &amp; AI Tools
                                </h3>
                                <p class="text-xs text-on-surface-variant line-clamp-2 leading-relaxed">
                                    Pelatihan praktik langsung di lab komputer untuk pemahaman arsitektur sistem dan aplikasi komputer modern.
                                </p>
                            </div>
                        </div>
                        <div class="p-5 pt-0 flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-secondary-container"></span>
                                <span class="text-xs font-bold text-secondary">Terakreditasi</span>
                            </div>
                            <a href="{{ url('/agenda') }}" class="px-3.5 py-1.5 rounded-lg bg-surface-container text-primary hover:bg-secondary hover:text-white transition-colors font-headline text-xs font-bold">
                                Lihat Detail
                            </a>
                        </div>
                    </article>

                </div>

                <!-- Centered Bottom Trigger -->
                <div class="flex justify-center mt-10">
                    <a href="{{ url('/agenda') }}" class="px-8 py-3.5 rounded-lg bg-primary-container text-white hover:bg-primary transition-all font-headline text-sm font-bold shadow-xs inline-flex items-center gap-2">
                        <span>Lihat Semua Agenda Pelatihan</span>
                        <span class="material-symbols-outlined text-[18px]">calendar_month</span>
                    </a>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 3.5 DOKUMENTASI & REKAM JEJAK PELATIHAN    -->
            <!-- ========================================== -->
            <section class="w-full py-12 sm:py-16 border-t border-outline-variant/60" id="dokumentasi-section">
                <div class="flex flex-col gap-3 mb-10">
                    <span class="font-headline text-xs font-bold text-secondary uppercase tracking-wider">Rekam Jejak &amp; Bukti Nyata</span>
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                        <div>
                            <h2 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary tracking-tight">
                                Dokumentasi Pelatihan &amp; Kemitraan
                            </h2>
                            <p class="text-sm sm:text-base text-on-surface-variant mt-2 max-w-3xl leading-relaxed">
                                Komitmen nyata Akademi Pelatihan dalam mengakselerasi kompetensi koding, kecerdasan artifisial, dan literasi digital bersama Cabang Dinas Pendidikan, sekolah menengah, dan pesantren.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bento Gallery Grid (5 Foto Dokumentasi Nyata) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-6">
                    
                    <!-- Foto 1 (Hero Bento 7 Kolom) -->
                    <div class="lg:col-span-7 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-xl transition-all duration-300 group flex flex-col justify-between">
                        <div class="relative h-72 sm:h-96 w-full overflow-hidden bg-surface-container flex items-center justify-center">
                            <img class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105" 
                                alt="Pelatihan Koding dan Kecerdasan Artifisial Cabang Dinas Pendidikan Lamongan" 
                                src="{{ asset('img/kegiatan/pelatihan-ai-cabdin-lamongan.jpg') }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/30 to-transparent"></div>
                            <div class="absolute top-4 left-4 bg-secondary text-white font-headline text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                Cabang Dinas Pendidikan Wilayah Lamongan
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h3 class="font-headline text-lg sm:text-2xl font-bold leading-tight">
                                    Pelatihan Koding dan Kecerdasan Artifisial (KKA) Jenjang Pendidikan Menengah
                                </h3>
                                <p class="text-xs sm:text-sm text-white/80 mt-1 line-clamp-2">
                                    Fasilitasi puluhan guru dan instruktur se-Kabupaten dalam mengintegrasikan kurikulum AI dan pemrograman ke dalam pembelajaran kelas modern.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto 2 (5 Kolom) -->
                    <div class="lg:col-span-5 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-xl transition-all duration-300 group flex flex-col">
                        <div class="relative h-72 sm:h-96 w-full overflow-hidden bg-surface-container flex items-center justify-center">
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                alt="Presentasi OJT KKA SMA Negeri 2 Lamongan" 
                                src="{{ asset('img/kegiatan/presentasi-ojt-sman2-lamongan.jpg') }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/30 to-transparent"></div>
                            <div class="absolute top-4 left-4 bg-primary/90 backdrop-blur-xs text-white font-headline text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                SMAN 2 Lamongan
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h3 class="font-headline text-base sm:text-xl font-bold leading-tight">
                                    On the Job Training (OJT) &amp; Desain Modul Ajar AI
                                </h3>
                                <p class="text-xs text-white/80 mt-1 line-clamp-2">
                                    Pemaparan rencana aksi tindak lanjut dan evaluasi media pembelajaran berbasis AI oleh tenaga pendidik.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto 3 (4 Kolom) -->
                    <div class="lg:col-span-4 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-xl transition-all duration-300 group flex flex-col">
                        <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-surface-container flex items-center justify-center">
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                alt="Pelatihan Koding dan AI SMK Negeri 1 Kalitengah Lamongan" 
                                src="{{ asset('img/kegiatan/pelatihan-ai-smkn1-kalitengah.jpg') }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/30 to-transparent"></div>
                            <div class="absolute top-4 left-4 bg-secondary text-white font-headline text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                SMKN 1 Kalitengah
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h3 class="font-headline text-base font-bold leading-tight">
                                    Pelatihan Koding &amp; AI Terapan Vokasi
                                </h3>
                                <p class="text-xs text-white/80 mt-1 line-clamp-2">
                                    Penguatan kesiapan talenta kejuruan dalam penguasaan kecerdasan artifisial dan integrasi sistem digital.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto 4 (4 Kolom) -->
                    <div class="lg:col-span-4 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-xl transition-all duration-300 group flex flex-col">
                        <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-surface-container flex items-center justify-center">
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                alt="Kemitraan Pelatihan Pondok Pesantren Tanwir" 
                                src="{{ asset('img/kegiatan/kemitraan-ponpes-tanwir.jpg') }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/30 to-transparent"></div>
                            <div class="absolute top-4 left-4 bg-primary/90 backdrop-blur-xs text-white font-headline text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                Pondok Pesantren Tanwir
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h3 class="font-headline text-base font-bold leading-tight">
                                    Kemitraan Literasi Digital Santri
                                </h3>
                                <p class="text-xs text-white/80 mt-1 line-clamp-2">
                                    Kolaborasi pembinaan kecakapan digital dan teknologi informasi modern di lingkungan pesantren.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Foto 5 (4 Kolom) -->
                    <div class="lg:col-span-4 bg-surface-container-lowest rounded-2xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-xl transition-all duration-300 group flex flex-col">
                        <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-surface-container flex items-center justify-center">
                            <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" 
                                alt="Praktikum Digital Skills Hardware & Software Lab Komputer" 
                                src="{{ asset('img/kegiatan/digital-skills-lab-komputer.jpg') }}" />
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/95 via-primary/30 to-transparent"></div>
                            <div class="absolute top-4 left-4 bg-secondary text-white font-headline text-xs font-bold px-3 py-1 rounded-full shadow-md">
                                Laboratorium Komputer
                            </div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <h3 class="font-headline text-base font-bold leading-tight">
                                    Digital Skills: Hardware &amp; Software Lab
                                </h3>
                                <p class="text-xs text-white/80 mt-1 line-clamp-2">
                                    Praktikum interaktif siswa menguasai komponen dasar perangkat keras dan piranti lunak komputasi.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ========================================== -->
            <!-- 4. BERITA DAN ARTIKEL (DINAMIS DARI ADMIN)  -->
            <!-- ========================================== -->
            @if(isset($recentPosts) && $recentPosts->isNotEmpty())
                @php
                    $featuredPost = $recentPosts->first();
                    $subPosts = $recentPosts->slice(1);
                @endphp
                <section class="w-full py-12 sm:py-16" id="berita-section">
                    <div class="flex flex-col gap-3 mb-8">
                        <span class="font-headline text-xs font-bold text-secondary uppercase tracking-wider">Wawasan &amp; Publikasi</span>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">Berita &amp; Artikel Edukasi</h2>
                            <a class="inline-flex items-center gap-1 font-headline text-xs sm:text-sm font-bold text-secondary hover:text-secondary-container transition-colors" href="{{ url('/berita') }}">
                                <span>Lihat Semua Publikasi</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        <!-- Major Headline Card (7 cols) -->
                        <article class="lg:col-span-7 bg-surface-container-lowest rounded-xl overflow-hidden shadow-xs border border-outline-variant/80 hover:shadow-md transition-all flex flex-col justify-between">
                            <div>
                                <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-surface-container-high flex items-center justify-center">
                                    @if($featuredPost->cover)
                                        <img class="w-full h-full object-cover" 
                                            alt="{{ $featuredPost->title }}" 
                                            src="{{ asset('storage/' . $featuredPost->cover) }}" />
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-primary/10 via-secondary/10 to-primary/5 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-outline text-6xl">
                                                {{ $featuredPost->type->value === 'berita' ? 'newspaper' : 'article' }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="absolute top-4 left-4 bg-secondary text-white px-3 py-1 rounded font-headline text-[10px] font-bold uppercase tracking-wider">
                                        {{ $featuredPost->type->label() }}
                                    </div>
                                </div>
                                <div class="p-6 flex flex-col gap-3">
                                    <div class="flex items-center gap-2 text-xs text-on-surface-variant font-medium">
                                        <span>{{ $featuredPost->published_at ? $featuredPost->published_at->translatedFormat('d M Y') : $featuredPost->created_at->translatedFormat('d M Y') }}</span>
                                        <span>•</span>
                                        <span class="text-secondary font-bold">{{ $featuredPost->author?->name ?? 'Dewan Kurikulum' }}</span>
                                    </div>
                                    <h3 class="font-headline text-xl sm:text-2xl font-bold text-primary hover:text-secondary transition-colors cursor-pointer leading-tight">
                                        <a href="{{ url('/berita/' . $featuredPost->slug) }}">
                                            {{ $featuredPost->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-on-surface-variant leading-relaxed line-clamp-3">
                                        {{ $featuredPost->excerpt }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-6 pt-0">
                                <a class="inline-flex items-center gap-1 font-headline text-sm font-bold text-secondary hover:text-secondary-container transition-colors" href="{{ url('/berita/' . $featuredPost->slug) }}">
                                    <span>Baca Selengkapnya</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </article>

                        <!-- Secondary Stories Stack (5 cols) -->
                        <div class="lg:col-span-5 flex flex-col gap-4">
                            @forelse($subPosts as $sub)
                                <article class="bg-surface-container-lowest p-4 rounded-xl shadow-xs border border-outline-variant/70 hover:shadow-md transition-all flex gap-4 items-center">
                                    <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0 bg-surface-container flex items-center justify-center">
                                        @if($sub->cover)
                                            <img class="w-full h-full object-cover" 
                                                alt="{{ $sub->title }}" 
                                                src="{{ asset('storage/' . $sub->cover) }}" />
                                        @else
                                            <span class="material-symbols-outlined text-outline text-[28px]">
                                                {{ $sub->type->value === 'berita' ? 'newspaper' : 'article' }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-1 min-w-0">
                                        <span class="text-[10px] text-secondary font-bold uppercase tracking-wider">{{ $sub->type->label() }}</span>
                                        <h4 class="font-headline text-sm font-bold text-primary hover:text-secondary transition-colors cursor-pointer line-clamp-2">
                                            <a href="{{ url('/berita/' . $sub->slug) }}">
                                                {{ $sub->title }}
                                            </a>
                                        </h4>
                                        <span class="text-[11px] text-on-surface-variant">
                                            {{ $sub->published_at ? $sub->published_at->translatedFormat('d M Y') : $sub->created_at->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                </article>
                            @empty
                                <div class="p-6 bg-surface-container-lowest rounded-xl border border-outline-variant/60 text-center text-outline text-xs">
                                    Nantikan artikel edukasi dan rilis berita berikutnya.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            @endif

            <!-- ========================================== -->
            <!-- 5. MENGAPA AKADEMI PELATIHAN?              -->
            <!-- ========================================== -->
            <section class="w-full py-12 sm:py-16 bg-surface-container-low rounded-2xl p-6 sm:p-12 my-8 border border-outline-variant/60" id="keunggulan-section">
                <div class="flex flex-col items-center text-center max-w-3xl mx-auto mb-12">
                    <span class="font-headline text-xs font-bold text-secondary uppercase tracking-wider mb-2">Integritas &amp; Kualitas</span>
                    <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary tracking-tight">Mengapa Memilih Akademi Pelatihan?</h2>
                    <p class="text-sm sm:text-base text-on-surface-variant mt-2">
                        Kami membangun sarana peningkatan mutu yang berakar pada keterbukaan informasi, kepatuhan pedagogik, dan relevansi nyata terhadap tuntutan kemajuan pendidikan Indonesia.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Value 1 -->
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-xs border border-outline-variant/60 flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[28px]">assignment_turned_in</span>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="font-headline text-base font-bold text-primary">Program Pelatihan yang Relevan</h3>
                            <p class="text-xs text-on-surface-variant leading-relaxed">
                                Disusun berdasarkan pemetaan kebutuhan nyata para tenaga pendidik di lapangan dan standar kecakapan kerja terkini.
                            </p>
                        </div>
                    </div>

                    <!-- Value 2 -->
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-xs border border-outline-variant/60 flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[28px]">visibility</span>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="font-headline text-base font-bold text-primary">Informasi yang Mudah Diakses</h3>
                            <p class="text-xs text-on-surface-variant leading-relaxed">
                                Seluruh jadwal pelaksanaan, silabus komprehensif, dan persyaratan keikutsertaan disajikan secara transparan dan terstruktur.
                            </p>
                        </div>
                    </div>

                    <!-- Value 3 -->
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-xs border border-outline-variant/60 flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[28px]">trending_up</span>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="font-headline text-base font-bold text-primary">Keluasan Mengembangkan Kompetensi</h3>
                            <p class="text-xs text-on-surface-variant leading-relaxed">
                                Pendampingan oleh fasilitator berpengalaman melalui modul interaktif, studi kasus aplikatif, dan sesi tanya-jawab intensif.
                            </p>
                        </div>
                    </div>

                    <!-- Value 4 -->
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-xs border border-outline-variant/60 flex flex-col gap-4">
                        <div class="w-12 h-12 rounded-lg bg-surface-container-high flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined text-[28px]">diversity_3</span>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <h3 class="font-headline text-base font-bold text-primary">Inklusif Berbagai Kalangan</h3>
                            <p class="text-xs text-on-surface-variant leading-relaxed">
                                Akses pembelajaran terbuka luas mulai dari pendidik formal, dosen, mahasiswa, hingga masyarakat umum yang bertekad maju.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ========================================== -->
            <!-- 6. CALL TO ACTION                          -->
            <!-- ========================================== -->
            <section class="w-full my-8">
                <div class="relative bg-primary-container text-white rounded-2xl p-8 sm:p-12 overflow-hidden shadow-xl">
                    <!-- Subtle Decorative Blobs -->
                    <div class="absolute -right-16 -top-16 w-80 h-80 bg-tertiary-fixed-dim opacity-15 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -left-12 -bottom-12 w-64 h-64 bg-secondary opacity-25 rounded-full blur-2xl pointer-events-none"></div>

                    <div class="relative z-10 max-w-3xl flex flex-col gap-4">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-tertiary-container text-tertiary-fixed-dim font-headline text-xs font-bold w-fit border border-tertiary-fixed-dim/20">
                            <span class="material-symbols-outlined text-[16px]">bolt</span>
                            <span>Pendaftaran Periode Berjalan Terbuka</span>
                        </div>
                        <h2 class="font-headline text-2xl sm:text-4xl text-white font-extrabold tracking-tight">
                            Mulai Langkah Pengembangan Kompetensimu
                        </h2>
                        <p class="text-sm sm:text-base text-on-primary-container leading-relaxed">
                            Temukan program pelatihan yang sesuai dengan kebutuhan dan tujuan pengembangan dirimu bersama Akademi Pelatihan. Dapatkan sertifikasi dan wawasan aplikatif untuk masa depan gemilang.
                        </p>
                        <div class="flex flex-wrap items-center gap-4 pt-2">
                            <a class="px-6 py-3.5 rounded-lg bg-secondary text-white font-headline text-sm font-bold hover:bg-secondary-container transition-all shadow-md" href="{{ url('/register') }}">
                                Daftar Sekarang
                            </a>
                            <a class="px-6 py-3.5 rounded-lg bg-surface-container-lowest text-primary font-headline text-sm font-bold hover:bg-surface-container transition-all shadow-xs" href="{{ url('/agenda') }}">
                                Lihat Agenda
                            </a>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<!-- ========================================== -->
<!-- JAVASCRIPT FILTERING & SEARCH SCRIPT       -->
<!-- ========================================== -->
<script>
function setFilter(button, filterType) {
    const buttons = document.querySelectorAll('#filterContainer .filter-btn');
    buttons.forEach(btn => {
        btn.classList.remove('bg-secondary', 'text-white');
        btn.classList.add('bg-surface-container-lowest', 'text-on-surface', 'border', 'border-outline-variant');
    });
    button.classList.add('bg-secondary', 'text-white');
    button.classList.remove('bg-surface-container-lowest', 'text-on-surface', 'border', 'border-outline-variant');

    const cards = document.querySelectorAll('#agendaGrid .agenda-card');
    cards.forEach(card => {
        const categories = card.getAttribute('data-cat') || '';
        if (filterType === 'semua' || categories.includes(filterType)) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

function filterAgenda(filterType) {
    const targetBtn = Array.from(document.querySelectorAll('#filterContainer .filter-btn')).find(b => {
        return b.getAttribute('onclick')?.includes(`'${filterType}'`);
    });
    if (targetBtn) {
        setFilter(targetBtn, filterType);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('agendaSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function (e) {
            const term = e.target.value.toLowerCase().trim();
            const cards = document.querySelectorAll('#agendaGrid .agenda-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(term)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // ==========================================
    // TENTOR HERO SLIDER CONTROLLER (3D Glassmorphism)
    // ==========================================
    const track = document.getElementById('tentorSlideTrack');
    const sliderContainer = document.getElementById('tentorHeroSliderWrapper');
    const dots = document.querySelectorAll('#tentorDotsContainer .tentor-dot');
    
    // Dynamic Floating Profile Card Elements
    const tentorThumb = document.getElementById('tentorThumb');
    const tentorName = document.getElementById('tentorName');
    const tentorRole = document.getElementById('tentorRole');
    const tentorExp = document.getElementById('tentorExp');

    const tentorData = [
        {
            name: 'Saminto, S.Sos, M.M',
            role: 'Konsultan Pendidikan & Pengembangan Mutu Sekolah',
            thumb: "{{ asset('img/tentor/saminto-sos-mm.png') }}",
            exp: '15+ Th Pengalaman',
        },
        {
            name: 'Rasmian, S.Pd',
            role: 'Konsultan Pendidikan & Pengawas Sekolah Jenjang SMA',
            thumb: "{{ asset('img/tentor/rasmian-formal.jpg') }}",
            exp: '15+ Th Pengalaman',
        },
        {
            name: 'M. Satria Pinandhita A, S.Kom',
            role: 'AI Analyst & Fasil KKA Kemendikdasmen',
            thumb: "{{ asset('img/tentor/m-satria-pa.jpg') }}",
            exp: '4+ Th Pengalaman',
        }
    ];
    
    if (track && dots.length > 0) {
        let currentSlide = 0;
        const totalSlides = dots.length;
        let autoplayTimer = null;

        function updateSlider(index) {
            currentSlide = (index + totalSlides) % totalSlides;
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            
            dots.forEach((dot, idx) => {
                if (idx === currentSlide) {
                    dot.className = 'tentor-dot h-1.5 rounded-full transition-all duration-300 w-6 bg-secondary';
                } else {
                    dot.className = 'tentor-dot h-1.5 rounded-full transition-all duration-300 w-2 bg-outline-variant/70 hover:bg-secondary/60';
                }
            });

            const data = tentorData[currentSlide];
            if (data) {
                if (tentorThumb) {
                    tentorThumb.src = data.thumb;
                    tentorThumb.alt = data.name;
                }
                if (tentorName) tentorName.textContent = data.name;
                if (tentorRole) tentorRole.textContent = data.role;
                if (tentorExp) tentorExp.textContent = data.exp;
            }
        }

        window.nextTentorSlide = function () {
            updateSlider(currentSlide + 1);
            resetAutoplay();
        };

        window.prevTentorSlide = function () {
            updateSlider(currentSlide - 1);
            resetAutoplay();
        };

        window.goToTentorSlide = function (idx) {
            updateSlider(idx);
            resetAutoplay();
        };

        function startAutoplay() {
            if (!autoplayTimer) {
                autoplayTimer = setInterval(() => {
                    updateSlider(currentSlide + 1);
                }, 4500);
            }
        }

        function stopAutoplay() {
            if (autoplayTimer) {
                clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }

        function resetAutoplay() {
            stopAutoplay();
            startAutoplay();
        }

        // Pause on mouse hover
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', stopAutoplay);
            sliderContainer.addEventListener('mouseleave', startAutoplay);

            // Touch Swipe Support for Mobile
            let touchStartX = 0;
            let touchEndX = 0;

            sliderContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
                stopAutoplay();
            }, { passive: true });

            sliderContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                const swipeDiff = touchEndX - touchStartX;
                if (Math.abs(swipeDiff) > 40) {
                    if (swipeDiff < 0) {
                        nextTentorSlide();
                    } else {
                        prevTentorSlide();
                    }
                } else {
                    startAutoplay();
                }
            }, { passive: true });
        }

        // Initialize autoplay
        startAutoplay();
    }
});
</script>
@endsection
