<?php

namespace App\Enums;

enum TrainingAudience: string
{
    case Guru = 'guru';
    case Siswa = 'siswa';
    case Umum = 'umum';
    case Vokasi = 'vokasi';

    public function label(): string
    {
        return match ($this) {
            self::Guru => 'Guru & Tenaga Pendidik',
            self::Siswa => 'Siswa / Mahasiswa',
            self::Umum => 'Masyarakat Umum',
            self::Vokasi => 'Peminat Vokasi & Industri',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Guru => 'bg-secondary-fixed text-on-secondary-fixed',
            self::Siswa => 'bg-tertiary-fixed text-primary',
            self::Umum => 'bg-surface-container-high text-on-surface-variant',
            self::Vokasi => 'bg-primary-container text-white',
        };
    }
}
