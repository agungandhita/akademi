@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div class="space-y-3">
        <nav class="flex items-center gap-1.5 text-xs text-outline">
            <a href="{{ route('admin') }}" class="hover:text-secondary transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.trainings.index') }}" class="hover:text-secondary transition-colors">Manajemen Pelatihan</a>
            <span>/</span>
            <span class="text-primary font-semibold truncate max-w-xs sm:max-w-md">{{ $training->title }}</span>
            <span>/</span>
            <span class="text-secondary font-bold">Daftar Peserta</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $training->status?->badgeClass() }}">
                        {{ $training->status?->label() }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $training->mode?->badgeClass() }}">
                        {{ $training->mode?->label() }}
                    </span>
                </div>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">
                    Daftar Peserta Pelatihan
                </h1>
                <p class="text-xs sm:text-sm text-on-surface-variant mt-0.5">
                    Program: <strong class="text-primary">{{ $training->title }}</strong> • Kuota: 
                    <strong class="text-secondary">{{ $training->quota ? $counts['registered'] . ' / ' . $training->quota . ' Peserta' : $counts['registered'] . ' Peserta (Tanpa Batas)' }}</strong>
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-2.5">
                <button type="button" onclick="openWaBlastModal()" 
                        class="px-4 py-2.5 bg-[#25D366] hover:bg-[#20ba5a] text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 shrink-0 hover:scale-[1.02] cursor-pointer">
                    <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                    </svg>
                    <span>Kirim Pengumuman WA</span>
                </button>
                <a href="{{ route('admin.trainings.participants.export', $training->id) }}" class="px-4 py-2.5 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>Ekspor CSV</span>
                </a>
                <a href="{{ route('admin.trainings.index') }}" class="px-3.5 py-2.5 border border-outline-variant/60 hover:bg-surface-container text-xs font-semibold text-on-surface-variant rounded-xl transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Status Metric Pills -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <!-- Total -->
        <a href="{{ route('admin.trainings.participants', ['training' => $training->id, 'search' => request('search')]) }}" 
           class="p-4 rounded-2xl border transition-all {{ !request('status') ? 'bg-primary text-white border-primary shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/60 hover:bg-surface-container-low' }}">
            <div class="text-[11px] font-bold uppercase tracking-wider {{ !request('status') ? 'text-white/80' : 'text-outline' }}">Total Pendaftar</div>
            <div class="font-headline text-2xl font-black mt-1">{{ $counts['total'] }}</div>
        </a>

        <!-- Terdaftar (Aktif) -->
        <a href="{{ route('admin.trainings.participants', ['training' => $training->id, 'status' => 'registered', 'search' => request('search')]) }}" 
           class="p-4 rounded-2xl border transition-all {{ request('status') === 'registered' ? 'bg-secondary text-white border-secondary shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/60 hover:bg-surface-container-low' }}">
            <div class="text-[11px] font-bold uppercase tracking-wider {{ request('status') === 'registered' ? 'text-white/80' : 'text-outline' }}">Terdaftar Aktif</div>
            <div class="font-headline text-2xl font-black mt-1">{{ $counts['registered'] }}</div>
        </a>

        <!-- Selesai -->
        <a href="{{ route('admin.trainings.participants', ['training' => $training->id, 'status' => 'completed', 'search' => request('search')]) }}" 
           class="p-4 rounded-2xl border transition-all {{ request('status') === 'completed' ? 'bg-tertiary-fixed text-primary border-tertiary shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/60 hover:bg-surface-container-low' }}">
            <div class="text-[11px] font-bold uppercase tracking-wider text-outline">Selesai</div>
            <div class="font-headline text-2xl font-black mt-1 text-primary">{{ $counts['completed'] }}</div>
        </a>

        <!-- Dibatalkan -->
        <a href="{{ route('admin.trainings.participants', ['training' => $training->id, 'status' => 'cancelled', 'search' => request('search')]) }}" 
           class="p-4 rounded-2xl border transition-all {{ request('status') === 'cancelled' ? 'bg-error-container text-error border-error shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/60 hover:bg-surface-container-low' }}">
            <div class="text-[11px] font-bold uppercase tracking-wider text-outline">Dibatalkan</div>
            <div class="font-headline text-2xl font-black mt-1 text-error">{{ $counts['cancelled'] }}</div>
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.trainings.participants', $training->id) }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto flex-1">
            <div class="relative w-full sm:max-w-md">
                <span class="material-symbols-outlined text-[20px] text-outline absolute left-3.5 top-2.5">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, institusi..." 
                    class="w-full h-10 pl-10 pr-4 text-xs sm:text-sm text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none transition-all placeholder:text-outline" />
                @if(request('search'))
                    <a href="{{ route('admin.trainings.participants', ['training' => $training->id, 'status' => request('status')]) }}" 
                       class="absolute right-3 top-2.5 text-outline hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                @endif
            </div>

            <div class="w-full sm:w-auto">
                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto h-10 px-3.5 py-2 text-xs sm:text-sm text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white outline-none cursor-pointer">
                    <option value="">Semua Status Pendaftaran</option>
                    @foreach($statuses as $st)
                        <option value="{{ $st->value }}" {{ request('status') === $st->value ? 'selected' : '' }}>
                            {{ $st->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="h-10 px-4 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl transition-all shadow-2xs flex items-center justify-center gap-1.5 flex-1 sm:flex-initial">
                    <span class="material-symbols-outlined text-[16px]">tune</span>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.trainings.participants', $training->id) }}" 
                       class="h-10 px-3.5 border border-outline-variant/60 hover:bg-surface-container text-xs font-semibold text-on-surface-variant rounded-xl transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <span class="text-xs text-outline font-medium shrink-0 self-end md:self-auto">
            Total: <strong class="text-primary font-bold">{{ $participants->total() }}</strong> Peserta Ditemukan
        </span>
    </div>

    <!-- Participants Table -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                <thead class="bg-surface-container-low text-outline font-bold uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                    <tr>
                        <th class="py-4 px-5 sm:px-6">Peserta</th>
                        <th class="py-4 px-4">Tipe &amp; Institusi</th>
                        <th class="py-4 px-4">Kontak (HP/WA)</th>
                        <th class="py-4 px-4">Status Pendaftaran</th>
                        <th class="py-4 px-4">Tanggal Daftar</th>
                        <th class="py-4 px-5 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse ($participants as $enrollment)
                    @php $user = $enrollment->user; @endphp
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <!-- User Name & Avatar -->
                        <td class="py-4 px-5 sm:px-6">
                            <div class="flex items-center gap-3.5">
                                @if($user?->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-2xl object-cover shadow-2xs shrink-0 border border-outline-variant/60" />
                                @else
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-primary to-primary-container text-white font-headline text-xs font-bold flex items-center justify-center shadow-2xs shrink-0">
                                        {{ strtoupper(substr($user?->name ?? 'P', 0, 2)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 space-y-0.5">
                                    <span class="font-bold text-primary truncate block max-w-xs text-sm">
                                        {{ $user?->name ?? 'Pengguna Tidak Ditemukan' }}
                                    </span>
                                    <div class="text-[11px] text-on-surface-variant/80 flex items-center gap-1 truncate">
                                        <span class="material-symbols-outlined text-[13px] text-outline">mail</span>
                                        <span class="truncate">{{ $user?->email ?? '—' }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Institution & Participant Type -->
                        <td class="py-4 px-4">
                            <div class="text-xs text-primary font-semibold truncate max-w-xs">
                                {{ $user?->institution ?: '—' }}
                            </div>
                            @if($user?->participant_type)
                                <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded text-[10px] font-bold {{ $user->participant_type->badgeClass() }}">
                                    <span class="material-symbols-outlined text-[12px]">{{ $user->participant_type->icon() }}</span>
                                    <span>{{ $user->participant_type->label() }}</span>
                                </div>
                            @endif
                        </td>

                        <!-- Phone -->
                        <td class="py-4 px-4">
                            @if($user?->phone)
                                <div class="text-xs text-primary font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[15px] text-secondary">phone</span>
                                    <span>{{ $user->phone }}</span>
                                </div>
                            @else
                                <span class="text-xs text-outline">—</span>
                            @endif
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $enrollment->status?->badgeClass() }}">
                                <span class="material-symbols-outlined text-[14px]">{{ $enrollment->status?->icon() }}</span>
                                <span>{{ $enrollment->status?->label() }}</span>
                            </span>
                        </td>

                        <!-- Enrolled At -->
                        <td class="py-4 px-4 text-xs text-outline whitespace-nowrap">
                            {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->translatedFormat('d M Y, H:i') : '—' }}
                        </td>

                        <!-- Action -->
                        <td class="py-4 px-5 sm:px-6 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                @if($user && $user->phone)
                                    <button type="button" 
                                            onclick="openSingleWa('{{ addslashes($user->name) }}', '{{ $user->phone }}', '{{ addslashes($user->institution ?? '') }}')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-[#25D366]/10 hover:bg-[#25D366] text-[#128C7E] hover:text-white font-semibold text-xs rounded-xl transition-all shadow-2xs cursor-pointer hover:scale-[1.02]"
                                            title="Kirim Undangan WhatsApp ke {{ $user->name }}">
                                        <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                                        </svg>
                                        <span class="hidden sm:inline">Kirim WA</span>
                                    </button>
                                @endif

                                @if($user)
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-surface-container hover:bg-secondary hover:text-white font-semibold text-xs rounded-xl transition-all shadow-2xs text-primary cursor-pointer"
                                       title="Lihat Detail Profil Pengguna">
                                        <span class="material-symbols-outlined text-[15px]">visibility</span>
                                        <span class="hidden sm:inline">Detail User</span>
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('admin.trainings.participants.destroy', [$training->id, $enrollment->id]) }}" class="form-delete inline" data-title="{{ $user?->name ?? 'Peserta' }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(event, '{{ addslashes($user?->name ?? 'Peserta') }}', 'Apakah Anda yakin ingin menghapus peserta <strong>&quot;{{ addslashes($user?->name ?? 'Peserta') }}&quot;</strong> dari program pelatihan ini?<br><span style=\'font-size:12px;color:#6b7280;margin-top:6px;display:block;\'>Peserta tidak akan lagi terdaftar pada pelatihan ini.</span>')"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-error/10 hover:bg-error hover:text-white text-error font-semibold text-xs rounded-xl transition-all shadow-2xs cursor-pointer hover:scale-[1.02]" 
                                            title="Hapus Peserta dari Pelatihan">
                                        <span class="material-symbols-outlined text-[15px]">person_remove</span>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-outline">
                            <span class="material-symbols-outlined text-4xl mb-1 text-outline">how_to_reg</span>
                            <p class="font-headline font-bold text-sm text-primary">Belum Ada Peserta Terdaftar</p>
                            <p class="text-xs text-on-surface-variant mt-0.5">Peserta yang mendaftar pada program ini akan otomatis tercatat di sini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($participants->hasPages())
        <div class="p-4 border-t border-outline-variant/40 bg-surface-container-low">
            {{ $participants->links() }}
        </div>
        @endif
    </div>

</div>

@php
    $waSourceCollection = request()->hasAny(['search', 'status'])
        ? $participants->getCollection()
        : ($allParticipants ?? $participants);

    $waParticipantsData = $waSourceCollection->filter(function ($enr) {
        return $enr->user && !empty($enr->user->phone);
    })->values()->map(function ($enr) {
        return [
            'id' => $enr->id,
            'name' => $enr->user->name,
            'email' => $enr->user->email,
            'phone' => $enr->user->phone,
            'institution' => $enr->user->institution ?? 'Peserta Pelatihan',
            'status' => $enr->status?->label() ?? 'Terdaftar',
        ];
    });

    $waNonEnrolledData = ($nonEnrolledUsers ?? collect())->filter(function ($u) {
        return !empty($u->phone);
    })->values()->map(function ($u) {
        return [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'phone' => $u->phone,
            'institution' => $u->institution ?? 'Calon Peserta',
            'status' => 'Belum Terdaftar',
        ];
    });

    $registrationUrl = route('agenda.detail', $training->slug);
@endphp

<!-- Modal Panel WA Blast / Broadcast Pengumuman -->
<div id="waBlastModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/60 backdrop-blur-xs p-2 sm:p-4 md:p-6" onclick="if(event.target === this) closeWaBlastModal()" style="overscroll-behavior: contain;">
    <div class="min-h-full flex items-center justify-center py-2 sm:py-4">
        <div class="bg-surface-container-lowest rounded-2xl shadow-2xl w-full max-w-5xl border border-outline-variant/60 overflow-hidden flex flex-col max-h-[calc(100vh-2rem)] sm:max-h-[calc(100vh-3rem)] animate-in fade-in zoom-in-95 duration-200 my-auto text-left">
        
        <!-- Header Modal -->
        <div class="px-5 py-4 border-b border-outline-variant/40 flex items-center justify-between bg-surface-container-low/60 shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-[#25D366] shrink-0 shadow-2xs">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-headline text-base font-bold text-primary flex items-center gap-2">
                        <span>Broadcast WhatsApp Peserta Pelatihan</span>
                    </h3>
                    <p class="text-xs text-on-surface-variant truncate max-w-md">
                        Program: {{ $training->title }}
                    </p>
                </div>
            </div>
            
            <button type="button" onclick="closeWaBlastModal()" class="w-8 h-8 rounded-lg flex items-center justify-center text-outline hover:text-on-surface hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <!-- Navigation Tabs for Modes -->
        <div class="px-5 pt-3 border-b border-outline-variant/40 bg-surface-container-low/40 flex items-center gap-2 overflow-x-auto shrink-0">
            <button type="button" id="tabRegisteredBtn" onclick="switchWaMode('registered')" 
                    class="pb-2.5 px-3 border-b-2 font-headline text-xs font-bold transition-all flex items-center gap-2 border-secondary text-secondary">
                <span class="material-symbols-outlined text-[17px]">group</span>
                <span>Peserta Terdaftar (Grup WA)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800" id="tabRegisteredBadge">
                    {{ $waParticipantsData->count() }} Kontak
                </span>
            </button>
            <button type="button" id="tabInviteBtn" onclick="switchWaMode('invite')" 
                    class="pb-2.5 px-3 border-b-2 font-headline text-xs font-bold transition-all flex items-center gap-2 border-transparent text-outline hover:text-primary">
                <span class="material-symbols-outlined text-[17px]">person_add</span>
                <span>Calon Peserta (Ajakan Daftar)</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-primary/10 text-primary" id="tabInviteBadge">
                    {{ $waNonEnrolledData->count() }} Kontak
                </span>
            </button>
            <button type="button" id="tabBroadcastBtn" onclick="switchWaMode('broadcast')" 
                    class="pb-2.5 px-3 border-b-2 font-headline text-xs font-bold transition-all flex items-center gap-2 border-transparent text-outline hover:text-primary">
                <span class="material-symbols-outlined text-[17px]">campaign</span>
                <span>Teks Siap Sebar (Grup Umum)</span>
            </button>
        </div>

        <!-- Info Strip Tautan Grup WA & Link Pendaftaran -->
        <div class="px-5 py-2.5 border-b border-outline-variant/40 shrink-0 bg-surface-container-low text-xs text-on-surface-variant flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[17px] {{ $training->whatsapp_group_link ? 'text-[#25D366]' : 'text-amber-600' }}">
                        {{ $training->whatsapp_group_link ? 'link' : 'warning' }}
                    </span>
                    <span>Link Grup WA: 
                        @if($training->whatsapp_group_link)
                            <strong class="font-bold underline text-primary">{{ $training->whatsapp_group_link }}</strong>
                        @else
                            <span class="text-amber-700 font-medium">Belum diisi (diarahkan ke link website)</span>
                        @endif
                    </span>
                </div>
                <span class="text-outline-variant">•</span>
                <div class="flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[17px] text-secondary">open_in_browser</span>
                    <span>Link Pendaftaran: <strong class="font-bold text-secondary underline">{{ $registrationUrl }}</strong></span>
                </div>
            </div>
            @if(!$training->whatsapp_group_link)
                <a href="{{ route('admin.trainings.edit', $training->id) }}" target="_blank" class="px-2.5 py-1 rounded-md bg-amber-200 hover:bg-amber-300 text-amber-900 font-bold text-[11px] transition-colors">
                    Edit Pelatihan
                </a>
            @endif
        </div>

        <!-- Body Grid Layout (Two Columns) -->
        <div class="p-5 overflow-y-auto flex-1 grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column: Template Editor & Live Preview (5 Cols) -->
            <div class="lg:col-span-5 space-y-4">
                
                <div class="bg-surface-container-low/50 p-4 rounded-xl border border-outline-variant/50 space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="waMessageTemplate" class="font-headline text-xs font-bold text-primary flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-secondary text-[16px]">edit_note</span>
                            <span id="waTemplateLabel">Format / Template Pesan WA</span>
                        </label>
                        <button type="button" onclick="resetWaTemplate()" class="text-[11px] text-secondary font-semibold hover:underline">
                            Reset Template
                        </button>
                    </div>

                    <textarea id="waMessageTemplate" rows="9" oninput="renderWaPreview()"
                              class="w-full p-3 rounded-xl bg-surface-container-lowest border border-outline-variant/60 text-xs font-mono text-on-surface focus:ring-2 focus:ring-[#25D366] outline-none leading-relaxed"></textarea>

                    <!-- Variable Tags Chips -->
                    <div>
                        <span class="text-[10px] text-outline uppercase font-bold tracking-wider block mb-1.5">Klik untuk Sisipkan Variabel:</span>
                        <div class="flex flex-wrap gap-1.5">
                            <button type="button" onclick="insertWaTag('{nama}')" class="px-2 py-1 rounded-md bg-surface-container hover:bg-secondary hover:text-white text-primary text-[11px] font-bold font-mono transition-colors">
                                + {nama}
                            </button>
                            <button type="button" onclick="insertWaTag('{pelatihan}')" class="px-2 py-1 rounded-md bg-surface-container hover:bg-secondary hover:text-white text-primary text-[11px] font-bold font-mono transition-colors">
                                + {pelatihan}
                            </button>
                            <button type="button" onclick="insertWaTag('{link_pendaftaran}')" class="px-2 py-1 rounded-md bg-surface-container hover:bg-secondary hover:text-white text-primary text-[11px] font-bold font-mono transition-colors">
                                + {link_pendaftaran}
                            </button>
                            <button type="button" onclick="insertWaTag('{link_wa}')" class="px-2 py-1 rounded-md bg-surface-container hover:bg-secondary hover:text-white text-primary text-[11px] font-bold font-mono transition-colors">
                                + {link_wa}
                            </button>
                            <button type="button" onclick="insertWaTag('{institusi}')" class="px-2 py-1 rounded-md bg-surface-container hover:bg-secondary hover:text-white text-primary text-[11px] font-bold font-mono transition-colors">
                                + {institusi}
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Live Preview Chat Bubble -->
                <div class="bg-surface-container-low/40 p-4 rounded-xl border border-outline-variant/40 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-headline font-bold text-primary flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-emerald-600 text-[16px]">visibility</span>
                            <span>Pratinjau Teks WhatsApp</span>
                        </span>
                        <span class="text-[10px] text-outline font-medium" id="waPreviewSubtitle">Pratinjau Realtime</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-[#DCF8C6]/80 text-[#075E54] text-xs leading-relaxed whitespace-pre-wrap font-sans border border-[#c3e6aa] shadow-2xs">
                        <div id="waPreviewContent">Memuat pratinjau...</div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Queue Sender & Controls (7 Cols) -->
            <div class="lg:col-span-7 space-y-4">
                
                <!-- Sequential Sender Card (For Mode Registered & Invite) -->
                <div id="waQueueSection" class="space-y-4">
                    <div class="bg-surface-container-low/70 p-4 sm:p-5 rounded-xl border border-outline-variant/50 space-y-3">
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <span class="text-[11px] font-bold text-outline uppercase tracking-wider block" id="waModeHeaderSubtitle">Fitur Kirim Cepat Berurutan</span>
                                <h4 class="font-headline text-sm font-bold text-primary" id="waModeHeaderTitle">Sesi Pengiriman Peserta Terdaftar</h4>
                            </div>
                            <div class="text-right">
                                <span class="font-headline text-xs font-bold text-primary" id="waProgressText">0 / 0 Terbuka</span>
                            </div>
                        </div>

                        <!-- Progress bar -->
                        <div class="w-full bg-surface-container-highest rounded-full h-2 overflow-hidden">
                            <div id="waProgressBar" class="h-full bg-[#25D366] transition-all duration-300" style="width: 0%"></div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 pt-1">
                            <!-- Auto next button -->
                            <button type="button" onclick="sendNextWa()" 
                                    class="flex-1 py-3 px-4 rounded-xl bg-[#25D366] hover:bg-[#20ba5a] text-white font-headline text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-xs transition-all hover:scale-[1.01] active:scale-[0.98] cursor-pointer">
                                <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                                </svg>
                                <span id="btnSendNextLabel">Kirim ke Peserta Berikutnya (Auto-Next)</span>
                                <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                            </button>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 pt-1 border-t border-outline-variant/30 text-xs">
                            <span class="text-outline text-[11px] font-semibold">Salin Kontak:</span>
                            <button type="button" onclick="copyAllWaPhones(', ')" class="px-2.5 py-1 rounded-lg border border-outline-variant/60 hover:bg-surface-container text-[11px] font-bold text-primary transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">content_copy</span>
                                <span>Format Koma (Broadcast List)</span>
                            </button>
                            <button type="button" onclick="copyAllWaPhones('\n')" class="px-2.5 py-1 rounded-lg border border-outline-variant/60 hover:bg-surface-container text-[11px] font-bold text-primary transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-[13px]">format_list_bulleted</span>
                                <span>Baris Baru</span>
                            </button>
                            <button type="button" onclick="resetSentSession()" class="text-[11px] text-error font-semibold hover:underline ml-auto">
                                Reset Sesi
                            </button>
                        </div>
                    </div>

                    <!-- Participant Queue List with Search -->
                    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/60 shadow-2xs overflow-hidden flex flex-col">
                        <div class="p-3 border-b border-outline-variant/40 bg-surface-container-low flex items-center justify-between gap-2">
                            <span class="font-headline text-xs font-bold text-primary" id="waQueueListTitle">Daftar Antrean Kontak</span>
                            <div class="relative w-48 sm:w-60">
                                <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-outline text-[16px]">search</span>
                                <input type="text" id="waParticipantSearch" oninput="filterWaList()" placeholder="Cari nama / no. HP..." 
                                       class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-surface-container-lowest border border-outline-variant/60 text-xs text-on-surface focus:outline-none focus:ring-1 focus:ring-secondary" />
                            </div>
                        </div>

                        <!-- Scrollable list -->
                        <div id="waParticipantContainer" class="max-h-[300px] overflow-y-auto divide-y divide-outline-variant/30">
                            <!-- Populated by JS -->
                        </div>
                    </div>
                </div>

                <!-- General Broadcast Action Card (For Mode Broadcast) -->
                <div id="waBroadcastSection" class="hidden bg-surface-container-low/70 p-5 rounded-xl border border-outline-variant/50 space-y-4">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px]">campaign</span>
                            </div>
                            <div>
                                <h4 class="font-headline text-sm font-bold text-primary">Teks Pesan WhatsApp Siap Sebar (Grup Umum)</h4>
                                <p class="text-xs text-on-surface-variant">Memuat info program, link pendaftaran, link grup WhatsApp, dan panduan langkah.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Full Preview WhatsApp Chat Bubble -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-headline font-bold text-primary flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-emerald-600 text-[16px]">chat</span>
                                <span>Teks Pesan WA Lengkap (Siap Copy &amp; Sebar)</span>
                            </span>
                            <span class="text-[11px] text-outline">Tautan Web &amp; Grup WA Terlampir</span>
                        </div>
                        <div id="waBroadcastFullPreview" class="p-4 rounded-xl bg-[#DCF8C6]/90 text-[#075E54] text-xs leading-relaxed whitespace-pre-wrap font-sans border border-[#c3e6aa] max-h-[300px] overflow-y-auto shadow-2xs font-medium">
                            Memuat pesan siaran...
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2.5 pt-1">
                        <button type="button" onclick="copyBroadcastMessage()" 
                                class="flex-1 py-3 px-4 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-xs transition-all cursor-pointer">
                            <span class="material-symbols-outlined text-[18px]">content_copy</span>
                            <span>Salin Teks Pesan WhatsApp</span>
                        </button>
                        <button type="button" onclick="shareBroadcastToWaWeb()" 
                                class="py-3 px-4 rounded-xl bg-[#25D366] hover:bg-[#20ba5a] text-white font-headline text-xs sm:text-sm font-bold flex items-center justify-center gap-2 shadow-xs transition-all cursor-pointer">
                            <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                            </svg>
                            <span>Buka WhatsApp Web</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer Modal -->
        <div class="px-5 py-3 border-t border-outline-variant/40 flex items-center justify-between bg-surface-container-low/60 shrink-0 text-xs">
            <span class="text-outline">
                Pesan dikirim langsung via protokol resmi WhatsApp Web/Desktop tanpa biaya langganan API.
            </span>
            <button type="button" onclick="closeWaBlastModal()" 
                    class="px-4 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-on-surface-variant font-bold transition-colors">
                Tutup
            </button>
        </div>

    </div>
    </div>
</div>

<!-- Notification Toast for Copied Status -->
<div id="waToast" class="fixed bottom-6 right-6 z-[60] hidden bg-primary text-white text-xs font-bold py-2.5 px-4 rounded-xl shadow-lg border border-white/10 items-center gap-2 animate-in fade-in slide-in-from-bottom-2 duration-200">
    <span class="material-symbols-outlined text-[16px] text-emerald-400">check_circle</span>
    <span id="waToastText">Teks berhasil disalin ke clipboard!</span>
</div>

<script>
    const trainingTitle = @json($training->title);
    const trainingWaGroupLink = @json($training->whatsapp_group_link ?: url('/'));
    const trainingRegistrationUrl = @json($registrationUrl);
    
    const waRegisteredParticipants = @json($waParticipantsData);
    const waNonEnrolledParticipants = @json($waNonEnrolledData);

    const templates = {
        registered: 
`Halo {nama},

Terima kasih telah mendaftar pada program pelatihan *{pelatihan}* di Akademi Pelatihan.

Untuk koordinasi pelaksanaan, pengumuman tautan ruang belajar, dan bimbingan langsung dari instruktur, silakan bergabung ke Grup WhatsApp resmi peserta berikut ini:

👉 {link_wa}

Sampai jumpa di sesi pelatihan!
Salam hangat,
Tim Akademi Pelatihan`,

        invite:
`Halo {nama},

Kabar baik! Program pelatihan *{pelatihan}* di Akademi Pelatihan saat ini resmi membuka pendaftaran! 🚀

Tingkatkan keahlian Anda dan dapatkan E-Sertifikat resmi terverifikasi bersama instruktur ahli.

📌 *Panduan Langkah Mudah Pendaftaran:*
1️⃣ Kunjungi tautan resmi pendaftaran:
   👉 {link_pendaftaran}
2️⃣ Masuk / Login ke akun Akademi Pelatihan Anda (atau klik Daftar Baru jika belum memiliki akun).
3️⃣ Pada halaman pelatihan, klik tombol hijau *"Daftar Pelatihan Sekarang"*.
4️⃣ Bergabunglah ke Grup WhatsApp resmi peserta melalui tautan berikut:
   👉 {link_wa}

📌 *Tautan Akses:*
🌐 Link Pendaftaran: {link_pendaftaran}
💬 Link Grup WhatsApp: {link_wa}

⏳ Kuota peserta terbatas. Yuk segera amankan kursi pelatihan Anda sekarang juga!

Salam hangat,
Tim Akademi Pelatihan`,

        broadcast:
`📢 *PENGUMUMAN PEMBUKAAN PENDAFTARAN PELATIHAN* 📢
--------------------------------------------------
Program: *{pelatihan}*
Penyelenggara: Akademi Pelatihan Indonesia

Halo Sahabat Pembelajar! 👋
Pendaftaran untuk program pelatihan *{pelatihan}* telah resmi dibuka. Program ini dirancang praktis dan aplikatif dengan bimbingan langsung dari instruktur ahli.

✨ *Fasilitas yang Didapatkan:*
• E-Sertifikat Resmi Terverifikasi Nasional (QR Code)
• Modul Ajar, Dokumen Panduan & Bahan Tayang Lengkap
• Sesi Live & Diskusi Interaktif
• Grup Koordinasi WhatsApp Eksklusif Peserta

📝 *Panduan Langkah Mudah Pendaftaran:*
1️⃣ Buka tautan resmi pendaftaran:
   👉 {link_pendaftaran}
2️⃣ Masuk / Login ke akun Anda (atau Registrasi Akun Baru jika baru).
3️⃣ Pada halaman pelatihan, klik tombol *"Daftar Pelatihan Sekarang"*.
4️⃣ Bergabunglah ke Grup WhatsApp resmi peserta melalui tautan berikut:
   👉 {link_wa}

📌 *Tautan Resmi:*
🌐 Link Pendaftaran: {link_pendaftaran}
💬 Link Grup WhatsApp: {link_wa}

Jangan lewatkan kesempatan berharga ini. Kuota peserta terbatas! Silakan bagikan info bermanfaat ini kepada rekan kerja dan sahabat Anda. 🙏`
    };

    let currentWaMode = 'registered'; // 'registered' | 'invite' | 'broadcast'
    let currentDataset = waRegisteredParticipants;
    let sentParticipantIds = new Set();

    function formatPhoneForWa(phone) {
        if (!phone) return '';
        let cleaned = phone.replace(/[^0-9]/g, '');
        if (cleaned.startsWith('0')) {
            cleaned = '62' + cleaned.substring(1);
        } else if (cleaned.startsWith('8')) {
            cleaned = '62' + cleaned;
        }
        return cleaned;
    }

    function switchWaMode(mode) {
        currentWaMode = mode;

        const tabRegisteredBtn = document.getElementById('tabRegisteredBtn');
        const tabInviteBtn = document.getElementById('tabInviteBtn');
        const tabBroadcastBtn = document.getElementById('tabBroadcastBtn');

        const queueSection = document.getElementById('waQueueSection');
        const broadcastSection = document.getElementById('waBroadcastSection');

        // Style reset
        [tabRegisteredBtn, tabInviteBtn, tabBroadcastBtn].forEach(btn => {
            btn.className = "pb-2.5 px-3 border-b-2 font-headline text-xs font-bold transition-all flex items-center gap-2 border-transparent text-outline hover:text-primary";
        });

        const activeClass = "pb-2.5 px-3 border-b-2 font-headline text-xs font-bold transition-all flex items-center gap-2 border-secondary text-secondary";

        if (mode === 'registered') {
            tabRegisteredBtn.className = activeClass;
            currentDataset = waRegisteredParticipants;
            queueSection.classList.remove('hidden');
            broadcastSection.classList.add('hidden');
            document.getElementById('waModeHeaderTitle').innerText = 'Sesi Pengiriman: Peserta Terdaftar';
            document.getElementById('waModeHeaderSubtitle').innerText = 'Kirim Tautan Grup WA';
            document.getElementById('waQueueListTitle').innerText = `Daftar Antrean Peserta (${waRegisteredParticipants.length})`;
        } else if (mode === 'invite') {
            tabInviteBtn.className = activeClass;
            currentDataset = waNonEnrolledParticipants;
            queueSection.classList.remove('hidden');
            broadcastSection.classList.add('hidden');
            document.getElementById('waModeHeaderTitle').innerText = 'Sesi Pengiriman: Calon Peserta (Ajakan Daftar)';
            document.getElementById('waModeHeaderSubtitle').innerText = 'Ajakan Daftar & Panduan Langkah';
            document.getElementById('waQueueListTitle').innerText = `Daftar Antrean Calon Peserta (${waNonEnrolledParticipants.length})`;
        } else {
            tabBroadcastBtn.className = activeClass;
            currentDataset = [];
            queueSection.classList.add('hidden');
            broadcastSection.classList.remove('hidden');
        }

        // Set textarea template according to mode
        document.getElementById('waMessageTemplate').value = templates[mode] || templates.registered;
        sentParticipantIds.clear();

        renderWaPreview();
        renderWaParticipantsList();
        updateWaProgress();
    }

    function openWaBlastModal() {
        const modal = document.getElementById('waBlastModal');
        if (!modal) return;
        
        modal.classList.remove('hidden');
        switchWaMode(currentWaMode);
    }

    function closeWaBlastModal() {
        const modal = document.getElementById('waBlastModal');
        if (modal) modal.classList.add('hidden');
    }

    function resetWaTemplate() {
        document.getElementById('waMessageTemplate').value = templates[currentWaMode] || templates.registered;
        renderWaPreview();
    }

    function insertWaTag(tag) {
        const textarea = document.getElementById('waMessageTemplate');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        textarea.value = text.substring(0, start) + tag + text.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + tag.length;
        textarea.focus();
        renderWaPreview();
    }

    function getPersonalizedMessage(participant) {
        const template = document.getElementById('waMessageTemplate').value || templates[currentWaMode];
        const name = participant ? participant.name : 'Nama Rekan';
        const institution = participant && participant.institution ? participant.institution : 'Akademi Pelatihan';
        
        return template
            .replace(/\{nama\}/g, name)
            .replace(/\{pelatihan\}/g, trainingTitle)
            .replace(/\{link_wa\}/g, trainingWaGroupLink)
            .replace(/\{link_pendaftaran\}/g, trainingRegistrationUrl)
            .replace(/\{institusi\}/g, institution);
    }

    function renderWaPreview() {
        const sampleParticipant = currentDataset.length > 0 ? currentDataset[0] : null;
        const previewText = getPersonalizedMessage(sampleParticipant);
        const previewEl = document.getElementById('waPreviewContent');
        if (previewEl) previewEl.innerText = previewText;

        const broadcastPreviewEl = document.getElementById('waBroadcastFullPreview');
        if (broadcastPreviewEl) broadcastPreviewEl.innerText = previewText;
    }

    function renderWaParticipantsList(filterText = '') {
        const container = document.getElementById('waParticipantContainer');
        if (!container) return;

        const filtered = currentDataset.filter(p => {
            if (!filterText) return true;
            const term = filterText.toLowerCase();
            return (p.name && p.name.toLowerCase().includes(term)) || (p.phone && p.phone.includes(term));
        });

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="py-8 text-center text-xs text-outline">
                    Tidak ada kontak pada kategori atau kriteria pencarian ini.
                </div>
            `;
            return;
        }

        container.innerHTML = filtered.map((p, idx) => {
            const isSent = sentParticipantIds.has(p.id);
            const cleanPhone = formatPhoneForWa(p.phone);
            
            return `
                <div id="wa-row-${p.id}" class="p-3 sm:px-4 flex items-center justify-between gap-3 hover:bg-surface-container-low transition-colors ${isSent ? 'bg-emerald-50/40' : ''}">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-headline font-bold text-xs text-primary truncate">${p.name}</span>
                            ${isSent 
                                ? '<span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800">Terkirim</span>' 
                                : '<span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-surface-container text-outline">Belum</span>'
                            }
                        </div>
                        <div class="text-[11px] text-on-surface-variant flex items-center gap-2 mt-0.5">
                            <span>📞 ${p.phone}</span>
                            ${p.institution ? `<span>• ${p.institution}</span>` : ''}
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 shrink-0">
                        <button type="button" onclick="copySingleWaMessage(${p.id})" 
                                class="p-1.5 rounded-lg border border-outline-variant hover:bg-surface-container text-outline hover:text-primary transition-colors"
                                title="Salin Teks Pesan">
                            <span class="material-symbols-outlined text-[15px]">content_copy</span>
                        </button>
                        <button type="button" onclick="sendIndividualFromList(${p.id})" 
                                class="px-2.5 py-1.5 rounded-lg ${isSent ? 'bg-surface-container text-on-surface-variant' : 'bg-[#25D366] hover:bg-[#20ba5a] text-white'} text-[11px] font-bold transition-all flex items-center gap-1 shadow-2xs">
                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.539 1.761.815 2.791.815 3.181 0 5.767-2.586 5.768-5.766 0-3.18-2.586-5.766-5.768-5.766zm9.969 5.766c0 5.503-4.466 9.969-9.969 9.969-1.748 0-3.376-.452-4.795-1.24l-5.236 1.373 1.397-5.107c-.901-1.488-1.435-3.234-1.435-5.095 0-5.503 4.466-9.969 9.969-9.969 5.503 0 9.969 4.466 9.969 9.969zm-5.467 3.513c-.234-.117-1.385-.683-1.6-.761-.215-.078-.372-.117-.528.117s-.607.761-.744.918c-.137.156-.273.176-.507.059-.234-.117-.988-.364-1.882-1.161-.696-.621-1.166-1.388-1.303-1.622-.137-.234-.015-.361.103-.477.106-.105.234-.273.351-.41.117-.137.156-.234.234-.39.078-.156.039-.293-.02-.41s-.528-1.27-.723-1.738c-.19-.457-.384-.395-.528-.402l-.45-.008c-.156 0-.41.059-.625.293s-.82 1.015-.82 2.476 1.055 2.871 1.202 3.066c.146.195 2.076 3.169 5.029 4.444.702.304 1.25.485 1.677.621.705.224 1.347.193 1.854.117.565-.085 1.738-.71 1.982-1.395.244-.684.244-1.27.171-1.395-.074-.124-.23-.195-.464-.312z"/>
                            </svg>
                            <span>${isSent ? 'Kirim Ulang' : 'Kirim WA'}</span>
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    function filterWaList() {
        const text = document.getElementById('waParticipantSearch').value;
        renderWaParticipantsList(text);
    }

    function sendIndividualFromList(id) {
        const p = currentDataset.find(item => item.id === id);
        if (!p) return;

        const cleanPhone = formatPhoneForWa(p.phone);
        const message = getPersonalizedMessage(p);
        const waUrl = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encodeURIComponent(message)}`;

        window.open(waUrl, '_blank');
        sentParticipantIds.add(p.id);
        renderWaParticipantsList(document.getElementById('waParticipantSearch').value);
        updateWaProgress();
    }

    function sendNextWa() {
        const unsent = currentDataset.find(p => !sentParticipantIds.has(p.id));
        if (!unsent) {
            showWaToast('Seluruh kontak pada antrean telah dibuka!');
            return;
        }

        sendIndividualFromList(unsent.id);

        // Scroll to the item in list
        const el = document.getElementById(`wa-row-${unsent.id}`);
        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function updateWaProgress() {
        const total = currentDataset.length;
        const sent = sentParticipantIds.size;
        const percent = total > 0 ? Math.round((sent / total) * 100) : 0;

        const textEl = document.getElementById('waProgressText');
        const barEl = document.getElementById('waProgressBar');
        const btnLabel = document.getElementById('btnSendNextLabel');

        if (textEl) textEl.innerText = `${sent} / ${total} Terbuka (${percent}%)`;
        if (barEl) barEl.style.width = `${percent}%`;

        if (btnLabel) {
            if (sent >= total && total > 0) {
                btnLabel.innerText = 'Semua Kontak Selesai Dibuka 🎉';
            } else {
                btnLabel.innerText = `Kirim Kontak Berikutnya (#${sent + 1})`;
            }
        }
    }

    function resetSentSession() {
        sentParticipantIds.clear();
        renderWaParticipantsList(document.getElementById('waParticipantSearch').value);
        updateWaProgress();
        showWaToast('Riwayat status pengiriman sesi telah direset.');
    }

    function copyAllWaPhones(delimiter) {
        const phones = currentDataset.map(p => formatPhoneForWa(p.phone)).filter(p => !!p);
        if (phones.length === 0) {
            showWaToast('Tidak ada nomor WhatsApp yang tersedia.');
            return;
        }

        const text = phones.join(delimiter);
        navigator.clipboard.writeText(text).then(() => {
            showWaToast(`${phones.length} nomor WhatsApp berhasil disalin!`);
        });
    }

    function copySingleWaMessage(id) {
        const p = currentDataset.find(item => item.id === id);
        if (!p) return;

        const message = getPersonalizedMessage(p);
        navigator.clipboard.writeText(message).then(() => {
            showWaToast(`Pesan untuk ${p.name} disalin ke clipboard!`);
        });
    }

    function copyBroadcastMessage() {
        const message = getPersonalizedMessage(null);
        navigator.clipboard.writeText(message).then(() => {
            showWaToast('Teks pengumuman broadcast berhasil disalin ke clipboard!');
        });
    }

    function shareBroadcastToWaWeb() {
        const message = getPersonalizedMessage(null);
        const waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(message)}`;
        window.open(waUrl, '_blank');
    }

    function openSingleWa(name, phone, institution) {
        const participant = { name: name, phone: phone, institution: institution };
        const cleanPhone = formatPhoneForWa(phone);
        const message = getPersonalizedMessage(participant);
        const waUrl = `https://api.whatsapp.com/send?phone=${cleanPhone}&text=${encodeURIComponent(message)}`;

        window.open(waUrl, '_blank');
    }

    function showWaToast(text) {
        const toast = document.getElementById('waToast');
        const toastText = document.getElementById('waToastText');
        if (!toast || !toastText) return;

        toastText.innerText = text;
        toast.classList.remove('hidden');
        toast.classList.add('flex');

        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('flex');
        }, 3000);
    }
</script>
@endsection

