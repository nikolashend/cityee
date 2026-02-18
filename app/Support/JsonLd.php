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
            '@id'      => 'https://cityee.ee/#service-' . $pageKey,
            'name'     => $t['h1'] ?? '',
            'description' => $t['meta_description'] ?? '',
            'provider' => ['@id' => 'https://cityee.ee/#org'],
            'areaServed' => [
                ['@type' => 'City',  'name' => 'Tallinn'],
                ['@type' => 'AdministrativeArea', 'name' => 'Harjumaa'],
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
     * Accepts either an array of $t values or individual parameters.
     */
    public static function article(
        string|array $titleOrT,
        ?string $url = null,
        ?string $description = null,
        ?string $datePublished = null,
        ?string $dateModified = null
    ): string {
        if (is_array($titleOrT)) {
            $t = $titleOrT;
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
        } else {
            $data = [
                '@context'      => 'https://schema.org',
                '@type'         => 'Article',
                'headline'      => $titleOrT,
                'url'           => $url,
                'description'   => $description ?? '',
                'author'        => ['@id' => 'https://cityee.ee/#org'],
                'publisher'     => ['@id' => 'https://cityee.ee/#org'],
                'datePublished' => $datePublished ?? now()->toIso8601String(),
                'dateModified'  => $dateModified ?? now()->toIso8601String(),
                'inLanguage'    => Lang::short(),
            ];
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

    /**
     * HowTo JSON-LD — step-by-step guides for AI/GEO.
     * @param string $name  Title of the how-to
     * @param array  $steps [['name' => '...', 'text' => '...'], ...]
     * @param string|null $description
     */
    public static function howTo(string $name, array $steps, ?string $description = null): string
    {
        $howToSteps = array_map(fn($s, $i) => [
            '@type'    => 'HowToStep',
            'position' => $i + 1,
            'name'     => $s['name'] ?? "Step " . ($i + 1),
            'text'     => $s['text'] ?? '',
        ], $steps, array_keys($steps));

        $data = [
            '@context' => 'https://schema.org',
            '@type'    => 'HowTo',
            'name'     => $name,
            'step'     => $howToSteps,
        ];

        if ($description) {
            $data['description'] = $description;
        }

        return self::scriptTag([$data]);
    }

    /**
     * QAPage JSON-LD — single Q&A for voice search / conversational SEO.
     */
    public static function qaPage(string $question, string $answer, ?string $url = null): string
    {
        $data = [
            '@context'   => 'https://schema.org',
            '@type'      => 'QAPage',
            'mainEntity' => [
                '@type'          => 'Question',
                'name'           => $question,
                'text'           => $question,
                'answerCount'    => 1,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => strip_tags($answer),
                ],
            ],
        ];

        if ($url) {
            $data['url'] = $url;
        }

        return self::scriptTag([$data]);
    }

    /**
     * CollectionPage JSON-LD — for index/listing pages (guides hub, audits hub).
     */
    public static function collectionPage(string $name, string $url, ?string $description = null): string
    {
        $data = [
            '@context'   => 'https://schema.org',
            '@type'      => 'CollectionPage',
            'name'       => $name,
            'url'        => $url,
            'inLanguage' => Lang::short(),
            'isPartOf'   => ['@id' => 'https://cityee.ee/#org'],
        ];

        if ($description) {
            $data['description'] = $description;
        }

        return self::scriptTag([$data]);
    }

    /**
     * ItemList JSON-LD — ordered list of items (guides, audits, resources).
     */
    public static function itemList(array $items): string
    {
        $elements = array_map(fn($item, $i) => [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'url'      => $item['url'] ?? '',
            'name'     => $item['name'] ?? '',
        ], $items, array_keys($items));

        $data = [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            'itemListElement' => $elements,
        ];

        return self::scriptTag([$data]);
    }

    /**
     * ProfilePage JSON-LD — author/expert profile for EEAT signals.
     */
    public static function profilePage(string $name, string $url, array $expertise = []): string
    {
        $data = [
            '@context'    => 'https://schema.org',
            '@type'       => 'ProfilePage',
            'mainEntity'  => Schema::personJsonLd(),
            'name'        => $name,
            'url'         => $url,
        ];

        return self::scriptTag([$data]);
    }

    // ──────────────────────────────────────────────
    //  Helpers
    // ──────────────────────────────────────────────

    private static function faqEntities(array $faq): array
    {
        return array_map(fn($item) => [
            '@type'          => 'Question',
            'name'           => $item['q'] ?? $item['question'] ?? '',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => strip_tags($item['a'] ?? $item['answer'] ?? ''),
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
