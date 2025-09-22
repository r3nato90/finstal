<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class SettingService
{
    public static function getSetting()
    {
        try {
            return Setting::first();
        }catch (\Exception $exception){
            return null;
        }
    }

    /**
     * @return array
     */
    public static function getKycConfiguration(): array
    {
        return self::getSetting()->kyc_configuration;
    }


    public static function isRegistrationEnabled(): bool
    {
        $config = Setting::first()->system_configuration ?? null;

        if (!$config) {
            return true;
        }

        if (!is_array($config) || !isset($config['registration_status'])) {
            return true;
        }

        return (int) $config['registration_status']['value'] === 1;
    }
}
