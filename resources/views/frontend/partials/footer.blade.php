<!-- Stitch Credible Vanguard Footer -->
<footer class="w-full bg-primary-container text-white mt-auto border-t border-primary" id="kontak-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-12 mb-12">
            
            <!-- Brand Column (2 cols) -->
            <div class="lg:col-span-2 flex flex-col gap-4 pr-0 lg:pr-6">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/logo.png') }}" alt="Akademi Pelatihan Logo" class="h-10 w-auto object-contain bg-white rounded-lg p-1 shadow-sm" />
                    <span class="font-headline text-xl text-white font-bold">Akademi Pelatihan</span>
                </div>
                <p class="text-sm text-on-primary-container leading-relaxed">
                    Platform terpercaya untuk peningkatan kompetensi guru, tenaga pendidik, dan masyarakat umum dengan kurikulum standar nasional terakreditasi.
                </p>
                <div class="flex items-center gap-2 text-on-primary-container text-xs sm:text-sm pt-1">
                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-[20px]">verified</span>
                    <span class="font-medium">Sertifikasi Resmi Kementerian &amp; Mitra Industri</span>
                </div>
            </div>

            <!-- Program Kami -->
            <div class="flex flex-col gap-3">
                <span class="font-headline text-xs font-bold text-white tracking-wider uppercase mb-1">
                    Program Kami
                </span>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/agenda') }}">
                    Pelatihan Guru Inti
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/agenda') }}">
                    Sertifikasi Digital
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/agenda') }}">
                    Kepemimpinan Sekolah
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/agenda') }}">
                    Workshop Kurikulum Merdeka
                </a>
            </div>

            <!-- Navigasi -->
            <div class="flex flex-col gap-3">
                <span class="font-headline text-xs font-bold text-white tracking-wider uppercase mb-1">
                    Navigasi
                </span>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/') }}">
                    Beranda
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/agenda') }}">
                    Agenda Pelatihan
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/berita') }}">
                    Berita &amp; Artikel
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="{{ url('/kontak') }}">
                    Kontak Layanan
                </a>
            </div>

            <!-- Bantuan & Legal -->
            <div class="flex flex-col gap-3">
                <span class="font-headline text-xs font-bold text-white tracking-wider uppercase mb-1">
                    Bantuan &amp; Legal
                </span>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="#">
                    Pusat Bantuan
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="#">
                    Kebijakan Privasi
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="#">
                    Syarat &amp; Ketentuan
                </a>
                <a class="text-xs sm:text-sm text-on-primary-container hover:text-white transition-colors" href="#">
                    Verifikasi Sertifikat
                </a>
            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="pt-6 border-t border-primary/40 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-on-primary-container">
            <p>&copy; 2025-2026 Akademi Pelatihan Indonesia. Hak Cipta Dilindungi Undang-Undang.</p>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-white transition-colors">Privasi</a>
                <a href="#" class="hover:text-white transition-colors">Ketentuan</a>
                <a href="#" class="hover:text-white transition-colors">Sitemap</a>
            </div>
        </div>

    </div>
</footer>
