<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\ParticipantType;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'participant_type',
        'institution',
        'phone',
        'bio',
        'expertise',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'participant_type' => ParticipantType::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * Scope untuk mengambil pengguna yang berstatus aktif saja.
     *
     * @param  Builder<User>  $query
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope filter berdasarkan peran pengguna.
     *
     * @param  Builder<User>  $query
     */
    public function scopeRole(Builder $query, UserRole|string $role): Builder
    {
        $roleValue = $role instanceof UserRole ? $role->value : $role;

        return $query->where('role', $roleValue);
    }

    /**
     * Cek apakah pengguna memiliki peran Administrator.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    /**
     * Cek apakah pengguna memiliki peran Tentor/Instruktur.
     */
    public function isTentor(): bool
    {
        return $this->role === UserRole::Tentor;
    }

    /**
     * Cek apakah pengguna memiliki peran Peserta.
     */
    public function isPeserta(): bool
    {
        return $this->role === UserRole::Peserta;
    }

    /**
     * Relasi ke pelatihan yang dibuat oleh user (admin).
     */
    public function createdTrainings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Training::class, 'created_by');
    }

    /**
     * Relasi ke pelatihan yang ditugaskan kepada user (tentor).
     */
    public function assignedTrainings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Training::class, 'training_instructors', 'user_id', 'training_id')
            ->withTimestamps();
    }

    /**
     * Relasi ke postingan berita dan artikel yang ditulis pengguna.
     */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }
}

