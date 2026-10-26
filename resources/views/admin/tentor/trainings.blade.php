@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div class="space-y-3">
        <nav class="flex items-center gap-1.5 text-xs text-outline">
            <a href="{{ route('tentor') }}" class="hover:text-secondary transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-primary font-semibold">Pelatihan Ditugaskan</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Pelatihan Ditugaskan</h1>
                <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                    Daftar seluruh kelas dan pelatihan di mana Anda ditugaskan sebagai instruktur pengampu.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('tentor.modules.index') }}" class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">menu_book</span>
                    <span>Kelola Seluruh Modul</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Assigned Trainings Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($assignedTrainings as $training)
        <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs hover:shadow-md transition-all flex flex-col justify-between overflow-hidden">
            <!-- Training Header & Thumbnail / Category -->
            <div class="p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between gap-2">
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-secondary-fixed text-on-secondary-fixed">
                        {{ $training->category?->name ?? 'Pelatihan' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $training->status?->badgeClass() ?? 'bg-surface-container text-secondary' }}">
                        {{ $training->status?->label() ?? ucfirst($training->status) }}
                    </span>
                </div>

                <div>
                    <h3 class="font-headline text-base sm:text-lg font-bold text-primary leading-snug line-clamp-2">
                        {{ $training->title }}
                    </h3>
                    <p class="text-xs text-on-surface-variant mt-1.5 line-clamp-2 leading-relaxed">
                        {{ $training->description ?: 'Program pelatihan terstruktur untuk meningkatkan kompetensi profesional.' }}
                    </p>
                </div>

                <!-- Info Badges (Mode, Sesi, Peserta) -->
                <div class="pt-3 border-t border-outline-variant/40 space-y-2 text-xs text-on-surface-variant">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-outline">
                            <span class="material-symbols-outlined text-[16px]">devices</span>
                            <span>Mode:</span>
                        </span>
                        <span class="font-bold text-primary">{{ $training->mode?->label() ?? 'Online' }}</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-outline">
                            <span class="material-symbols-outlined text-[16px]">groups</span>
                            <span>Peserta Terdaftar:</span>
                        </span>
                        <span class="font-bold text-secondary">
                            {{ $training->active_enrollments_count ?? $training->enrollments_count ?? 0 }} / {{ $training->quota ? $training->quota . ' Peserta' : 'Tak Terbatas' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="flex items-center gap-1.5 text-outline">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                            <span>Waktu Mulai:</span>
                        </span>
                        <span class="font-semibold text-primary">
                            {{ $training->start_date ? $training->start_date->format('d M Y') : 'Sesuai Jadwal' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Action Footer -->
            <div class="p-4 bg-surface-container-low border-t border-outline-variant/40 flex items-center justify-between gap-2">
                <a href="{{ route('tentor.modules.index', ['training_id' => $training->id]) }}" 
                   class="px-3.5 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 flex-1 justify-center">
                    <span class="material-symbols-outlined text-[16px]">menu_book</span>
                    <span>Modul ({{ $training->modules_count ?? $training->modules?->count() ?? 0 }})</span>
                </a>

                <a href="{{ route('tentor.trainings.participants', $training->id) }}" 
                   class="px-3.5 py-2 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 flex-1 justify-center"
                   title="Lihat daftar peserta pelatihan ini">
                    <span class="material-symbols-outlined text-[16px]">group</span>
                    <span>Peserta</span>
                </a>

                <a href="{{ url('/agenda/' . $training->slug) }}" target="_blank" 
                   class="w-9 h-9 rounded-xl border border-outline-variant/60 hover:bg-surface-container text-on-surface-variant flex items-center justify-center transition-all shrink-0" 
                   title="Buka halaman publik di tab baru">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-surface-container-lowest p-12 rounded-2xl border border-outline-variant/60 text-center flex flex-col items-center justify-center">
            <div class="w-16 h-16 rounded-2xl bg-surface-container-high text-outline flex items-center justify-center mb-4 shadow-xs">
                <span class="material-symbols-outlined text-[36px] text-on-surface-variant/70">co_present</span>
            </div>
            <h3 class="font-headline text-lg font-bold text-primary">Belum Ada Pelatihan yang Ditugaskan</h3>
            <p class="text-xs sm:text-sm text-on-surface-variant mt-1.5 max-w-md leading-relaxed">
                Anda belum ditugaskan sebagai instruktur pengampu pada program pelatihan manapun saat ini.
            </p>
        </div>
        @endforelse
    </div>

</div>
@endsection
