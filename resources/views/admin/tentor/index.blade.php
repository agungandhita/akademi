@extends('admin.layouts.main')

@section('container')
<div class="space-y-8">
    
    <!-- Tentor Welcome Banner -->
    <div class="bg-primary rounded-2xl p-6 sm:p-8 text-white shadow-md relative overflow-hidden border border-primary">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary text-white text-xs font-semibold mb-3">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span>Instruktur Terverifikasi</span>
                </div>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Dashboard Tentor &amp; Instruktur
                </h1>
                <p class="mt-1 text-xs sm:text-sm text-on-primary-container max-w-xl leading-relaxed">
                    Kelola materi modul ajar, pantau keaktifan peserta, dan koordinasikan sesi pelatihan yang ditugaskan kepada Anda.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-white/10 hover:bg-white/20 transition-colors border border-white/20">
                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                    <span>Lihat Web Publik</span>
                </a>
            </div>
        </div>
        
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-secondary/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- 3 Key Stat Metric Cards (PRD TNT-01) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        
        <!-- Card 1: Pelatihan Ditugaskan -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Pelatihan Ditugaskan</span>
                <span class="w-9 h-9 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">co_present</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">3</span>
                <span class="text-xs font-bold text-secondary bg-secondary-fixed px-2 py-0.5 rounded-md">Aktif</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">2 Online • 1 Blended</p>
        </div>

        <!-- Card 2: Total Peserta Terdaftar -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Total Peserta Terdaftar</span>
                <span class="w-9 h-9 rounded-xl bg-tertiary-fixed text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">groups</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">134</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">Peserta</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">Rata-rata 45 peserta per kelas</p>
        </div>

        <!-- Card 3: Modul Terbit -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Modul Ajar Terbit</span>
                <span class="w-9 h-9 rounded-xl bg-surface-container-high text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">12</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">Published</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">PDF, Teks &amp; Video Pembelajaran</p>
        </div>

    </div>

    <!-- Assigned Trainings List (PRD TNT-02) -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-outline-variant/40 flex items-center justify-between">
            <div>
                <h3 class="font-headline text-base sm:text-lg font-bold text-primary">Daftar Pelatihan yang Ditugaskan</h3>
                <p class="text-xs text-on-surface-variant mt-0.5">Program pelatihan di mana Anda ditugaskan sebagai instruktur pengampu</p>
            </div>
        </div>

        <div class="divide-y divide-outline-variant/30">
            <!-- Training Item 1 -->
            <div class="p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-surface-container-low/40 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-primary text-white flex items-center justify-center font-headline font-bold shrink-0">
                        <span class="material-symbols-outlined text-[24px]">psychology</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-on-secondary-fixed">Online • 32 JP</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-surface-container text-secondary">Published</span>
                        </div>
                        <h4 class="font-headline text-sm sm:text-base font-bold text-primary">
                            Penerapan Pembelajaran Berbasis AI &amp; Gamifikasi untuk Pendidik
                        </h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            Sasaran: Guru &amp; Tenaga Pendidik • Kuota: 44/50 Peserta • Jadwal: 18 - 21 Mei 2025
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 self-start md:self-center shrink-0">
                    <button class="px-4 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-lg shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">menu_book</span>
                        <span>Kelola Modul (4)</span>
                    </button>
                </div>
            </div>

            <!-- Training Item 2 -->
            <div class="p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-surface-container-low/40 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-secondary text-white flex items-center justify-center font-headline font-bold shrink-0">
                        <span class="material-symbols-outlined text-[24px]">assignment_turned_in</span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-on-secondary-fixed">Blended • 32 JP</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-surface-container text-secondary">Published</span>
                        </div>
                        <h4 class="font-headline text-sm sm:text-base font-bold text-primary">
                            Konstruksi Instrumen Asesmen Formatif Digital Terstandarisasi
                        </h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            Sasaran: Guru &amp; Dosen • Kuota: 46/50 Peserta • Jadwal: 25 - 28 Mei 2025
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 self-start md:self-center shrink-0">
                    <button class="px-4 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-lg shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                        <span class="material-symbols-outlined text-[16px]">menu_book</span>
                        <span>Kelola Modul (5)</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
