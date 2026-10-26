<?php

namespace App\DTOs\Post;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Http\UploadedFile;

readonly class PostDTO
{
    public function __construct(
        public string $title,
        public PostType $type,
        public string $excerpt,
        public string $content,
        public PostStatus $status,
        public ?string $publishedAt = null,
        public ?UploadedFile $cover = null,
        public ?int $authorId = null,
    ) {}

    /**
     * Create DTO from validated request array.
     *
     * @param array<string, mixed> $data
     */
    public static function fromRequest(array $data, ?int $authorId = null): self
    {
        return new self(
            title: $data['title'],
            type: $data['type'] instanceof PostType ? $data['type'] : PostType::from($data['type']),
            excerpt: $data['excerpt'],
            content: $data['content'],
            status: $data['status'] instanceof PostStatus ? $data['status'] : PostStatus::from($data['status']),
            publishedAt: $data['published_at'] ?? null,
            cover: isset($data['cover']) && $data['cover'] instanceof UploadedFile ? $data['cover'] : null,
            authorId: $authorId,
        );
    }
}
