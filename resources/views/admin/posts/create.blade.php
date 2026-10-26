@extends('admin.layouts.main')

@section('container')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-outline mb-1 font-medium">
                <a href="{{ route('admin.posts.index') }}" class="hover:text-secondary">Berita &amp; Artikel</a>
                <span>/</span>
                <span class="text-primary font-bold">Tulis Baru</span>
            </div>
            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Tulis Berita / Artikel Baru</h1>
            <p class="text-xs sm:text-sm text-on-surface-variant mt-1">
                Lengkapi formulir di bawah ini untuk menerbitkan berita resmi atau artikel wawasan pembelajaran.
            </p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 rounded-xl border border-outline-variant/60 text-on-surface-variant hover:text-primary hover:bg-surface-container font-headline text-xs font-semibold transition-all">
            Kembali
        </a>
    </div>

    <!-- Form Container -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 p-6 sm:p-8 shadow-xs">
        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label for="title" class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">
                    Judul Konten <span class="text-error">*</span>
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       required
                       placeholder="Misal: Transformasi Digital Pendidikan Vokasi Melalui Kurikulum AI 2026"
                       class="w-full px-4 py-3 text-sm text-on-surface bg-surface-container-low border @error('title') border-error @else border-outline-variant/60 @enderror rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 focus:border-secondary outline-none transition-all placeholder:text-outline font-medium" />
                @error('title')
                    <p class="text-xs text-error mt-1.5 flex items-center gap-1 font-medium">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Grid: Tipe, Status, & Tanggal Terbit -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <!-- Tipe -->
                <div>
                    <label for="type" class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">
                        Tipe Konten <span class="text-error">*</span>
                    </label>
                    <select id="type" name="type" required
                        class="w-full px-4 py-2.5 text-xs text-on-surface bg-surface-container-low border @error('type') border-error @else border-outline-variant/60 @enderror rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none transition-all font-semibold">
                        <option value="berita" {{ old('type', 'berita') === 'berita' ? 'selected' : '' }}>Berita (Siaran Resmi / Liputan)</option>
                        <option value="artikel" {{ old('type') === 'artikel' ? 'selected' : '' }}>Artikel (Edukasi / Opini / Wawasan)</option>
                    </select>
                    @error('type')
                        <p class="text-xs text-error mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">
                        Status Publikasi <span class="text-error">*</span>
                    </label>
                    <select id="status" name="status" required
                        class="w-full px-4 py-2.5 text-xs text-on-surface bg-surface-container-low border @error('status') border-error @else border-outline-variant/60 @enderror rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none transition-all font-semibold">
                        <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft (Simpan sebagai Konsep)</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published (Terbitkan ke Publik)</option>
                    </select>
                    @error('status')
                        <p class="text-xs text-error mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Terbit -->
                <div>
                    <label for="published_at" class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">
                        Tanggal Terbit <span class="text-outline text-[10px] font-normal">(Opsional)</span>
                    </label>
                    <input type="datetime-local" 
                           id="published_at" 
                           name="published_at" 
                           value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                           class="w-full px-4 py-2.5 text-xs text-on-surface bg-surface-container-low border @error('published_at') border-error @else border-outline-variant/60 @enderror rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none transition-all font-medium" />
                    @error('published_at')
                        <p class="text-xs text-error mt-1.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Upload Cover Image -->
            <div>
                <label class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">
                    Foto Sampul / Cover <span class="text-outline text-[10px] font-normal">(Opsional, Maks 2 MB)</span>
                </label>
                <div class="flex flex-col sm:flex-row items-center gap-4 p-4 border-2 border-dashed border-outline-variant/80 rounded-2xl bg-surface-container-low/40">
                    <div id="cover-preview-wrapper" class="w-28 h-20 rounded-xl bg-surface-container border border-outline-variant/50 overflow-hidden flex items-center justify-center shrink-0">
                        <span id="cover-placeholder" class="material-symbols-outlined text-outline text-[32px]">image</span>
                        <img id="cover-preview" src="#" alt="Preview Cover" class="hidden w-full h-full object-cover">
                    </div>
                    <div class="flex-1 w-full text-center sm:text-left">
                        <input type="file" 
                               id="cover" 
                               name="cover" 
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="block w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-secondary file:text-white hover:file:bg-secondary-container file:cursor-pointer cursor-pointer" />
                        <p class="text-[11px] text-outline mt-1.5">Mendukung format JPG, PNG, WEBP dengan rasio standar 16:9 atau landscape.</p>
                    </div>
                </div>
                @error('cover')
                    <p class="text-xs text-error mt-1.5 flex items-center gap-1 font-medium">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Ringkasan (Excerpt) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="excerpt" class="block text-xs font-bold text-primary uppercase tracking-wider">
                        Ringkasan / Sinopsis Konten <span class="text-error">*</span>
                    </label>
                    <span class="text-[11px] text-outline" id="excerpt-counter">0 / 500 karakter</span>
                </div>
                <textarea id="excerpt" 
                          name="excerpt" 
                          rows="3" 
                          maxlength="500" 
                          required
                          placeholder="Tuliskan rangkuman 1-2 paragraf singkat yang memikat pembaca dan tampil di kartu berita..."
                          class="w-full px-4 py-3 text-xs sm:text-sm text-on-surface bg-surface-container-low border @error('excerpt') border-error @else border-outline-variant/60 @enderror rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 focus:border-secondary outline-none transition-all placeholder:text-outline font-medium leading-relaxed">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="text-xs text-error mt-1.5 flex items-center gap-1 font-medium">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Isi Konten Lengkap (Content) -->
            <div>
                <label for="content" class="block text-xs font-bold text-primary uppercase tracking-wider mb-2">
                    Isi Konten Lengkap <span class="text-error">*</span>
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="12" 
                          required
                          placeholder="Tuliskan materi ulasan, sub-judul, data penguat, dan pembahasan menyeluruh di sini..."
                          class="w-full px-4 py-3 text-sm text-on-surface bg-surface-container-low border @error('content') border-error @else border-outline-variant/60 @enderror rounded-xl focus:bg-white focus:ring-2 focus:ring-secondary/40 focus:border-secondary outline-none transition-all placeholder:text-outline font-sans leading-relaxed">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-xs text-error mt-1.5 flex items-center gap-1 font-medium">
                        <span class="material-symbols-outlined text-[14px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-outline-variant/60 flex items-center justify-end gap-3">
                <a href="{{ route('admin.posts.index') }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-on-surface-variant hover:bg-surface-container font-headline text-xs font-semibold transition-all">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">publish</span>
                    <span>Simpan Konten</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Excerpt character counter
    const excerptInput = document.getElementById('excerpt');
    const counter = document.getElementById('excerpt-counter');
    if (excerptInput && counter) {
        const updateCounter = () => {
            counter.textContent = `${excerptInput.value.length} / 500 karakter`;
        };
        excerptInput.addEventListener('input', updateCounter);
        updateCounter();
    }

    // Cover image preview
    const coverInput = document.getElementById('cover');
    const preview = document.getElementById('cover-preview');
    const placeholder = document.getElementById('cover-placeholder');

    if (coverInput && preview && placeholder) {
        coverInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (evt) {
                    preview.src = evt.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        });
    }
});
</script>
@endsection
