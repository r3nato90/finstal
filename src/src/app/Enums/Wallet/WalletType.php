<?php

namespace App\Enums\Wallet;

use App\Enums\EnumTrait;

enum WalletType: string
{
    use EnumTrait;

    case PRIMARY = 'primary';
    case ICO = 'ico';
}
