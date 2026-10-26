<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case Registered = 'registered';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Registered => 'Terdaftar',
            self::Cancelled => 'Dibatalkan',
            self::Completed => 'Selesai',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Registered => 'bg-secondary-fixed text-on-secondary-fixed',
            self::Cancelled => 'bg-error-container/40 text-error',
            self::Completed => 'bg-tertiary-fixed text-primary',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::Registered => 'how_to_reg',
            self::Cancelled => 'cancel',
            self::Completed => 'check_circle',
        };
    }
}
