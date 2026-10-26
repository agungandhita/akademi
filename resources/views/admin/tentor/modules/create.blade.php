@extends('admin.layouts.main')

@section('container')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('tentor') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('tentor.modules.index') }}" class="hover:text-secondary">Modul Pembelajaran</a>
        <span>/</span>
        <span class="text-primary font-semibold">Tambah Modul Baru</span>
    </nav>

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">Tambah Modul Materi Baru</h1>
            <p class="text-xs text-on-surface-variant mt-0.5">Unggah berkas PDF, tulis materi teks, atau sertakan video pembelajaran (TNT-03 s.d. TNT-05).</p>
        </div>
        <a href="{{ route('tentor.modules.index', array_filter(['training_id' => $selectedTrainingId])) }}" class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
            Kembali
        </a>
    </div>

    @if($publishedTrainings->isEmpty())
    <div class="p-6 rounded-2xl bg-surface-container-lowest border border-error/30 text-center space-y-3">
        <div class="w-12 h-12 rounded-xl bg-error-container text-error flex items-center justify-center mx-auto">
            <span class="material-symbols-outlined text-2xl">warning</span>
        </div>
        <h3 class="font-headline text-base font-bold text-primary">Tidak Ada Pelatihan yang Memenuhi Syarat</h3>
        <p class="text-xs text-on-surface-variant max-w-md mx-auto leading-relaxed">
            Sesuai aturan (TNT-03), modul ajar hanya dapat ditambahkan pada program pelatihan yang ditugaskan kepada Anda <strong>dan sudah berstatus Published</strong> oleh Administrator.
        </p>
        <a href="{{ route('tentor.trainings') }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-secondary text-white text-xs font-bold rounded-xl shadow-xs">
            <span>Lihat Pelatihan Ditugaskan</span>
        </a>
    </div>
    @else
    <!-- Create Form Card -->
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant/60 shadow-xs">
        <form method="POST" action="{{ route('tentor.modules.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. Pelatihan Induk -->
            <div>
                <label for="training_id" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Pilih Program Pelatihan <span class="text-error">*</span>
                </label>
                <select id="training_id" name="training_id" required
                    class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none cursor-pointer">
                    @foreach($publishedTrainings as $t)
                        <option value="{{ $t->id }}" {{ old('training_id', $selectedTrainingId) == $t->id ? 'selected' : '' }}>
                            {{ $t->title }} ({{ $t->category?->name ?? 'Pelatihan' }})
                        </option>
                    @endforeach
                </select>
                @error('training_id')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 2. Judul & Urutan Modul -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="md:col-span-3">
                    <label for="title" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Judul Modul Materi <span class="text-error">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: Modul 01: Pengenalan Pembelajaran Digital Berdiferensiasi"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('title')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Urutan Modul (Sort) <span class="text-error">*</span>
                    </label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 1) }}" min="0" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('sort_order')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 3. Deskripsi Singkat -->
            <div>
                <label for="description" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Deskripsi / Ringkasan Modul <span class="text-outline font-normal">(Opsional)</span>
                </label>
                <textarea id="description" name="description" rows="2" placeholder="Jelaskan secara ringkas tujuan pembelajaran dan capaian yang diharapkan dari modul ini..."
                    class="w-full p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none resize-none">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 4. Pilihan Format Materi (TNT-04) -->
            <div>
                <label class="block font-headline text-xs font-bold text-primary mb-2">
                    Pilih Jenis / Format Materi <span class="text-error">*</span>
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @php $currentType = old('type', 'text'); @endphp
                    <!-- Type 1: Text -->
                    <label class="relative flex flex-col p-3.5 rounded-xl border cursor-pointer transition-all type-option {{ $currentType === 'text' ? 'bg-secondary/10 border-secondary shadow-xs' : 'bg-surface-container-low border-outline-variant/60 hover:bg-surface-container' }}">
                        <input type="radio" name="type" value="text" class="sr-only" onchange="switchModuleType(this.value)" {{ $currentType === 'text' ? 'checked' : '' }} />
                        <span class="material-symbols-outlined text-secondary text-2xl mb-1">article</span>
                        <span class="font-bold text-xs text-primary">Teks / Artikel</span>
                        <span class="text-[10px] text-outline mt-0.5">Materi bacaan langsung</span>
                    </label>

                    <!-- Type 2: PDF -->
                    <label class="relative flex flex-col p-3.5 rounded-xl border cursor-pointer transition-all type-option {{ $currentType === 'pdf' ? 'bg-secondary/10 border-secondary shadow-xs' : 'bg-surface-container-low border-outline-variant/60 hover:bg-surface-container' }}">
                        <input type="radio" name="type" value="pdf" class="sr-only" onchange="switchModuleType(this.value)" {{ $currentType === 'pdf' ? 'checked' : '' }} />
                        <span class="material-symbols-outlined text-error text-2xl mb-1">picture_as_pdf</span>
                        <span class="font-bold text-xs text-primary">Dokumen PDF</span>
                        <span class="text-[10px] text-outline mt-0.5">Unggah berkas PDF</span>
                    </label>

                    <!-- Type 3: Video -->
                    <label class="relative flex flex-col p-3.5 rounded-xl border cursor-pointer transition-all type-option {{ $currentType === 'video' ? 'bg-secondary/10 border-secondary shadow-xs' : 'bg-surface-container-low border-outline-variant/60 hover:bg-surface-container' }}">
                        <input type="radio" name="type" value="video" class="sr-only" onchange="switchModuleType(this.value)" {{ $currentType === 'video' ? 'checked' : '' }} />
                        <span class="material-symbols-outlined text-primary text-2xl mb-1">play_circle</span>
                        <span class="font-bold text-xs text-primary">Video Belajar</span>
                        <span class="text-[10px] text-outline mt-0.5">YouTube / Google Drive</span>
                    </label>

                    <!-- Type 4: Link External -->
                    <label class="relative flex flex-col p-3.5 rounded-xl border cursor-pointer transition-all type-option {{ $currentType === 'link' ? 'bg-secondary/10 border-secondary shadow-xs' : 'bg-surface-container-low border-outline-variant/60 hover:bg-surface-container' }}">
                        <input type="radio" name="type" value="link" class="sr-only" onchange="switchModuleType(this.value)" {{ $currentType === 'link' ? 'checked' : '' }} />
                        <span class="material-symbols-outlined text-outline text-2xl mb-1">link</span>
                        <span class="font-bold text-xs text-primary">Tautan Luar</span>
                        <span class="text-[10px] text-outline mt-0.5">URL referensi eksternal</span>
                    </label>
                </div>
                @error('type')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 5. Konten Dinamis Berdasarkan Tipe -->
            <!-- Dynamic Section: Text/Content -->
            <div id="section-text" class="space-y-1.5 {{ $currentType === 'text' ? '' : 'hidden' }}">
                <label for="content" class="block font-headline text-xs font-bold text-primary">
                    Isi Materi Pembelajaran (Teks Lengkap) <span class="text-error">*</span>
                </label>
                <textarea id="content" name="content" rows="8" placeholder="Tuliskan materi pembelajaran modul secara lengkap di sini..."
                    class="w-full p-4 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none leading-relaxed">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dynamic Section: PDF Upload -->
            <div id="section-pdf" class="space-y-1.5 {{ $currentType === 'pdf' ? '' : 'hidden' }}">
                <label for="file" class="block font-headline text-xs font-bold text-primary">
                    Unggah Berkas PDF Modul <span class="text-error">*</span>
                </label>
                <input type="file" id="file" name="file" accept="application/pdf"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                <p class="text-[11px] text-outline">Format dokumen wajib <strong>.PDF</strong> dengan ukuran maksimal 10 MB.</p>
                @error('file')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dynamic Section: Video / Link URL -->
            <div id="section-url" class="space-y-1.5 {{ in_array($currentType, ['video', 'link']) ? '' : 'hidden' }}">
                <label for="url" class="block font-headline text-xs font-bold text-primary">
                    <span id="label-url">Tautan URL Video / Dokumen Luar</span> <span class="text-error">*</span>
                </label>
                <input type="url" id="url" name="url" value="{{ old('url') }}" placeholder="https://www.youtube.com/watch?v=... atau https://drive.google.com/..."
                    class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                @error('url')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- 6. Status Modul (Draft / Published) -->
            <div class="pt-2 border-t border-outline-variant/40">
                <label for="status" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Status Publikasi Modul <span class="text-error">*</span>
                </label>
                <select id="status" name="status" required
                    class="w-full sm:max-w-xs px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none cursor-pointer">
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Diterbitkan (Dapat diakses peserta)</option>
                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draf (Hanya terlihat oleh instruktur)</option>
                </select>
                @error('status')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button Bar -->
            <div class="pt-4 border-t border-outline-variant/40 flex items-center justify-end gap-3">
                <a href="{{ route('tentor.modules.index', array_filter(['training_id' => $selectedTrainingId])) }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-xs font-bold text-on-surface-variant hover:bg-surface-container transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all cursor-pointer">
                    Simpan Modul Materi
                </button>
            </div>
        </form>
    </div>
    @endif

</div>

<!-- Interactive Switcher Script -->
<script>
function switchModuleType(type) {
    document.querySelectorAll('.type-option').forEach(el => {
        el.classList.remove('bg-secondary/10', 'border-secondary', 'shadow-xs');
        el.classList.add('bg-surface-container-low', 'border-outline-variant/60');
    });

    const activeLabel = event.target.closest('label');
    if (activeLabel) {
        activeLabel.classList.add('bg-secondary/10', 'border-secondary', 'shadow-xs');
        activeLabel.classList.remove('bg-surface-container-low', 'border-outline-variant/60');
    }

    const secText = document.getElementById('section-text');
    const secPdf = document.getElementById('section-pdf');
    const secUrl = document.getElementById('section-url');
    const labelUrl = document.getElementById('label-url');

    secText.classList.add('hidden');
    secPdf.classList.add('hidden');
    secUrl.classList.add('hidden');

    if (type === 'text') {
        secText.classList.remove('hidden');
    } else if (type === 'pdf') {
        secPdf.classList.remove('hidden');
    } else if (type === 'video') {
        secUrl.classList.remove('hidden');
        labelUrl.innerText = 'Tautan URL Video (YouTube / Google Drive)';
    } else if (type === 'link') {
        secUrl.classList.remove('hidden');
        labelUrl.innerText = 'Tautan URL Materi Luar (Eksternal)';
    }
}
</script>
@endsection
