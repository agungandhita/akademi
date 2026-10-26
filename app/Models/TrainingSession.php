<?php

namespace App\Models;

use App\Enums\SessionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingSession extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'training_id',
        'title',
        'session_type',
        'session_date',
        'start_time',
        'end_time',
        'location',
        'meeting_url',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'session_type' => SessionType::class,
            'session_date' => 'date',
        ];
    }

    /**
     * Relasi ke pelatihan induk.
     *
     * @return BelongsTo<Training, $this>
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class, 'training_id');
    }
}
