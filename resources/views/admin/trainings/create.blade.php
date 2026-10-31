@extends('admin.layouts.main')

@section('container')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-1.5 text-xs text-outline">
        <a href="{{ route('admin') }}" class="hover:text-secondary">Dashboard</a>
        <span>/</span>
        <a href="{{ route('admin.trainings.index') }}" class="hover:text-secondary">Manajemen Pelatihan</a>
        <span>/</span>
        <span class="text-primary font-semibold">Buat Baru</span>
    </nav>

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-headline text-2xl font-extrabold text-primary">Buat Program Pelatihan Baru</h1>
            <p class="text-xs text-on-surface-variant mt-0.5">Lengkapi rincian kurikulum, jadwal, biaya, berkas poster/sampul, dan instruktur pengampu.</p>
        </div>
        <a href="{{ route('admin.trainings.index') }}" class="px-3.5 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-on-surface-variant hover:bg-surface-container transition-colors">
            Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl border border-outline-variant/60 shadow-xs">
        <form method="POST" action="{{ route('admin.trainings.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Informasi Dasar -->
            <div>
                <h3 class="font-headline text-sm font-bold text-primary mb-3 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">info</span>
                    <span>1. Informasi Pokok Pelatihan</span>
                </h3>

                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Judul Pelatihan <span class="text-error">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Contoh: Penerapan Pembelajaran Berbasis AI & Gamifikasi untuk Pendidik" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                        @error('title')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block font-headline text-xs font-bold text-primary mb-1.5">
                                Kategori Bidang <span class="text-error">*</span>
                            </label>
                            <select id="category_id" name="category_id" required
                                class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Audience -->
                        <div>
                            <label for="audience" class="block font-headline text-xs font-bold text-primary mb-1.5">
                                Sasaran Peserta <span class="text-error">*</span>
                            </label>
                            <select id="audience" name="audience" required
                                class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none">
                                @foreach($audiences as $aud)
                                    <option value="{{ $aud->value }}" {{ old('audience') === $aud->value ? 'selected' : '' }}>
                                        {{ $aud->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('audience')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block font-headline text-xs font-bold text-primary mb-1.5">
                                Status Publikasi <span class="text-error">*</span>
                            </label>
                            <select id="status" name="status" required
                                class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none">
                                @foreach($statuses as $stat)
                                    <option value="{{ $stat->value }}" {{ old('status', 'draft') === $stat->value ? 'selected' : '' }}>
                                        {{ $stat->label() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-xs text-error mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Deskripsi Lengkap &amp; Sasaran Pembelajaran <span class="text-error">*</span>
                        </label>
                        <textarea id="description" name="description" rows="5" required placeholder="Uraikan gambaran umum pelatihan, kompetensi yang dicapai, syarat peserta, dan silabus..."
                            class="w-full p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 2: Mode & Lokasi / Link Pertemuan (Aturan Bisnis 7) -->
            <div>
                <h3 class="font-headline text-sm font-bold text-primary mb-3 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">devices_other</span>
                    <span>2. Mode Pelaksanaan &amp; Akses Pertemuan</span>
                </h3>

                <div class="space-y-4">
                    <!-- Mode Radio Selection -->
                    <div>
                        <label class="block font-headline text-xs font-bold text-primary mb-2">
                            Pilih Mode Pelatihan <span class="text-error">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach($modes as $mode)
                            <label class="flex items-center gap-2.5 p-3 rounded-xl border border-outline-variant/60 bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors has-[:checked]:bg-secondary-fixed has-[:checked]:border-secondary">
                                <input type="radio" name="mode" value="{{ $mode->value }}" onchange="handleModeChange(this.value)"
                                    {{ old('mode', 'online') === $mode->value ? 'checked' : '' }} class="text-secondary focus:ring-secondary" />
                                <div>
                                    <div class="font-headline text-xs font-bold text-primary">{{ $mode->label() }}</div>
                                    <div class="text-[10px] text-on-surface-variant">
                                        @if($mode->value === 'online') Zoom / Google Meet
                                        @elseif($mode->value === 'offline') Tatap Muka Fisik
                                        @else Kombinasi Sesi Online &amp; Fisik
                                        @endif
                                    </div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Conditional: Meeting URL -->
                    <div id="meetingUrlContainer">
                        <label for="meeting_url" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Tautan Meeting Daring (Zoom / Google Meet) <span class="text-error">* (Untuk Online)</span>
                        </label>
                        <input type="url" id="meeting_url" name="meeting_url" value="{{ old('meeting_url') }}" placeholder="https://zoom.us/j/... atau https://meet.google.com/..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                        <span class="text-[10px] text-outline mt-1 block">Tautan ini hanya dapat diakses oleh peserta resmi yang telah terdaftar.</span>
                        @error('meeting_url')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Conditional: Location Venue -->
                    <div id="locationContainer">
                        <label for="location" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Lokasi Venue Tatap Muka <span class="text-error">* (Untuk Offline)</span>
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}" placeholder="Contoh: Gedung Guru Indonesia Lt. 3, Jl. Pendidikan No. 45, Jakarta"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                        @error('location')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp Group Link -->
                    <div>
                        <label for="whatsapp_group_link" class="block font-headline text-xs font-bold text-primary mb-1.5 flex items-center justify-between">
                            <span class="flex items-center gap-1.5">
                                <span class="material-symbols-outlined text-[16px] text-emerald-600">chat</span>
                                <span>Tautan Grup WhatsApp Pelatihan (Opsional)</span>
                            </span>
                            <span class="text-[10px] text-outline font-normal">Khusus Peserta Terdaftar</span>
                        </label>
                        <input type="url" id="whatsapp_group_link" name="whatsapp_group_link" value="{{ old('whatsapp_group_link') }}" placeholder="https://chat.whatsapp.com/..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                        <span class="text-[10px] text-outline mt-1 block">Tautan undangan grup WhatsApp koordinasi untuk pelatihan ini. Hanya dapat dilihat dan diakses oleh peserta yang telah terdaftar resmi.</span>
                        @error('whatsapp_group_link')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 3: Jadwal & Kuota -->
            <div>
                <h3 class="font-headline text-sm font-bold text-primary mb-3 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">calendar_month</span>
                    <span>3. Jadwal Pelaksanaan &amp; Kuota Peserta</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Tanggal Mulai <span class="text-error">*</span>
                        </label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                        @error('start_date')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Tanggal Selesai <span class="text-error">*</span>
                        </label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                        @error('end_date')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Registration Start -->
                    <div>
                        <label for="registration_start" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Buka Pendaftaran
                        </label>
                        <input type="date" id="registration_start" name="registration_start" value="{{ old('registration_start') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    </div>

                    <!-- Registration End -->
                    <div>
                        <label for="registration_end" class="block font-headline text-xs font-bold text-primary mb-1.5">
                            Tutup Pendaftaran
                        </label>
                        <input type="date" id="registration_end" name="registration_end" value="{{ old('registration_end') }}"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    </div>
                </div>

                <div class="mt-4">
                    <!-- Quota -->
                    <label for="quota" class="block font-headline text-xs font-bold text-primary mb-1.5">
                        Batas Kuota Peserta (Kosongkan jika tanpa batas)
                    </label>
                    <input type="number" id="quota" name="quota" value="{{ old('quota') }}" min="1" placeholder="Contoh: 50"
                        class="w-full sm:w-1/2 px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:bg-white focus:ring-2 focus:ring-secondary/40 outline-none" />
                    @error('quota')
                        <p class="text-xs text-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Section 4: Biaya & Skema Pendaftaran (Baru) -->
            <div>
                <h3 class="font-headline text-sm font-bold text-primary mb-3 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">payments</span>
                    <span>4. Biaya &amp; Skema Pendaftaran</span>
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block font-headline text-xs font-bold text-primary mb-2">
                            Pilih Skema Biaya <span class="text-error">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- 100% Gratis -->
                            <label class="flex items-start gap-3 p-3.5 rounded-xl border border-outline-variant/60 bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors has-[:checked]:bg-secondary-fixed has-[:checked]:border-secondary">
                                <input type="radio" name="is_free" value="1" onchange="handlePriceTypeChange(true)"
                                    {{ old('is_free', '1') == '1' ? 'checked' : '' }} class="mt-0.5 text-secondary focus:ring-secondary" />
                                <div>
                                    <div class="font-headline text-xs font-bold text-primary flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">redeem</span>
                                        <span>100% Gratis</span>
                                    </div>
                                    <div class="text-[11px] text-on-surface-variant mt-0.5">
                                        Tidak dipungut biaya pendaftaran. Terbuka gratis untuk seluruh peserta yang memenuhi kualifikasi.
                                    </div>
                                </div>
                            </label>

                            <!-- Berbayar -->
                            <label class="flex items-start gap-3 p-3.5 rounded-xl border border-outline-variant/60 bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors has-[:checked]:bg-secondary-fixed has-[:checked]:border-secondary">
                                <input type="radio" name="is_free" value="0" onchange="handlePriceTypeChange(false)"
                                    {{ old('is_free') === '0' ? 'checked' : '' }} class="mt-0.5 text-secondary focus:ring-secondary" />
                                <div>
                                    <div class="font-headline text-xs font-bold text-primary flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px] text-secondary">monetization_on</span>
                                        <span>Berbayar / Berinvestasi</span>
                                    </div>
                                    <div class="text-[11px] text-on-surface-variant mt-0.5">
                                        Peserta dikenakan tarif pendaftaran resmi untuk fasilitas pelatihan, materi premium, atau sertifikat.
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('is_free')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price Input Container (Tampil jika Berbayar) -->
                    <div id="priceContainer" class="{{ old('is_free', '1') == '1' ? 'hidden' : 'block' }} p-4 rounded-xl bg-surface-container-low border border-outline-variant/60 space-y-2">
                        <label for="price" class="block font-headline text-xs font-bold text-primary">
                            Nominal Biaya Pelatihan (Rp) <span class="text-error">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-xs font-bold text-outline">
                                Rp
                            </div>
                            <input type="number" id="price" name="price" value="{{ old('price', 0) }}" min="0" step="1000" placeholder="Contoh: 150000"
                                class="w-full pl-10 pr-3.5 py-2.5 rounded-xl bg-white border border-outline-variant/60 text-xs sm:text-sm font-semibold text-primary focus:ring-2 focus:ring-secondary/40 outline-none"
                                oninput="updatePriceReadable(this.value)" />
                        </div>
                        <div class="flex items-center justify-between text-[11px] text-on-surface-variant">
                            <span>Masukkan angka nominal tanpa titik atau koma (contoh: 250000).</span>
                            <span id="priceReadable" class="font-bold text-secondary">
                                @if(old('price') && old('is_free') === '0')
                                    Terbaca: Rp {{ number_format(old('price'), 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                        @error('price')
                            <p class="text-xs text-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section 5: Fasilitas Peserta Pelatihan (Baru) -->
            <div>
                <h3 class="font-headline text-sm font-bold text-primary mb-3 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">inventory_2</span>
                    <span>5. Fasilitas Peserta Pelatihan</span>
                </h3>

                <div class="space-y-4">
                    <p class="text-xs text-on-surface-variant">
                        Tentukan apa saja fasilitas dan manfaat yang akan diterima oleh peserta terdaftar. Anda dapat memilih dari daftar rekomendasi cepat atau mengetikkan fasilitas khusus.
                    </p>

                    <!-- Quick Preset Checkboxes -->
                    @php
                        $presetFacilities = [
                            'E-Sertifikat 32 JP Terverifikasi Nasional',
                            'Modul Ajar & Bahan Tayang Digital Lengkap',
                            'Akses Rekaman Video Sesi Penuh Seumur Hidup',
                            'Grup Komunitas Bimbingan WhatsApp / Telegram',
                            'Paket Template Praktik & Modul Siap Pakai',
                            'Konsultasi Langsung & Review Karya Bersama Tentor',
                        ];
                        $selectedFacilities = old('facilities', []);
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($presetFacilities as $preset)
                            <label class="flex items-start gap-2.5 p-3 rounded-xl border border-outline-variant/60 bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors has-[:checked]:bg-secondary-fixed has-[:checked]:border-secondary">
                                <input type="checkbox" name="facilities[]" value="{{ $preset }}" 
                                    {{ in_array($preset, $selectedFacilities) ? 'checked' : '' }}
                                    class="mt-0.5 rounded text-secondary focus:ring-secondary" />
                                <span class="font-headline text-xs font-semibold text-primary leading-tight">{{ $preset }}</span>
                            </label>
                        @endforeach
                    </div>

                    <!-- Custom Facility Adder -->
                    <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/60 space-y-3">
                        <label class="block font-headline text-xs font-bold text-primary">
                            Tambah Fasilitas Tambahan Khusus:
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="text" id="customFacilityInput" placeholder="Contoh: Voucher Diskon Kelas Lanjutan 50%" 
                                class="flex-1 px-3.5 py-2.5 rounded-xl bg-white border border-outline-variant/60 text-xs sm:text-sm text-on-surface focus:ring-2 focus:ring-secondary/40 outline-none" 
                                onkeydown="if(event.key === 'Enter'){ event.preventDefault(); addCustomFacility(); }" />
                            <button type="button" onclick="addCustomFacility()" 
                                class="px-4 py-2.5 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl shadow-2xs transition-all flex items-center gap-1 shrink-0 cursor-pointer">
                                <span class="material-symbols-outlined text-[16px]">add</span>
                                <span>Tambah</span>
                            </button>
                        </div>
                        
                        <!-- Container for dynamic custom facilities -->
                        <div id="customFacilitiesContainer" class="flex flex-wrap gap-2 pt-1">
                            @foreach($selectedFacilities as $item)
                                @if(!in_array($item, $presetFacilities))
                                    <div class="custom-facility-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-lowest border border-secondary text-primary font-headline text-xs font-semibold shadow-2xs">
                                        <input type="hidden" name="facilities[]" value="{{ $item }}" />
                                        <span>{{ $item }}</span>
                                        <button type="button" onclick="this.parentElement.remove()" class="text-error hover:text-error-hover text-sm font-bold ml-1 cursor-pointer">×</button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 6: Unggah Gambar Sampul / Poster Pelatihan (Direct Upload) -->
            <div>
                <h3 class="font-headline text-sm font-bold text-primary mb-3 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">image</span>
                    <span>6. Gambar Sampul &amp; Banner Pelatihan</span>
                </h3>

                <div class="p-5 rounded-2xl bg-surface-container-low border border-outline-variant/60 space-y-4">
                    <div>
                        <label class="block font-headline text-xs font-bold text-primary mb-1">
                            Unggah Gambar Poster / Sampul Pelatihan
                        </label>
                        <p class="text-[11px] text-outline">
                            Format yang didukung: JPG, JPEG, PNG, atau WEBP. Maksimal ukuran file 10MB. Rekomendasi rasio 16:9 atau poster banner untuk tampilan menarik di katalog publik.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                        <!-- Image Preview Box -->
                        <div class="relative group shrink-0">
                            <div id="thumbnail-preview-container" class="w-44 h-28 sm:w-52 sm:h-32 rounded-2xl bg-surface-container-high border-2 border-dashed border-outline-variant/80 overflow-hidden flex items-center justify-center shadow-2xs">
                                <img id="thumbnail-preview-img" src="" alt="Preview Poster Pelatihan" class="w-full h-full object-cover hidden" />
                                <div id="thumbnail-preview-placeholder" class="text-center p-3 text-outline">
                                    <span class="material-symbols-outlined text-3xl mb-1 text-outline/70">add_photo_alternate</span>
                                    <span class="text-[10px] block font-semibold">Pilih Berkas Gambar</span>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Controls -->
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-2.5 flex-wrap">
                                <label for="thumbnail" 
                                       class="px-4 py-2 bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold rounded-xl shadow-2xs transition-all flex items-center gap-1.5 cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px]">upload</span>
                                    <span>Pilih Berkas Gambar</span>
                                </label>
                                <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="handleThumbnailPreview(this)" />
                                
                                <button type="button" id="btn-remove-thumbnail" onclick="removeThumbnailSelection()" class="hidden px-3 py-2 border border-outline-variant/60 rounded-xl text-xs font-semibold text-error hover:bg-error-container/20 transition-colors">
                                    Hapus
                                </button>
                            </div>
                            <span id="thumbnail-filename" class="text-[11px] text-on-surface-variant font-medium block">
                                Belum ada berkas gambar yang dipilih.
                            </span>
                            @error('thumbnail')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 6: Penugasan Tentor Pengampu (ADM-07) -->
            <div>
                <h3 class="font-headline text-sm font-bold text-primary mb-3 pb-2 border-b border-outline-variant/40 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px] text-secondary">co_present</span>
                    <span>7. Penugasan Instruktur / Tentor Pengampu (ADM-07)</span>
                </h3>

                <p class="text-xs text-on-surface-variant mb-3">
                    Pilih satu atau beberapa tentor yang bertugas mengajar dan mengisi modul ajar pada pelatihan ini.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @forelse($tentors as $tentor)
                    <label class="flex items-start gap-3 p-3 rounded-xl border border-outline-variant/60 bg-surface-container-low hover:bg-surface-container cursor-pointer transition-colors has-[:checked]:bg-secondary-fixed has-[:checked]:border-secondary">
                        <input type="checkbox" name="instructors[]" value="{{ $tentor->id }}" 
                            {{ in_array($tentor->id, old('instructors', [])) ? 'checked' : '' }}
                            class="mt-0.5 rounded text-secondary focus:ring-secondary" />
                        <div class="min-w-0">
                            <div class="font-headline text-xs font-bold text-primary truncate">{{ $tentor->name }}</div>
                            <div class="text-[11px] text-outline truncate">{{ $tentor->expertise ?? 'Instruktur' }}</div>
                        </div>
                    </label>
                    @empty
                    <div class="sm:col-span-3 p-4 bg-surface-container-low rounded-xl text-center text-outline text-xs">
                        Belum ada tentor terdaftar. Anda dapat membuat akun tentor terlebih dahulu melalui menu 
                        <a href="{{ route('admin.tentor.create') }}" class="text-secondary font-bold underline">Buat Akun Tentor</a>.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="pt-4 border-t border-outline-variant/40 flex items-center justify-end gap-3">
                <a href="{{ route('admin.trainings.index') }}" class="px-5 py-2.5 rounded-xl border border-outline-variant/60 text-xs font-bold text-on-surface-variant hover:bg-surface-container transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold shadow-xs transition-all flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[18px]">check</span>
                    <span>Terbitkan Pelatihan</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function handleModeChange(mode) {
    const meetingContainer = document.getElementById('meetingUrlContainer');
    const locationContainer = document.getElementById('locationContainer');
    const meetingInput = document.getElementById('meeting_url');
    const locationInput = document.getElementById('location');

    if (mode === 'online') {
        meetingContainer.style.display = 'block';
        locationContainer.style.display = 'none';
        meetingInput.required = true;
        locationInput.required = false;
    } else if (mode === 'offline') {
        meetingContainer.style.display = 'none';
        locationContainer.style.display = 'block';
        meetingInput.required = false;
        locationInput.required = true;
    } else { // blended
        meetingContainer.style.display = 'block';
        locationContainer.style.display = 'block';
        meetingInput.required = false;
        locationInput.required = false;
    }
}

function handlePriceTypeChange(isFree) {
    const priceContainer = document.getElementById('priceContainer');
    const priceInput = document.getElementById('price');
    const priceReadable = document.getElementById('priceReadable');

    if (isFree) {
        priceContainer.classList.add('hidden');
        priceContainer.classList.remove('block');
        priceInput.value = 0;
        if (priceReadable) priceReadable.innerText = '';
    } else {
        priceContainer.classList.remove('hidden');
        priceContainer.classList.add('block');
        if (priceInput.value == 0) {
            priceInput.value = '';
        }
        priceInput.focus();
        updatePriceReadable(priceInput.value);
    }
}

function updatePriceReadable(val) {
    const priceReadable = document.getElementById('priceReadable');
    if (!priceReadable) return;
    
    const num = parseInt(val, 10);
    if (!isNaN(num) && num > 0) {
        priceReadable.innerText = 'Terbaca: Rp ' + num.toLocaleString('id-ID');
    } else {
        priceReadable.innerText = '';
    }
}

function handleThumbnailPreview(input) {
    const previewContainer = document.getElementById('thumbnail-preview-container');
    const previewImg = document.getElementById('thumbnail-preview-img');
    const placeholder = document.getElementById('thumbnail-preview-placeholder');
    const filenameLabel = document.getElementById('thumbnail-filename');
    const removeBtn = document.getElementById('btn-remove-thumbnail');

    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Guard size max 10MB
        if (file.size > 10 * 1024 * 1024) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ukuran Gambar Terlalu Besar',
                    text: 'Ukuran berkas gambar (' + (file.size / (1024 * 1024)).toFixed(1) + 'MB) melebihi batas maksimal 10MB. Silakan pilih berkas gambar yang lebih ringkas.',
                    confirmButtonColor: '#10b981'
                });
            } else {
                alert('Ukuran berkas gambar maksimal 10MB.');
            }
            input.value = '';
            return;
        }

        const objectUrl = URL.createObjectURL(file);
        previewImg.src = objectUrl;
        previewImg.classList.remove('hidden');
        placeholder.classList.add('hidden');
        previewContainer.classList.remove('border-dashed');

        filenameLabel.innerText = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        removeBtn.classList.remove('hidden');
    }
}

function removeThumbnailSelection() {
    const input = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('thumbnail-preview-container');
    const previewImg = document.getElementById('thumbnail-preview-img');
    const placeholder = document.getElementById('thumbnail-preview-placeholder');
    const filenameLabel = document.getElementById('thumbnail-filename');
    const removeBtn = document.getElementById('btn-remove-thumbnail');

    input.value = '';
    previewImg.src = '';
    previewImg.classList.add('hidden');
    placeholder.classList.remove('hidden');
    previewContainer.classList.add('border-dashed');

    filenameLabel.innerText = 'Belum ada berkas gambar yang dipilih.';
    removeBtn.classList.add('hidden');
}

function addCustomFacility() {
    const input = document.getElementById('customFacilityInput');
    const container = document.getElementById('customFacilitiesContainer');
    if (!input || !container) return;

    const val = input.value.trim();
    if (!val) return;

    // Check if duplicate already exists
    const existing = container.querySelectorAll('input[name="facilities[]"]');
    for (let el of existing) {
        if (el.value.toLowerCase() === val.toLowerCase()) {
            input.value = '';
            return;
        }
    }

    const chip = document.createElement('div');
    chip.className = 'custom-facility-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-surface-container-lowest border border-secondary text-primary font-headline text-xs font-semibold shadow-2xs';
    
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'facilities[]';
    hiddenInput.value = val;

    const textSpan = document.createElement('span');
    textSpan.textContent = val;

    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'text-error hover:text-error-hover text-sm font-bold ml-1 cursor-pointer';
    removeBtn.textContent = '×';
    removeBtn.onclick = function() { chip.remove(); };

    chip.appendChild(hiddenInput);
    chip.appendChild(textSpan);
    chip.appendChild(removeBtn);

    container.appendChild(chip);
    input.value = '';
}

// Initial setup on load
document.addEventListener('DOMContentLoaded', () => {
    const activeMode = document.querySelector('input[name="mode"]:checked');
    if (activeMode) {
        handleModeChange(activeMode.value);
    }

    const priceInput = document.getElementById('price');
    if (priceInput && priceInput.value > 0) {
        updatePriceReadable(priceInput.value);
    }
});
</script>
@endsection
