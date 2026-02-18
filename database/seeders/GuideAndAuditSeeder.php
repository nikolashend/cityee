<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\AreaAudit;
use Illuminate\Database\Seeder;

class GuideAndAuditSeeder extends Seeder
{
    public function run(): void
    {
        // ═══════════════════════════════════════════════════════════
        // GUIDE #1 — How to Sell Property in Tallinn (3 languages)
        // ═══════════════════════════════════════════════════════════

        Guide::updateOrCreate(
            ['slug' => 'kuidas-muua-kinnisvara-tallinnas', 'locale' => 'et'],
            [
                'title' => 'Kuidas müüa kinnisvara Tallinnas — täielik juhend 2025',
                'meta_title' => 'Kuidas müüa kinnisvara Tallinnas 2025 | CityEE Juhend',
                'meta_description' => 'Professionaalne juhend kinnisvara müügiks Tallinnas: hinnastamine, ettevalmistus, läbirääkimised, maksimaalne tulemus. Aleksandr Tarasov, 18+ aastat.',
                'excerpt' => 'Samm-sammuline juhend kinnisvara edukaks müügiks Tallinnas ja Harjumaal — hinnastamisest kuni tehingu sõlmimiseni.',
                'content_blocks' => [
                    'intro' => '<p>Kinnisvara müük Tallinnas nõuab professionaalset lähenemist. Selles juhendis jagan 18+ aasta kogemust — kuidas saavutada maksimaalne hind minimaalsete kuludega.</p>',
                    'sections' => [
                        [
                            'heading' => '1. Turuhinna määramine — esimene samm',
                            'body' => '<p>Õige hinnastamine on eduka müügi alus. Kasutan võrdlusmeetodit: analüüsin viimase 6 kuu samas piirkonnas sõlmitud tehinguid, arvestades pindala, seisukorda ja korrust.</p><p><strong>Peamine reegel:</strong> 95% ostjatest otsib kinnisvara portaalidest. Kui hind on turuväärtusest >10% üle, kaotad esimese 14 päeva kuldse akna.</p>',
                        ],
                        [
                            'heading' => '2. Objekti ettevalmistus',
                            'body' => '<p>Professionaalne pildistamine ja home staging tõstavad kinnisvara atraktiivsust 30–40%. Investeering on 200–500 €, aga tulemus — tuhandetes eurodes.</p><ul><li>Depersonaliseerimine — eemalda isiklikud esemed</li><li>Värvitööd — neutraalsed toonid</li><li>Valgustus — maksimaalne loomulik valgus</li></ul>',
                        ],
                        [
                            'heading' => '3. Turundus ja kanalid',
                            'body' => '<p>Kasutan multikanalset turundust: KV.ee, City24, sotsiaalmeediat ja otseturundust oma andmebaasist 500+ ostjale. Iga kanal toob oma sihtgruppi.</p>',
                        ],
                        [
                            'heading' => '4. Läbirääkimised ja tehingu sõlmimine',
                            'body' => '<p>Professionaalne maakler kaitseb teie huve läbirääkimistel. Minu strateegia: mõistlik alghind → aktiivne huvi → mitu pakkumist → valimine. Tulemus: 97-103% turuhinnast.</p>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'Kui kaua kinnisvara müük Tallinnas võtab?', 'answer' => '<p>Korrektselt hinnastatud ja ettevalmistatud objekt müüakse Tallinnas keskmiselt 30–45 päevaga. Ülehinnatatud objektid seisavad 90–180 päeva.</p>'],
                        ['question' => 'Milline on maakleri vahendustasu?', 'answer' => '<p>CityEE vahendustasu on 2–3% tehinguhinnast (miinimum 2000 €). Tasu makstakse ainult eduka tehingu korral — riskivaba koostöö.</p>'],
                        ['question' => 'Kas tasub enne müüki renoveerida?', 'answer' => '<p>Väikesed kosmeetilised tööd (100–500 €) end reeglina ära tasuvad. Kapitaalremont enne müüki on harva mõistlik — parem kajastada hinnas.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Soovid müüa kinnisvara parimal hinnal?',
                        'text' => 'Tasuta konsultatsioon ja turuhinna analüüs 24 tunni jooksul.',
                        'button' => 'Soovin tasuta konsultatsiooni',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'kuidas-muua-kinnisvara-tallinnas', 'locale' => 'ru'],
            [
                'title' => 'Как продать недвижимость в Таллинне — полное руководство 2025',
                'meta_title' => 'Как продать недвижимость в Таллинне 2025 | CityEE Гид',
                'meta_description' => 'Профессиональное руководство по продаже недвижимости в Таллинне: ценообразование, подготовка, переговоры, максимальный результат. Александр Тарасов, 18+ лет.',
                'excerpt' => 'Пошаговое руководство по успешной продаже недвижимости в Таллинне и Харьюмаа — от оценки до закрытия сделки.',
                'content_blocks' => [
                    'intro' => '<p>Продажа недвижимости в Таллинне требует профессионального подхода. В этом руководстве делюсь опытом 18+ лет — как получить максимальную цену при минимальных затратах.</p>',
                    'sections' => [
                        [
                            'heading' => '1. Определение рыночной цены — первый шаг',
                            'body' => '<p>Правильное ценообразование — основа успешной продажи. Использую сравнительный метод: анализирую сделки за последние 6 месяцев в том же районе.</p><p><strong>Главное правило:</strong> 95% покупателей ищут через порталы. Если цена на >10% выше рынка — вы теряете золотое окно первых 14 дней.</p>',
                        ],
                        [
                            'heading' => '2. Подготовка объекта',
                            'body' => '<p>Профессиональная фотосъёмка и хоум-стейджинг повышают привлекательность на 30–40%. Инвестиция 200–500 €, а результат — тысячи евро.</p>',
                        ],
                        [
                            'heading' => '3. Маркетинг и каналы',
                            'body' => '<p>Мультиканальный маркетинг: KV.ee, City24, соцсети и прямой маркетинг из базы 500+ покупателей.</p>',
                        ],
                        [
                            'heading' => '4. Переговоры и закрытие сделки',
                            'body' => '<p>Профессиональный маклер защищает ваши интересы. Моя стратегия: разумная стартовая цена → активный интерес → несколько предложений → выбор. Результат: 97-103% рыночной цены.</p>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'Сколько времени занимает продажа в Таллинне?', 'answer' => '<p>Правильно оценённый объект продаётся в среднем за 30–45 дней. Переоценённые стоят 90–180 дней.</p>'],
                        ['question' => 'Какова комиссия маклера?', 'answer' => '<p>Комиссия CityEE — 2–3% от суммы сделки (минимум 2000 €). Оплата только при успешной сделке.</p>'],
                        ['question' => 'Стоит ли делать ремонт перед продажей?', 'answer' => '<p>Небольшие косметические работы (100–500 €) окупаются. Капитальный ремонт перед продажей редко оправдан.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Хотите продать по лучшей цене?',
                        'text' => 'Бесплатная консультация и анализ рынка за 24 часа.',
                        'button' => 'Получить бесплатную консультацию',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        Guide::updateOrCreate(
            ['slug' => 'kuidas-muua-kinnisvara-tallinnas', 'locale' => 'en'],
            [
                'title' => 'How to Sell Property in Tallinn — Complete Guide 2025',
                'meta_title' => 'How to Sell Property in Tallinn 2025 | CityEE Guide',
                'meta_description' => 'Professional guide to selling property in Tallinn: pricing, preparation, negotiations, maximum result. Aleksandr Tarasov, 18+ years experience.',
                'excerpt' => 'Step-by-step guide to successfully selling property in Tallinn & Harjumaa — from valuation to closing.',
                'content_blocks' => [
                    'intro' => '<p>Selling property in Tallinn requires a professional approach. In this guide, I share 18+ years of experience — how to achieve maximum price with minimum costs.</p>',
                    'sections' => [
                        [
                            'heading' => '1. Market Price Assessment — The First Step',
                            'body' => '<p>Correct pricing is the foundation of a successful sale. I use the comparative method: analyzing transactions from the last 6 months in the same area.</p><p><strong>Key rule:</strong> 95% of buyers search via portals. If priced >10% above market — you lose the golden window of the first 14 days.</p>',
                        ],
                        [
                            'heading' => '2. Property Preparation',
                            'body' => '<p>Professional photography and home staging boost attractiveness by 30–40%. Investment of 200–500 €, but the result — thousands of euros.</p>',
                        ],
                        [
                            'heading' => '3. Marketing Channels',
                            'body' => '<p>Multi-channel marketing: KV.ee, City24, social media and direct marketing from a database of 500+ buyers.</p>',
                        ],
                        [
                            'heading' => '4. Negotiations and Closing',
                            'body' => '<p>A professional broker protects your interests. My strategy: reasonable starting price → active interest → multiple offers → selection. Result: 97-103% of market value.</p>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'How long does it take to sell in Tallinn?', 'answer' => '<p>A properly priced property sells on average in 30–45 days. Overpriced properties sit for 90–180 days.</p>'],
                        ['question' => 'What is the broker commission?', 'answer' => '<p>CityEE commission is 2–3% of the transaction (minimum €2,000). Payment only upon successful deal.</p>'],
                        ['question' => 'Should I renovate before selling?', 'answer' => '<p>Small cosmetic works (€100–500) usually pay off. Major renovation before selling is rarely justified.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Want to sell at the best price?',
                        'text' => 'Free consultation and market analysis within 24 hours.',
                        'button' => 'Get Free Consultation',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        // ═══════════════════════════════════════════════════════════
        // AREA AUDIT #1 — Kesklinn / Tallinn City Centre
        // ═══════════════════════════════════════════════════════════

        AreaAudit::updateOrCreate(
            ['slug' => 'kesklinn-tallinn', 'locale' => 'et'],
            [
                'title' => 'Kinnisvara audit: Tallinn Kesklinn — turuanalüüs 2025',
                'meta_title' => 'Kesklinn Tallinn kinnisvara audit 2025 | CityEE',
                'meta_description' => 'Tallinna Kesklinna kinnisvaraturu audit: mediaanhinnad, müügidünaamika, prognoos. Ekspertanalüüs Aleksandr Tarasovilt.',
                'excerpt' => 'Põhjalik Tallinna Kesklinna kinnisvaraturu analüüs — hinnad, dünaamika, investeerimispotentsiaal.',
                'content_blocks' => [
                    'summary' => '<p>Tallinna Kesklinn on kinnisvaraturu premium-segment. 2025. aasta I kvartalis: mediaanhind 3200 €/m², keskmiselt 42 päeva müügil, aktiivne nõudlus 2–3-toaliste korterite järele.</p>',
                    'market_data' => '<ul><li><strong>Mediaanhind:</strong> 3200 €/m² (2-toaline korter)</li><li><strong>Hinnadünaamika:</strong> +5.2% aasta-aastalt</li><li><strong>Keskmine müügiaeg:</strong> 42 päeva</li><li><strong>Aktiivsemad segmendid:</strong> 2-toalised 45–65 m²</li><li><strong>Üüritootlus:</strong> 5.1–6.3% bruto</li></ul>',
                    'sections' => [
                        [
                            'heading' => 'Müügistrateegia Kesklinna jaoks',
                            'body' => '<p>Kesklinna objekte otsivad nii kohalikud kui ka välismaalased. Mitmekeelne turundus (eesti + vene + inglise) katab 100% sihtgrupist. Professionaalne pildistamine on kohustuslik — Kesklinna ostjad on nõudlikud.</p>',
                        ],
                        [
                            'heading' => 'Investeeringu potentsiaal',
                            'body' => '<p>Kesklinn pakub stabiilset üüritootlust ja kapitalikasvupotentsiaali. Lühiajaline üür (Airbnb) annab kõrgemat tootlust, kuid nõuab aktiivset haldamist.</p>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'Milline on Kesklinna kinnisvara keskmine hind?', 'answer' => '<p>2025. aasta I kvartalis on Tallinna Kesklinna mediaan 3200 €/m². Uusarendused küünivad 4500–6000 €/m².</p>'],
                        ['question' => 'Kas Kesklinn on hea investeering?', 'answer' => '<p>Jah. Kesklinn pakub 5–6% bruto üüritootlust ja stabiilset hindade kasvu 4–6% aastas viimase 5 aasta jooksul.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Soovid Kesklinna kinnisvara müüa?',
                        'text' => 'Tasuta turuanalüüs ja müügistrateegia.',
                        'button' => 'Telli tasuta audit',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        AreaAudit::updateOrCreate(
            ['slug' => 'kesklinn-tallinn', 'locale' => 'ru'],
            [
                'title' => 'Аудит недвижимости: Таллинн Кесклинн — анализ рынка 2025',
                'meta_title' => 'Кесклинн Таллинн аудит недвижимости 2025 | CityEE',
                'meta_description' => 'Аудит рынка недвижимости Таллинна Кесклинн: медианные цены, динамика продаж, прогноз. Экспертный анализ Александра Тарасова.',
                'excerpt' => 'Полный анализ рынка недвижимости Таллинна Кесклинн — цены, динамика, инвестиционный потенциал.',
                'content_blocks' => [
                    'summary' => '<p>Кесклинн Таллинна — премиальный сегмент рынка. I квартал 2025: медианная цена 3200 €/м², в среднем 42 дня на продажу, активный спрос на 2–3-комнатные квартиры.</p>',
                    'market_data' => '<ul><li><strong>Медианная цена:</strong> 3200 €/м² (2-комнатная)</li><li><strong>Динамика цен:</strong> +5.2% год к году</li><li><strong>Среднее время продажи:</strong> 42 дня</li><li><strong>Активный сегмент:</strong> 2-комнатные 45–65 м²</li><li><strong>Арендная доходность:</strong> 5.1–6.3% брутто</li></ul>',
                    'sections' => [
                        [
                            'heading' => 'Стратегия продажи в Кесклинне',
                            'body' => '<p>Объекты в Кесклинне ищут как местные, так и иностранцы. Мультиязычный маркетинг (эстонский + русский + английский) покрывает 100% целевой аудитории.</p>',
                        ],
                        [
                            'heading' => 'Инвестиционный потенциал',
                            'body' => '<p>Кесклинн предлагает стабильную арендную доходность и потенциал роста капитала. Краткосрочная аренда (Airbnb) даёт более высокую доходность.</p>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'Какова средняя цена недвижимости в Кесклинне?', 'answer' => '<p>В I квартале 2025 медиана в Кесклинне составляет 3200 €/м². Новостройки — 4500–6000 €/м².</p>'],
                        ['question' => 'Кесклинн — хорошая инвестиция?', 'answer' => '<p>Да. Кесклинн предлагает 5–6% брутто арендной доходности и стабильный рост цен 4–6% в год.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Хотите продать недвижимость в Кесклинне?',
                        'text' => 'Бесплатный анализ рынка и стратегия продажи.',
                        'button' => 'Заказать бесплатный аудит',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );

        AreaAudit::updateOrCreate(
            ['slug' => 'kesklinn-tallinn', 'locale' => 'en'],
            [
                'title' => 'Property Audit: Tallinn City Centre — Market Analysis 2025',
                'meta_title' => 'Tallinn City Centre Property Audit 2025 | CityEE',
                'meta_description' => 'Tallinn City Centre real estate market audit: median prices, sales dynamics, forecast. Expert analysis by Aleksandr Tarasov.',
                'excerpt' => 'Comprehensive Tallinn City Centre property market analysis — prices, dynamics, investment potential.',
                'content_blocks' => [
                    'summary' => '<p>Tallinn City Centre is the premium market segment. Q1 2025: median price €3,200/m², average 42 days on market, active demand for 2–3 bedroom apartments.</p>',
                    'market_data' => '<ul><li><strong>Median price:</strong> €3,200/m² (2-bedroom)</li><li><strong>Price dynamics:</strong> +5.2% year-on-year</li><li><strong>Average selling time:</strong> 42 days</li><li><strong>Active segment:</strong> 2-bedroom 45–65 m²</li><li><strong>Rental yield:</strong> 5.1–6.3% gross</li></ul>',
                    'sections' => [
                        [
                            'heading' => 'Selling Strategy for City Centre',
                            'body' => '<p>City Centre properties are sought by both locals and foreigners. Multilingual marketing (Estonian + Russian + English) covers 100% of the target audience.</p>',
                        ],
                        [
                            'heading' => 'Investment Potential',
                            'body' => '<p>City Centre offers stable rental yields and capital growth. Short-term rental (Airbnb) provides higher returns but requires active management.</p>',
                        ],
                    ],
                    'faq' => [
                        ['question' => 'What is the average property price in Tallinn City Centre?', 'answer' => '<p>Q1 2025 median in City Centre is €3,200/m². New developments reach €4,500–6,000/m².</p>'],
                        ['question' => 'Is City Centre a good investment?', 'answer' => '<p>Yes. City Centre offers 5–6% gross rental yield and stable price growth of 4–6% per year.</p>'],
                    ],
                    'cta' => [
                        'heading' => 'Want to sell property in City Centre?',
                        'text' => 'Free market analysis and selling strategy.',
                        'button' => 'Order Free Audit',
                    ],
                ],
                'priority' => 0.8,
                'published' => true,
                'published_at' => now(),
            ]
        );
    }
}
