<?php

namespace App\Enums;

enum PostType: string
{
    case Berita = 'berita';
    case Artikel = 'artikel';

    public function label(): string
    {
        return match ($this) {
            self::Berita => 'Berita',
            self::Artikel => 'Artikel',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Berita => 'bg-secondary-fixed text-on-secondary-fixed',
            self::Artikel => 'bg-tertiary-fixed text-on-tertiary-fixed',
        };
    }
}
