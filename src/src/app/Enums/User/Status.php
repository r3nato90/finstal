<?php

declare(strict_types=1);

namespace App\Enums\User;

use App\Enums\EnumTrait;

enum Status: int
{
    use EnumTrait;

    case ACTIVE = 1;
    case BANNED = 2;
    case PENDING = 0;

    public static function getColor(int $status): string {
        return match($status) {
            self::ACTIVE->value => 'badge--success',
            self::BANNED->value => 'badge--danger',
            self::PENDING->value => 'badge--primary',
            default => 'black'
        };
    }

    public static function getName(int $status): string {
        return match($status) {
            self::ACTIVE->value => 'Active',
            self::BANNED->value => 'Banned',
            self::PENDING->value => 'Pending',
            default => 'Default'
        };
    }

}
