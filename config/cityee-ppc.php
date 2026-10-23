<?php

/**
 * Paid-traffic landing pages (Google Ads) — CITYEE PPC Monetization Train V2.
 *
 * WHY A SEPARATE FILE
 * -------------------
 * These pages serve ONE paid job each and must never enter the organic index:
 *   • noindex, follow  — set by the controller, rendered by layouts/app.blade.php
 *   • self-canonical   — no cross-language consolidation
 *   • NO hreflang      — a paid LP has no translated counterpart
 *   • NOT in any sitemap
 *
 * The sitemap generators iterate config('cityee-phase3.landings') and friends,
 * so PPC pages live in their OWN config namespace: omission from those arrays
 * is structural, not a rule someone has to remember. SitemapController never
 * reads this file — do not move these entries into cityee-phase3.php.
 *
 * robots.txt intentionally does NOT disallow /ru/lp/ — the crawler must be able
 * to FETCH the page to see the noindex meta. Blocking the path would strand the
 * URL as "indexed, though blocked by robots.txt".
 *
 * Claim discipline: no numeric market claim may appear here unless it comes from
 * config/trust_claims.php or is an explicitly authorised business fact (the bank
 * appraisal price/turnaround — owner-authorised, §35). Nothing is invented.
 */

return [

    'landings' => [

        // ─── Lasnamäe valuation (Commit C) ─────────────────────────
        // Paid job: a Lasnamäe owner wants to know what their flat is worth.
        // Reuses the existing /contact/price-calculator endpoint — no new lead
        // type, no new tracking, so the generate_lead contract is untouched.
        'ocenka-lasnamae' => [
            'locale'       => 'ru',
            'meta_title'   => 'Оценка квартиры в Ласнамяэ | CityEE',
            'meta_description' => 'Узнайте реальный ценовой коридор квартиры в Ласнамяэ: разбор по вашему дому и серии, актуальные конкуренты, рабочая стартовая цена.',
            'h1'           => 'Сколько реально стоит квартира в Lasnamäe?',
            'subtitle'     => 'Разбираем по вашему адресу: с кем конкурирует объект сейчас и в каком диапазоне он продаётся, а не в каком хотелось бы.',
            'cta_label'    => 'Узнать цену моей квартиры',
            'cta_target'   => '#v3-form-calc',
            'form'         => 'price-calculator',

            // Sitewide sticky bar re-pointed at THIS page's single job
            // (default target is the audit form — wrong job for a paid valuation click).
            'sticky_cta_label'  => 'Узнать цену',
            'sticky_cta_target' => '#v3-form-calc',

            'bullets' => [
                'Смотрим конкретный дом и серию, а не среднюю цену по Ласнамяэ.',
                'Показываем объекты, с которыми ваша квартира конкурирует прямо сейчас.',
                'Даём рабочий ценовой коридор и риск неверной стартовой цены.',
            ],

            'steps' => [
                ['title' => 'Вы оставляете адрес и параметры', 'text' => 'Достаточно адреса, площади и состояния — без документов и без визита.'],
                ['title' => 'Мы разбираем ваш сегмент',       'text' => 'Сравниваем с актуальными предложениями и реальными сделками в вашем районе.'],
                ['title' => 'Вы получаете ценовой коридор',    'text' => 'Диапазон, обоснование и что меняется при разной стартовой цене.'],
            ],

            'reassurance' => 'Это консультация по цене, а не обязательство продавать. Если решите продавать — условия обсуждаем отдельно.',
        ],

    ],

];
