<?php

namespace App\Enums;

enum TrainingMode: string
{
    case Online = 'online';
    case Offline = 'offline';
    case Blended = 'blended';

    public function label(): string
    {
        return match ($this) {
            self::Online => 'Online (Daring Penuh)',
            self::Offline => 'Offline (Tatap Muka)',
            self::Blended => 'Blended (Campuran)',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Online => 'bg-secondary-fixed text-on-secondary-fixed',
            self::Offline => 'bg-surface-container-high text-primary',
            self::Blended => 'bg-tertiary-fixed text-primary',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Online => 'videocam',
            self::Offline => 'location_on',
            self::Blended => 'devices_other',
        };
    }
}
