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


        // ─── Bank appraisal act (Commit D) ─────────────────────────
        // Paid job: someone whose BANK has asked for an appraisal act.
        // Materially different from a seller valuation (different buyer, a paid
        // deliverable, a third-party licensed appraiser), hence its own LP and
        // its own lead type — mixing it into price_calculator would corrupt both
        // the seller funnel's lead quality and this page's own measurement.
        //
        // CLAIM DISCIPLINE — these two figures are owner-authorised business
        // facts (§35) and are published with an explicit "ориентировочно"
        // hedge. They are NOT market data and must not be restated as firm
        // quotes. Deliberately absent: any claim that a given bank will accept
        // the act, and any suggestion that CityEE itself is the appraiser.
        'ocenochnyy-akt-dlya-banka' => [
            'locale'       => 'ru',
            'meta_title'   => 'Оценочный акт для банка — Таллинн и Харьюмаа | CityEE',
            'meta_description' => 'Нужен оценочный акт для банка в Таллинне или Харьюмаа? Организуем оценку через лицензированного партнёра-оценщика: ориентировочно 300 € и 4–7 дней.',
            'h1'           => 'Оценочный акт для банка в Таллинне и Харьюмаа',
            'subtitle'     => 'Банк запросил оценку недвижимости? Организуем её через лицензированного партнёра-оценщика и ведём процесс до готового акта.',
            'cta_label'    => 'Заказать оценочный акт',
            'cta_target'   => '#v3-form-bank',
            'form'         => 'bank-appraisal',

            'sticky_cta_label'  => 'Заказать акт',
            'sticky_cta_target' => '#v3-form-bank',

            'facts_title' => 'Стоимость и срок',
            'facts' => [
                'Стоимость — ориентировочно 300 €.',
                'Срок — ориентировочно 4–7 дней с момента доступа к объекту.',
                'Требования банков различаются, поэтому перед заказом подтверждаем требования вашего банка.',
            ],

            'bullets' => [
                'Акт готовит лицензированный партнёр-оценщик — не CityEE.',
                'Мы берём на себя согласование визита, документы и сроки.',
                'Вы получаете акт в том виде, который запросил ваш банк.',
            ],

            'steps' => [
                ['title' => 'Вы оставляете объект и банк',  'text' => 'Адрес объекта и название банка, который запросил оценку.'],
                ['title' => 'Мы подтверждаем требования',   'text' => 'Уточняем, что именно требует ваш банк, и подтверждаем стоимость и срок до начала работы.'],
                ['title' => 'Оценщик выезжает на объект',   'text' => 'Согласуем удобное время доступа к недвижимости.'],
                ['title' => 'Вы получаете оценочный акт',   'text' => 'Готовый акт передаётся вам для предоставления в банк.'],
            ],

            // Copy lives in config like every other CityEE form; the component
            // stays presentation-only. RU-only: this is a single-locale paid LP.
            'form_copy' => [
                'title'     => 'Заказать оценочный акт',
                'address'   => 'Адрес объекта',
                'bank'      => 'Какой банк запросил оценку',
                'purpose'   => 'Для чего нужна оценка',
                'purposes'  => ['Кредит на покупку', 'Рефинансирование', 'Раздел имущества', 'Наследство', 'Другое'],
                'contact'   => 'Телефон / WhatsApp или email',
                'contact_ph' => '+372 5xxx xxxx  /  name@example.com',
                'submit'    => 'Заказать оценочный акт',
                'note'      => 'Перед заказом подтверждаем требования вашего банка.',
                'success'   => 'Спасибо! Свяжемся с вами и подтвердим требования вашего банка.',
            ],

            'reassurance' => 'Перед заказом подтверждаем требования вашего банка. Если банк требует оценку в ином формате — скажем об этом до оплаты, а не после.',
        ],

    ],

];
