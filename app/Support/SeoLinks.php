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
            'phase3.prodat-kvartiru-v-tallinne' => [
                'et' => "{$base}/ru/prodat-kvartiru-v-tallinne/",
                'ru' => "{$base}/ru/prodat-kvartiru-v-tallinne/",
                'en' => "{$base}/ru/prodat-kvartiru-v-tallinne/",
            ],
            'phase3.sdat-kvartiru-v-tallinne' => [
                'et' => "{$base}/ru/sdat-kvartiru-v-tallinne/",
                'ru' => "{$base}/ru/sdat-kvartiru-v-tallinne/",
                'en' => "{$base}/ru/sdat-kvartiru-v-tallinne/",
            ],
            'phase3.makler-v-tallinne' => [
                'et' => "{$base}/ru/makler-v-tallinne/",
                'ru' => "{$base}/ru/makler-v-tallinne/",
                'en' => "{$base}/ru/makler-v-tallinne/",
            ],
            'phase3.agentstvo-nedvizhimosti-tallinn' => [
                'et' => "{$base}/ru/agentstvo-nedvizhimosti-tallinn/",
                'ru' => "{$base}/ru/agentstvo-nedvizhimosti-tallinn/",
                'en' => "{$base}/ru/agentstvo-nedvizhimosti-tallinn/",
            ],
            'phase3.ocenka-kvartiry-v-tallinne' => [
                'et' => "{$base}/ru/ocenka-kvartiry-v-tallinne/",
                'ru' => "{$base}/ru/ocenka-kvartiry-v-tallinne/",
                'en' => "{$base}/ru/ocenka-kvartiry-v-tallinne/",
            ],
            'phase3.ne-prodaetsya-kvartira-v-tallinne' => [
                'et' => "{$base}/ru/ne-prodaetsya-kvartira-v-tallinne/",
                'ru' => "{$base}/ru/ne-prodaetsya-kvartira-v-tallinne/",
                'en' => "{$base}/ru/ne-prodaetsya-kvartira-v-tallinne/",
            ],
            'phase3.audit-nedvizhimosti-tallinn' => [
                'et' => "{$base}/ru/audit-nedvizhimosti-tallinn/",
                'ru' => "{$base}/ru/audit-nedvizhimosti-tallinn/",
                'en' => "{$base}/ru/audit-nedvizhimosti-tallinn/",
            ],
            'phase3.o-kompanii' => [
                'et' => "{$base}/ru/o-kompanii/",
                'ru' => "{$base}/ru/o-kompanii/",
                'en' => "{$base}/ru/o-kompanii/",
            ],

            // ── Phase 3 — GEO hub & cases hub ──────────────────
            'phase3.geo-hub' => [
                'et' => "{$base}/ru/tallinn/",
                'ru' => "{$base}/ru/tallinn/",
                'en' => "{$base}/ru/tallinn/",
            ],
            'phase3.cases-hub' => [
                'et' => "{$base}/ru/cases/",
                'ru' => "{$base}/ru/cases/",
                'en' => "{$base}/ru/cases/",
            ],

            // ── Phase 3 — district pages ────────────────────────
            'phase3.district.lasnamae' => [
                'et' => "{$base}/ru/tallinn/lasnamae/",
                'ru' => "{$base}/ru/tallinn/lasnamae/",
                'en' => "{$base}/ru/tallinn/lasnamae/",
            ],
            'phase3.district.mustamae' => [
                'et' => "{$base}/ru/tallinn/mustamae/",
                'ru' => "{$base}/ru/tallinn/mustamae/",
                'en' => "{$base}/ru/tallinn/mustamae/",
            ],
            'phase3.district.kesklinn' => [
                'et' => "{$base}/ru/tallinn/kesklinn/",
                'ru' => "{$base}/ru/tallinn/kesklinn/",
                'en' => "{$base}/ru/tallinn/kesklinn/",
            ],
            'phase3.district.haabersti' => [
                'et' => "{$base}/ru/tallinn/haabersti/",
                'ru' => "{$base}/ru/tallinn/haabersti/",
                'en' => "{$base}/ru/tallinn/haabersti/",
            ],
            'phase3.district.kristiine' => [
                'et' => "{$base}/ru/tallinn/kristiine/",
                'ru' => "{$base}/ru/tallinn/kristiine/",
                'en' => "{$base}/ru/tallinn/kristiine/",
            ],

            // ── Phase 3 — individual case pages ─────────────────
            'phase3.case.prodali-3-komnatnuyu-kvartiru-v-kesklinn-za-16-dney' => [
                'et' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-kesklinn-za-16-dney/",
                'ru' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-kesklinn-za-16-dney/",
                'en' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-kesklinn-za-16-dney/",
            ],
            'phase3.case.prodali-2-komnatnuyu-kvartiru-v-kadriorg-za-24-dnya' => [
                'et' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kadriorg-za-24-dnya/",
                'ru' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kadriorg-za-24-dnya/",
                'en' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kadriorg-za-24-dnya/",
            ],
            'phase3.case.prodali-1-komnatnuyu-kvartiru-v-lasnamae' => [
                'et' => "{$base}/ru/cases/prodali-1-komnatnuyu-kvartiru-v-lasnamae/",
                'ru' => "{$base}/ru/cases/prodali-1-komnatnuyu-kvartiru-v-lasnamae/",
                'en' => "{$base}/ru/cases/prodali-1-komnatnuyu-kvartiru-v-lasnamae/",
            ],
            'phase3.case.prodali-3-komnatnuyu-kvartiru-v-lasnamae' => [
                'et' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-lasnamae/",
                'ru' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-lasnamae/",
                'en' => "{$base}/ru/cases/prodali-3-komnatnuyu-kvartiru-v-lasnamae/",
            ],
            'phase3.case.prodali-2-komnatnuyu-kvartiru-v-kristiine-za-18-dney' => [
                'et' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kristiine-za-18-dney/",
                'ru' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kristiine-za-18-dney/",
                'en' => "{$base}/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kristiine-za-18-dney/",
            ],
            'phase3.case.prodali-4-komnatnuyu-kvartiru-v-tiskre' => [
                'et' => "{$base}/ru/cases/prodali-4-komnatnuyu-kvartiru-v-tiskre/",
                'ru' => "{$base}/ru/cases/prodali-4-komnatnuyu-kvartiru-v-tiskre/",
                'en' => "{$base}/ru/cases/prodali-4-komnatnuyu-kvartiru-v-tiskre/",
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
