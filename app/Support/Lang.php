<?php

namespace App\Support;

class Lang
{
    public static function current(): string
    {
        $host = request()->getHost();

        if (str_starts_with($host, 'ru.')) return 'ru-EE';
        if (str_starts_with($host, 'en.')) return 'en-EE';

        return 'et-EE';
    }

    public static function short(?string $lang = null): string
    {
        $lang = $lang ?: self::current();

        return match ($lang) {
            'ru-EE' => 'ru',
            'en-EE' => 'en',
            default => 'et',
        };
    }

    public static function baseUrl(?string $lang = null): string
    {
        $lang = $lang ?: self::current();

        return match ($lang) {
            'ru-EE' => 'https://ru.cityee.ee',
            'en-EE' => 'https://en.cityee.ee',
            default => 'https://cityee.ee',
        };
    }

    /**
     * Check if the current request is local/dev environment.
     * In dev, we detect language from the route prefix instead of domain.
     */
    public static function isLocal(): bool
    {
        $host = request()->getHost();
        return in_array($host, ['localhost', '127.0.0.1']) || str_contains($host, '.test');
    }

    /**
     * Get locale from route prefix for local development.
     * Falls back to domain-based detection in production.
     */
    public static function detect(): string
    {
        // In production: domain-based
        if (!self::isLocal()) {
            return self::current();
        }

        // In local/dev: use app locale set by route middleware
        return match (app()->getLocale()) {
            'ru' => 'ru-EE',
            'en' => 'en-EE',
            default => 'et-EE',
        };
    }
}
