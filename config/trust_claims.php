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
    // The business runs a TIERED model, not a single number:
    //   • headline  = 2%   — minimal fee, WITH an exclusive agreement
    //   • standard  = 2–5% — general brokerage range (no exclusive)
    // The "2–3%" figure previously seen on the consultation price tables,
    // the profile page and the AI summary matches NEITHER tier and is the true
    // drift to remediate (see docs/CITYEE_X999_FINAL_HARDENING_REPORT.md).
    'commission' => [
        'headline'       => '2%',   // the marketing/hero claim (exclusive agreement)
        'headline_num'   => 2,
        'standard_range' => '2–5%', // general brokerage range
        'condition' => [
            'et' => 'ainuesinduslepingu korral',
            'ru' => 'при эксклюзивном договоре',
            'en' => 'with an exclusive agreement',
        ],
        'label' => ['et' => 'vahendustasu', 'ru' => 'комиссия', 'en' => 'commission'],
        // Full sanctioned sentence — use this instead of inventing a variant.
        'sentence' => [
            'et' => 'Vahendustasu on ainult 2% müügihinnast ainuesinduslepingu korral (standardtasu 2–5%).',
            'ru' => 'Комиссия — всего 2% от цены продажи при эксклюзивном договоре (стандарт 2–5%).',
            'en' => 'Commission is only 2% of the sale price with an exclusive agreement (standard 2–5%).',
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
