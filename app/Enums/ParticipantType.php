<?php

namespace App\Enums;

enum ParticipantType: string
{
    case Guru = 'guru';
    case Siswa = 'siswa';
    case Praktisi = 'praktisi';
    case Umum = 'umum';

    /**
     * Label representasi tipe peserta dalam Bahasa Indonesia.
     */
    public function label(): string
    {
        return match ($this) {
            self::Guru => 'Guru & Tenaga Pendidik',
            self::Siswa => 'Siswa / Mahasiswa',
            self::Praktisi => 'Profesional & Praktisi',
            self::Umum => 'Masyarakat Umum / Vokasi',
        };
    }

    /**
     * Kelas styling badge Tailwind.
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::Guru => 'bg-secondary-fixed text-on-secondary-fixed',
            self::Siswa => 'bg-tertiary-fixed text-primary',
            self::Praktisi => 'bg-primary-container text-on-primary-container',
            self::Umum => 'bg-surface-container-high text-on-surface-variant',
        };
    }

    /**
     * Nama icon Material Symbols untuk tipe peserta.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Guru => 'badge',
            self::Siswa => 'backpack',
            self::Praktisi => 'business_center',
            self::Umum => 'person',
        };
    }
}
