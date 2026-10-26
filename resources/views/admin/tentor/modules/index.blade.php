@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb & Header Section -->
    <div class="space-y-3">
        <nav class="flex items-center gap-1.5 text-xs text-outline">
            <a href="{{ route('tentor') }}" class="hover:text-secondary transition-colors">Dashboard</a>
            <span>/</span>
            <span class="text-primary font-semibold">Kelola Modul Pembelajaran</span>
        </nav>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Kelola Modul Pembelajaran</h1>
                <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                    Buat dan susun modul bacaan, materi PDF, video pembelajaran, dan tautan tugas untuk peserta kelas Anda.
                </p>
            </div>
            @if($selectedTraining && $selectedTraining->status?->value === 'published')
            <div class="flex items-center gap-2">
                <a href="{{ route('tentor.modules.create', ['training_id' => $selectedTraining->id]) }}" 
                   class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>Tambah Modul Baru</span>
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Training Selector Dropdown Card -->
    @if($assignedTrainings->isNotEmpty())
    <div class="bg-surface-container-lowest p-4 sm:p-5 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('tentor.modules.index') }}" class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto flex-1">
            <label for="select-training" class="text-xs font-bold text-primary shrink-0 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px] text-secondary">school</span>
                <span>Pilih Pelatihan:</span>
            </label>
            <select id="select-training" name="training_id" onchange="this.form.submit()" 
                    class="w-full sm:max-w-md h-10 px-3.5 py-2 text-xs sm:text-sm text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none cursor-pointer">
                @foreach($assignedTrainings as $t)
                    <option value="{{ $t->id }}" {{ $selectedTraining && $selectedTraining->id === $t->id ? 'selected' : '' }}>
                        {{ $t->title }} ({{ $t->status?->label() ?? ucfirst($t->status) }})
                    </option>
                @endforeach
            </select>
        </form>

        @if($selectedTraining)
        <div class="flex items-center gap-2 text-xs text-outline shrink-0">
            <span>Status Pelatihan:</span>
            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $selectedTraining->status?->badgeClass() }}">
                {{ $selectedTraining->status?->label() }}
            </span>
        </div>
        @endif
    </div>
    @endif

    <!-- Alert jika pelatihan berstatus bukan Published (PRD TNT-03) -->
    @if($selectedTraining && $selectedTraining->status?->value !== 'published')
    <div class="p-4 rounded-xl bg-error-container/20 border border-error/30 text-error flex items-start gap-3">
        <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5">info</span>
        <div class="text-xs leading-relaxed">
            <strong class="font-bold">Pelatihan Masih Berstatus {{ $selectedTraining->status?->label() }}:</strong>
            Sesuai aturan sistem (TNT-03), modul materi baru hanya dapat ditambahkan, diubah, atau dihapus ketika pelatihan telah resmi diterbitkan (berstatus <em>Published</em>) oleh Administrator.
        </div>
    </div>
    @endif

    <!-- Modules List Table Container -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                <thead class="bg-surface-container-low text-outline font-bold uppercase text-[11px] tracking-wider border-b border-outline-variant/40">
                    <tr>
                        <th class="py-4 px-4 w-12 text-center">Urutan</th>
                        <th class="py-4 px-5 sm:px-6">Judul Modul</th>
                        <th class="py-4 px-4">Tipe Format</th>
                        <th class="py-4 px-4">Status</th>
                        <th class="py-4 px-4">Tautan / Konten</th>
                        <th class="py-4 px-5 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse($modules as $module)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <!-- Sort Order -->
                        <td class="py-4 px-4 text-center">
                            <span class="w-7 h-7 rounded-lg bg-surface-container-high text-primary font-mono font-bold text-xs inline-flex items-center justify-center">
                                #{{ $module->sort_order }}
                            </span>
                        </td>

                        <!-- Module Title & Description -->
                        <td class="py-4 px-5 sm:px-6">
                            <div class="font-bold text-primary text-sm line-clamp-1">
                                {{ $module->title }}
                            </div>
                            @if($module->description)
                                <p class="text-[11px] text-on-surface-variant line-clamp-1 mt-0.5">
                                    {{ $module->description }}
                                </p>
                            @endif
                        </td>

                        <!-- Type Badge -->
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold shadow-2xs {{ $module->type?->badgeClass() }}">
                                <span class="material-symbols-outlined text-[15px]">{{ $module->type?->icon() }}</span>
                                <span>{{ $module->type?->label() }}</span>
                            </span>
                        </td>

                        <!-- Status Badge -->
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $module->status?->badgeClass() }}">
                                <span>{{ $module->status?->label() }}</span>
                            </span>
                        </td>

                        <!-- Content Preview/Link -->
                        <td class="py-4 px-4 text-xs">
                            @if($module->type?->value === 'pdf' && $module->file_path)
                                <a href="{{ asset('storage/' . $module->file_path) }}" target="_blank" class="inline-flex items-center gap-1 text-secondary hover:underline font-semibold">
                                    <span class="material-symbols-outlined text-[16px]">download</span>
                                    <span>Buka PDF</span>
                                </a>
                            @elseif(($module->type?->value === 'video' || $module->type?->value === 'link') && $module->url)
                                <a href="{{ $module->url }}" target="_blank" class="inline-flex items-center gap-1 text-primary hover:text-secondary transition-colors font-semibold truncate max-w-[180px]">
                                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                    <span class="truncate">{{ $module->url }}</span>
                                </a>
                            @elseif($module->type?->value === 'text')
                                <span class="text-outline italic">Bacaan Mandiri</span>
                            @else
                                <span class="text-outline">—</span>
                            @endif
                        </td>

                        <!-- Action Buttons -->
                        <td class="py-4 px-5 sm:px-6 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                @if($selectedTraining && $selectedTraining->status?->value === 'published')
                                <!-- Edit Button -->
                                <a href="{{ route('tentor.modules.edit', $module->id) }}" 
                                   class="w-8 h-8 rounded-xl bg-surface-container-low hover:bg-primary hover:text-white text-primary flex items-center justify-center transition-all shadow-2xs hover:scale-105" 
                                   title="Ubah Modul">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('tentor.modules.destroy', $module->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul \'{{ $module->title }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-8 h-8 rounded-xl bg-surface-container-low hover:bg-error hover:text-white text-outline flex items-center justify-center transition-all shadow-2xs hover:scale-105 cursor-pointer" 
                                            title="Hapus Modul">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                                @else
                                <span class="text-[11px] text-outline italic">Terkunci</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 px-6 text-center text-outline">
                            <div class="w-14 h-14 rounded-2xl bg-surface-container-high text-outline flex items-center justify-center mx-auto mb-3 shadow-xs">
                                <span class="material-symbols-outlined text-[32px] text-on-surface-variant/70">menu_book</span>
                            </div>
                            <h4 class="font-headline text-base font-bold text-primary">Belum Ada Modul Materi</h4>
                            <p class="text-xs text-on-surface-variant mt-1 max-w-sm mx-auto leading-relaxed">
                                @if($selectedTraining)
                                    Belum ada modul materi pada pelatihan ini. Mulai tambahkan materi bacaan, dokumen PDF, atau tautan video pembelajaran.
                                @else
                                    Silakan pilih pelatihan yang ditugaskan terlebih dahulu.
                                @endif
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
