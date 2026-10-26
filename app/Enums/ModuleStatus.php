<?php

namespace App\Enums;

enum ModuleStatus: string
{
    case Draft = 'draft';
    case Published = 'published';

    /**
     * Label bahasa Indonesia untuk status modul.
     */
    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draf (Belum Terbit)',
            self::Published => 'Diterbitkan (Aktif)',
        };
    }

    /**
     * Styling badge Tailwind.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Draft => 'bg-surface-container-high text-on-surface-variant',
            self::Published => 'bg-secondary-fixed text-on-secondary-fixed',
        };
    }
}
