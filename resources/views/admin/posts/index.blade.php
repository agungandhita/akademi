@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-outline mb-1 font-medium">
                <a href="{{ route('admin') }}" class="hover:text-secondary">Dashboard</a>
                <span>/</span>
                <span class="text-primary font-bold">Berita &amp; Artikel</span>
            </div>
            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Manajemen Berita &amp; Artikel</h1>
            <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                Kelola publikasi siaran pers, artikel edukasi, panduan kurikulum, dan wawasan resmi Akademi Pelatihan.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Tulis Konten Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col lg:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap items-center gap-2.5 w-full lg:w-auto flex-1">
            <!-- Search -->
            <div class="relative w-full sm:w-64">
                <span class="material-symbols-outlined text-[18px] text-outline absolute left-3 top-2.5">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau ringkasan..." 
                    class="w-full pl-9 pr-4 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none transition-all placeholder:text-outline" />
            </div>

            <!-- Filter Type -->
            <select name="type" class="px-3 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none">
                <option value="">Semua Tipe</option>
                <option value="berita" {{ request('type') === 'berita' ? 'selected' : '' }}>Berita</option>
                <option value="artikel" {{ request('type') === 'artikel' ? 'selected' : '' }}>Artikel</option>
            </select>

            <!-- Filter Status -->
            <select name="status" class="px-3 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
            </select>

            <button type="submit" class="px-4 py-2 bg-secondary text-white font-headline text-xs font-bold rounded-xl hover:bg-secondary-container transition-all">
                Filter
            </button>

            @if(request('search') || request('type') || request('status'))
                <a href="{{ route('admin.posts.index') }}" class="text-xs text-secondary hover:underline ml-1">
                    Reset Filter
                </a>
            @endif
        </form>

        <span class="text-xs text-outline font-medium shrink-0">
            Total: <strong>{{ $posts->total() }}</strong> Konten Terdata
        </span>
    </div>

    <!-- Posts Table -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                <thead class="bg-surface-container-low text-outline font-semibold uppercase text-[11px] border-b border-outline-variant/40">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Konten</th>
                        <th class="py-3.5 px-4">Tipe</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Penulis</th>
                        <th class="py-3.5 px-4">Tanggal Terbit</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse ($posts as $post)
                    <tr class="hover:bg-surface-container-low/40 transition-colors">
                        <!-- Cover & Title -->
                        <td class="py-3.5 px-4 sm:px-6">
                            <div class="flex items-start gap-3 max-w-md">
                                <div class="w-14 h-14 rounded-xl bg-surface-container-high border border-outline-variant/50 shrink-0 overflow-hidden flex items-center justify-center">
                                    @if($post->cover)
                                        <img src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-outline text-[24px]">
                                            {{ $post->type->value === 'berita' ? 'newspaper' : 'article' }}
                                        </span>
                                    @endif
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <a href="{{ route('admin.posts.show', $post->id) }}" class="font-headline font-bold text-xs sm:text-sm text-primary hover:text-secondary line-clamp-1 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                    <p class="text-[11px] text-on-surface-variant line-clamp-1 mt-0.5">
                                        {{ $post->excerpt }}
                                    </p>
                                    <span class="text-[10px] text-outline font-mono mt-1 truncate">
                                        /berita/{{ $post->slug }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <!-- Tipe -->
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $post->type->badgeClass() }}">
                                {{ $post->type->label() }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $post->status->badgeClass() }}">
                                {{ $post->status->label() }}
                            </span>
                        </td>

                        <!-- Penulis -->
                        <td class="py-3.5 px-4 text-xs">
                            <span class="font-semibold text-primary block truncate max-w-[120px]">
                                {{ $post->author?->name ?? 'Admin' }}
                            </span>
                        </td>

                        <!-- Tanggal Terbit -->
                        <td class="py-3.5 px-4 text-xs text-on-surface-variant whitespace-nowrap">
                            @if($post->published_at)
                                <div class="flex flex-col">
                                    <span class="font-medium text-primary">{{ $post->published_at->translatedFormat('d M Y') }}</span>
                                    <span class="text-[10px] text-outline">{{ $post->published_at->format('H:i') }} WIB</span>
                                </div>
                            @else
                                <span class="text-outline italic">Belum terbit</span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="py-3.5 px-4 sm:px-6 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.posts.show', $post->id) }}" 
                                   class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-surface-container text-on-surface-variant hover:text-primary transition-colors cursor-pointer" 
                                   title="Pratinjau Detail">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                </a>

                                <a href="{{ route('admin.posts.edit', $post->id) }}" 
                                   class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-surface-container text-secondary transition-colors cursor-pointer" 
                                   title="Ubah Konten">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                </a>

                                <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" class="form-delete" data-title="{{ $post->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(event, '{{ addslashes($post->title) }}', 'Apakah Anda yakin ingin menghapus konten <strong>&quot;{{ addslashes($post->title) }}&quot;</strong>? Tindakan ini dapat dibatalkan melalui pemulihan sistem.')"
                                            class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-error-container/20 text-error transition-colors cursor-pointer" 
                                            title="Hapus Konten">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-outline">
                            <span class="material-symbols-outlined text-4xl mb-2 text-outline/60">article</span>
                            <p class="font-headline font-bold text-sm text-primary">Tidak Ada Berita atau Artikel Ditemukan</p>
                            <p class="text-xs text-on-surface-variant mt-1">Coba sesuaikan kata kunci pencarian atau klik tombol "Tulis Konten Baru".</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
        <div class="p-4 border-t border-outline-variant/40 bg-surface-container-low">
            {{ $posts->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
