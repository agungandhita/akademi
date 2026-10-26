<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Enums\PostType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'type',
        'excerpt',
        'content',
        'cover',
        'status',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => PostType::class,
            'status' => PostStatus::class,
            'published_at' => 'datetime',
        ];
    }

    /**
     * Scope untuk mengambil postingan yang sudah terbit.
     *
     * @param  Builder<Post>  $query
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published->value)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope filter berdasarkan tipe postingan.
     *
     * @param  Builder<Post>  $query
     */
    public function scopeType(Builder $query, PostType|string $type): Builder
    {
        $typeVal = $type instanceof PostType ? $type->value : $type;

        return $query->where('type', $typeVal);
    }

    /**
     * Scope filter berdasarkan status postingan.
     *
     * @param  Builder<Post>  $query
     */
    public function scopeStatus(Builder $query, PostStatus|string $status): Builder
    {
        $statusVal = $status instanceof PostStatus ? $status->value : $status;

        return $query->where('status', $statusVal);
    }

    /**
     * Scope pencarian postingan berdasarkan judul atau ringkasan.
     *
     * @param  Builder<Post>  $query
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (empty($search)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($search) {
            $q->whereLike('title', "%{$search}%")
                ->orWhereLike('excerpt', "%{$search}%");
        });
    }

    /**
     * Relasi ke penulis (user).
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
