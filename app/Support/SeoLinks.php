<?php

namespace App\Support;

class SeoLinks
{
    /**
     * Map logical page keys to per-language full URLs.
     */
    public static function pageUrls(string $pageKey): array
    {
        return match ($pageKey) {
            'home' => [
                'et-EE' => 'https://cityee.ee/',
                'ru-EE' => 'https://ru.cityee.ee/',
                'en-EE' => 'https://en.cityee.ee/',
            ],
            'sell' => [
                'et-EE' => 'https://cityee.ee/kinnisvara-muuk/',
                'ru-EE' => 'https://ru.cityee.ee/kinnisvara-muuk/',
                'en-EE' => 'https://en.cityee.ee/sell-property/',
            ],
            'rent' => [
                'et-EE' => 'https://cityee.ee/kinnisvara-uur/',
                'ru-EE' => 'https://ru.cityee.ee/kinnisvara-uur/',
                'en-EE' => 'https://en.cityee.ee/rent-out-property/',
            ],
            'consultation' => [
                'et-EE' => 'https://cityee.ee/konsultatsioon/',
                'ru-EE' => 'https://ru.cityee.ee/konsultatsioon/',
                'en-EE' => 'https://en.cityee.ee/consultation/',
            ],
            'contacts' => [
                'et-EE' => 'https://cityee.ee/kontaktid/',
                'ru-EE' => 'https://ru.cityee.ee/kontaktid/',
                'en-EE' => 'https://en.cityee.ee/contacts/',
            ],
            'comparison', 'why' => [
                'et-EE' => 'https://cityee.ee/miks-cityee/',
                'ru-EE' => 'https://ru.cityee.ee/pochemu-cityee/',
                'en-EE' => 'https://en.cityee.ee/why-cityee/',
            ],
            'audit' => [
                'et-EE' => 'https://cityee.ee/audit/',
                'ru-EE' => 'https://ru.cityee.ee/audit/',
                'en-EE' => 'https://en.cityee.ee/audit/',
            ],
            'knowledge' => [
                'et-EE' => 'https://cityee.ee/knowledge/',
                'ru-EE' => 'https://ru.cityee.ee/knowledge/',
                'en-EE' => 'https://en.cityee.ee/knowledge/',
            ],
            default => throw new \InvalidArgumentException("Unknown pageKey: {$pageKey}")
        };
    }

    /**
     * Get canonical URL for the given page key and current language.
     */
    public static function canonical(string $pageKey): string
    {
        $lang = Lang::current();
        return self::pageUrls($pageKey)[$lang];
    }

    /**
     * Get hreflang array for the given page key.
     */
    public static function hreflang(string $pageKey): array
    {
        $urls = self::pageUrls($pageKey);

        return [
            ['hreflang' => 'et', 'href' => $urls['et-EE']],
            ['hreflang' => 'ru', 'href' => $urls['ru-EE']],
            ['hreflang' => 'en', 'href' => $urls['en-EE']],
            ['hreflang' => 'x-default', 'href' => $urls['et-EE']],
        ];
    }

    /**
     * Get alternates map (used for seo-links partial).
     */
    public static function alternates(string $pageKey): array
    {
        $urls = self::pageUrls($pageKey);
        $urls['x-default'] = $urls['et-EE'];
        return $urls;
    }
}
