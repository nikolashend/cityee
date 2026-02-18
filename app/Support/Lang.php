<?php

namespace App\Support;

/**
 * Language helper — single-domain, path-based architecture.
 * Language is always determined by app()->getLocale() set by route middleware.
 * No subdomain detection needed.
 */
class Lang
{
    private const BASE = 'https://cityee.ee';

    /**
     * Current locale shortcode: 'et', 'ru', 'en'
     */
    public static function current(): string
    {
        return app()->getLocale() ?: 'et';
    }

    /**
     * Alias for current() — kept for backward compat.
     */
    public static function short(?string $lang = null): string
    {
        return $lang ?: self::current();
    }

    /**
     * Base URL — always the single canonical domain.
     */
    public static function baseUrl(?string $lang = null): string
    {
        return self::BASE;
    }

    /**
     * Build a full URL for a given locale and optional path.
     * ET (default): https://cityee.ee/{path}
     * RU: https://cityee.ee/ru/{path}
     * EN: https://cityee.ee/en/{path}
     */
    public static function url(?string $lang = null, string $path = ''): string
    {
        $lang = $lang ?: self::current();
        $prefix = match ($lang) {
            'ru' => '/ru',
            'en' => '/en',
            default => '',
        };

        $path = ltrim($path, '/');
        return self::BASE . $prefix . ($path ? "/{$path}" : '/');
    }

    /**
     * Check if the current request is local/dev environment.
     */
    public static function isLocal(): bool
    {
        $host = request()->getHost();
        return in_array($host, ['localhost', '127.0.0.1']) || str_contains($host, '.test');
    }

    /**
     * Detect current locale — delegates to app locale (set by route prefix middleware).
     */
    public static function detect(): string
    {
        return self::current();
    }
}
