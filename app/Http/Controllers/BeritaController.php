<?php

namespace App\Http\Controllers;

use App\Services\Post\PostInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BeritaController extends Controller
{
    public function __construct(
        protected PostInterface $postService,
    ) {}

    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'type']);
        $posts = $this->postService->getPublishedPaginated($filters, 9);

        return view('frontend.berita.index', [
            'posts' => $posts,
            'filters' => $filters,
            'title' => 'Berita & Artikel Edukasi - Akademi Pelatihan',
            'metaDescription' => 'Kajian mendalam, tips pengajaran pedagogis, analisis regulasi kompetensi, dan berita resmi Akademi Pelatihan.',
        ]);
    }

    public function show(string $slug): View
    {
        $post = $this->postService->getPublishedBySlug($slug);
        $relatedPosts = $this->postService->getRecentPublished(4);

        return view('frontend.berita.detail', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'title' => "{$post->title} - Akademi Pelatihan",
            'metaDescription' => $post->excerpt,
        ]);
    }
}
