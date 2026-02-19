<?php

namespace App\Support;

class SeoLinks
{
    private const BASE = 'https://cityee.ee';

    /**
     * Map logical page keys to per-language full URLs.
     * Single domain, path-based language structure:
     *   ET: https://cityee.ee/{slug}
     *   RU: https://cityee.ee/ru/{slug}
     *   EN: https://cityee.ee/en/{slug}
     */
    public static function pageUrls(string $pageKey): array
    {
        $base = self::BASE;

        return match ($pageKey) {
            'home' => [
                'et' => "{$base}/",
                'ru' => "{$base}/ru/",
                'en' => "{$base}/en/",
            ],
            'sell' => [
                'et' => "{$base}/kinnisvara-muuk/",
                'ru' => "{$base}/ru/kinnisvara-muuk/",
                'en' => "{$base}/en/sell-property/",
            ],
            'rent' => [
                'et' => "{$base}/kinnisvara-uur/",
                'ru' => "{$base}/ru/kinnisvara-uur/",
                'en' => "{$base}/en/rent-out-property/",
            ],
            'consultation' => [
                'et' => "{$base}/konsultatsioon/",
                'ru' => "{$base}/ru/konsultatsioon/",
                'en' => "{$base}/en/consultation/",
            ],
            'contacts' => [
                'et' => "{$base}/kontaktid/",
                'ru' => "{$base}/ru/kontaktid/",
                'en' => "{$base}/en/contacts/",
            ],
            'comparison', 'why' => [
                'et' => "{$base}/miks-cityee/",
                'ru' => "{$base}/ru/pochemu-cityee/",
                'en' => "{$base}/en/why-cityee/",
            ],
            'audit' => [
                'et' => "{$base}/audit/",
                'ru' => "{$base}/ru/audit/",
                'en' => "{$base}/en/audit/",
            ],
            'knowledge' => [
                'et' => "{$base}/knowledge/",
                'ru' => "{$base}/ru/knowledge/",
                'en' => "{$base}/en/knowledge/",
            ],
            'dashboard' => [
                'et' => "{$base}/dashboard/",
                'ru' => "{$base}/ru/dashboard/",
                'en' => "{$base}/en/dashboard/",
            ],
            'guides' => [
                'et' => "{$base}/guides/",
                'ru' => "{$base}/ru/guides/",
                'en' => "{$base}/en/guides/",
            ],
            'audits' => [
                'et' => "{$base}/audits/",
                'ru' => "{$base}/ru/audits/",
                'en' => "{$base}/en/audits/",
            ],
            default => throw new \InvalidArgumentException("Unknown pageKey: {$pageKey}")
        };
    }

    /**
     * Get canonical URL for the given page key and current language.
     */
    public static function canonical(string $pageKey): string
    {
        $lang = app()->getLocale() ?: 'et';
        return self::pageUrls($pageKey)[$lang] ?? self::pageUrls($pageKey)['et'];
    }

    /**
     * Get hreflang array for the given page key.
     */
    public static function hreflang(string $pageKey): array
    {
        $urls = self::pageUrls($pageKey);

        return [
            ['hreflang' => 'et-EE', 'href' => $urls['et']],
            ['hreflang' => 'ru-EE', 'href' => $urls['ru']],
            ['hreflang' => 'en-EE', 'href' => $urls['en']],
            ['hreflang' => 'x-default', 'href' => $urls['et']],
        ];
    }

    /**
     * Get alternates map.
     */
    public static function alternates(string $pageKey): array
    {
        $urls = self::pageUrls($pageKey);
        $urls['x-default'] = $urls['et'];
        return $urls;
    }
}
