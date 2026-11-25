<?php

declare(strict_types=1);

namespace App\Enums;

enum IrrigationType: string
{
    case Paid = 'paid';
    case Rainfed = 'rainfed';

    public function label(): string
    {
        return match ($this) {
            self::Paid => 'Irigasi Berbayar (Zakat 5%)',
            self::Rainfed => 'Tadah Hujan/Gratis (Zakat 10%)',
        };
    }

    public function zakatRate(): float
    {
        return match ($this) {
            self::Paid => 0.05,
            self::Rainfed => 0.10,
        };
    }

    public function zakatPercent(): int
    {
        return match ($this) {
            self::Paid => 5,
            self::Rainfed => 10,
        };
    }
}
