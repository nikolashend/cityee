<?php

/**
 * SEO Redirect Map — cityee.ee
 *
 * Format:
 * '/old-url' => [
 *     'target' => '/new-url',
 *     'status' => 301,
 *     'reason' => 'RULE-XXX description',
 * ]
 *
 * RULES applied:
 * RULE-002: 404 → 301 to best canonical equivalent
 * RULE-007: legacy subdomain → path-based URL (server-level, see docs)
 * RULE-008: http → https (server-level, see docs)
 * RULE-009: /index → / (handled in CanonicalRedirects middleware)
 * RULE-010: non-trailing-slash → canonical (handled in SeoLinks canonical tags)
 * RULE-016: old internal links → final canonical URL
 */

return [

    // ─── Index duplicates (RULE-009) ───────────────────────────────
    '/index' => [
        'target' => '/',
        'status' => 301,
        'reason' => 'RULE-009: /index duplicate → root',
    ],
    '/ru/index' => [
        'target' => '/ru',
        'status' => 301,
        'reason' => 'RULE-009: /ru/index duplicate → /ru',
    ],
    '/en/index' => [
        'target' => '/en',
        'status' => 301,
        'reason' => 'RULE-009: /en/index duplicate → /en',
    ],

    // ─── Legacy Estonian slug redirects (RULE-002/016) ─────────────
    '/teenused' => [
        'target' => '/kinnisvara-muuk',
        'status' => 301,
        'reason' => 'RULE-016: old ET service slug',
    ],
    '/kontakt' => [
        'target' => '/kontaktid',
        'status' => 301,
        'reason' => 'RULE-016: old ET contacts slug',
    ],

    // ─── Legacy Russian pages without /ru/ prefix (RULE-016) ───────
    '/prodazha-nedvizhimosti' => [
        'target' => '/ru/kinnisvara-muuk',
        'status' => 301,
        'reason' => 'RULE-016: old RU sell slug without prefix',
    ],
    '/arenda-nedvizhimosti' => [
        'target' => '/ru/kinnisvara-uur',
        'status' => 301,
        'reason' => 'RULE-016: old RU rent slug without prefix',
    ],

    // ─── Old English pages (RULE-016) ──────────────────────────────
    '/sell' => [
        'target' => '/en/sell-property',
        'status' => 301,
        'reason' => 'RULE-016: old EN sell URL',
    ],
    '/rent' => [
        'target' => '/en/rent-out-property',
        'status' => 301,
        'reason' => 'RULE-016: old EN rent URL',
    ],
    '/consultation' => [
        'target' => '/en/consultation',
        'status' => 301,
        'reason' => 'RULE-016: old EN consultation URL',
    ],
    '/contacts' => [
        'target' => '/en/contacts',
        'status' => 301,
        'reason' => 'RULE-016: old EN contacts URL',
    ],

    // ─── Old /locations/ to Phase 3 geo (RULE-002) ─────────────────
    '/ru/locations/tallinn'   => ['target' => '/ru/tallinn',           'status' => 301, 'reason' => 'RULE-002: locations migrated to Phase3 geo'],
    '/ru/locations/lasnamae'  => ['target' => '/ru/tallinn/lasnamae',  'status' => 301, 'reason' => 'RULE-002: locations migrated to Phase3 geo'],
    '/ru/locations/mustamae'  => ['target' => '/ru/tallinn/mustamae',  'status' => 301, 'reason' => 'RULE-002: locations migrated to Phase3 geo'],
    '/ru/locations/kesklinn'  => ['target' => '/ru/tallinn/kesklinn',  'status' => 301, 'reason' => 'RULE-002: locations migrated to Phase3 geo'],
    '/ru/locations/haabersti' => ['target' => '/ru/tallinn/haabersti', 'status' => 301, 'reason' => 'RULE-002: locations migrated to Phase3 geo'],
    '/ru/locations/kristiine' => ['target' => '/ru/tallinn/kristiine', 'status' => 301, 'reason' => 'RULE-002: locations migrated to Phase3 geo'],

    // ─── WordPress security crawl bait (RULE-002) ──────────────────
    '/wp-admin'      => ['target' => '/', 'status' => 301, 'reason' => 'RULE-002: WordPress path on non-WP site'],
    '/wp-login.php'  => ['target' => '/', 'status' => 301, 'reason' => 'RULE-002: WordPress path on non-WP site'],
    '/wp-content'    => ['target' => '/', 'status' => 301, 'reason' => 'RULE-002: WordPress path on non-WP site'],
    '/xmlrpc.php'    => ['target' => '/', 'status' => 301, 'reason' => 'RULE-002: WordPress path on non-WP site'],

    // ─── GSC 2026-07: changed pillar-guide slug (RULE-002) ─────────
    // Old ET negotiation slug had a double "aa"; canonical is "labirakimiste".
    '/knowledge/labiraakimiste-strateegia-kinnisvara' => [
        'target' => '/knowledge/labirakimiste-strateegia-kinnisvara',
        'status' => 301,
        'reason' => 'RULE-002: negotiation pillar slug typo fix (labiraakimiste → labirakimiste)',
    ],

    // ─── GSC 2026-07: changed RU intent slug (RULE-002) ────────────
    '/ru/kvartira-ne-prodaetsya' => [
        'target' => '/ru/ne-prodaetsya-kvartira-v-tallinne',
        'status' => 301,
        'reason' => 'RULE-002: old RU "apartment not selling" slug → current Phase-3 landing',
    ],

    // ─── GSC 2026-07: removed DB guides → guides index (RULE-002) ──
    // These SEO-topic guides no longer exist. Redirect to the section index
    // (a strong topical equivalent) rather than 410 to preserve link equity.
    '/guides/seo-strategi-2026' => [
        'target' => '/guides',
        'status' => 301,
        'reason' => 'RULE-002: removed guide → guides index (ET)',
    ],
    '/guides/geo-aeo-ai-optimizatsiya' => [
        'target' => '/guides',
        'status' => 301,
        'reason' => 'RULE-002: removed guide → guides index (ET)',
    ],
    '/ru/guides/seo-strategi-2026' => [
        'target' => '/ru/guides',
        'status' => 301,
        'reason' => 'RULE-002: removed guide → guides index (RU)',
    ],
    '/ru/guides/geo-aeo-ai-optimizatsiya' => [
        'target' => '/ru/guides',
        'status' => 301,
        'reason' => 'RULE-002: removed guide → guides index (RU)',
    ],

    // ─── SERVER-LEVEL REDIRECTS (cannot be implemented in Laravel) ─
    // These must be configured in Nginx/Apache:
    //
    // http://cityee.ee/*          → https://cityee.ee/*        (RULE-008, INV-11)
    // http://www.cityee.ee/*      → https://cityee.ee/*        (RULE-008, INV-10)
    // https://www.cityee.ee/*     → https://cityee.ee/*        (RULE-010, INV-10)
    // http://ru.cityee.ee/*       → https://cityee.ee/ru/*     (RULE-007, INV-10)
    // https://ru.cityee.ee/*      → https://cityee.ee/ru/*     (RULE-007, INV-10)
    //
    // Example Nginx config:
    // server {
    //     listen 80;
    //     server_name cityee.ee www.cityee.ee ru.cityee.ee;
    //     return 301 https://cityee.ee$request_uri;
    // }
    // server {
    //     listen 443 ssl;
    //     server_name www.cityee.ee;
    //     return 301 https://cityee.ee$request_uri;
    // }
    // server {
    //     listen 443 ssl;
    //     server_name ru.cityee.ee;
    //     return 301 https://cityee.ee/ru$request_uri;
    // }
];
