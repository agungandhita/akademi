@extends('admin.layouts.main')

@section('container')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('admin') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.users.index') }}" class="hover:text-secondary">Manajemen Pengguna</a>
        <span>/</span>
        <span class="text-primary font-semibold">Ubah Data</span>
    </nav>

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">Ubah Data Pengguna</h1>
            <p class="text-xs text-on-surface-variant mt-0.5">Perbarui informasi profil, instansi, atau status keaktifan akun.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
            Kembali
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant/60 shadow-xs">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Avatar Photo Upload Section -->
            <div class="p-5 rounded-2xl bg-surface-container-low border border-outline-variant/60 space-y-3">
                <div>
                    <label class="block font-headline text-xs font-bold text-primary mb-1">
                        Foto Profil Pengguna
                    </label>
                    <p class="text-[11px] text-outline">
                        Format: JPG, JPEG, PNG, WEBP. Maksimal 10MB. Biarkan kosong jika tidak ingin mengubah foto profil.
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
                                    <span class="material-symbols-outlined text-3xl mb-1 text-outline/70">account_circle</span>
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
                        Nama Lengkap <span class="text-error">*</span>
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
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('phone')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Institution -->
                <div>
                    <label for="institution" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Institusi / Sekolah / Lembaga
                    </label>
                    <input type="text" id="institution" name="institution" value="{{ old('institution', $user->institution) }}"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('institution')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expertise (For Tentor/Instruktur) -->
                <div>
                    <label for="expertise" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Bidang Keahlian / Kompetensi
                    </label>
                    <input type="text" id="expertise" name="expertise" value="{{ old('expertise', $user->expertise) }}" placeholder="Contoh: Pedagogi Digital, Web Dev, dll"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('expertise')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Participant Type (if role peserta) -->
                <div>
                    <label for="participant_type" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Tipe Peserta Pelatihan
                    </label>
                    <select id="participant_type" name="participant_type" 
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none">
                        <option value="">— Tidak Ditetapkan —</option>
                        <option value="guru" {{ old('participant_type', $user->participant_type?->value) === 'guru' ? 'selected' : '' }}>Guru &amp; Tenaga Pendidik</option>
                        <option value="siswa" {{ old('participant_type', $user->participant_type?->value) === 'siswa' ? 'selected' : '' }}>Siswa / Mahasiswa</option>
                        <option value="umum" {{ old('participant_type', $user->participant_type?->value) === 'umum' ? 'selected' : '' }}>Masyarakat Umum / Vokasi</option>
                    </select>
                </div>
            </div>

            <!-- Bio -->
            <div>
                <label for="bio" class="block font-headline text-xs font-bold text-primary mb-1.5">
                    Biografi / Catatan Singkat
                </label>
                <textarea id="bio" name="bio" rows="3"
                    class="w-full p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none resize-none">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p class="text-xs text-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status Checkbox -->
            <div class="pt-2 border-t border-outline-variant/40 flex items-center justify-between">
                <div>
                    <span class="font-headline text-xs font-bold text-primary block">Status Keaktifan Akun</span>
                    <span class="text-[11px] text-outline">Akun nonaktif tidak akan dapat melakukan login ke dalam sistem.</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-surface-container-high peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-outline-variant/40 flex items-center justify-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-xs font-bold text-on-surface-variant hover:bg-surface-container transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all cursor-pointer">
                    Simpan Perubahan
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
        // Validasi ukuran berkas maksimal 10MB
        if (file.size > 10 * 1024 * 1024) {
            alert('Ukuran berkas foto terlalu besar (' + (file.size / (1024 * 1024)).toFixed(1) + ' MB). Maksimal yang diizinkan adalah 10MB.');
            cancelEditAvatarSelection();
            return;
        }

        filenameLabel.textContent = 'Berkas dipilih: ' + file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        btnCancel.classList.remove('hidden');

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
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
        filenameLabel.textContent = "Foto saat ini tersimpan: {{ basename($user->avatar ?? '') }}";
    } else {
        previewImg.src = '';
        previewImg.classList.add('hidden');
        if (placeholder) placeholder.classList.remove('hidden');
        filenameLabel.textContent = 'Belum ada foto profil.';
    }
}
</script>
@endsection
