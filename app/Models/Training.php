<?php

namespace App\Models;

use App\Enums\EnrollmentStatus;
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
     * Relasi ke seluruh pendaftaran pelatihan.
     *
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'training_id');
    }

    /**
     * Relasi ke modul pembelajaran pelatihan.
     *
     * @return HasMany<Module, $this>
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'training_id')->ordered();
    }

    /**
     * Relasi ke peserta yang terdaftar di pelatihan.
     *
     * @return BelongsToMany<User, $this>
     */
    public function participants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'enrollments', 'training_id', 'user_id')
            ->withPivot(['id', 'status', 'enrolled_at', 'cancelled_at', 'completed_at'])
            ->withTimestamps();
    }

    /**
     * Hitung jumlah peserta aktif terdaftar secara realtime.
     */
    public function getEnrolledCountAttribute(): int
    {
        if (array_key_exists('active_enrollments_count', $this->attributes)) {
            return (int) $this->attributes['active_enrollments_count'];
        }

        if (array_key_exists('enrollments_count', $this->attributes)) {
            return (int) $this->attributes['enrollments_count'];
        }

        if ($this->relationLoaded('enrollments')) {
            return $this->enrollments->where('status', '!=', EnrollmentStatus::Cancelled)->count();
        }

        return $this->enrollments()->where('status', '!=', EnrollmentStatus::Cancelled->value)->count();
    }

    /**
     * Hitung sisa kuota yang tersedia (null jika tanpa batas kuota).
     */
    public function getRemainingQuotaAttribute(): ?int
    {
        if ($this->quota === null) {
            return null;
        }

        return max(0, $this->quota - $this->enrolled_count);
    }

    /**
     * Cek apakah kuota pendaftaran sudah penuh.
     */
    public function getIsQuotaFullAttribute(): bool
    {
        if ($this->quota === null) {
            return false;
        }

        return $this->remaining_quota <= 0;
    }

    /**
     * Cek apakah waktu pendaftaran sudah berakhir/habis.
     */
    public function getIsRegistrationEndedAttribute(): bool
    {
        return (bool) ($this->registration_end && $this->registration_end->endOfDay()->isPast());
    }

    /**
     * Cek apakah waktu pendaftaran belum dibuka.
     */
    public function getIsRegistrationNotStartedAttribute(): bool
    {
        return (bool) ($this->registration_start && $this->registration_start->startOfDay()->isFuture());
    }

    /**
     * Cek apakah pendaftaran pelatihan saat ini aktif dan dapat dilakukan.
     */
    public function getIsRegistrationOpenAttribute(): bool
    {
        if ($this->status !== TrainingStatus::Published) {
            return false;
        }

        if ($this->is_registration_ended) {
            return false;
        }

        if ($this->is_registration_not_started) {
            return false;
        }

        if ($this->is_quota_full) {
            return false;
        }

        return true;
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
