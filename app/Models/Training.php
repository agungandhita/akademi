<?php

namespace App\Models;

use App\Enums\TrainingAudience;
use App\Enums\TrainingMode;
use App\Enums\TrainingStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'facilities',
        'thumbnail',
        'audience',
        'mode',
        'status',
        'is_free',
        'price',
        'quota',
        'registration_start',
        'registration_end',
        'start_date',
        'end_date',
        'location',
        'meeting_url',
        'created_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'audience' => TrainingAudience::class,
            'mode' => TrainingMode::class,
            'status' => TrainingStatus::class,
            'is_free' => 'boolean',
            'price' => 'decimal:2',
            'quota' => 'integer',
            'facilities' => 'array',
            'registration_start' => 'date',
            'registration_end' => 'date',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Training $training) {
            if (empty($training->slug)) {
                $training->slug = Str::slug($training->title);
            }
        });
    }

    /**
     * Relasi ke kategori pelatihan.
     *
     * @return BelongsTo<TrainingCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TrainingCategory::class, 'category_id');
    }

    /**
     * Relasi ke admin pembuat pelatihan.
     *
     * @return BelongsTo<User, $this>
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi ke instruktur/tentor pengampu.
     *
     * @return BelongsToMany<User, $this>
     */
    public function instructors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'training_instructors', 'training_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Relasi ke daftar sesi pelatihan.
     *
     * @return HasMany<TrainingSession, $this>
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(TrainingSession::class, 'training_id')
            ->orderBy('session_date')
            ->orderBy('start_time');
    }

    /**
     * Local scope untuk pelatihan yang dipublikasikan.
     *
     * @param  Builder<Training>  $query
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', TrainingStatus::Published->value);
    }

    /**
     * Local scope filter pencarian dan kriteria.
     *
     * @param  Builder<Training>  $query
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        $query->when(! empty($filters['search']), function (Builder $q) use ($filters) {
            $search = $filters['search'];
            $q->where(function (Builder $sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        });

        $query->when(! empty($filters['category_id']), function (Builder $q) use ($filters) {
            $q->where('category_id', $filters['category_id']);
        });

        $query->when(! empty($filters['mode']), function (Builder $q) use ($filters) {
            $mode = $filters['mode'] instanceof TrainingMode ? $filters['mode']->value : $filters['mode'];
            $q->where('mode', $mode);
        });

        $query->when(! empty($filters['status']), function (Builder $q) use ($filters) {
            $status = $filters['status'] instanceof TrainingStatus ? $filters['status']->value : $filters['status'];
            $q->where('status', $status);
        });

        $query->when(! empty($filters['audience']), function (Builder $q) use ($filters) {
            $audience = $filters['audience'] instanceof TrainingAudience ? $filters['audience']->value : $filters['audience'];
            $q->where('audience', $audience);
        });

        return $query;
    }
}
