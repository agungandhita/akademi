<?php

namespace App\Models;

use App\Enums\ModuleStatus;
use App\Enums\ModuleType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'training_id',
        'created_by',
        'title',
        'description',
        'type',
        'content',
        'file_path',
        'url',
        'sort_order',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ModuleType::class,
            'status' => ModuleStatus::class,
            'sort_order' => 'integer',
        ];
    }

    /**
     * Relasi ke Pelatihan induk.
     */
    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    /**
     * Relasi ke pembuat modul (User/Tentor).
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Local Scope: Modul yang berstatus diterbitkan (published).
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ModuleStatus::Published->value);
    }

    /**
     * Local Scope: Diurutkan berdasarkan sort_order.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'asc');
    }
}
