@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb & Top Bar -->
    <div class="flex items-center gap-2 text-xs text-on-surface-variant">
        <a href="{{ route('peserta') }}" class="hover:text-primary transition-colors">Portal Peserta</a>
        <span class="text-outline-variant">/</span>
        <a href="{{ route('peserta.trainings') }}" class="hover:text-primary transition-colors">Pelatihan Saya</a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold truncate max-w-xs">{{ $training->title }}</span>
    </div>

    <!-- Header Banner Ruang Belajar -->
    <div class="rounded-2xl p-6 sm:p-8 bg-linear-to-r from-primary to-primary-container text-white relative overflow-hidden shadow-md">
        <div class="relative z-10 max-w-3xl">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-tertiary-fixed-dim text-xs font-bold border border-white/10">
                    <span class="material-symbols-outlined text-[14px]">school</span>
                    <span>Ruang Belajar Peserta</span>
                </span>
                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-secondary-fixed text-on-secondary-fixed">
                    {{ $training->mode?->label() ?? 'Online' }}
                </span>
                @if($training->category)
                    <span class="px-2.5 py-0.5 rounded text-[11px] font-semibold bg-white/20 text-white">
                        {{ $training->category->name }}
                    </span>
                @endif
            </div>

            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight">
                {{ $training->title }}
            </h1>

            <p class="text-xs sm:text-sm text-white/80 mt-3 leading-relaxed max-w-2xl">
                {{ $training->description }}
            </p>

            <!-- Metadata Strip -->
            <div class="mt-6 flex flex-wrap items-center gap-y-2 gap-x-6 text-xs text-white/90 border-t border-white/10 pt-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-tertiary-fixed-dim">calendar_today</span>
                    <span>{{ $training->start_date ? $training->start_date->format('d M Y') : '—' }} @if($training->end_date && $training->end_date != $training->start_date) s.d. {{ $training->end_date->format('d M Y') }} @endif</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-tertiary-fixed-dim">menu_book</span>
                    <span>{{ $modules->count() }} Modul Pembelajaran</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-tertiary-fixed-dim">group</span>
                    <span>Instruktur: {{ $training->instructors->pluck('name')->join(', ') ?: 'Tim Instruktur' }}</span>
                </div>
            </div>
        </div>

        <div class="absolute -right-8 -bottom-10 opacity-10 pointer-events-none hidden md:block">
            <span class="material-symbols-outlined text-[220px]">auto_stories</span>
        </div>
    </div>

    <!-- Grid Content: Modul (Left/Main) & Sesi/Info (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Kolom Kiri: Kurikulum Modul Pembelajaran (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-outline-variant/40 flex items-center justify-between">
                    <div>
                        <h2 class="font-headline text-base sm:text-lg font-bold text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary text-[22px]">menu_book</span>
                            <span>Kurikulum &amp; Modul Pembelajaran</span>
                        </h2>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            Pelajari materi pembelajaran yang telah diunggah oleh instruktur secara berurutan.
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold shrink-0">
                        {{ $modules->count() }} Modul
                    </span>
                </div>

                <div class="divide-y divide-outline-variant/30">
                    @forelse ($modules as $index => $module)
                        <div class="p-5 sm:p-6 hover:bg-surface-container-low/40 transition-colors flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-start gap-4 flex-1">
                                <!-- Nomor & Icon Tipe -->
                                <div class="w-12 h-12 rounded-xl {{ $module->type->badgeClass() }} flex flex-col items-center justify-center shrink-0 shadow-2xs font-headline font-bold">
                                    <span class="material-symbols-outlined text-[22px]">{{ $module->type->icon() }}</span>
                                </div>

                                <div class="space-y-1 flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider">
                                            Modul #{{ $module->sort_order ?: ($index + 1) }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $module->type->badgeClass() }}">
                                            {{ $module->type->label() }}
                                        </span>
                                    </div>

                                    <h3 class="font-headline text-sm sm:text-base font-bold text-primary hover:text-secondary transition-colors">
                                        <a href="{{ route('peserta.trainings.modules.show', [$training->id, $module->id]) }}">
                                            {{ $module->title }}
                                        </a>
                                    </h3>

                                    @if($module->description)
                                        <p class="text-xs text-on-surface-variant line-clamp-2 leading-relaxed">
                                            {{ $module->description }}
                                        </p>
                                    @endif

                                    <div class="flex items-center gap-3 text-[11px] text-outline pt-1">
                                        @if($module->type === \App\Enums\ModuleType::Pdf && $module->file_path)
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">picture_as_pdf</span>
                                                <span>Dokumen PDF Siap Baca</span>
                                            </span>
                                        @elseif($module->type === \App\Enums\ModuleType::Video)
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">play_circle</span>
                                                <span>Video Tutorial</span>
                                            </span>
                                        @elseif($module->type === \App\Enums\ModuleType::Text)
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">article</span>
                                                <span>Bacaan Mandiri</span>
                                            </span>
                                        @elseif($module->type === \App\Enums\ModuleType::Link)
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">link</span>
                                                <span>Tautan Eksternal</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Buka Modul -->
                            <div class="self-end sm:self-center shrink-0">
                                <a href="{{ route('peserta.trainings.modules.show', [$training->id, $module->id]) }}" 
                                   class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 hover:scale-[1.02] active:scale-[0.98]">
                                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                    <span>Buka Modul</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 px-6 text-center flex flex-col items-center justify-center">
                            <div class="w-14 h-14 rounded-2xl bg-surface-container-high text-outline flex items-center justify-center mb-3">
                                <span class="material-symbols-outlined text-[30px] text-on-surface-variant/60">menu_book</span>
                            </div>
                            <h4 class="font-headline text-sm sm:text-base font-bold text-primary">
                                Belum Ada Modul yang Dipublikasikan
                            </h4>
                            <p class="text-xs text-on-surface-variant mt-1 max-w-sm leading-relaxed">
                                Instruktur pengampu sedang menyusun dan memfinalisasi modul pembelajaran untuk pelatihan ini. Silakan periksa kembali berkala.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Sesi & Tautan Tatap Muka (PST-07) (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Card Sesi Pertemuan -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
                <div class="p-5 border-b border-outline-variant/40">
                    <h3 class="font-headline text-sm sm:text-base font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary text-[20px]">calendar_month</span>
                        <span>Jadwal &amp; Sesi Pertemuan</span>
                    </h3>
                    <p class="text-xs text-on-surface-variant mt-0.5">
                        Tautan Zoom / tatap muka lokasi pelatihan
                    </p>
                </div>

                <div class="p-5 space-y-4">
                    @forelse ($training->sessions as $session)
                        <div class="p-4 rounded-xl bg-surface-container-low/50 border border-outline-variant/40 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-headline text-xs font-bold text-primary">
                                    {{ $session->title }}
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-surface-container-highest text-on-surface-variant">
                                    Sesi #{{ $loop->iteration }}
                                </span>
                            </div>

                            <div class="text-[11px] text-on-surface-variant space-y-1">
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[15px] text-secondary">calendar_today</span>
                                    <span>{{ $session->session_date ? \Carbon\Carbon::parse($session->session_date)->format('d M Y') : '—' }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[15px] text-secondary">schedule</span>
                                    <span>{{ $session->start_time }} - {{ $session->end_time }} WIB</span>
                                </div>
                            </div>

                            @if($session->meeting_link)
                                <div class="pt-2">
                                    <a href="{{ $session->meeting_link }}" target="_blank" rel="noopener noreferrer" 
                                       class="w-full py-2 px-3 bg-primary hover:bg-primary-container text-white text-xs font-bold rounded-lg flex items-center justify-center gap-1.5 transition-colors shadow-2xs">
                                        <span class="material-symbols-outlined text-[16px]">video_call</span>
                                        <span>Masuk Ruang Virtual</span>
                                    </a>
                                </div>
                            @endif

                            @if($session->location)
                                <div class="pt-1 flex items-start gap-1.5 text-[11px] text-outline">
                                    <span class="material-symbols-outlined text-[14px] text-secondary shrink-0 mt-0.5">location_on</span>
                                    <span>{{ $session->location }}</span>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="py-6 text-center text-xs text-on-surface-variant">
                            Belum ada jadwal sesi yang dijadwalkan secara spesifik.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Card Instruktur Pengampu -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs p-5">
                <h4 class="font-headline text-xs font-bold text-primary uppercase tracking-wider mb-3">
                    Instruktur Pengampu
                </h4>
                <div class="space-y-3">
                    @forelse($training->instructors as $instructor)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container-high border border-outline-variant/40 flex items-center justify-center text-primary font-bold overflow-hidden shrink-0">
                                @if($instructor->avatar)
                                    <img src="{{ asset('storage/' . $instructor->avatar) }}" alt="{{ $instructor->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-[20px]">person</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h5 class="text-xs font-bold text-on-surface truncate">{{ $instructor->name }}</h5>
                                <p class="text-[11px] text-outline truncate">{{ $instructor->expertise ?: 'Instruktur Ahli' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-on-surface-variant">Tim Pengajar Akademi Pelatihan</p>
                    @endforelse
                </div>
            </div>

            <!-- Tautan Halaman Publik -->
            <div>
                <a href="{{ route('agenda.detail', $training->slug) }}" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl border border-outline-variant hover:bg-surface-container-low text-xs font-semibold text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    <span>Lihat Halaman Info Publik</span>
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
