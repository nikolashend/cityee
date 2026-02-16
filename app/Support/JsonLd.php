<?php

namespace App\Support;

/**
 * Build per-page JSON-LD structured data.
 */
class JsonLd
{
    /**
     * Service page JSON-LD (sell / rent / consultation).
     */
    public static function servicePage(string $pageKey, array $t): string
    {
        $lang     = Lang::current();
        $langCode = Lang::short();

        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'Service',
            'name'     => $t['h1'] ?? '',
            'description' => $t['meta_description'] ?? '',
            'provider' => ['@id' => 'https://cityee.ee/#org'],
            'areaServed' => [
                ['@type' => 'City',  'name' => 'Tallinn'],
                ['@type' => 'State', 'name' => 'Harjumaa'],
            ],
            'inLanguage' => $langCode,
            'url' => SeoLinks::canonical($pageKey),
        ];

        if (!empty($t['faq'])) {
            $data['mainEntity'] = self::faqEntities($t['faq']);
        }

        return self::scriptTag([$data, Schema::orgJsonLd()]);
    }

    /**
     * Contact page JSON-LD.
     */
    public static function contactPage(array $t): string
    {
        $page = [
            '@context' => 'https://schema.org',
            '@type'    => 'ContactPage',
            'name'     => $t['h1'] ?? 'Kontaktid',
            'url'      => SeoLinks::canonical('contacts'),
            'mainEntity' => ['@id' => 'https://cityee.ee/#org'],
        ];

        return self::scriptTag([$page, Schema::orgJsonLd()]);
    }

    /**
     * FAQ page JSON-LD.
     */
    public static function faqPage(array $faq): string
    {
        $data = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => self::faqEntities($faq),
        ];

        return self::scriptTag([$data]);
    }

    /**
     * Article JSON-LD (for guides, audits).
     */
    public static function article(array $t): string
    {
        $data = [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => $t['h1'] ?? '',
            'description'   => $t['meta_description'] ?? '',
            'author'        => ['@id' => 'https://cityee.ee/#org'],
            'publisher'     => ['@id' => 'https://cityee.ee/#org'],
            'datePublished' => $t['date_published'] ?? now()->toIso8601String(),
            'dateModified'  => $t['date_modified'] ?? now()->toIso8601String(),
            'inLanguage'    => Lang::short(),
        ];

        if (!empty($t['image'])) {
            $data['image'] = $t['image'];
        }

        return self::scriptTag([$data, Schema::orgJsonLd()]);
    }

    /**
     * BreadcrumbList JSON-LD.
     */
    public static function breadcrumbs(array $items): string
    {
        $list = [];
        foreach ($items as $i => $item) {
            $list[] = [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $item['name'],
                'item'     => $item['url'] ?? null,
            ];
        }

        $data = [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $list,
        ];

        return self::scriptTag([$data]);
    }

    /**
     * WebPage JSON-LD.
     */
    public static function webPage(string $name, string $url, ?string $description = null): string
    {
        $data = [
            '@context'    => 'https://schema.org',
            '@type'       => 'WebPage',
            'name'        => $name,
            'url'         => $url,
            'inLanguage'  => Lang::short(),
            'isPartOf'    => ['@id' => 'https://cityee.ee/#org'],
        ];

        if ($description) {
            $data['description'] = $description;
        }

        return self::scriptTag([$data]);
    }

    // ──────────────────────────────────────────────
    //  Helpers
    // ──────────────────────────────────────────────

    private static function faqEntities(array $faq): array
    {
        return array_map(fn($item) => [
            '@type'          => 'Question',
            'name'           => $item['q'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $item['a'],
            ],
        ], $faq);
    }

    /**
     * Encode one or multiple JSON-LD objects into <script> tags.
     */
    private static function scriptTag(array $objects): string
    {
        $out = '';
        foreach ($objects as $obj) {
            $json = json_encode($obj, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            $out .= '<script type="application/ld+json">' . $json . '</script>' . "\n";
        }
        return $out;
    }
}
