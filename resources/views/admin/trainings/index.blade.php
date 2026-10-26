@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Manajemen Pelatihan</h1>
            <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                Kelola program kursus, seminar, dan sertifikasi dalam mode Online, Offline, maupun Blended.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.trainings.create') }}" class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Buat Pelatihan Baru</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col gap-3">
        <form method="GET" action="{{ route('admin.trainings.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search -->
            <div class="relative lg:col-span-2">
                <span class="material-symbols-outlined text-[18px] text-outline absolute left-3 top-2.5">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau topik..." 
                    class="w-full pl-9 pr-4 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
            </div>

            <!-- Category -->
            <div>
                <select name="category_id" class="w-full px-3 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mode -->
            <div>
                <select name="mode" class="w-full px-3 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white outline-none">
                    <option value="">Semua Mode</option>
                    @foreach($modes as $mode)
                        <option value="{{ $mode->value }}" {{ request('mode') === $mode->value ? 'selected' : '' }}>
                            {{ $mode->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status & Submit -->
            <div class="flex items-center gap-2">
                <select name="status" class="w-full px-3 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white outline-none">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 bg-secondary text-white font-headline text-xs font-bold rounded-xl transition-all shadow-xs shrink-0 cursor-pointer">
                    Filter
                </button>
            </div>
        </form>

        <div class="flex items-center justify-between pt-2 border-t border-outline-variant/40 text-xs text-outline">
            <span>Menampilkan <strong>{{ $trainings->total() }}</strong> program pelatihan</span>
            @if(request()->hasAny(['search', 'category_id', 'mode', 'status', 'audience']))
                <a href="{{ route('admin.trainings.index') }}" class="text-secondary hover:underline font-semibold">Reset Semua Filter</a>
            @endif
        </div>
    </div>

    <!-- Trainings Table -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                <thead class="bg-surface-container-low text-outline font-semibold uppercase text-[11px] border-b border-outline-variant/40">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Program Pelatihan</th>
                        <th class="py-3.5 px-4">Kategori &amp; Sasaran</th>
                        <th class="py-3.5 px-4">Mode &amp; Sesi</th>
                        <th class="py-3.5 px-4">Jadwal Pelaksanaan</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse ($trainings as $training)
                    <tr class="hover:bg-surface-container-low/40 transition-colors">
                        <td class="py-3.5 px-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                @php
                                    $thumbUrl = null;
                                    if ($training->thumbnail) {
                                        $thumbUrl = \Illuminate\Support\Str::startsWith($training->thumbnail, ['http://', 'https://'])
                                            ? $training->thumbnail
                                            : asset('storage/' . $training->thumbnail);
                                    }
                                @endphp
                                @if($thumbUrl)
                                    <img src="{{ $thumbUrl }}" alt="{{ $training->title }}" class="w-11 h-11 rounded-xl object-cover shrink-0 border border-outline-variant/60 shadow-2xs" />
                                @else
                                    <div class="w-11 h-11 rounded-xl bg-primary text-white flex items-center justify-center font-headline font-bold text-xs shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">{{ $training->mode->icon() }}</span>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ route('admin.trainings.show', $training->id) }}" class="font-bold text-primary hover:text-secondary transition-colors truncate max-w-sm block">
                                        {{ $training->title }}
                                    </a>
                                    <div class="text-[11px] text-outline mt-0.5 flex items-center gap-1.5">
                                        <span>Kuota: {{ $training->quota ? $training->quota . ' Peserta' : 'Tanpa Batas' }}</span>
                                        <span>•</span>
                                        <span class="font-semibold {{ $training->is_free ? 'text-tertiary' : 'text-primary' }}">
                                            {{ $training->is_free ? 'Gratis' : 'Rp ' . number_format($training->price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <div class="font-semibold text-primary text-xs">{{ $training->category?->name ?? '—' }}</div>
                            <span class="inline-block mt-0.5 px-2 py-0.2 rounded text-[10px] font-bold {{ $training->audience->badgeClass() }}">
                                {{ $training->audience->label() }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $training->mode->badgeClass() }}">
                                <span class="material-symbols-outlined text-[14px]">{{ $training->mode->icon() }}</span>
                                <span>{{ $training->mode->label() }}</span>
                            </span>
                            <div class="text-[11px] text-outline mt-1 font-medium">
                                {{ $training->sessions_count ?? 0 }} Sesi Terjadwal • {{ $training->instructors_count ?? 0 }} Tentor
                            </div>
                        </td>
                        <td class="py-3.5 px-4 text-xs">
                            <div class="text-primary font-medium">
                                {{ $training->start_date->format('d M Y') }} s.d {{ $training->end_date->format('d M Y') }}
                            </div>
                            @if($training->registration_start && $training->registration_end)
                                <div class="text-[10px] text-outline mt-0.5">
                                    Daftar: {{ $training->registration_start->format('d/m') }} - {{ $training->registration_end->format('d/m/Y') }}
                                </div>
                            @endif
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-xs font-bold {{ $training->status->badgeClass() }}">
                                {{ $training->status->label() }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 sm:px-6 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <!-- Daftar Peserta (ADM-08) -->
                                <a href="{{ route('admin.trainings.participants', $training->id) }}" 
                                   class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-primary hover:text-white text-primary transition-colors cursor-pointer" 
                                   title="Lihat Daftar Peserta">
                                    <span class="material-symbols-outlined text-[16px]">group</span>
                                </a>

                                <!-- Detail / Sesi / Penugasan -->
                                <a href="{{ route('admin.trainings.show', $training->id) }}" 
                                   class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-secondary hover:text-white text-secondary transition-colors cursor-pointer" 
                                   title="Kelola Sesi & Instruktur">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.trainings.edit', $training->id) }}" 
                                   class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-surface-container text-primary transition-colors cursor-pointer" 
                                   title="Ubah Pelatihan">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                </a>

                                <!-- Delete with SweetAlert2 -->
                                <form method="POST" action="{{ route('admin.trainings.destroy', $training->id) }}" class="form-delete" data-title="{{ $training->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(event, '{{ addslashes($training->title) }}')"
                                            class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-error-container/20 text-error transition-colors cursor-pointer" 
                                            title="Hapus Pelatihan">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-outline">
                            <span class="material-symbols-outlined text-4xl mb-1">school</span>
                            <p class="font-headline font-bold text-sm text-primary">Belum Ada Program Pelatihan</p>
                            <p class="text-xs text-on-surface-variant">Mulai dengan membuat pelatihan pertama melalui tombol di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($trainings->hasPages())
        <div class="p-4 border-t border-outline-variant/40 bg-surface-container-low">
            {{ $trainings->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
