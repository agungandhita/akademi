@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-20 bg-surface">
    <div class="flex flex-col w-full">

        <!-- ========================================== -->
        <!-- 0. READING PROGRESS BAR                    -->
        <!-- ========================================== -->
        <div class="fixed top-20 left-0 w-full h-1 bg-surface-container-high z-40">
            <div class="h-full bg-secondary transition-all duration-150" id="read-progress" style="width: 0%;"></div>
        </div>

        <!-- ========================================== -->
        <!-- 1. BREADCRUMB BAR                          -->
        <!-- ========================================== -->
        <section class="w-full bg-surface-container-low py-3 border-b border-outline-variant/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav aria-label="Breadcrumb" class="flex items-center gap-1.5 text-on-surface-variant text-xs sm:text-sm overflow-x-auto whitespace-nowrap py-0.5">
                    <a class="hover:text-secondary flex items-center gap-1 transition-colors font-medium" href="{{ url('/') }}">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <a class="hover:text-secondary transition-colors font-medium" href="{{ url('/berita') }}">
                        Berita &amp; Artikel
                    </a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <span class="text-on-surface font-semibold truncate max-w-xs md:max-w-md">
                        {{ $post->title }}
                    </span>
                </nav>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- 2. ARTICLE HEADER SECTION                  -->
        <!-- ========================================== -->
        <header class="w-full bg-surface-container-lowest pt-8 sm:pt-12 pb-8 border-b border-outline-variant/60 shadow-xs">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col gap-4">
                
                <!-- Category Badges -->
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-3 py-1 bg-secondary text-white rounded-full font-headline text-xs font-bold tracking-wide">
                        {{ $post->type->label() }}
                    </span>
                    <span class="px-3 py-1 bg-surface-container text-primary rounded-full font-headline text-xs font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">stars</span>
                        Publikasi Resmi Akademi
                    </span>
                </div>

                <!-- Main Article Headline -->
                <h1 class="font-headline text-2xl sm:text-3xl lg:text-4xl font-extrabold text-primary leading-tight tracking-tight">
                    {{ $post->title }}
                </h1>

                <!-- Informative Subtitle / Excerpt -->
                <p class="text-sm sm:text-base text-on-surface-variant leading-relaxed">
                    {{ $post->excerpt }}
                </p>

                <!-- Metadata Bar -->
                <div class="pt-4 mt-2 bg-surface-container-low p-4 sm:p-5 rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-4 border border-outline-variant/60">
                    
                    <!-- Author Profile Info -->
                    @php
                        $authorName = $post->author?->name ?? 'Dewan Redaksi';
                        $words = array_values(array_filter(explode(' ', trim($authorName))));
                        $initials = count($words) >= 2 
                            ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1)) 
                            : strtoupper(substr($authorName, 0, 2));
                    @endphp
                    <div class="flex items-center gap-3.5 min-w-0">
                        <div class="w-12 h-12 rounded-full bg-primary text-white flex items-center justify-center font-headline text-base font-bold shadow-xs shrink-0 ring-2 ring-secondary/20">
                            {{ $initials }}
                        </div>
                        <div class="flex flex-col min-w-0">
                            <div class="flex items-center gap-1.5">
                                <span class="font-headline text-sm font-bold text-primary truncate">{{ $authorName }}</span>
                                <span class="material-symbols-outlined text-secondary text-[18px]" style="font-variation-settings: 'FILL' 1;" title="Penulis Resmi">check_circle</span>
                            </div>
                            <span class="text-xs text-on-surface-variant truncate">
                                {{ $post->author?->expertise ?? 'Akademi Pelatihan Indonesia' }}
                            </span>
                            <div class="flex items-center gap-3 mt-0.5 text-[11px] text-outline font-medium">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">calendar_today</span> 
                                    {{ $post->published_at ? $post->published_at->translatedFormat('d F Y') : $post->created_at->translatedFormat('d F Y') }}
                                </span>
                                <span>•</span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                                    {{ $post->published_at ? $post->published_at->format('H:i') : '' }} WIB
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Utility Buttons -->
                    <div class="flex items-center gap-2 self-start md:self-center shrink-0">
                        <button type="button" 
                                onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan artikel berhasil disalin!');" 
                                class="px-3.5 py-2 rounded-xl bg-surface-container-lowest hover:bg-surface-container text-primary font-headline text-xs font-semibold transition-all flex items-center gap-1.5 border border-outline-variant/50 cursor-pointer" 
                                title="Salin Tautan">
                            <span class="material-symbols-outlined text-[18px]">share</span>
                            <span>Bagikan</span>
                        </button>
                        <button type="button" 
                                onclick="window.print()" 
                                class="px-3.5 py-2 rounded-xl bg-surface-container-lowest hover:bg-surface-container text-primary font-headline text-xs font-semibold transition-all flex items-center gap-1.5 border border-outline-variant/50 cursor-pointer" 
                                title="Cetak Artikel">
                            <span class="material-symbols-outlined text-[18px]">print</span>
                            <span>Cetak</span>
                        </button>
                    </div>

                </div>

            </div>
        </header>

        <!-- ========================================== -->
        <!-- 3. COVER IMAGE BANNER (JIKA ADA)           -->
        <!-- ========================================== -->
        @if($post->cover)
        <section class="w-full bg-surface-container-lowest pb-10 sm:pb-12 border-b border-outline-variant/50">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl shadow-md bg-surface-container-high aspect-[16/9] max-h-[500px] border border-outline-variant/50">
                    <img class="w-full h-full object-cover" 
                         alt="{{ $post->title }}" 
                         src="{{ asset('storage/' . $post->cover) }}" />
                </div>
            </div>
        </section>
        @endif

        <!-- ========================================== -->
        <!-- 4. MAIN CONTENT LAYOUT (BODY + SIDEBAR)    -->
        <!-- ========================================== -->
        <section class="w-full bg-surface py-10 lg:py-14">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Main Editorial Column (8 Columns) -->
                    <article class="lg:col-span-8 flex flex-col gap-6">
                        
                        <!-- Excerpt Callout Card -->
                        <div class="bg-surface-container-lowest p-6 sm:p-8 rounded-2xl shadow-xs border-l-4 border-secondary border-t border-r border-b border-outline-variant/60">
                            <span class="text-xs font-bold text-secondary uppercase tracking-wider block mb-2">Ringkasan Materi:</span>
                            <p class="text-base sm:text-lg text-on-surface font-medium leading-relaxed">
                                {{ $post->excerpt }}
                            </p>
                        </div>

                        <!-- Full Content Body -->
                        <div class="bg-surface-container-lowest p-6 sm:p-10 rounded-2xl shadow-xs border border-outline-variant/60">
                            <div class="prose max-w-none text-on-surface leading-relaxed whitespace-pre-line font-sans text-base sm:text-lg space-y-4">
                                {!! nl2br(e($post->content)) !!}
                            </div>
                        </div>

                        <!-- Back Button -->
                        <div class="pt-4 flex items-center justify-between">
                            <a href="{{ url('/berita') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-surface-container text-primary font-headline text-xs font-bold hover:bg-secondary hover:text-white transition-all shadow-xs">
                                <span class="material-symbols-outlined text-[16px]">arrow_back</span>
                                <span>Kembali ke Indeks Berita</span>
                            </a>
                        </div>
                    </article>

                    <!-- Sidebar Column (4 Columns) -->
                    <aside class="lg:col-span-4 flex flex-col gap-6">
                        
                        <!-- CTA Card -->
                        <div class="bg-gradient-to-br from-primary to-primary-container p-6 sm:p-8 rounded-2xl text-white shadow-md">
                            <span class="text-xs font-bold uppercase tracking-wider text-secondary-fixed">Kompetensi Nasional</span>
                            <h4 class="font-headline text-lg sm:text-xl font-bold mt-2 mb-3 leading-snug">
                                Siap Tingkatkan Keahlian Digital Anda?
                            </h4>
                            <p class="text-xs text-white/80 leading-relaxed mb-6">
                                Telusuri agenda pelatihan terakreditasi dan dapatkan modul standar industri secara terpadu.
                            </p>
                            <a href="{{ url('/agenda') }}" class="block w-full py-2.5 px-4 bg-secondary text-white font-headline text-xs font-bold text-center rounded-xl hover:bg-secondary-container transition-all shadow-xs">
                                Telusuri Agenda Pelatihan
                            </a>
                        </div>

                        <!-- Related Articles Stack -->
                        @php
                            $filteredRelated = isset($relatedPosts) ? $relatedPosts->where('id', '!=', $post->id)->take(3) : collect();
                        @endphp
                        @if($filteredRelated->isNotEmpty())
                        <div class="bg-surface-container-lowest p-6 rounded-2xl border border-outline-variant/60 shadow-xs">
                            <h4 class="font-headline text-sm font-extrabold text-primary mb-4 pb-2 border-b border-outline-variant/40 flex items-center justify-between">
                                <span>Publikasi Lainnya</span>
                                <span class="material-symbols-outlined text-[18px] text-secondary">feed</span>
                            </h4>
                            <div class="flex flex-col divide-y divide-outline-variant/40">
                                @foreach($filteredRelated as $rel)
                                    <article class="py-3.5 first:pt-0 last:pb-0 flex flex-col gap-1.5">
                                        <span class="text-[10px] font-bold text-secondary uppercase tracking-wider">{{ $rel->type->label() }}</span>
                                        <h5 class="font-headline text-xs sm:text-sm font-bold text-primary hover:text-secondary transition-colors line-clamp-2">
                                            <a href="{{ url('/berita/' . $rel->slug) }}">
                                                {{ $rel->title }}
                                            </a>
                                        </h5>
                                        <span class="text-[11px] text-outline">
                                            {{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : '' }}
                                        </span>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </aside>

                </div>
            </div>
        </section>

    </div>
</div>

<script>
window.addEventListener('scroll', function () {
    const totalHeight = document.documentElement.scrollHeight - window.innerHeight;
    const progress = (window.scrollY / totalHeight) * 100;
    const progressBar = document.getElementById('read-progress');
    if (progressBar) {
        progressBar.style.width = Math.min(100, Math.max(0, progress)) + '%';
    }
});
</script>
@endsection
