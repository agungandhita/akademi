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
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">2</span>
                <span class="text-xs font-bold text-secondary bg-secondary-fixed px-2 py-0.5 rounded-md">Terdaftar</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">Semua program berstatus aktif</p>
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
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">6 / 8</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">75%</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">2 modul lagi menuju selesai</p>
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
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">1</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">Live Zoom</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">Besok, 19:30 WIB</p>
        </div>

    </div>

    <!-- Enrolled Trainings List (PRD PST-01, PST-05) -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-outline-variant/40 flex items-center justify-between">
            <div>
                <h3 class="font-headline text-base sm:text-lg font-bold text-primary">Pelatihan Saya yang Sedang Berjalan</h3>
                <p class="text-xs text-on-surface-variant mt-0.5">Lanjutkan membaca modul dan bergabung ke sesi tatap muka</p>
            </div>
        </div>

        <div class="divide-y divide-outline-variant/30">
            <!-- Item 1 -->
            <div class="p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-surface-container-low/40 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center font-headline font-bold shrink-0">
                        <span class="material-symbols-outlined text-[24px]">smart_toy</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-on-secondary-fixed">Online • 32 JP</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-surface-container text-secondary">Progres 75%</span>
                        </div>
                        <h4 class="font-headline text-sm sm:text-base font-bold text-primary">
                            Penerapan Pembelajaran Berbasis AI &amp; Gamifikasi untuk Pendidik
                        </h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            Instruktur: Dr. Hendra Wijaya, M.Pd • Sesi Berikutnya: Praktik Prompt Pedagogis
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 self-start md:self-center shrink-0">
                    <a href="{{ url('/agenda/ai-gamifikasi-pendidik') }}" class="px-4 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-lg shadow-xs transition-all flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px]">play_circle</span>
                        <span>Buka Modul</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
