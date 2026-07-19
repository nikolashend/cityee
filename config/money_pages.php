<?php

/**
 * MoneyPageRegistry — canonical winner per commercial seller intent cluster.
 *
 * CITYEE X999 §20 / §52 / §77 / addendum #3.
 *
 * PURPOSE
 * -------
 * Declares exactly ONE canonical winner page per dominant commercial intent
 * (INV-002: one intent = one winner). Protects the highest-value seller money
 * pages from future SEO cannibalization: any new page targeting a cluster whose
 * winner is already claimed here must EITHER support the winner (link up to it)
 * or be a distinct sub-intent — never a second competitor for the same query.
 *
 * Each `winner`/`supporting` value is a SeoLinks page key (see App\Support\SeoLinks),
 * so URLs resolve through the single canonical URL registry — this file stores
 * intent→page relationships, never raw URLs.
 *
 * `locales` lists the languages in which the winner currently exists. Seller
 * priority is RU-first (§79 GSC signal: "маклер таллинн", "недвижимость таллинн").
 */

return [

    'SELL_TALLINN' => [
        'label'            => 'Sell apartment in Tallinn',
        'primary_keyword'  => 'продать квартиру в таллинне',
        'winner'           => ['ru' => 'phase3.prodat-kvartiru-v-tallinne', 'et' => 'sell', 'en' => 'sell'],
        'locales'          => ['ru', 'et', 'en'],
        'supporting'       => ['sell', 'guide_sell_tallinn', 'sell_faster', 'mistakes'],
        'stage'            => 'transaction',
        'cannibalization'  => 'RU phase3 landing is the query winner; /ru/kinnisvara-muuk/ (sell) is the service hub — keep the service page framed around the SERVICE, not the query.',
    ],

    'MAKLER_TALLINN' => [
        'label'            => 'Makler / realtor Tallinn',
        'primary_keyword'  => 'маклер таллинн',
        'winner'           => ['ru' => 'phase3.makler-v-tallinne', 'et' => 'sell', 'en' => 'sell'],
        'locales'          => ['ru'],
        'supporting'       => ['profile', 'why', 'sell'],
        'stage'            => 'expert',
        'cannibalization'  => 'ET/EN have no dedicated makler landing; sell/profile carry the intent. Do NOT create a second RU makler page.',
    ],

    'AGENCY_TALLINN' => [
        'label'            => 'Real estate agency Tallinn',
        'primary_keyword'  => 'агентство недвижимости таллинн',
        'winner'           => ['ru' => 'phase3.agentstvo-nedvizhimosti-tallinn'],
        'locales'          => ['ru'],
        'supporting'       => ['phase3.makler-v-tallinne', 'why', 'profile'],
        'stage'            => 'expert',
        'cannibalization'  => 'Distinct from MAKLER (person/broker intent) — agency = organizational intent. Keep the two landings topically separate.',
    ],

    'VALUATION_TALLINN' => [
        'label'            => 'Apartment valuation / price corridor',
        'primary_keyword'  => 'оценка квартиры таллинн',
        'winner'           => ['ru' => 'phase3.ocenka-kvartiry-v-tallinne', 'et' => 'price_analysis', 'en' => 'price_analysis'],
        'locales'          => ['ru', 'et', 'en'],
        'supporting'       => ['guide_pricing', 'audit', 'price_analysis'],
        'stage'            => 'latent',
        'cannibalization'  => 'RU ocenka landing owns "оценка квартиры"; ET/EN price_analysis intent pages own the equivalent. guide_pricing is a supporting explainer, not a competitor.',
    ],

    'NOT_SELLING' => [
        'label'            => 'Apartment not selling',
        'primary_keyword'  => 'квартира не продается',
        'winner'           => ['ru' => 'phase3.ne-prodaetsya-kvartira-v-tallinne'],
        'locales'          => ['ru'],
        'supporting'       => ['no_calls', 'no_offers', 'sell_faster', 'audit'],
        'stage'            => 'problem',
        'cannibalization'  => 'Broad "not selling" intent. no_calls / no_offers cover NARROWER sub-symptoms and must link UP to this winner, not restate it.',
    ],

    'NO_CALLS' => [
        'label'            => 'Selling myself, no calls',
        'primary_keyword'  => 'продаю сам никто не звонит',
        'winner'           => ['ru' => 'no_calls', 'et' => 'no_calls', 'en' => 'no_calls'],
        'locales'          => ['ru', 'et', 'en'],
        'supporting'       => ['listing_audit', 'price_analysis'],
        'stage'            => 'problem',
        'cannibalization'  => 'Sub-intent of NOT_SELLING (no viewings/calls). Do not merge with no_offers — different funnel stage.',
    ],

    'NO_OFFERS' => [
        'label'            => 'Viewings but no offers',
        'primary_keyword'  => 'просмотры есть предложений нет',
        'winner'           => ['ru' => 'no_offers', 'et' => 'no_offers', 'en' => 'no_offers'],
        'locales'          => ['ru', 'et', 'en'],
        'supporting'       => ['price_analysis', 'guide_negotiation'],
        'stage'            => 'problem',
        'cannibalization'  => 'Distinct from NO_CALLS: demand exists, conversion fails. Keep the diagnosis framed on price/objections, not visibility.',
    ],

    'LISTING_AUDIT' => [
        'label'            => 'Listing / property audit',
        'primary_keyword'  => 'аудит недвижимости таллинн',
        'winner'           => ['ru' => 'phase3.audit-nedvizhimosti-tallinn', 'et' => 'audit', 'en' => 'audit'],
        'locales'          => ['ru', 'et', 'en'],
        'supporting'       => ['audit', 'listing_audit'],
        'stage'            => 'expert',
        // HIGH cannibalization zone — three RU pages orbit "audit".
        'cannibalization'  => 'THREE RU audit pages MUST stay differentiated: '
            . 'phase3.audit-nedvizhimosti-tallinn = commercial winner for "аудит недвижимости таллинн"; '
            . 'listing_audit (/ru/audit-obyavleniya/) = narrower "аудит объявления" (listing copy/photos); '
            . 'audit (/ru/audit/) = trilingual SERVICE page (what the audit is + order form). '
            . 'Never let all three target the same query — monitor in seller_intent_map.csv.',
    ],

    'RENT_TALLINN' => [
        'label'            => 'Rent out apartment in Tallinn',
        'primary_keyword'  => 'сдать квартиру в таллинне',
        'winner'           => ['ru' => 'phase3.sdat-kvartiru-v-tallinne', 'et' => 'rent', 'en' => 'rent'],
        'locales'          => ['ru', 'et', 'en'],
        'supporting'       => ['rent', 'guide_rent'],
        'stage'            => 'transaction',
        'cannibalization'  => 'BUY/RENT must not dilute seller authority (§2). RU sdat landing owns the query; kinnisvara-uur is the service hub.',
    ],
];
