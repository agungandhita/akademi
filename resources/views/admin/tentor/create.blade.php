@extends('admin.layouts.main')

@section('container')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('admin') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.users.index') }}" class="hover:text-secondary">Manajemen Pengguna</a>
        <span>/</span>
        <span class="text-primary font-semibold">Buat Akun Tentor</span>
    </nav>

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">Buat Akun Tentor Baru</h1>
            <p class="text-xs text-on-surface-variant mt-0.5">Sesuai aturan sistem (PRD Bagian 4), akun instruktur/tentor hanya dapat diterbitkan oleh Administrator.</p>
        </div>
        <a href="{{ route('admin.users.index', ['role' => 'tentor']) }}" class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
            Kembali
        </a>
    </div>

    <!-- Alert Information Card -->
    <div class="p-4 bg-secondary-fixed text-on-secondary-fixed rounded-2xl flex items-start gap-3">
        <span class="material-symbols-outlined text-[22px] shrink-0 text-secondary">info</span>
        <div class="text-xs leading-relaxed">
            <strong>Catatan Otoritas:</strong> Akun yang dibuat di sini secara otomatis akan memiliki hak akses sebagai <strong>Tentor</strong>. Foto profil resmi wajib diunggah untuk ditampilkan pada katalog program dan modul pelatihan.
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant/60 shadow-xs">
        <form method="POST" action="{{ route('admin.tentor.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Tentor Photo / Avatar Upload Section (Wajib) -->
            <div class="p-5 rounded-2xl bg-surface-container-low border border-outline-variant/60 space-y-4">
                <div>
                    <label class="block font-headline text-xs font-bold text-primary mb-1">
                        Foto Profil Instruktur / Tentor <span class="text-error">*</span>
                    </label>
                    <p class="text-[11px] text-outline">
                        Wajib mengunggah foto formal tentor. Format: JPG, JPEG, PNG, atau WEBP. Maksimal 10MB. Rasio 1:1 direkomendasikan.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <!-- Photo Preview Box -->
                    <div class="relative group">
                        <div id="avatar-preview-container" class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl bg-surface-container-high border-2 border-dashed border-outline-variant/80 overflow-hidden flex items-center justify-center shadow-2xs">
                            <img id="avatar-preview-img" src="" alt="Preview Foto Tentor" class="w-full h-full object-cover hidden" />
                            <div id="avatar-preview-placeholder" class="text-center p-2 text-outline">
                                <span class="material-symbols-outlined text-3xl mb-1 text-outline/70">add_a_photo</span>
                                <span class="text-[10px] block font-semibold">Pilih Foto</span>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Controls -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-2.5">
                            <label for="avatar" 
                                   class="px-4 py-2 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl shadow-2xs transition-all flex items-center gap-1.5 cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">upload</span>
                                <span>Pilih Berkas Foto</span>
                            </label>
                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg,image/webp" required class="hidden" onchange="handleAvatarPreview(this)" />
                            
                            <button type="button" id="btn-remove-avatar" onclick="removeAvatarSelection()" class="hidden px-3 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-error hover:bg-error-container/20 transition-colors">
                                Hapus
                            </button>
                        </div>
                        <span id="avatar-filename" class="text-[11px] text-on-surface-variant font-medium block">
                            Belum ada berkas foto yang dipilih.
                        </span>
                        @error('avatar')
                            <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Credentials & Basic Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Name -->
                <div>
                    <label for="name" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Nama Lengkap Beserta Gelar <span class="text-error">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Dr. Hendra Wijaya, M.Pd" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('name')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Alamat Email Aktif <span class="text-error">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="hendra.wijaya@akademipelatihan.com" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('email')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Initial Password -->
                <div>
                    <label for="password" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Kata Sandi Awal <span class="text-error">*</span>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Minimal 8 karakter aman" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    <span class="text-[10px] text-outline mt-1 block">Berikan kata sandi ini kepada tentor untuk akses login pertama kali.</span>
                    @error('password')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Nomor Handphone / WhatsApp
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Contoh: 081234567890"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('phone')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Expertise -->
            <div>
                <label for="expertise" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Bidang Keahlian &amp; Spesialisasi Pengajaran
                </label>
                <input type="text" id="expertise" name="expertise" value="{{ old('expertise') }}" placeholder="Contoh: Pedagogi Digital, AI Instruksional, Asesmen Formatif"
                    class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                @error('expertise')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Biografi &amp; Ringkasan Rekam Jejak
                </label>
                <textarea id="bio" name="bio" rows="3" placeholder="Tuliskan pengalaman mengajar, sertifikasi, atau gelar keahlian tentor..."
                    class="w-full p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none resize-none">{{ old('bio') }}</textarea>
                @error('bio')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-outline-variant/40 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index', ['role' => 'tentor']) }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-xs font-bold text-on-surface-variant hover:bg-surface-container transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    <span>Terbitkan Akun Tentor</span>
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Image Preview Script -->
<script>
function handleAvatarPreview(input) {
    const file = input.files && input.files[0];
    const previewImg = document.getElementById('avatar-preview-img');
    const placeholder = document.getElementById('avatar-preview-placeholder');
    const filenameLabel = document.getElementById('avatar-filename');
    const btnRemove = document.getElementById('btn-remove-avatar');

    if (file) {
        // Validasi ukuran berkas maksimal 10MB
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran berkas foto terlalu besar (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB). Maksimal yang diizinkan adalah 10MB.');
            removeAvatarSelection();
            return;
        }

        filenameLabel.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        btnRemove.classList.remove('hidden');

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

function removeAvatarSelection() {
    const input = document.getElementById('avatar');
    const previewImg = document.getElementById('avatar-preview-img');
    const placeholder = document.getElementById('avatar-preview-placeholder');
    const filenameLabel = document.getElementById('avatar-filename');
    const btnRemove = document.getElementById('btn-remove-avatar');

    input.value = '';
    previewImg.src = '';
    previewImg.classList.add('hidden');
    placeholder.classList.remove('hidden');
    filenameLabel.textContent = 'Belum ada berkas foto yang dipilih.';
    btnRemove.classList.add('hidden');
}
</script>
@endsection
