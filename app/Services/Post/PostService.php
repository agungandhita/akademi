<?php

namespace App\Services\Post;

use App\DTOs\Post\PostDTO;
use App\Enums\PostStatus;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService implements PostInterface
{
    public function getAllPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Post::with('author')->latest();

        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (! empty($filters['type'])) {
            $query->type($filters['type']);
        }

        if (! empty($filters['status'])) {
            $query->status($filters['status']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getPublishedPaginated(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = Post::published()->with('author')->latest('published_at');

        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (! empty($filters['type'])) {
            $query->type($filters['type']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getRecentPublished(int $limit = 4): \Illuminate\Database\Eloquent\Collection
    {
        return Post::published()
            ->with('author')
            ->latest('published_at')
            ->take($limit)
            ->get();
    }

    public function getPublishedBySlug(string $slug): Post
    {
        return Post::published()
            ->with('author')
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function getById(int $id): Post
    {
        return Post::with('author')->findOrFail($id);
    }

    public function getBySlug(string $slug): Post
    {
        return Post::with('author')->where('slug', $slug)->firstOrFail();
    }

    public function create(PostDTO $dto): Post
    {
        $coverPath = null;
        if ($dto->cover) {
            $coverPath = $dto->cover->store('posts', 'public');
        }

        $slug = $this->generateUniqueSlug($dto->title);

        $publishedAt = $dto->publishedAt;
        if ($dto->status === PostStatus::Published && empty($publishedAt)) {
            $publishedAt = now();
        }

        return Post::create([
            'author_id' => $dto->authorId ?? auth()->id(),
            'title' => $dto->title,
            'slug' => $slug,
            'type' => $dto->type,
            'excerpt' => $dto->excerpt,
            'content' => $dto->content,
            'cover' => $coverPath,
            'status' => $dto->status,
            'published_at' => $publishedAt,
        ]);
    }

    public function update(int $id, PostDTO $dto): Post
    {
        $post = $this->getById($id);

        $updateData = [
            'type' => $dto->type,
            'excerpt' => $dto->excerpt,
            'content' => $dto->content,
            'status' => $dto->status,
        ];

        // Jika judul berubah, generate slug baru
        if ($post->title !== $dto->title) {
            $updateData['title'] = $dto->title;
            $updateData['slug'] = $this->generateUniqueSlug($dto->title, $id);
        }

        // Tanggal terbit
        if ($dto->status === PostStatus::Published) {
            $updateData['published_at'] = $dto->publishedAt ?? ($post->published_at ?? now());
        } else {
            $updateData['published_at'] = $dto->publishedAt;
        }

        // Handle cover baru jika diunggah
        if ($dto->cover) {
            if ($post->cover && Storage::disk('public')->exists($post->cover)) {
                Storage::disk('public')->delete($post->cover);
            }
            $updateData['cover'] = $dto->cover->store('posts', 'public');
        }

        $post->update($updateData);

        return $post;
    }

    public function delete(int $id): bool
    {
        $post = $this->getById($id);

        return (bool) $post->delete();
    }

    /**
     * Generate slug yang unik.
     */
    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (Post::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
