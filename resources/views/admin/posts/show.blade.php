@extends('admin.layouts.main')

@section('container')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-outline mb-1 font-medium">
                <a href="{{ route('admin.posts.index') }}" class="hover:text-secondary">Berita &amp; Artikel</a>
                <span>/</span>
                <span class="text-primary font-bold">Detail Konten</span>
            </div>
            <h1 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary">Detail Konten Publikasi</h1>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            @if($post->status->value === 'published')
                <a href="{{ url('/berita/' . $post->slug) }}" target="_blank" class="px-4 py-2 rounded-xl border border-secondary text-secondary hover:bg-secondary hover:text-white font-headline text-xs font-semibold transition-all flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    <span>Lihat di Web</span>
                </a>
            @endif
            <a href="{{ route('admin.posts.edit', $post->id) }}" class="px-4 py-2 rounded-xl bg-secondary hover:bg-secondary-container text-white font-headline text-xs font-bold transition-all flex items-center gap-1.5 shadow-xs">
                <span class="material-symbols-outlined text-[16px]">edit</span>
                <span>Ubah</span>
            </a>
            <form method="POST" action="{{ route('admin.posts.destroy', $post->id) }}" class="inline">
                @csrf
                @method('DELETE')
                <button type="button" 
                        onclick="confirmDelete(event, '{{ addslashes($post->title) }}', 'Apakah Anda yakin ingin menghapus konten ini?')"
                        class="px-3.5 py-2 rounded-xl border border-outline-variant/60 hover:bg-error-container/20 text-error font-headline text-xs font-semibold transition-all flex items-center gap-1.5 cursor-pointer">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    <span>Hapus</span>
                </button>
            </form>
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 rounded-xl border border-outline-variant/60 text-on-surface-variant hover:text-primary hover:bg-surface-container font-headline text-xs font-semibold transition-all">
                Kembali
            </a>
        </div>
    </div>

    <!-- Article Detail Card -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/60 overflow-hidden shadow-xs">
        
        <!-- Cover Banner (if exists) -->
        @if($post->cover)
        <div class="w-full h-64 sm:h-80 bg-surface-container-high overflow-hidden border-b border-outline-variant/60 relative">
            <img src="{{ asset('storage/' . $post->cover) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-sm text-white px-3 py-1 rounded-lg text-xs font-medium">
                Cover Resmi
            </div>
        </div>
        @endif

        <div class="p-6 sm:p-8 space-y-6">
            
            <!-- Metadata Badges & Date -->
            <div class="flex flex-wrap items-center gap-2.5 pb-4 border-b border-outline-variant/40">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $post->type->badgeClass() }}">
                    {{ $post->type->label() }}
                </span>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $post->status->badgeClass() }}">
                    {{ $post->status->label() }}
                </span>
                <div class="flex items-center gap-1 text-xs text-outline ml-auto">
                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                    <span>
                        @if($post->published_at)
                            Terbit: {{ $post->published_at->translatedFormat('d F Y, H:i') }} WIB
                        @else
                            Belum diterbitkan
                        @endif
                    </span>
                </div>
            </div>

            <!-- Title & Slug -->
            <div>
                <h2 class="font-headline text-2xl sm:text-3xl font-extrabold text-primary leading-tight">
                    {{ $post->title }}
                </h2>
                <div class="flex items-center gap-2 mt-2 text-xs text-outline">
                    <span class="font-mono bg-surface-container px-2 py-0.5 rounded text-[11px]">/berita/{{ $post->slug }}</span>
                    <span>&bull;</span>
                    <span>Penulis: <strong class="text-primary">{{ $post->author?->name ?? 'Administrator' }}</strong></span>
                </div>
            </div>

            <!-- Excerpt Callout -->
            <div class="p-4 rounded-xl bg-surface-container-low border-l-4 border-secondary text-sm font-medium text-on-surface leading-relaxed">
                <span class="block text-[11px] font-bold text-secondary uppercase tracking-wider mb-1">Ringkasan Singkat:</span>
                {{ $post->excerpt }}
            </div>

            <!-- Full Content -->
            <div class="pt-2">
                <h4 class="text-xs font-bold text-outline uppercase tracking-wider mb-4">Isi Konten:</h4>
                <div class="text-sm sm:text-base text-on-surface leading-relaxed whitespace-pre-line font-sans space-y-4">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- Footer Details -->
            <div class="pt-6 border-t border-outline-variant/40 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-outline gap-2">
                <span>Dibuat: {{ $post->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                <span>Terakhir diubah: {{ $post->updated_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </div>

        </div>
    </div>

</div>
@endsection
