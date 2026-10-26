@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-24 pb-16 bg-surface min-h-[calc(100vh-80px)] flex flex-col justify-center">
    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb / Kembali -->
        <div class="mb-6">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-on-surface-variant hover:text-secondary transition-colors group">
                <span class="material-symbols-outlined text-[18px] transition-transform group-hover:-translate-x-1">arrow_back</span>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Card Container Grid Dual-Column -->
        <div class="w-full grid grid-cols-1 lg:grid-cols-12 rounded-2xl overflow-hidden shadow-xl bg-surface-container-lowest border border-outline-variant/60">
            
            <!-- Sisi Kiri: Formulir Autentikasi (lg:col-span-7) -->
            <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-between">
                <div class="w-full max-w-lg mx-auto flex flex-col">
                    
                    <!-- Logo & Header Brand -->
                    <div class="flex items-center gap-3.5 mb-8">
                        <img src="{{ asset('img/logo.png') }}" alt="Akademi Pelatihan Logo" class="h-11 w-auto object-contain rounded-xl shadow-xs" />
                        <div class="flex flex-col">
                            <span class="font-headline text-lg sm:text-xl font-bold text-primary tracking-tight leading-tight">
                                Akademi Pelatihan
                            </span>
                            <span class="font-mono text-[10px] sm:text-[11px] font-semibold text-outline uppercase tracking-wider">
                                Portal Autentikasi Resmi
                            </span>
                        </div>
                    </div>

                    <!-- Headline Sambutan -->
                    <div class="mb-8">
                        <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-on-surface mb-2 tracking-tight">
                            Selamat Datang Kembali
                        </h1>
                        <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed">
                            Masuk ke portal pembelajaran dan pantau agenda pelatihan serta sertifikat kompetensi Anda secara terpadu.
                        </p>
                    </div>

                    <!-- Form Login -->
                    <form class="flex flex-col gap-5" id="loginForm" action="{{ url('/login') }}" method="POST">
                        @csrf

                        <!-- Email Field -->
                        <div class="flex flex-col gap-1.5">
                            <label class="font-headline text-xs font-bold text-on-surface" for="email">
                                Alamat Email <span class="text-error">*</span>
                            </label>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">mail</span>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       required 
                                       autocomplete="email"
                                       value="{{ old('email') }}"
                                       placeholder="nama@instansi.ac.id atau email Anda" 
                                       class="w-full pl-11 pr-4 py-3 rounded-lg bg-surface-container-low text-on-surface placeholder:text-outline text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                            </div>
                            @error('email')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center justify-between">
                                <label class="font-headline text-xs font-bold text-on-surface" for="password">
                                    Kata Sandi <span class="text-error">*</span>
                                </label>
                                <a href="javascript:void(0)" onclick="alertLupaSandi()" class="text-xs font-semibold text-secondary hover:underline">
                                    Lupa kata sandi?
                                </a>
                            </div>
                            <div class="relative flex items-center">
                                <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">lock</span>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="Masukkan kata sandi" 
                                       class="w-full pl-11 pr-11 py-3 rounded-lg bg-surface-container-low text-on-surface placeholder:text-outline text-xs sm:text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-secondary/40 border border-transparent font-medium transition-all" />
                                <button type="button" 
                                        id="togglePassword" 
                                        class="absolute right-3.5 p-1 text-outline hover:text-on-surface focus:outline-none flex items-center justify-center transition-colors cursor-pointer"
                                        aria-label="Tampilkan atau sembunyikan kata sandi">
                                    <span class="material-symbols-outlined text-[20px]" id="eyeIcon">visibility</span>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs text-error font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Options: Remember Me -->
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" 
                                       name="remember" 
                                       id="remember" 
                                       class="w-4 h-4 rounded text-secondary bg-surface-container-low focus:ring-secondary border-outline-variant cursor-pointer" />
                                <span class="text-xs sm:text-sm text-on-surface-variant">Ingat saya di perangkat ini</span>
                            </label>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                    id="submitBtn" 
                                    class="w-full py-3.5 px-6 rounded-lg bg-secondary hover:bg-secondary-container text-white font-headline text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group cursor-pointer">
                                <span>Masuk ke Akun</span>
                                <span class="material-symbols-outlined text-[18px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                            </button>
                        </div>

                    </form>

                    <!-- Register Link Box -->
                    <div class="mt-8 p-4 rounded-xl bg-surface-container-low text-center flex flex-col sm:flex-row items-center justify-center gap-1.5 border border-outline-variant/40">
                        <span class="text-xs sm:text-sm text-on-surface-variant">Belum memiliki akun peserta?</span>
                        <a href="{{ url('/register') }}" class="text-xs sm:text-sm text-secondary hover:text-secondary-container font-bold underline">
                            Daftar Akun Baru Sekarang
                        </a>
                    </div>

                    <!-- Security Badge -->
                    <div class="mt-6 flex items-center justify-center gap-2 text-outline text-xs">
                        <span class="material-symbols-outlined text-[16px]">lock</span>
                        <span>Kanal login terenkripsi SSL 256-bit standar ISO/IEC 27001</span>
                    </div>

                </div>
            </div>

            <!-- Sisi Kanan: Visual & Value Proposition (Navy Primary Container) -->
            <div class="lg:col-span-5 relative bg-primary-container text-white p-6 sm:p-10 lg:p-12 flex flex-col justify-between overflow-hidden">
                
                <!-- Ambient Background Gradients -->
                <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-secondary opacity-25 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -left-24 w-72 h-72 rounded-full bg-tertiary-fixed-dim opacity-20 blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <!-- Quality Assurance Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md mb-8 self-start border border-white/15">
                        <span class="material-symbols-outlined text-tertiary-fixed-dim text-[16px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        <span class="text-xs font-semibold text-white tracking-wide uppercase">Terakreditasi BPSDM &amp; Kemendikbud</span>
                    </div>

                    <!-- Hero Highlight Card -->
                    <div class="mb-8">
                        <h2 class="font-headline text-xl sm:text-2xl font-extrabold text-white leading-snug mb-3">
                            Tingkatkan Kompetensi Pendidik &amp; Tenaga Profesional Bersama 15.000+ Alumni di Seluruh Indonesia.
                        </h2>
                        <p class="text-xs sm:text-sm text-on-primary-container leading-relaxed">
                            Bergabunglah dalam ekosistem terpadu pelatihan terstruktur, penilaian berkala, serta modul sertifikasi standar nasional.
                        </p>
                    </div>

                    <!-- 3 Poin Keuntungan -->
                    <div class="flex flex-col gap-4 mb-8">
                        <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                            <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center shrink-0 text-white shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">auto_stories</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-headline text-sm font-bold text-white">Akses Materi &amp; Silabus Terkini</span>
                                <span class="text-xs text-on-primary-container mt-0.5 leading-relaxed">Modul berbasis Kurikulum Merdeka dan standar kompetensi industri teranyar.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                            <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center shrink-0 text-white shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">qr_code_2</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-headline text-sm font-bold text-white">Sertifikasi Resmi Ber-Barcode</span>
                                <span class="text-xs text-on-primary-container mt-0.5 leading-relaxed">Verifikasi legalitas sertifikat secara publik dengan kode verifikasi unik.</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 p-3 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
                            <div class="w-10 h-10 rounded-lg bg-secondary flex items-center justify-center shrink-0 text-white shadow-sm">
                                <span class="material-symbols-outlined text-[20px]">forum</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-headline text-sm font-bold text-white">Konsultasi Pakar Kurikulum</span>
                                <span class="text-xs text-on-primary-container mt-0.5 leading-relaxed">Sesi klinik dan bimbingan langsung dengan instruktur bersertifikasi nasional.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metric and Testimonial Footer -->
                <div class="relative z-10 pt-4 mt-auto border-t border-white/10">
                    <div class="p-4 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-between border border-white/10">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2 overflow-hidden">
                                <div class="inline-block h-8 w-8 rounded-full ring-2 ring-primary-container bg-surface-container flex items-center justify-center text-primary font-bold text-xs">8k</div>
                                <div class="inline-block h-8 w-8 rounded-full ring-2 ring-primary-container bg-secondary text-white flex items-center justify-center text-xs font-bold">Guru</div>
                                <div class="inline-block h-8 w-8 rounded-full ring-2 ring-primary-container bg-tertiary-fixed text-primary flex items-center justify-center text-xs font-bold">ASN</div>
                            </div>
                            <div class="flex flex-col">
                                <span class="font-headline text-xs font-bold text-white">Tingkat Kelulusan 98.4%</span>
                                <span class="text-[11px] text-on-primary-container">Dari 420+ Angkatan Terdaftar</span>
                            </div>
                        </div>
                        <div class="flex items-center text-amber-300">
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star</span>
                            <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">star_half</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const toggleBtn = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    if (toggleBtn && passwordInput && eyeIcon) {
        toggleBtn.addEventListener('click', function () {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            eyeIcon.textContent = isPassword ? 'visibility_off' : 'visibility';
        });
    }
});

function alertLupaSandi() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: 'info',
            title: 'Pemulihan Kata Sandi',
            html: '<p class="text-sm text-gray-600">Silakan hubungi administrator instansi Anda atau kirim pesan bantuan ke tim layanan melalui halaman <a href="{{ url('/kontak') }}" class="text-blue-600 font-bold underline">Kontak Layanan</a>.</p>',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#0051d5'
        });
    } else {
        alert('Untuk pemulihan kata sandi, silakan hubungi tim layanan melalui halaman Kontak.');
    }
}
</script>
@endsection
