<?php

/**
 * Query → Page Ownership Registry — CITYEE X999^5 §23 / §7 / INV-004.
 *
 * NOT a Google config. This is a regression-safety layer that declares, per
 * language, which ONE canonical page owns each commercial query cluster, plus
 * its supporting pages. Used by `seo:audit-intent-map` / the final report to
 * detect cannibalization (two pages claiming one intent) and to keep internal
 * linking pointed at the right winner after future deploys.
 *
 * Paths are canonical trailing-slash URLs. Keep in sync with
 * config/money_pages.php (intent clusters) and config/seo_protected_assets.php.
 */

return [

    'ru' => [
        'broker_tallinn' => [
            'queries'    => ['маклер таллинн', 'маклер в таллинне', 'риелтор таллинн', 'агент по недвижимости таллинн'],
            'primary'    => '/ru/makler-v-tallinne/',
            'supporting' => ['/ru/aleksandr-primakov/', '/ru/pochemu-cityee/', '/ru/kinnisvara-muuk/'],
            'tier'       => 'S',
        ],
        'agency_tallinn' => [
            'queries'    => ['агентство недвижимости таллинн', 'бюро недвижимости таллинн'],
            'primary'    => '/ru/agentstvo-nedvizhimosti-tallinn/',
            'supporting' => ['/ru/makler-v-tallinne/', '/ru/pochemu-cityee/'],
            'tier'       => 'A',
        ],
        'sell_tallinn' => [
            'queries'    => ['продать квартиру в таллинне', 'продажа квартиры таллинн', 'помощь в продаже квартиры'],
            'primary'    => '/ru/prodat-kvartiru-v-tallinne/',
            'supporting' => ['/ru/kinnisvara-muuk/', '/ru/kak-prodat-bystree/', '/ru/oshibki-pri-prodazhe/'],
            'tier'       => 'S',
        ],
        'valuation_tallinn' => [
            'queries'    => ['оценка квартиры таллинн', 'сколько стоит квартира', 'рыночная цена квартиры', 'реальная цена квартиры'],
            'primary'    => '/ru/ocenka-kvartiry-v-tallinne/',
            'supporting' => ['/ru/analiz-ceny-nedvizhimosti-tallinn/', '/ru/audit/'],
            'tier'       => 'S',
        ],
        'not_selling' => [
            'queries'    => ['квартира не продается', 'почему квартира не продается', 'долго не продается квартира'],
            'primary'    => '/ru/ne-prodaetsya-kvartira-v-tallinne/',
            'supporting' => ['/ru/prodayu-sam-nikto-ne-zvonit/', '/ru/prosmotry-est-predlozheniy-net/', '/ru/audit/'],
            'tier'       => 'A',
        ],
        'no_calls' => [
            'queries'    => ['нет звонков по объявлению', 'продаю сам никто не звонит', 'мало просмотров'],
            'primary'    => '/ru/prodayu-sam-nikto-ne-zvonit/',
            'supporting' => ['/ru/audit-obyavleniya/', '/ru/analiz-ceny-nedvizhimosti-tallinn/'],
            'tier'       => 'A',
        ],
        'no_offers' => [
            'queries'    => ['просмотры есть предложений нет', 'покупатели торгуются'],
            'primary'    => '/ru/prosmotry-est-predlozheniy-net/',
            'supporting' => ['/ru/analiz-ceny-nedvizhimosti-tallinn/'],
            'tier'       => 'A',
        ],
        'fast_sale' => [
            'queries'    => ['продать квартиру быстро', 'срочно продать квартиру', 'быстрая продажа квартиры'],
            'primary'    => '/ru/kak-prodat-bystree/',
            'supporting' => ['/ru/prodat-kvartiru-v-tallinne/', '/ru/audit/'],
            'tier'       => 'A',
        ],
        'listing_audit' => [
            'queries'    => ['аудит недвижимости таллинн', 'аудит объявления', 'проверить объявление'],
            'primary'    => '/ru/audit-nedvizhimosti-tallinn/',
            'supporting' => ['/ru/audit-obyavleniya/', '/ru/audit/'],
            'tier'       => 'A',
        ],
        'diy_vs_broker' => [
            'queries'    => ['продать самому или через маклера', 'нужен ли риелтор', 'комиссия маклера', 'сколько стоит маклер'],
            'primary'    => '/ru/prodat-samomu-vs-partner/',
            'supporting' => ['/ru/makler-v-tallinne/', '/ru/pochemu-cityee/'],
            'tier'       => 'B',
        ],
        'landlord_tallinn' => [
            'queries'    => ['сдать квартиру в таллинне', 'найти арендатора', 'проверить арендатора', 'сдать через маклера'],
            'primary'    => '/ru/sdat-kvartiru-v-tallinne/',
            'supporting' => ['/ru/kinnisvara-uur/'],
            'tier'       => 'A',
        ],
    ],

    'et' => [
        'sell_service'   => ['queries' => ['kinnisvara müük tallinn', 'korteri müük'],       'primary' => '/kinnisvara-muuk/',          'supporting' => ['/kuidas-muua-kiiremini/', '/kuulutuse-audit/'], 'tier' => 'S'],
        'fast_sale'      => ['queries' => ['kuidas müüa kiiremini', 'korteri kiire müük'],    'primary' => '/kuidas-muua-kiiremini/',    'supporting' => ['/kinnisvara-muuk/', '/audit/'],                  'tier' => 'A'],
        'listing_audit'  => ['queries' => ['kuulutuse audit', 'kinnisvara audit'],           'primary' => '/kuulutuse-audit/',          'supporting' => ['/audit/'],                                       'tier' => 'A'],
        'valuation'      => ['queries' => ['korteri hindamine', 'kinnisvara turuhind'],       'primary' => '/kinnisvara-hinnaanaluus-tallinn/', 'supporting' => ['/audit/'],                                'tier' => 'A'],
        'landlord'       => ['queries' => ['kinnisvara üürileandmine', 'üürnik'],             'primary' => '/kinnisvara-uur/',           'supporting' => [],                                                'tier' => 'A'],
    ],

    'en' => [
        'sell_service'   => ['queries' => ['sell property tallinn'],                          'primary' => '/en/sell-property/',         'supporting' => ['/en/how-to-sell-faster/', '/en/listing-audit/'], 'tier' => 'S'],
        'fast_sale'      => ['queries' => ['how to sell faster tallinn'],                      'primary' => '/en/how-to-sell-faster/',    'supporting' => ['/en/sell-property/', '/en/audit/'],              'tier' => 'A'],
        'listing_audit'  => ['queries' => ['listing audit tallinn'],                          'primary' => '/en/listing-audit/',         'supporting' => ['/en/audit/'],                                    'tier' => 'A'],
        'landlord'       => ['queries' => ['rent out property tallinn'],                       'primary' => '/en/rent-out-property/',     'supporting' => [],                                                'tier' => 'A'],
    ],
];
