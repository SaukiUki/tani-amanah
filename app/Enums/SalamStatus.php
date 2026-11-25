<?php

declare(strict_types=1);

namespace App\Enums;

enum SalamStatus: string
{
    case Pending = 'pending';
    case Partial = 'partial';
    case Fulfilled = 'fulfilled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu panen',
            self::Partial => 'Diserahkan sebagian',
            self::Fulfilled => 'Sudah diserahkan',
        };
    }
}
