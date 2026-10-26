<?php

namespace App\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft (Konsep)',
            self::Published => 'Published (Terbit)',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'bg-surface-container text-on-surface-variant font-medium',
            self::Published => 'bg-secondary text-white font-bold',
        };
    }
}
