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
            'why' => [
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
            'profile' => [
                'et' => "{$base}/aleksandr-primakov/",
                'ru' => "{$base}/ru/aleksandr-primakov/",
                'en' => "{$base}/en/aleksandr-primakov/",
            ],
            'no_calls' => [
                'et' => "{$base}/muud-ise-keegi-ei-helista/",
                'ru' => "{$base}/ru/prodayu-sam-nikto-ne-zvonit/",
                'en' => "{$base}/en/selling-yourself-no-calls/",
            ],
            'no_offers' => [
                'et' => "{$base}/vaatamised-aga-pakkumisi-pole/",
                'ru' => "{$base}/ru/prosmotry-est-predlozheniy-net/",
                'en' => "{$base}/en/viewings-but-no-offers/",
            ],
            'price_analysis' => [
                'et' => "{$base}/kinnisvara-hinnaanaluus-tallinn/",
                'ru' => "{$base}/ru/analiz-ceny-nedvizhimosti-tallinn/",
                'en' => "{$base}/en/property-price-analysis-tallinn/",
            ],
            'mistakes' => [
                'et' => "{$base}/vead-kinnisvara-muugil/",
                'ru' => "{$base}/ru/oshibki-pri-prodazhe/",
                'en' => "{$base}/en/mistakes-selling-property/",
            ],
            'sell_faster' => [
                'et' => "{$base}/kuidas-muua-kiiremini/",
                'ru' => "{$base}/ru/kak-prodat-bystree/",
                'en' => "{$base}/en/how-to-sell-faster/",
            ],
            'listing_audit' => [
                'et' => "{$base}/kuulutuse-audit/",
                'ru' => "{$base}/ru/audit-obyavleniya/",
                'en' => "{$base}/en/listing-audit/",
            ],
            'comparison' => [
                'et' => "{$base}/muua-ise-vs-strateegiline-partner/",
                'ru' => "{$base}/ru/prodat-samomu-vs-partner/",
                'en' => "{$base}/en/sell-yourself-vs-strategy-partner/",
            ],
            // Phase 5 — cases page
            'cases' => [
                'et' => "{$base}/knowledge/cases/",
                'ru' => "{$base}/ru/knowledge/cases/",
                'en' => "{$base}/en/knowledge/cases/",
            ],
            // Phase 5 — pillar guides
            'guide_sell_tallinn' => [
                'et' => "{$base}/knowledge/terviklik-juhend-kinnisvara-muugiks-tallinnas/",
                'ru' => "{$base}/ru/knowledge/polnoe-rukovodstvo-prodazha-nedvizhimosti-tallinn/",
                'en' => "{$base}/en/knowledge/complete-guide-selling-property-tallinn/",
            ],
            'guide_rent' => [
                'et' => "{$base}/knowledge/juhend-kinnisvara-uurimine/",
                'ru' => "{$base}/ru/knowledge/rukovodstvo-sdacha-v-arendu/",
                'en' => "{$base}/en/knowledge/guide-renting-out-property/",
            ],
            'guide_pricing' => [
                'et' => "{$base}/knowledge/kuidas-maarata-kinnisvara-turuhind/",
                'ru' => "{$base}/ru/knowledge/kak-opredelit-rynochnuyu-cenu/",
                'en' => "{$base}/en/knowledge/how-to-determine-market-price/",
            ],
            'guide_negotiation' => [
                'et' => "{$base}/knowledge/labirakimiste-strateegia-kinnisvara/",
                'ru' => "{$base}/ru/knowledge/peregovornaya-strategiya-nedvizhimost/",
                'en' => "{$base}/en/knowledge/negotiation-strategy-property/",
            ],
            'guide_staging' => [
                'et' => "{$base}/knowledge/kuidas-valmistada-korter-muugiks/",
                'ru' => "{$base}/ru/knowledge/kak-podgotovit-kvartiru-k-prodazhe/",
                'en' => "{$base}/en/knowledge/how-to-prepare-apartment-for-sale/",
            ],
            'guide_market_2026' => [
                'et' => "{$base}/knowledge/kinnisvara-turu-analuus-tallinn-2026/",
                'ru' => "{$base}/ru/knowledge/analiz-rynka-nedvizhimosti-tallinn-2026/",
                'en' => "{$base}/en/knowledge/real-estate-market-analysis-tallinn-2026/",
            ],
            'guide_mistakes' => [
                'et' => "{$base}/knowledge/vead-mille-parast-kaotate-raha/",
                'ru' => "{$base}/ru/knowledge/oshibki-iz-za-kotorykh-teryayut-dengi/",
                'en' => "{$base}/en/knowledge/mistakes-that-cost-money/",
            ],

            // ── Phase 3 — RU-only intent landings ──────────────
            // et/en set to null: no mirror pages exist, hreflang() skips nulls
            'phase3.prodat-kvartiru-v-tallinne' => [
                'et' => null,
                'ru' => "{$base}/ru/prodat-kvartiru-v-tallinne/",
                'en' => null,
            ],
            'phase3.sdat-kvartiru-v-tallinne' => [
                'et' => null,
                'ru' => "{$base}/ru/sdat-kvartiru-v-tallinne/",
                'en' => null,
            ],
            'phase3.makler-v-tallinne' => [
                'et' => null,
                'ru' => "{$base}/ru/makler-v-tallinne/",
                'en' => null,
            ],
            'phase3.agentstvo-nedvizhimosti-tallinn' => [
                'et' => null,
                'ru' => "{$base}/ru/agentstvo-nedvizhimosti-tallinn/",
                'en' => null,
            ],
            'phase3.ocenka-kvartiry-v-tallinne' => [
                'et' => null,
                'ru' => "{$base}/ru/ocenka-kvartiry-v-tallinne/",
                'en' => null,
            ],
            'phase3.ne-prodaetsya-kvartira-v-tallinne' => [
                'et' => null,
                'ru' => "{$base}/ru/ne-prodaetsya-kvartira-v-tallinne/",
                'en' => null,
            ],
            'phase3.audit-nedvizhimosti-tallinn' => [
                'et' => null,
                'ru' => "{$base}/ru/audit-nedvizhimosti-tallinn/",
                'en' => null,
            ],
            'phase3.o-kompanii' => [
                'et' => null,
                'ru' => "{$base}/ru/o-kompanii/",
                'en' => null,
            ],

            // ── Phase 3 — GEO hub & cases hub ──────────────────
            'phase3.geo-hub' => [
                'et' => null,
                'ru' => "{$base}/ru/tallinn/",
                'en' => null,
            ],
            'phase3.cases-hub' => [
                'et' => null,
                'ru' => "{$base}/ru/cases/",
                'en' => null,
            ],

            // ── Phase 3 — district pages ────────────────────────
            'phase3.district.lasnamae' => [
                'et' => null,
                'ru' => "{$base}/ru/tallinn/lasnamae/",
                'en' => null,
            ],
            'phase3.district.mustamae' => [
                'et' => null,
                'ru' => "{$base}/ru/tallinn/mustamae/",
                'en' => null,
            ],
            'phase3.district.kesklinn' => [
                'et' => null,
                'ru' => "{$base}/ru/tallinn/kesklinn/",
                'en' => null,
            ],
            'phase3.district.haabersti' => [
                'et' => null,
                'ru' => "{$base}/ru/tallinn/haabersti/",
                'en' => null,
            ],
            'phase3.district.kristiine' => [
                'et' => null,
                'ru' => "{$base}/ru/tallinn/kristiine/",
                'en' => null,
            ],

            // ── Phase 3 — individual case pages ─────────────────
            'phase3.case.prodali-3-komnatnuyu-kvartiru-v-kesklinn-za-16-dney' => [
                'et' => null,
                'ru' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-kesklinn-za-16-dney/",
                'en' => null,
            ],
            'phase3.case.prodali-2-komnatnuyu-kvartiru-v-kadriorg-za-24-dnya' => [
                'et' => null,
                'ru' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kadriorg-za-24-dnya/",
                'en' => null,
            ],
            'phase3.case.prodali-1-komnatnuyu-kvartiru-v-lasnamae' => [
                'et' => null,
                'ru' => "{$base}/ru/cases/prodali-1-komnatnuyu-kvartiru-v-lasnamae/",
                'en' => null,
            ],
            'phase3.case.prodali-3-komnatnuyu-kvartiru-v-lasnamae' => [
                'et' => null,
                'ru' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-lasnamae/",
                'en' => null,
            ],
            'phase3.case.prodali-2-komnatnuyu-kvartiru-v-kristiine-za-18-dney' => [
                'et' => null,
                'ru' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kristiine-za-18-dney/",
                'en' => null,
            ],
            'phase3.case.prodali-4-komnatnuyu-kvartiru-v-tiskre' => [
                'et' => null,
                'ru' => "{$base}/ru/cases/prodali-4-komnatnuyu-kvartiru-v-tiskre/",
                'en' => null,
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
        $urls = self::pageUrls($pageKey);
        return $urls[$lang] ?? $urls['et'] ?? $urls['ru'];
    }

    /**
     * Get hreflang array for the given page key.
     * Skips locales with null URLs (e.g. Phase 3 RU-only pages).
     */
    public static function hreflang(string $pageKey): array
    {
        $urls = self::pageUrls($pageKey);

        $tags = [];
        if (!empty($urls['et'])) {
            $tags[] = ['hreflang' => 'et-EE', 'href' => $urls['et']];
        }
        if (!empty($urls['ru'])) {
            $tags[] = ['hreflang' => 'ru-EE', 'href' => $urls['ru']];
        }
        if (!empty($urls['en'])) {
            $tags[] = ['hreflang' => 'en-EE', 'href' => $urls['en']];
        }
        // x-default: ET if available, otherwise RU
        $tags[] = ['hreflang' => 'x-default', 'href' => $urls['et'] ?? $urls['ru']];

        return $tags;
    }

    /**
     * Get alternates map.
     */
    public static function alternates(string $pageKey): array
    {
        $urls = array_filter(self::pageUrls($pageKey));
        $urls['x-default'] = $urls['et'] ?? $urls['ru'];
        return $urls;
    }
}
