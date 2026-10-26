@extends('admin.layouts.main')

@section('container')
<div class="space-y-8">
    
    <!-- Dashboard Header & Welcome Banner -->
    <div class="bg-primary rounded-2xl p-6 sm:p-8 text-white shadow-md relative overflow-hidden border border-primary">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-tertiary-fixed-dim text-xs font-semibold mb-3 border border-white/10">
                    <span class="w-2 h-2 rounded-full bg-tertiary-fixed-dim animate-pulse"></span>
                    <span>Portal Administrator Aktif</span>
                </div>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Dashboard Manajemen Akademi Pelatihan
                </h1>
                <p class="mt-1 text-xs sm:text-sm text-on-primary-container max-w-xl leading-relaxed">
                    Pantau metrik pendaftaran peserta, status program pelatihan, modul ajar tentor, dan pesan kontak secara real-time.
                </p>
            </div>
            
            <!-- Quick Action Buttons -->
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ url('/agenda') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-secondary hover:bg-secondary-container shadow-xs transition-colors">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    <span>Katalog Pelatihan</span>
                </a>
                <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold text-white bg-white/10 hover:bg-white/20 transition-colors border border-white/20">
                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                    <span>Lihat Web Publik</span>
                </a>
            </div>
        </div>
        
        <!-- Decorative Glow -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-secondary/20 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- 4 Key Stat Metric Cards (PRD ADM-01) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Total Pengguna (PRD ADM-01) -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Total Pengguna</span>
                <span class="w-9 h-9 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalPeserta ?? '1.248' }}</span>
                <span class="text-xs font-bold text-secondary bg-secondary-fixed px-2 py-0.5 rounded-md">Aktif</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">1.228 Peserta • 18 Tentor • 2 Admin</p>
        </div>

        <!-- Card 2: Total Pelatihan (PRD ADM-01) -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Pelatihan</span>
                <span class="w-9 h-9 rounded-xl bg-surface-container-high text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">school</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalProgram ?? '24' }}</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">6 Kategori</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">18 Online • 4 Blended • 2 Offline</p>
        </div>

        <!-- Card 3: Pendaftaran Peserta (PRD ADM-01) -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Pendaftaran Pelatihan</span>
                <span class="w-9 h-9 rounded-xl bg-tertiary-fixed text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalPendaftaran ?? '842' }}</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">Gratis (Fase 1)</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">36 pendaftaran baru minggu ini</p>
        </div>

        <!-- Card 4: Pesan Kontak Belum Dibaca (PRD ADM-01) -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Pesan Kontak Masuk</span>
                <span class="w-9 h-9 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">mail</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalPesan ?? '5' }}</span>
                <span class="text-xs font-bold text-error bg-error-container/40 px-2 py-0.5 rounded-md">Belum Dibaca</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">Konsultasi lembaga &amp; dinas</p>
        </div>

    </div>

    <!-- Main Grid: Recent Registrations & Popular Programs -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Table: Pendaftaran Peserta Terbaru (8 cols) -->
        <div class="lg:col-span-8 bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-outline-variant/40 flex items-center justify-between">
                <div>
                    <h3 class="font-headline text-base sm:text-lg font-bold text-primary">Pendaftaran Peserta Terbaru</h3>
                    <p class="text-xs text-on-surface-variant mt-0.5">Daftar peserta yang baru mendaftar ke sesi pelatihan</p>
                </div>
                <span class="text-xs font-bold text-secondary hover:underline cursor-pointer flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                    <thead class="bg-surface-container-low text-outline font-semibold uppercase text-[11px] border-b border-outline-variant/40">
                        <tr>
                            <th class="py-3.5 px-4 sm:px-6">Nama Peserta</th>
                            <th class="py-3.5 px-4">Program Pelatihan</th>
                            <th class="py-3.5 px-4">Tipe Peserta</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30">
                        <!-- Row 1 -->
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="font-bold text-primary">Drs. Ahmad Fauzi, M.Pd</div>
                                <div class="text-[11px] text-outline">ahmad.fauzi@kemdikbud.go.id</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-primary">
                                Penerapan Pembelajaran Berbasis AI (32 JP)
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-on-secondary-fixed">
                                    Guru
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-secondary-fixed text-on-secondary-fixed">
                                    Terdaftar
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="px-3 py-1 bg-surface-container hover:bg-secondary hover:text-white font-semibold text-xs rounded-lg transition-colors cursor-pointer text-primary">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="font-bold text-primary">Siti Rahmawati</div>
                                <div class="text-[11px] text-outline">siti.rahma@student.ac.id</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-primary">
                                Dasar Pemrograman Web &amp; Algoritma
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-tertiary-fixed text-primary">
                                    Siswa
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-secondary-fixed text-on-secondary-fixed">
                                    Terdaftar
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="px-3 py-1 bg-surface-container hover:bg-secondary hover:text-white font-semibold text-xs rounded-lg transition-colors cursor-pointer text-primary">
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="font-bold text-primary">Budi Pratama, S.T.</div>
                                <div class="text-[11px] text-outline">budi.pratama@gmail.com</div>
                            </td>
                            <td class="py-3.5 px-4 font-medium text-primary">
                                Analisis Kebutuhan Pelatihan Soft Skills 2025
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-surface-container-high text-on-surface-variant">
                                    Umum
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-secondary-fixed text-on-secondary-fixed">
                                    Terdaftar
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <button class="px-3 py-1 bg-surface-container hover:bg-secondary hover:text-white font-semibold text-xs rounded-lg transition-colors cursor-pointer text-primary">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Side: Kuota Pelatihan & Aktivitas (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Kapasitas Batch -->
            <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
                <h3 class="font-headline text-base font-bold text-primary mb-1">Keterisian Kuota Pelatihan</h3>
                <p class="text-xs text-on-surface-variant mb-5">Persentase pendaftaran peserta per program</p>

                <div class="space-y-4">
                    <!-- Prog 1 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-primary truncate max-w-[180px]">AI Pedagogi (32 JP)</span>
                            <span class="text-secondary font-bold">88% (44/50)</span>
                        </div>
                        <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full rounded-full" style="width: 88%"></div>
                        </div>
                    </div>

                    <!-- Prog 2 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-primary truncate max-w-[180px]">Asesmen Formatif Guru</span>
                            <span class="text-secondary font-bold">92% (46/50)</span>
                        </div>
                        <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full rounded-full" style="width: 92%"></div>
                        </div>
                    </div>

                    <!-- Prog 3 -->
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1">
                            <span class="text-primary truncate max-w-[180px]">Pelatihan Vokasi Digital</span>
                            <span class="text-secondary font-bold">75% (30/40)</span>
                        </div>
                        <div class="w-full bg-surface-container h-2 rounded-full overflow-hidden">
                            <div class="bg-secondary h-full rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feed Aktivitas Terkini -->
            <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
                <h3 class="font-headline text-base font-bold text-primary mb-4">Aktivitas Terkini</h3>
                
                <div class="space-y-3.5 text-xs">
                    <div class="flex items-start gap-3">
                        <span class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold shrink-0">
                            <span class="material-symbols-outlined text-[16px]">person_add</span>
                        </span>
                        <div>
                            <p class="font-semibold text-primary">Pendaftaran Baru Masuk</p>
                            <p class="text-on-surface-variant text-[11px]">Drs. Ahmad Fauzi mendaftar di Pelatihan AI.</p>
                            <span class="text-[10px] text-outline">12 menit yang lalu</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="w-7 h-7 rounded-full bg-surface-container-high text-primary flex items-center justify-center font-bold shrink-0">
                            <span class="material-symbols-outlined text-[16px]">upload_file</span>
                        </span>
                        <div>
                            <p class="font-semibold text-primary">Modul Ajar Diunggah</p>
                            <p class="text-on-surface-variant text-[11px]">Dr. Hendra Wijaya mengunggah Modul 1 (PDF).</p>
                            <span class="text-[10px] text-outline">1 jam yang lalu</span>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <span class="w-7 h-7 rounded-full bg-tertiary-fixed text-primary flex items-center justify-center font-bold shrink-0">
                            <span class="material-symbols-outlined text-[16px]">mail</span>
                        </span>
                        <div>
                            <p class="font-semibold text-primary">Pesan Kontak Baru</p>
                            <p class="text-on-surface-variant text-[11px]">Dinas Pendidikan Sleman menanyakan in-house training.</p>
                            <span class="text-[10px] text-outline">2 jam yang lalu</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
