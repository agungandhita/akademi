@extends('frontend.layouts.main')

@section('container')
<div class="w-full pt-20 bg-surface">
    <div class="flex flex-col w-full">

        <!-- ========================================== -->
        <!-- 1. EDITORIAL HEADER & AMBIENT GLOW         -->
        <!-- ========================================== -->
        <div class="relative w-full overflow-hidden bg-gradient-to-b from-surface-container-high/60 via-surface to-surface pb-12 pt-6 sm:pt-10 px-4 sm:px-6 lg:px-8 border-b border-outline-variant/50">
            <div class="absolute top-0 right-1/4 w-96 h-96 rounded-full bg-secondary-fixed/30 blur-3xl pointer-events-none -translate-y-1/2"></div>
            <div class="absolute top-28 right-12 w-64 h-64 rounded-full bg-tertiary-fixed/20 blur-2xl pointer-events-none"></div>

            <div class="max-w-7xl mx-auto">
                <!-- Breadcrumb Navigation -->
                <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-on-surface-variant text-xs sm:text-sm mb-6">
                    <a class="hover:text-secondary flex items-center gap-1 transition-colors font-medium" href="{{ url('/') }}">
                        <span class="material-symbols-outlined text-[16px]">home</span>
                        <span>Beranda</span>
                    </a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <span class="font-semibold text-primary">Berita &amp; Artikel</span>
                </nav>

                <!-- Editorial Header -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 sm:gap-8 mb-8 pb-4">
                    <div class="max-w-3xl">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-surface-container-high text-secondary text-xs font-bold mb-3 border border-outline-variant/60">
                            <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                            Kanal Redaksi &amp; Publikasi Resmi
                        </div>
                        <h1 class="font-headline text-3xl sm:text-4xl lg:text-5xl font-extrabold text-primary tracking-tight mb-3 leading-tight">
                            Berita &amp; Wawasan Pendidikan Terkini
                        </h1>
                        <p class="text-base sm:text-lg text-on-surface-variant leading-relaxed">
                            Kajian mendalam, tips pengajaran pedagogis, analisis regulasi kompetensi, dan inovasi teknologi pelatihan terkini langsung dari pakar kurikulum nasional.
                        </p>
                    </div>

                    <!-- Search Bar Form -->
                    <div class="w-full lg:w-80 shrink-0">
                        <form method="GET" action="{{ route('berita') }}" class="relative">
                            @if(request('type'))
                                <input type="hidden" name="type" value="{{ request('type') }}">
                            @endif
                            <input type="text" 
                                   name="search"
                                   value="{{ request('search') }}" 
                                   placeholder="Cari artikel atau topik..." 
                                   class="w-full bg-surface-container-lowest text-on-surface placeholder:text-outline text-sm rounded-xl pl-11 pr-4 py-3 shadow-xs border border-outline-variant/60 focus:outline-none focus:ring-2 focus:ring-secondary/40 transition-all font-medium" />
                            <span class="material-symbols-outlined absolute left-3.5 top-3.5 text-outline text-[20px]">search</span>
                        </form>
                    </div>
                </div>

                <!-- Category Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-2" id="articleCategoryGroup">
                    <a href="{{ route('berita', array_filter(['search' => request('search')])) }}" 
                       class="px-4 py-2 rounded-full font-headline text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ !request('type') ? 'bg-secondary text-white shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant hover:text-primary hover:bg-surface-container border border-outline-variant/60' }}">
                        Semua Topik
                    </a>
                    <a href="{{ route('berita', array_filter(['search' => request('search'), 'type' => 'berita'])) }}" 
                       class="px-4 py-2 rounded-full font-headline text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ request('type') === 'berita' ? 'bg-secondary text-white shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant hover:text-primary hover:bg-surface-container border border-outline-variant/60' }}">
                        Berita Resmi
                    </a>
                    <a href="{{ route('berita', array_filter(['search' => request('search'), 'type' => 'artikel'])) }}" 
                       class="px-4 py-2 rounded-full font-headline text-xs sm:text-sm font-bold transition-all whitespace-nowrap {{ request('type') === 'artikel' ? 'bg-secondary text-white shadow-xs' : 'bg-surface-container-lowest text-on-surface-variant hover:text-primary hover:bg-surface-container border border-outline-variant/60' }}">
                        Artikel &amp; Opini
                    </a>
                    @if(request('search') || request('type'))
                        <a href="{{ route('berita') }}" class="px-3 py-1.5 text-xs text-error hover:underline flex items-center gap-1 font-semibold ml-2">
                            <span class="material-symbols-outlined text-[14px]">close</span>
                            Reset Filter
                        </a>
                    @endif
                </div>
            </div>
        </div>

        @if($posts->isEmpty())
            <!-- Empty State: Ketika admin belum menginputkan konten -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full text-center">
                <div class="max-w-md mx-auto p-8 rounded-3xl bg-surface-container-lowest border border-outline-variant/60 shadow-xs flex flex-col items-center">
                    <div class="w-16 h-16 rounded-2xl bg-surface-container-high flex items-center justify-center text-outline mb-4">
                        <span class="material-symbols-outlined text-4xl">article</span>
                    </div>
                    <h3 class="font-headline text-xl font-bold text-primary mb-2">Belum Ada Publikasi</h3>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-6">
                        @if(request('search') || request('type'))
                            Tidak ada berita atau artikel yang cocok dengan pencarian Anda. Silakan coba kata kunci lain.
                        @else
                            Saat ini belum ada berita atau artikel yang diterbitkan oleh administrator. Silakan cek kembali dalam waktu dekat.
                        @endif
                    </p>
                    @if(request('search') || request('type'))
                        <a href="{{ route('berita') }}" class="px-5 py-2.5 rounded-xl bg-secondary text-white font-headline text-xs font-bold hover:bg-secondary-container transition-all">
                            Lihat Semua Publikasi
                        </a>
                    @else
                        <a href="{{ url('/') }}" class="px-5 py-2.5 rounded-xl bg-secondary text-white font-headline text-xs font-bold hover:bg-secondary-container transition-all">
                            Kembali ke Beranda
                        </a>
                    @endif
                </div>
            </section>
        @else
            @php
                $featuredPost = $posts->first();
                $gridPosts = $posts->slice(1);
            @endphp

            <!-- ========================================== -->
            <!-- 2. FEATURED ARTICLE BENTO (POST UTAMA)     -->
            <!-- ========================================== -->
            @if(!request('search') && !request('type') && $posts->currentPage() === 1)
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12 w-full">
                <div class="relative bg-surface-container-lowest rounded-2xl shadow-md border border-outline-variant/70 overflow-hidden grid grid-cols-1 lg:grid-cols-12 transition-all duration-300 hover:shadow-xl">
                    
                    <!-- Left Hero Image (7 cols) -->
                    <div class="lg:col-span-7 relative min-h-[280px] lg:min-h-[420px] overflow-hidden bg-primary flex items-center justify-center">
                        @if($featuredPost->cover)
                            <img class="w-full h-full object-cover object-center transition-transform duration-700 hover:scale-105" 
                                 alt="{{ $featuredPost->title }}" 
                                 src="{{ asset('storage/' . $featuredPost->cover) }}" />
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-primary via-primary-container to-secondary/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-white/50 text-7xl">
                                    {{ $featuredPost->type->value === 'berita' ? 'newspaper' : 'article' }}
                                </span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 via-primary/20 to-transparent"></div>
                        <div class="absolute top-5 left-5 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-secondary text-white font-headline text-xs font-bold shadow-md">
                                <span class="material-symbols-outlined text-[16px]">stars</span>
                                {{ $featuredPost->type->label() }}
                            </span>
                        </div>
                    </div>

                    <!-- Right Editorial Content (5 cols) -->
                    <div class="lg:col-span-5 p-6 sm:p-8 lg:p-10 flex flex-col justify-between bg-surface-container-lowest">
                        <div>
                            <div class="flex items-center gap-3 text-on-surface-variant text-xs mb-3">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px] text-secondary">calendar_today</span>
                                    {{ $featuredPost->published_at ? $featuredPost->published_at->translatedFormat('d M Y') : $featuredPost->created_at->translatedFormat('d M Y') }}
                                </span>
                                <span>•</span>
                                <span class="text-secondary font-bold">{{ $featuredPost->author?->name ?? 'Dewan Redaksi' }}</span>
                            </div>
                            <h2 class="font-headline text-xl sm:text-2xl lg:text-3xl font-extrabold text-primary tracking-tight mb-4 hover:text-secondary transition-colors cursor-pointer leading-snug">
                                <a href="{{ url('/berita/' . $featuredPost->slug) }}">
                                    {{ $featuredPost->title }}
                                </a>
                            </h2>
                            <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed mb-6 line-clamp-4">
                                {{ $featuredPost->excerpt }}
                            </p>
                        </div>

                        <div class="pt-6 border-t border-outline-variant/50 flex items-center justify-between mt-auto">
                            <span class="font-headline text-xs font-semibold text-outline">
                                Publikasi Resmi
                            </span>
                            <a class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-primary text-white hover:bg-secondary font-headline text-xs font-bold shadow-xs transition-all group" href="{{ url('/berita/' . $featuredPost->slug) }}">
                                <span>Baca Lengkap</span>
                                <span class="material-symbols-outlined text-[16px] transition-transform group-hover:translate-x-1">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                </div>
            </section>
            @endif

            <!-- ========================================== -->
            <!-- 3. MAIN CONTENT GRID                       -->
            <!-- ========================================== -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16 w-full">
                <div class="flex flex-col gap-6">
                    
                    <div class="flex items-center justify-between pb-3 border-b border-outline-variant/60">
                        <div class="flex items-center gap-2">
                            <h3 class="font-headline text-xl sm:text-2xl font-extrabold text-primary">
                                {{ request('search') ? 'Hasil Pencarian' : (request('type') ? ucfirst(request('type')) : 'Artikel & Kajian Terkini') }}
                            </h3>
                            <span class="px-2.5 py-0.5 rounded-full bg-surface-container text-on-surface-variant text-xs font-bold">
                                {{ $posts->total() }} Publikasi
                            </span>
                        </div>
                    </div>

                    @php
                        // Jika di halaman pertama tanpa search/filter, item pertama sudah ada di featured banner
                        $displayPosts = (!request('search') && !request('type') && $posts->currentPage() === 1) ? $gridPosts : $posts;
                    @endphp

                    @if($displayPosts->isEmpty())
                        <div class="py-12 text-center text-outline text-sm">
                            Tidak ada artikel tambahan pada kategori ini.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($displayPosts as $item)
                                <article class="group bg-surface-container-lowest rounded-2xl shadow-xs hover:shadow-md transition-all duration-300 flex flex-col overflow-hidden border border-outline-variant/70">
                                    <div class="relative h-48 w-full overflow-hidden bg-surface-container flex items-center justify-center">
                                        @if($item->cover)
                                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" 
                                                 alt="{{ $item->title }}" 
                                                 src="{{ asset('storage/' . $item->cover) }}" />
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-primary/10 via-secondary/10 to-transparent flex items-center justify-center">
                                                <span class="material-symbols-outlined text-outline text-5xl">
                                                    {{ $item->type->value === 'berita' ? 'newspaper' : 'article' }}
                                                </span>
                                            </div>
                                        @endif
                                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-secondary text-white font-headline text-[11px] font-bold shadow-xs">
                                            {{ $item->type->label() }}
                                        </span>
                                    </div>

                                    <div class="p-5 sm:p-6 flex flex-col flex-1">
                                        <div class="flex items-center gap-2 text-outline text-xs mb-2">
                                            <span>{{ $item->published_at ? $item->published_at->translatedFormat('d M Y') : $item->created_at->translatedFormat('d M Y') }}</span>
                                            <span>•</span>
                                            <span class="font-medium text-primary">{{ $item->author?->name ?? 'Dewan Kurikulum' }}</span>
                                        </div>
                                        <h4 class="font-headline text-base font-bold text-primary group-hover:text-secondary transition-colors line-clamp-2 mb-2 leading-snug">
                                            <a href="{{ url('/berita/' . $item->slug) }}">
                                                {{ $item->title }}
                                            </a>
                                        </h4>
                                        <p class="text-xs sm:text-sm text-on-surface-variant line-clamp-3 mb-4 leading-relaxed">
                                            {{ $item->excerpt }}
                                        </p>
                                        <div class="mt-auto pt-4 border-t border-outline-variant/50 flex items-center justify-between">
                                            <span class="text-[11px] text-outline font-mono">
                                                {{ $item->type->label() }}
                                            </span>
                                            <a class="inline-flex items-center gap-1 text-secondary font-headline text-xs font-bold group-hover:gap-1.5 transition-all" href="{{ url('/berita/' . $item->slug) }}">
                                                <span>Baca Artikel</span>
                                                <span class="material-symbols-outlined text-[14px]">arrow_right_alt</span>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if($posts->hasPages())
                        <div class="pt-8">
                            {{ $posts->links() }}
                        </div>
                    @endif

                </div>
            </section>
        @endif

    </div>
</div>
@endsection
