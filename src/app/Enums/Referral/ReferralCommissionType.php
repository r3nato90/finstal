<?php

namespace App\Enums\Referral;

use App\Enums\EnumTrait;

enum ReferralCommissionType: int
{
    use EnumTrait;

    case DEPOSIT = 1;
    case INVESTMENT = 2;
    case INTEREST_RATE = 3;
    case ICO_TOKEN = 4;

    public static function commissionTypes(): array
    {
        return [
            self::INVESTMENT->value => 'Investment Commission',
            self::DEPOSIT->value => 'Deposit Commission',
            self::INTEREST_RATE->value => 'Interest Rate Commission',
            self::ICO_TOKEN->value => 'Ico Token Commission',
        ];
    }

    public static function getName(int $status): string {
        return match ($status) {
            self::INVESTMENT->value => 'Investment Commission',
            self::DEPOSIT->value => 'Deposit Commission',
            self::INTEREST_RATE->value => 'Interest Rate Commission',
            self::ICO_TOKEN->value => 'Ico Token Commission',
            default => 'Default'
        };
    }

    public static function getColumnName(int $status): string {
        return match ($status) {
            self::INVESTMENT->value => 'investment',
            self::DEPOSIT->value => 'deposit',
            self::INTEREST_RATE->value => 'interest_rate',
            self::ICO_TOKEN->value => 'ico_token',
            default => 'Default'
        };
    }


    public static function getColumns(): array {
        return ['investment', 'deposit', 'interest_rate', 'ico_token'];
    }
}
