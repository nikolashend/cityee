<?php

/**
 * Protected SEO Asset Registry — CITYEE X999^5 §4 / INV-001.
 *
 * Machine-readable list of pages that must NOT be silently degraded: no URL
 * change, delete, merge, cross-canonical, noindex, content strip, or radical
 * title/H1 rewrite without explicit evidence-backed sign-off.
 *
 * Priority tiers:
 *   S — top commercial money page / brand-critical hub
 *   A — high-value owner-problem or funnel page
 *
 * `path` is the canonical trailing-slash URL. `intent` ties the asset to its
 * cluster in config/money_pages.php / config/search_intents.php.
 *
 * This is a regression-safety layer: `seo:smoke-public` asserts every entry
 * still returns 200, and the final report diffs title/H1/canonical against it.
 */

return [

    // ── S-tier: brand + top commercial hubs ────────────────────────
    ['path' => '/',                                    'lang' => 'et', 'intent' => 'brand_home',       'priority' => 'S', 'protected' => true],
    ['path' => '/ru/',                                 'lang' => 'ru', 'intent' => 'brand_home',       'priority' => 'S', 'protected' => true],
    ['path' => '/en/',                                 'lang' => 'en', 'intent' => 'brand_home',       'priority' => 'S', 'protected' => true],
    ['path' => '/ru/makler-v-tallinne/',               'lang' => 'ru', 'intent' => 'MAKLER_TALLINN',   'priority' => 'S', 'protected' => true],
    ['path' => '/ru/prodat-kvartiru-v-tallinne/',      'lang' => 'ru', 'intent' => 'SELL_TALLINN',     'priority' => 'S', 'protected' => true],
    ['path' => '/ru/ocenka-kvartiry-v-tallinne/',      'lang' => 'ru', 'intent' => 'VALUATION_TALLINN','priority' => 'S', 'protected' => true],
    ['path' => '/ru/tallinn/',                         'lang' => 'ru', 'intent' => 'GEO_TALLINN_HUB',  'priority' => 'S', 'protected' => true],
    ['path' => '/ru/aleksandr-primakov/',              'lang' => 'ru', 'intent' => 'EXPERT_PERSON',    'priority' => 'S', 'protected' => true],

    // Service hubs (trilingual) — canonical winners for the service, not the query
    ['path' => '/kinnisvara-muuk/',                    'lang' => 'et', 'intent' => 'SELL_SERVICE',     'priority' => 'S', 'protected' => true],
    ['path' => '/ru/kinnisvara-muuk/',                 'lang' => 'ru', 'intent' => 'SELL_SERVICE',     'priority' => 'S', 'protected' => true],
    ['path' => '/en/sell-property/',                   'lang' => 'en', 'intent' => 'SELL_SERVICE',     'priority' => 'S', 'protected' => true],

    // ── A-tier: owner-problem + funnel money pages ─────────────────
    ['path' => '/ru/ne-prodaetsya-kvartira-v-tallinne/','lang' => 'ru', 'intent' => 'NOT_SELLING',     'priority' => 'A', 'protected' => true],
    ['path' => '/ru/sdat-kvartiru-v-tallinne/',        'lang' => 'ru', 'intent' => 'RENT_TALLINN',     'priority' => 'A', 'protected' => true],
    ['path' => '/ru/agentstvo-nedvizhimosti-tallinn/', 'lang' => 'ru', 'intent' => 'AGENCY_TALLINN',   'priority' => 'A', 'protected' => true],
    ['path' => '/ru/audit-nedvizhimosti-tallinn/',     'lang' => 'ru', 'intent' => 'LISTING_AUDIT',    'priority' => 'A', 'protected' => true],
    ['path' => '/ru/prodayu-sam-nikto-ne-zvonit/',     'lang' => 'ru', 'intent' => 'NO_CALLS',         'priority' => 'A', 'protected' => true],
    ['path' => '/ru/prosmotry-est-predlozheniy-net/',  'lang' => 'ru', 'intent' => 'NO_OFFERS',        'priority' => 'A', 'protected' => true],
    ['path' => '/ru/cases/',                           'lang' => 'ru', 'intent' => 'EVIDENCE_CASES',   'priority' => 'A', 'protected' => true],

    // ET/EN owner-problem equivalents
    ['path' => '/kuidas-muua-kiiremini/',              'lang' => 'et', 'intent' => 'SELL_FASTER',      'priority' => 'A', 'protected' => true],
    ['path' => '/en/how-to-sell-faster/',              'lang' => 'en', 'intent' => 'SELL_FASTER',      'priority' => 'A', 'protected' => true],
    ['path' => '/kuulutuse-audit/',                    'lang' => 'et', 'intent' => 'LISTING_AUDIT',    'priority' => 'A', 'protected' => true],
];
