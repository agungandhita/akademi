<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Tentor = 'tentor';
    case Peserta = 'peserta';

    /**
     * Label representasi peran pengguna dalam Bahasa Indonesia.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Tentor => 'Tentor / Instruktur',
            self::Peserta => 'Peserta Pelatihan',
        };
    }

    /**
     * Kelas styling badge Tailwind sesuai Design System Akademi Pelatihan.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Admin => 'bg-[#001539] text-white',
            self::Tentor => 'bg-[#0051d5] text-white',
            self::Peserta => 'bg-[#dbe1ff] text-[#00174b]',
        };
    }

    /**
     * Nama icon Material Symbols untuk peran.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Admin => 'admin_panel_settings',
            self::Tentor => 'co_present',
            self::Peserta => 'school',
        };
    }
}
