<?php

namespace App\Enums;

enum TrainingStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Closed = 'closed';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft (Konsep)',
            self::Published => 'Published (Terbit)',
            self::Closed => 'Closed (Ditutup)',
            self::Archived => 'Archived (Diarsipkan)',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'bg-surface-container text-on-surface-variant',
            self::Published => 'bg-secondary text-white font-bold',
            self::Closed => 'bg-error-container text-on-error-container',
            self::Archived => 'bg-surface-container-high text-outline',
        };
    }
}
