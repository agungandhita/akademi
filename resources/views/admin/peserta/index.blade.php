@extends('admin.layouts.main')

@section('container')
<div class="space-y-8">
    
    <!-- Peserta Welcome Banner -->
    <div class="bg-primary rounded-2xl p-6 sm:p-8 text-white shadow-md relative overflow-hidden border border-primary">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary text-white text-xs font-semibold mb-3">
                    <span class="material-symbols-outlined text-[16px]">school</span>
                    <span>Ruang Belajar Terpadu</span>
                </div>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Portal Pembelajaran Peserta
                </h1>
                <p class="mt-1 text-xs sm:text-sm text-on-primary-container max-w-xl leading-relaxed">
                    Akses materi modul terakreditasi, pantau jadwal pertemuan online/offline, dan tingkatkan kompetensi profesional Anda.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ url('/agenda') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-secondary hover:bg-secondary-container shadow-xs transition-colors">
                    <span class="material-symbols-outlined text-[18px]">search</span>
                    <span>Cari Pelatihan Baru</span>
                </a>
            </div>
        </div>
        
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-secondary/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- 3 Key Stat Metric Cards (PRD PST-01) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        
        <!-- Card 1: Pelatihan Diikuti -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Pelatihan Diikuti</span>
                <span class="w-9 h-9 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">book</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $enrolledCount ?? 0 }}</span>
                @if (($enrolledCount ?? 0) > 0)
                    <span class="text-xs font-bold text-secondary bg-secondary-fixed px-2 py-0.5 rounded-md">Terdaftar</span>
                @else
                    <span class="text-xs font-bold text-outline bg-surface-container px-2 py-0.5 rounded-md">Belum Ada</span>
                @endif
            </div>
            <p class="text-xs text-on-surface-variant mt-2">
                {{ ($enrolledCount ?? 0) > 0 ? 'Semua program berstatus aktif' : 'Belum ada program yang diikuti' }}
            </p>
        </div>

        <!-- Card 2: Modul Selesai -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Modul Terbaca</span>
                <span class="w-9 h-9 rounded-xl bg-tertiary-fixed text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">task_alt</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $completedModules ?? 0 }} / {{ $totalModules ?? 0 }}</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">
                    {{ ($totalModules ?? 0) > 0 ? round(($completedModules / $totalModules) * 100) : 0 }}%
                </span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">
                {{ ($totalModules ?? 0) > 0 ? (($totalModules - ($completedModules ?? 0)) . ' modul lagi menuju selesai') : '0 modul terselesaikan' }}
            </p>
        </div>

        <!-- Card 3: Sesi Mendatang -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Sesi Mendatang</span>
                <span class="w-9 h-9 rounded-xl bg-surface-container-high text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">event</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $upcomingSessionsCount ?? 0 }}</span>
                @if (($upcomingSessionsCount ?? 0) > 0)
                    <span class="text-xs font-bold text-secondary bg-secondary-fixed px-2 py-0.5 rounded-md">Live Zoom</span>
                @else
                    <span class="text-xs font-bold text-outline bg-surface-container px-2 py-0.5 rounded-md">Jadwal</span>
                @endif
            </div>
            <p class="text-xs text-on-surface-variant mt-2">
                {{ ($upcomingSessionsCount ?? 0) > 0 ? 'Sesi terdekat tersedia' : 'Belum ada jadwal sesi terdekat' }}
            </p>
        </div>

    </div>

    <!-- Enrolled Trainings List (PRD PST-01, PST-05) -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-outline-variant/40 flex items-center justify-between">
            <div>
                <h3 class="font-headline text-base sm:text-lg font-bold text-primary">Pelatihan Saya yang Sedang Berjalan</h3>
                <p class="text-xs text-on-surface-variant mt-0.5">Lanjutkan membaca modul dan bergabung ke sesi tatap muka</p>
            </div>
            <a href="{{ route('peserta.trainings') }}" class="inline-flex items-center gap-1.5 text-xs text-secondary font-bold hover:underline">
                <span>Lihat Semua ({{ count($enrolledTrainings ?? []) }})</span>
                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
            </a>
        </div>

        <div class="divide-y divide-outline-variant/30">
            @forelse ($enrolledTrainings ?? [] as $item)
                @php
                    $enrollment = $item instanceof \App\Models\Enrollment ? $item : null;
                    $training = $enrollment ? $enrollment->training : $item;
                @endphp
                @if($training)
                <!-- Item Pelatihan -->
                <div class="p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-surface-container-low/40 transition-colors">
                    <div class="flex items-start gap-4 flex-1">
                        @if($training->thumbnail)
                            @php
                                $thumbUrl = \Illuminate\Support\Str::startsWith($training->thumbnail, ['http://', 'https://'])
                                    ? $training->thumbnail
                                    : asset('storage/' . $training->thumbnail);
                            @endphp
                            <div class="w-14 h-14 rounded-xl overflow-hidden bg-surface-container-low border border-outline-variant/40 shrink-0">
                                <img src="{{ $thumbUrl }}" alt="{{ $training->title }}" class="w-full h-full object-cover" />
                            </div>
                        @else
                            <div class="w-14 h-14 rounded-xl bg-primary text-white flex items-center justify-center font-headline font-bold shrink-0">
                                <span class="material-symbols-outlined text-[26px]">school</span>
                            </div>
                        @endif
                        <div class="space-y-1 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-on-secondary-fixed">
                                    {{ $training->mode?->label() ?? 'Online' }}
                                </span>
                                @if($enrollment && $enrollment->status)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $enrollment->status->badgeClass() }}">
                                        {{ $enrollment->status->label() }}
                                    </span>
                                @endif
                                @if($training->category)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-surface-container text-on-surface-variant">
                                        {{ $training->category->name }}
                                    </span>
                                @endif
                            </div>
                            <h4 class="font-headline text-sm sm:text-base font-bold text-primary hover:text-secondary transition-colors">
                                <a href="{{ route('peserta.trainings.show', $training->id) }}">
                                    {{ $training->title }}
                                </a>
                            </h4>
                            <p class="text-xs text-on-surface-variant line-clamp-1">
                                {{ $training->description }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-start md:self-center shrink-0">
                        <a href="{{ route('peserta.trainings.show', $training->id) }}" class="px-4 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                            <span class="material-symbols-outlined text-[16px]">play_lesson</span>
                            <span>Buka Ruang Belajar &amp; Modul</span>
                        </a>
                    </div>
                </div>
                @endif
            @empty
                <!-- Empty State ketika belum mendaftar pelatihan -->
                <div class="py-12 px-6 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-surface-container-high text-outline flex items-center justify-center mb-4 shadow-xs">
                        <span class="material-symbols-outlined text-[36px] text-on-surface-variant/70">school</span>
                    </div>
                    <h4 class="font-headline text-base sm:text-lg font-bold text-primary">
                        Belum Ada Pelatihan yang Diikuti
                    </h4>
                    <p class="text-xs sm:text-sm text-on-surface-variant mt-1.5 max-w-md leading-relaxed">
                        Anda baru saja mendaftar dan belum mengikuti pelatihan apapun. Silakan telusuri katalog agenda pelatihan kami untuk mulai belajar dan meningkatkan kompetensi Anda.
                    </p>
                    <a href="{{ route('agenda') }}" class="mt-5 inline-flex items-center gap-2 px-5 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs sm:text-sm font-bold rounded-xl shadow-xs transition-all hover:scale-[1.02] active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[18px]">search</span>
                        <span>Jelajahi Agenda Pelatihan</span>
                    </a>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
