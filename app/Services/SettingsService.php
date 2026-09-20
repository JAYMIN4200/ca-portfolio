<?php

namespace App\Services;

use App\Models\Setting;

class SettingsService
{
    protected static ?array $cache = null;

    public static function get(string $key, ?string $default = null): ?string
    {
        if (static::$cache === null) {
            static::$cache = Setting::pluck('value', 'key')->toArray();
        }

        return static::$cache[$key] ?? $default;
    }

    public static function set(string $key, ?string $value, string $group = 'general'): void
    {
        Setting::setValue($key, $value, $group);
        static::$cache = null;
    }

    public static function group(string $group): array
    {
        return Setting::getGroup($group);
    }

    public static function setGroup(string $group, array $data): void
    {
        Setting::setGroup($group, $data);
        static::$cache = null;
    }

    public static function all(): array
    {
        return Setting::pluck('value', 'key')->toArray();
    }

    public static function flushCache(): void
    {
        static::$cache = null;
    }
}
