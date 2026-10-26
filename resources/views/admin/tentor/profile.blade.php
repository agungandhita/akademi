@extends('admin.layouts.main')

@section('container')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('tentor') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <span class="text-primary font-semibold">Profil &amp; Keahlian Instruktur</span>
    </nav>

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">Profil &amp; Bidang Keahlian</h1>
            <p class="text-xs text-on-surface-variant mt-0.5">Kelola identitas resmi, bidang keahlian pengajaran, biografi, dan keamanan akun Anda (TNT-07).</p>
        </div>
        <a href="{{ route('tentor') }}" class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
            Kembali
        </a>
    </div>

    <!-- Edit Profile Card -->
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant/60 shadow-xs">
        <form method="POST" action="{{ route('tentor.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar Photo Upload Section -->
            <div class="p-5 rounded-2xl bg-surface-container-low border border-outline-variant/60 space-y-3">
                <div>
                    <label class="block font-headline text-xs font-bold text-primary mb-1">
                        Foto Profil Instruktur
                    </label>
                    <p class="text-[11px] text-outline">
                        Format: JPG, JPEG, PNG, WEBP. Maksimal 10MB. Foto ini akan tampil pada katalog pelatihan resmi.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <!-- Photo Preview Box -->
                    <div class="relative group">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl bg-surface-container-high border-2 border-dashed border-outline-variant/80 overflow-hidden flex items-center justify-center shadow-2xs">
                            @if($user->avatar)
                                <img id="edit-avatar-preview-img" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover" />
                            @else
                                <img id="edit-avatar-preview-img" src="" alt="Preview Foto" class="w-full h-full object-cover hidden" />
                                <div id="edit-avatar-placeholder" class="text-center p-2 text-outline">
                                    <span class="material-symbols-outlined text-3xl mb-1 text-outline/70">co_present</span>
                                    <span class="text-[10px] block font-semibold">Belum Ada Foto</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Upload Controls -->
                    <div class="space-y-2">
                        <div class="flex items-center gap-2.5">
                            <label for="avatar" 
                                   class="px-4 py-2 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl shadow-2xs transition-all flex items-center gap-1.5 cursor-pointer">
                                <span class="material-symbols-outlined text-[18px]">upload</span>
                                <span>Unggah Foto Baru</span>
                            </label>
                            <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="handleEditAvatarPreview(this)" />
                            
                            <button type="button" id="btn-cancel-avatar" onclick="cancelEditAvatarSelection()" class="hidden px-3 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-error hover:bg-error-container/20 transition-colors">
                                Batalkan Pilihan
                            </button>
                        </div>
                        <span id="edit-avatar-filename" class="text-[11px] text-on-surface-variant font-medium block">
                            {{ $user->avatar ? 'Foto saat ini tersimpan: ' . basename($user->avatar) : 'Belum ada foto profil.' }}
                        </span>
                        @error('avatar')
                            <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Name -->
                <div>
                    <label for="name" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Nama Lengkap (beserta gelar) <span class="text-error">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('name')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Alamat Email Resmi <span class="text-error">*</span>
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('email')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Nomor Handphone / WhatsApp
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 0812-3456-7890"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('phone')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Institution -->
                <div>
                    <label for="institution" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Institusi / Lembaga / Afiliasi
                    </label>
                    <input type="text" id="institution" name="institution" value="{{ old('institution', $user->institution) }}" placeholder="Contoh: Universitas Indonesia / Mandiri"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('institution')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expertise (Bidang Keahlian) -->
                <div class="md:col-span-2">
                    <label for="expertise" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Bidang Keahlian &amp; Spesialisasi Pengajaran <span class="text-secondary font-normal">(TNT-07)</span>
                    </label>
                    <input type="text" id="expertise" name="expertise" value="{{ old('expertise', $user->expertise) }}" placeholder="Contoh: Pedagogi Digital, Analisis Data Pendidikan, Kurikulum Merdeka"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    <p class="text-[11px] text-outline mt-1">Bidang keahlian ini akan ditampilkan kepada calon peserta pada detail pelatihan yang Anda ampu.</p>
                    @error('expertise')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Biografi Singkat / Pengalaman Profesional
                </label>
                <textarea id="bio" name="bio" rows="4" placeholder="Ceritakan latar belakang profesional, pencapaian, dan pengalaman Anda dalam melatih atau mendidik..."
                    class="w-full p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none resize-none leading-relaxed">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Change (Optional) -->
            <div class="pt-4 border-t border-outline-variant/40 space-y-3">
                <div>
                    <h4 class="font-headline text-xs font-bold text-primary">Keamanan Akun (Ganti Kata Sandi)</h4>
                    <p class="text-[11px] text-outline">Kosongkan kolom ini jika Anda tidak ingin mengubah kata sandi masuk saat ini.</p>
                </div>
                <div class="w-full sm:max-w-md">
                    <label for="password" class="block font-headline text-xs font-semibold text-primary mb-1">
                        Kata Sandi Baru (Minimal 8 karakter)
                    </label>
                    <input type="password" id="password" name="password" placeholder="Masukkan sandi baru..."
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('password')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button Bar -->
            <div class="pt-4 border-t border-outline-variant/40 flex items-center justify-end gap-3">
                <a href="{{ route('tentor') }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-xs font-bold text-on-surface-variant hover:bg-surface-container transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all cursor-pointer">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Image Preview Script -->
<script>
const originalAvatarSrc = "{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}";

function handleEditAvatarPreview(input) {
    const file = input.files && input.files[0];
    const previewImg = document.getElementById('edit-avatar-preview-img');
    const placeholder = document.getElementById('edit-avatar-placeholder');
    const filenameLabel = document.getElementById('edit-avatar-filename');
    const btnCancel = document.getElementById('btn-cancel-avatar');

    if (file) {
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran berkas melebihi 10MB.');
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);

        filenameLabel.textContent = 'Berkas dipilih: ' + file.name;
        btnCancel.classList.remove('hidden');
    }
}

function cancelEditAvatarSelection() {
    const input = document.getElementById('avatar');
    const previewImg = document.getElementById('edit-avatar-preview-img');
    const placeholder = document.getElementById('edit-avatar-placeholder');
    const filenameLabel = document.getElementById('edit-avatar-filename');
    const btnCancel = document.getElementById('btn-cancel-avatar');

    input.value = '';
    btnCancel.classList.add('hidden');

    if (originalAvatarSrc) {
        previewImg.src = originalAvatarSrc;
        previewImg.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
        filenameLabel.textContent = 'Foto saat ini tersimpan: ' + originalAvatarSrc.split('/').pop();
    } else {
        previewImg.src = '';
        previewImg.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
        filenameLabel.textContent = 'Belum ada foto profil.';
    }
}
</script>
@endsection
