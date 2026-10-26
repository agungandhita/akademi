@extends('admin.layouts.main')

@section('container')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Top Breadcrumbs & Back Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <nav class="flex items-center gap-1.5 text-xs text-outline">
            <a href="{{ route('admin') }}" class="hover:text-secondary transition-colors">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.users.index') }}" class="hover:text-secondary transition-colors">Manajemen Pengguna</a>
            <span>/</span>
            <span class="text-primary font-semibold">Detail: {{ $user->name }}</span>
        </nav>

        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl border border-outline-variant/60 bg-surface-container-lowest hover:bg-surface-container text-xs font-semibold text-primary transition-colors shadow-2xs self-start sm:self-auto">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- User Hero Card -->
    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/60 shadow-xs p-6 sm:p-8 relative overflow-hidden">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
            
            <!-- Avatar & Profile Info -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                <!-- Large Avatar with Photo or Initials -->
                <div class="relative">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl object-cover shadow-md shrink-0 border border-outline-variant/60" />
                    @else
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-gradient-to-br from-primary via-primary-container to-secondary text-white font-headline font-black text-2xl sm:text-3xl flex items-center justify-center shadow-md shrink-0">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    <!-- Status dot badge -->
                    <span class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full border-2 border-white flex items-center justify-center shadow-xs {{ $user->is_active ? 'bg-secondary' : 'bg-error' }}"
                          title="{{ $user->is_active ? 'Akun Aktif' : 'Akun Nonaktif' }}">
                        <span class="material-symbols-outlined text-[14px] text-white">
                            {{ $user->is_active ? 'check' : 'close' }}
                        </span>
                    </span>
                </div>

                <!-- Text Details -->
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">
                            {{ $user->name }}
                        </h1>

                        <!-- Role Badge -->
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $user->role?->badgeClass() ?? 'bg-surface-container text-on-surface' }}">
                            <span class="material-symbols-outlined text-[15px]">{{ $user->role?->icon() ?? 'person' }}</span>
                            <span>{{ $user->role?->label() ?? ucfirst($user->role) }}</span>
                        </span>

                        <!-- Participant Type Badge (if any) -->
                        @if($user->participant_type)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold {{ $user->participant_type->badgeClass() }}">
                                <span class="material-symbols-outlined text-[15px]">{{ $user->participant_type->icon() }}</span>
                                <span>{{ $user->participant_type->label() }}</span>
                            </span>
                        @endif

                        <!-- Status Badge -->
                        @if($user->is_active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-secondary-fixed text-on-secondary-fixed">
                                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                                <span>Aktif</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-error-container text-on-error-container">
                                <span class="w-2 h-2 rounded-full bg-error"></span>
                                <span>Dinonaktifkan</span>
                            </span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs text-on-surface-variant font-medium">
                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-outline">mail</span>
                            <span class="text-primary font-semibold">{{ $user->email }}</span>
                        </span>

                        @if($user->institution)
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-outline">apartment</span>
                                <span>{{ $user->institution }}</span>
                            </span>
                        @endif

                        <span class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-outline">tag</span>
                            <span class="text-outline">ID: #{{ $user->id }}</span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Group -->
            <div class="flex flex-wrap items-center gap-2.5 shrink-0 pt-4 lg:pt-0 border-t lg:border-t-0 border-outline-variant/40">
                <!-- Edit Button -->
                <a href="{{ route('admin.users.edit', $user->id) }}"
                   class="px-4 py-2.5 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    <span>Ubah Profil</span>
                </a>

                <!-- Toggle Active Form -->
                <form method="POST" action="{{ route('admin.users.toggle-active', $user->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-4 py-2.5 rounded-xl border text-xs font-headline font-bold transition-all flex items-center gap-1.5 cursor-pointer shadow-2xs {{ $user->is_active ? 'border-outline-variant bg-surface-container-lowest text-on-surface-variant hover:bg-error-container/20 hover:text-error hover:border-error/40' : 'border-secondary/40 bg-secondary-fixed text-on-secondary-fixed hover:bg-secondary hover:text-white' }}">
                        <span class="material-symbols-outlined text-[18px]">
                            {{ $user->is_active ? 'block' : 'check_circle' }}
                        </span>
                        <span>{{ $user->is_active ? 'Nonaktifkan Akun' : 'Aktifkan Akun' }}</span>
                    </button>
                </form>

                <!-- Delete Form (Only if not self) -->
                @if(auth()->id() !== $user->id)
                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="form-delete" data-title="{{ $user->name }}">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                            onclick="confirmDelete(event, '{{ addslashes($user->name) }}', 'Apakah Anda yakin ingin menghapus akun <strong>&quot;{{ addslashes($user->name) }}&quot;</strong>?<br><span style=\'font-size:12px;color:#6b7280;margin-top:6px;display:block;\'>Akun akan diarsipkan dengan aman melalui soft-delete.</span>')"
                            class="p-2.5 rounded-xl border border-error/30 bg-error-container/20 hover:bg-error hover:text-white text-error transition-all cursor-pointer shadow-2xs"
                            title="Hapus Akun Pengguna">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </form>
                @endif
            </div>

        </div>

        <!-- Subtle Gradient Accent -->
        <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-secondary/5 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Detailed Information Cards (7 Cols) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card: Informasi Kontak & Akun -->
            <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/60 shadow-xs p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-[18px]">contact_page</span>
                        </span>
                        <h2 class="font-headline text-base font-bold text-primary">Informasi Kontak &amp; Akun</h2>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <!-- Email -->
                    <div class="p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Alamat Email</span>
                        <div class="font-bold text-primary text-sm truncate">{{ $user->email }}</div>
                        <div class="flex items-center gap-1 text-[11px] text-tertiary font-semibold pt-0.5">
                            <span class="material-symbols-outlined text-[14px]">verified</span>
                            <span>{{ $user->email_verified_at ? 'Email Terverifikasi (' . $user->email_verified_at->format('d/m/Y') . ')' : 'Verifikasi Otomatis Sistem' }}</span>
                        </div>
                    </div>

                    <!-- Phone / WhatsApp -->
                    <div class="p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Nomor HP / WhatsApp</span>
                        <div class="font-bold text-primary text-sm">
                            {{ $user->phone ?: 'Belum ditambahkan' }}
                        </div>
                        @if($user->phone)
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $user->phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                }
                            @endphp
                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank"
                               class="inline-flex items-center gap-1 text-[11px] text-secondary hover:underline font-semibold pt-0.5">
                                <span class="material-symbols-outlined text-[14px]">chat</span>
                                <span>Hubungi via WhatsApp</span>
                            </a>
                        @else
                            <span class="text-[11px] text-outline block pt-0.5">Kontak langsung belum tersedia</span>
                        @endif
                    </div>

                    <!-- Tanggal Terdaftar -->
                    <div class="p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Terdaftar Sejak</span>
                        <div class="font-bold text-primary text-sm">
                            {{ $user->created_at->format('d F Y, H:i') }} WIB
                        </div>
                        <span class="text-[11px] text-outline block">
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Terakhir Diperbarui -->
                    <div class="p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40 space-y-1">
                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Pembaruan Terakhir</span>
                        <div class="font-bold text-primary text-sm">
                            {{ $user->updated_at->format('d F Y, H:i') }} WIB
                        </div>
                        <span class="text-[11px] text-outline block">
                            {{ $user->updated_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card: Profil Keahlian & Lembaga -->
            <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/60 shadow-xs p-6 space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                    <div class="flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-surface-container text-primary flex items-center justify-center font-bold">
                            <span class="material-symbols-outlined text-[18px]">domain</span>
                        </span>
                        <h2 class="font-headline text-base font-bold text-primary">Profil Afiliasi &amp; Keahlian</h2>
                    </div>
                </div>

                <div class="space-y-4 text-xs">
                    <!-- Institusi -->
                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40">
                        <span class="material-symbols-outlined text-outline text-[20px] mt-0.5">corporate_fare</span>
                        <div class="space-y-0.5">
                            <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Institusi / Sekolah / Lembaga</span>
                            <span class="font-bold text-primary text-sm">{{ $user->institution ?: '— (Tidak ada institusi spesifik)' }}</span>
                        </div>
                    </div>

                    <!-- Keahlian -->
                    @if($user->expertise)
                    <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40">
                        <span class="material-symbols-outlined text-secondary text-[20px] mt-0.5">psychology</span>
                        <div class="space-y-0.5">
                            <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Bidang Keahlian / Spesialisasi</span>
                            <span class="font-bold text-primary text-sm">{{ $user->expertise }}</span>
                        </div>
                    </div>
                    @endif

                    <!-- Bio -->
                    <div class="p-4 rounded-2xl bg-surface-container-low border border-outline-variant/40 space-y-2">
                        <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Biografi / Profil Singkat</span>
                        @if($user->bio)
                            <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed whitespace-pre-line">
                                {{ $user->bio }}
                            </p>
                        @else
                            <p class="text-xs text-outline italic">
                                Belum ada biografi atau catatan ringkas yang ditambahkan untuk pengguna ini.
                            </p>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Pelatihan & Keterlibatan (5 Cols) -->
        <div class="lg:col-span-5 space-y-6">

            <!-- Dynamic Activity Card Based on Role -->
            @if($user->isTentor())
                <!-- Tentor: Assigned Trainings -->
                <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/60 shadow-xs p-6 space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-secondary text-white flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-[18px]">co_present</span>
                            </span>
                            <div>
                                <h2 class="font-headline text-base font-bold text-primary">Pelatihan yang Diampu</h2>
                                <span class="text-[11px] text-outline font-medium">Ditugaskan sebagai Instruktur / Tentor</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-secondary-fixed text-on-secondary-fixed">
                            {{ $user->assignedTrainings->count() }} Program
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($user->assignedTrainings as $training)
                            <div class="p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40 hover:border-secondary/60 transition-all flex items-start justify-between gap-3">
                                <div class="space-y-1 min-w-0">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold {{ $training->mode->badgeClass() }}">
                                            <span class="material-symbols-outlined text-[12px]">{{ $training->mode->icon() }}</span>
                                            <span>{{ $training->mode->label() }}</span>
                                        </span>
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $training->status->badgeClass() }}">
                                            {{ $training->status->label() }}
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.trainings.show', $training->id) }}" class="font-bold text-xs sm:text-sm text-primary hover:text-secondary block truncate transition-colors">
                                        {{ $training->title }}
                                    </a>
                                    <div class="text-[11px] text-outline flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[13px]">calendar_today</span>
                                        <span>{{ $training->start_date->format('d M Y') }} s.d {{ $training->end_date->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('admin.trainings.show', $training->id) }}" class="p-1.5 rounded-lg bg-surface-container hover:bg-secondary hover:text-white transition-colors text-primary shrink-0" title="Buka Detail Pelatihan">
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-8 text-outline space-y-1">
                                <span class="material-symbols-outlined text-3xl">school</span>
                                <p class="text-xs font-bold text-primary">Belum Ada Pelatihan yang Ditugaskan</p>
                                <p class="text-[11px]">Anda dapat menugaskan tentor ini saat membuat atau mengedit pelatihan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            @elseif($user->isAdmin())
                <!-- Admin: Created Trainings -->
                <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/60 shadow-xs p-6 space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-primary text-white flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-[18px]">verified_user</span>
                            </span>
                            <div>
                                <h2 class="font-headline text-base font-bold text-primary">Pelatihan Diterbitkan</h2>
                                <span class="text-[11px] text-outline font-medium">Program yang dibuat oleh Administrator ini</span>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-surface-container text-primary">
                            {{ $user->createdTrainings->count() }} Program
                        </span>
                    </div>

                    <div class="space-y-3">
                        @forelse($user->createdTrainings->take(5) as $training)
                            <div class="p-3.5 rounded-2xl bg-surface-container-low border border-outline-variant/40 hover:border-secondary/60 transition-all flex items-start justify-between gap-3">
                                <div class="space-y-1 min-w-0">
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold {{ $training->mode->badgeClass() }}">
                                            <span>{{ $training->mode->label() }}</span>
                                        </span>
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold {{ $training->status->badgeClass() }}">
                                            {{ $training->status->label() }}
                                        </span>
                                    </div>
                                    <a href="{{ route('admin.trainings.show', $training->id) }}" class="font-bold text-xs sm:text-sm text-primary hover:text-secondary block truncate transition-colors">
                                        {{ $training->title }}
                                    </a>
                                </div>
                                <a href="{{ route('admin.trainings.show', $training->id) }}" class="p-1.5 rounded-lg bg-surface-container hover:bg-secondary hover:text-white transition-colors text-primary shrink-0">
                                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                                </a>
                            </div>
                        @empty
                            <div class="text-center py-8 text-outline space-y-1">
                                <span class="material-symbols-outlined text-3xl">post_add</span>
                                <p class="text-xs font-bold text-primary">Belum Ada Pelatihan yang Dibuat</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            @else
                <!-- Peserta: Summary Card -->
                <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/60 shadow-xs p-6 space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                        <div class="flex items-center gap-2.5">
                            <span class="w-8 h-8 rounded-xl bg-tertiary-fixed text-primary flex items-center justify-center font-bold">
                                <span class="material-symbols-outlined text-[18px]">school</span>
                            </span>
                            <div>
                                <h2 class="font-headline text-base font-bold text-primary">Status Kepesertaan</h2>
                                <span class="text-[11px] text-outline font-medium">Hak Akses Pembelajaran Peserta</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-secondary-fixed text-on-secondary-fixed space-y-2">
                        <div class="flex items-center gap-2 font-bold text-xs">
                            <span class="material-symbols-outlined text-[18px] text-secondary">info</span>
                            <span>Akses Peserta Pelatihan</span>
                        </div>
                        <p class="text-xs leading-relaxed">
                            Pengguna ini terdaftar sebagai peserta aktif di portal Akademi Pelatihan. Riwayat pendaftaran program pelatihan dan unduhan sertifikat modul akan otomatis tercatat ketika peserta mendaftar agenda pelatihan.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Quick Audit Box -->
            <div class="bg-surface-container-low rounded-3xl border border-outline-variant/60 p-5 space-y-3">
                <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Ringkasan Hak Akses &amp; Otoritas</span>
                <ul class="space-y-2 text-xs text-on-surface-variant">
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] {{ $user->is_active ? 'text-secondary' : 'text-error' }}">
                            {{ $user->is_active ? 'check_circle' : 'cancel' }}
                        </span>
                        <span>Otorisasi Login: <strong>{{ $user->is_active ? 'Diizinkan (Aktif)' : 'Diblokir (Nonaktif)' }}</strong></span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-secondary">verified_user</span>
                        <span>Dashboard Target: <strong>/{{ $user->role->value }}</strong></span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-outline">history</span>
                        <span>Dibuat: <strong>{{ $user->created_at->format('d M Y') }}</strong></span>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
