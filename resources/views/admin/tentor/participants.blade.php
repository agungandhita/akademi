@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div class="space-y-3">
        <nav class="flex items-center gap-1.5 text-xs text-outline">
            <a href="{{ route('tentor') }}" class="hover:text-secondary transition-colors">Portal Tentor</a>
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
                    Program yang Anda ampu: <strong class="text-primary">{{ $training->title }}</strong> • 
                    Keterisian Kuota: <strong class="text-secondary">{{ $training->quota ? $counts['registered'] . ' / ' . $training->quota : $counts['registered'] }} Peserta</strong>
                </p>
            </div>
            
            <div class="flex items-center gap-2.5">
                <a href="{{ route('tentor') }}" class="px-3.5 py-2.5 border border-outline-variant/60 hover:bg-surface-container text-xs font-semibold text-on-surface-variant rounded-xl transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                    <span>Kembali ke Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Status Metric Pills -->
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <!-- Total -->
        <a href="{{ route('tentor.trainings.participants', ['training' => $training->id, 'search' => request('search')]) }}" 
           class="p-4 rounded-2xl border transition-all {{ !request('status') ? 'bg-primary text-white border-primary shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/60 hover:bg-surface-container-low' }}">
            <div class="text-[11px] font-bold uppercase tracking-wider {{ !request('status') ? 'text-white/80' : 'text-outline' }}">Total Peserta</div>
            <div class="font-headline text-2xl font-black mt-1">{{ $counts['total'] }}</div>
        </a>

        <!-- Terdaftar (Aktif) -->
        <a href="{{ route('tentor.trainings.participants', ['training' => $training->id, 'status' => 'registered', 'search' => request('search')]) }}" 
           class="p-4 rounded-2xl border transition-all {{ request('status') === 'registered' ? 'bg-secondary text-white border-secondary shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/60 hover:bg-surface-container-low' }}">
            <div class="text-[11px] font-bold uppercase tracking-wider {{ request('status') === 'registered' ? 'text-white/80' : 'text-outline' }}">Terdaftar Aktif</div>
            <div class="font-headline text-2xl font-black mt-1">{{ $counts['registered'] }}</div>
        </a>

        <!-- Selesai -->
        <a href="{{ route('tentor.trainings.participants', ['training' => $training->id, 'status' => 'completed', 'search' => request('search')]) }}" 
           class="p-4 rounded-2xl border transition-all {{ request('status') === 'completed' ? 'bg-tertiary-fixed text-primary border-tertiary shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant border-outline-variant/60 hover:bg-surface-container-low' }}">
            <div class="text-[11px] font-bold uppercase tracking-wider text-outline">Selesai</div>
            <div class="font-headline text-2xl font-black mt-1 text-primary">{{ $counts['completed'] }}</div>
        </a>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('tentor.trainings.participants', $training->id) }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto flex-1">
            <div class="relative w-full sm:max-w-md">
                <span class="material-symbols-outlined text-[20px] text-outline absolute left-3.5 top-2.5">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, institusi..." 
                    class="w-full h-10 pl-10 pr-4 text-xs sm:text-sm text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none transition-all placeholder:text-outline" />
                @if(request('search'))
                    <a href="{{ route('tentor.trainings.participants', ['training' => $training->id, 'status' => request('status')]) }}" 
                       class="absolute right-3 top-2.5 text-outline hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                @endif
            </div>

            <div class="w-full sm:w-auto">
                <select name="status" onchange="this.form.submit()" class="w-full sm:w-auto h-10 px-3.5 py-2 text-xs sm:text-sm text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white outline-none cursor-pointer">
                    <option value="">Semua Status</option>
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
                    <a href="{{ route('tentor.trainings.participants', $training->id) }}" 
                       class="h-10 px-3.5 border border-outline-variant/60 hover:bg-surface-container text-xs font-semibold text-on-surface-variant rounded-xl transition-colors flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <span class="text-xs text-outline font-medium shrink-0 self-end md:self-auto">
            Total: <strong class="text-primary font-bold">{{ $participants->total() }}</strong> Peserta
        </span>
    </div>

    <!-- Participants Table -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                <thead class="bg-surface-container-low text-outline font-bold uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                    <tr>
                        <th class="py-4 px-5 sm:px-6">Nama Peserta</th>
                        <th class="py-4 px-4">Tipe &amp; Institusi</th>
                        <th class="py-4 px-4">Kontak (HP/WA)</th>
                        <th class="py-4 px-4">Status Pendaftaran</th>
                        <th class="py-4 px-5 sm:px-6">Tanggal Terdaftar</th>
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
                        <td class="py-4 px-5 sm:px-6 text-xs text-outline whitespace-nowrap">
                            {{ $enrollment->enrolled_at ? $enrollment->enrolled_at->translatedFormat('d M Y, H:i') : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-outline">
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
@endsection
