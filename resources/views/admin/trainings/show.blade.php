@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('admin') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.trainings.index') }}" class="hover:text-secondary">Manajemen Pelatihan</a>
        <span>/</span>
        <span class="text-primary font-semibold truncate max-w-sm">{{ $training->title }}</span>
    </nav>

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1.5">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $training->mode->badgeClass() }}">
                    <span class="material-symbols-outlined text-[13px] align-middle mr-0.5">{{ $training->mode->icon() }}</span>
                    {{ $training->mode->label() }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $training->status->badgeClass() }}">
                    {{ $training->status->label() }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $training->audience->badgeClass() }}">
                    {{ $training->audience->label() }}
                </span>
            </div>
            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">
                {{ $training->title }}
            </h1>
            <p class="text-xs text-on-surface-variant mt-1 flex flex-wrap items-center gap-2">
                <span>Kategori: <strong class="text-primary font-semibold">{{ $training->category?->name ?? '—' }}</strong></span>
                <span>•</span>
                <span>Dibuat oleh: <strong class="text-primary font-semibold">{{ $training->creator?->name ?? 'Admin' }}</strong></span>
                <span>•</span>
                <span>Diperbarui: {{ $training->updated_at->format('d M Y, H:i') }} WIB</span>
            </p>
        </div>
        
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.trainings.edit', $training->id) }}" class="px-4 py-2 bg-surface-container hover:bg-surface-container-high text-primary font-headline text-xs font-bold rounded-xl transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Ubah Data</span>
            </a>
            <a href="{{ url('/agenda/' . $training->slug) }}" target="_blank" class="px-4 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">visibility</span>
                <span>Halaman Publik</span>
            </a>
            <a href="{{ route('admin.trainings.index') }}" class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- 4 Quick Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Jadwal Pelaksanaan -->
        <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs">
            <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Jadwal Pelaksanaan</span>
            <span class="font-headline text-sm font-bold text-primary block mt-1">
                {{ $training->start_date->format('d M') }} - {{ $training->end_date->format('d M Y') }}
            </span>
            <span class="text-[11px] text-on-surface-variant">Durasi {{ $training->start_date->diffInDays($training->end_date) + 1 }} Hari</span>
        </div>

        <!-- Biaya & Skema -->
        <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs">
            <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Skema &amp; Biaya</span>
            <span class="font-headline text-sm font-bold block mt-1 {{ $training->is_free ? 'text-tertiary' : 'text-primary' }}">
                {{ $training->is_free ? '100% Gratis' : 'Rp ' . number_format($training->price, 0, ',', '.') }}
            </span>
            <span class="text-[11px] text-on-surface-variant">{{ $training->is_free ? 'Bebas Biaya Pendaftaran' : 'Biaya Investasi Resmi' }}</span>
        </div>

        <!-- Batas Kuota -->
        <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs">
            <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Batas Kuota Peserta</span>
            <span class="font-headline text-sm font-bold text-primary block mt-1">
                {{ $training->quota ? $training->quota . ' Peserta' : 'Tanpa Batas Kuota' }}
            </span>
            <span class="text-[11px] text-on-surface-variant">{{ $training->quota ? 'Kapasitas Ditentukan' : 'Terbuka Fleksibel' }}</span>
        </div>

        <!-- Periode Pendaftaran -->
        <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs">
            <span class="text-[11px] font-bold text-outline uppercase tracking-wider block">Periode Pendaftaran</span>
            <span class="font-headline text-sm font-bold text-primary block mt-1">
                @if($training->registration_start && $training->registration_end)
                    {{ $training->registration_start->format('d M') }} - {{ $training->registration_end->format('d M Y') }}
                @else
                    Terbuka Setiap Saat
                @endif
            </span>
            <span class="text-[11px] font-semibold {{ ($training->registration_end && now()->gt($training->registration_end)) ? 'text-error' : 'text-secondary' }}">
                @if($training->registration_start && now()->lt($training->registration_start))
                    Segera Dibuka
                @elseif($training->registration_end && now()->gt($training->registration_end))
                    Pendaftaran Ditutup
                @else
                    Pendaftaran Terbuka
                @endif
            </span>
        </div>
    </div>

    <!-- Main Grid Content: Left 8 cols, Right 4 cols -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Deskripsi & Jadwal Sesi Pertemuan (8 cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Card 1: Rincian Pokok, Deskripsi & Akses Pelatihan -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs space-y-5">
                <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40">
                    <h2 class="font-headline text-base font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-secondary">description</span>
                        <span>Deskripsi &amp; Sasaran Pelatihan</span>
                    </h2>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $training->audience->badgeClass() }}">
                        Sasaran: {{ $training->audience->label() }}
                    </span>
                </div>

                <!-- Deskripsi Lengkap -->
                <div>
                    <h3 class="text-xs font-bold text-outline uppercase tracking-wider mb-2">Uraian Program</h3>
                    <div class="text-xs sm:text-sm text-on-surface-variant leading-relaxed whitespace-pre-line bg-surface-container-low/50 p-4 rounded-xl border border-outline-variant/40">
                        {{ $training->description }}
                    </div>
                </div>

                <!-- Akses & Lokasi Pelatihan Lengkap -->
                <div class="pt-4 border-t border-outline-variant/40 space-y-3">
                    <h3 class="font-headline text-xs font-bold text-primary uppercase tracking-wider flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-secondary">explore</span>
                        <span>Akses &amp; Lokasi Pertemuan</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <!-- Location Venue -->
                        <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/50 space-y-1">
                            <div class="flex items-center gap-1.5 text-xs font-bold text-primary">
                                <span class="material-symbols-outlined text-[16px] text-secondary">location_on</span>
                                <span>Lokasi Venue Fisik (Tatap Muka)</span>
                            </div>
                            <div class="text-xs text-on-surface-variant font-medium leading-relaxed">
                                @if($training->location)
                                    {{ $training->location }}
                                @else
                                    <span class="text-outline italic">Tidak ada lokasi fisik (Pelatihan Mode Daring).</span>
                                @endif
                            </div>
                        </div>

                        <!-- Meeting URL -->
                        <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/50 space-y-1">
                            <div class="flex items-center gap-1.5 text-xs font-bold text-primary">
                                <span class="material-symbols-outlined text-[16px] text-secondary">videocam</span>
                                <span>Tautan Meeting Daring (Zoom / Meet)</span>
                            </div>
                            @if($training->meeting_url)
                                <div class="flex items-center gap-2 pt-0.5">
                                    <a href="{{ $training->meeting_url }}" target="_blank" class="text-xs text-secondary font-semibold hover:underline truncate block">
                                        {{ $training->meeting_url }}
                                    </a>
                                    <a href="{{ $training->meeting_url }}" target="_blank" class="px-2 py-0.5 rounded-md bg-secondary text-white text-[10px] font-bold shrink-0 hover:bg-secondary-container transition-colors">
                                        Buka
                                    </a>
                                </div>
                            @else
                                <div class="text-xs text-outline italic">
                                    Tidak ada tautan meeting daring (Pelatihan Mode Fisik).
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Fasilitas & Manfaat Peserta Pelatihan -->
                <div class="pt-4 border-t border-outline-variant/40 space-y-3">
                    <h3 class="font-headline text-xs font-bold text-primary uppercase tracking-wider flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-secondary">inventory_2</span>
                        <span>Fasilitas &amp; Manfaat Peserta Pelatihan</span>
                    </h3>

                    @if(!empty($training->facilities) && count($training->facilities) > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                            @foreach($training->facilities as $facility)
                                <div class="flex items-center gap-2.5 p-3 rounded-xl bg-surface-container-low border border-outline-variant/50">
                                    <div class="w-6 h-6 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary shrink-0">
                                        <span class="material-symbols-outlined text-[15px]">check_circle</span>
                                    </div>
                                    <span class="text-xs font-semibold text-primary leading-tight">{{ $facility }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/40 text-xs text-outline italic">
                            Belum ada daftar fasilitas khusus yang dicantumkan untuk pelatihan ini.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card 2: Manajemen Sesi Pelatihan (ADM-06) -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
                <div class="flex items-center justify-between pb-4 border-b border-outline-variant/40 mb-4">
                    <div>
                        <h2 class="font-headline text-base font-bold text-primary flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px] text-secondary">calendar_month</span>
                            <span>Jadwal Sesi Pertemuan (ADM-06)</span>
                        </h2>
                        <p class="text-xs text-on-surface-variant mt-0.5">Kelola agenda jam pertemuan harian untuk kelas ini.</p>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-container text-primary">
                        {{ $training->sessions->count() }} Sesi Terjadwal
                    </span>
                </div>

                <!-- Form Tambah Sesi Baru -->
                <div class="p-4 bg-surface-container-low rounded-xl border border-outline-variant/40 mb-6">
                    <h3 class="font-headline text-xs font-bold text-primary uppercase tracking-wider mb-3 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-secondary">add_circle</span>
                        <span>Jadwalkan Sesi Baru</span>
                    </h3>

                    <form method="POST" action="{{ route('admin.trainings.sessions.store', $training->id) }}" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-primary mb-1">Judul / Topik Sesi <span class="text-error">*</span></label>
                                <input type="text" name="title" placeholder="Contoh: Sesi 1 - Pengantar AI Pedagogis" required
                                    class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-outline-variant/60 focus:ring-2 focus:ring-secondary/40 outline-none" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-primary mb-1">Tipe Sesi <span class="text-error">*</span></label>
                                <select name="session_type" required class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-outline-variant/60 outline-none">
                                    <option value="online">Online (Virtual)</option>
                                    <option value="offline">Offline (Tatap Muka)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-primary mb-1">Tanggal Sesi <span class="text-error">*</span></label>
                                <input type="date" name="session_date" value="{{ $training->start_date->format('Y-m-d') }}" required
                                    class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-outline-variant/60 outline-none" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-primary mb-1">Jam Mulai <span class="text-error">*</span></label>
                                <input type="time" name="start_time" value="09:00" required
                                    class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-outline-variant/60 outline-none" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-primary mb-1">Jam Selesai <span class="text-error">*</span></label>
                                <input type="time" name="end_time" value="12:00" required
                                    class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-outline-variant/60 outline-none" />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-primary mb-1">Tautan Meeting Khusus (Opsional)</label>
                                <input type="url" name="meeting_url" value="{{ $training->meeting_url }}" placeholder="https://zoom.us/..."
                                    class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-outline-variant/60 outline-none" />
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-primary mb-1">Ruangan / Lokasi Khusus (Opsional)</label>
                                <input type="text" name="location" value="{{ $training->location }}" placeholder="Contoh: Lab Komputer A"
                                    class="w-full px-3 py-2 text-xs bg-white rounded-lg border border-outline-variant/60 outline-none" />
                            </div>
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-4 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-lg shadow-xs transition-colors flex items-center gap-1 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">save</span>
                                <span>Simpan Sesi</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Daftar Sesi Terjadwal -->
                <div class="space-y-3">
                    @forelse($training->sessions as $index => $session)
                    <div class="p-4 rounded-xl border border-outline-variant/40 bg-surface-container-low flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-primary text-white font-headline text-xs font-bold flex items-center justify-center shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-primary text-xs sm:text-sm">{{ $session->title }}</span>
                                    <span class="px-2 py-0.2 rounded text-[10px] font-bold bg-surface-container text-secondary">
                                        {{ $session->session_type->label() }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 mt-1 text-[11px] text-outline">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                        {{ $session->session_date->format('d M Y') }}
                                    </span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        {{ substr($session->start_time, 0, 5) }} - {{ substr($session->end_time, 0, 5) }} WIB
                                    </span>
                                </div>
                                @if($session->location || $session->meeting_url)
                                    <div class="text-[11px] text-on-surface-variant mt-1">
                                        {{ $session->location ?? $session->meeting_url }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.trainings.sessions.destroy', ['training' => $training->id, 'session' => $session->id]) }}" class="form-delete" data-title="Sesi Pertemuan: {{ $session->title }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" 
                                    onclick="confirmDelete(event, '{{ addslashes($session->title) }}', 'Apakah Anda yakin ingin menghapus sesi <strong>&quot;{{ addslashes($session->title) }}&quot;</strong>?')"
                                    class="p-1.5 rounded-lg border border-outline-variant/60 text-error hover:bg-error-container/20 transition-colors text-xs cursor-pointer" 
                                    title="Hapus Sesi">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="text-center py-6 text-outline text-xs">
                        Belum ada sesi pertemuan yang dijadwalkan.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column: Poster, Meta & Penugasan Tentor Pengampu (4 cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Card: Poster / Banner Pelatihan -->
            @php
                $detailThumbUrl = null;
                if ($training->thumbnail) {
                    $detailThumbUrl = \Illuminate\Support\Str::startsWith($training->thumbnail, ['http://', 'https://'])
                        ? $training->thumbnail
                        : asset('storage/' . $training->thumbnail);
                }
            @endphp
            <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-outline-variant/40">
                    <span class="text-xs font-bold text-primary uppercase tracking-wider flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-secondary">image</span>
                        <span>Poster Sampul Pelatihan</span>
                    </span>
                    @if($detailThumbUrl)
                        <a href="{{ $detailThumbUrl }}" target="_blank" class="text-[11px] text-secondary font-bold hover:underline">
                            Lihat Asli
                        </a>
                    @endif
                </div>

                @if($detailThumbUrl)
                    <div class="rounded-xl overflow-hidden border border-outline-variant/50 shadow-2xs aspect-video bg-surface-container-low group relative">
                        <img src="{{ $detailThumbUrl }}" alt="{{ $training->title }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" />
                    </div>
                @else
                    <div class="rounded-xl border-2 border-dashed border-outline-variant/70 p-6 text-center text-outline bg-surface-container-low/40">
                        <span class="material-symbols-outlined text-3xl mb-1 text-outline/60">hide_image</span>
                        <p class="text-xs font-semibold">Belum ada gambar poster</p>
                        <a href="{{ route('admin.trainings.edit', $training->id) }}" class="inline-block mt-2 text-[11px] text-secondary font-bold hover:underline">
                            + Unggah Poster Sekarang
                        </a>
                    </div>
                @endif
            </div>

            <!-- Card: Rincian Meta Program -->
            <div class="bg-surface-container-lowest p-5 rounded-2xl border border-outline-variant/60 shadow-xs space-y-3">
                <span class="text-xs font-bold text-primary uppercase tracking-wider block pb-2 border-b border-outline-variant/40">
                    Ringkasan Teknis Program
                </span>
                <dl class="divide-y divide-outline-variant/30 text-xs">
                    <div class="py-2 flex items-center justify-between">
                        <dt class="text-outline">Kode ID</dt>
                        <dd class="font-mono font-bold text-primary">#TRN-{{ str_pad($training->id, 4, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div class="py-2 flex items-center justify-between">
                        <dt class="text-outline">Slug Tautan</dt>
                        <dd class="font-mono text-[11px] text-on-surface-variant truncate max-w-[180px]">{{ $training->slug }}</dd>
                    </div>
                    <div class="py-2 flex items-center justify-between">
                        <dt class="text-outline">Kategori</dt>
                        <dd class="font-semibold text-primary">{{ $training->category?->name ?? '—' }}</dd>
                    </div>
                    <div class="py-2 flex items-center justify-between">
                        <dt class="text-outline">Skema Biaya</dt>
                        <dd class="font-bold {{ $training->is_free ? 'text-tertiary' : 'text-primary' }}">
                            {{ $training->is_free ? 'Gratis' : 'Rp ' . number_format($training->price, 0, ',', '.') }}
                        </dd>
                    </div>
                    <div class="py-2 flex items-center justify-between">
                        <dt class="text-outline">Batas Kuota</dt>
                        <dd class="font-semibold text-primary">{{ $training->quota ? $training->quota . ' Orang' : 'Tanpa Batas' }}</dd>
                    </div>
                    <div class="py-2 flex items-center justify-between">
                        <dt class="text-outline">Dibuat Oleh</dt>
                        <dd class="font-semibold text-primary">{{ $training->creator?->name ?? 'Admin' }}</dd>
                    </div>
                    <div class="py-2 flex items-center justify-between">
                        <dt class="text-outline">Waktu Terbit</dt>
                        <dd class="text-on-surface-variant">{{ $training->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Card: Penugasan Tentor Pengampu (ADM-07) -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
                <div class="flex items-center justify-between pb-3 border-b border-outline-variant/40 mb-4">
                    <h2 class="font-headline text-sm font-bold text-primary flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[18px] text-secondary">co_present</span>
                        <span>Instruktur Pengampu</span>
                    </h2>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-secondary-fixed text-on-secondary-fixed">
                        {{ $training->instructors->count() }} Tentor
                    </span>
                </div>

                <p class="text-xs text-on-surface-variant mb-4">
                    Instruktur yang ditugaskan berhak mengisi silabus, modul ajar, dan memoderasi kelas.
                </p>

                <!-- List of Assigned Tentors with Avatar Photos -->
                <div class="space-y-3 mb-6">
                    @forelse($training->instructors as $instructor)
                        @php
                            $instructorAvatarUrl = null;
                            if ($instructor->avatar) {
                                $instructorAvatarUrl = \Illuminate\Support\Str::startsWith($instructor->avatar, ['http://', 'https://'])
                                    ? $instructor->avatar
                                    : asset('storage/' . $instructor->avatar);
                            }
                        @endphp
                        <div class="p-3 bg-surface-container-low rounded-xl border border-outline-variant/40 flex items-center gap-3">
                            @if($instructorAvatarUrl)
                                <img src="{{ $instructorAvatarUrl }}" alt="{{ $instructor->name }}" class="w-10 h-10 rounded-full object-cover shrink-0 border border-outline-variant/60 shadow-2xs" />
                            @else
                                <div class="w-10 h-10 rounded-full bg-secondary text-white font-headline text-xs font-bold flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($instructor->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="font-bold text-primary text-xs truncate">{{ $instructor->name }}</div>
                                <div class="text-[11px] text-secondary font-medium truncate">{{ $instructor->expertise ?? 'Instruktur' }}</div>
                                <div class="text-[10px] text-outline truncate">{{ $instructor->email }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 bg-surface-container-low rounded-xl text-center text-outline text-xs">
                            Belum ada tentor yang ditugaskan ke pelatihan ini.
                        </div>
                    @endforelse
                </div>

                <!-- Update Assignment Form -->
                <form method="POST" action="{{ route('admin.trainings.instructors.sync', $training->id) }}" class="space-y-3 pt-3 border-t border-outline-variant/40">
                    @csrf
                    <label class="block font-headline text-xs font-bold text-primary">Perbarui Penugasan Tentor:</label>
                    <div class="max-h-48 overflow-y-auto space-y-2 pr-1">
                        @php $assignedIds = $training->instructors->pluck('id')->toArray(); @endphp
                        @foreach($tentors as $t)
                        <label class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-surface-container-low cursor-pointer text-xs">
                            <input type="checkbox" name="instructors[]" value="{{ $t->id }}" 
                                {{ in_array($t->id, $assignedIds) ? 'checked' : '' }}
                                class="rounded text-secondary focus:ring-secondary" />
                            <span class="font-medium text-primary truncate">{{ $t->name }}</span>
                        </label>
                        @endforeach
                    </div>
                    <button type="submit" class="w-full py-2 bg-primary hover:bg-primary/90 text-white font-headline text-xs font-bold rounded-xl transition-colors cursor-pointer shadow-2xs">
                        Simpan Penugasan
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection
