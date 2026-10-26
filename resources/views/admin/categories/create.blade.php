@extends('admin.layouts.main')

@section('container')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('admin') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.categories.index') }}" class="hover:text-secondary">Kategori Pelatihan</a>
        <span>/</span>
        <span class="text-primary font-semibold">Tambah Baru</span>
    </nav>

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">Tambah Kategori Pelatihan</h1>
            <p class="text-xs text-on-surface-variant mt-0.5">Buat klasifikasi topik baru untuk mengelompokkan program pelatihan.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant/60 shadow-xs">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Nama Kategori <span class="text-error">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Pendidikan & Pedagogi Digital" required
                    class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                @error('name')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Slug URL (Opsional)
                </label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Dibuat otomatis dari nama jika dikosongkan"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                <span class="text-[10px] text-outline mt-1 block">Hanya huruf kecil, angka, dan tanda hubung (-).</span>
                @error('slug')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Deskripsi Ringkas Kategori
                </label>
                <textarea id="description" name="description" rows="3" placeholder="Jelaskan cakupan topik atau kompetensi yang dinaungi oleh kategori ini..."
                    class="w-full p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-outline-variant/40 flex items-center justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-xs font-bold text-on-surface-variant hover:bg-surface-container transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">add_circle</span>
                    <span>Simpan Kategori</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
