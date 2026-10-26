@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div class="space-y-3">
        <nav class="flex items-center gap-1.5 text-xs text-outline">
            <a href="{{ route('admin') }}" class="hover:text-secondary transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-primary font-semibold">Manajemen Pengguna</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Manajemen Pengguna</h1>
                <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                    Kelola akun administrator, instruktur/tentor, dan peserta pelatihan se-Indonesia.
                </p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.tentor.create') }}" class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 shrink-0">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    <span>Buat Akun Tentor</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Role Filter Pills (Instant Stats Navigation) -->
    @if(isset($roleCounts))
    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
        <a href="{{ route('admin.users.index', array_filter(['search' => request('search')])) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all whitespace-nowrap {{ !request('role') ? 'bg-primary text-white shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-low border border-outline-variant/60' }}">
            <span class="material-symbols-outlined text-[16px]">group</span>
            <span>Semua Pengguna</span>
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ !request('role') ? 'bg-white/20 text-white' : 'bg-surface-container-high text-primary' }}">
                {{ $roleCounts['total'] }}
            </span>
        </a>

        <a href="{{ route('admin.users.index', array_filter(['role' => 'admin', 'search' => request('search')])) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all whitespace-nowrap {{ request('role') === 'admin' ? 'bg-primary text-white shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-low border border-outline-variant/60' }}">
            <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span>
            <span>Administrator</span>
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ request('role') === 'admin' ? 'bg-white/20 text-white' : 'bg-surface-container-high text-primary' }}">
                {{ $roleCounts['admin'] }}
            </span>
        </a>

        <a href="{{ route('admin.users.index', array_filter(['role' => 'tentor', 'search' => request('search')])) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all whitespace-nowrap {{ request('role') === 'tentor' ? 'bg-secondary text-white shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-low border border-outline-variant/60' }}">
            <span class="material-symbols-outlined text-[16px]">co_present</span>
            <span>Tentor / Instruktur</span>
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ request('role') === 'tentor' ? 'bg-white/20 text-white' : 'bg-surface-container-high text-primary' }}">
                {{ $roleCounts['tentor'] }}
            </span>
        </a>

        <a href="{{ route('admin.users.index', array_filter(['role' => 'peserta', 'search' => request('search')])) }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all whitespace-nowrap {{ request('role') === 'peserta' ? 'bg-secondary text-white shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-low border border-outline-variant/60' }}">
            <span class="material-symbols-outlined text-[16px]">school</span>
            <span>Peserta Pelatihan</span>
            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md {{ request('role') === 'peserta' ? 'bg-white/20 text-white' : 'bg-surface-container-high text-primary' }}">
                {{ $roleCounts['peserta'] }}
            </span>
        </a>
    </div>
    @endif

    <!-- Search & Filter Controls Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto flex-1">
            <!-- Search Input with Search Icon -->
            <div class="relative w-full sm:max-w-md">
                <span class="material-symbols-outlined text-[20px] text-outline absolute left-3.5 top-2.5">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, institusi..." 
                    class="w-full h-10 pl-10 pr-4 text-xs sm:text-sm text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none transition-all placeholder:text-outline" />
                @if(request('search'))
                    <a href="{{ route('admin.users.index', array_filter(['role' => request('role')])) }}" 
                       class="absolute right-3 top-2.5 text-outline hover:text-primary transition-colors" title="Hapus kata kunci pencarian">
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </a>
                @endif
            </div>

            <!-- Role Dropdown Selector -->
            <div class="w-full sm:w-auto">
                <select name="role" onchange="this.form.submit()" class="w-full sm:w-auto h-10 px-3.5 py-2 text-xs sm:text-sm text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white outline-none cursor-pointer">
                    <option value="">Semua Peran (Role)</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="tentor" {{ request('role') === 'tentor' ? 'selected' : '' }}>Tentor / Instruktur</option>
                    <option value="peserta" {{ request('role') === 'peserta' ? 'selected' : '' }}>Peserta Pelatihan</option>
                </select>
            </div>

            <!-- Filter & Reset Buttons -->
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <button type="submit" class="h-10 px-4 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl transition-all shadow-2xs flex items-center justify-center gap-1.5 flex-1 sm:flex-initial">
                    <span class="material-symbols-outlined text-[16px]">tune</span>
                    <span>Filter</span>
                </button>

                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('admin.users.index') }}" 
                       class="h-10 px-3.5 border border-outline-variant/60 hover:bg-surface-container text-xs font-semibold text-on-surface-variant rounded-xl transition-colors flex items-center gap-1"
                       title="Reset seluruh filter">
                        <span class="material-symbols-outlined text-[16px]">restart_alt</span>
                        <span>Reset</span>
                    </a>
                @endif
            </div>
        </form>

        <span class="text-xs text-outline font-medium shrink-0 self-end md:self-auto">
            Total: <strong class="text-primary font-bold">{{ $users->total() }}</strong> Pengguna Terdaftar
        </span>
    </div>

    <!-- Users Table Container -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                <thead class="bg-surface-container-low text-outline font-bold uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                    <tr>
                        <th class="py-4 px-5 sm:px-6">Pengguna</th>
                        <th class="py-4 px-4">Peran (Role)</th>
                        <th class="py-4 px-4">Institusi / Tipe</th>
                        <th class="py-4 px-4">Status Akun</th>
                        <th class="py-4 px-4">Tanggal Daftar</th>
                        <th class="py-4 px-5 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse ($users as $user)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <!-- User Name & Avatar -->
                        <td class="py-4 px-5 sm:px-6">
                            <div class="flex items-center gap-3.5">
                                <!-- Avatar Image or Initials -->
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-2xl object-cover shadow-2xs shrink-0 border border-outline-variant/60" />
                                @else
                                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-primary to-primary-container text-white font-headline text-xs font-bold flex items-center justify-center shadow-2xs shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div class="min-w-0 space-y-0.5">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="font-bold text-primary hover:text-secondary transition-colors truncate block max-w-xs text-sm"
                                       title="Lihat profil detail {{ $user->name }}">
                                        {{ $user->name }}
                                    </a>
                                    <div class="text-[11px] text-on-surface-variant/80 flex items-center gap-1 truncate">
                                        <span class="material-symbols-outlined text-[13px] text-outline">mail</span>
                                        <span class="truncate">{{ $user->email }}</span>
                                    </div>
                                    @if($user->phone)
                                        <div class="text-[11px] text-outline flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[13px] text-outline">phone</span>
                                            <span>{{ $user->phone }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Role Badge -->
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold shadow-2xs {{ $user->role?->badgeClass() ?? 'bg-surface-container text-on-surface' }}">
                                <span class="material-symbols-outlined text-[15px]">{{ $user->role?->icon() ?? 'person' }}</span>
                                <span>{{ $user->role?->label() ?? ucfirst($user->role) }}</span>
                            </span>
                        </td>

                        <!-- Institution / Participant Type -->
                        <td class="py-4 px-4">
                            <div class="text-xs text-primary font-semibold truncate max-w-xs">
                                {{ $user->institution ?: '—' }}
                            </div>
                            @if($user->participant_type)
                                <div class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 rounded text-[10px] font-bold {{ $user->participant_type->badgeClass() }}">
                                    <span class="material-symbols-outlined text-[12px]">{{ $user->participant_type->icon() }}</span>
                                    <span>{{ $user->participant_type->label() }}</span>
                                </div>
                            @elseif($user->expertise)
                                <div class="text-[11px] text-outline truncate max-w-xs mt-0.5">
                                    {{ $user->expertise }}
                                </div>
                            @endif
                        </td>

                        <!-- Account Status Badge -->
                        <td class="py-4 px-4">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-secondary-fixed text-on-secondary-fixed shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-pulse"></span>
                                    <span>Aktif</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-error-container text-on-error-container shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error"></span>
                                    <span>Nonaktif</span>
                                </span>
                            @endif
                        </td>

                        <!-- Registration Date -->
                        <td class="py-4 px-4 text-xs">
                            <div class="text-primary font-semibold">
                                {{ $user->created_at->format('d M Y') }}
                            </div>
                            <div class="text-[11px] text-outline mt-0.5">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </td>

                        <!-- Uniform Clean Action Buttons -->
                        <td class="py-4 px-5 sm:px-6 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <!-- 1. Show Detail Button -->
                                <a href="{{ route('admin.users.show', $user->id) }}" 
                                   class="w-8 h-8 rounded-xl bg-surface-container-low hover:bg-secondary hover:text-white text-primary flex items-center justify-center transition-all shadow-2xs hover:scale-105" 
                                   title="Lihat Detail Profil">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>

                                <!-- 2. Edit User Button -->
                                <a href="{{ route('admin.users.edit', $user->id) }}" 
                                   class="w-8 h-8 rounded-xl bg-surface-container-low hover:bg-primary hover:text-white text-primary flex items-center justify-center transition-all shadow-2xs hover:scale-105" 
                                   title="Ubah Profil Pengguna">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>

                                <!-- 3. Toggle Active Form Button -->
                                <form method="POST" action="{{ route('admin.users.toggle-active', $user->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-8 h-8 rounded-xl bg-surface-container-low transition-all shadow-2xs flex items-center justify-center cursor-pointer hover:scale-105 {{ $user->is_active ? 'hover:bg-error-container hover:text-error text-outline' : 'hover:bg-secondary hover:text-white text-secondary' }}" 
                                            title="{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}">
                                        <span class="material-symbols-outlined text-[18px]">
                                            {{ $user->is_active ? 'block' : 'check_circle' }}
                                        </span>
                                    </button>
                                </form>

                                <!-- 4. Soft Delete Form Button (Only if not self) -->
                                @if(auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="form-delete" data-title="{{ $user->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(event, '{{ addslashes($user->name) }}', 'Apakah Anda yakin ingin menghapus akun <strong>&quot;{{ addslashes($user->name) }}&quot;</strong>?<br><span style=\'font-size:12px;color:#6b7280;margin-top:6px;display:block;\'>Data pengguna tetap dapat dipulihkan melalui soft delete.</span>')"
                                            class="w-8 h-8 rounded-xl bg-surface-container-low hover:bg-error hover:text-white text-error/80 flex items-center justify-center transition-all shadow-2xs cursor-pointer hover:scale-105" 
                                            title="Hapus Pengguna (Soft Delete)">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-outline">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <span class="material-symbols-outlined text-4xl text-outline/60">person_off</span>
                                <p class="font-headline font-bold text-sm text-primary">Tidak Ada Pengguna Ditemukan</p>
                                <p class="text-xs text-on-surface-variant max-w-sm">
                                    Tidak ada data yang cocok dengan kriteria pencarian atau filter yang dipilih. Coba reset filter.
                                </p>
                                <a href="{{ route('admin.users.index') }}" class="mt-2 px-3.5 py-1.5 rounded-xl bg-surface-container hover:bg-surface-container-high text-xs font-semibold text-primary transition-colors">
                                    Reset Filter
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-outline-variant/40 bg-surface-container-low flex items-center justify-between">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
