<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description'
    ];

    public static function get(string $key, $default = null)
    {
        $cacheKey = "setting.{$key}";
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            if (!$setting) {
                return $default;
            }

            return match ($setting->type) {
                'boolean' => (bool) $setting->value,
                'integer' => (int) $setting->value,
                'float' => (float) $setting->value,
                'json' => json_decode($setting->value, true),
                default => $setting->value
            };
        });
    }

    public static function set($key, $value, $type = null, $label = null, $group = 'general'): void
    {
        $setting = self::where('key', $key)->first();
        if ($type === null) {
            $type = is_array($value) ? 'json' : 'text';
        }

        $processedValue = match($type) {
            'boolean' => $value ? '1' : '0',
            'json' => is_array($value) ? json_encode($value) : $value,
            'array' => is_array($value) ? json_encode($value) : $value,
            default => is_array($value) ? json_encode($value) : $value
        };

        if ($setting) {
            $setting->update([
                'value' => $processedValue,
                'type' => $type
            ]);
        } else {
            self::create([
                'key' => $key,
                'value' => $processedValue,
                'type' => $type,
                'label' => $label ?: ucwords(str_replace('_', ' ', $key)),
                'group' => $group
            ]);
        }

        Cache::forget("setting.{$key}");
    }

    public static function getByGroup($group)
    {
        return self::where('group', $group)->get()->mapWithKeys(function ($setting) {
            $value = match($setting->type) {
                'boolean' => (bool) $setting->value,
                'json', 'array' => json_decode($setting->value, true),
                default => $setting->value
            };

            return [$setting->key => $value];
        });
    }

    public static function clearCache(): void
    {
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }

        $groups = static::distinct('group')->pluck('group');
        foreach ($groups as $group) {
            Cache::forget("settings.group.{$group}");
        }
    }
}
