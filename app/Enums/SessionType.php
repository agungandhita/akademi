<?php

namespace App\Enums;

enum SessionType: string
{
    case Online = 'online';
    case Offline = 'offline';

    public function label(): string
    {
        return match ($this) {
            self::Online => 'Sesi Online (Virtual)',
            self::Offline => 'Sesi Offline (Tatap Muka)',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Online => 'videocam',
            self::Offline => 'location_on',
        };
    }
}
