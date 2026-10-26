<?php

namespace App\Models;

use App\Enums\EnrollmentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'training_id',
        'status',
        'enrolled_at',
        'cancelled_at',
        'completed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => EnrollmentStatus::class,
            'enrolled_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke peserta pelatihan.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke pelatihan.
     *
     * @return BelongsTo<Training, $this>
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    /**
     * Scope untuk peserta yang aktif terdaftar.
     *
     * @param  Builder<Enrollment>  $query
     */
    public function scopeRegistered(Builder $query): Builder
    {
        return $query->where('status', EnrollmentStatus::Registered->value);
    }

    /**
     * Scope filter pencarian dan status.
     *
     * @param  Builder<Enrollment>  $query
     */
    public function scopeFilter(Builder $query, ?string $search = null, ?string $status = null): Builder
    {
        $query->when(! empty($search), function (Builder $q) use ($search) {
            $q->whereHas('user', function (Builder $userQuery) use ($search) {
                $userQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%");
            });
        });

        $query->when(! empty($status), function (Builder $q) use ($status) {
            $statusVal = $status instanceof EnrollmentStatus ? $status->value : $status;
            $q->where('status', $statusVal);
        });

        return $query;
    }
}
