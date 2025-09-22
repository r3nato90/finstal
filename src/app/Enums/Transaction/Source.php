<?php

namespace App\Enums\Transaction;

use App\Enums\EnumTrait;

enum Source: int
{
    use EnumTrait;

    case ALL = 1;
    case MATRIX = 2;
    case INVESTMENT = 3;
    case TRADE = 4;
    case ICO = 5;


    public static function getColor(int $status): string {
        return match($status) {
            self::ALL->value => 'badge--primary',
            self::MATRIX->value => 'badge--info',
            self::INVESTMENT->value => 'badge--success',
            self::TRADE->value => 'badge--danger',
            default => 'badge--danger'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::ALL->value => 'All',
            self::MATRIX->value => 'Matrix',
            self::INVESTMENT->value => 'Investment',
            self::TRADE->value => 'Trade',
            default => 'Ico'
        };
    }
}
