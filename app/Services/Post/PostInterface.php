<?php

namespace App\Services\Post;

use App\DTOs\Post\PostDTO;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostInterface
{
    /**
     * Ambil daftar postingan dengan filter & pagination.
     *
     * @param array<string, mixed> $filters
     */
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    /**
     * Ambil postingan berdasarkan ID.
     */
    public function getById(int $id): Post;

    /**
     * Ambil postingan berdasarkan slug.
     */
    public function getBySlug(string $slug): Post;

    /**
     * Buat postingan baru.
     */
    public function create(PostDTO $dto): Post;

    /**
     * Perbarui postingan yang ada.
     */
    public function update(int $id, PostDTO $dto): Post;

    /**
     * Ambil daftar postingan terbit untuk publik dengan filter & paginasi.
     *
     * @param array<string, mixed> $filters
     */
    public function getPublishedPaginated(array $filters = [], int $perPage = 9): LengthAwarePaginator;

    /**
     * Ambil postingan terbit terbaru untuk beranda.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Post>
     */
    public function getRecentPublished(int $limit = 4): \Illuminate\Database\Eloquent\Collection;

    /**
     * Ambil postingan terbit berdasarkan slug untuk halaman detail publik.
     */
    public function getPublishedBySlug(string $slug): Post;

    /**
     * Hapus postingan (soft delete).
     */
    public function delete(int $id): bool;
}
