<?php

namespace App\Http\Controllers\Admin;

use App\DTOs\Post\PostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StorePostRequest;
use App\Http\Requests\Admin\Post\UpdatePostRequest;
use App\Services\Post\PostInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
{
    public function __construct(
        protected PostInterface $postService,
    ) {}

    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->query('search'),
            'type' => $request->query('type'),
            'status' => $request->query('status'),
        ];

        $posts = $this->postService->getAllPaginated($filters);

        return view('admin.posts.index', [
            'posts' => $posts,
            'filters' => $filters,
            'title' => 'Manajemen Berita & Artikel - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'title' => 'Tulis Berita / Artikel Baru - Akademi Pelatihan',
            'currentRole' => 'admin',
        ]);
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $dto = PostDTO::fromRequest($request->validated(), $request->user()->id);

        $post = $this->postService->create($dto);

        Alert::success('Berhasil', "Konten \"{$post->title}\" berhasil ditambahkan.");

        return redirect()->route('admin.posts.index');
    }

    public function show(int $id): View
    {
        $post = $this->postService->getById($id);

        return view('admin.posts.show', [
            'post' => $post,
            'title' => "Detail: {$post->title} - Akademi Pelatihan",
            'currentRole' => 'admin',
        ]);
    }

    public function edit(int $id): View
    {
        $post = $this->postService->getById($id);

        return view('admin.posts.edit', [
            'post' => $post,
            'title' => "Ubah: {$post->title} - Akademi Pelatihan",
            'currentRole' => 'admin',
        ]);
    }

    public function update(UpdatePostRequest $request, int $id): RedirectResponse
    {
        $dto = PostDTO::fromRequest($request->validated(), $request->user()->id);

        $post = $this->postService->update($id, $dto);

        Alert::success('Berhasil', "Konten \"{$post->title}\" berhasil diperbarui.");

        return redirect()->route('admin.posts.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->postService->delete($id);

        Alert::success('Berhasil', 'Konten berita/artikel berhasil dihapus.');

        return redirect()->route('admin.posts.index');
    }
}
