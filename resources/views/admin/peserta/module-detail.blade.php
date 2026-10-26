@extends('admin.layouts.main')

@section('container')
<div class="space-y-6">

    <!-- Breadcrumb & Top Bar -->
    <div class="flex items-center gap-2 text-xs text-on-surface-variant flex-wrap">
        <a href="{{ route('peserta') }}" class="hover:text-primary transition-colors">Portal Peserta</a>
        <span class="text-outline-variant">/</span>
        <a href="{{ route('peserta.trainings') }}" class="hover:text-primary transition-colors">Pelatihan Saya</a>
        <span class="text-outline-variant">/</span>
        <a href="{{ route('peserta.trainings.show', $training->id) }}" class="hover:text-primary transition-colors truncate max-w-xs">{{ $training->title }}</a>
        <span class="text-outline-variant">/</span>
        <span class="text-primary font-semibold truncate max-w-xs">{{ $module->title }}</span>
    </div>

    <!-- Quick Navigation Header Strip -->
    <div class="bg-surface-container-lowest p-4 sm:p-5 rounded-2xl border border-outline-variant/60 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('peserta.trainings.show', $training->id) }}" class="w-10 h-10 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary flex items-center justify-center transition-colors shrink-0" title="Kembali ke Ruang Belajar">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-bold text-outline uppercase tracking-wider">
                        Modul #{{ $module->sort_order ?: 1 }}
                    </span>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $module->type->badgeClass() }}">
                        {{ $module->type->label() }}
                    </span>
                </div>
                <h1 class="font-headline text-base sm:text-xl font-bold text-primary truncate mt-0.5">
                    {{ $module->title }}
                </h1>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            @if($prevModule)
                <a href="{{ route('peserta.trainings.modules.show', [$training->id, $prevModule->id]) }}" class="px-3 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-headline text-xs font-semibold flex items-center gap-1.5 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                    <span class="hidden sm:inline">Modul Sebelumnya</span>
                </a>
            @endif

            @if($nextModule)
                <a href="{{ route('peserta.trainings.modules.show', [$training->id, $nextModule->id]) }}" class="px-3.5 py-2 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold flex items-center gap-1.5 shadow-xs transition-colors">
                    <span class="hidden sm:inline">Modul Selanjutnya</span>
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Main Content Layout (Reader + Sidebar) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- Kolom Utama: Module Viewer (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
                
                <!-- Deskripsi Modul jika ada -->
                @if($module->description)
                    <div class="p-5 sm:p-6 bg-surface-container-low/40 border-b border-outline-variant/40">
                        <h4 class="text-xs font-bold text-outline uppercase tracking-wider mb-1.5">Deskripsi Modul</h4>
                        <p class="text-xs sm:text-sm text-on-surface leading-relaxed">
                            {{ $module->description }}
                        </p>
                    </div>
                @endif

                <!-- Viewer Berdasarkan Tipe Modul (TNT-04, PST-05) -->
                <div class="p-5 sm:p-6">
                    
                    {{-- 1. Tipe Modul PDF --}}
                    @if ($module->type === \App\Enums\ModuleType::Pdf)
                        @if($module->file_path)
                            @php
                                $fileUrl = asset('storage/' . $module->file_path);
                            @endphp
                            <div class="space-y-4">
                                <!-- Action bar PDF -->
                                <div class="flex flex-wrap items-center justify-between gap-3 p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/40">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-red-500/10 text-red-600 flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined text-[20px]">picture_as_pdf</span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-primary truncate max-w-xs">{{ basename($module->file_path) }}</p>
                                            <p class="text-[10px] text-outline">Dokumen PDF Resmi Modul Pelatihan</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ $fileUrl }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg border border-outline-variant hover:bg-surface-container text-xs font-semibold text-primary flex items-center gap-1.5 transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                            <span>Buka Layar Penuh</span>
                                        </a>
                                        <a href="{{ $fileUrl }}" download class="px-3.5 py-1.5 rounded-lg bg-secondary hover:bg-secondary-container text-white text-xs font-bold flex items-center gap-1.5 shadow-2xs transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">download</span>
                                            <span>Unduh PDF</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Interactive PDF.js Controls Bar -->
                                <div class="flex flex-wrap items-center justify-between gap-2 p-2.5 rounded-xl bg-surface-container border border-outline-variant/40 text-xs text-on-surface">
                                    <!-- Page Nav -->
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" id="pdf-prev" class="w-8 h-8 rounded-lg bg-surface-container-lowest hover:bg-surface-container-high border border-outline-variant/40 flex items-center justify-center text-primary transition-colors disabled:opacity-40 disabled:cursor-not-allowed" title="Halaman Sebelumnya">
                                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                        </button>
                                        <span class="px-2 font-mono font-bold text-[11px] text-primary">
                                            Halaman <span id="pdf-current-page">1</span> / <span id="pdf-total-pages">-</span>
                                        </span>
                                        <button type="button" id="pdf-next" class="w-8 h-8 rounded-lg bg-surface-container-lowest hover:bg-surface-container-high border border-outline-variant/40 flex items-center justify-center text-primary transition-colors disabled:opacity-40 disabled:cursor-not-allowed" title="Halaman Selanjutnya">
                                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                        </button>
                                    </div>

                                    <!-- Zoom & View Controls -->
                                    <div class="flex items-center gap-1">
                                        <button type="button" id="pdf-zoom-out" class="w-8 h-8 rounded-lg bg-surface-container-lowest hover:bg-surface-container-high border border-outline-variant/40 flex items-center justify-center text-primary transition-colors" title="Perkecil (-)">
                                            <span class="material-symbols-outlined text-[16px]">remove</span>
                                        </button>
                                        <button type="button" id="pdf-fit" class="px-2.5 h-8 rounded-lg bg-surface-container-lowest hover:bg-surface-container-high border border-outline-variant/40 flex items-center gap-1 text-[11px] font-semibold text-primary transition-colors" title="Sesuaikan Lebar Layar">
                                            <span class="material-symbols-outlined text-[15px]">fit_screen</span>
                                            <span class="hidden sm:inline">Paskan</span>
                                        </button>
                                        <button type="button" id="pdf-zoom-in" class="w-8 h-8 rounded-lg bg-surface-container-lowest hover:bg-surface-container-high border border-outline-variant/40 flex items-center justify-center text-primary transition-colors" title="Perbesar (+)">
                                            <span class="material-symbols-outlined text-[16px]">add</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- PDF Canvas Render Container (Responsive, Mobile & Desktop Ready) -->
                                <div id="pdf-render-container" class="relative min-h-[420px] max-h-[820px] overflow-auto flex flex-col items-center justify-start p-3 sm:p-5 rounded-2xl border border-outline-variant/60 bg-surface-container-low/80 shadow-inner">
                                    
                                    <!-- Loading State -->
                                    <div id="pdf-loader" class="py-20 flex flex-col items-center justify-center gap-3 text-on-surface-variant">
                                        <div class="w-8 h-8 border-3 border-secondary border-t-transparent rounded-full animate-spin"></div>
                                        <p class="text-xs font-semibold">Memuat dokumen PDF...</p>
                                    </div>

                                    <!-- Error / Fallback State -->
                                    <div id="pdf-error" class="hidden py-16 px-4 text-center flex flex-col items-center justify-center max-w-md mx-auto">
                                        <div class="w-12 h-12 rounded-xl bg-error-container/40 text-error flex items-center justify-center mb-3">
                                            <span class="material-symbols-outlined text-[28px]">broken_image</span>
                                        </div>
                                        <h5 class="text-xs sm:text-sm font-bold text-primary">Gagal memuat pratinjau di layar ini</h5>
                                        <p class="text-[11px] text-on-surface-variant mt-1 mb-4">
                                            Browser membatasi render dokumen langsung. Silakan buka di tab baru atau unduh dokumen resmi.
                                        </p>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ $fileUrl }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-primary text-white text-xs font-bold">
                                                Buka Tab Baru
                                            </a>
                                            <a href="{{ $fileUrl }}" download class="px-3.5 py-2 rounded-xl bg-secondary text-white text-xs font-bold">
                                                Unduh PDF
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Canvas Element -->
                                    <canvas id="pdf-canvas" class="hidden shadow-lg rounded-xl max-w-full bg-white transition-all duration-200"></canvas>
                                </div>
                            </div>
                        @else
                            <div class="p-8 text-center text-xs text-on-surface-variant bg-surface-container-low rounded-xl">
                                Berkas file PDF materi belum tersedia atau tautan tidak valid.
                            </div>
                        @endif

                    {{-- 2. Tipe Modul Video --}}
                    @elseif ($module->type === \App\Enums\ModuleType::Video)
                        @php
                            $videoUrl = $module->url;
                            $embedUrl = null;
                            if ($videoUrl) {
                                if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $videoUrl, $matches)) {
                                    $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                } elseif (str_contains($videoUrl, 'drive.google.com/file/d/')) {
                                    $embedUrl = str_replace('/view', '/preview', $videoUrl);
                                }
                            }
                        @endphp

                        <div class="space-y-4">
                            @if($embedUrl)
                                <div class="relative w-full aspect-video rounded-xl overflow-hidden border border-outline-variant/60 shadow-xs bg-black">
                                    <iframe src="{{ $embedUrl }}" class="absolute inset-0 w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                </div>
                            @elseif($videoUrl)
                                <div class="p-6 rounded-xl bg-surface-container-low border border-outline-variant/40 text-center space-y-3">
                                    <div class="w-12 h-12 rounded-full bg-secondary/10 text-secondary mx-auto flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[24px]">play_circle</span>
                                    </div>
                                    <h4 class="font-headline text-sm font-bold text-primary">Tautan Video Pembelajaran</h4>
                                    <p class="text-xs text-on-surface-variant max-w-md mx-auto">
                                        Video dapat disaksikan langsung melalui tautan eksternal resmi berikut ini.
                                    </p>
                                    <a href="{{ $videoUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-4 py-2 bg-secondary hover:bg-secondary-container text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                        <span>Buka Video di Tab Baru</span>
                                    </a>
                                </div>
                            @endif

                            @if($module->content)
                                <div class="mt-4 p-5 rounded-xl bg-surface-container-low/40 border border-outline-variant/30 text-xs sm:text-sm text-on-surface leading-relaxed">
                                    {!! nl2br(e($module->content)) !!}
                                </div>
                            @endif
                        </div>

                    {{-- 3. Tipe Modul Teks --}}
                    @elseif ($module->type === \App\Enums\ModuleType::Text)
                        <div class="prose max-w-none text-xs sm:text-sm text-on-surface leading-relaxed space-y-4">
                            <div class="p-5 sm:p-6 rounded-xl bg-surface-container-low/30 border border-outline-variant/30">
                                {!! nl2br(e($module->content)) !!}
                            </div>
                        </div>

                    {{-- 4. Tipe Modul Tautan Eksternal --}}
                    @elseif ($module->type === \App\Enums\ModuleType::Link)
                        <div class="p-6 rounded-xl bg-surface-container-low border border-outline-variant/40 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-primary/10 text-primary mx-auto flex items-center justify-center">
                                <span class="material-symbols-outlined text-[24px]">link</span>
                            </div>
                            <h4 class="font-headline text-sm font-bold text-primary">Tautan Sumber Belajar Eksternal</h4>
                            <p class="text-xs text-on-surface-variant max-w-md mx-auto truncate">
                                {{ $module->url }}
                            </p>
                            @if($module->content)
                                <p class="text-xs text-on-surface-variant max-w-lg mx-auto leading-relaxed">
                                    {{ $module->content }}
                                </p>
                            @endif
                            <a href="{{ $module->url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-5 py-2.5 bg-secondary hover:bg-secondary-container text-white text-xs font-bold rounded-xl shadow-xs transition-colors">
                                <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                <span>Kunjungi Tautan Materi</span>
                            </a>
                        </div>
                    @endif

                </div>

                <!-- Footer Reader Navigation -->
                <div class="p-4 sm:p-5 border-t border-outline-variant/40 bg-surface-container-low/30 flex items-center justify-between gap-4">
                    @if($prevModule)
                        <a href="{{ route('peserta.trainings.modules.show', [$training->id, $prevModule->id]) }}" class="px-4 py-2 rounded-xl bg-surface-container hover:bg-surface-container-high text-primary font-headline text-xs font-semibold flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                            <span>{{ $prevModule->title }}</span>
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if($nextModule)
                        <a href="{{ route('peserta.trainings.modules.show', [$training->id, $nextModule->id]) }}" class="px-4 py-2 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold flex items-center gap-1.5 shadow-xs transition-colors">
                            <span>{{ $nextModule->title }}</span>
                            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                        </a>
                    @else
                        <a href="{{ route('peserta.trainings.show', $training->id) }}" class="px-4 py-2 rounded-xl bg-primary hover:bg-primary-container text-white font-headline text-xs font-bold flex items-center gap-1.5 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                            <span>Kembali ke Kurikulum</span>
                        </a>
                    @endif
                </div>

            </div>
        </div>

        <!-- Kolom Samping: Silabus / Daftar Semua Modul (4 Cols) -->
        <div class="lg:col-span-4 space-y-4">
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs overflow-hidden">
                <div class="p-4 sm:p-5 border-b border-outline-variant/40">
                    <h3 class="font-headline text-xs sm:text-sm font-bold text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary text-[18px]">format_list_bulleted</span>
                        <span>Silabus Modul ({{ $modules->count() }})</span>
                    </h3>
                </div>

                <div class="divide-y divide-outline-variant/20 max-h-[600px] overflow-y-auto">
                    @foreach ($modules as $idx => $m)
                        @php
                            $isActive = $m->id === $module->id;
                        @endphp
                        <a href="{{ route('peserta.trainings.modules.show', [$training->id, $m->id]) }}" 
                           class="p-3.5 sm:p-4 flex items-start gap-3 transition-colors {{ $isActive ? 'bg-secondary/10 border-l-4 border-secondary' : 'hover:bg-surface-container-low/50' }}">
                            
                            <div class="w-8 h-8 rounded-lg {{ $isActive ? 'bg-secondary text-white' : 'bg-surface-container text-on-surface-variant' }} flex items-center justify-center shrink-0 font-bold text-xs">
                                @if($isActive)
                                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                @else
                                    <span>{{ $m->sort_order ?: ($idx + 1) }}</span>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold {{ $isActive ? 'text-secondary' : 'text-outline' }} uppercase tracking-wider">
                                        Modul #{{ $m->sort_order ?: ($idx + 1) }}
                                    </span>
                                    <span class="px-1.5 py-0.2 rounded text-[9px] font-semibold {{ $m->type->badgeClass() }}">
                                        {{ $m->type->label() }}
                                    </span>
                                </div>
                                <h4 class="text-xs font-bold {{ $isActive ? 'text-secondary' : 'text-primary' }} truncate mt-0.5">
                                    {{ $m->title }}
                                </h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Card Informasi Instruktur Singkat -->
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 shadow-xs p-4 sm:p-5">
                <h4 class="text-[11px] font-bold text-outline uppercase tracking-wider mb-2">Instruktur Pengampu</h4>
                <div class="space-y-2">
                    @forelse($training->instructors as $instructor)
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-primary font-bold overflow-hidden shrink-0">
                                @if($instructor->avatar)
                                    <img src="{{ asset('storage/' . $instructor->avatar) }}" alt="{{ $instructor->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="material-symbols-outlined text-[16px]">person</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h5 class="text-xs font-bold text-on-surface truncate">{{ $instructor->name }}</h5>
                                <p class="text-[10px] text-outline truncate">{{ $instructor->expertise ?: 'Instruktur' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-on-surface-variant">Tim Pengajar</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@if ($module->type === \App\Enums\ModuleType::Pdf && $module->file_path)
    @push('scripts')
    <script src="{{ asset('vendor/pdfjs/pdf.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileUrl = "{{ asset('storage/' . $module->file_path) }}";
            if (typeof pdfjsLib === 'undefined') {
                console.error('PDF.js library is not loaded');
                return;
            }

            pdfjsLib.GlobalWorkerOptions.workerSrc = "{{ asset('vendor/pdfjs/pdf.worker.min.js') }}";

            let pdfDoc = null,
                pageNum = 1,
                pageRendering = false,
                pageNumPending = null,
                userZoom = 1.0,
                canvas = document.getElementById('pdf-canvas'),
                ctx = canvas ? canvas.getContext('2d') : null;

            const loader = document.getElementById('pdf-loader');
            const errorEl = document.getElementById('pdf-error');
            const container = document.getElementById('pdf-render-container');
            const currentPgEl = document.getElementById('pdf-current-page');
            const totalPgEl = document.getElementById('pdf-total-pages');
            const prevBtn = document.getElementById('pdf-prev');
            const nextBtn = document.getElementById('pdf-next');

            if (!canvas || !container) return;

            function updateNavState() {
                if (!pdfDoc) return;
                if (currentPgEl) currentPgEl.textContent = pageNum;
                if (prevBtn) prevBtn.disabled = pageNum <= 1;
                if (nextBtn) nextBtn.disabled = pageNum >= pdfDoc.numPages;
            }

            function renderPage(num) {
                pageRendering = true;
                pdfDoc.getPage(num).then(function(page) {
                    const containerWidth = Math.max(container.clientWidth - 32, 260);
                    const unscaledViewport = page.getViewport({ scale: 1.0 });
                    const fitScale = (containerWidth / unscaledViewport.width);
                    const finalScale = fitScale * userZoom;

                    const viewport = page.getViewport({ scale: finalScale });
                    const outputScale = window.devicePixelRatio || 1;

                    canvas.width = Math.floor(viewport.width * outputScale);
                    canvas.height = Math.floor(viewport.height * outputScale);
                    canvas.style.width = Math.floor(viewport.width) + "px";
                    canvas.style.height = Math.floor(viewport.height) + "px";

                    const transform = outputScale !== 1
                        ? [outputScale, 0, 0, outputScale, 0, 0]
                        : null;

                    const renderContext = {
                        canvasContext: ctx,
                        transform: transform,
                        viewport: viewport
                    };

                    const renderTask = page.render(renderContext);

                    renderTask.promise.then(function() {
                        pageRendering = false;
                        if (loader) loader.classList.add('hidden');
                        if (errorEl) errorEl.classList.add('hidden');
                        canvas.classList.remove('hidden');

                        if (pageNumPending !== null) {
                            renderPage(pageNumPending);
                            pageNumPending = null;
                        }
                    }).catch(function(err) {
                        pageRendering = false;
                        console.error("Render error:", err);
                    });
                }).catch(function(err) {
                    pageRendering = false;
                    console.error("Get page error:", err);
                });

                updateNavState();
            }

            function queueRenderPage(num) {
                if (pageRendering) {
                    pageNumPending = num;
                } else {
                    renderPage(num);
                }
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    if (pageNum <= 1) return;
                    pageNum--;
                    queueRenderPage(pageNum);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    if (!pdfDoc || pageNum >= pdfDoc.numPages) return;
                    pageNum++;
                    queueRenderPage(pageNum);
                });
            }

            const zoomInBtn = document.getElementById('pdf-zoom-in');
            if (zoomInBtn) {
                zoomInBtn.addEventListener('click', function() {
                    if (userZoom >= 2.5) return;
                    userZoom += 0.2;
                    queueRenderPage(pageNum);
                });
            }

            const zoomOutBtn = document.getElementById('pdf-zoom-out');
            if (zoomOutBtn) {
                zoomOutBtn.addEventListener('click', function() {
                    if (userZoom <= 0.6) return;
                    userZoom -= 0.2;
                    queueRenderPage(pageNum);
                });
            }

            const fitBtn = document.getElementById('pdf-fit');
            if (fitBtn) {
                fitBtn.addEventListener('click', function() {
                    userZoom = 1.0;
                    queueRenderPage(pageNum);
                });
            }

            let resizeTimeout;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function() {
                    if (pdfDoc) queueRenderPage(pageNum);
                }, 250);
            });

            pdfjsLib.getDocument(fileUrl).promise.then(function(loadedDoc) {
                pdfDoc = loadedDoc;
                if (totalPgEl) totalPgEl.textContent = pdfDoc.numPages;
                renderPage(pageNum);
            }).catch(function(err) {
                console.error("PDF.js loading error: ", err);
                if (loader) loader.classList.add('hidden');
                if (errorEl) errorEl.classList.remove('hidden');
            });
        });
    </script>
    @endpush
@endif
