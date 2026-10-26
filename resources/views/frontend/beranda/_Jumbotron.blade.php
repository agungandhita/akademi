<section class="relative bg-gradient-to-b from-slate-900 via-blue-950 to-slate-900 text-white overflow-hidden py-16 md:py-24">
    <!-- Background Glow Effects -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-600/25 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 -right-40 w-96 h-96 bg-indigo-600/25 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Column: Copy & Actions -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <!-- Highlight Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 border border-blue-400/30 text-blue-300 text-xs sm:text-sm font-medium backdrop-blur-sm">
                    <span class="flex h-2 w-2 rounded-full bg-cyan-400 animate-ping"></span>
                    <span>Platform Pelatihan & Sertifikasi Profesional Terpercaya</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Akselerasi Karir Digital Anda Bersama 
                    <span class="block mt-1 bg-gradient-to-r from-blue-400 via-sky-300 to-indigo-300 bg-clip-text text-transparent">
                        Akademi Pelatihan
                    </span>
                </h1>

                <!-- Subtitle -->
                <p class="text-base sm:text-lg text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    Kuasai keterampilan teknologi paling dicari industri saat ini. Bimbingan langsung dari mentor praktisi teruji, proyek nyata portofolio, dan sertifikat berstandar kompetensi nasional.
                </p>

                <!-- CTA Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="{{ url('/register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-base font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 shadow-lg shadow-blue-500/25 transition-all duration-200 transform hover:-translate-y-0.5">
                        <span>Mulai Belajar Sekarang</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#program" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-xl text-base font-semibold text-slate-200 bg-slate-800/80 hover:bg-slate-700/80 border border-slate-700 transition-colors">
                        Lihat Program Kelas
                    </a>
                </div>

                <!-- Trust Badges & Metrics -->
                <div class="pt-8 border-t border-slate-800/80 grid grid-cols-2 sm:grid-cols-4 gap-6 text-center lg:text-left">
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-white">10.000+</p>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Alumni Lulus</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-sky-400">98%</p>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Tingkat Kepuasan</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-indigo-400">50+</p>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Modul Praktis</p>
                    </div>
                    <div>
                        <p class="text-2xl sm:text-3xl font-black text-emerald-400">120+</p>
                        <p class="text-xs text-slate-400 mt-1 uppercase tracking-wider">Mitra Industri</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Interactive Visual Showcase -->
            <div class="lg:col-span-5 relative">
                <!-- Outer Glass Container -->
                <div class="relative bg-slate-800/60 border border-slate-700/80 rounded-2xl p-6 sm:p-8 backdrop-blur-xl shadow-2xl space-y-5">
                    
                    <div class="flex items-center justify-between pb-4 border-b border-slate-700">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('img/logo.png') }}" alt="Akademi Pelatihan" class="h-10 w-auto bg-white/10 p-1.5 rounded-lg" />
                            <div>
                                <h3 class="font-bold text-white text-sm">Akademi Pelatihan</h3>
                                <p class="text-xs text-slate-400">Sertifikasi & Karir Digital</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            Batch Aktif
                        </span>
                    </div>

                    <!-- Mini Highlight Cards -->
                    <div class="space-y-3">
                        <div class="p-3.5 rounded-xl bg-slate-900/70 border border-slate-700/50 flex items-center justify-between hover:border-blue-500 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold">
                                    💻
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white">Fullstack Web Development</h4>
                                    <p class="text-xs text-slate-400">Laravel 12, Vue 3 & Tailwind</p>
                                </div>
                            </div>
                            <span class="text-xs text-sky-400 font-semibold">12 Minggu</span>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-900/70 border border-slate-700/50 flex items-center justify-between hover:border-indigo-500 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold">
                                    🎨
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white">UI/UX & Product Design</h4>
                                    <p class="text-xs text-slate-400">Figma, Prototyping & UX Research</p>
                                </div>
                            </div>
                            <span class="text-xs text-indigo-400 font-semibold">8 Minggu</span>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-900/70 border border-slate-700/50 flex items-center justify-between hover:border-emerald-500 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                                    📊
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-white">Data Science & Analytics</h4>
                                    <p class="text-xs text-slate-400">Python, SQL & PowerBI</p>
                                </div>
                            </div>
                            <span class="text-xs text-emerald-400 font-semibold">10 Minggu</span>
                        </div>
                    </div>

                    <!-- Verified Badge Banner -->
                    <div class="pt-3 flex items-center justify-between text-xs text-slate-300 bg-blue-900/30 p-3 rounded-xl border border-blue-800/40">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>E-Sertifikat Resmi & Portofolio Kerja</span>
                        </div>
                        <span class="text-blue-300 font-bold">Terverifikasi</span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
