@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Hero Header Banner -->
    <div class="bg-primary rounded-2xl p-6 sm:p-8 bg-gradient-to-r from-primary to-primary-container text-white relative overflow-hidden shadow-md">
        <div class="relative z-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-tertiary-fixed-dim text-xs font-bold mb-3 border border-white/10">
                <span class="material-symbols-outlined text-[14px]">book</span>
                <span>Program Pembelajaran Terdaftar</span>
            </div>
            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                Pelatihan Saya
            </h1>
            <p class="text-xs sm:text-sm text-white/80 mt-2 leading-relaxed">
                Kelola dan ikuti seluruh program pelatihan, workshop, dan bimbingan teknis yang sedang Anda ikuti.
            </p>
        </div>
        <div class="absolute -right-8 -bottom-10 opacity-10 pointer-events-none hidden md:block">
            <span class="material-symbols-outlined text-[200px]">school</span>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-3 relative z-10">
            <a href="{{ route('agenda') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all hover:scale-[1.02]">
                <span class="material-symbols-outlined text-[18px]">search</span>
                <span>Cari Pelatihan Baru</span>
            </a>
            <a href="{{ route('peserta') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-headline text-xs font-semibold backdrop-blur-xs transition-all">
                <span class="material-symbols-outlined text-[18px]">dashboard</span>
                <span>Dashboard Peserta</span>
            </a>
        </div>
    </div>

    <!-- Enrolled Trainings List -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="p-5 sm:p-6 border-b border-outline-variant/40 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h3 class="font-headline text-base sm:text-lg font-bold text-primary">Daftar Pelatihan yang Diikuti</h3>
                <p class="text-xs text-on-surface-variant mt-0.5">Total {{ $enrolledTrainings->count() }} program pelatihan terdaftar</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold self-start sm:self-auto">
                {{ $enrolledTrainings->count() }} Pelatihan Aktif
            </span>
        </div>

        <div class="divide-y divide-outline-variant/30">
            @forelse ($enrolledTrainings as $enrollment)
                @php
                    $training = $enrollment->training;
                @endphp
                @if($training)
                    <div class="p-5 sm:p-6 flex flex-col lg:flex-row lg:items-center justify-between gap-5 hover:bg-surface-container-low/40 transition-colors">
                        <div class="flex items-start gap-4 flex-1">
                            <!-- Thumbnail / Icon -->
                            @if($training->thumbnail)
                                @php
                                    $thumbUrl = \Illuminate\Support\Str::startsWith($training->thumbnail, ['http://', 'https://'])
                                        ? $training->thumbnail
                                        : asset('storage/' . $training->thumbnail);
                                @endphp
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden bg-surface-container-low border border-outline-variant/40 shrink-0">
                                    <img src="{{ $thumbUrl }}" alt="{{ $training->title }}" class="w-full h-full object-cover" />
                                </div>
                            @else
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-primary text-white flex items-center justify-center font-headline font-bold shrink-0 shadow-xs">
                                    <span class="material-symbols-outlined text-[32px]">school</span>
                                </div>
                            @endif

                            <!-- Meta Details -->
                            <div class="space-y-1.5 flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded text-[10px] font-bold {{ $enrollment->status?->badgeClass() ?? 'bg-secondary-fixed text-on-secondary-fixed' }}">
                                        {{ $enrollment->status?->label() ?? 'Terdaftar' }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-surface-container text-on-surface-variant">
                                        {{ $training->mode?->label() ?? 'Online' }}
                                    </span>
                                    @if($training->category)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-primary/10 text-primary">
                                            {{ $training->category->name }}
                                        </span>
                                    @endif
                                    <span class="text-[11px] text-outline">
                                        Terdaftar: {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->format('d M Y') : '—' }}
                                    </span>
                                </div>                                <h4 class="font-headline text-base sm:text-lg font-bold text-primary hover:text-secondary transition-colors">
                                    <a href="{{ route('peserta.trainings.show', $training->id) }}">
                                         {{ $training->title }}
                                     </a>
                                 </h4>

                                 <p class="text-xs text-on-surface-variant line-clamp-2">
                                     {{ $training->description }}
                                 </p>

                                 <!-- Sessions & Schedule Summary -->
                                 <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-[11px] text-on-surface-variant pt-1">
                                     <span class="flex items-center gap-1 font-medium">
                                         <span class="material-symbols-outlined text-[15px] text-secondary">calendar_month</span>
                                         <span>{{ $training->start_date ? $training->start_date->format('d M Y') : '—' }} @if($training->end_date && $training->end_date != $training->start_date) s.d. {{ $training->end_date->format('d M Y') }} @endif</span>
                                     </span>
                                     <span class="flex items-center gap-1 font-medium">
                                         <span class="material-symbols-outlined text-[15px] text-secondary">schedule</span>
                                         <span>{{ $training->sessions->count() }} Sesi Pertemuan</span>
                                     </span>
                                     <span class="flex items-center gap-1 font-medium text-secondary">
                                         <span class="material-symbols-outlined text-[15px]">menu_book</span>
                                         <span>{{ $training->modules->where('status', \App\Enums\ModuleStatus::Published)->count() }} Modul Pembelajaran</span>
                                     </span>
                                     @if($training->location)
                                         <span class="flex items-center gap-1 font-medium truncate max-w-xs">
                                             <span class="material-symbols-outlined text-[15px] text-secondary">location_on</span>
                                             <span class="truncate">{{ $training->location }}</span>
                                         </span>
                                     @endif
                                 </div>
                            </div>
                        </div>

                        <!-- CTA Actions -->
                        <div class="flex items-center gap-2 self-start lg:self-center shrink-0 pt-2 lg:pt-0">
                            @if($training->whatsapp_group_link)
                                <a href="{{ $training->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer" 
                                   class="px-3.5 py-2.5 bg-[#25D366] hover:bg-[#20ba5a] text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 hover:scale-[1.02]"
                                   title="Masuk Grup WhatsApp Koordinasi Pelatihan">
                                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                                    </svg>
                                    <span>Grup WA</span>
                                </a>
                            @endif
                            <a href="{{ route('peserta.trainings.show', $training->id) }}" 
                               class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 hover:scale-[1.02]">
                                <span class="material-symbols-outlined text-[16px]">play_lesson</span>
                                <span>Buka Ruang Belajar &amp; Modul</span>
                            </a>
                            <a href="{{ route('agenda.detail', $training->slug) }}" 
                               class="px-3 py-2.5 rounded-xl border border-outline-variant hover:bg-surface-container text-xs font-semibold text-on-surface-variant transition-colors"
                                title="Lihat Detail Brosur Publik">
                                <span class="material-symbols-outlined text-[16px]">visibility</span>
                            </a>
                        </div>
                    </div>
                @endif
            @empty
                <!-- Empty State -->
                <div class="py-16 px-6 text-center flex flex-col items-center justify-center">
                    <div class="w-16 h-16 rounded-2xl bg-surface-container-high text-outline flex items-center justify-center mb-4 shadow-xs">
                        <span class="material-symbols-outlined text-[36px] text-on-surface-variant/70">school</span>
                    </div>
                    <h4 class="font-headline text-base sm:text-lg font-bold text-primary">
                        Belum Ada Pelatihan yang Diikuti
                    </h4>
                    <p class="text-xs sm:text-sm text-on-surface-variant mt-1.5 max-w-md leading-relaxed">
                        Anda belum mendaftar pada program pelatihan manapun. Temukan berbagai workshop, bimbingan teknis, dan sertifikasi berkualitas sekarang.
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
