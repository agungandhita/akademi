@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-24 pb-16 bg-surface">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Navigasi Kembali & Badge Status -->
        <div class="flex items-center justify-between mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-secondary font-headline text-xs sm:text-sm font-bold hover:text-secondary-container transition-colors group">
                <span class="material-symbols-outlined text-[18px] transition-transform group-hover:-translate-x-1">arrow_back</span>
                <span>Kembali ke Beranda</span>
            </a>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold shadow-xs">
                <span class="material-symbols-outlined text-[14px]">security</span>
                <span>Portal Resmi Terverifikasi</span>
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
            
            <!-- Sisi Kiri: Formulir Registrasi (lg:col-span-7) -->
            <div class="lg:col-span-7 bg-surface-container-lowest rounded-2xl shadow-xl p-6 sm:p-8 lg:p-10 border border-outline-variant/60 flex flex-col justify-between">
                <div>
                    <!-- Logo & Brand Header -->
                    <div class="flex items-center gap-3.5 mb-6">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo Akademi Pelatihan" class="h-11 w-auto object-contain rounded-xl shadow-xs" />
                        <div class="flex flex-col">
                            <span class="font-headline text-lg sm:text-xl font-bold text-primary tracking-tight leading-tight">
                                Akademi Pelatihan
                            </span>
                            <span class="font-mono text-[10px] sm:text-[11px] font-semibold text-on-surface-variant uppercase tracking-wider">
                                Registrasi Akun Peserta
                            </span>
                        </div>
                    </div>

                    <div class="space-y-2 mb-8">
                        <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-on-surface tracking-tight">
                            Daftar Akun Akademi Pelatihan
                        </h1>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Bergabung bersama puluhan ribu pendidik, praktisi, dan profesional di Indonesia untuk mengakselerasi kompetensi bersertifikasi nasional.
                        </p>
                    </div>

                    <!-- Form Registrasi -->
                    <form class="space-y-6" id="form-registrasi" action="{{ url('/register') }}" method="POST">
                        @csrf

                        <!-- Field 1: Nama Lengkap -->
                        <div class="space-y-1.5">
                            <label class="block font-headline text-xs font-bold text-on-surface" for="name">
                                Nama Lengkap (beserta gelar jika ada) <span class="text-error">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                    <span class="material-symbols-outlined text-[20px]">badge</span>
                                </div>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       required 
                                       value="{{ old('name') }}"
                                       placeholder="Contoh: Dr. Budi Santoso, M.Pd" 
                                       class="w-full pl-11 pr-4 py-3 bg-surface-container-low rounded-lg text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                            </div>
                            <p class="text-[11px] text-on-surface-variant">Nama ini akan dicetak langsung pada sertifikat resmi Anda.</p>
                            @error('name')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Field 2 & 3: Kontak (Email & WhatsApp) Grid 2 Kolom -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Field 2: Email -->
                            <div class="space-y-1.5">
                                <label class="block font-headline text-xs font-bold text-on-surface" for="email">
                                    Alamat Email Aktif <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                        <span class="material-symbols-outlined text-[20px]">alternate_email</span>
                                    </div>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           required 
                                           value="{{ old('email') }}"
                                           autocomplete="email"
                                           placeholder="email.aktif@instansi.ac.id" 
                                           class="w-full pl-11 pr-4 py-3 bg-surface-container-low rounded-lg text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                </div>
                                @error('email')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Field 3: WhatsApp -->
                            <div class="space-y-1.5">
                                <label class="block font-headline text-xs font-bold text-on-surface" for="phone">
                                    Nomor WhatsApp / HP <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                        <span class="material-symbols-outlined text-[20px]">call</span>
                                    </div>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone" 
                                           required 
                                           value="{{ old('phone') }}"
                                           placeholder="0812-3456-7890" 
                                           class="w-full pl-11 pr-4 py-3 bg-surface-container-low rounded-lg text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                </div>
                                @error('phone')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Field 4: Segmented Radio Cards (Jenis Pengguna) -->
                        <div class="space-y-2">
                            <label class="block font-headline text-xs font-bold text-on-surface">
                                Pilih Kategori Kepesertaan <span class="text-error">*</span>
                            </label>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="role-selector">
                                @php
                                    $selectedRole = old('participant_type', 'Guru & Tenaga Pendidik');
                                @endphp

                                <!-- Role 1: Guru -->
                                <label class="relative flex items-center p-3.5 rounded-xl cursor-pointer transition-all role-card {{ $selectedRole == 'Guru & Tenaga Pendidik' ? 'bg-surface-container-low border-2 border-secondary/50 shadow-xs' : 'bg-surface border border-outline-variant/60 hover:bg-surface-container-low' }}">
                                    <input type="radio" 
                                           name="participant_type" 
                                           value="Guru & Tenaga Pendidik" 
                                           class="sr-only role-input" 
                                           {{ $selectedRole == 'Guru & Tenaga Pendidik' ? 'checked' : '' }} />
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center mr-3 role-icon-bg transition-colors {{ $selectedRole == 'Guru & Tenaga Pendidik' ? 'bg-secondary text-white' : 'bg-surface-container text-on-surface-variant' }}">
                                        <span class="material-symbols-outlined text-[20px]">school</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline text-xs sm:text-sm font-bold text-on-surface">Guru &amp; Pendidik</span>
                                        <span class="text-[11px] text-on-surface-variant">PAUD, SD, SMP, SMA/SMK</span>
                                    </div>
                                    <span class="material-symbols-outlined ml-auto text-[20px] check-indicator {{ $selectedRole == 'Guru & Tenaga Pendidik' ? 'text-secondary' : 'text-outline-variant' }}">
                                        {{ $selectedRole == 'Guru & Tenaga Pendidik' ? 'check_circle' : 'radio_button_unchecked' }}
                                    </span>
                                </label>

                                <!-- Role 2: Praktisi -->
                                <label class="relative flex items-center p-3.5 rounded-xl cursor-pointer transition-all role-card {{ $selectedRole == 'Profesional & Praktisi' ? 'bg-surface-container-low border-2 border-secondary/50 shadow-xs' : 'bg-surface border border-outline-variant/60 hover:bg-surface-container-low' }}">
                                    <input type="radio" 
                                           name="participant_type" 
                                           value="Profesional & Praktisi" 
                                           class="sr-only role-input" 
                                           {{ $selectedRole == 'Profesional & Praktisi' ? 'checked' : '' }} />
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center mr-3 role-icon-bg transition-colors {{ $selectedRole == 'Profesional & Praktisi' ? 'bg-secondary text-white' : 'bg-surface-container text-on-surface-variant' }}">
                                        <span class="material-symbols-outlined text-[20px]">business_center</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline text-xs sm:text-sm font-bold text-on-surface">Profesional &amp; Praktisi</span>
                                        <span class="text-[11px] text-on-surface-variant">Korporasi, Konsultan, Dosen</span>
                                    </div>
                                    <span class="material-symbols-outlined ml-auto text-[20px] check-indicator {{ $selectedRole == 'Profesional & Praktisi' ? 'text-secondary' : 'text-outline-variant' }}">
                                        {{ $selectedRole == 'Profesional & Praktisi' ? 'check_circle' : 'radio_button_unchecked' }}
                                    </span>
                                </label>

                                <!-- Role 3: Mahasiswa / Pelajar -->
                                <label class="relative flex items-center p-3.5 rounded-xl cursor-pointer transition-all role-card {{ $selectedRole == 'Mahasiswa / Pelajar' ? 'bg-surface-container-low border-2 border-secondary/50 shadow-xs' : 'bg-surface border border-outline-variant/60 hover:bg-surface-container-low' }}">
                                    <input type="radio" 
                                           name="participant_type" 
                                           value="Mahasiswa / Pelajar" 
                                           class="sr-only role-input" 
                                           {{ $selectedRole == 'Mahasiswa / Pelajar' ? 'checked' : '' }} />
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center mr-3 role-icon-bg transition-colors {{ $selectedRole == 'Mahasiswa / Pelajar' ? 'bg-secondary text-white' : 'bg-surface-container text-on-surface-variant' }}">
                                        <span class="material-symbols-outlined text-[20px]">local_library</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline text-xs sm:text-sm font-bold text-on-surface">Siswa &amp; Mahasiswa</span>
                                        <span class="text-[11px] text-on-surface-variant">SMP, SMA, SMK &amp; Kampus</span>
                                    </div>
                                    <span class="material-symbols-outlined ml-auto text-[20px] check-indicator {{ $selectedRole == 'Mahasiswa / Pelajar' ? 'text-secondary' : 'text-outline-variant' }}">
                                        {{ $selectedRole == 'Mahasiswa / Pelajar' ? 'check_circle' : 'radio_button_unchecked' }}
                                    </span>
                                </label>

                                <!-- Role 4: Umum -->
                                <label class="relative flex items-center p-3.5 rounded-xl cursor-pointer transition-all role-card {{ $selectedRole == 'Masyarakat Umum' ? 'bg-surface-container-low border-2 border-secondary/50 shadow-xs' : 'bg-surface border border-outline-variant/60 hover:bg-surface-container-low' }}">
                                    <input type="radio" 
                                           name="participant_type" 
                                           value="Masyarakat Umum" 
                                           class="sr-only role-input" 
                                           {{ $selectedRole == 'Masyarakat Umum' ? 'checked' : '' }} />
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center mr-3 role-icon-bg transition-colors {{ $selectedRole == 'Masyarakat Umum' ? 'bg-secondary text-white' : 'bg-surface-container text-on-surface-variant' }}">
                                        <span class="material-symbols-outlined text-[20px]">groups</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-headline text-xs sm:text-sm font-bold text-on-surface">Masyarakat Umum</span>
                                        <span class="text-[11px] text-on-surface-variant">Vokasi &amp; Pegiat Literasi</span>
                                    </div>
                                    <span class="material-symbols-outlined ml-auto text-[20px] check-indicator {{ $selectedRole == 'Masyarakat Umum' ? 'text-secondary' : 'text-outline-variant' }}">
                                        {{ $selectedRole == 'Masyarakat Umum' ? 'check_circle' : 'radio_button_unchecked' }}
                                    </span>
                                </label>
                            </div>
                            @error('participant_type')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Field 5: Asal Lembaga / Instansi -->
                        <div class="space-y-1.5">
                            <label class="block font-headline text-xs font-bold text-on-surface" for="institution">
                                Sekolah / Instansi / Lembaga Asal <span class="text-error">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                    <span class="material-symbols-outlined text-[20px]">apartment</span>
                                </div>
                                <input type="text" 
                                       id="institution" 
                                       name="institution" 
                                       required 
                                       value="{{ old('institution') }}"
                                       placeholder="Contoh: SMAN 1 Bandung / Dinas Pendidikan / Mandiri" 
                                       class="w-full pl-11 pr-4 py-3 bg-surface-container-low rounded-lg text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                            </div>
                            @error('institution')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Field 6 & 7: Kata Sandi & Konfirmasi Sandi Grid 2 Kolom -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Kata Sandi -->
                            <div class="space-y-1.5">
                                <label class="block font-headline text-xs font-bold text-on-surface" for="password">
                                    Kata Sandi <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                        <span class="material-symbols-outlined text-[20px]">lock</span>
                                    </div>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           minlength="8" 
                                           required 
                                           placeholder="Min. 8 Karakter" 
                                           oninput="evalPasswordStrength(this.value)"
                                           class="w-full pl-11 pr-11 py-3 bg-surface-container-low rounded-lg text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                    <button type="button" 
                                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-outline hover:text-on-surface cursor-pointer"
                                            onclick="togglePasswordVisibility('password', this)"
                                            aria-label="Tampilkan sandi">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                </div>
                                
                                <!-- Indikator Kekuatan Password -->
                                <div class="space-y-1 pt-1">
                                    <div class="flex items-center justify-between text-[11px]">
                                        <span class="text-on-surface-variant">Kekuatan Sandi:</span>
                                        <span class="text-outline font-semibold" id="strength-label">Belum Diisi</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-surface-container rounded-full overflow-hidden flex">
                                        <div class="h-full bg-outline-variant w-0 transition-all duration-300" id="strength-bar"></div>
                                    </div>
                                </div>
                                @error('password')
                                    <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Konfirmasi Sandi -->
                            <div class="space-y-1.5">
                                <label class="block font-headline text-xs font-bold text-on-surface" for="confirm-password">
                                    Konfirmasi Sandi <span class="text-error">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-outline">
                                        <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                                    </div>
                                    <input type="password" 
                                           id="confirm-password" 
                                           name="password_confirmation" 
                                           required 
                                           placeholder="Ulangi Kata Sandi" 
                                           oninput="checkPasswordMatch()"
                                           class="w-full pl-11 pr-11 py-3 bg-surface-container-low rounded-lg text-xs sm:text-sm text-on-surface placeholder:text-outline focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                    <button type="button" 
                                            class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-outline hover:text-on-surface cursor-pointer"
                                            onclick="togglePasswordVisibility('confirm-password', this)"
                                            aria-label="Tampilkan konfirmasi sandi">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                </div>
                                
                                <!-- Status Kecocokan -->
                                <div class="flex items-center gap-1.5 pt-1 text-[11px]" id="match-status-container">
                                    <span class="material-symbols-outlined text-[16px] text-outline" id="match-icon">help_outline</span>
                                    <span class="text-outline" id="match-text">Pastikan kata sandi sama persis</span>
                                </div>
                            </div>
                        </div>

                        <!-- Field 8: Persetujuan Kebijakan -->
                        <div class="pt-2">
                            <label class="flex items-start gap-3 cursor-pointer group select-none">
                                <div class="pt-0.5">
                                    <input type="checkbox" 
                                           id="terms" 
                                           name="terms" 
                                           required 
                                           class="w-4 h-4 rounded text-secondary focus:ring-secondary border-outline-variant cursor-pointer" />
                                </div>
                                <span class="text-xs text-on-surface-variant leading-relaxed">
                                    Saya menyetujui <a href="{{ url('/kontak') }}" class="text-secondary font-semibold hover:underline">Syarat &amp; Ketentuan Layanan</a> serta perlindungan data sesuai standar <a href="{{ url('/kontak') }}" class="text-secondary font-semibold hover:underline">Kebijakan Privasi</a> Akademi Pelatihan.
                                </span>
                            </label>
                        </div>

                        <!-- Tombol Aksi Utama -->
                        <div class="pt-3 space-y-4">
                            <button type="submit" 
                                    id="submitBtn" 
                                    class="w-full py-3.5 px-6 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 cursor-pointer">
                                <span>Buat Akun Sekarang</span>
                                <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                            </button>

                            <div class="text-center">
                                <p class="text-xs sm:text-sm text-on-surface-variant">
                                    Sudah memiliki akun terdaftar? 
                                    <a href="{{ url('/login') }}" class="text-secondary font-bold hover:text-secondary-container transition-colors ml-1">
                                        Masuk di sini
                                    </a>
                                </p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Sisi Kanan: Educational Banner & Step Flow (Navy Theme Primary Container) -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                
                <!-- Kartu Utama Sisi Kanan -->
                <div class="bg-primary-container text-white rounded-2xl p-6 sm:p-8 shadow-xl relative overflow-hidden flex flex-col justify-between border border-primary/20">
                    
                    <!-- Ornamen Geometris Latar Belakang -->
                    <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-secondary-container/20 pointer-events-none blur-3xl"></div>
                    <div class="absolute -left-12 -bottom-12 w-48 h-48 rounded-full bg-tertiary-fixed-dim/20 pointer-events-none blur-2xl"></div>

                    <div class="relative z-10">
                        <!-- Header Banner -->
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-tertiary-fixed-dim text-[22px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                            <span class="font-headline text-xs text-tertiary-fixed-dim uppercase tracking-wider font-bold">Standardisasi Kemendikbudristek</span>
                        </div>

                        <h2 class="font-headline text-xl sm:text-2xl text-white font-extrabold mb-3 leading-snug">
                            Langkah Mudah Memulai Pelatihan
                        </h2>
                        <p class="text-xs sm:text-sm text-on-primary-container mb-8 leading-relaxed">
                            Tingkatkan jenjang karier profesional dan angka kredit pendidik melalui kurikulum terstruktur dan bimbingan fasilitator nasional.
                        </p>

                        <!-- 3 Langkah Alur Singkat -->
                        <div class="space-y-6">
                            <!-- Langkah 1 -->
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-secondary text-white flex items-center justify-center font-headline text-base font-bold flex-shrink-0 shadow-sm">
                                    1
                                </div>
                                <div>
                                    <h3 class="font-headline text-sm text-white font-bold">Lengkapi Profil &amp; Kategori</h3>
                                    <p class="text-xs text-on-primary-container mt-1 leading-relaxed">
                                        Isi data diri yang valid untuk keperluan penerbitan nomor registrasi e-sertifikat resmi.
                                    </p>
                                </div>
                            </div>

                            <!-- Langkah 2 -->
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-secondary text-white flex items-center justify-center font-headline text-base font-bold flex-shrink-0 shadow-sm">
                                    2
                                </div>
                                <div>
                                    <h3 class="font-headline text-sm text-white font-bold">Pilih Agenda Workshop / Diklat</h3>
                                    <p class="text-xs text-on-primary-container mt-1 leading-relaxed">
                                        Akses ratusan modul Kurikulum Merdeka, teknologi digital pembelajaran, dan kepemimpinan sekolah.
                                    </p>
                                </div>
                            </div>

                            <!-- Langkah 3 -->
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-secondary text-white flex items-center justify-center font-headline text-base font-bold flex-shrink-0 shadow-sm">
                                    3
                                </div>
                                <div>
                                    <h3 class="font-headline text-sm text-white font-bold">Dapatkan Tiket &amp; E-Sertifikat</h3>
                                    <p class="text-xs text-on-primary-container mt-1 leading-relaxed">
                                        Sertifikat resmi dilengkapi QR Code verifikasi nasional dan rincian Jam Pelajaran (JP).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Mini Sertifikat Terverifikasi -->
                    <div class="relative z-10 mt-8 pt-6 border-t border-white/10">
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 flex flex-col gap-3 border border-white/10">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-[20px]">workspace_premium</span>
                                    <span class="font-headline text-xs text-white tracking-wide font-bold">PREVIEW SERTIFIKAT RESMI</span>
                                </div>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-tertiary-fixed-dim/20 text-tertiary-fixed-dim">
                                    VALIDASI QR
                                </span>
                            </div>
                            <div class="flex items-center justify-between bg-primary/60 rounded-lg p-3 border border-white/10">
                                <div class="flex flex-col">
                                    <span class="text-[11px] text-on-primary-container">Nomor Registrasi Akreditasi:</span>
                                    <span class="text-xs sm:text-sm text-white font-mono tracking-wider font-bold">AP/2025/32JP-9941</span>
                                </div>
                                <!-- Inline SVG QR Code -->
                                <div class="w-10 h-10 bg-white rounded p-1 flex items-center justify-center shadow-xs">
                                    <svg class="w-full h-full text-primary" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M2 2h8v8H2V2zm2 2v4h4V4H4zm10-2h8v8h-8V2zm2 2v4h4V4h-4zM2 14h8v8H2v-8zm2 2v4h4v-4H4zm10 0h2v2h-2v-2zm4 0h4v2h-4v-2zm-4 4h2v4h-2v-4zm4 2h2v2h-2v-2zm2-2h2v2h-2v-2zM6 6h2v2H6V6zm12 0h2v2h-2V6zm-12 12h2v2H6v-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Kartu Informasi Bantuan Terpadu -->
                <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-md border border-outline-variant/60 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-[26px]">support_agent</span>
                    </div>
                    <div class="flex flex-col">
                        <h4 class="font-headline text-sm font-bold text-on-surface">Kendala saat mendaftar?</h4>
                        <p class="text-xs text-on-surface-variant mt-0.5">
                            Tim Layanan Pelatihan aktif mendampingi: 
                            <a href="{{ url('/kontak') }}" class="text-secondary font-semibold hover:underline block sm:inline">
                                Hubungi Layanan Kontak &rarr;
                            </a>
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<script>
// Segmented Radio selector toggle
document.addEventListener('DOMContentLoaded', function () {
    const roleCards = document.querySelectorAll('.role-card');
    roleCards.forEach(card => {
        card.addEventListener('click', function () {
            const input = this.querySelector('.role-input');
            if (input) {
                input.checked = true;
            }
            
            roleCards.forEach(c => {
                c.classList.remove('bg-surface-container-low', 'border-2', 'border-secondary/50', 'shadow-xs');
                c.classList.add('bg-surface', 'border', 'border-outline-variant/60');
                
                const icon = c.querySelector('.check-indicator');
                const iconBg = c.querySelector('.role-icon-bg');
                if (icon) {
                    icon.textContent = 'radio_button_unchecked';
                    icon.classList.remove('text-secondary');
                    icon.classList.add('text-outline-variant');
                }
                if (iconBg) {
                    iconBg.classList.remove('bg-secondary', 'text-white');
                    iconBg.classList.add('bg-surface-container', 'text-on-surface-variant');
                }
            });

            this.classList.remove('bg-surface', 'border-outline-variant/60');
            this.classList.add('bg-surface-container-low', 'border-2', 'border-secondary/50', 'shadow-xs');
            
            const currentIcon = this.querySelector('.check-indicator');
            const currentIconBg = this.querySelector('.role-icon-bg');
            if (currentIcon) {
                currentIcon.textContent = 'check_circle';
                currentIcon.classList.remove('text-outline-variant');
                currentIcon.classList.add('text-secondary');
            }
            if (currentIconBg) {
                currentIconBg.classList.remove('bg-surface-container', 'text-on-surface-variant');
                currentIconBg.classList.add('bg-secondary', 'text-white');
            }
        });
    });
});

// Toggle password visibility
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('.material-symbols-outlined');
    if (input && icon) {
        const isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');
        icon.textContent = isPassword ? 'visibility_off' : 'visibility';
    }
}

// Password strength evaluator
function evalPasswordStrength(password) {
    const label = document.getElementById('strength-label');
    const bar = document.getElementById('strength-bar');
    if (!label || !bar) return;

    if (!password || password.length === 0) {
        label.textContent = 'Belum Diisi';
        label.className = 'text-outline font-semibold';
        bar.style.width = '0%';
        bar.className = 'h-full bg-outline-variant w-0 transition-all duration-300';
        return;
    }

    let score = 0;
    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[^A-Za-z0-9]/.test(password)) score++;

    if (password.length < 8) {
        label.textContent = 'Terlalu Pendek';
        label.className = 'text-error font-semibold';
        bar.style.width = '25%';
        bar.className = 'h-full bg-error transition-all duration-300';
    } else if (score <= 2) {
        label.textContent = 'Sedang';
        label.className = 'text-amber-600 font-semibold';
        bar.style.width = '55%';
        bar.className = 'h-full bg-amber-500 transition-all duration-300';
    } else {
        label.textContent = 'Sangat Kuat';
        label.className = 'text-emerald-600 font-semibold';
        bar.style.width = '100%';
        bar.className = 'h-full bg-emerald-500 transition-all duration-300';
    }

    checkPasswordMatch();
}

// Password match checker
function checkPasswordMatch() {
    const pwd = document.getElementById('password');
    const confirm = document.getElementById('confirm-password');
    const icon = document.getElementById('match-icon');
    const text = document.getElementById('match-text');
    if (!pwd || !confirm || !icon || !text) return;

    if (!confirm.value) {
        icon.textContent = 'help_outline';
        icon.className = 'material-symbols-outlined text-[16px] text-outline';
        text.textContent = 'Pastikan kata sandi sama persis';
        text.className = 'text-outline';
        return;
    }

    if (pwd.value === confirm.value) {
        icon.textContent = 'check_circle';
        icon.className = 'material-symbols-outlined text-[16px] text-emerald-600';
        text.textContent = 'Kata sandi cocok';
        text.className = 'text-emerald-600 font-medium';
    } else {
        icon.textContent = 'cancel';
        icon.className = 'material-symbols-outlined text-[16px] text-error';
        text.textContent = 'Kata sandi belum cocok';
        text.className = 'text-error font-medium';
    }
}
</script>
@endsection
