<?php

declare(strict_types=1);

namespace App\Enums;

enum SubscriptionPlan: string
{
    case Monthly = 'monthly';
    case Quarterly = 'quarterly';

    public function label(): string
    {
        return match ($this) {
            self::Monthly => 'Paket Bulanan (10 kg/bulan - Rp 175.000)',
            self::Quarterly => 'Paket Musiman (3 bulan di muka - Rp 525.000)',
        };
    }

    public function price(): int
    {
        return match ($this) {
            self::Monthly => 175_000,
            self::Quarterly => 525_000,
        };
    }

    public function grainKg(): int
    {
        return match ($this) {
            self::Monthly => 10,
            self::Quarterly => 30,
        };
    }
}
