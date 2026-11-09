@extends('admin.layouts.main')

@section('container')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('admin') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.trainings.index') }}" class="hover:text-secondary">Manajemen Pelatihan</a>
        <span>/</span>
        <a href="{{ route('admin.trainings.show', $training->id) }}" class="hover:text-secondary truncate max-w-xs">{{ $training->title }}</a>
        <span>/</span>
        <span class="text-primary font-semibold">Pengaturan Sertifikat</span>
    </nav>

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $training->status->badgeClass() }}">
                    {{ $training->status->label() }}
                </span>
                @if($training->is_certificate_enabled)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        <span class="material-symbols-outlined text-[13px] align-middle mr-0.5">verified</span>
                        Sertifikat Diterbitkan
                    </span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">
                        <span class="material-symbols-outlined text-[13px] align-middle mr-0.5">lock</span>
                        Belum Diterbitkan ke Peserta
                    </span>
                @endif
            </div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">
                Pengaturan Sertifikat Pelatihan
            </h1>
            <p class="text-xs text-on-surface-variant mt-0.5">
                Konfigurasikan nomor kegiatan, tanggal pelaksanaan resmi, dan tanda tangan digital panitia.
            </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.trainings.certificate.preview', $training->id) }}" target="_blank"
               class="px-4 py-2 bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold rounded-xl shadow-xs transition-colors flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">visibility</span>
                <span>Pratinjau Sertifikat</span>
            </a>
            <a href="{{ route('admin.trainings.show', $training->id) }}"
               class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Configuration -->
    <form method="POST" action="{{ route('admin.trainings.certificate.update', $training->id) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Status Penerbitan Sertifikat -->
        <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h3 class="font-headline text-sm font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-secondary">workspace_premium</span>
                        <span>Status Penerbitan Sertifikat untuk Peserta</span>
                    </h3>
                    <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">
                        Jika diaktifkan, seluruh peserta terdaftar dapat mengakses dan mengunduh sertifikat resmi melalui dashboard peserta.
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" name="is_certificate_enabled" value="1" class="sr-only peer" {{ old('is_certificate_enabled', $training->is_certificate_enabled) ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                </label>
            </div>
        </div>

        <!-- Card 2: Nomor & Tanggal Kegiatan -->
        <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs space-y-4">
            <h3 class="font-headline text-sm font-bold text-primary pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px] text-secondary">pin</span>
                <span>Nomor &amp; Tanggal Pelaksanaan Kegiatan</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nomor Kegiatan -->
                <div>
                    <label for="certificate_number" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Nomor Kegiatan <span class="text-error">*</span>
                    </label>
                    <input type="text" id="certificate_number" name="certificate_number" 
                        value="{{ old('certificate_number', $training->certificate_number ?? sprintf('%03d/AP/X/%s', $training->id, date('Y'))) }}"
                        placeholder="Contoh: 014/AP/X/2026"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    <p class="text-[11px] text-outline mt-1">Format nomor kegiatan resmi yang akan dicantumkan di bagian atas sertifikat.</p>
                    @error('certificate_number')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Kegiatan -->
                <div>
                    <label for="certificate_date" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Tanggal Kegiatan di Sertifikat
                    </label>
                    @php
                        $defaultDate = $training->certificate_date;
                        if (!$defaultDate && $training->start_date) {
                            $defaultDate = $training->end_date && $training->end_date != $training->start_date
                                ? $training->start_date->isoFormat('D MMMM') . ' - ' . $training->end_date->isoFormat('D MMMM Y')
                                : $training->start_date->isoFormat('D MMMM Y');
                        }
                    @endphp
                    <input type="text" id="certificate_date" name="certificate_date" 
                        value="{{ old('certificate_date', $defaultDate) }}"
                        placeholder="Contoh: 24 Oktober 2026 atau 20 - 24 Oktober 2026"
                        class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    <p class="text-[11px] text-outline mt-1">Teks tanggal pelaksanaan yang tertera setelah kalimat "pada tanggal ...".</p>
                    @error('certificate_date')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Card 3 & 4: Signatures Grid (Left: Ketua Pelaksana, Right: Pimpinan) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Penandatangan Kiri (Ketua Pelaksana) -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs space-y-4">
                <h3 class="font-headline text-sm font-bold text-primary pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">draw</span>
                    <span>Penandatangan Kiri (Ketua Pelaksana)</span>
                </h3>

                <!-- Title / Jabatan -->
                <div>
                    <label for="certificate_signer_left_title" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Jabatan Penandatangan Kiri
                    </label>
                    <input type="text" id="certificate_signer_left_title" name="certificate_signer_left_title" 
                        value="{{ old('certificate_signer_left_title', $training->certificate_signer_left_title ?? 'Ketua Pelaksana') }}"
                        class="w-full px-3.5 py-2 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                </div>

                <!-- Nama Lengkap & Gelar -->
                <div>
                    <label for="certificate_signer_left_name" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Nama Lengkap &amp; Gelar
                    </label>
                    <input type="text" id="certificate_signer_left_name" name="certificate_signer_left_name" 
                        value="{{ old('certificate_signer_left_name', $training->certificate_signer_left_name) }}"
                        placeholder="Contoh: Dr. Hendra Wijaya, M.Pd"
                        class="w-full px-3.5 py-2 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('certificate_signer_left_name')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIP / No. Identitas -->
                <div>
                    <label for="certificate_signer_left_nip" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        NIP / Nomor Identitas
                    </label>
                    <input type="text" id="certificate_signer_left_nip" name="certificate_signer_left_nip" 
                        value="{{ old('certificate_signer_left_nip', $training->certificate_signer_left_nip) }}"
                        placeholder="Contoh: NIP. 19820315 200501 1 002"
                        class="w-full px-3.5 py-2 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                </div>

                <!-- Upload Gambar Tanda Tangan Kiri -->
                <div>
                    <label class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Berkas Tanda Tangan (PNG Transparan Disarankan)
                    </label>
                    
                    @if($training->certificate_signer_left_signature_url)
                        <div class="mb-3 p-3 bg-surface-container-low rounded-xl border border-outline-variant/50 flex items-center gap-3">
                            <div class="w-20 h-14 bg-white rounded-lg border border-outline-variant/40 flex items-center justify-center p-1 overflow-hidden">
                                <img src="{{ $training->certificate_signer_left_signature_url }}" alt="TTD Kiri" class="max-h-full max-w-full object-contain" />
                            </div>
                            <div class="text-[11px] text-on-surface-variant flex-1 min-w-0">
                                <span class="font-bold text-primary block truncate">Tanda Tangan Terunggah</span>
                                <span class="text-outline">Unggah berkas baru di bawah untuk mengganti.</span>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="certificate_signer_left_signature" accept="image/png,image/jpeg,image/webp"
                        class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-surface-container file:text-primary hover:file:bg-surface-container-high cursor-pointer" />
                    <p class="text-[10px] text-outline mt-1">Maks. 2 MB (Format PNG dengan background transparan memberikan hasil terbaik).</p>
                    @error('certificate_signer_left_signature')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Penandatangan Kanan (Pimpinan Akademi Pelatihan) -->
            <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs space-y-4">
                <h3 class="font-headline text-sm font-bold text-primary pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">draw</span>
                    <span>Penandatangan Kanan (Pimpinan)</span>
                </h3>

                <!-- Title / Jabatan -->
                <div>
                    <label for="certificate_signer_right_title" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Jabatan Penandatangan Kanan
                    </label>
                    <input type="text" id="certificate_signer_right_title" name="certificate_signer_right_title" 
                        value="{{ old('certificate_signer_right_title', $training->certificate_signer_right_title ?? 'Pimpinan Akademi Pelatihan') }}"
                        class="w-full px-3.5 py-2 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                </div>

                <!-- Nama Lengkap & Gelar -->
                <div>
                    <label for="certificate_signer_right_name" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Nama Lengkap &amp; Gelar
                    </label>
                    <input type="text" id="certificate_signer_right_name" name="certificate_signer_right_name" 
                        value="{{ old('certificate_signer_right_name', $training->certificate_signer_right_name) }}"
                        placeholder="Contoh: Prof. Dr. Ir. H. Budi Santoso, M.Kom"
                        class="w-full px-3.5 py-2 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('certificate_signer_right_name')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIP / No. Identitas -->
                <div>
                    <label for="certificate_signer_right_nip" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        NIP / Nomor Identitas
                    </label>
                    <input type="text" id="certificate_signer_right_nip" name="certificate_signer_right_nip" 
                        value="{{ old('certificate_signer_right_nip', $training->certificate_signer_right_nip) }}"
                        placeholder="Contoh: NIP. 19750820 199903 1 001"
                        class="w-full px-3.5 py-2 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                </div>

                <!-- Upload Gambar Tanda Tangan Kanan -->
                <div>
                    <label class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Berkas Tanda Tangan (PNG Transparan Disarankan)
                    </label>
                    
                    @if($training->certificate_signer_right_signature_url)
                        <div class="mb-3 p-3 bg-surface-container-low rounded-xl border border-outline-variant/50 flex items-center gap-3">
                            <div class="w-20 h-14 bg-white rounded-lg border border-outline-variant/40 flex items-center justify-center p-1 overflow-hidden">
                                <img src="{{ $training->certificate_signer_right_signature_url }}" alt="TTD Kanan" class="max-h-full max-w-full object-contain" />
                            </div>
                            <div class="text-[11px] text-on-surface-variant flex-1 min-w-0">
                                <span class="font-bold text-primary block truncate">Tanda Tangan Terunggah</span>
                                <span class="text-outline">Unggah berkas baru di bawah untuk mengganti.</span>
                            </div>
                        </div>
                    @endif

                    <input type="file" name="certificate_signer_right_signature" accept="image/png,image/jpeg,image/webp"
                        class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-surface-container file:text-primary hover:file:bg-surface-container-high cursor-pointer" />
                    <p class="text-[10px] text-outline mt-1">Maks. 2 MB (Format PNG dengan background transparan memberikan hasil terbaik).</p>
                    @error('certificate_signer_right_signature')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.trainings.show', $training->id) }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-xs font-bold text-on-surface-variant hover:bg-surface-container transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-primary hover:bg-primary-container text-white text-xs font-bold shadow-xs transition-colors flex items-center gap-2 cursor-pointer">
                <span class="material-symbols-outlined text-[18px]">save</span>
                <span>Simpan Pengaturan Sertifikat</span>
            </button>
        </div>
    </form>

</div>
@endsection

