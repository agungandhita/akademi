@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Kategori Pelatihan</h1>
            <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                Kelola kelompok bidang ilmu dan topik kurikulum pelatihan terstandarisasi.
            </p>
        </div>
        <div class="flex items-center gap-2.5">
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                <span>Tambah Kategori</span>
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="flex items-center gap-2 w-full sm:w-auto flex-1">
            <div class="relative w-full sm:max-w-xs">
                <span class="material-symbols-outlined text-[18px] text-outline absolute left-3 top-2.5">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi..." 
                    class="w-full pl-9 pr-4 py-2 text-xs text-on-surface bg-surface-container-low border border-outline-variant/60 rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
            </div>
            <button type="submit" class="px-3.5 py-2 bg-surface-container hover:bg-surface-container-high text-primary font-headline text-xs font-bold rounded-xl transition-colors">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.categories.index') }}" class="text-xs text-secondary hover:underline">Reset</a>
            @endif
        </form>

        <span class="text-xs text-outline font-medium shrink-0">
            Total: <strong>{{ $categories->total() }}</strong> Kategori Terdaftar
        </span>
    </div>

    <!-- Categories Table -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm text-on-surface-variant">
                <thead class="bg-surface-container-low text-outline font-semibold uppercase text-[11px] border-b border-outline-variant/40">
                    <tr>
                        <th class="py-3.5 px-4 sm:px-6">Nama Kategori</th>
                        <th class="py-3.5 px-4">Slug URL</th>
                        <th class="py-3.5 px-4">Jumlah Pelatihan</th>
                        <th class="py-3.5 px-4">Deskripsi Ringkas</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    @forelse ($categories as $category)
                    <tr class="hover:bg-surface-container-low/40 transition-colors">
                        <td class="py-3.5 px-4 sm:px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-headline font-bold text-xs shrink-0">
                                    <span class="material-symbols-outlined text-[18px]">category</span>
                                </div>
                                <span class="font-bold text-primary">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <code class="px-2 py-0.5 rounded bg-surface-container text-secondary text-xs font-mono font-bold">
                                {{ $category->slug }}
                            </code>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-container text-primary">
                                {{ $category->trainings_count ?? 0 }} Program
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-xs text-on-surface-variant max-w-sm truncate">
                            {{ $category->description ?? '—' }}
                        </td>
                        <td class="py-3.5 px-4 sm:px-6 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                   class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-surface-container text-primary transition-colors cursor-pointer" 
                                   title="Ubah Kategori">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                </a>

                                <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" class="form-delete" data-title="{{ $category->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            onclick="confirmDelete(event, '{{ addslashes($category->name) }}', 'Apakah Anda yakin ingin menghapus kategori <strong>&quot;{{ addslashes($category->name) }}&quot;</strong>?')"
                                            class="p-1.5 rounded-lg border border-outline-variant/60 hover:bg-error-container/20 text-error transition-colors cursor-pointer" 
                                            title="Hapus Kategori">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-outline">
                            <span class="material-symbols-outlined text-4xl mb-1">folder_off</span>
                            <p class="font-headline font-bold text-sm text-primary">Belum Ada Kategori Pelatihan</p>
                            <p class="text-xs text-on-surface-variant">Klik tombol "Tambah Kategori" untuk membuat kategori pertama.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($categories->hasPages())
        <div class="p-4 border-t border-outline-variant/40 bg-surface-container-low">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
