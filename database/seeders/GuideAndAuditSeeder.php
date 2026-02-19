<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;
use App\Models\AreaAudit;
use Illuminate\Support\Carbon;

/**
 * ЭТАП 5 — Full seeder: 5 guides + 3 audits × 3 languages (ET/RU/EN).
 *
 * Guide topics:
 *  1. sell-apartment-without-losing-money  — Sell apartment without losing 5–15k
 *  2. real-price-corridor                  — Real price corridor: how to set the right price
 *  3. kv-ee-listing-checklist              — KV.ee listing checklist: 27 points
 *  4. safe-rental-tenant-check             — Safe rental + tenant verification
 *  5. 30-45-day-sales-plan                 — 30–45 day sales plan
 *
 * Audit topics:
 *  1. kv-ee-listing-audit                  — KV.ee listing audit
 *  2. price-corridor-negotiation-strategy  — Price corridor + negotiation strategy
 *  3. 30-45-day-sales-plan-audit           — 30–45 day sales plan (audit)
 */
class GuideAndAuditSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing
        Guide::truncate();
        AreaAudit::truncate();

        $now = Carbon::now();

        // ══════════════════════════════════════
        //  GUIDES
        // ══════════════════════════════════════
        $guides = $this->getGuides($now);
        foreach ($guides as $guide) {
            Guide::create($guide);
        }

        // ══════════════════════════════════════
        //  AUDITS
        // ══════════════════════════════════════
        $audits = $this->getAudits($now);
        foreach ($audits as $audit) {
            AreaAudit::create($audit);
        }
    }

    // ═══════════════════════════════════════════════════
    //  GUIDE DATA
    // ═══════════════════════════════════════════════════

    private function getGuides(Carbon $now): array
    {
        return array_merge(
            $this->guide1($now),
            $this->guide2($now),
            $this->guide3($now),
            $this->guide4($now),
            $this->guide5($now),
        );
    }

    /**
     * Guide 1: Sell apartment without losing 5-15k (3 locales)
     */
    private function guide1(Carbon $now): array
    {
        $slug = 'sell-apartment-without-losing-money';
        $base = [
            'slug'             => $slug,
            'category'         => 'sell',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 12,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(5),
            'related_guide_slugs'  => json_encode(['real-price-corridor', '30-45-day-sales-plan']),
            'related_audit_slugs'  => json_encode(['kv-ee-listing-audit', 'price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale'           => 'ru',
                'title'            => 'Как продать квартиру в Таллинне и не потерять 5–15 000 €',
                'excerpt'          => 'Пошаговый гайд: от подготовки до сделки. Реальные цифры, проверенная стратегия, 300+ завершённых сделок.',
                'meta_title'       => 'Как продать квартиру в Таллинне без потерь | CityEE',
                'meta_description' => 'Пошаговая инструкция продажи квартиры в Таллинне: ценовой коридор, подготовка, фото, показы. 10+ лет опыта, 300+ сделок.',
                'og_title'         => 'Продать квартиру в Таллинне без потерь — CityEE Гайд',
                'og_description'   => 'Полный гайд: как не потерять 5–15k€ при продаже квартиры в Таллинне.',
                'ai_summary'       => 'Средняя потеря при самостоятельной продаже квартиры в Таллинне — 5–15 000 €. Причины: завышенная/заниженная цена, плохое объявление, слабые переговоры. Гайд раскрывает пошаговую стратегию, которая за 10+ лет и 300+ сделок доказала: правильная подготовка и ценообразование = максимальная цена продажи.',
                'key_takeaways'    => json_encode([
                    'Правильный ценовой коридор = +5–10% к финальной цене',
                    'Профессиональные фото увеличивают просмотры на 40–60%',
                    'Подготовка квартиры (decluttering + staging) окупается в 3–5 раз',
                    'Первые 14 дней объявления — самые важные на KV.ee',
                    'Стратегия переговоров экономит собственнику 3–8% от цены',
                ]),
                'location_tags'    => json_encode(['Tallinn', 'Harjumaa', 'Kesklinn', 'Lasnamäe', 'Mustamäe', 'Õismäe']),
                'faq_json'         => json_encode($this->guide1FaqRu()),
                'content_blocks'   => json_encode([
                    'quick_answer' => 'Чтобы не потерять 5–15 000 € при продаже квартиры в Таллинне: определите точный ценовой коридор по данным Maa-amet, подготовьте квартиру, закажите профессиональные фото, опубликуйте на KV.ee в правильное время, и ведите переговоры с позиции силы.',
                    'intro' => '<p>По данным Maa-amet за 2024 год, средняя цена квадратного метра в Таллинне достигла 2 800–3 200 €. При этом разница между хорошо подготовленным и «как есть» объявлением может составлять 5–15 000 € на двухкомнатную квартиру.</p><p>В этом гайде — проверенная на 300+ сделках стратегия, которая поможет получить максимальную цену.</p>',
                    'sections' => [
                        ['heading' => 'Шаг 1: Определите реальный ценовой коридор', 'snippet' => 'Ценовой коридор — диапазон между минимальной и максимальной реалистичной ценой, основанный на сделках Maa-amet за последние 6 месяцев.', 'body' => '<p>Проверьте реальные сделки на <a href="https://www.maaamet.ee" rel="noopener" target="_blank">Maa-amet</a> за последние 6 месяцев в вашем районе. Сравните: площадь, этаж, состояние ремонта, тип дома. Это даст коридор ±5–10% от вашей стартовой цены.</p><p>Ошибка №1 собственников — ставить цену «как у соседа». Цена соседа на KV.ee ≠ цена реальной сделки.</p>', 'cta_text' => 'Заказать бесплатный расчёт ценового коридора'],
                        ['heading' => 'Шаг 2: Подготовьте квартиру к продаже', 'snippet' => 'Decluttering + мелкий ремонт окупаются в 3–5 раз.', 'body' => '<p>Минимальный чек-лист: уберите личные вещи, проведите генеральную уборку, устраните мелкие дефекты (подтекающий кран, сколы на стенах). Стоимость подготовки 200–500 € → возврат 1 000–3 000 € в цене продажи.</p>'],
                        ['heading' => 'Шаг 3: Закажите профессиональные фото', 'snippet' => 'Объявления с профессиональными фото получают на 40–60% больше просмотров на KV.ee.', 'body' => '<p>Фото — первое, что видит покупатель. 5–10 качественных снимков с правильными ракурсами и освещением увеличивают CTR объявления на 40–60%. Стоимость съёмки: 100–200 €.</p>'],
                        ['heading' => 'Шаг 4: Публикация на KV.ee — таймлинг и текст', 'snippet' => 'Первые 14 дней на KV.ee дают 60% всех просмотров. Ваше объявление должно быть идеальным с первого дня.', 'body' => '<p>Лучшее время публикации: вторник–четверг, утро. Заголовок должен содержать район + тип + ключевое преимущество. Описание — факты, замеры, инфраструктура в радиусе 500м.</p>'],
                        ['heading' => 'Шаг 5: Стратегия переговоров', 'snippet' => 'Правильная стратегия переговоров экономит собственнику 3–8% от цены сделки.', 'body' => '<p>Не соглашайтесь на первое предложение. Используйте «метод двух покупателей»: создайте ощущение конкуренции. Всегда имейте минимальную цену, ниже которой не опускаетесь, и аргументы на основе данных Maa-amet.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet — Kinnisvara tehingute statistika', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/', 'note' => 'Официальная статистика сделок'],
                        ['title' => 'KV.ee — Крупнейший портал недвижимости Эстонии', 'url' => 'https://www.kv.ee/', 'note' => 'Актуальные объявления'],
                    ],
                    'cta' => ['heading' => 'Готовы продать с максимальной выгодой?', 'text' => 'Получите бесплатный расчёт ценового коридора и стратегию продажи за 24 часа.', 'button' => 'Бесплатная консультация'],
                ]),
            ]),
            array_merge($base, [
                'locale'           => 'et',
                'title'            => 'Kuidas müüa korter Tallinnas ja mitte kaotada 5–15 000 €',
                'excerpt'          => 'Samm-sammuline juhend: ettevalmistusest tehinguni. Tegelikud numbrid, tõestatud strateegia, 300+ tehingut.',
                'meta_title'       => 'Kuidas müüa korter Tallinnas kaotamata | CityEE',
                'meta_description' => 'Korteri müügi juhend Tallinnas: hinnakoridor, ettevalmistus, fotod, näitamised. 10+ aastat, 300+ tehingut.',
                'og_title'         => 'Müü korter Tallinnas kaotamata — CityEE juhend',
                'og_description'   => 'Täielik juhend: kuidas mitte kaotada 5–15k€ korteri müügil Tallinnas.',
                'ai_summary'       => 'Keskmine kaotus iseseisvalt müües Tallinnas — 5–15 000 €. Põhjused: vale hind, halb kuulutus, nõrgad läbirääkimised. Juhend avab strateegia, mis 10+ aasta ja 300+ tehingu jooksul on tõestanud: õige ettevalmistus ja hinnastamine = maksimaalne müügihind.',
                'key_takeaways'    => json_encode([
                    'Õige hinnakoridor = +5–10% lõpphinnale',
                    'Professionaalsed fotod suurendavad vaatamisi 40–60%',
                    'Korteri ettevalmistus tasub end 3–5 korda',
                    'Esimesed 14 päeva KV.ee-s on kõige olulisemad',
                    'Läbirääkimisstrateegia säästab omanikule 3–8% hinnast',
                ]),
                'location_tags'    => json_encode(['Tallinn', 'Harjumaa', 'Kesklinn', 'Lasnamäe', 'Mustamäe', 'Õismäe']),
                'faq_json'         => json_encode($this->guide1FaqEt()),
                'content_blocks'   => json_encode([
                    'quick_answer' => 'Et mitte kaotada 5–15 000 € korteri müügil Tallinnas: määrake täpne hinnakoridor Maa-ameti andmete põhjal, valmistage korter ette, tellige professionaalsed fotod, avaldage KV.ee-s õigel ajal ja pidage läbirääkimisi tugevalt positsioonilt.',
                    'intro' => '<p>Maa-ameti 2024. aasta andmetel on Tallinna keskmine ruutmeetri hind 2 800–3 200 €. Hästi ettevalmistatud ja halvasti ettevalmistatud kuulutuse vahe võib 2-toalise korteri puhul olla 5–15 000 €.</p>',
                    'sections' => [
                        ['heading' => '1. samm: Määrake tegelik hinnakoridor', 'snippet' => 'Hinnakoridor on vahemik minimaalse ja maksimaalse realistliku hinna vahel, põhinedes Maa-ameti tehingutel viimase 6 kuu jooksul.', 'body' => '<p>Kontrollige tegelikke tehinguid Maa-ametis viimase 6 kuu jooksul teie piirkonnas.</p>'],
                        ['heading' => '2. samm: Valmistage korter müügiks ette', 'snippet' => 'Decluttering + väikeremont tasub end 3–5 korda.', 'body' => '<p>Minimaalne kontrollnimekiri: eemaldage isiklikud asjad, tehke põhjalik koristus, kõrvaldage väiksed defektid.</p>'],
                        ['heading' => '3. samm: Tellige professionaalsed fotod', 'snippet' => 'Professionaalsete fotodega kuulutused saavad KV.ee-s 40–60% rohkem vaatamisi.', 'body' => '<p>Fotod on esimene asi, mida ostja näeb. 5–10 kvaliteetset pilti õigete nurkade ja valgusega.</p>'],
                        ['heading' => '4. samm: Avaldamine KV.ee-s', 'snippet' => 'Esimesed 14 päeva KV.ee-s annavad 60% kõigist vaatamistest.', 'body' => '<p>Parim avaldamisaeg: teisipäev–neljapäev, hommikul.</p>'],
                        ['heading' => '5. samm: Läbirääkimisstrateegia', 'snippet' => 'Õige läbirääkimisstrateegia säästab omanikule 3–8% tehingu hinnast.', 'body' => '<p>Ärge nõustuge esimese pakkumisega. Kasutage kahe ostja meetodit.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet — Kinnisvara tehingute statistika', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/'],
                        ['title' => 'KV.ee', 'url' => 'https://www.kv.ee/'],
                    ],
                    'cta' => ['heading' => 'Valmis müüma maksimaalse kasuga?', 'text' => 'Saage tasuta hinnakoridori arvutus ja müügistrateegia 24 tunniga.', 'button' => 'Tasuta konsultatsioon'],
                ]),
            ]),
            array_merge($base, [
                'locale'           => 'en',
                'title'            => 'How to Sell an Apartment in Tallinn Without Losing 5–15,000 €',
                'excerpt'          => 'Step-by-step guide: from preparation to closing. Real numbers, proven strategy, 300+ completed deals.',
                'meta_title'       => 'How to Sell an Apartment in Tallinn | CityEE Guide',
                'meta_description' => 'Step-by-step apartment selling guide in Tallinn: price corridor, preparation, photos, showings. 10+ years, 300+ deals.',
                'og_title'         => 'Sell an Apartment in Tallinn Without Losing Money — CityEE Guide',
                'og_description'   => 'Complete guide: how not to lose 5–15k€ when selling an apartment in Tallinn.',
                'ai_summary'       => 'The average loss when selling independently in Tallinn is 5–15,000 €. Reasons: wrong pricing, poor listing, weak negotiations. This guide reveals a step-by-step strategy proven over 10+ years and 300+ deals: proper preparation and pricing = maximum sale price.',
                'key_takeaways'    => json_encode([
                    'Correct price corridor = +5–10% to final price',
                    'Professional photos increase views by 40–60%',
                    'Apartment preparation pays back 3–5x',
                    'First 14 days on KV.ee are the most important',
                    'Negotiation strategy saves the owner 3–8% of the price',
                ]),
                'location_tags'    => json_encode(['Tallinn', 'Harjumaa', 'Kesklinn', 'Lasnamäe', 'Mustamäe', 'Õismäe']),
                'faq_json'         => json_encode($this->guide1FaqEn()),
                'content_blocks'   => json_encode([
                    'quick_answer' => 'To avoid losing 5–15,000 € selling an apartment in Tallinn: determine the exact price corridor using Maa-amet data, prepare the apartment, order professional photos, publish on KV.ee at the right time, and negotiate from a position of strength.',
                    'intro' => '<p>According to Maa-amet 2024 data, the average price per sqm in Tallinn reached 2,800–3,200 €. The difference between a well-prepared and an "as-is" listing can be 5–15,000 € for a two-room apartment.</p>',
                    'sections' => [
                        ['heading' => 'Step 1: Determine the Real Price Corridor', 'snippet' => 'A price corridor is the range between minimum and maximum realistic price, based on Maa-amet transactions over the past 6 months.', 'body' => '<p>Check real transactions at Maa-amet for the past 6 months in your area.</p>'],
                        ['heading' => 'Step 2: Prepare the Apartment for Sale', 'snippet' => 'Decluttering + minor repairs pay back 3–5 times.', 'body' => '<p>Minimum checklist: remove personal items, deep clean, fix minor defects.</p>'],
                        ['heading' => 'Step 3: Order Professional Photos', 'snippet' => 'Listings with professional photos get 40–60% more views on KV.ee.', 'body' => '<p>Photos are the first thing a buyer sees. 5–10 quality shots with proper angles and lighting.</p>'],
                        ['heading' => 'Step 4: Publishing on KV.ee — Timing & Copy', 'snippet' => 'First 14 days on KV.ee generate 60% of all views.', 'body' => '<p>Best publishing time: Tuesday–Thursday morning.</p>'],
                        ['heading' => 'Step 5: Negotiation Strategy', 'snippet' => 'The right negotiation strategy saves the owner 3–8% of the deal price.', 'body' => '<p>Don\'t agree to the first offer. Use the "two buyers" method.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet — Real Estate Transaction Statistics', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/'],
                        ['title' => 'KV.ee', 'url' => 'https://www.kv.ee/'],
                    ],
                    'cta' => ['heading' => 'Ready to sell for maximum value?', 'text' => 'Get a free price corridor calculation and sales strategy within 24 hours.', 'button' => 'Free Consultation'],
                ]),
            ]),
        ];
    }

    /**
     * Guide 2: Real Price Corridor (3 locales)
     */
    private function guide2(Carbon $now): array
    {
        $slug = 'real-price-corridor';
        $base = [
            'slug'             => $slug,
            'category'         => 'pricing',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 10,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(8),
            'related_guide_slugs'  => json_encode(['sell-apartment-without-losing-money', 'kv-ee-listing-checklist']),
            'related_audit_slugs'  => json_encode(['price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Реальный ценовой коридор: как определить правильную цену квартиры в Таллинне',
                'excerpt' => 'Метод ценового коридора на основе данных Maa-amet: точная оценка за 15 минут.',
                'meta_title' => 'Ценовой коридор квартиры в Таллинне | CityEE',
                'meta_description' => 'Как определить правильную цену квартиры: метод ценового коридора по данным Maa-amet. Формула + примеры.',
                'og_title' => 'Ценовой коридор квартиры — CityEE',
                'og_description' => 'Точная оценка цены квартиры в Таллинне — метод ценового коридора.',
                'ai_summary' => 'Ценовой коридор — диапазон между минимальной и максимальной реальной ценой продажи, рассчитанный на основе завершённых сделок Maa-amet за 6 месяцев. Метод учитывает район, площадь, этаж, состояние ремонта и тип дома. Точный коридор позволяет выставить оптимальную стартовую цену и получить на 5–10% больше.',
                'key_takeaways' => json_encode([
                    'Ценовой коридор = реальные сделки Maa-amet за 6 месяцев',
                    'Цена на KV.ee ≠ цена реальной сделки (разница 5–15%)',
                    'Формула: медиана сделок ± 10% = ваш коридор',
                    'Стартовая цена = верхняя граница коридора',
                    'Пересмотр цены — через 14 дней без предложений',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide2FaqRu()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Ценовой коридор — это диапазон ±10% от медианы реальных сделок Maa-amet за последние 6 месяцев в вашем районе. Стартовую цену выставляйте по верхней границе.',
                    'intro' => '<p>80% собственников ставят цену «по ощущениям» или «как у соседа на KV.ee». Результат: объявление висит 60+ дней, покупатели торгуются жёстко. Метод ценового коридора решает эту проблему.</p>',
                    'sections' => [
                        ['heading' => 'Что такое ценовой коридор', 'snippet' => 'Ценовой коридор — диапазон цен, в котором реально продаётся объект сопоставимого качества в вашем районе.', 'body' => '<p>Коридор рассчитывается на основе реальных сделок (не объявлений!) за последние 6 месяцев. Источник данных: государственный реестр Maa-amet.</p>'],
                        ['heading' => 'Как рассчитать: пошаговая формула', 'snippet' => 'Шаг 1: Найдите 5–10 аналогичных сделок в Maa-amet. Шаг 2: Рассчитайте медиану цены за м². Шаг 3: Диапазон ±10% = ваш коридор.', 'body' => '<p>Пример для Kesklinn: 5 сделок по 3 100–3 500 €/м² → медиана 3 300 €/м² → коридор 2 970–3 630 €/м². Для квартиры 50 м²: 148 500–181 500 €.</p>'],
                        ['heading' => 'Ошибки при ценообразовании', 'snippet' => 'Главная ошибка: ставить цену по объявлениям на KV.ee. Цена объявления на 5–15% выше реальной цены сделки.', 'body' => '<p>Портальная цена — это «wish price» продавца. Реальная цена сделки всегда ниже. Используйте только данные Maa-amet.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet — Kinnisvara tehingud', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/'],
                    ],
                    'cta' => ['heading' => 'Хотите узнать точный коридор для вашей квартиры?', 'text' => 'Бесплатный расчёт на основе данных Maa-amet за 2 часа.', 'button' => 'Получить расчёт'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Tegelik hinnakoridor: kuidas määrata õige korterihind Tallinnas',
                'excerpt' => 'Hinnakoridori meetod Maa-ameti andmete põhjal: täpne hinnang 15 minutiga.',
                'meta_title' => 'Korteri hinnakoridor Tallinnas | CityEE',
                'meta_description' => 'Kuidas määrata korteri õige hind: hinnakoridori meetod Maa-ameti andmete põhjal. Valem + näited.',
                'og_title' => 'Korteri hinnakoridor — CityEE',
                'og_description' => 'Täpne korterihinna hinnang Tallinnas — hinnakoridori meetod.',
                'ai_summary' => 'Hinnakoridor on vahemik minimaalse ja maksimaalse reaalse müügihinna vahel, arvutatuna Maa-ameti tehingute põhjal 6 kuu jooksul. Meetod arvestab piirkonda, pindala, korrust, remondi seisukorda ja maja tüüpi.',
                'key_takeaways' => json_encode([
                    'Hinnakoridor = Maa-ameti tegelikud tehingud 6 kuu jooksul',
                    'KV.ee hind ≠ tegeliku tehingu hind (vahe 5–15%)',
                    'Valem: tehingute mediaan ± 10% = teie koridor',
                    'Stardihind = koridori ülemine piir',
                    'Hinna ülevaatus — 14 päeva pärast ilma pakkumisteta',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide2FaqEt()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Hinnakoridor on ±10% tehingute mediaanist Maa-ametis viimase 6 kuu jooksul teie piirkonnas. Stardihinna panege koridori ülemisele piirile.',
                    'intro' => '<p>80% omanikest paneb hinna "tunde järgi". Hinnakoridori meetod lahendab selle probleemi.</p>',
                    'sections' => [
                        ['heading' => 'Mis on hinnakoridor', 'body' => '<p>Koridor arvutatakse tegelike tehingute põhjal (mitte kuulutused!) viimase 6 kuu jooksul.</p>'],
                        ['heading' => 'Kuidas arvutada: samm-sammuline valem', 'body' => '<p>Näide Kesklinna jaoks: 5 tehingut 3 100–3 500 €/m² → mediaan 3 300 €/m² → koridor 2 970–3 630 €/m².</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite teada oma korteri täpset koridori?', 'text' => 'Tasuta arvutus Maa-ameti andmete põhjal 2 tunniga.', 'button' => 'Saa arvutus'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Real Price Corridor: How to Determine the Right Apartment Price in Tallinn',
                'excerpt' => 'Price corridor method based on Maa-amet data: accurate estimate in 15 minutes.',
                'meta_title' => 'Apartment Price Corridor in Tallinn | CityEE',
                'meta_description' => 'How to determine the right apartment price: price corridor method using Maa-amet data. Formula + examples.',
                'og_title' => 'Apartment Price Corridor — CityEE',
                'og_description' => 'Accurate apartment price estimate in Tallinn — the price corridor method.',
                'ai_summary' => 'A price corridor is the range between the minimum and maximum realistic sale price, calculated from Maa-amet completed transactions over 6 months. The method accounts for district, area, floor, renovation condition, and building type.',
                'key_takeaways' => json_encode([
                    'Price corridor = real Maa-amet transactions over 6 months',
                    'KV.ee price ≠ actual deal price (5–15% difference)',
                    'Formula: median of deals ± 10% = your corridor',
                    'Starting price = upper boundary of the corridor',
                    'Price review — after 14 days without offers',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide2FaqEn()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'A price corridor is ±10% from the median of real Maa-amet transactions over the past 6 months in your area. Set the starting price at the upper boundary.',
                    'intro' => '<p>80% of owners set prices "by feeling." The price corridor method solves this problem using data-driven approach.</p>',
                    'sections' => [
                        ['heading' => 'What Is a Price Corridor', 'body' => '<p>Calculated from real transactions (not listings!) over the past 6 months. Data source: Maa-amet state registry.</p>'],
                        ['heading' => 'How to Calculate: Step-by-Step', 'body' => '<p>Example for Kesklinn: 5 deals at 3,100–3,500 €/sqm → median 3,300 €/sqm → corridor 2,970–3,630 €/sqm.</p>'],
                    ],
                    'cta' => ['heading' => 'Want to know the exact corridor for your apartment?', 'text' => 'Free calculation based on Maa-amet data within 2 hours.', 'button' => 'Get Calculation'],
                ]),
            ]),
        ];
    }

    /**
     * Guide 3: KV.ee Listing Checklist (3 locales)
     */
    private function guide3(Carbon $now): array
    {
        $slug = 'kv-ee-listing-checklist';
        $base = [
            'slug'             => $slug,
            'category'         => 'marketing',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 8,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(12),
            'related_guide_slugs'  => json_encode(['sell-apartment-without-losing-money', 'real-price-corridor']),
            'related_audit_slugs'  => json_encode(['kv-ee-listing-audit']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Чек-лист идеального объявления на KV.ee: 27 пунктов',
                'excerpt' => 'Полный чек-лист для продающего объявления на KV.ee. Каждый пункт проверен на 300+ сделках.',
                'meta_title' => 'Чек-лист объявления на KV.ee — 27 пунктов | CityEE',
                'meta_description' => 'Идеальное объявление на KV.ee: чек-лист из 27 пунктов. Фото, текст, цена, тайминг — всё для максимума просмотров.',
                'ai_summary' => 'Объявление на KV.ee — главный инструмент продажи. От его качества зависит 60–80% результата. Чек-лист из 27 пунктов покрывает: заголовок, текст, фото, цену, тайминг и дополнительные опции. Каждый пункт проверен на 300+ реальных сделках в Таллинне.',
                'key_takeaways' => json_encode([
                    'Заголовок: район + тип + ключевое преимущество',
                    'Фото: минимум 10, первое — лучшая комната с окном',
                    'Текст: факты > эмоции. Площадь, ремонт, инфраструктура',
                    'Публикация: вт–чт утром, премиум-пакет на старте',
                    'Обновление: раз в 7 дней для поддержания позиции',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide3FaqRu()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Идеальное объявление на KV.ee: привлекающий заголовок с районом, 10+ профессиональных фото, фактологическое описание на 2 языках, правильная цена на верхней границе коридора, публикация вт–чт утром.',
                    'intro' => '<p>Среднее объявление на KV.ee набирает 200–400 просмотров. Объявление по нашему чек-листу — 800–1500. Разница = больше звонков = больше предложений = выше цена.</p>',
                    'sections' => [
                        ['heading' => 'Блок 1: Заголовок (5 пунктов)', 'body' => '<p><strong>1.</strong> Район в начале заголовка<br><strong>2.</strong> Тип объекта<br><strong>3.</strong> Ключевое преимущество (вид, ремонт, парковка)<br><strong>4.</strong> Площадь<br><strong>5.</strong> Без CAPS LOCK и восклицательных знаков</p>'],
                        ['heading' => 'Блок 2: Фото (7 пунктов)', 'body' => '<p><strong>6.</strong> Минимум 10 фото<br><strong>7.</strong> Первое фото — лучшая комната с окном<br><strong>8.</strong> Профессиональный фотограф<br><strong>9.</strong> Широкий угол, естественный свет<br><strong>10.</strong> Фасад дома + вход<br><strong>11.</strong> Вид из окна<br><strong>12.</strong> План квартиры</p>'],
                        ['heading' => 'Блок 3: Описание (8 пунктов)', 'body' => '<p><strong>13.</strong> Площадь и комнаты<br><strong>14.</strong> Год постройки и ремонта<br><strong>15.</strong> Тип отопления и коммунальные<br><strong>16.</strong> Этаж / лифт<br><strong>17.</strong> Парковка / хранение<br><strong>18.</strong> Инфраструктура (школы, магазины, транспорт)<br><strong>19.</strong> Описание на 2 языках (эст + рус)<br><strong>20.</strong> Без орфографических ошибок</p>'],
                        ['heading' => 'Блок 4: Цена и тайминг (7 пунктов)', 'body' => '<p><strong>21.</strong> Цена по верхней границе коридора<br><strong>22.</strong> Публикация вт–чт утром<br><strong>23.</strong> Премиум-пакет на первые 14 дней<br><strong>24.</strong> Обновление раз в 7 дней<br><strong>25.</strong> Контактный телефон доступен<br><strong>26.</strong> Быстрый ответ на запросы (< 1 часа)<br><strong>27.</strong> Анализ статистики просмотров через 7 дней</p>'],
                    ],
                    'cta' => ['heading' => 'Хотите проверку вашего объявления?', 'text' => 'Бесплатный аудит объявления на KV.ee за 2 часа.', 'button' => 'Заказать аудит'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Ideaalse KV.ee kuulutuse kontrollnimekiri: 27 punkti',
                'excerpt' => 'Täielik kontrollnimekiri müüva KV.ee kuulutuse jaoks. Iga punkt testitud 300+ tehingul.',
                'meta_title' => 'KV.ee kuulutuse kontrollnimekiri — 27 punkti | CityEE',
                'meta_description' => 'Ideaalne KV.ee kuulutus: 27-punktiline kontrollnimekiri. Fotod, tekst, hind, ajastus.',
                'ai_summary' => 'KV.ee kuulutus on müügi peamine tööriist. Kvaliteedist sõltub 60–80% tulemusest. 27-punktiline nimekiri katab: pealkiri, tekst, fotod, hind, ajastus ja lisavalikud.',
                'key_takeaways' => json_encode([
                    'Pealkiri: piirkond + tüüp + peamine eelis',
                    'Fotod: vähemalt 10, esimene — parim tuba aknaga',
                    'Tekst: faktid > emotsioonid',
                    'Avaldamine: T-N hommikul, premium pakett alguses',
                    'Uuendamine: iga 7 päeva järel',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide3FaqEt()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Ideaalne KV.ee kuulutus: mõjuv pealkiri piirkonnaga, 10+ professionaalset fotot, faktiline kirjeldus 2 keeles, õige hind koridori ülemisel piiril, avaldamine T-N hommikul.',
                    'intro' => '<p>Keskmine KV.ee kuulutus kogub 200–400 vaatamist. Meie kontrollnimekirja järgi tehtud kuulutus — 800–1500.</p>',
                    'sections' => [
                        ['heading' => 'Plokk 1: Pealkiri (5 punkti)', 'body' => '<p>Piirkond pealkirja alguses, objekti tüüp, peamine eelis, pindala, ilma suurtähtedeta.</p>'],
                        ['heading' => 'Plokk 2: Fotod (7 punkti)', 'body' => '<p>Vähemalt 10 fotot, professionaalne fotograaf, lai nurk, plaan.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite oma kuulutuse kontrolli?', 'text' => 'Tasuta KV.ee kuulutuse audit 2 tunniga.', 'button' => 'Telli audit'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Perfect KV.ee Listing Checklist: 27 Points',
                'excerpt' => 'Complete checklist for a selling KV.ee listing. Every point tested on 300+ deals.',
                'meta_title' => 'KV.ee Listing Checklist — 27 Points | CityEE',
                'meta_description' => 'Perfect KV.ee listing: 27-point checklist. Photos, copy, pricing, timing — everything for maximum views.',
                'ai_summary' => 'Your KV.ee listing is the main selling tool. Its quality determines 60–80% of the outcome. This 27-point checklist covers: headline, copy, photos, price, timing, and extra options.',
                'key_takeaways' => json_encode([
                    'Headline: district + type + key advantage',
                    'Photos: minimum 10, first one — best room with window',
                    'Copy: facts > emotions. Area, renovation, infrastructure',
                    'Publishing: Tue–Thu morning, premium package at launch',
                    'Refresh: every 7 days to maintain position',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide3FaqEn()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Perfect KV.ee listing: attention-grabbing headline with district, 10+ professional photos, fact-based description in 2 languages, correct price at the upper boundary of the corridor, published Tue–Thu morning.',
                    'intro' => '<p>Average KV.ee listing gets 200–400 views. A listing following our checklist — 800–1,500.</p>',
                    'sections' => [
                        ['heading' => 'Block 1: Headline (5 points)', 'body' => '<p>District at the beginning, property type, key advantage, area, no CAPS LOCK.</p>'],
                        ['heading' => 'Block 2: Photos (7 points)', 'body' => '<p>Minimum 10 photos, professional photographer, wide angle, floor plan.</p>'],
                    ],
                    'cta' => ['heading' => 'Want your listing reviewed?', 'text' => 'Free KV.ee listing audit within 2 hours.', 'button' => 'Order Audit'],
                ]),
            ]),
        ];
    }

    /**
     * Guide 4: Safe Rental + Tenant Check (3 locales)
     */
    private function guide4(Carbon $now): array
    {
        $slug = 'safe-rental-tenant-check';
        $base = [
            'slug'             => $slug,
            'category'         => 'rent',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 9,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(15),
            'related_guide_slugs'  => json_encode(['sell-apartment-without-losing-money', 'kv-ee-listing-checklist']),
            'related_audit_slugs'  => json_encode(['kv-ee-listing-audit']),
            'service_link_key' => 'rent',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Безопасная аренда: полный чек-лист проверки арендатора',
                'excerpt' => 'Как сдать квартиру в Таллинне и не получить проблемного арендатора. Чек-лист из 15 пунктов.',
                'meta_title' => 'Проверка арендатора: чек-лист | CityEE',
                'meta_description' => 'Безопасная аренда в Таллинне: чек-лист проверки арендатора из 15 пунктов. Документы, гарантии, договор.',
                'ai_summary' => 'Проблемный арендатор может стоить собственнику 2 000–10 000 € (неоплаченная аренда, повреждения, судебные расходы). Полный чек-лист проверки: документы, кредитная история, рекомендации работодателя, залог и правильный договор — минимизирует риск до 2–3%.',
                'key_takeaways' => json_encode([
                    'Проверяйте документы: паспорт/ID + ВНЖ + трудовой договор',
                    'Запросите справку из Creditinfo (публичные долги)',
                    'Залог = 2 месяца аренды (минимум)',
                    'Договор на эстонском языке с приложением инвентаря',
                    'Акт приёма-передачи с фото — обязателен',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide4FaqRu()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Для безопасной аренды: проверьте документы и кредитную историю арендатора, возьмите залог 2 месяца, составьте правильный договор с инвентарём и актом приёма-передачи.',
                    'intro' => '<p>Средний убыток от проблемного арендатора в Таллинне — 2 000–10 000 €. Этот гайд поможет минимизировать риск.</p>',
                    'sections' => [
                        ['heading' => 'Этап 1: Проверка документов', 'body' => '<p>Паспорт/ID-карта, вид на жительство, трудовой договор или справка о доходах. Для иностранцев — дополнительно ВНЖ.</p>'],
                        ['heading' => 'Этап 2: Кредитная проверка', 'body' => '<p>Запросите согласие на проверку через Creditinfo. Публичные долги = красный флаг.</p>'],
                        ['heading' => 'Этап 3: Правильный договор', 'body' => '<p>Договор на эстонском языке, с приложением: инвентарь + состояние + фото + акт приёма-передачи.</p>'],
                        ['heading' => 'Этап 4: Залог и гарантии', 'body' => '<p>Залог = 2 месяца аренды. Первый + последний месяц + залог = 3 месяца при заселении.</p>'],
                    ],
                    'cta' => ['heading' => 'Нужна помощь с арендой?', 'text' => 'Проверка арендатора и оформление договора — от 200 €.', 'button' => 'Заказать проверку'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Turvaline üürimine: üürniku kontrollimise täielik nimekiri',
                'excerpt' => 'Kuidas üürida korter Tallinnas ja vältida probleemset üürnikku. 15-punktiline kontrollnimekiri.',
                'meta_title' => 'Üürniku kontroll: kontrollnimekiri | CityEE',
                'meta_description' => 'Turvaline üürimine Tallinnas: üürniku kontrollnimekiri 15 punkti. Dokumendid, garantiid, leping.',
                'ai_summary' => 'Probleemne üürnik võib omanikule maksma minna 2 000–10 000 €. Täielik kontrollnimekiri: dokumendid, krediidiajalugu, tööandja soovitused, tagatisraha ja õige leping.',
                'key_takeaways' => json_encode([
                    'Kontrollige dokumente: pass/ID + elamisluba + tööleping',
                    'Küsige Creditinfo tõendit (avalikud võlad)',
                    'Tagatisraha = 2 kuu üür (miinimum)',
                    'Leping eesti keeles koos inventari lisaga',
                    'Üleandmisakt fotodega — kohustuslik',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide4FaqEt()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Turvaliseks üürimiseks: kontrollige üürniku dokumente ja krediidiajalugu, võtke 2 kuu tagatisraha, koostage õige leping inventari ja üleandmisaktiga.',
                    'intro' => '<p>Keskmine kahju probleemse üürniku tõttu Tallinnas — 2 000–10 000 €. See juhend aitab riski minimeerida.</p>',
                    'sections' => [
                        ['heading' => '1. etapp: Dokumentide kontroll', 'body' => '<p>Pass/ID-kaart, elamisluba, tööleping või sissetulekutõend.</p>'],
                        ['heading' => '2. etapp: Krediidikontroll', 'body' => '<p>Küsige nõusolekut Creditinfo kontrolliks. Avalikud võlad = punane lipp.</p>'],
                    ],
                    'cta' => ['heading' => 'Vajate abi üürimisega?', 'text' => 'Üürniku kontroll ja lepingu vormistamine — alates 200 €.', 'button' => 'Telli kontroll'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Safe Rental: Complete Tenant Verification Checklist',
                'excerpt' => 'How to rent out your apartment in Tallinn safely. 15-point tenant check checklist.',
                'meta_title' => 'Tenant Verification Checklist | CityEE',
                'meta_description' => 'Safe rental in Tallinn: 15-point tenant verification checklist. Documents, guarantees, contract.',
                'ai_summary' => 'A problematic tenant can cost the owner 2,000–10,000 € (unpaid rent, damages, legal costs). Complete verification checklist: documents, credit history, employer references, deposit and proper contract — minimizes risk to 2–3%.',
                'key_takeaways' => json_encode([
                    'Verify documents: passport/ID + residence permit + employment contract',
                    'Request Creditinfo certificate (public debts)',
                    'Deposit = 2 months rent (minimum)',
                    'Contract in Estonian with inventory appendix',
                    'Handover act with photos — mandatory',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide4FaqEn()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'For safe rental: verify tenant documents and credit history, collect 2-month deposit, draft a proper contract with inventory and handover act.',
                    'intro' => '<p>Average loss from a problematic tenant in Tallinn — 2,000–10,000 €. This guide helps minimize the risk.</p>',
                    'sections' => [
                        ['heading' => 'Stage 1: Document Verification', 'body' => '<p>Passport/ID card, residence permit, employment contract or income certificate.</p>'],
                        ['heading' => 'Stage 2: Credit Check', 'body' => '<p>Request consent for Creditinfo check. Public debts = red flag.</p>'],
                    ],
                    'cta' => ['heading' => 'Need help with rental?', 'text' => 'Tenant verification and contract drafting — from 200 €.', 'button' => 'Order Verification'],
                ]),
            ]),
        ];
    }

    /**
     * Guide 5: 30-45 Day Sales Plan (3 locales)
     */
    private function guide5(Carbon $now): array
    {
        $slug = '30-45-day-sales-plan';
        $base = [
            'slug'             => $slug,
            'category'         => 'sell',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 11,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(3),
            'related_guide_slugs'  => json_encode(['sell-apartment-without-losing-money', 'real-price-corridor']),
            'related_audit_slugs'  => json_encode(['30-45-day-sales-plan-audit']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'План продажи квартиры за 30–45 дней: пошаговая стратегия',
                'excerpt' => 'Как продать квартиру в Таллинне за 30–45 дней по максимальной цене. Полный таймлайн с дедлайнами.',
                'meta_title' => 'План продажи квартиры за 30–45 дней | CityEE',
                'meta_description' => 'Пошаговый план продажи квартиры в Таллинне за 30–45 дней: подготовка, публикация, показы, переговоры, сделка.',
                'ai_summary' => 'Средний срок продажи квартиры в Таллинне — 60–90 дней. С правильным планом и стратегией CityEE сокращает этот срок до 30–45 дней без снижения цены. Ключ — чёткий таймлайн: неделя 1 — подготовка, неделя 2 — публикация, недели 3–4 — показы и переговоры, неделя 5–6 — предварительный договор и сделка.',
                'key_takeaways' => json_encode([
                    'Неделя 1: подготовка квартиры + ценовой коридор + фото',
                    'Неделя 2: публикация на KV.ee + продвижение',
                    'Недели 3–4: показы и сбор предложений',
                    'Неделя 4–5: переговоры с топ-покупателями',
                    'Неделя 5–6: предварительный договор + нотариус',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide5FaqRu()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'План 30–45 дней: неделя 1 — подготовка + коридор + фото, неделя 2 — KV.ee публикация, недели 3–4 — показы, неделя 5 — переговоры, неделя 6 — нотариус.',
                    'intro' => '<p>Средний срок продажи квартиры в Таллинне — 60–90 дней. Наш план сокращает его вдвое, сохраняя (и часто увеличивая) цену.</p>',
                    'sections' => [
                        ['heading' => 'Неделя 1: Подготовка', 'snippet' => 'Первая неделя — фундамент всей продажи: ценовой коридор, подготовка квартиры, профессиональная фотосъёмка.', 'body' => '<p>День 1–2: расчёт ценового коридора по Maa-amet. День 3–4: decluttering и мелкий ремонт. День 5–7: фотосъёмка и подготовка текста объявления.</p>'],
                        ['heading' => 'Неделя 2: Публикация и продвижение', 'body' => '<p>Публикация на KV.ee во вторник–четверг утром. Премиум-пакет на 14 дней. Дублирование в социальных сетях и тематических чатах.</p>'],
                        ['heading' => 'Недели 3–4: Показы', 'body' => '<p>Организация показов группами (2–3 покупателя вместе = ощущение конкуренции). Сбор обратной связи после каждого показа.</p>'],
                        ['heading' => 'Неделя 5: Переговоры', 'body' => '<p>Работа с лучшими предложениями. Метод «двух покупателей». Финальный торг с позиции силы.</p>'],
                        ['heading' => 'Неделя 6: Сделка', 'body' => '<p>Предварительный договор → нотариус → передача ключей. Вся бумажная работа занимает 3–5 дней.</p>'],
                    ],
                    'cta' => ['heading' => 'Хотите продать за 30–45 дней?', 'text' => 'Получите персональный план продажи бесплатно.', 'button' => 'Получить план'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Korteri müügiplaan 30–45 päevaga: samm-sammuline strateegia',
                'excerpt' => 'Kuidas müüa korter Tallinnas 30–45 päevaga maksimaalse hinnaga. Täielik ajakava.',
                'meta_title' => 'Korteri müügiplaan 30–45 päeva | CityEE',
                'meta_description' => 'Samm-sammuline korteri müügiplaan Tallinnas 30–45 päevaga: ettevalmistus, avaldamine, näitamised, läbirääkimised.',
                'ai_summary' => 'Keskmine müügiaeg Tallinnas — 60–90 päeva. Õige plaaniga lühendab CityEE selle 30–45 päevale ilma hinda langetamata.',
                'key_takeaways' => json_encode([
                    '1. nädal: korteri ettevalmistus + hinnakoridor + fotod',
                    '2. nädal: KV.ee avaldamine + reklaam',
                    '3.–4. nädal: näitamised ja pakkumiste kogumine',
                    '5. nädal: läbirääkimised parimate ostjatega',
                    '6. nädal: eelleping + notar',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide5FaqEt()),
                'content_blocks' => json_encode([
                    'quick_answer' => 'Plaan 30–45 päeva: 1. nädal — ettevalmistus + koridor + fotod, 2. nädal — KV.ee, 3.–4. nädal — näitamised, 5. nädal — läbirääkimised, 6. nädal — notar.',
                    'intro' => '<p>Keskmine müügiaeg Tallinnas on 60–90 päeva. Meie plaan lühendab selle poole võrra.</p>',
                    'sections' => [
                        ['heading' => '1. nädal: Ettevalmistus', 'body' => '<p>Hinnakoridori arvutus, decluttering, fotosessioon.</p>'],
                        ['heading' => '2. nädal: Avaldamine', 'body' => '<p>KV.ee avaldamine T–N hommikul. Premium pakett.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite müüa 30–45 päevaga?', 'text' => 'Saage personaalne müügiplaan tasuta.', 'button' => 'Saa plaan'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Apartment Sales Plan in 30–45 Days: Step-by-Step Strategy',
                'excerpt' => 'How to sell an apartment in Tallinn in 30–45 days at maximum price. Complete timeline with deadlines.',
                'meta_title' => 'Apartment Sales Plan 30–45 Days | CityEE',
                'meta_description' => 'Step-by-step apartment sales plan in Tallinn in 30–45 days: preparation, publishing, showings, negotiations, closing.',
                'ai_summary' => 'Average selling time in Tallinn is 60–90 days. With the right plan, CityEE cuts this to 30–45 days without reducing the price.',
                'key_takeaways' => json_encode([
                    'Week 1: apartment preparation + price corridor + photos',
                    'Week 2: KV.ee publication + promotion',
                    'Weeks 3–4: showings and collecting offers',
                    'Week 5: negotiations with top buyers',
                    'Week 6: preliminary contract + notary',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Harjumaa']),
                'faq_json' => json_encode($this->guide5FaqEn()),
                'content_blocks' => json_encode([
                    'quick_answer' => '30–45 day plan: week 1 — preparation + corridor + photos, week 2 — KV.ee publication, weeks 3–4 — showings, week 5 — negotiations, week 6 — notary.',
                    'intro' => '<p>Average selling time in Tallinn is 60–90 days. Our plan halves it while maintaining (and often increasing) the price.</p>',
                    'sections' => [
                        ['heading' => 'Week 1: Preparation', 'body' => '<p>Price corridor calculation, decluttering, photo session.</p>'],
                        ['heading' => 'Week 2: Publication', 'body' => '<p>KV.ee publication Tue–Thu morning. Premium package.</p>'],
                    ],
                    'cta' => ['heading' => 'Want to sell in 30–45 days?', 'text' => 'Get a personalized sales plan for free.', 'button' => 'Get Plan'],
                ]),
            ]),
        ];
    }

    // ═══════════════════════════════════════════════════
    //  AUDIT DATA
    // ═══════════════════════════════════════════════════

    private function getAudits(Carbon $now): array
    {
        return array_merge(
            $this->audit1($now),
            $this->audit2($now),
            $this->audit3($now),
        );
    }

    /**
     * Audit 1: KV.ee Listing Audit (3 locales)
     */
    private function audit1(Carbon $now): array
    {
        $slug = 'kv-ee-listing-audit';
        $base = [
            'slug'             => $slug,
            'audit_type'       => 'listing_audit',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 8,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(4),
            'related_guide_slugs'  => json_encode(['kv-ee-listing-checklist', 'sell-apartment-without-losing-money']),
            'related_audit_slugs'  => json_encode(['price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Аудит объявления на KV.ee: реальный разбор 2-комнатной в Kesklinn',
                'excerpt' => 'Разбираем реальное объявление: что не так с фото, ценой и текстом. До и после оптимизации.',
                'meta_title' => 'Аудит объявления KV.ee — реальный разбор | CityEE',
                'meta_description' => 'Аудит реального объявления на KV.ee: 2-комнатная в Kesklinn. Ошибки фото, цены и текста. Рекомендации.',
                'ai_summary' => 'Аудит реального объявления 2-комнатной квартиры в Kesklinn на KV.ee. Выявлены 12 критических ошибок: тёмные фото без естественного света, завышенная цена на 8% выше коридора, текст без ключевых фактов. После оптимизации: просмотры выросли на 340%, получено 4 предложения за 10 дней.',
                'key_takeaways' => json_encode([
                    'Тёмные фото снижают CTR объявления на 50–70%',
                    'Цена выше коридора на 8% = 0 предложений за 30 дней',
                    'Отсутствие площади в заголовке — потеря 20% просмотров',
                    'После оптимизации: +340% просмотров за первые 7 дней',
                    'Профессиональные фото + правильная цена = 4 предложения за 10 дней',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Kesklinn']),
                'faq_json' => json_encode($this->audit1FaqRu()),
                'content_blocks' => json_encode([
                    'summary' => '<p>Владелец 2-комнатной квартиры (52 м²) в Kesklinn опубликовал объявление на KV.ee. За 30 дней — 0 предложений, 180 просмотров. После аудита CityEE и оптимизации — 4 предложения за 10 дней, продажа по цене +3% от ценового коридора.</p>',
                    'market_data' => '<div class="audit-stats"><div class="audit-stat"><span class="audit-stat__value">52 м²</span><span class="audit-stat__label">Площадь</span></div><div class="audit-stat"><span class="audit-stat__value">Kesklinn</span><span class="audit-stat__label">Район</span></div><div class="audit-stat"><span class="audit-stat__value">3 200 €/м²</span><span class="audit-stat__label">Медиана Maa-amet</span></div><div class="audit-stat"><span class="audit-stat__value">+340%</span><span class="audit-stat__label">Рост просмотров</span></div></div>',
                    'sections' => [
                        ['heading' => 'Ошибка 1: Тёмные фото', 'snippet' => 'Фото без естественного света снижают CTR объявления на 50–70%.', 'body' => '<p>Все 6 фото сделаны вечером при искусственном освещении. Комнаты выглядят тесными и тёмными. Рекомендация: пересъёмка днём, 10+ фото с широким углом.</p>'],
                        ['heading' => 'Ошибка 2: Завышенная цена', 'snippet' => 'Цена была выше ценового коридора на 8% — это отсекает 80% покупателей.', 'body' => '<p>Ценовой коридор по Maa-amet: 155 000–172 000 €. Выставленная цена: 185 000 €. Рекомендация: 172 000 € (верхняя граница коридора).</p>'],
                        ['heading' => 'Ошибка 3: Слабый текст', 'body' => '<p>Нет площади в заголовке, нет информации об инфраструктуре, описание только на русском. Рекомендация: двуязычное описание с фактами.</p>'],
                        ['heading' => 'Результат после оптимизации', 'snippet' => 'После внедрения рекомендаций: +340% просмотров, 4 предложения за 10 дней, продажа +3% от коридора.', 'body' => '<p>Новые фото, правильная цена, оптимизированный текст — и результат не заставил себя ждать.</p>'],
                    ],
                    'cta' => ['heading' => 'Хотите такой же разбор?', 'text' => 'Бесплатный аудит вашего объявления на KV.ee за 2 часа.', 'button' => 'Заказать аудит'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'KV.ee kuulutuse audit: tegelik analüüs — 2-toaline Kesklinnas',
                'excerpt' => 'Analüüsime tegelikku kuulutust: mis on valesti fotode, hinna ja tekstiga. Enne ja pärast optimeerimist.',
                'meta_title' => 'KV.ee kuulutuse audit — tegelik analüüs | CityEE',
                'meta_description' => 'Tegeliku KV.ee kuulutuse audit: 2-toaline Kesklinnas. Fotode, hinna ja teksti vead. Soovitused.',
                'ai_summary' => 'Tegeliku 2-toalise korteri kuulutuse audit KV.ee-s Kesklinnas. Tuvastatud 12 kriitilist viga: tumedad fotod, 8% koridorist kõrgem hind, puudulikud faktid.',
                'key_takeaways' => json_encode([
                    'Tumedad fotod vähendavad CTR-i 50–70%',
                    'Hind 8% koridorist kõrgem = 0 pakkumist 30 päevaga',
                    'Pärast optimeerimist: +340% vaatamisi 7 päevaga',
                    'Profifotod + õige hind = 4 pakkumist 10 päevaga',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Kesklinn']),
                'faq_json' => json_encode($this->audit1FaqEt()),
                'content_blocks' => json_encode([
                    'summary' => '<p>2-toalise korteri (52 m²) omanik Kesklinnas avaldas KV.ee kuulutuse. 30 päeva — 0 pakkumist. Pärast CityEE auditi ja optimeerimist — 4 pakkumist 10 päevaga.</p>',
                    'sections' => [
                        ['heading' => 'Viga 1: Tumedad fotod', 'body' => '<p>Kõik fotod tehtud õhtul. Soovitus: ümberpildistamine päeval.</p>'],
                        ['heading' => 'Viga 2: Liiga kõrge hind', 'body' => '<p>Hinnakoridor: 155 000–172 000 €. Pandud hind: 185 000 €.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite sama analüüsi?', 'text' => 'Tasuta KV.ee kuulutuse audit 2 tunniga.', 'button' => 'Telli audit'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'KV.ee Listing Audit: Real Case Study — 2-Room in Kesklinn',
                'excerpt' => 'We analyze a real listing: what\'s wrong with photos, price, and copy. Before and after optimization.',
                'meta_title' => 'KV.ee Listing Audit — Real Case Study | CityEE',
                'meta_description' => 'Real KV.ee listing audit: 2-room in Kesklinn. Photo, price, and copy errors. Recommendations.',
                'ai_summary' => 'Audit of a real 2-room apartment listing on KV.ee in Kesklinn. Found 12 critical errors: dark photos, price 8% above corridor, missing key facts. After optimization: +340% views, 4 offers in 10 days.',
                'key_takeaways' => json_encode([
                    'Dark photos reduce listing CTR by 50–70%',
                    'Price 8% above corridor = 0 offers in 30 days',
                    'After optimization: +340% views in 7 days',
                    'Professional photos + correct price = 4 offers in 10 days',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Kesklinn']),
                'faq_json' => json_encode($this->audit1FaqEn()),
                'content_blocks' => json_encode([
                    'summary' => '<p>Owner of a 2-room apartment (52 sqm) in Kesklinn published on KV.ee. 30 days — 0 offers. After CityEE audit — 4 offers in 10 days, sold at +3% above corridor.</p>',
                    'sections' => [
                        ['heading' => 'Error 1: Dark Photos', 'body' => '<p>All photos taken in the evening. Recommendation: reshoot during daytime.</p>'],
                        ['heading' => 'Error 2: Overpriced', 'body' => '<p>Price corridor: 155,000–172,000 €. Listed at: 185,000 €.</p>'],
                    ],
                    'cta' => ['heading' => 'Want the same analysis?', 'text' => 'Free KV.ee listing audit within 2 hours.', 'button' => 'Order Audit'],
                ]),
            ]),
        ];
    }

    /**
     * Audit 2: Price Corridor + Negotiation Strategy (3 locales)
     */
    private function audit2(Carbon $now): array
    {
        $slug = 'price-corridor-negotiation-strategy';
        $base = [
            'slug'             => $slug,
            'audit_type'       => 'price_corridor',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 10,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(7),
            'related_guide_slugs'  => json_encode(['real-price-corridor', 'sell-apartment-without-losing-money']),
            'related_audit_slugs'  => json_encode(['kv-ee-listing-audit']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Ценовой коридор + стратегия переговоров: разбор 3-комнатной в Mustamäe',
                'excerpt' => 'Как мы нашли точный коридор и выторговали +7 000 € для продавца. Реальные цифры и стратегия.',
                'meta_title' => 'Ценовой коридор и переговоры — разбор | CityEE',
                'meta_description' => 'Реальный разбор: ценовой коридор 3-комнатной в Mustamäe + стратегия переговоров = +7 000 € для продавца.',
                'ai_summary' => 'Разбор продажи 3-комнатной квартиры (68 м²) в Mustamäe. Ценовой коридор по Maa-amet: 136 000–156 000 €. Стартовая цена: 155 000 € (верхняя граница). Применение стратегии «двух покупателей» и аргументации на данных позволило закрыть сделку на 149 000 € (на 7 000 € выше первого предложения покупателя).',
                'key_takeaways' => json_encode([
                    'Коридор по Maa-amet: 136 000–156 000 € (68 м², Mustamäe)',
                    'Стартовая цена = 155 000 € (верхняя граница)',
                    'Первое предложение покупателя: 142 000 €',
                    'Стратегия «двух покупателей» + аргументы по данным',
                    'Финальная цена: 149 000 € (+7 000 € от первого предложения)',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Mustamäe']),
                'faq_json' => json_encode($this->audit2FaqRu()),
                'content_blocks' => json_encode([
                    'summary' => '<p>Собственник 3-комнатной квартиры в Mustamäe (68 м², 5 этаж, капремонт 2019) обратился в CityEE после 45 дней без предложений. Мы пересчитали коридор, оптимизировали объявление и применили стратегию переговоров. Результат: +7 000 € к первому предложению покупателя.</p>',
                    'market_data' => '<div class="audit-stats"><div class="audit-stat"><span class="audit-stat__value">68 м²</span><span class="audit-stat__label">Площадь</span></div><div class="audit-stat"><span class="audit-stat__value">Mustamäe</span><span class="audit-stat__label">Район</span></div><div class="audit-stat"><span class="audit-stat__value">136–156k €</span><span class="audit-stat__label">Коридор</span></div><div class="audit-stat"><span class="audit-stat__value">+7 000 €</span><span class="audit-stat__label">Выигрыш</span></div></div>',
                    'sections' => [
                        ['heading' => 'Этап 1: Пересчёт ценового коридора', 'body' => '<p>По данным Maa-amet за последние 6 месяцев: 8 аналогичных сделок в Mustamäe → медиана 2 150 €/м² → коридор 136 000–156 000 €.</p>'],
                        ['heading' => 'Этап 2: Оптимизация объявления', 'body' => '<p>Новые фото, двуязычный текст, скорректированная цена 155 000 €. За 10 дней: 4 запроса на показ.</p>'],
                        ['heading' => 'Этап 3: Стратегия переговоров', 'body' => '<p>Первое предложение: 142 000 €. Мы не соглашаемся. Аргумент: данные Maa-amet + второй заинтересованный покупатель. Второе предложение: 146 000 €. Контраргумент: ремонт 2019, энергокласс. Финальное: 149 000 €.</p>'],
                    ],
                    'cta' => ['heading' => 'Хотите такую же стратегию?', 'text' => 'Бесплатный расчёт коридора и план переговоров за 24 часа.', 'button' => 'Получить стратегию'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Hinnakoridor + läbirääkimisstrateegia: 3-toalise analüüs Mustamäel',
                'excerpt' => 'Kuidas leidsime täpse koridori ja kaublesime müüjale +7 000 €. Tegelikud numbrid.',
                'meta_title' => 'Hinnakoridor ja läbirääkimised — analüüs | CityEE',
                'meta_description' => 'Tegelik analüüs: 3-toalise hinnakoridor Mustamäel + läbirääkimisstrateegia = +7 000 € müüjale.',
                'ai_summary' => '3-toalise korteri müügianalüüs Mustamäel (68 m²). Maa-ameti hinnakoridor: 136 000–156 000 €. Kahe ostja strateegia andis +7 000 € esimesest pakkumisest.',
                'key_takeaways' => json_encode([
                    'Maa-ameti koridor: 136 000–156 000 € (68 m²)',
                    'Esimene pakkumine: 142 000 €',
                    'Lõpphind: 149 000 € (+7 000 €)',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Mustamäe']),
                'faq_json' => json_encode($this->audit2FaqEt()),
                'content_blocks' => json_encode([
                    'summary' => '<p>3-toalise korteri omanik Mustamäel pöördus CityEE poole pärast 45 päeva ilma pakkumisteta. Tulemus: +7 000 €.</p>',
                    'sections' => [
                        ['heading' => '1. etapp: Hinnakoridori ümberarvutus', 'body' => '<p>Maa-ameti andmed: 8 tehingut → mediaan 2 150 €/m² → koridor 136 000–156 000 €.</p>'],
                        ['heading' => '2. etapp: Läbirääkimised', 'body' => '<p>Esimene pakkumine 142 000 €. Lõpphind 149 000 €.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite sama strateegiat?', 'text' => 'Tasuta koridori arvutus ja läbirääkimisplaan 24 tunniga.', 'button' => 'Saa strateegia'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Price Corridor + Negotiation Strategy: 3-Room Case Study in Mustamäe',
                'excerpt' => 'How we found the exact corridor and negotiated +7,000 € for the seller. Real numbers and strategy.',
                'meta_title' => 'Price Corridor & Negotiations — Case Study | CityEE',
                'meta_description' => 'Real case study: 3-room price corridor in Mustamäe + negotiation strategy = +7,000 € for the seller.',
                'ai_summary' => 'Sale analysis of a 3-room apartment (68 sqm) in Mustamäe. Maa-amet corridor: 136,000–156,000 €. The "two buyers" strategy yielded +7,000 € above the first offer.',
                'key_takeaways' => json_encode([
                    'Maa-amet corridor: 136,000–156,000 € (68 sqm)',
                    'First offer: 142,000 €',
                    'Final price: 149,000 € (+7,000 €)',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Mustamäe']),
                'faq_json' => json_encode($this->audit2FaqEn()),
                'content_blocks' => json_encode([
                    'summary' => '<p>Owner of a 3-room apartment in Mustamäe came to CityEE after 45 days without offers. Result: +7,000 €.</p>',
                    'sections' => [
                        ['heading' => 'Stage 1: Price Corridor Recalculation', 'body' => '<p>Maa-amet data: 8 transactions → median 2,150 €/sqm → corridor 136,000–156,000 €.</p>'],
                        ['heading' => 'Stage 2: Negotiation', 'body' => '<p>First offer 142,000 €. Final price 149,000 €.</p>'],
                    ],
                    'cta' => ['heading' => 'Want the same strategy?', 'text' => 'Free corridor calculation and negotiation plan within 24 hours.', 'button' => 'Get Strategy'],
                ]),
            ]),
        ];
    }

    /**
     * Audit 3: 30-45 Day Sales Plan Audit (3 locales)
     */
    private function audit3(Carbon $now): array
    {
        $slug = '30-45-day-sales-plan-audit';
        $base = [
            'slug'             => $slug,
            'audit_type'       => 'sales_plan',
            'author_name'      => 'Aleksandr Primakov',
            'reviewed_by'      => 'CityEE Expert Team',
            'city_focus'       => 'Tallinn',
            'reading_time_minutes' => 9,
            'published'        => true,
            'published_at'     => $now->copy()->subDays(2),
            'related_guide_slugs'  => json_encode(['30-45-day-sales-plan', 'sell-apartment-without-losing-money']),
            'related_audit_slugs'  => json_encode(['price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'План продажи за 30–45 дней: разбор 1-комнатной в Lasnamäe',
                'excerpt' => 'Как мы продали студию 28 м² за 38 дней по верхней границе коридора. Полный разбор стратегии.',
                'meta_title' => 'План продажи 30–45 дней — разбор | CityEE',
                'meta_description' => 'Разбор: план продажи студии в Lasnamäe за 38 дней. Подготовка → KV.ee → показы → сделка.',
                'ai_summary' => 'Разбор продажи студии 28 м² в Lasnamäe по плану «30–45 дней». Ценовой коридор: 56 000–68 000 €. Выставлена за 67 000 €. Продана за 65 500 € через 38 дней — точно по плану. Ключевые факторы: правильная подготовка за 5 дней, публикация в оптимальное время, 6 показов за 2 недели, закрытие с первым серьёзным покупателем.',
                'key_takeaways' => json_encode([
                    'Коридор: 56 000–68 000 € (28 м², Lasnamäe)',
                    'Стартовая цена: 67 000 € → финальная: 65 500 €',
                    'Срок продажи: 38 дней (план: 30–45)',
                    '5 дней подготовки, 6 показов, 2 предложения',
                    'Минимальные затраты на подготовку: 350 €',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Lasnamäe']),
                'faq_json' => json_encode($this->audit3FaqRu()),
                'content_blocks' => json_encode([
                    'summary' => '<p>Собственник студии (28 м², Lasnamäe, 9 этаж, обновлённый ремонт) хотел продать «как можно быстрее». Мы предложили план «30–45 дней» — и выполнили его: продажа за 38 дней по 65 500 €.</p>',
                    'market_data' => '<div class="audit-stats"><div class="audit-stat"><span class="audit-stat__value">28 м²</span><span class="audit-stat__label">Площадь</span></div><div class="audit-stat"><span class="audit-stat__value">Lasnamäe</span><span class="audit-stat__label">Район</span></div><div class="audit-stat"><span class="audit-stat__value">65 500 €</span><span class="audit-stat__label">Цена сделки</span></div><div class="audit-stat"><span class="audit-stat__value">38 дней</span><span class="audit-stat__label">Срок</span></div></div>',
                    'sections' => [
                        ['heading' => 'Дни 1–5: Подготовка', 'body' => '<p>Расчёт коридора: 56 000–68 000 €. Decluttering + уборка: 150 €. Фотосъёмка: 200 €. Итого подготовка: 350 €.</p>'],
                        ['heading' => 'Дни 6–7: Публикация', 'body' => '<p>KV.ee публикация в среду утром. Премиум-пакет на 14 дней. Цена: 67 000 €.</p>'],
                        ['heading' => 'Дни 8–28: Показы', 'body' => '<p>6 показов за 3 недели. 2 серьёзных предложения: 63 000 € и 64 500 €. Контрпредложение: 65 500 €.</p>'],
                        ['heading' => 'Дни 29–38: Закрытие', 'body' => '<p>Предварительный договор → проверка обременений → нотариус. Сделка закрыта на 38-й день.</p>'],
                    ],
                    'cta' => ['heading' => 'Хотите продать за 30–45 дней?', 'text' => 'Бесплатный анализ вашего объекта и план продажи за 24 часа.', 'button' => 'Получить план'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Müügiplaan 30–45 päeva: 1-toalise analüüs Lasnamäel',
                'excerpt' => 'Kuidas müüsime stuudio 28 m² 38 päevaga koridori ülemise piiri juures. Täielik strateegia.',
                'meta_title' => 'Müügiplaan 30–45 päeva — analüüs | CityEE',
                'meta_description' => 'Analüüs: stuudio müügiplaan Lasnamäel 38 päevaga. Ettevalmistus → KV.ee → näitamised → tehing.',
                'ai_summary' => 'Stuudio (28 m²) müügianalüüs Lasnamäel plaaniga "30–45 päeva". Koridor: 56 000–68 000 €. Müüdud 65 500 €-ga 38 päevaga.',
                'key_takeaways' => json_encode([
                    'Koridor: 56 000–68 000 € (28 m², Lasnamäe)',
                    'Stardihind: 67 000 € → lõpphind: 65 500 €',
                    'Müügiaeg: 38 päeva (plaan: 30–45)',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Lasnamäe']),
                'faq_json' => json_encode($this->audit3FaqEt()),
                'content_blocks' => json_encode([
                    'summary' => '<p>Stuudio omanik (28 m², Lasnamäe) soovis müüa kiiresti. CityEE plaan "30–45 päeva" — müüdud 38 päevaga 65 500 € eest.</p>',
                    'sections' => [
                        ['heading' => 'Päevad 1–5: Ettevalmistus', 'body' => '<p>Koridori arvutus, decluttering, fotosessioon. Kokku: 350 €.</p>'],
                        ['heading' => 'Päevad 6–38: Müük', 'body' => '<p>KV.ee avaldamine, 6 näitamist, 2 pakkumist, tehing.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite müüa 30–45 päevaga?', 'text' => 'Tasuta analüüs ja müügiplaan 24 tunniga.', 'button' => 'Saa plaan'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => '30–45 Day Sales Plan: Studio Case Study in Lasnamäe',
                'excerpt' => 'How we sold a 28 sqm studio in 38 days at the upper corridor boundary. Full strategy breakdown.',
                'meta_title' => '30–45 Day Sales Plan — Case Study | CityEE',
                'meta_description' => 'Case study: studio sales plan in Lasnamäe in 38 days. Preparation → KV.ee → showings → closing.',
                'ai_summary' => 'Sale analysis of a 28 sqm studio in Lasnamäe using the "30–45 day" plan. Corridor: 56,000–68,000 €. Sold for 65,500 € in 38 days.',
                'key_takeaways' => json_encode([
                    'Corridor: 56,000–68,000 € (28 sqm, Lasnamäe)',
                    'Starting price: 67,000 € → final: 65,500 €',
                    'Selling time: 38 days (plan: 30–45)',
                ]),
                'location_tags' => json_encode(['Tallinn', 'Lasnamäe']),
                'faq_json' => json_encode($this->audit3FaqEn()),
                'content_blocks' => json_encode([
                    'summary' => '<p>Studio owner (28 sqm, Lasnamäe) wanted to sell fast. CityEE "30–45 day" plan — sold in 38 days for 65,500 €.</p>',
                    'sections' => [
                        ['heading' => 'Days 1–5: Preparation', 'body' => '<p>Corridor calculation, decluttering, photo session. Total: 350 €.</p>'],
                        ['heading' => 'Days 6–38: Sale', 'body' => '<p>KV.ee publication, 6 showings, 2 offers, closing.</p>'],
                    ],
                    'cta' => ['heading' => 'Want to sell in 30–45 days?', 'text' => 'Free analysis and sales plan within 24 hours.', 'button' => 'Get Plan'],
                ]),
            ]),
        ];
    }

    // ═══════════════════════════════════════════════════
    //  FAQ DATA (8-10 items per guide/audit per locale)
    // ═══════════════════════════════════════════════════

    // ──── Guide 1 FAQ ────

    private function guide1FaqRu(): array
    {
        return [
            ['question' => 'Сколько стоит продать квартиру через маклера?', 'answer' => 'Комиссия маклера в Эстонии обычно 3–4% от цены сделки. Но правильный маклер помогает получить на 5–15% больше — т.е. окупается многократно.'],
            ['question' => 'Можно ли продать квартиру самостоятельно?', 'answer' => 'Да, но по статистике самостоятельные продавцы в среднем получают на 5–15 000 € меньше из-за ошибок в ценообразовании и переговорах.'],
            ['question' => 'Сколько времени занимает продажа квартиры?', 'answer' => 'В среднем 60–90 дней. С правильной стратегией CityEE — 30–45 дней.'],
            ['question' => 'Какие документы нужны для продажи?', 'answer' => 'Выписка из Kinnistusraamat (земельный регистр), энергосертификат, план квартиры, данные о коммунальных платежах.'],
            ['question' => 'Нужен ли энергосертификат?', 'answer' => 'Да, это обязательный документ для продажи в Эстонии. Стоимость: 100–200 €, срок изготовления 3–5 дней.'],
            ['question' => 'Когда лучше всего продавать квартиру?', 'answer' => 'Весна (март–май) и осень (сентябрь–ноябрь) — пиковые сезоны. Но с правильной стратегией можно продать в любое время.'],
            ['question' => 'Как определить правильную цену?', 'answer' => 'Используйте метод ценового коридора: анализ реальных сделок Maa-amet за 6 месяцев в вашем районе. НЕ ориентируйтесь на цены объявлений.'],
            ['question' => 'Стоит ли делать ремонт перед продажей?', 'answer' => 'Полный ремонт не окупается. Но минимальная подготовка (уборка, мелкие починки, staging): вложения 200–500 € → возврат 1 000–3 000 €.'],
            ['question' => 'Что такое предварительный договор?', 'answer' => 'Юридически обязывающий документ перед нотариальной сделкой. Фиксирует цену, сроки и условия. Обычно с задатком 5–10%.'],
            ['question' => 'Кто платит нотариальные расходы?', 'answer' => 'В Эстонии по умолчанию — покупатель. Нотариальный сбор: 0.1–0.5% от цены сделки + государственная пошлина.'],
        ];
    }

    private function guide1FaqEt(): array
    {
        return [
            ['question' => 'Kui palju maksab korteri müük maakleri kaudu?', 'answer' => 'Maakleri tasu Eestis on tavaliselt 3–4% tehingu hinnast. Õige maakler aitab saada 5–15% rohkem.'],
            ['question' => 'Kas ma saan ise korterit müüa?', 'answer' => 'Jah, aga statistiliselt saavad iseseisvad müüjad keskmiselt 5–15 000 € vähem.'],
            ['question' => 'Kui kaua võtab korteri müük aega?', 'answer' => 'Keskmiselt 60–90 päeva. CityEE strateegiaga — 30–45 päeva.'],
            ['question' => 'Millised dokumendid on müügiks vajalikud?', 'answer' => 'Kinnistusraamatu väljavõte, energiamärgis, korteri plaan, kommunaalarvete andmed.'],
            ['question' => 'Kas energiamärgis on kohustuslik?', 'answer' => 'Jah, see on Eestis müügiks kohustuslik dokument. Hind: 100–200 €, valmistamine 3–5 päeva.'],
            ['question' => 'Millal on parim aeg korterit müüa?', 'answer' => 'Kevad (märts–mai) ja sügis (september–november) on tippperioodid.'],
            ['question' => 'Kuidas määrata õige hind?', 'answer' => 'Kasutage hinnakoridori meetodit: Maa-ameti tehingute analüüs viimase 6 kuu jooksul.'],
            ['question' => 'Kas enne müüki tasub remonti teha?', 'answer' => 'Täisremont ei tasu end ära. Aga minimaalne ettevalmistus (koristus, väiksed parandused): 200–500 € → tagasi 1 000–3 000 €.'],
        ];
    }

    private function guide1FaqEn(): array
    {
        return [
            ['question' => 'How much does it cost to sell through a broker?', 'answer' => 'Broker commission in Estonia is typically 3–4% of the deal price. A good broker helps get 5–15% more.'],
            ['question' => 'Can I sell my apartment myself?', 'answer' => 'Yes, but statistically independent sellers get 5–15,000 € less on average.'],
            ['question' => 'How long does it take to sell?', 'answer' => 'On average 60–90 days. With CityEE strategy — 30–45 days.'],
            ['question' => 'What documents are needed?', 'answer' => 'Land registry excerpt, energy certificate, apartment plan, utility bill data.'],
            ['question' => 'Is an energy certificate mandatory?', 'answer' => 'Yes, it\'s mandatory in Estonia. Cost: 100–200 €, delivery 3–5 business days.'],
            ['question' => 'When is the best time to sell?', 'answer' => 'Spring (March–May) and autumn (September–November) are peak seasons.'],
            ['question' => 'How to set the right price?', 'answer' => 'Use the price corridor method: analyze real Maa-amet transactions from the past 6 months in your area.'],
            ['question' => 'Should I renovate before selling?', 'answer' => 'Full renovation doesn\'t pay off. But minimal preparation (cleaning, minor fixes): invest 200–500 € → return 1,000–3,000 €.'],
        ];
    }

    // ──── Guide 2 FAQ ────

    private function guide2FaqRu(): array
    {
        return [
            ['question' => 'Что такое ценовой коридор?', 'answer' => 'Диапазон между минимальной и максимальной реальной ценой продажи, основанный на завершённых сделках Maa-amet за последние 6 месяцев.'],
            ['question' => 'Где найти данные о реальных сделках?', 'answer' => 'На сайте Maa-amet: maaamet.ee/kinnisvara/hinnast — государственный реестр всех сделок с недвижимостью в Эстонии.'],
            ['question' => 'Почему нельзя ориентироваться на цены KV.ee?', 'answer' => 'Цены на KV.ee — это «wish price» продавцов. Реальные сделки обычно на 5–15% ниже.'],
            ['question' => 'Как часто пересчитывать коридор?', 'answer' => 'Каждые 2–3 месяца или при значительных изменениях рынка. Если объявление висит 14+ дней без предложений — пересчитайте.'],
            ['question' => 'Что влияет на цену больше всего?', 'answer' => 'Район, площадь, этаж, ремонт, тип дома (кирпич vs панель), инфраструктура в радиусе 500м.'],
            ['question' => 'Можно ли выставить цену выше коридора?', 'answer' => 'Можно, но риск: объявление «зависнет» на 60+ дней. Рекомендуем: верхняя граница коридора = стартовая цена.'],
            ['question' => 'Чем отличается оценка банка от ценового коридора?', 'answer' => 'Оценка банка — для ипотеки, обычно консервативная (на 5–10% ниже рынка). Коридор — для продажи, показывает реальный диапазон.'],
            ['question' => 'Сколько стоит профессиональная оценка?', 'answer' => 'Банковская оценка: 200–400 €. Расчёт ценового коридора от CityEE — бесплатно.'],
        ];
    }

    private function guide2FaqEt(): array
    {
        return [
            ['question' => 'Mis on hinnakoridor?', 'answer' => 'Vahemik minimaalse ja maksimaalse reaalse müügihinna vahel, põhinedes Maa-ameti tehingutel viimase 6 kuu jooksul.'],
            ['question' => 'Kust leida tegelike tehingute andmeid?', 'answer' => 'Maa-ameti veebilehelt: maaamet.ee/kinnisvara/hinnast.'],
            ['question' => 'Miks ei saa tugineda KV.ee hindadele?', 'answer' => 'KV.ee hinnad on müüjate "soovhinnad". Tegelikud tehingud on tavaliselt 5–15% madalamad.'],
            ['question' => 'Kui tihti tuleks koridori ümber arvutada?', 'answer' => 'Iga 2–3 kuu järel. Kui kuulutus on 14+ päeva ilma pakkumisteta — arvutage ümber.'],
            ['question' => 'Mis mõjutab hinda kõige rohkem?', 'answer' => 'Piirkond, pindala, korrus, remont, maja tüüp, infrastruktuur 500m raadiuses.'],
            ['question' => 'Kas saab hinna panna koridorist kõrgemale?', 'answer' => 'Saab, aga risk: kuulutus jääb 60+ päevaks "rippuma". Soovitus: koridori ülemine piir = stardihind.'],
            ['question' => 'Kuidas erineb panga hindamine hinnakoridorist?', 'answer' => 'Panga hinnang on laenu jaoks, tavaliselt konservatiivne. Koridor näitab tegelikku müügivahemikku.'],
            ['question' => 'Palju maksab professionaalne hindamine?', 'answer' => 'Panga hindamine: 200–400 €. CityEE hinnakoridori arvutus — tasuta.'],
        ];
    }

    private function guide2FaqEn(): array
    {
        return [
            ['question' => 'What is a price corridor?', 'answer' => 'The range between the minimum and maximum realistic sale price, based on Maa-amet completed transactions over the past 6 months.'],
            ['question' => 'Where to find real transaction data?', 'answer' => 'Maa-amet website: maaamet.ee/kinnisvara/hinnast — state registry of all real estate transactions in Estonia.'],
            ['question' => 'Why not rely on KV.ee prices?', 'answer' => 'KV.ee prices are sellers\' "wish prices." Real deals are typically 5–15% lower.'],
            ['question' => 'How often should I recalculate the corridor?', 'answer' => 'Every 2–3 months. If listing has been 14+ days without offers — recalculate.'],
            ['question' => 'What affects the price most?', 'answer' => 'District, area, floor, renovation, building type, infrastructure within 500m.'],
            ['question' => 'Can I price above the corridor?', 'answer' => 'You can, but risk: listing may sit for 60+ days. Recommend: upper corridor boundary = starting price.'],
            ['question' => 'How does a bank appraisal differ?', 'answer' => 'Bank appraisal is for mortgage, usually conservative (5–10% below market). Corridor shows the real selling range.'],
            ['question' => 'How much does a professional appraisal cost?', 'answer' => 'Bank appraisal: 200–400 €. CityEE corridor calculation — free.'],
        ];
    }

    // ──── Guide 3 FAQ ────

    private function guide3FaqRu(): array
    {
        return [
            ['question' => 'Сколько фото нужно для объявления на KV.ee?', 'answer' => 'Минимум 10. Идеально 15–20: все комнаты, кухня, ванная, балкон, вид, подъезд, двор, фасад, план.'],
            ['question' => 'На каком языке писать объявление?', 'answer' => 'Обязательно на двух: эстонском и русском. Это покрывает 95% покупателей в Таллинне.'],
            ['question' => 'Стоит ли покупать премиум-пакет на KV.ee?', 'answer' => 'Да, на первые 14 дней обязательно. Это самое важное окно: 60% всех просмотров приходится на первые 2 недели.'],
            ['question' => 'Что писать в заголовке объявления?', 'answer' => 'Район + тип + ключевое преимущество. Пример: «Kesklinn | 2-к квартира 52м² | Панорамный вид».'],
            ['question' => 'Как часто обновлять объявление?', 'answer' => 'Раз в 7 дней — это поднимает его в выдаче KV.ee.'],
            ['question' => 'Нужен ли профессиональный фотограф?', 'answer' => 'Да. Разница в CTR между любительскими и профессиональными фото: 40–60%. Стоимость: 100–200 €.'],
            ['question' => 'Стоит ли добавлять видеотур?', 'answer' => 'Да, видеотур увеличивает вовлечённость на 30–40%. Особенно важно для покупателей за рубежом.'],
            ['question' => 'Какой формат описания лучше?', 'answer' => 'Структурированный: факты в начале (площадь, ремонт, отопление), потом — инфраструктура и преимущества.'],
        ];
    }

    private function guide3FaqEt(): array
    {
        return [
            ['question' => 'Mitu fotot on KV.ee kuulutusel vaja?', 'answer' => 'Vähemalt 10. Ideaalis 15–20.'],
            ['question' => 'Mis keeles kuulutus kirjutada?', 'answer' => 'Kindlasti kahes: eesti ja vene keeles. See katab 95% ostjaid Tallinnas.'],
            ['question' => 'Kas tasub KV.ee premium paketti osta?', 'answer' => 'Jah, esimesed 14 päeva kindlasti. 60% vaatamistest tuleb esimesel 2 nädalal.'],
            ['question' => 'Mida pealkirja kirjutada?', 'answer' => 'Piirkond + tüüp + peamine eelis. Näide: «Kesklinn | 2-t korter 52m² | Panoraamvaade».'],
            ['question' => 'Kui tihti kuulutust uuendada?', 'answer' => 'Iga 7 päeva järel — see tõstab positsiooni KV.ee-s.'],
            ['question' => 'Kas professionaalne fotograaf on vajalik?', 'answer' => 'Jah. Profi- ja amatöörfotode CTR vahe: 40–60%. Hind: 100–200 €.'],
            ['question' => 'Kas videotuuri tasub lisada?', 'answer' => 'Jah, videotuur suurendab kaasatust 30–40%.'],
            ['question' => 'Milline kirjelduse formaat on parim?', 'answer' => 'Struktureeritud: faktid alguses (pindala, remont, küte), seejärel infrastruktuur ja eelised.'],
        ];
    }

    private function guide3FaqEn(): array
    {
        return [
            ['question' => 'How many photos for a KV.ee listing?', 'answer' => 'Minimum 10. Ideally 15–20.'],
            ['question' => 'What language for the listing?', 'answer' => 'Both Estonian and Russian. This covers 95% of buyers in Tallinn.'],
            ['question' => 'Should I buy the KV.ee premium package?', 'answer' => 'Yes, for the first 14 days — 60% of views come in the first 2 weeks.'],
            ['question' => 'What to write in the headline?', 'answer' => 'District + type + key advantage. Example: "Kesklinn | 2-room 52sqm | Panoramic view".'],
            ['question' => 'How often to refresh the listing?', 'answer' => 'Every 7 days to boost position on KV.ee.'],
            ['question' => 'Do I need a professional photographer?', 'answer' => 'Yes. CTR difference between amateur and professional photos: 40–60%. Cost: 100–200 €.'],
            ['question' => 'Should I add a video tour?', 'answer' => 'Yes, video tours increase engagement by 30–40%.'],
            ['question' => 'What description format is best?', 'answer' => 'Structured: facts first (area, renovation, heating), then infrastructure and advantages.'],
        ];
    }

    // ──── Guide 4 FAQ ────

    private function guide4FaqRu(): array
    {
        return [
            ['question' => 'Какой залог просить у арендатора?', 'answer' => 'Минимум 2 месяца аренды. При высоких рисках (домашние животные, мало истории) — 3 месяца.'],
            ['question' => 'Как проверить кредитную историю арендатора?', 'answer' => 'Через Creditinfo: запросите у арендатора согласие и проверьте публичные долги и кредитные обязательства.'],
            ['question' => 'На каком языке должен быть договор?', 'answer' => 'На эстонском — это юридически обязательный язык. Перевод на русский/английский — для удобства сторон.'],
            ['question' => 'Нужен ли акт приёма-передачи?', 'answer' => 'Обязателен. С фото каждой комнаты, описанием инвентаря и состояния. Это защита при возврате залога.'],
            ['question' => 'Что делать при неоплате аренды?', 'answer' => 'Шаг 1: письменное предупреждение. Шаг 2: 14-дневный срок. Шаг 3: расторжение + заявление в суд. Средний срок процесса: 3–6 месяцев.'],
            ['question' => 'Можно ли отказать арендатору?', 'answer' => 'Да, но нельзя дискриминировать по национальности, полу, возрасту. Можно отказать на основании кредитной истории, доходов, рекомендаций.'],
            ['question' => 'Как разрешить конфликт с арендатором?', 'answer' => 'Медиация через Üürikomisjon (арендная комиссия) — бесплатный государственный орган для разрешения арендных споров.'],
            ['question' => 'Какие расходы несёт арендодатель?', 'answer' => 'Налог на доходы (20%), страховка (50–200 €/год), амортизация, капремонт. Коммунальные — обычно за счёт арендатора.'],
        ];
    }

    private function guide4FaqEt(): array
    {
        return [
            ['question' => 'Millist tagatisraha üürnikult küsida?', 'answer' => 'Vähemalt 2 kuu üür. Kõrgema riski korral — 3 kuud.'],
            ['question' => 'Kuidas kontrollida üürniku krediidiajalugu?', 'answer' => 'Creditinfo kaudu: küsige üürnikult nõusolekut ja kontrollige avalikke võlgu.'],
            ['question' => 'Mis keeles peab leping olema?', 'answer' => 'Eesti keeles — see on juriidiliselt siduv keel. Tõlge mugavuse jaoks.'],
            ['question' => 'Kas üleandmisakt on vajalik?', 'answer' => 'Kohustuslik. Fotodega igast toast, inventari ja seisukorra kirjeldusega.'],
            ['question' => 'Mida teha üüri maksmata jätmisel?', 'answer' => 'Kirjalik hoiatus → 14 päeva → lepingu lõpetamine + kohtusse.'],
            ['question' => 'Kas saan üürnikust keelduda?', 'answer' => 'Jah, aga ei tohi diskrimineerida. Saab keelduda krediidiajaloo, sissetuleku põhjal.'],
            ['question' => 'Kuidas konflikti lahendada?', 'answer' => 'Üürikomisjoni kaudu — tasuta riiklik organ üürivaidluste lahendamiseks.'],
            ['question' => 'Millised kulud jäävad üürileandja kanda?', 'answer' => 'Tulumaks (20%), kindlustus, amortisatsioon, suurem remont.'],
        ];
    }

    private function guide4FaqEn(): array
    {
        return [
            ['question' => 'What deposit to request from a tenant?', 'answer' => 'Minimum 2 months rent. For higher risk (pets, little history) — 3 months.'],
            ['question' => 'How to check tenant credit history?', 'answer' => 'Through Creditinfo: request tenant consent and check public debts.'],
            ['question' => 'What language should the contract be in?', 'answer' => 'Estonian — it\'s the legally binding language. Translation for convenience.'],
            ['question' => 'Is a handover act necessary?', 'answer' => 'Mandatory. With photos of every room, inventory, and condition description.'],
            ['question' => 'What to do about unpaid rent?', 'answer' => 'Step 1: written warning. Step 2: 14-day period. Step 3: termination + court.'],
            ['question' => 'Can I refuse a tenant?', 'answer' => 'Yes, but no discrimination. Can refuse based on credit history, income, references.'],
            ['question' => 'How to resolve a conflict?', 'answer' => 'Through Üürikomisjon — free state body for rental dispute resolution.'],
            ['question' => 'What expenses does the landlord bear?', 'answer' => 'Income tax (20%), insurance, depreciation, major repairs. Utilities — usually tenant.'],
        ];
    }

    // ──── Guide 5 FAQ ────

    private function guide5FaqRu(): array
    {
        return [
            ['question' => 'Реально ли продать квартиру за 30 дней?', 'answer' => 'Да, при правильном ценообразовании и подготовке. 65% наших сделок закрываются за 30–45 дней.'],
            ['question' => 'Что если за 45 дней не продастся?', 'answer' => 'Пересмотр стратегии: коррекция цены (-3–5%), обновление фото, расширение каналов продвижения.'],
            ['question' => 'Сколько стоит подготовка?', 'answer' => 'Минимальная подготовка: 200–500 €. Возврат: 1 000–3 000 € в цене сделки.'],
            ['question' => 'Сколько показов в среднем нужно?', 'answer' => '5–8 показов для продажи. Если после 10 показов нет предложений — проблема в цене.'],
            ['question' => 'Когда лучше начинать?', 'answer' => 'Март–апрель или сентябрь–октябрь — пиковые сезоны. Но план работает круглый год.'],
            ['question' => 'Нужен ли предварительный договор?', 'answer' => 'Рекомендуется. Он фиксирует цену и сроки, чтобы покупатель не передумал. Задаток 5–10%.'],
            ['question' => 'Сколько занимает нотариальная сделка?', 'answer' => '1–3 дня на подготовку документов + 30–60 минут у нотариуса. Деньги переводятся в день сделки.'],
            ['question' => 'Могу ли я жить в квартире во время продажи?', 'answer' => 'Да, но перед показами — генеральная уборка и decluttering. Для фотосъёмки — квартира должна быть максимально «чистой».'],
        ];
    }

    private function guide5FaqEt(): array
    {
        return [
            ['question' => 'Kas on reaalne müüa korter 30 päevaga?', 'answer' => 'Jah, õige hinnastamise ja ettevalmistusega. 65% meie tehingutest sulguvad 30–45 päevaga.'],
            ['question' => 'Mis siis, kui 45 päevaga ei müü?', 'answer' => 'Strateegia ülevaatus: hinna korrigeerimine (-3–5%), fotode uuendamine, kanalite laiendamine.'],
            ['question' => 'Palju ettevalmistus maksab?', 'answer' => 'Minimaalne ettevalmistus: 200–500 €. Tagasi: 1 000–3 000 € tehingu hinnas.'],
            ['question' => 'Mitu näitamist on keskmiselt vaja?', 'answer' => '5–8 näitamist müügiks. Kui 10 näitamist ilma pakkumiseta — probleem on hinnas.'],
            ['question' => 'Millal on parim alustada?', 'answer' => 'Märts–aprill või september–oktoober. Aga plaan töötab aastaringselt.'],
            ['question' => 'Kas eelleping on vajalik?', 'answer' => 'Soovitatav. See fikseerib hinna ja tähtajad. Tagatisraha 5–10%.'],
            ['question' => 'Kui kaua võtab aega notariaaltehing?', 'answer' => '1–3 päeva dokumentide ettevalmistus + 30–60 minutit notari juures.'],
            ['question' => 'Kas saan müügi ajal korteris elada?', 'answer' => 'Jah, aga enne näitamisi — põhjalik koristus ja decluttering.'],
        ];
    }

    private function guide5FaqEn(): array
    {
        return [
            ['question' => 'Is it realistic to sell in 30 days?', 'answer' => 'Yes, with proper pricing and preparation. 65% of our deals close in 30–45 days.'],
            ['question' => 'What if it doesn\'t sell in 45 days?', 'answer' => 'Strategy review: price correction (-3–5%), photo refresh, expanded promotion.'],
            ['question' => 'How much does preparation cost?', 'answer' => 'Minimal preparation: 200–500 €. Return: 1,000–3,000 € in deal price.'],
            ['question' => 'How many showings are typically needed?', 'answer' => '5–8 showings for a sale. If 10 showings with no offers — the price is the issue.'],
            ['question' => 'When is the best time to start?', 'answer' => 'March–April or September–October peak seasons. But the plan works year-round.'],
            ['question' => 'Is a preliminary contract needed?', 'answer' => 'Recommended. It locks in price and timeline. Deposit 5–10%.'],
            ['question' => 'How long does a notary transaction take?', 'answer' => '1–3 days document preparation + 30–60 minutes at the notary.'],
            ['question' => 'Can I live in the apartment during the sale?', 'answer' => 'Yes, but deep clean and declutter before showings.'],
        ];
    }

    // ──── Audit 1 FAQ ────

    private function audit1FaqRu(): array
    {
        return [
            ['question' => 'Что такое аудит объявления?', 'answer' => 'Профессиональная проверка вашего объявления на KV.ee по 27 критериям: фото, текст, цена, позиционирование. Результат: конкретные рекомендации для увеличения звонков.'],
            ['question' => 'Сколько стоит аудит?', 'answer' => 'Базовый аудит — бесплатно. Расширенный с ценовым коридором и стратегией — от 150 €.'],
            ['question' => 'Сколько занимает аудит?', 'answer' => '2–4 часа. Вы получаете детальный отчёт с конкретными рекомендациями.'],
            ['question' => 'Что входит в аудит?', 'answer' => 'Проверка фото (качество, количество, ракурсы), текст (структура, язык, факты), цена (сравнение с коридором), позиционирование (пакет, тайминг).'],
            ['question' => 'Какой результат даёт аудит?', 'answer' => 'В среднем +200–400% просмотров и +3–5 серьёзных предложений за первые 14 дней после оптимизации.'],
            ['question' => 'Нужно ли мне менять маклера после аудита?', 'answer' => 'Не обязательно. Вы можете реализовать рекомендации самостоятельно или попросить текущего маклера.'],
            ['question' => 'Аудит подходит для аренды?', 'answer' => 'Да, те же принципы работают для объявлений на аренду.'],
            ['question' => 'Как заказать аудит?', 'answer' => 'Отправьте ссылку на ваше объявление в WhatsApp или Telegram — и получите отчёт за 2–4 часа.'],
        ];
    }

    private function audit1FaqEt(): array
    {
        return [
            ['question' => 'Mis on kuulutuse audit?', 'answer' => 'Professionaalne KV.ee kuulutuse kontroll 27 kriteeriumi järgi: fotod, tekst, hind, positsioneerimine.'],
            ['question' => 'Palju audit maksab?', 'answer' => 'Baasaudit — tasuta. Laiendatud hinnakoridori ja strateegiaga — alates 150 €.'],
            ['question' => 'Kui kaua audit aega võtab?', 'answer' => '2–4 tundi. Saate üksikasjaliku raporti konkreetsete soovitustega.'],
            ['question' => 'Mida audit sisaldab?', 'answer' => 'Fotode kontroll, tekst, hind (võrdlus koridoriga), positsioneerimine.'],
            ['question' => 'Millist tulemust audit annab?', 'answer' => 'Keskmiselt +200–400% vaatamisi ja +3–5 tõsist pakkumist 14 päevaga.'],
            ['question' => 'Kas pean pärast auditi maaklerit vahetama?', 'answer' => 'Ei pea. Saate soovitusi ise rakendada.'],
            ['question' => 'Kas audit sobib üürimiseks?', 'answer' => 'Jah, samad põhimõtted kehtivad üürikuulutustele.'],
            ['question' => 'Kuidas auditi tellida?', 'answer' => 'Saatke kuulutuse link WhatsAppi või Telegrami — raport 2–4 tunniga.'],
        ];
    }

    private function audit1FaqEn(): array
    {
        return [
            ['question' => 'What is a listing audit?', 'answer' => 'Professional review of your KV.ee listing across 27 criteria: photos, copy, price, positioning.'],
            ['question' => 'How much does an audit cost?', 'answer' => 'Basic audit — free. Extended with price corridor and strategy — from 150 €.'],
            ['question' => 'How long does an audit take?', 'answer' => '2–4 hours. You receive a detailed report with specific recommendations.'],
            ['question' => 'What\'s included in the audit?', 'answer' => 'Photo check, copy analysis, price comparison with corridor, positioning review.'],
            ['question' => 'What results does the audit provide?', 'answer' => 'On average +200–400% views and +3–5 serious offers within 14 days after optimization.'],
            ['question' => 'Do I need to change my broker?', 'answer' => 'Not necessarily. You can implement recommendations yourself.'],
            ['question' => 'Does the audit work for rentals?', 'answer' => 'Yes, the same principles apply to rental listings.'],
            ['question' => 'How to order an audit?', 'answer' => 'Send your listing link via WhatsApp or Telegram — report within 2–4 hours.'],
        ];
    }

    // ──── Audit 2 FAQ ────

    private function audit2FaqRu(): array
    {
        return [
            ['question' => 'Что такое стратегия «двух покупателей»?', 'answer' => 'Создание конкуренции между покупателями: когда есть 2+ заинтересованных, каждый готов предложить больше. Позволяет получить на 3–8% выше первого предложения.'],
            ['question' => 'Откуда берутся данные для коридора?', 'answer' => 'Из государственного реестра Maa-amet — официальная статистика всех сделок с недвижимостью в Эстонии. Это не цены объявлений, а реальные цены сделок.'],
            ['question' => 'Всегда ли переговоры помогают?', 'answer' => 'В 90% случаев. Средний «выигрыш» — 3–8% от первого предложения. Но важна правильная аргументация, основанная на данных.'],
            ['question' => 'Что если покупатель не торгуется?', 'answer' => 'Если цена справедливая и покупатель мотивирован — он может согласиться сразу. Это хороший сценарий.'],
            ['question' => 'Нужен ли мне маклер для переговоров?', 'answer' => 'Рекомендуется. Эмоции — враг переговоров. Профессионал ведёт диалог объективно и с позиции данных.'],
            ['question' => 'Сколько длятся переговоры?', 'answer' => 'Обычно 3–7 дней. Два-три раунда предложений и контрпредложений.'],
            ['question' => 'Что включает разбор CityEE?', 'answer' => 'Расчёт коридора, анализ рынка, стратегия переговоров, поддержка до закрытия сделки.'],
            ['question' => 'Можно ли заказать только коридор без переговоров?', 'answer' => 'Да, базовый расчёт коридора — бесплатно. Полное сопровождение переговоров — по договорённости.'],
        ];
    }

    private function audit2FaqEt(): array
    {
        return [
            ['question' => 'Mis on "kahe ostja" strateegia?', 'answer' => 'Konkurentsi loomine ostjate vahel: 2+ huvitatud ostjat tähendab kõrgemat hinda. Annab 3–8% esimesest pakkumisest rohkem.'],
            ['question' => 'Kust tulevad koridori andmed?', 'answer' => 'Maa-ameti riiklikust registrist — kõigi tehingute ametlik statistika.'],
            ['question' => 'Kas läbirääkimised aitavad alati?', 'answer' => '90% juhtudest. Keskmine "võit" — 3–8% esimesest pakkumisest.'],
            ['question' => 'Mis siis, kui ostja ei kauple?', 'answer' => 'Kui hind on õiglane ja ostja motiveeritud — ta võib kohe nõustuda. See on hea stsenaarium.'],
            ['question' => 'Kas mul on läbirääkimisteks maaklerit vaja?', 'answer' => 'Soovitatav. Emotsioonid on läbirääkimiste vaenlane.'],
            ['question' => 'Kui kaua läbirääkimised kestavad?', 'answer' => 'Tavaliselt 3–7 päeva. 2–3 vooru pakkumisi.'],
            ['question' => 'Mida CityEE analüüs sisaldab?', 'answer' => 'Koridori arvutus, turu analüüs, läbirääkimisstrateegia, tugi tehingu sulgemiseni.'],
            ['question' => 'Kas saan tellida ainult koridori?', 'answer' => 'Jah, baasarvutus on tasuta. Täielik läbirääkimiste tugi — kokkuleppel.'],
        ];
    }

    private function audit2FaqEn(): array
    {
        return [
            ['question' => 'What is the "two buyers" strategy?', 'answer' => 'Creating competition between buyers: with 2+ interested parties, each is willing to offer more. Yields 3–8% above the first offer.'],
            ['question' => 'Where does the corridor data come from?', 'answer' => 'Maa-amet state registry — official statistics of all real estate transactions in Estonia.'],
            ['question' => 'Do negotiations always help?', 'answer' => 'In 90% of cases. Average "gain" is 3–8% above the first offer.'],
            ['question' => 'What if the buyer doesn\'t negotiate?', 'answer' => 'If the price is fair and buyer is motivated — they may agree immediately. That\'s a good scenario.'],
            ['question' => 'Do I need a broker for negotiations?', 'answer' => 'Recommended. Emotions are the enemy of negotiations.'],
            ['question' => 'How long do negotiations last?', 'answer' => 'Usually 3–7 days. Two-three rounds of offers and counteroffers.'],
            ['question' => 'What does CityEE analysis include?', 'answer' => 'Corridor calculation, market analysis, negotiation strategy, support until closing.'],
            ['question' => 'Can I order just the corridor?', 'answer' => 'Yes, basic calculation is free. Full negotiation support — by agreement.'],
        ];
    }

    // ──── Audit 3 FAQ ────

    private function audit3FaqRu(): array
    {
        return [
            ['question' => 'Что входит в план «30–45 дней»?', 'answer' => 'Расчёт коридора, подготовка квартиры, фотосъёмка, публикация на KV.ee, показы, переговоры, сопровождение до нотариуса.'],
            ['question' => 'Гарантируете ли вы продажу за 45 дней?', 'answer' => 'Мы не даём гарантий на срок, но 65% наших объектов продаются за 30–45 дней. Если нет — бесплатно пересматриваем стратегию.'],
            ['question' => 'Сколько стоит план продажи?', 'answer' => 'Разработка плана — бесплатно. Реализация с полным сопровождением — стандартная комиссия 3–4%.'],
            ['question' => 'Работает ли план для дорогих объектов?', 'answer' => 'Да, но срок может быть 45–60 дней для объектов от 300 000 €. Принципы те же.'],
            ['question' => 'Могу ли я реализовать план самостоятельно?', 'answer' => 'Да, используйте наш гайд. Но профессиональное сопровождение повышает результат на 10–20%.'],
            ['question' => 'Что если покупатель требует экспертизу?', 'answer' => 'Это нормально. Закладываем 3–5 дней на техническую проверку. Обычно не влияет на финальный срок.'],
            ['question' => 'Сколько стоит подготовка квартиры?', 'answer' => 'Минимальный пакет: 200–500 €. Включает: генеральная уборка, мелкий ремонт, фотосъёмка.'],
            ['question' => 'Как запустить план?', 'answer' => 'Напишите в WhatsApp или Telegram. Первый шаг: бесплатный расчёт коридора за 2 часа.'],
        ];
    }

    private function audit3FaqEt(): array
    {
        return [
            ['question' => 'Mida "30–45 päeva" plaan sisaldab?', 'answer' => 'Koridori arvutus, ettevalmistus, fotod, KV.ee avaldamine, näitamised, läbirääkimised, tugi notarini.'],
            ['question' => 'Kas garanteerite müügi 45 päevaga?', 'answer' => 'Garantiid ei anna, aga 65% meie objektidest müüakse 30–45 päevaga.'],
            ['question' => 'Palju müügiplaan maksab?', 'answer' => 'Plaani koostamine — tasuta. Täissaatmine — standardne vahendustasu 3–4%.'],
            ['question' => 'Kas plaan töötab kallimate objektidega?', 'answer' => 'Jah, aga aeg võib olla 45–60 päeva objektidel alates 300 000 €.'],
            ['question' => 'Kas saan plaani ise ellu viia?', 'answer' => 'Jah, kasutage meie juhendit. Professionaalne tugi parandab tulemust 10–20%.'],
            ['question' => 'Mis siis, kui ostja tahab ekspertiisi?', 'answer' => 'See on normaalne. Arvestame 3–5 päeva tehniliseks kontrolliks.'],
            ['question' => 'Palju ettevalmistus maksab?', 'answer' => 'Miinimumpakett: 200–500 €. Sisaldab: koristus, väikremont, fotod.'],
            ['question' => 'Kuidas plaani käivitada?', 'answer' => 'Kirjutage WhatsAppi või Telegrami. Esimene samm: tasuta koridori arvutus 2 tunniga.'],
        ];
    }

    private function audit3FaqEn(): array
    {
        return [
            ['question' => 'What\'s included in the "30–45 day" plan?', 'answer' => 'Corridor calculation, preparation, photos, KV.ee publication, showings, negotiations, support until notary.'],
            ['question' => 'Do you guarantee a sale in 45 days?', 'answer' => 'No guarantee on timing, but 65% of our properties sell in 30–45 days.'],
            ['question' => 'How much does the sales plan cost?', 'answer' => 'Plan development — free. Full execution — standard commission 3–4%.'],
            ['question' => 'Does the plan work for expensive properties?', 'answer' => 'Yes, but timeline may be 45–60 days for properties above 300,000 €.'],
            ['question' => 'Can I execute the plan independently?', 'answer' => 'Yes, use our guide. Professional support improves results by 10–20%.'],
            ['question' => 'What if the buyer requests an inspection?', 'answer' => 'Normal. We budget 3–5 days for technical inspection.'],
            ['question' => 'How much does preparation cost?', 'answer' => 'Minimum package: 200–500 €. Includes: deep cleaning, minor repairs, photos.'],
            ['question' => 'How to start the plan?', 'answer' => 'Message us on WhatsApp or Telegram. First step: free corridor calculation within 2 hours.'],
        ];
    }
}
