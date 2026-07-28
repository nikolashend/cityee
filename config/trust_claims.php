<?php

/**
 * TrustClaimRegistry — single source of truth for CityEE factual claims.
 *
 * CITYEE X999 §51 / addendum #4.
 *
 * WHY THIS FILE EXISTS
 * --------------------
 * Reusable factual claims (commission, experience, deal count, average sale
 * time) were previously inlined across Blade templates and config/cityee.php.
 * That produced factual drift — the same fact appearing as different numbers on
 * different pages (e.g. "45 days" vs "1–1.5 months", "2%" vs "2–3%").
 * Inconsistent facts damage EEAT, AI-answer consistency, and buyer trust.
 *
 * RULE: Every reusable factual claim MUST originate here. Pages read it via
 * App\Support\TrustClaims. Do NOT hardcode these numbers in templates.
 *
 * CANONICAL VALUES are asserted by the business (see §50). Each claim documents
 * its sanctioned representations so pages can vary phrasing WITHOUT varying fact.
 */

return [

    // ─── Experience & volume ───────────────────────────────────────
    'experience_years' => [
        'value'   => '10+',
        'numeric' => 10,
        'label'   => ['et' => 'aastat kogemust', 'ru' => 'лет опыта', 'en' => 'years experience'],
    ],

    'deal_count' => [
        'value'   => '300+',
        'numeric' => 300,
        'label'   => ['et' => 'tehingut', 'ru' => 'сделок', 'en' => 'deals closed'],
    ],

    // ─── Average sale time ─────────────────────────────────────────
    // ONE underlying fact with two sanctioned representations.
    // 45 days ≈ 1–1.5 months. Pages may use either representation, but both
    // now resolve to the same registry entry, so they cannot drift apart.
    // Canonical phrasing (§50): "1–1.5 months".
    'avg_sale' => [
        'days'         => 45,
        'days_value'   => '45',
        'months_value' => '1–1,5',   // ru/et decimal comma; en override below
        'days_label'   => ['et' => 'päeva kes. müük', 'ru' => 'дней ср. продажа', 'en' => 'avg days to sell'],
        'months_label' => ['et' => 'kuud müügiaeg',   'ru' => 'мес. срок продажи', 'en' => 'months avg. sale'],
        // Ready-made sentence forms (for meta descriptions / AI summary).
        'sentence' => [
            'et' => 'Keskmine müügiaeg on 1–1,5 kuud (u 45 päeva).',
            'ru' => 'Среднее время продажи — 1–1,5 месяца (около 45 дней).',
            'en' => 'Average sale time is 1–1.5 months (about 45 days).',
        ],
    ],

    // ─── Commission model ──────────────────────────────────────────
    // APPROVED BUSINESS FACT (X999^5 Seller-Domination §2):
    //   • standard commission = 2% of the deal price
    //   • minimum commission  = €2000
    //   • final terms depend on the property and agreed scope
    // This is now the SINGLE canonical model. The previous "2–5%" standard tier
    // and the "2–3%" figures (profile / consultation tables / ai-summary) are
    // superseded and must be reconciled to this model — no conflicting range may
    // be published without an explicit different-product explanation.
    'commission' => [
        'standard_percent' => 2,
        'minimum_eur'      => 2000,
        'headline'         => '2%',   // display value used by trust components
        'headline_num'     => 2,
        'qualifier' => [
            'et' => 'Täpsed tingimused sõltuvad objektist ja kokkulepitud teenuse mahust.',
            'ru' => 'Точные условия зависят от объекта и согласованного объёма услуги.',
            'en' => 'Final terms depend on the property and the agreed scope of service.',
        ],
        'label' => ['et' => 'vahendustasu', 'ru' => 'комиссия', 'en' => 'commission'],
        // Full sanctioned sentence — use this instead of inventing a variant.
        'sentence' => [
            'et' => 'Vahendustasu on 2% müügihinnast, kuid vähemalt 2000 €. Teenuse täpne maht lepitakse kokku enne tööd.',
            'ru' => 'Комиссия составляет 2% от цены сделки, но не менее 2000 €. Точный объём услуги фиксируется до начала работы.',
            'en' => 'Commission is 2% of the sale price, with a €2000 minimum. The exact scope is agreed before work begins.',
        ],
    ],

    // ─── Reputation ────────────────────────────────────────────────
    'google_rating' => [
        'value' => '5.0',
        'label' => ['et' => 'Google hinnang', 'ru' => 'рейтинг Google', 'en' => 'Google rating'],
    ],

    // ─── Service area ──────────────────────────────────────────────
    'service_area' => [
        'value' => 'Tallinn & Harjumaa',
        'label' => ['et' => 'teeninduspiirkond', 'ru' => 'регион обслуживания', 'en' => 'service area'],
    ],

    // ─── Advertising reach (from contacts page meta) ───────────────
    'ad_network_contacts' => [
        'value' => '120 000+',
        'label' => ['et' => 'kontakti reklaamivõrgus', 'ru' => 'контактов в рекламной сети', 'en' => 'contacts in ad network'],
    ],
];
