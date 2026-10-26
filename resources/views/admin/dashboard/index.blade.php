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
    <!-- 4 Key Stat Metric Cards (PRD ADM-01) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- Card 1: Total Pengguna (PRD ADM-01) -->
        <a href="{{ route('admin.users.index') }}" class="block bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider group-hover:text-secondary transition-colors">Total Pengguna</span>
                <span class="w-9 h-9 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">group</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalUsers ?? 0 }}</span>
                <span class="text-xs font-bold text-secondary bg-secondary-fixed px-2 py-0.5 rounded-md">Aktif</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">
                {{ $userCounts['peserta'] ?? 0 }} Peserta • {{ $userCounts['tentor'] ?? 0 }} Tentor • {{ $userCounts['admin'] ?? 0 }} Admin
            </p>
        </a>

        <!-- Card 2: Total Pelatihan (PRD ADM-01) -->
        <a href="{{ route('admin.trainings.index') }}" class="block bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider group-hover:text-secondary transition-colors">Pelatihan</span>
                <span class="w-9 h-9 rounded-xl bg-surface-container-high text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">school</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalProgram ?? 0 }}</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">{{ $totalCategories ?? 0 }} Kategori</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">
                {{ $trainingModeCounts['online'] ?? 0 }} Online • {{ $trainingModeCounts['blended'] ?? 0 }} Blended • {{ $trainingModeCounts['offline'] ?? 0 }} Offline
            </p>
        </a>

        <!-- Card 3: Pendaftaran Peserta (PRD ADM-01) -->
        <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-outline uppercase tracking-wider">Pendaftaran Pelatihan</span>
                <span class="w-9 h-9 rounded-xl bg-tertiary-fixed text-primary flex items-center justify-center font-bold text-base">
                    <span class="material-symbols-outlined text-[20px]">how_to_reg</span>
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalPendaftaran ?? 0 }}</span>
                <span class="text-xs font-bold text-secondary bg-surface-container px-2 py-0.5 rounded-md">Fase 1</span>
            </div>
            <p class="text-xs text-on-surface-variant mt-2">
                {{ ($totalPendaftaran ?? 0) > 0 ? ($totalPendaftaran . ' pendaftaran aktif') : 'Belum ada pendaftaran masuk' }}
            </p>
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
                <span class="font-headline text-2xl sm:text-3xl font-black text-primary">{{ $totalPesan ?? 0 }}</span>
                @if (($totalPesan ?? 0) > 0)
                    <span class="text-xs font-bold text-error bg-error-container/40 px-2 py-0.5 rounded-md">Belum Dibaca</span>
                @else
                    <span class="text-xs font-bold text-outline bg-surface-container px-2 py-0.5 rounded-md">Kotak Pesan</span>
                @endif
            </div>
            <p class="text-xs text-on-surface-variant mt-2">
                {{ ($totalPesan ?? 0) > 0 ? ($totalPesan . ' pesan baru belum dibaca') : 'Tidak ada pesan kontak baru' }}
            </p>
        </div>

    </div>

    <!-- Main Grid: Recent Registrations & Popular Programs -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left Table: Pengguna & Peserta Terbaru (8 cols) -->
        <div class="lg:col-span-8 bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-outline-variant/40 flex items-center justify-between">
                <div>
                    <h3 class="font-headline text-base sm:text-lg font-bold text-primary">Pengguna &amp; Peserta Terbaru</h3>
                    <p class="text-xs text-on-surface-variant mt-0.5">Daftar pengguna yang baru saja mendaftar ke platform</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-secondary hover:underline flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                    <thead class="bg-surface-container-low text-outline font-semibold uppercase text-[11px] border-b border-outline-variant/40">
                        <tr>
                            <th class="py-3.5 px-4 sm:px-6">Nama Pengguna</th>
                            <th class="py-3.5 px-4">Peran (Role)</th>
                            <th class="py-3.5 px-4">Institusi / Tipe</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4">Terdaftar</th>
                            <th class="py-3.5 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30">
                        @forelse($recentUsers as $user)
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-3.5 px-4 sm:px-6">
                                <div class="flex items-center gap-3">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-8 h-8 rounded-xl object-cover shrink-0 border border-outline-variant/60" />
                                    @else
                                        <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-primary to-primary-container text-white font-headline text-[11px] font-bold flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="font-bold text-primary truncate max-w-[180px]">{{ $user->name }}</div>
                                        <div class="text-[11px] text-outline truncate max-w-[180px]">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $user->role?->badgeClass() ?? 'bg-surface-container text-on-surface' }}">
                                    <span class="material-symbols-outlined text-[13px]">{{ $user->role?->icon() ?? 'person' }}</span>
                                    <span>{{ $user->role?->label() ?? ucfirst($user->role) }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                @if($user->participant_type)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $user->participant_type->badgeClass() }}">
                                        {{ $user->participant_type->label() }}
                                    </span>
                                @elseif($user->institution)
                                    <span class="text-xs text-primary font-medium">{{ $user->institution }}</span>
                                @else
                                    <span class="text-xs text-outline">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4">
                                @if($user->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-secondary-fixed text-on-secondary-fixed">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-error-container/40 text-error">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-xs text-outline whitespace-nowrap">
                                {{ $user->created_at?->diffForHumans() ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="inline-block px-3 py-1 bg-surface-container hover:bg-secondary hover:text-white font-semibold text-xs rounded-lg transition-colors cursor-pointer text-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-outline">
                                <span class="material-symbols-outlined text-4xl mb-1 text-outline">group_off</span>
                                <p class="font-headline font-bold text-sm text-primary">Belum Ada Pengguna</p>
                                <p class="text-xs text-on-surface-variant">Data pendaftaran pengguna baru akan muncul di sini secara otomatis.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Side: Kuota Pelatihan & Aktivitas (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Kapasitas / Daftar Pelatihan Aktif -->
            <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
                <div class="flex items-center justify-between mb-1">
                    <h3 class="font-headline text-base font-bold text-primary">Pelatihan Terbaru</h3>
                    <a href="{{ route('admin.trainings.index') }}" class="text-[11px] font-bold text-secondary hover:underline">Semua</a>
                </div>
                <p class="text-xs text-on-surface-variant mb-4">Program pelatihan terdaftar di sistem</p>

                <div class="space-y-3.5">
                    @forelse($recentTrainings as $training)
                        <div class="p-3 rounded-xl bg-surface-container-low/50 border border-outline-variant/40 space-y-1.5">
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-xs font-bold text-primary truncate" title="{{ $training->title }}">
                                    {{ $training->title }}
                                </span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full shrink-0 {{ $training->status?->badgeClass() ?? 'bg-surface-container text-primary' }}">
                                    {{ $training->status?->label() ?? ucfirst($training->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] text-outline">
                                <span class="inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[13px]">{{ $training->mode?->icon() ?? 'school' }}</span>
                                    <span>{{ $training->mode?->label() ?? 'Online' }}</span>
                                </span>
                                <span class="font-semibold text-primary">
                                    {{ $training->quota ? $training->quota . ' Kuota' : 'Tanpa Batas Kuota' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 px-3 bg-surface-container-low/40 rounded-xl border border-dashed border-outline-variant">
                            <span class="material-symbols-outlined text-3xl text-outline mb-1">school</span>
                            <p class="text-xs font-bold text-primary">Belum Ada Pelatihan</p>
                            <p class="text-[11px] text-on-surface-variant mt-0.5">Mulai publikasikan program pelatihan perdana.</p>
                            <a href="{{ route('admin.trainings.create') }}" class="mt-3 inline-flex items-center gap-1 px-3 py-1.5 bg-secondary text-white text-[11px] font-bold rounded-lg shadow-2xs hover:bg-secondary-container transition-colors">
                                <span class="material-symbols-outlined text-[14px]">add</span>
                                <span>Buat Pelatihan</span>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Feed Aktivitas Terkini -->
            <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
                <h3 class="font-headline text-base font-bold text-primary mb-1">Aktivitas Terkini</h3>
                <p class="text-xs text-on-surface-variant mb-4">Pembaruan sistem dan pendaftaran real-time</p>
                
                <div class="space-y-3.5 text-xs">
                    @forelse($recentUsers->take(4) as $actUser)
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold shrink-0">
                                <span class="material-symbols-outlined text-[16px]">person_add</span>
                            </span>
                            <div class="min-w-0">
                                <p class="font-semibold text-primary truncate">{{ $actUser->name }}</p>
                                <p class="text-on-surface-variant text-[11px] truncate">
                                    Bergabung sebagai {{ $actUser->role?->label() ?? 'Pengguna' }}
                                    @if($actUser->participant_type)
                                        ({{ $actUser->participant_type->label() }})
                                    @endif
                                </p>
                                <span class="text-[10px] text-outline">{{ $actUser->created_at?->diffForHumans() ?? 'Baru saja' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-outline text-xs">
                            Belum ada aktivitas tercatat
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
