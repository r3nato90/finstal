<?php

namespace App\Enums\Phase;

use App\Enums\EnumTrait;

enum PhaseType: string
{
    use EnumTrait;

    case PRESALE = 'presale';
    case PUBLIC_SALE = 'public_sale';


    public static function getName(string $status): string {
        return match($status) {
            self::PRESALE->value => 'Presale',
            self::PUBLIC_SALE->value => 'Public Sale',
            default => 'Default'
        };
    }
}
