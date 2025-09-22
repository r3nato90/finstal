<?php

namespace App\Enums\Ico;

use App\Enums\EnumTrait;

enum PurchaseStatus: int
{
    use EnumTrait;

    case PENDING = 1;
    case COMPLETED = 2;


    public static function getColor(int $status): string {
        return match($status) {
            self::PENDING->value => 'badge--primary',
            self::COMPLETED->value => 'badge--success',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::PENDING->value => 'Pending',
            self::COMPLETED->value => 'Completed',
            default => 'Default'
        };
    }

}
