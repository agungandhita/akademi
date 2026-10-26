<?php

namespace App\Enums;

enum ModuleType: string
{
    case Text = 'text';
    case Pdf = 'pdf';
    case Video = 'video';
    case Link = 'link';

    /**
     * Label bahasa Indonesia untuk jenis modul.
     */
    public function label(): string
    {
        return match ($this) {
            self::Text => 'Teks / Bacaan',
            self::Pdf => 'Dokumen PDF',
            self::Video => 'Video Pembelajaran',
            self::Link => 'Tautan / URL Eksternal',
        };
    }

    /**
     * Nama ikon Material Symbols.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Text => 'article',
            self::Pdf => 'picture_as_pdf',
            self::Video => 'play_circle',
            self::Link => 'link',
        };
    }

    /**
     * Styling badge Tailwind.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Text => 'bg-secondary-fixed text-on-secondary-fixed',
            self::Pdf => 'bg-error-container text-error',
            self::Video => 'bg-primary-container text-on-primary-container',
            self::Link => 'bg-surface-container-high text-on-surface-variant',
        };
    }
}
