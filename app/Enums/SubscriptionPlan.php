<?php

declare(strict_types=1);

namespace App\Enums;

enum SubscriptionPlan: string
{
    case Monthly = 'monthly';
    case Quarterly = 'quarterly';
    case Retail1Kg = 'retail_1kg';
    case Retail3Kg = 'retail_3kg';
    case Retail5Kg = 'retail_5kg';

    public function label(): string
    {
        return match ($this) {
            self::Monthly => 'Paket Bulanan (10 kg/bulan - Rp 175.000)',
            self::Quarterly => 'Paket Musiman (3 bulan di muka - Rp 525.000)',
            self::Retail1Kg => 'Kemasan 1 Kg (Tambahan / Eceran)',
            self::Retail3Kg => 'Kemasan 3 Kg (Tambahan / Eceran)',
            self::Retail5Kg => 'Kemasan 5 Kg (Tambahan / Eceran)',
        };
    }

    public function price(): int
    {
        return match ($this) {
            self::Monthly => 175_000,
            self::Quarterly => 525_000,
            self::Retail1Kg => 17_500,
            self::Retail3Kg => 52_500,
            self::Retail5Kg => 87_500,
        };
    }

    public function grainKg(): int
    {
        return match ($this) {
            self::Monthly => 10,
            self::Quarterly => 30,
            self::Retail1Kg => 1,
            self::Retail3Kg => 3,
            self::Retail5Kg => 5,
        };
    }
}
