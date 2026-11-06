<?php

namespace App\Services;

use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    protected const CACHE_KEY = 'app_settings';


    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return Settings::pluck('value', 'key')->all();
        });
    }


    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        return $settings[$key] ?? $default ?? ($this->defaults[$key] ?? null);
    }


    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
