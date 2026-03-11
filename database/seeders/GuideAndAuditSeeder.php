<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;
use App\Models\AreaAudit;
use Illuminate\Support\Carbon;

/**
 * Ð­Ð¢ÐÐŸ 5 â€” Full seeder: 5 guides + 3 audits Ã— 3 languages (ET/RU/EN).
 *
 * Guide topics:
 *  1. sell-apartment-without-losing-money  â€” Sell apartment without losing 5â€“15k
 *  2. real-price-corridor                  â€” Real price corridor: how to set the right price
 *  3. kv-ee-listing-checklist              â€” KV.ee listing checklist: 27 points
 *  4. safe-rental-tenant-check             â€” Safe rental + tenant verification
 *  5. 30-45-day-sales-plan                 â€” 30â€“45 day sales plan
 *
 * Audit topics:
 *  1. kv-ee-listing-audit                  â€” KV.ee listing audit
 *  2. price-corridor-negotiation-strategy  â€” Price corridor + negotiation strategy
 *  3. 30-45-day-sales-plan-audit           â€” 30â€“45 day sales plan (audit)
 */
class GuideAndAuditSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing
        Guide::truncate();
        AreaAudit::truncate();

        $now = Carbon::now();

        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        //  GUIDES
        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        $guides = $this->getGuides($now);
        foreach ($guides as $guide) {
            Guide::create($guide);
        }

        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        //  AUDITS
        // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
        $audits = $this->getAudits($now);
        foreach ($audits as $audit) {
            AreaAudit::create($audit);
        }
    }

    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    //  GUIDE DATA
    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•

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
            'related_guide_slugs'  => (['real-price-corridor', '30-45-day-sales-plan']),
            'related_audit_slugs'  => (['kv-ee-listing-audit', 'price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale'           => 'ru',
                'title'            => 'ÐšÐ°Ðº Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ Ð¸ Ð½Ðµ Ð¿Ð¾Ñ‚ÐµÑ€ÑÑ‚ÑŒ 5â€“15 000 â‚¬',
                'excerpt'          => 'ÐŸÐ¾ÑˆÐ°Ð³Ð¾Ð²Ñ‹Ð¹ Ð³Ð°Ð¹Ð´: Ð¾Ñ‚ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ¸ Ð´Ð¾ ÑÐ´ÐµÐ»ÐºÐ¸. Ð ÐµÐ°Ð»ÑŒÐ½Ñ‹Ðµ Ñ†Ð¸Ñ„Ñ€Ñ‹, Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐµÐ½Ð½Ð°Ñ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ, 300+ Ð·Ð°Ð²ÐµÑ€ÑˆÑ‘Ð½Ð½Ñ‹Ñ… ÑÐ´ÐµÐ»Ð¾Ðº.',
                'meta_title'       => 'ÐšÐ°Ðº Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ Ð±ÐµÐ· Ð¿Ð¾Ñ‚ÐµÑ€ÑŒ | CityEE',
                'meta_description' => 'ÐŸÐ¾ÑˆÐ°Ð³Ð¾Ð²Ð°Ñ Ð¸Ð½ÑÑ‚Ñ€ÑƒÐºÑ†Ð¸Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ: Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€, Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°, Ñ„Ð¾Ñ‚Ð¾, Ð¿Ð¾ÐºÐ°Ð·Ñ‹. 10+ Ð»ÐµÑ‚ Ð¾Ð¿Ñ‹Ñ‚Ð°, 300+ ÑÐ´ÐµÐ»Ð¾Ðº.',
                'og_title'         => 'ÐŸÑ€Ð¾Ð´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ Ð±ÐµÐ· Ð¿Ð¾Ñ‚ÐµÑ€ÑŒ â€” CityEE Ð“Ð°Ð¹Ð´',
                'og_description'   => 'ÐŸÐ¾Ð»Ð½Ñ‹Ð¹ Ð³Ð°Ð¹Ð´: ÐºÐ°Ðº Ð½Ðµ Ð¿Ð¾Ñ‚ÐµÑ€ÑÑ‚ÑŒ 5â€“15kâ‚¬ Ð¿Ñ€Ð¸ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ðµ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ.',
                'ai_summary'       => 'Ð¡Ñ€ÐµÐ´Ð½ÑÑ Ð¿Ð¾Ñ‚ÐµÑ€Ñ Ð¿Ñ€Ð¸ ÑÐ°Ð¼Ð¾ÑÑ‚Ð¾ÑÑ‚ÐµÐ»ÑŒÐ½Ð¾Ð¹ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ðµ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ â€” 5â€“15 000 â‚¬. ÐŸÑ€Ð¸Ñ‡Ð¸Ð½Ñ‹: Ð·Ð°Ð²Ñ‹ÑˆÐµÐ½Ð½Ð°Ñ/Ð·Ð°Ð½Ð¸Ð¶ÐµÐ½Ð½Ð°Ñ Ñ†ÐµÐ½Ð°, Ð¿Ð»Ð¾Ñ…Ð¾Ðµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ, ÑÐ»Ð°Ð±Ñ‹Ðµ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹. Ð“Ð°Ð¹Ð´ Ñ€Ð°ÑÐºÑ€Ñ‹Ð²Ð°ÐµÑ‚ Ð¿Ð¾ÑˆÐ°Ð³Ð¾Ð²ÑƒÑŽ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÑŽ, ÐºÐ¾Ñ‚Ð¾Ñ€Ð°Ñ Ð·Ð° 10+ Ð»ÐµÑ‚ Ð¸ 300+ ÑÐ´ÐµÐ»Ð¾Ðº Ð´Ð¾ÐºÐ°Ð·Ð°Ð»Ð°: Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð°Ñ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° Ð¸ Ñ†ÐµÐ½Ð¾Ð¾Ð±Ñ€Ð°Ð·Ð¾Ð²Ð°Ð½Ð¸Ðµ = Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½Ð°Ñ Ñ†ÐµÐ½Ð° Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸.',
                'key_takeaways'    => ([
                    'ÐŸÑ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ñ‹Ð¹ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ = +5â€“10% Ðº Ñ„Ð¸Ð½Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ñ†ÐµÐ½Ðµ',
                    'ÐŸÑ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾ ÑƒÐ²ÐµÐ»Ð¸Ñ‡Ð¸Ð²Ð°ÑŽÑ‚ Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ñ‹ Ð½Ð° 40â€“60%',
                    'ÐŸÐ¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ (decluttering + staging) Ð¾ÐºÑƒÐ¿Ð°ÐµÑ‚ÑÑ Ð² 3â€“5 Ñ€Ð°Ð·',
                    'ÐŸÐµÑ€Ð²Ñ‹Ðµ 14 Ð´Ð½ÐµÐ¹ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ â€” ÑÐ°Ð¼Ñ‹Ðµ Ð²Ð°Ð¶Ð½Ñ‹Ðµ Ð½Ð° KV.ee',
                    'Ð¡Ñ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð² ÑÐºÐ¾Ð½Ð¾Ð¼Ð¸Ñ‚ ÑÐ¾Ð±ÑÑ‚Ð²ÐµÐ½Ð½Ð¸ÐºÑƒ 3â€“8% Ð¾Ñ‚ Ñ†ÐµÐ½Ñ‹',
                ]),
                'location_tags'    => (['Tallinn', 'Harjumaa', 'Kesklinn', 'LasnamÃ¤e', 'MustamÃ¤e', 'Ã•ismÃ¤e']),
                'faq_json'         => ($this->guide1FaqRu()),
                'content_blocks'   => ([
                    'quick_answer' => 'Ð§Ñ‚Ð¾Ð±Ñ‹ Ð½Ðµ Ð¿Ð¾Ñ‚ÐµÑ€ÑÑ‚ÑŒ 5â€“15 000 â‚¬ Ð¿Ñ€Ð¸ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ðµ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ: Ð¾Ð¿Ñ€ÐµÐ´ÐµÐ»Ð¸Ñ‚Ðµ Ñ‚Ð¾Ñ‡Ð½Ñ‹Ð¹ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð¿Ð¾ Ð´Ð°Ð½Ð½Ñ‹Ð¼ Maa-amet, Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÑŒÑ‚Ðµ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ, Ð·Ð°ÐºÐ°Ð¶Ð¸Ñ‚Ðµ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾, Ð¾Ð¿ÑƒÐ±Ð»Ð¸ÐºÑƒÐ¹Ñ‚Ðµ Ð½Ð° KV.ee Ð² Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð¾Ðµ Ð²Ñ€ÐµÐ¼Ñ, Ð¸ Ð²ÐµÐ´Ð¸Ñ‚Ðµ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹ Ñ Ð¿Ð¾Ð·Ð¸Ñ†Ð¸Ð¸ ÑÐ¸Ð»Ñ‹.',
                    'intro' => '<p>ÐŸÐ¾ Ð´Ð°Ð½Ð½Ñ‹Ð¼ Maa-amet Ð·Ð° 2024 Ð³Ð¾Ð´, ÑÑ€ÐµÐ´Ð½ÑÑ Ñ†ÐµÐ½Ð° ÐºÐ²Ð°Ð´Ñ€Ð°Ñ‚Ð½Ð¾Ð³Ð¾ Ð¼ÐµÑ‚Ñ€Ð° Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ Ð´Ð¾ÑÑ‚Ð¸Ð³Ð»Ð° 2 800â€“3 200 â‚¬. ÐŸÑ€Ð¸ ÑÑ‚Ð¾Ð¼ Ñ€Ð°Ð·Ð½Ð¸Ñ†Ð° Ð¼ÐµÐ¶Ð´Ñƒ Ñ…Ð¾Ñ€Ð¾ÑˆÐ¾ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²Ð»ÐµÐ½Ð½Ñ‹Ð¼ Ð¸ Â«ÐºÐ°Ðº ÐµÑÑ‚ÑŒÂ» Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸ÐµÐ¼ Ð¼Ð¾Ð¶ÐµÑ‚ ÑÐ¾ÑÑ‚Ð°Ð²Ð»ÑÑ‚ÑŒ 5â€“15 000 â‚¬ Ð½Ð° Ð´Ð²ÑƒÑ…ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½ÑƒÑŽ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ.</p><p>Ð’ ÑÑ‚Ð¾Ð¼ Ð³Ð°Ð¹Ð´Ðµ â€” Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐµÐ½Ð½Ð°Ñ Ð½Ð° 300+ ÑÐ´ÐµÐ»ÐºÐ°Ñ… ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ, ÐºÐ¾Ñ‚Ð¾Ñ€Ð°Ñ Ð¿Ð¾Ð¼Ð¾Ð¶ÐµÑ‚ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½ÑƒÑŽ Ñ†ÐµÐ½Ñƒ.</p>',
                    'sections' => [
                        ['heading' => 'Ð¨Ð°Ð³ 1: ÐžÐ¿Ñ€ÐµÐ´ÐµÐ»Ð¸Ñ‚Ðµ Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€', 'snippet' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ â€” Ð´Ð¸Ð°Ð¿Ð°Ð·Ð¾Ð½ Ð¼ÐµÐ¶Ð´Ñƒ Ð¼Ð¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ð¸ Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ñ€ÐµÐ°Ð»Ð¸ÑÑ‚Ð¸Ñ‡Ð½Ð¾Ð¹ Ñ†ÐµÐ½Ð¾Ð¹, Ð¾ÑÐ½Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ Ð½Ð° ÑÐ´ÐµÐ»ÐºÐ°Ñ… Maa-amet Ð·Ð° Ð¿Ð¾ÑÐ»ÐµÐ´Ð½Ð¸Ðµ 6 Ð¼ÐµÑÑÑ†ÐµÐ².', 'body' => '<p>ÐŸÑ€Ð¾Ð²ÐµÑ€ÑŒÑ‚Ðµ Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ðµ ÑÐ´ÐµÐ»ÐºÐ¸ Ð½Ð° <a href="https://www.maaamet.ee" rel="noopener" target="_blank">Maa-amet</a> Ð·Ð° Ð¿Ð¾ÑÐ»ÐµÐ´Ð½Ð¸Ðµ 6 Ð¼ÐµÑÑÑ†ÐµÐ² Ð² Ð²Ð°ÑˆÐµÐ¼ Ñ€Ð°Ð¹Ð¾Ð½Ðµ. Ð¡Ñ€Ð°Ð²Ð½Ð¸Ñ‚Ðµ: Ð¿Ð»Ð¾Ñ‰Ð°Ð´ÑŒ, ÑÑ‚Ð°Ð¶, ÑÐ¾ÑÑ‚Ð¾ÑÐ½Ð¸Ðµ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚Ð°, Ñ‚Ð¸Ð¿ Ð´Ð¾Ð¼Ð°. Ð­Ñ‚Ð¾ Ð´Ð°ÑÑ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Â±5â€“10% Ð¾Ñ‚ Ð²Ð°ÑˆÐµÐ¹ ÑÑ‚Ð°Ñ€Ñ‚Ð¾Ð²Ð¾Ð¹ Ñ†ÐµÐ½Ñ‹.</p><p>ÐžÑˆÐ¸Ð±ÐºÐ° â„–1 ÑÐ¾Ð±ÑÑ‚Ð²ÐµÐ½Ð½Ð¸ÐºÐ¾Ð² â€” ÑÑ‚Ð°Ð²Ð¸Ñ‚ÑŒ Ñ†ÐµÐ½Ñƒ Â«ÐºÐ°Ðº Ñƒ ÑÐ¾ÑÐµÐ´Ð°Â». Ð¦ÐµÐ½Ð° ÑÐ¾ÑÐµÐ´Ð° Ð½Ð° KV.ee â‰  Ñ†ÐµÐ½Ð° Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ð¹ ÑÐ´ÐµÐ»ÐºÐ¸.</p>', 'cta_text' => 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ñ€Ð°ÑÑ‡Ñ‘Ñ‚ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°'],
                        ['heading' => 'Ð¨Ð°Ð³ 2: ÐŸÐ¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÑŒÑ‚Ðµ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ðº Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ðµ', 'snippet' => 'Decluttering + Ð¼ÐµÐ»ÐºÐ¸Ð¹ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚ Ð¾ÐºÑƒÐ¿Ð°ÑŽÑ‚ÑÑ Ð² 3â€“5 Ñ€Ð°Ð·.', 'body' => '<p>ÐœÐ¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚: ÑƒÐ±ÐµÑ€Ð¸Ñ‚Ðµ Ð»Ð¸Ñ‡Ð½Ñ‹Ðµ Ð²ÐµÑ‰Ð¸, Ð¿Ñ€Ð¾Ð²ÐµÐ´Ð¸Ñ‚Ðµ Ð³ÐµÐ½ÐµÑ€Ð°Ð»ÑŒÐ½ÑƒÑŽ ÑƒÐ±Ð¾Ñ€ÐºÑƒ, ÑƒÑÑ‚Ñ€Ð°Ð½Ð¸Ñ‚Ðµ Ð¼ÐµÐ»ÐºÐ¸Ðµ Ð´ÐµÑ„ÐµÐºÑ‚Ñ‹ (Ð¿Ð¾Ð´Ñ‚ÐµÐºÐ°ÑŽÑ‰Ð¸Ð¹ ÐºÑ€Ð°Ð½, ÑÐºÐ¾Ð»Ñ‹ Ð½Ð° ÑÑ‚ÐµÐ½Ð°Ñ…). Ð¡Ñ‚Ð¾Ð¸Ð¼Ð¾ÑÑ‚ÑŒ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ¸ 200â€“500 â‚¬ â†’ Ð²Ð¾Ð·Ð²Ñ€Ð°Ñ‚ 1 000â€“3 000 â‚¬ Ð² Ñ†ÐµÐ½Ðµ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸.</p>'],
                        ['heading' => 'Ð¨Ð°Ð³ 3: Ð—Ð°ÐºÐ°Ð¶Ð¸Ñ‚Ðµ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾', 'snippet' => 'ÐžÐ±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ñ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¼Ð¸ Ñ„Ð¾Ñ‚Ð¾ Ð¿Ð¾Ð»ÑƒÑ‡Ð°ÑŽÑ‚ Ð½Ð° 40â€“60% Ð±Ð¾Ð»ÑŒÑˆÐµ Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð² Ð½Ð° KV.ee.', 'body' => '<p>Ð¤Ð¾Ñ‚Ð¾ â€” Ð¿ÐµÑ€Ð²Ð¾Ðµ, Ñ‡Ñ‚Ð¾ Ð²Ð¸Ð´Ð¸Ñ‚ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑŒ. 5â€“10 ÐºÐ°Ñ‡ÐµÑÑ‚Ð²ÐµÐ½Ð½Ñ‹Ñ… ÑÐ½Ð¸Ð¼ÐºÐ¾Ð² Ñ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ñ‹Ð¼Ð¸ Ñ€Ð°ÐºÑƒÑ€ÑÐ°Ð¼Ð¸ Ð¸ Ð¾ÑÐ²ÐµÑ‰ÐµÐ½Ð¸ÐµÐ¼ ÑƒÐ²ÐµÐ»Ð¸Ñ‡Ð¸Ð²Ð°ÑŽÑ‚ CTR Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° 40â€“60%. Ð¡Ñ‚Ð¾Ð¸Ð¼Ð¾ÑÑ‚ÑŒ ÑÑŠÑ‘Ð¼ÐºÐ¸: 100â€“200 â‚¬.</p>'],
                        ['heading' => 'Ð¨Ð°Ð³ 4: ÐŸÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð½Ð° KV.ee â€” Ñ‚Ð°Ð¹Ð¼Ð»Ð¸Ð½Ð³ Ð¸ Ñ‚ÐµÐºÑÑ‚', 'snippet' => 'ÐŸÐµÑ€Ð²Ñ‹Ðµ 14 Ð´Ð½ÐµÐ¹ Ð½Ð° KV.ee Ð´Ð°ÑŽÑ‚ 60% Ð²ÑÐµÑ… Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð². Ð’Ð°ÑˆÐµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð´Ð¾Ð»Ð¶Ð½Ð¾ Ð±Ñ‹Ñ‚ÑŒ Ð¸Ð´ÐµÐ°Ð»ÑŒÐ½Ñ‹Ð¼ Ñ Ð¿ÐµÑ€Ð²Ð¾Ð³Ð¾ Ð´Ð½Ñ.', 'body' => '<p>Ð›ÑƒÑ‡ÑˆÐµÐµ Ð²Ñ€ÐµÐ¼Ñ Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ð¸: Ð²Ñ‚Ð¾Ñ€Ð½Ð¸Ðºâ€“Ñ‡ÐµÑ‚Ð²ÐµÑ€Ð³, ÑƒÑ‚Ñ€Ð¾. Ð—Ð°Ð³Ð¾Ð»Ð¾Ð²Ð¾Ðº Ð´Ð¾Ð»Ð¶ÐµÐ½ ÑÐ¾Ð´ÐµÑ€Ð¶Ð°Ñ‚ÑŒ Ñ€Ð°Ð¹Ð¾Ð½ + Ñ‚Ð¸Ð¿ + ÐºÐ»ÑŽÑ‡ÐµÐ²Ð¾Ðµ Ð¿Ñ€ÐµÐ¸Ð¼ÑƒÑ‰ÐµÑÑ‚Ð²Ð¾. ÐžÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ â€” Ñ„Ð°ÐºÑ‚Ñ‹, Ð·Ð°Ð¼ÐµÑ€Ñ‹, Ð¸Ð½Ñ„Ñ€Ð°ÑÑ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð° Ð² Ñ€Ð°Ð´Ð¸ÑƒÑÐµ 500Ð¼.</p>'],
                        ['heading' => 'Ð¨Ð°Ð³ 5: Ð¡Ñ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð²', 'snippet' => 'ÐŸÑ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð°Ñ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð² ÑÐºÐ¾Ð½Ð¾Ð¼Ð¸Ñ‚ ÑÐ¾Ð±ÑÑ‚Ð²ÐµÐ½Ð½Ð¸ÐºÑƒ 3â€“8% Ð¾Ñ‚ Ñ†ÐµÐ½Ñ‹ ÑÐ´ÐµÐ»ÐºÐ¸.', 'body' => '<p>ÐÐµ ÑÐ¾Ð³Ð»Ð°ÑˆÐ°Ð¹Ñ‚ÐµÑÑŒ Ð½Ð° Ð¿ÐµÑ€Ð²Ð¾Ðµ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ðµ. Ð˜ÑÐ¿Ð¾Ð»ÑŒÐ·ÑƒÐ¹Ñ‚Ðµ Â«Ð¼ÐµÑ‚Ð¾Ð´ Ð´Ð²ÑƒÑ… Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹Â»: ÑÐ¾Ð·Ð´Ð°Ð¹Ñ‚Ðµ Ð¾Ñ‰ÑƒÑ‰ÐµÐ½Ð¸Ðµ ÐºÐ¾Ð½ÐºÑƒÑ€ÐµÐ½Ñ†Ð¸Ð¸. Ð’ÑÐµÐ³Ð´Ð° Ð¸Ð¼ÐµÐ¹Ñ‚Ðµ Ð¼Ð¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½ÑƒÑŽ Ñ†ÐµÐ½Ñƒ, Ð½Ð¸Ð¶Ðµ ÐºÐ¾Ñ‚Ð¾Ñ€Ð¾Ð¹ Ð½Ðµ Ð¾Ð¿ÑƒÑÐºÐ°ÐµÑ‚ÐµÑÑŒ, Ð¸ Ð°Ñ€Ð³ÑƒÐ¼ÐµÐ½Ñ‚Ñ‹ Ð½Ð° Ð¾ÑÐ½Ð¾Ð²Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ… Maa-amet.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet â€” Kinnisvara tehingute statistika', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/', 'note' => 'ÐžÑ„Ð¸Ñ†Ð¸Ð°Ð»ÑŒÐ½Ð°Ñ ÑÑ‚Ð°Ñ‚Ð¸ÑÑ‚Ð¸ÐºÐ° ÑÐ´ÐµÐ»Ð¾Ðº'],
                        ['title' => 'KV.ee â€” ÐšÑ€ÑƒÐ¿Ð½ÐµÐ¹ÑˆÐ¸Ð¹ Ð¿Ð¾Ñ€Ñ‚Ð°Ð» Ð½ÐµÐ´Ð²Ð¸Ð¶Ð¸Ð¼Ð¾ÑÑ‚Ð¸ Ð­ÑÑ‚Ð¾Ð½Ð¸Ð¸', 'url' => 'https://www.kv.ee/', 'note' => 'ÐÐºÑ‚ÑƒÐ°Ð»ÑŒÐ½Ñ‹Ðµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ'],
                    ],
                    'cta' => ['heading' => 'Ð“Ð¾Ñ‚Ð¾Ð²Ñ‹ Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ Ñ Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ð²Ñ‹Ð³Ð¾Ð´Ð¾Ð¹?', 'text' => 'ÐŸÐ¾Ð»ÑƒÑ‡Ð¸Ñ‚Ðµ Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ñ€Ð°ÑÑ‡Ñ‘Ñ‚ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð¸ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÑŽ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ Ð·Ð° 24 Ñ‡Ð°ÑÐ°.', 'button' => 'Ð‘ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð°Ñ ÐºÐ¾Ð½ÑÑƒÐ»ÑŒÑ‚Ð°Ñ†Ð¸Ñ'],
                ]),
            ]),
            array_merge($base, [
                'locale'           => 'et',
                'title'            => 'Kuidas mÃ¼Ã¼a korter Tallinnas ja mitte kaotada 5â€“15 000 â‚¬',
                'excerpt'          => 'Samm-sammuline juhend: ettevalmistusest tehinguni. Tegelikud numbrid, tÃµestatud strateegia, 300+ tehingut.',
                'meta_title'       => 'Kuidas mÃ¼Ã¼a korter Tallinnas kaotamata | CityEE',
                'meta_description' => 'Korteri mÃ¼Ã¼gi juhend Tallinnas: hinnakoridor, ettevalmistus, fotod, nÃ¤itamised. 10+ aastat, 300+ tehingut.',
                'og_title'         => 'MÃ¼Ã¼ korter Tallinnas kaotamata â€” CityEE juhend',
                'og_description'   => 'TÃ¤ielik juhend: kuidas mitte kaotada 5â€“15kâ‚¬ korteri mÃ¼Ã¼gil Tallinnas.',
                'ai_summary'       => 'Keskmine kaotus iseseisvalt mÃ¼Ã¼es Tallinnas â€” 5â€“15 000 â‚¬. PÃµhjused: vale hind, halb kuulutus, nÃµrgad lÃ¤birÃ¤Ã¤kimised. Juhend avab strateegia, mis 10+ aasta ja 300+ tehingu jooksul on tÃµestanud: Ãµige ettevalmistus ja hinnastamine = maksimaalne mÃ¼Ã¼gihind.',
                'key_takeaways'    => ([
                    'Ã•ige hinnakoridor = +5â€“10% lÃµpphinnale',
                    'Professionaalsed fotod suurendavad vaatamisi 40â€“60%',
                    'Korteri ettevalmistus tasub end 3â€“5 korda',
                    'Esimesed 14 pÃ¤eva KV.ee-s on kÃµige olulisemad',
                    'LÃ¤birÃ¤Ã¤kimisstrateegia sÃ¤Ã¤stab omanikule 3â€“8% hinnast',
                ]),
                'location_tags'    => (['Tallinn', 'Harjumaa', 'Kesklinn', 'LasnamÃ¤e', 'MustamÃ¤e', 'Ã•ismÃ¤e']),
                'faq_json'         => ($this->guide1FaqEt()),
                'content_blocks'   => ([
                    'quick_answer' => 'Et mitte kaotada 5â€“15 000 â‚¬ korteri mÃ¼Ã¼gil Tallinnas: mÃ¤Ã¤rake tÃ¤pne hinnakoridor Maa-ameti andmete pÃµhjal, valmistage korter ette, tellige professionaalsed fotod, avaldage KV.ee-s Ãµigel ajal ja pidage lÃ¤birÃ¤Ã¤kimisi tugevalt positsioonilt.',
                    'intro' => '<p>Maa-ameti 2024. aasta andmetel on Tallinna keskmine ruutmeetri hind 2 800â€“3 200 â‚¬. HÃ¤sti ettevalmistatud ja halvasti ettevalmistatud kuulutuse vahe vÃµib 2-toalise korteri puhul olla 5â€“15 000 â‚¬.</p>',
                    'sections' => [
                        ['heading' => '1. samm: MÃ¤Ã¤rake tegelik hinnakoridor', 'snippet' => 'Hinnakoridor on vahemik minimaalse ja maksimaalse realistliku hinna vahel, pÃµhinedes Maa-ameti tehingutel viimase 6 kuu jooksul.', 'body' => '<p>Kontrollige tegelikke tehinguid Maa-ametis viimase 6 kuu jooksul teie piirkonnas.</p>'],
                        ['heading' => '2. samm: Valmistage korter mÃ¼Ã¼giks ette', 'snippet' => 'Decluttering + vÃ¤ikeremont tasub end 3â€“5 korda.', 'body' => '<p>Minimaalne kontrollnimekiri: eemaldage isiklikud asjad, tehke pÃµhjalik koristus, kÃµrvaldage vÃ¤iksed defektid.</p>'],
                        ['heading' => '3. samm: Tellige professionaalsed fotod', 'snippet' => 'Professionaalsete fotodega kuulutused saavad KV.ee-s 40â€“60% rohkem vaatamisi.', 'body' => '<p>Fotod on esimene asi, mida ostja nÃ¤eb. 5â€“10 kvaliteetset pilti Ãµigete nurkade ja valgusega.</p>'],
                        ['heading' => '4. samm: Avaldamine KV.ee-s', 'snippet' => 'Esimesed 14 pÃ¤eva KV.ee-s annavad 60% kÃµigist vaatamistest.', 'body' => '<p>Parim avaldamisaeg: teisipÃ¤evâ€“neljapÃ¤ev, hommikul.</p>'],
                        ['heading' => '5. samm: LÃ¤birÃ¤Ã¤kimisstrateegia', 'snippet' => 'Ã•ige lÃ¤birÃ¤Ã¤kimisstrateegia sÃ¤Ã¤stab omanikule 3â€“8% tehingu hinnast.', 'body' => '<p>Ã„rge nÃµustuge esimese pakkumisega. Kasutage kahe ostja meetodit.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet â€” Kinnisvara tehingute statistika', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/'],
                        ['title' => 'KV.ee', 'url' => 'https://www.kv.ee/'],
                    ],
                    'cta' => ['heading' => 'Valmis mÃ¼Ã¼ma maksimaalse kasuga?', 'text' => 'Saage tasuta hinnakoridori arvutus ja mÃ¼Ã¼gistrateegia 24 tunniga.', 'button' => 'Tasuta konsultatsioon'],
                ]),
            ]),
            array_merge($base, [
                'locale'           => 'en',
                'title'            => 'How to Sell an Apartment in Tallinn Without Losing 5â€“15,000 â‚¬',
                'excerpt'          => 'Step-by-step guide: from preparation to closing. Real numbers, proven strategy, 300+ completed deals.',
                'meta_title'       => 'How to Sell an Apartment in Tallinn | CityEE Guide',
                'meta_description' => 'Step-by-step apartment selling guide in Tallinn: price corridor, preparation, photos, showings. 10+ years, 300+ deals.',
                'og_title'         => 'Sell an Apartment in Tallinn Without Losing Money â€” CityEE Guide',
                'og_description'   => 'Complete guide: how not to lose 5â€“15kâ‚¬ when selling an apartment in Tallinn.',
                'ai_summary'       => 'The average loss when selling independently in Tallinn is 5â€“15,000 â‚¬. Reasons: wrong pricing, poor listing, weak negotiations. This guide reveals a step-by-step strategy proven over 10+ years and 300+ deals: proper preparation and pricing = maximum sale price.',
                'key_takeaways'    => ([
                    'Correct price corridor = +5â€“10% to final price',
                    'Professional photos increase views by 40â€“60%',
                    'Apartment preparation pays back 3â€“5x',
                    'First 14 days on KV.ee are the most important',
                    'Negotiation strategy saves the owner 3â€“8% of the price',
                ]),
                'location_tags'    => (['Tallinn', 'Harjumaa', 'Kesklinn', 'LasnamÃ¤e', 'MustamÃ¤e', 'Ã•ismÃ¤e']),
                'faq_json'         => ($this->guide1FaqEn()),
                'content_blocks'   => ([
                    'quick_answer' => 'To avoid losing 5â€“15,000 â‚¬ selling an apartment in Tallinn: determine the exact price corridor using Maa-amet data, prepare the apartment, order professional photos, publish on KV.ee at the right time, and negotiate from a position of strength.',
                    'intro' => '<p>According to Maa-amet 2024 data, the average price per sqm in Tallinn reached 2,800â€“3,200 â‚¬. The difference between a well-prepared and an "as-is" listing can be 5â€“15,000 â‚¬ for a two-room apartment.</p>',
                    'sections' => [
                        ['heading' => 'Step 1: Determine the Real Price Corridor', 'snippet' => 'A price corridor is the range between minimum and maximum realistic price, based on Maa-amet transactions over the past 6 months.', 'body' => '<p>Check real transactions at Maa-amet for the past 6 months in your area.</p>'],
                        ['heading' => 'Step 2: Prepare the Apartment for Sale', 'snippet' => 'Decluttering + minor repairs pay back 3â€“5 times.', 'body' => '<p>Minimum checklist: remove personal items, deep clean, fix minor defects.</p>'],
                        ['heading' => 'Step 3: Order Professional Photos', 'snippet' => 'Listings with professional photos get 40â€“60% more views on KV.ee.', 'body' => '<p>Photos are the first thing a buyer sees. 5â€“10 quality shots with proper angles and lighting.</p>'],
                        ['heading' => 'Step 4: Publishing on KV.ee â€” Timing & Copy', 'snippet' => 'First 14 days on KV.ee generate 60% of all views.', 'body' => '<p>Best publishing time: Tuesdayâ€“Thursday morning.</p>'],
                        ['heading' => 'Step 5: Negotiation Strategy', 'snippet' => 'The right negotiation strategy saves the owner 3â€“8% of the deal price.', 'body' => '<p>Don\'t agree to the first offer. Use the "two buyers" method.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet â€” Real Estate Transaction Statistics', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/'],
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
            'related_guide_slugs'  => (['sell-apartment-without-losing-money', 'kv-ee-listing-checklist']),
            'related_audit_slugs'  => (['price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Ð ÐµÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€: ÐºÐ°Ðº Ð¾Ð¿Ñ€ÐµÐ´ÐµÐ»Ð¸Ñ‚ÑŒ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½ÑƒÑŽ Ñ†ÐµÐ½Ñƒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ',
                'excerpt' => 'ÐœÐµÑ‚Ð¾Ð´ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð½Ð° Ð¾ÑÐ½Ð¾Ð²Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ… Maa-amet: Ñ‚Ð¾Ñ‡Ð½Ð°Ñ Ð¾Ñ†ÐµÐ½ÐºÐ° Ð·Ð° 15 Ð¼Ð¸Ð½ÑƒÑ‚.',
                'meta_title' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ | CityEE',
                'meta_description' => 'ÐšÐ°Ðº Ð¾Ð¿Ñ€ÐµÐ´ÐµÐ»Ð¸Ñ‚ÑŒ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½ÑƒÑŽ Ñ†ÐµÐ½Ñƒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹: Ð¼ÐµÑ‚Ð¾Ð´ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð¿Ð¾ Ð´Ð°Ð½Ð½Ñ‹Ð¼ Maa-amet. Ð¤Ð¾Ñ€Ð¼ÑƒÐ»Ð° + Ð¿Ñ€Ð¸Ð¼ÐµÑ€Ñ‹.',
                'og_title' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ â€” CityEE',
                'og_description' => 'Ð¢Ð¾Ñ‡Ð½Ð°Ñ Ð¾Ñ†ÐµÐ½ÐºÐ° Ñ†ÐµÐ½Ñ‹ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ â€” Ð¼ÐµÑ‚Ð¾Ð´ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°.',
                'ai_summary' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ â€” Ð´Ð¸Ð°Ð¿Ð°Ð·Ð¾Ð½ Ð¼ÐµÐ¶Ð´Ñƒ Ð¼Ð¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ð¸ Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ð¹ Ñ†ÐµÐ½Ð¾Ð¹ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸, Ñ€Ð°ÑÑÑ‡Ð¸Ñ‚Ð°Ð½Ð½Ñ‹Ð¹ Ð½Ð° Ð¾ÑÐ½Ð¾Ð²Ðµ Ð·Ð°Ð²ÐµÑ€ÑˆÑ‘Ð½Ð½Ñ‹Ñ… ÑÐ´ÐµÐ»Ð¾Ðº Maa-amet Ð·Ð° 6 Ð¼ÐµÑÑÑ†ÐµÐ². ÐœÐµÑ‚Ð¾Ð´ ÑƒÑ‡Ð¸Ñ‚Ñ‹Ð²Ð°ÐµÑ‚ Ñ€Ð°Ð¹Ð¾Ð½, Ð¿Ð»Ð¾Ñ‰Ð°Ð´ÑŒ, ÑÑ‚Ð°Ð¶, ÑÐ¾ÑÑ‚Ð¾ÑÐ½Ð¸Ðµ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚Ð° Ð¸ Ñ‚Ð¸Ð¿ Ð´Ð¾Ð¼Ð°. Ð¢Ð¾Ñ‡Ð½Ñ‹Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð¿Ð¾Ð·Ð²Ð¾Ð»ÑÐµÑ‚ Ð²Ñ‹ÑÑ‚Ð°Ð²Ð¸Ñ‚ÑŒ Ð¾Ð¿Ñ‚Ð¸Ð¼Ð°Ð»ÑŒÐ½ÑƒÑŽ ÑÑ‚Ð°Ñ€Ñ‚Ð¾Ð²ÑƒÑŽ Ñ†ÐµÐ½Ñƒ Ð¸ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ð½Ð° 5â€“10% Ð±Ð¾Ð»ÑŒÑˆÐµ.',
                'key_takeaways' => ([
                    'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ = Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ðµ ÑÐ´ÐµÐ»ÐºÐ¸ Maa-amet Ð·Ð° 6 Ð¼ÐµÑÑÑ†ÐµÐ²',
                    'Ð¦ÐµÐ½Ð° Ð½Ð° KV.ee â‰  Ñ†ÐµÐ½Ð° Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ð¹ ÑÐ´ÐµÐ»ÐºÐ¸ (Ñ€Ð°Ð·Ð½Ð¸Ñ†Ð° 5â€“15%)',
                    'Ð¤Ð¾Ñ€Ð¼ÑƒÐ»Ð°: Ð¼ÐµÐ´Ð¸Ð°Ð½Ð° ÑÐ´ÐµÐ»Ð¾Ðº Â± 10% = Ð²Ð°Ñˆ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€',
                    'Ð¡Ñ‚Ð°Ñ€Ñ‚Ð¾Ð²Ð°Ñ Ñ†ÐµÐ½Ð° = Ð²ÐµÑ€Ñ…Ð½ÑÑ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ð° ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°',
                    'ÐŸÐµÑ€ÐµÑÐ¼Ð¾Ñ‚Ñ€ Ñ†ÐµÐ½Ñ‹ â€” Ñ‡ÐµÑ€ÐµÐ· 14 Ð´Ð½ÐµÐ¹ Ð±ÐµÐ· Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide2FaqRu()),
                'content_blocks' => ([
                    'quick_answer' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ â€” ÑÑ‚Ð¾ Ð´Ð¸Ð°Ð¿Ð°Ð·Ð¾Ð½ Â±10% Ð¾Ñ‚ Ð¼ÐµÐ´Ð¸Ð°Ð½Ñ‹ Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ñ… ÑÐ´ÐµÐ»Ð¾Ðº Maa-amet Ð·Ð° Ð¿Ð¾ÑÐ»ÐµÐ´Ð½Ð¸Ðµ 6 Ð¼ÐµÑÑÑ†ÐµÐ² Ð² Ð²Ð°ÑˆÐµÐ¼ Ñ€Ð°Ð¹Ð¾Ð½Ðµ. Ð¡Ñ‚Ð°Ñ€Ñ‚Ð¾Ð²ÑƒÑŽ Ñ†ÐµÐ½Ñƒ Ð²Ñ‹ÑÑ‚Ð°Ð²Ð»ÑÐ¹Ñ‚Ðµ Ð¿Ð¾ Ð²ÐµÑ€Ñ…Ð½ÐµÐ¹ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ðµ.',
                    'intro' => '<p>80% ÑÐ¾Ð±ÑÑ‚Ð²ÐµÐ½Ð½Ð¸ÐºÐ¾Ð² ÑÑ‚Ð°Ð²ÑÑ‚ Ñ†ÐµÐ½Ñƒ Â«Ð¿Ð¾ Ð¾Ñ‰ÑƒÑ‰ÐµÐ½Ð¸ÑÐ¼Â» Ð¸Ð»Ð¸ Â«ÐºÐ°Ðº Ñƒ ÑÐ¾ÑÐµÐ´Ð° Ð½Ð° KV.eeÂ». Ð ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚: Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð²Ð¸ÑÐ¸Ñ‚ 60+ Ð´Ð½ÐµÐ¹, Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»Ð¸ Ñ‚Ð¾Ñ€Ð³ÑƒÑŽÑ‚ÑÑ Ð¶Ñ‘ÑÑ‚ÐºÐ¾. ÐœÐµÑ‚Ð¾Ð´ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ñ€ÐµÑˆÐ°ÐµÑ‚ ÑÑ‚Ñƒ Ð¿Ñ€Ð¾Ð±Ð»ÐµÐ¼Ñƒ.</p>',
                    'sections' => [
                        ['heading' => 'Ð§Ñ‚Ð¾ Ñ‚Ð°ÐºÐ¾Ðµ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€', 'snippet' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ â€” Ð´Ð¸Ð°Ð¿Ð°Ð·Ð¾Ð½ Ñ†ÐµÐ½, Ð² ÐºÐ¾Ñ‚Ð¾Ñ€Ð¾Ð¼ Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾ Ð¿Ñ€Ð¾Ð´Ð°Ñ‘Ñ‚ÑÑ Ð¾Ð±ÑŠÐµÐºÑ‚ ÑÐ¾Ð¿Ð¾ÑÑ‚Ð°Ð²Ð¸Ð¼Ð¾Ð³Ð¾ ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð° Ð² Ð²Ð°ÑˆÐµÐ¼ Ñ€Ð°Ð¹Ð¾Ð½Ðµ.', 'body' => '<p>ÐšÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ñ€Ð°ÑÑÑ‡Ð¸Ñ‚Ñ‹Ð²Ð°ÐµÑ‚ÑÑ Ð½Ð° Ð¾ÑÐ½Ð¾Ð²Ðµ Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ñ… ÑÐ´ÐµÐ»Ð¾Ðº (Ð½Ðµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ð¹!) Ð·Ð° Ð¿Ð¾ÑÐ»ÐµÐ´Ð½Ð¸Ðµ 6 Ð¼ÐµÑÑÑ†ÐµÐ². Ð˜ÑÑ‚Ð¾Ñ‡Ð½Ð¸Ðº Ð´Ð°Ð½Ð½Ñ‹Ñ…: Ð³Ð¾ÑÑƒÐ´Ð°Ñ€ÑÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ñ€ÐµÐµÑÑ‚Ñ€ Maa-amet.</p>'],
                        ['heading' => 'ÐšÐ°Ðº Ñ€Ð°ÑÑÑ‡Ð¸Ñ‚Ð°Ñ‚ÑŒ: Ð¿Ð¾ÑˆÐ°Ð³Ð¾Ð²Ð°Ñ Ñ„Ð¾Ñ€Ð¼ÑƒÐ»Ð°', 'snippet' => 'Ð¨Ð°Ð³ 1: ÐÐ°Ð¹Ð´Ð¸Ñ‚Ðµ 5â€“10 Ð°Ð½Ð°Ð»Ð¾Ð³Ð¸Ñ‡Ð½Ñ‹Ñ… ÑÐ´ÐµÐ»Ð¾Ðº Ð² Maa-amet. Ð¨Ð°Ð³ 2: Ð Ð°ÑÑÑ‡Ð¸Ñ‚Ð°Ð¹Ñ‚Ðµ Ð¼ÐµÐ´Ð¸Ð°Ð½Ñƒ Ñ†ÐµÐ½Ñ‹ Ð·Ð° Ð¼Â². Ð¨Ð°Ð³ 3: Ð”Ð¸Ð°Ð¿Ð°Ð·Ð¾Ð½ Â±10% = Ð²Ð°Ñˆ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€.', 'body' => '<p>ÐŸÑ€Ð¸Ð¼ÐµÑ€ Ð´Ð»Ñ Kesklinn: 5 ÑÐ´ÐµÐ»Ð¾Ðº Ð¿Ð¾ 3 100â€“3 500 â‚¬/Ð¼Â² â†’ Ð¼ÐµÐ´Ð¸Ð°Ð½Ð° 3 300 â‚¬/Ð¼Â² â†’ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ 2 970â€“3 630 â‚¬/Ð¼Â². Ð”Ð»Ñ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ 50 Ð¼Â²: 148 500â€“181 500 â‚¬.</p>'],
                        ['heading' => 'ÐžÑˆÐ¸Ð±ÐºÐ¸ Ð¿Ñ€Ð¸ Ñ†ÐµÐ½Ð¾Ð¾Ð±Ñ€Ð°Ð·Ð¾Ð²Ð°Ð½Ð¸Ð¸', 'snippet' => 'Ð“Ð»Ð°Ð²Ð½Ð°Ñ Ð¾ÑˆÐ¸Ð±ÐºÐ°: ÑÑ‚Ð°Ð²Ð¸Ñ‚ÑŒ Ñ†ÐµÐ½Ñƒ Ð¿Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸ÑÐ¼ Ð½Ð° KV.ee. Ð¦ÐµÐ½Ð° Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° 5â€“15% Ð²Ñ‹ÑˆÐµ Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ð¹ Ñ†ÐµÐ½Ñ‹ ÑÐ´ÐµÐ»ÐºÐ¸.', 'body' => '<p>ÐŸÐ¾Ñ€Ñ‚Ð°Ð»ÑŒÐ½Ð°Ñ Ñ†ÐµÐ½Ð° â€” ÑÑ‚Ð¾ Â«wish priceÂ» Ð¿Ñ€Ð¾Ð´Ð°Ð²Ñ†Ð°. Ð ÐµÐ°Ð»ÑŒÐ½Ð°Ñ Ñ†ÐµÐ½Ð° ÑÐ´ÐµÐ»ÐºÐ¸ Ð²ÑÐµÐ³Ð´Ð° Ð½Ð¸Ð¶Ðµ. Ð˜ÑÐ¿Ð¾Ð»ÑŒÐ·ÑƒÐ¹Ñ‚Ðµ Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð´Ð°Ð½Ð½Ñ‹Ðµ Maa-amet.</p>'],
                    ],
                    'sources' => [
                        ['title' => 'Maa-amet â€” Kinnisvara tehingud', 'url' => 'https://www.maaamet.ee/kinnisvara/hinnast/'],
                    ],
                    'cta' => ['heading' => 'Ð¥Ð¾Ñ‚Ð¸Ñ‚Ðµ ÑƒÐ·Ð½Ð°Ñ‚ÑŒ Ñ‚Ð¾Ñ‡Ð½Ñ‹Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð´Ð»Ñ Ð²Ð°ÑˆÐµÐ¹ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹?', 'text' => 'Ð‘ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ñ€Ð°ÑÑ‡Ñ‘Ñ‚ Ð½Ð° Ð¾ÑÐ½Ð¾Ð²Ðµ Ð´Ð°Ð½Ð½Ñ‹Ñ… Maa-amet Ð·Ð° 2 Ñ‡Ð°ÑÐ°.', 'button' => 'ÐŸÐ¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ñ€Ð°ÑÑ‡Ñ‘Ñ‚'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Tegelik hinnakoridor: kuidas mÃ¤Ã¤rata Ãµige korterihind Tallinnas',
                'excerpt' => 'Hinnakoridori meetod Maa-ameti andmete pÃµhjal: tÃ¤pne hinnang 15 minutiga.',
                'meta_title' => 'Korteri hinnakoridor Tallinnas | CityEE',
                'meta_description' => 'Kuidas mÃ¤Ã¤rata korteri Ãµige hind: hinnakoridori meetod Maa-ameti andmete pÃµhjal. Valem + nÃ¤ited.',
                'og_title' => 'Korteri hinnakoridor â€” CityEE',
                'og_description' => 'TÃ¤pne korterihinna hinnang Tallinnas â€” hinnakoridori meetod.',
                'ai_summary' => 'Hinnakoridor on vahemik minimaalse ja maksimaalse reaalse mÃ¼Ã¼gihinna vahel, arvutatuna Maa-ameti tehingute pÃµhjal 6 kuu jooksul. Meetod arvestab piirkonda, pindala, korrust, remondi seisukorda ja maja tÃ¼Ã¼pi.',
                'key_takeaways' => ([
                    'Hinnakoridor = Maa-ameti tegelikud tehingud 6 kuu jooksul',
                    'KV.ee hind â‰  tegeliku tehingu hind (vahe 5â€“15%)',
                    'Valem: tehingute mediaan Â± 10% = teie koridor',
                    'Stardihind = koridori Ã¼lemine piir',
                    'Hinna Ã¼levaatus â€” 14 pÃ¤eva pÃ¤rast ilma pakkumisteta',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide2FaqEt()),
                'content_blocks' => ([
                    'quick_answer' => 'Hinnakoridor on Â±10% tehingute mediaanist Maa-ametis viimase 6 kuu jooksul teie piirkonnas. Stardihinna panege koridori Ã¼lemisele piirile.',
                    'intro' => '<p>80% omanikest paneb hinna "tunde jÃ¤rgi". Hinnakoridori meetod lahendab selle probleemi.</p>',
                    'sections' => [
                        ['heading' => 'Mis on hinnakoridor', 'body' => '<p>Koridor arvutatakse tegelike tehingute pÃµhjal (mitte kuulutused!) viimase 6 kuu jooksul.</p>'],
                        ['heading' => 'Kuidas arvutada: samm-sammuline valem', 'body' => '<p>NÃ¤ide Kesklinna jaoks: 5 tehingut 3 100â€“3 500 â‚¬/mÂ² â†’ mediaan 3 300 â‚¬/mÂ² â†’ koridor 2 970â€“3 630 â‚¬/mÂ².</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite teada oma korteri tÃ¤pset koridori?', 'text' => 'Tasuta arvutus Maa-ameti andmete pÃµhjal 2 tunniga.', 'button' => 'Saa arvutus'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Real Price Corridor: How to Determine the Right Apartment Price in Tallinn',
                'excerpt' => 'Price corridor method based on Maa-amet data: accurate estimate in 15 minutes.',
                'meta_title' => 'Apartment Price Corridor in Tallinn | CityEE',
                'meta_description' => 'How to determine the right apartment price: price corridor method using Maa-amet data. Formula + examples.',
                'og_title' => 'Apartment Price Corridor â€” CityEE',
                'og_description' => 'Accurate apartment price estimate in Tallinn â€” the price corridor method.',
                'ai_summary' => 'A price corridor is the range between the minimum and maximum realistic sale price, calculated from Maa-amet completed transactions over 6 months. The method accounts for district, area, floor, renovation condition, and building type.',
                'key_takeaways' => ([
                    'Price corridor = real Maa-amet transactions over 6 months',
                    'KV.ee price â‰  actual deal price (5â€“15% difference)',
                    'Formula: median of deals Â± 10% = your corridor',
                    'Starting price = upper boundary of the corridor',
                    'Price review â€” after 14 days without offers',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide2FaqEn()),
                'content_blocks' => ([
                    'quick_answer' => 'A price corridor is Â±10% from the median of real Maa-amet transactions over the past 6 months in your area. Set the starting price at the upper boundary.',
                    'intro' => '<p>80% of owners set prices "by feeling." The price corridor method solves this problem using data-driven approach.</p>',
                    'sections' => [
                        ['heading' => 'What Is a Price Corridor', 'body' => '<p>Calculated from real transactions (not listings!) over the past 6 months. Data source: Maa-amet state registry.</p>'],
                        ['heading' => 'How to Calculate: Step-by-Step', 'body' => '<p>Example for Kesklinn: 5 deals at 3,100â€“3,500 â‚¬/sqm â†’ median 3,300 â‚¬/sqm â†’ corridor 2,970â€“3,630 â‚¬/sqm.</p>'],
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
            'related_guide_slugs'  => (['sell-apartment-without-losing-money', 'real-price-corridor']),
            'related_audit_slugs'  => (['kv-ee-listing-audit']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Ð§ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¸Ð´ÐµÐ°Ð»ÑŒÐ½Ð¾Ð³Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee: 27 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð²',
                'excerpt' => 'ÐŸÐ¾Ð»Ð½Ñ‹Ð¹ Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚ Ð´Ð»Ñ Ð¿Ñ€Ð¾Ð´Ð°ÑŽÑ‰ÐµÐ³Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee. ÐšÐ°Ð¶Ð´Ñ‹Ð¹ Ð¿ÑƒÐ½ÐºÑ‚ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐµÐ½ Ð½Ð° 300+ ÑÐ´ÐµÐ»ÐºÐ°Ñ….',
                'meta_title' => 'Ð§ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee â€” 27 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð² | CityEE',
                'meta_description' => 'Ð˜Ð´ÐµÐ°Ð»ÑŒÐ½Ð¾Ðµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð½Ð° KV.ee: Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¸Ð· 27 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð². Ð¤Ð¾Ñ‚Ð¾, Ñ‚ÐµÐºÑÑ‚, Ñ†ÐµÐ½Ð°, Ñ‚Ð°Ð¹Ð¼Ð¸Ð½Ð³ â€” Ð²ÑÑ‘ Ð´Ð»Ñ Ð¼Ð°ÐºÑÐ¸Ð¼ÑƒÐ¼Ð° Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð².',
                'ai_summary' => 'ÐžÐ±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð½Ð° KV.ee â€” Ð³Ð»Ð°Ð²Ð½Ñ‹Ð¹ Ð¸Ð½ÑÑ‚Ñ€ÑƒÐ¼ÐµÐ½Ñ‚ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸. ÐžÑ‚ ÐµÐ³Ð¾ ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð° Ð·Ð°Ð²Ð¸ÑÐ¸Ñ‚ 60â€“80% Ñ€ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚Ð°. Ð§ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¸Ð· 27 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð² Ð¿Ð¾ÐºÑ€Ñ‹Ð²Ð°ÐµÑ‚: Ð·Ð°Ð³Ð¾Ð»Ð¾Ð²Ð¾Ðº, Ñ‚ÐµÐºÑÑ‚, Ñ„Ð¾Ñ‚Ð¾, Ñ†ÐµÐ½Ñƒ, Ñ‚Ð°Ð¹Ð¼Ð¸Ð½Ð³ Ð¸ Ð´Ð¾Ð¿Ð¾Ð»Ð½Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ðµ Ð¾Ð¿Ñ†Ð¸Ð¸. ÐšÐ°Ð¶Ð´Ñ‹Ð¹ Ð¿ÑƒÐ½ÐºÑ‚ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐµÐ½ Ð½Ð° 300+ Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ñ… ÑÐ´ÐµÐ»ÐºÐ°Ñ… Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ.',
                'key_takeaways' => ([
                    'Ð—Ð°Ð³Ð¾Ð»Ð¾Ð²Ð¾Ðº: Ñ€Ð°Ð¹Ð¾Ð½ + Ñ‚Ð¸Ð¿ + ÐºÐ»ÑŽÑ‡ÐµÐ²Ð¾Ðµ Ð¿Ñ€ÐµÐ¸Ð¼ÑƒÑ‰ÐµÑÑ‚Ð²Ð¾',
                    'Ð¤Ð¾Ñ‚Ð¾: Ð¼Ð¸Ð½Ð¸Ð¼ÑƒÐ¼ 10, Ð¿ÐµÑ€Ð²Ð¾Ðµ â€” Ð»ÑƒÑ‡ÑˆÐ°Ñ ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð° Ñ Ð¾ÐºÐ½Ð¾Ð¼',
                    'Ð¢ÐµÐºÑÑ‚: Ñ„Ð°ÐºÑ‚Ñ‹ > ÑÐ¼Ð¾Ñ†Ð¸Ð¸. ÐŸÐ»Ð¾Ñ‰Ð°Ð´ÑŒ, Ñ€ÐµÐ¼Ð¾Ð½Ñ‚, Ð¸Ð½Ñ„Ñ€Ð°ÑÑ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð°',
                    'ÐŸÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ: Ð²Ñ‚â€“Ñ‡Ñ‚ ÑƒÑ‚Ñ€Ð¾Ð¼, Ð¿Ñ€ÐµÐ¼Ð¸ÑƒÐ¼-Ð¿Ð°ÐºÐµÑ‚ Ð½Ð° ÑÑ‚Ð°Ñ€Ñ‚Ðµ',
                    'ÐžÐ±Ð½Ð¾Ð²Ð»ÐµÐ½Ð¸Ðµ: Ñ€Ð°Ð· Ð² 7 Ð´Ð½ÐµÐ¹ Ð´Ð»Ñ Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶Ð°Ð½Ð¸Ñ Ð¿Ð¾Ð·Ð¸Ñ†Ð¸Ð¸',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide3FaqRu()),
                'content_blocks' => ([
                    'quick_answer' => 'Ð˜Ð´ÐµÐ°Ð»ÑŒÐ½Ð¾Ðµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð½Ð° KV.ee: Ð¿Ñ€Ð¸Ð²Ð»ÐµÐºÐ°ÑŽÑ‰Ð¸Ð¹ Ð·Ð°Ð³Ð¾Ð»Ð¾Ð²Ð¾Ðº Ñ Ñ€Ð°Ð¹Ð¾Ð½Ð¾Ð¼, 10+ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ñ… Ñ„Ð¾Ñ‚Ð¾, Ñ„Ð°ÐºÑ‚Ð¾Ð»Ð¾Ð³Ð¸Ñ‡ÐµÑÐºÐ¾Ðµ Ð¾Ð¿Ð¸ÑÐ°Ð½Ð¸Ðµ Ð½Ð° 2 ÑÐ·Ñ‹ÐºÐ°Ñ…, Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð°Ñ Ñ†ÐµÐ½Ð° Ð½Ð° Ð²ÐµÑ€Ñ…Ð½ÐµÐ¹ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ðµ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°, Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð²Ñ‚â€“Ñ‡Ñ‚ ÑƒÑ‚Ñ€Ð¾Ð¼.',
                    'intro' => '<p>Ð¡Ñ€ÐµÐ´Ð½ÐµÐµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð½Ð° KV.ee Ð½Ð°Ð±Ð¸Ñ€Ð°ÐµÑ‚ 200â€“400 Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð². ÐžÐ±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð¿Ð¾ Ð½Ð°ÑˆÐµÐ¼Ñƒ Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚Ñƒ â€” 800â€“1500. Ð Ð°Ð·Ð½Ð¸Ñ†Ð° = Ð±Ð¾Ð»ÑŒÑˆÐµ Ð·Ð²Ð¾Ð½ÐºÐ¾Ð² = Ð±Ð¾Ð»ÑŒÑˆÐµ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹ = Ð²Ñ‹ÑˆÐµ Ñ†ÐµÐ½Ð°.</p>',
                    'sections' => [
                        ['heading' => 'Ð‘Ð»Ð¾Ðº 1: Ð—Ð°Ð³Ð¾Ð»Ð¾Ð²Ð¾Ðº (5 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð²)', 'body' => '<p><strong>1.</strong> Ð Ð°Ð¹Ð¾Ð½ Ð² Ð½Ð°Ñ‡Ð°Ð»Ðµ Ð·Ð°Ð³Ð¾Ð»Ð¾Ð²ÐºÐ°<br><strong>2.</strong> Ð¢Ð¸Ð¿ Ð¾Ð±ÑŠÐµÐºÑ‚Ð°<br><strong>3.</strong> ÐšÐ»ÑŽÑ‡ÐµÐ²Ð¾Ðµ Ð¿Ñ€ÐµÐ¸Ð¼ÑƒÑ‰ÐµÑÑ‚Ð²Ð¾ (Ð²Ð¸Ð´, Ñ€ÐµÐ¼Ð¾Ð½Ñ‚, Ð¿Ð°Ñ€ÐºÐ¾Ð²ÐºÐ°)<br><strong>4.</strong> ÐŸÐ»Ð¾Ñ‰Ð°Ð´ÑŒ<br><strong>5.</strong> Ð‘ÐµÐ· CAPS LOCK Ð¸ Ð²Ð¾ÑÐºÐ»Ð¸Ñ†Ð°Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ñ… Ð·Ð½Ð°ÐºÐ¾Ð²</p>'],
                        ['heading' => 'Ð‘Ð»Ð¾Ðº 2: Ð¤Ð¾Ñ‚Ð¾ (7 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð²)', 'body' => '<p><strong>6.</strong> ÐœÐ¸Ð½Ð¸Ð¼ÑƒÐ¼ 10 Ñ„Ð¾Ñ‚Ð¾<br><strong>7.</strong> ÐŸÐµÑ€Ð²Ð¾Ðµ Ñ„Ð¾Ñ‚Ð¾ â€” Ð»ÑƒÑ‡ÑˆÐ°Ñ ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð° Ñ Ð¾ÐºÐ½Ð¾Ð¼<br><strong>8.</strong> ÐŸÑ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ„Ð¾Ñ‚Ð¾Ð³Ñ€Ð°Ñ„<br><strong>9.</strong> Ð¨Ð¸Ñ€Ð¾ÐºÐ¸Ð¹ ÑƒÐ³Ð¾Ð», ÐµÑÑ‚ÐµÑÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ ÑÐ²ÐµÑ‚<br><strong>10.</strong> Ð¤Ð°ÑÐ°Ð´ Ð´Ð¾Ð¼Ð° + Ð²Ñ…Ð¾Ð´<br><strong>11.</strong> Ð’Ð¸Ð´ Ð¸Ð· Ð¾ÐºÐ½Ð°<br><strong>12.</strong> ÐŸÐ»Ð°Ð½ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹</p>'],
                        ['heading' => 'Ð‘Ð»Ð¾Ðº 3: ÐžÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ (8 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð²)', 'body' => '<p><strong>13.</strong> ÐŸÐ»Ð¾Ñ‰Ð°Ð´ÑŒ Ð¸ ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ñ‹<br><strong>14.</strong> Ð“Ð¾Ð´ Ð¿Ð¾ÑÑ‚Ñ€Ð¾Ð¹ÐºÐ¸ Ð¸ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚Ð°<br><strong>15.</strong> Ð¢Ð¸Ð¿ Ð¾Ñ‚Ð¾Ð¿Ð»ÐµÐ½Ð¸Ñ Ð¸ ÐºÐ¾Ð¼Ð¼ÑƒÐ½Ð°Ð»ÑŒÐ½Ñ‹Ðµ<br><strong>16.</strong> Ð­Ñ‚Ð°Ð¶ / Ð»Ð¸Ñ„Ñ‚<br><strong>17.</strong> ÐŸÐ°Ñ€ÐºÐ¾Ð²ÐºÐ° / Ñ…Ñ€Ð°Ð½ÐµÐ½Ð¸Ðµ<br><strong>18.</strong> Ð˜Ð½Ñ„Ñ€Ð°ÑÑ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð° (ÑˆÐºÐ¾Ð»Ñ‹, Ð¼Ð°Ð³Ð°Ð·Ð¸Ð½Ñ‹, Ñ‚Ñ€Ð°Ð½ÑÐ¿Ð¾Ñ€Ñ‚)<br><strong>19.</strong> ÐžÐ¿Ð¸ÑÐ°Ð½Ð¸Ðµ Ð½Ð° 2 ÑÐ·Ñ‹ÐºÐ°Ñ… (ÑÑÑ‚ + Ñ€ÑƒÑ)<br><strong>20.</strong> Ð‘ÐµÐ· Ð¾Ñ€Ñ„Ð¾Ð³Ñ€Ð°Ñ„Ð¸Ñ‡ÐµÑÐºÐ¸Ñ… Ð¾ÑˆÐ¸Ð±Ð¾Ðº</p>'],
                        ['heading' => 'Ð‘Ð»Ð¾Ðº 4: Ð¦ÐµÐ½Ð° Ð¸ Ñ‚Ð°Ð¹Ð¼Ð¸Ð½Ð³ (7 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð²)', 'body' => '<p><strong>21.</strong> Ð¦ÐµÐ½Ð° Ð¿Ð¾ Ð²ÐµÑ€Ñ…Ð½ÐµÐ¹ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ðµ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°<br><strong>22.</strong> ÐŸÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð²Ñ‚â€“Ñ‡Ñ‚ ÑƒÑ‚Ñ€Ð¾Ð¼<br><strong>23.</strong> ÐŸÑ€ÐµÐ¼Ð¸ÑƒÐ¼-Ð¿Ð°ÐºÐµÑ‚ Ð½Ð° Ð¿ÐµÑ€Ð²Ñ‹Ðµ 14 Ð´Ð½ÐµÐ¹<br><strong>24.</strong> ÐžÐ±Ð½Ð¾Ð²Ð»ÐµÐ½Ð¸Ðµ Ñ€Ð°Ð· Ð² 7 Ð´Ð½ÐµÐ¹<br><strong>25.</strong> ÐšÐ¾Ð½Ñ‚Ð°ÐºÑ‚Ð½Ñ‹Ð¹ Ñ‚ÐµÐ»ÐµÑ„Ð¾Ð½ Ð´Ð¾ÑÑ‚ÑƒÐ¿ÐµÐ½<br><strong>26.</strong> Ð‘Ñ‹ÑÑ‚Ñ€Ñ‹Ð¹ Ð¾Ñ‚Ð²ÐµÑ‚ Ð½Ð° Ð·Ð°Ð¿Ñ€Ð¾ÑÑ‹ (< 1 Ñ‡Ð°ÑÐ°)<br><strong>27.</strong> ÐÐ½Ð°Ð»Ð¸Ð· ÑÑ‚Ð°Ñ‚Ð¸ÑÑ‚Ð¸ÐºÐ¸ Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð² Ñ‡ÐµÑ€ÐµÐ· 7 Ð´Ð½ÐµÐ¹</p>'],
                    ],
                    'cta' => ['heading' => 'Ð¥Ð¾Ñ‚Ð¸Ñ‚Ðµ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÑƒ Ð²Ð°ÑˆÐµÐ³Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ?', 'text' => 'Ð‘ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ð°ÑƒÐ´Ð¸Ñ‚ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee Ð·Ð° 2 Ñ‡Ð°ÑÐ°.', 'button' => 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð°ÑƒÐ´Ð¸Ñ‚'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Ideaalse KV.ee kuulutuse kontrollnimekiri: 27 punkti',
                'excerpt' => 'TÃ¤ielik kontrollnimekiri mÃ¼Ã¼va KV.ee kuulutuse jaoks. Iga punkt testitud 300+ tehingul.',
                'meta_title' => 'KV.ee kuulutuse kontrollnimekiri â€” 27 punkti | CityEE',
                'meta_description' => 'Ideaalne KV.ee kuulutus: 27-punktiline kontrollnimekiri. Fotod, tekst, hind, ajastus.',
                'ai_summary' => 'KV.ee kuulutus on mÃ¼Ã¼gi peamine tÃ¶Ã¶riist. Kvaliteedist sÃµltub 60â€“80% tulemusest. 27-punktiline nimekiri katab: pealkiri, tekst, fotod, hind, ajastus ja lisavalikud.',
                'key_takeaways' => ([
                    'Pealkiri: piirkond + tÃ¼Ã¼p + peamine eelis',
                    'Fotod: vÃ¤hemalt 10, esimene â€” parim tuba aknaga',
                    'Tekst: faktid > emotsioonid',
                    'Avaldamine: T-N hommikul, premium pakett alguses',
                    'Uuendamine: iga 7 pÃ¤eva jÃ¤rel',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide3FaqEt()),
                'content_blocks' => ([
                    'quick_answer' => 'Ideaalne KV.ee kuulutus: mÃµjuv pealkiri piirkonnaga, 10+ professionaalset fotot, faktiline kirjeldus 2 keeles, Ãµige hind koridori Ã¼lemisel piiril, avaldamine T-N hommikul.',
                    'intro' => '<p>Keskmine KV.ee kuulutus kogub 200â€“400 vaatamist. Meie kontrollnimekirja jÃ¤rgi tehtud kuulutus â€” 800â€“1500.</p>',
                    'sections' => [
                        ['heading' => 'Plokk 1: Pealkiri (5 punkti)', 'body' => '<p>Piirkond pealkirja alguses, objekti tÃ¼Ã¼p, peamine eelis, pindala, ilma suurtÃ¤htedeta.</p>'],
                        ['heading' => 'Plokk 2: Fotod (7 punkti)', 'body' => '<p>VÃ¤hemalt 10 fotot, professionaalne fotograaf, lai nurk, plaan.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite oma kuulutuse kontrolli?', 'text' => 'Tasuta KV.ee kuulutuse audit 2 tunniga.', 'button' => 'Telli audit'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Perfect KV.ee Listing Checklist: 27 Points',
                'excerpt' => 'Complete checklist for a selling KV.ee listing. Every point tested on 300+ deals.',
                'meta_title' => 'KV.ee Listing Checklist â€” 27 Points | CityEE',
                'meta_description' => 'Perfect KV.ee listing: 27-point checklist. Photos, copy, pricing, timing â€” everything for maximum views.',
                'ai_summary' => 'Your KV.ee listing is the main selling tool. Its quality determines 60â€“80% of the outcome. This 27-point checklist covers: headline, copy, photos, price, timing, and extra options.',
                'key_takeaways' => ([
                    'Headline: district + type + key advantage',
                    'Photos: minimum 10, first one â€” best room with window',
                    'Copy: facts > emotions. Area, renovation, infrastructure',
                    'Publishing: Tueâ€“Thu morning, premium package at launch',
                    'Refresh: every 7 days to maintain position',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide3FaqEn()),
                'content_blocks' => ([
                    'quick_answer' => 'Perfect KV.ee listing: attention-grabbing headline with district, 10+ professional photos, fact-based description in 2 languages, correct price at the upper boundary of the corridor, published Tueâ€“Thu morning.',
                    'intro' => '<p>Average KV.ee listing gets 200â€“400 views. A listing following our checklist â€” 800â€“1,500.</p>',
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
            'related_guide_slugs'  => (['sell-apartment-without-losing-money', 'kv-ee-listing-checklist']),
            'related_audit_slugs'  => (['kv-ee-listing-audit']),
            'service_link_key' => 'rent',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Ð‘ÐµÐ·Ð¾Ð¿Ð°ÑÐ½Ð°Ñ Ð°Ñ€ÐµÐ½Ð´Ð°: Ð¿Ð¾Ð»Ð½Ñ‹Ð¹ Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÐ¸ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð°',
                'excerpt' => 'ÐšÐ°Ðº ÑÐ´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ Ð¸ Ð½Ðµ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ð¿Ñ€Ð¾Ð±Ð»ÐµÐ¼Ð½Ð¾Ð³Ð¾ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð°. Ð§ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¸Ð· 15 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð².',
                'meta_title' => 'ÐŸÑ€Ð¾Ð²ÐµÑ€ÐºÐ° Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð°: Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚ | CityEE',
                'meta_description' => 'Ð‘ÐµÐ·Ð¾Ð¿Ð°ÑÐ½Ð°Ñ Ð°Ñ€ÐµÐ½Ð´Ð° Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ: Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÐ¸ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð° Ð¸Ð· 15 Ð¿ÑƒÐ½ÐºÑ‚Ð¾Ð². Ð”Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ñ‹, Ð³Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ð¸, Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€.',
                'ai_summary' => 'ÐŸÑ€Ð¾Ð±Ð»ÐµÐ¼Ð½Ñ‹Ð¹ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€ Ð¼Ð¾Ð¶ÐµÑ‚ ÑÑ‚Ð¾Ð¸Ñ‚ÑŒ ÑÐ¾Ð±ÑÑ‚Ð²ÐµÐ½Ð½Ð¸ÐºÑƒ 2 000â€“10 000 â‚¬ (Ð½ÐµÐ¾Ð¿Ð»Ð°Ñ‡ÐµÐ½Ð½Ð°Ñ Ð°Ñ€ÐµÐ½Ð´Ð°, Ð¿Ð¾Ð²Ñ€ÐµÐ¶Ð´ÐµÐ½Ð¸Ñ, ÑÑƒÐ´ÐµÐ±Ð½Ñ‹Ðµ Ñ€Ð°ÑÑ…Ð¾Ð´Ñ‹). ÐŸÐ¾Ð»Ð½Ñ‹Ð¹ Ñ‡ÐµÐº-Ð»Ð¸ÑÑ‚ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÐ¸: Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ñ‹, ÐºÑ€ÐµÐ´Ð¸Ñ‚Ð½Ð°Ñ Ð¸ÑÑ‚Ð¾Ñ€Ð¸Ñ, Ñ€ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ð¸ Ñ€Ð°Ð±Ð¾Ñ‚Ð¾Ð´Ð°Ñ‚ÐµÐ»Ñ, Ð·Ð°Ð»Ð¾Ð³ Ð¸ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€ â€” Ð¼Ð¸Ð½Ð¸Ð¼Ð¸Ð·Ð¸Ñ€ÑƒÐµÑ‚ Ñ€Ð¸ÑÐº Ð´Ð¾ 2â€“3%.',
                'key_takeaways' => ([
                    'ÐŸÑ€Ð¾Ð²ÐµÑ€ÑÐ¹Ñ‚Ðµ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ñ‹: Ð¿Ð°ÑÐ¿Ð¾Ñ€Ñ‚/ID + Ð’ÐÐ– + Ñ‚Ñ€ÑƒÐ´Ð¾Ð²Ð¾Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€',
                    'Ð—Ð°Ð¿Ñ€Ð¾ÑÐ¸Ñ‚Ðµ ÑÐ¿Ñ€Ð°Ð²ÐºÑƒ Ð¸Ð· Creditinfo (Ð¿ÑƒÐ±Ð»Ð¸Ñ‡Ð½Ñ‹Ðµ Ð´Ð¾Ð»Ð³Ð¸)',
                    'Ð—Ð°Ð»Ð¾Ð³ = 2 Ð¼ÐµÑÑÑ†Ð° Ð°Ñ€ÐµÐ½Ð´Ñ‹ (Ð¼Ð¸Ð½Ð¸Ð¼ÑƒÐ¼)',
                    'Ð”Ð¾Ð³Ð¾Ð²Ð¾Ñ€ Ð½Ð° ÑÑÑ‚Ð¾Ð½ÑÐºÐ¾Ð¼ ÑÐ·Ñ‹ÐºÐµ Ñ Ð¿Ñ€Ð¸Ð»Ð¾Ð¶ÐµÐ½Ð¸ÐµÐ¼ Ð¸Ð½Ð²ÐµÐ½Ñ‚Ð°Ñ€Ñ',
                    'ÐÐºÑ‚ Ð¿Ñ€Ð¸Ñ‘Ð¼Ð°-Ð¿ÐµÑ€ÐµÐ´Ð°Ñ‡Ð¸ Ñ Ñ„Ð¾Ñ‚Ð¾ â€” Ð¾Ð±ÑÐ·Ð°Ñ‚ÐµÐ»ÐµÐ½',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide4FaqRu()),
                'content_blocks' => ([
                    'quick_answer' => 'Ð”Ð»Ñ Ð±ÐµÐ·Ð¾Ð¿Ð°ÑÐ½Ð¾Ð¹ Ð°Ñ€ÐµÐ½Ð´Ñ‹: Ð¿Ñ€Ð¾Ð²ÐµÑ€ÑŒÑ‚Ðµ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ñ‹ Ð¸ ÐºÑ€ÐµÐ´Ð¸Ñ‚Ð½ÑƒÑŽ Ð¸ÑÑ‚Ð¾Ñ€Ð¸ÑŽ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð°, Ð²Ð¾Ð·ÑŒÐ¼Ð¸Ñ‚Ðµ Ð·Ð°Ð»Ð¾Ð³ 2 Ð¼ÐµÑÑÑ†Ð°, ÑÐ¾ÑÑ‚Ð°Ð²ÑŒÑ‚Ðµ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€ Ñ Ð¸Ð½Ð²ÐµÐ½Ñ‚Ð°Ñ€Ñ‘Ð¼ Ð¸ Ð°ÐºÑ‚Ð¾Ð¼ Ð¿Ñ€Ð¸Ñ‘Ð¼Ð°-Ð¿ÐµÑ€ÐµÐ´Ð°Ñ‡Ð¸.',
                    'intro' => '<p>Ð¡Ñ€ÐµÐ´Ð½Ð¸Ð¹ ÑƒÐ±Ñ‹Ñ‚Ð¾Ðº Ð¾Ñ‚ Ð¿Ñ€Ð¾Ð±Ð»ÐµÐ¼Ð½Ð¾Ð³Ð¾ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð° Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ â€” 2 000â€“10 000 â‚¬. Ð­Ñ‚Ð¾Ñ‚ Ð³Ð°Ð¹Ð´ Ð¿Ð¾Ð¼Ð¾Ð¶ÐµÑ‚ Ð¼Ð¸Ð½Ð¸Ð¼Ð¸Ð·Ð¸Ñ€Ð¾Ð²Ð°Ñ‚ÑŒ Ñ€Ð¸ÑÐº.</p>',
                    'sections' => [
                        ['heading' => 'Ð­Ñ‚Ð°Ð¿ 1: ÐŸÑ€Ð¾Ð²ÐµÑ€ÐºÐ° Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¾Ð²', 'body' => '<p>ÐŸÐ°ÑÐ¿Ð¾Ñ€Ñ‚/ID-ÐºÐ°Ñ€Ñ‚Ð°, Ð²Ð¸Ð´ Ð½Ð° Ð¶Ð¸Ñ‚ÐµÐ»ÑŒÑÑ‚Ð²Ð¾, Ñ‚Ñ€ÑƒÐ´Ð¾Ð²Ð¾Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€ Ð¸Ð»Ð¸ ÑÐ¿Ñ€Ð°Ð²ÐºÐ° Ð¾ Ð´Ð¾Ñ…Ð¾Ð´Ð°Ñ…. Ð”Ð»Ñ Ð¸Ð½Ð¾ÑÑ‚Ñ€Ð°Ð½Ñ†ÐµÐ² â€” Ð´Ð¾Ð¿Ð¾Ð»Ð½Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ð¾ Ð’ÐÐ–.</p>'],
                        ['heading' => 'Ð­Ñ‚Ð°Ð¿ 2: ÐšÑ€ÐµÐ´Ð¸Ñ‚Ð½Ð°Ñ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÐ°', 'body' => '<p>Ð—Ð°Ð¿Ñ€Ð¾ÑÐ¸Ñ‚Ðµ ÑÐ¾Ð³Ð»Ð°ÑÐ¸Ðµ Ð½Ð° Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÑƒ Ñ‡ÐµÑ€ÐµÐ· Creditinfo. ÐŸÑƒÐ±Ð»Ð¸Ñ‡Ð½Ñ‹Ðµ Ð´Ð¾Ð»Ð³Ð¸ = ÐºÑ€Ð°ÑÐ½Ñ‹Ð¹ Ñ„Ð»Ð°Ð³.</p>'],
                        ['heading' => 'Ð­Ñ‚Ð°Ð¿ 3: ÐŸÑ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€', 'body' => '<p>Ð”Ð¾Ð³Ð¾Ð²Ð¾Ñ€ Ð½Ð° ÑÑÑ‚Ð¾Ð½ÑÐºÐ¾Ð¼ ÑÐ·Ñ‹ÐºÐµ, Ñ Ð¿Ñ€Ð¸Ð»Ð¾Ð¶ÐµÐ½Ð¸ÐµÐ¼: Ð¸Ð½Ð²ÐµÐ½Ñ‚Ð°Ñ€ÑŒ + ÑÐ¾ÑÑ‚Ð¾ÑÐ½Ð¸Ðµ + Ñ„Ð¾Ñ‚Ð¾ + Ð°ÐºÑ‚ Ð¿Ñ€Ð¸Ñ‘Ð¼Ð°-Ð¿ÐµÑ€ÐµÐ´Ð°Ñ‡Ð¸.</p>'],
                        ['heading' => 'Ð­Ñ‚Ð°Ð¿ 4: Ð—Ð°Ð»Ð¾Ð³ Ð¸ Ð³Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ð¸', 'body' => '<p>Ð—Ð°Ð»Ð¾Ð³ = 2 Ð¼ÐµÑÑÑ†Ð° Ð°Ñ€ÐµÐ½Ð´Ñ‹. ÐŸÐµÑ€Ð²Ñ‹Ð¹ + Ð¿Ð¾ÑÐ»ÐµÐ´Ð½Ð¸Ð¹ Ð¼ÐµÑÑÑ† + Ð·Ð°Ð»Ð¾Ð³ = 3 Ð¼ÐµÑÑÑ†Ð° Ð¿Ñ€Ð¸ Ð·Ð°ÑÐµÐ»ÐµÐ½Ð¸Ð¸.</p>'],
                    ],
                    'cta' => ['heading' => 'ÐÑƒÐ¶Ð½Ð° Ð¿Ð¾Ð¼Ð¾Ñ‰ÑŒ Ñ Ð°Ñ€ÐµÐ½Ð´Ð¾Ð¹?', 'text' => 'ÐŸÑ€Ð¾Ð²ÐµÑ€ÐºÐ° Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð° Ð¸ Ð¾Ñ„Ð¾Ñ€Ð¼Ð»ÐµÐ½Ð¸Ðµ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€Ð° â€” Ð¾Ñ‚ 200 â‚¬.', 'button' => 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÑƒ'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Turvaline Ã¼Ã¼rimine: Ã¼Ã¼rniku kontrollimise tÃ¤ielik nimekiri',
                'excerpt' => 'Kuidas Ã¼Ã¼rida korter Tallinnas ja vÃ¤ltida probleemset Ã¼Ã¼rnikku. 15-punktiline kontrollnimekiri.',
                'meta_title' => 'ÃœÃ¼rniku kontroll: kontrollnimekiri | CityEE',
                'meta_description' => 'Turvaline Ã¼Ã¼rimine Tallinnas: Ã¼Ã¼rniku kontrollnimekiri 15 punkti. Dokumendid, garantiid, leping.',
                'ai_summary' => 'Probleemne Ã¼Ã¼rnik vÃµib omanikule maksma minna 2 000â€“10 000 â‚¬. TÃ¤ielik kontrollnimekiri: dokumendid, krediidiajalugu, tÃ¶Ã¶andja soovitused, tagatisraha ja Ãµige leping.',
                'key_takeaways' => ([
                    'Kontrollige dokumente: pass/ID + elamisluba + tÃ¶Ã¶leping',
                    'KÃ¼sige Creditinfo tÃµendit (avalikud vÃµlad)',
                    'Tagatisraha = 2 kuu Ã¼Ã¼r (miinimum)',
                    'Leping eesti keeles koos inventari lisaga',
                    'Ãœleandmisakt fotodega â€” kohustuslik',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide4FaqEt()),
                'content_blocks' => ([
                    'quick_answer' => 'Turvaliseks Ã¼Ã¼rimiseks: kontrollige Ã¼Ã¼rniku dokumente ja krediidiajalugu, vÃµtke 2 kuu tagatisraha, koostage Ãµige leping inventari ja Ã¼leandmisaktiga.',
                    'intro' => '<p>Keskmine kahju probleemse Ã¼Ã¼rniku tÃµttu Tallinnas â€” 2 000â€“10 000 â‚¬. See juhend aitab riski minimeerida.</p>',
                    'sections' => [
                        ['heading' => '1. etapp: Dokumentide kontroll', 'body' => '<p>Pass/ID-kaart, elamisluba, tÃ¶Ã¶leping vÃµi sissetulekutÃµend.</p>'],
                        ['heading' => '2. etapp: Krediidikontroll', 'body' => '<p>KÃ¼sige nÃµusolekut Creditinfo kontrolliks. Avalikud vÃµlad = punane lipp.</p>'],
                    ],
                    'cta' => ['heading' => 'Vajate abi Ã¼Ã¼rimisega?', 'text' => 'ÃœÃ¼rniku kontroll ja lepingu vormistamine â€” alates 200 â‚¬.', 'button' => 'Telli kontroll'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Safe Rental: Complete Tenant Verification Checklist',
                'excerpt' => 'How to rent out your apartment in Tallinn safely. 15-point tenant check checklist.',
                'meta_title' => 'Tenant Verification Checklist | CityEE',
                'meta_description' => 'Safe rental in Tallinn: 15-point tenant verification checklist. Documents, guarantees, contract.',
                'ai_summary' => 'A problematic tenant can cost the owner 2,000â€“10,000 â‚¬ (unpaid rent, damages, legal costs). Complete verification checklist: documents, credit history, employer references, deposit and proper contract â€” minimizes risk to 2â€“3%.',
                'key_takeaways' => ([
                    'Verify documents: passport/ID + residence permit + employment contract',
                    'Request Creditinfo certificate (public debts)',
                    'Deposit = 2 months rent (minimum)',
                    'Contract in Estonian with inventory appendix',
                    'Handover act with photos â€” mandatory',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide4FaqEn()),
                'content_blocks' => ([
                    'quick_answer' => 'For safe rental: verify tenant documents and credit history, collect 2-month deposit, draft a proper contract with inventory and handover act.',
                    'intro' => '<p>Average loss from a problematic tenant in Tallinn â€” 2,000â€“10,000 â‚¬. This guide helps minimize the risk.</p>',
                    'sections' => [
                        ['heading' => 'Stage 1: Document Verification', 'body' => '<p>Passport/ID card, residence permit, employment contract or income certificate.</p>'],
                        ['heading' => 'Stage 2: Credit Check', 'body' => '<p>Request consent for Creditinfo check. Public debts = red flag.</p>'],
                    ],
                    'cta' => ['heading' => 'Need help with rental?', 'text' => 'Tenant verification and contract drafting â€” from 200 â‚¬.', 'button' => 'Order Verification'],
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
            'related_guide_slugs'  => (['sell-apartment-without-losing-money', 'real-price-corridor']),
            'related_audit_slugs'  => (['30-45-day-sales-plan-audit']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'ÐŸÐ»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹: Ð¿Ð¾ÑˆÐ°Ð³Ð¾Ð²Ð°Ñ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ',
                'excerpt' => 'ÐšÐ°Ðº Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹ Ð¿Ð¾ Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ñ†ÐµÐ½Ðµ. ÐŸÐ¾Ð»Ð½Ñ‹Ð¹ Ñ‚Ð°Ð¹Ð¼Ð»Ð°Ð¹Ð½ Ñ Ð´ÐµÐ´Ð»Ð°Ð¹Ð½Ð°Ð¼Ð¸.',
                'meta_title' => 'ÐŸÐ»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹ | CityEE',
                'meta_description' => 'ÐŸÐ¾ÑˆÐ°Ð³Ð¾Ð²Ñ‹Ð¹ Ð¿Ð»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹: Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°, Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ, Ð¿Ð¾ÐºÐ°Ð·Ñ‹, Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹, ÑÐ´ÐµÐ»ÐºÐ°.',
                'ai_summary' => 'Ð¡Ñ€ÐµÐ´Ð½Ð¸Ð¹ ÑÑ€Ð¾Ðº Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ â€” 60â€“90 Ð´Ð½ÐµÐ¹. Ð¡ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ñ‹Ð¼ Ð¿Ð»Ð°Ð½Ð¾Ð¼ Ð¸ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÐµÐ¹ CityEE ÑÐ¾ÐºÑ€Ð°Ñ‰Ð°ÐµÑ‚ ÑÑ‚Ð¾Ñ‚ ÑÑ€Ð¾Ðº Ð´Ð¾ 30â€“45 Ð´Ð½ÐµÐ¹ Ð±ÐµÐ· ÑÐ½Ð¸Ð¶ÐµÐ½Ð¸Ñ Ñ†ÐµÐ½Ñ‹. ÐšÐ»ÑŽÑ‡ â€” Ñ‡Ñ‘Ñ‚ÐºÐ¸Ð¹ Ñ‚Ð°Ð¹Ð¼Ð»Ð°Ð¹Ð½: Ð½ÐµÐ´ÐµÐ»Ñ 1 â€” Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°, Ð½ÐµÐ´ÐµÐ»Ñ 2 â€” Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ, Ð½ÐµÐ´ÐµÐ»Ð¸ 3â€“4 â€” Ð¿Ð¾ÐºÐ°Ð·Ñ‹ Ð¸ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹, Ð½ÐµÐ´ÐµÐ»Ñ 5â€“6 â€” Ð¿Ñ€ÐµÐ´Ð²Ð°Ñ€Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€ Ð¸ ÑÐ´ÐµÐ»ÐºÐ°.',
                'key_takeaways' => ([
                    'ÐÐµÐ´ÐµÐ»Ñ 1: Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ + Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ + Ñ„Ð¾Ñ‚Ð¾',
                    'ÐÐµÐ´ÐµÐ»Ñ 2: Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð½Ð° KV.ee + Ð¿Ñ€Ð¾Ð´Ð²Ð¸Ð¶ÐµÐ½Ð¸Ðµ',
                    'ÐÐµÐ´ÐµÐ»Ð¸ 3â€“4: Ð¿Ð¾ÐºÐ°Ð·Ñ‹ Ð¸ ÑÐ±Ð¾Ñ€ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹',
                    'ÐÐµÐ´ÐµÐ»Ñ 4â€“5: Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹ Ñ Ñ‚Ð¾Ð¿-Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑÐ¼Ð¸',
                    'ÐÐµÐ´ÐµÐ»Ñ 5â€“6: Ð¿Ñ€ÐµÐ´Ð²Ð°Ñ€Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€ + Ð½Ð¾Ñ‚Ð°Ñ€Ð¸ÑƒÑ',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide5FaqRu()),
                'content_blocks' => ([
                    'quick_answer' => 'ÐŸÐ»Ð°Ð½ 30â€“45 Ð´Ð½ÐµÐ¹: Ð½ÐµÐ´ÐµÐ»Ñ 1 â€” Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° + ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ + Ñ„Ð¾Ñ‚Ð¾, Ð½ÐµÐ´ÐµÐ»Ñ 2 â€” KV.ee Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ, Ð½ÐµÐ´ÐµÐ»Ð¸ 3â€“4 â€” Ð¿Ð¾ÐºÐ°Ð·Ñ‹, Ð½ÐµÐ´ÐµÐ»Ñ 5 â€” Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹, Ð½ÐµÐ´ÐµÐ»Ñ 6 â€” Ð½Ð¾Ñ‚Ð°Ñ€Ð¸ÑƒÑ.',
                    'intro' => '<p>Ð¡Ñ€ÐµÐ´Ð½Ð¸Ð¹ ÑÑ€Ð¾Ðº Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ â€” 60â€“90 Ð´Ð½ÐµÐ¹. ÐÐ°Ñˆ Ð¿Ð»Ð°Ð½ ÑÐ¾ÐºÑ€Ð°Ñ‰Ð°ÐµÑ‚ ÐµÐ³Ð¾ Ð²Ð´Ð²Ð¾Ðµ, ÑÐ¾Ñ…Ñ€Ð°Ð½ÑÑ (Ð¸ Ñ‡Ð°ÑÑ‚Ð¾ ÑƒÐ²ÐµÐ»Ð¸Ñ‡Ð¸Ð²Ð°Ñ) Ñ†ÐµÐ½Ñƒ.</p>',
                    'sections' => [
                        ['heading' => 'ÐÐµÐ´ÐµÐ»Ñ 1: ÐŸÐ¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°', 'snippet' => 'ÐŸÐµÑ€Ð²Ð°Ñ Ð½ÐµÐ´ÐµÐ»Ñ â€” Ñ„ÑƒÐ½Ð´Ð°Ð¼ÐµÐ½Ñ‚ Ð²ÑÐµÐ¹ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸: Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€, Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹, Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð°Ñ Ñ„Ð¾Ñ‚Ð¾ÑÑŠÑ‘Ð¼ÐºÐ°.', 'body' => '<p>Ð”ÐµÐ½ÑŒ 1â€“2: Ñ€Ð°ÑÑ‡Ñ‘Ñ‚ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð¿Ð¾ Maa-amet. Ð”ÐµÐ½ÑŒ 3â€“4: decluttering Ð¸ Ð¼ÐµÐ»ÐºÐ¸Ð¹ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚. Ð”ÐµÐ½ÑŒ 5â€“7: Ñ„Ð¾Ñ‚Ð¾ÑÑŠÑ‘Ð¼ÐºÐ° Ð¸ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° Ñ‚ÐµÐºÑÑ‚Ð° Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ.</p>'],
                        ['heading' => 'ÐÐµÐ´ÐµÐ»Ñ 2: ÐŸÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð¸ Ð¿Ñ€Ð¾Ð´Ð²Ð¸Ð¶ÐµÐ½Ð¸Ðµ', 'body' => '<p>ÐŸÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð½Ð° KV.ee Ð²Ð¾ Ð²Ñ‚Ð¾Ñ€Ð½Ð¸Ðºâ€“Ñ‡ÐµÑ‚Ð²ÐµÑ€Ð³ ÑƒÑ‚Ñ€Ð¾Ð¼. ÐŸÑ€ÐµÐ¼Ð¸ÑƒÐ¼-Ð¿Ð°ÐºÐµÑ‚ Ð½Ð° 14 Ð´Ð½ÐµÐ¹. Ð”ÑƒÐ±Ð»Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð¸Ðµ Ð² ÑÐ¾Ñ†Ð¸Ð°Ð»ÑŒÐ½Ñ‹Ñ… ÑÐµÑ‚ÑÑ… Ð¸ Ñ‚ÐµÐ¼Ð°Ñ‚Ð¸Ñ‡ÐµÑÐºÐ¸Ñ… Ñ‡Ð°Ñ‚Ð°Ñ….</p>'],
                        ['heading' => 'ÐÐµÐ´ÐµÐ»Ð¸ 3â€“4: ÐŸÐ¾ÐºÐ°Ð·Ñ‹', 'body' => '<p>ÐžÑ€Ð³Ð°Ð½Ð¸Ð·Ð°Ñ†Ð¸Ñ Ð¿Ð¾ÐºÐ°Ð·Ð¾Ð² Ð³Ñ€ÑƒÐ¿Ð¿Ð°Ð¼Ð¸ (2â€“3 Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»Ñ Ð²Ð¼ÐµÑÑ‚Ðµ = Ð¾Ñ‰ÑƒÑ‰ÐµÐ½Ð¸Ðµ ÐºÐ¾Ð½ÐºÑƒÑ€ÐµÐ½Ñ†Ð¸Ð¸). Ð¡Ð±Ð¾Ñ€ Ð¾Ð±Ñ€Ð°Ñ‚Ð½Ð¾Ð¹ ÑÐ²ÑÐ·Ð¸ Ð¿Ð¾ÑÐ»Ðµ ÐºÐ°Ð¶Ð´Ð¾Ð³Ð¾ Ð¿Ð¾ÐºÐ°Ð·Ð°.</p>'],
                        ['heading' => 'ÐÐµÐ´ÐµÐ»Ñ 5: ÐŸÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹', 'body' => '<p>Ð Ð°Ð±Ð¾Ñ‚Ð° Ñ Ð»ÑƒÑ‡ÑˆÐ¸Ð¼Ð¸ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸ÑÐ¼Ð¸. ÐœÐµÑ‚Ð¾Ð´ Â«Ð´Ð²ÑƒÑ… Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹Â». Ð¤Ð¸Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ‚Ð¾Ñ€Ð³ Ñ Ð¿Ð¾Ð·Ð¸Ñ†Ð¸Ð¸ ÑÐ¸Ð»Ñ‹.</p>'],
                        ['heading' => 'ÐÐµÐ´ÐµÐ»Ñ 6: Ð¡Ð´ÐµÐ»ÐºÐ°', 'body' => '<p>ÐŸÑ€ÐµÐ´Ð²Ð°Ñ€Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€ â†’ Ð½Ð¾Ñ‚Ð°Ñ€Ð¸ÑƒÑ â†’ Ð¿ÐµÑ€ÐµÐ´Ð°Ñ‡Ð° ÐºÐ»ÑŽÑ‡ÐµÐ¹. Ð’ÑÑ Ð±ÑƒÐ¼Ð°Ð¶Ð½Ð°Ñ Ñ€Ð°Ð±Ð¾Ñ‚Ð° Ð·Ð°Ð½Ð¸Ð¼Ð°ÐµÑ‚ 3â€“5 Ð´Ð½ÐµÐ¹.</p>'],
                    ],
                    'cta' => ['heading' => 'Ð¥Ð¾Ñ‚Ð¸Ñ‚Ðµ Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹?', 'text' => 'ÐŸÐ¾Ð»ÑƒÑ‡Ð¸Ñ‚Ðµ Ð¿ÐµÑ€ÑÐ¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ð¿Ð»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð¾.', 'button' => 'ÐŸÐ¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ð¿Ð»Ð°Ð½'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Korteri mÃ¼Ã¼giplaan 30â€“45 pÃ¤evaga: samm-sammuline strateegia',
                'excerpt' => 'Kuidas mÃ¼Ã¼a korter Tallinnas 30â€“45 pÃ¤evaga maksimaalse hinnaga. TÃ¤ielik ajakava.',
                'meta_title' => 'Korteri mÃ¼Ã¼giplaan 30â€“45 pÃ¤eva | CityEE',
                'meta_description' => 'Samm-sammuline korteri mÃ¼Ã¼giplaan Tallinnas 30â€“45 pÃ¤evaga: ettevalmistus, avaldamine, nÃ¤itamised, lÃ¤birÃ¤Ã¤kimised.',
                'ai_summary' => 'Keskmine mÃ¼Ã¼giaeg Tallinnas â€” 60â€“90 pÃ¤eva. Ã•ige plaaniga lÃ¼hendab CityEE selle 30â€“45 pÃ¤evale ilma hinda langetamata.',
                'key_takeaways' => ([
                    '1. nÃ¤dal: korteri ettevalmistus + hinnakoridor + fotod',
                    '2. nÃ¤dal: KV.ee avaldamine + reklaam',
                    '3.â€“4. nÃ¤dal: nÃ¤itamised ja pakkumiste kogumine',
                    '5. nÃ¤dal: lÃ¤birÃ¤Ã¤kimised parimate ostjatega',
                    '6. nÃ¤dal: eelleping + notar',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide5FaqEt()),
                'content_blocks' => ([
                    'quick_answer' => 'Plaan 30â€“45 pÃ¤eva: 1. nÃ¤dal â€” ettevalmistus + koridor + fotod, 2. nÃ¤dal â€” KV.ee, 3.â€“4. nÃ¤dal â€” nÃ¤itamised, 5. nÃ¤dal â€” lÃ¤birÃ¤Ã¤kimised, 6. nÃ¤dal â€” notar.',
                    'intro' => '<p>Keskmine mÃ¼Ã¼giaeg Tallinnas on 60â€“90 pÃ¤eva. Meie plaan lÃ¼hendab selle poole vÃµrra.</p>',
                    'sections' => [
                        ['heading' => '1. nÃ¤dal: Ettevalmistus', 'body' => '<p>Hinnakoridori arvutus, decluttering, fotosessioon.</p>'],
                        ['heading' => '2. nÃ¤dal: Avaldamine', 'body' => '<p>KV.ee avaldamine Tâ€“N hommikul. Premium pakett.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite mÃ¼Ã¼a 30â€“45 pÃ¤evaga?', 'text' => 'Saage personaalne mÃ¼Ã¼giplaan tasuta.', 'button' => 'Saa plaan'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Apartment Sales Plan in 30â€“45 Days: Step-by-Step Strategy',
                'excerpt' => 'How to sell an apartment in Tallinn in 30â€“45 days at maximum price. Complete timeline with deadlines.',
                'meta_title' => 'Apartment Sales Plan 30â€“45 Days | CityEE',
                'meta_description' => 'Step-by-step apartment sales plan in Tallinn in 30â€“45 days: preparation, publishing, showings, negotiations, closing.',
                'ai_summary' => 'Average selling time in Tallinn is 60â€“90 days. With the right plan, CityEE cuts this to 30â€“45 days without reducing the price.',
                'key_takeaways' => ([
                    'Week 1: apartment preparation + price corridor + photos',
                    'Week 2: KV.ee publication + promotion',
                    'Weeks 3â€“4: showings and collecting offers',
                    'Week 5: negotiations with top buyers',
                    'Week 6: preliminary contract + notary',
                ]),
                'location_tags' => (['Tallinn', 'Harjumaa']),
                'faq_json' => ($this->guide5FaqEn()),
                'content_blocks' => ([
                    'quick_answer' => '30â€“45 day plan: week 1 â€” preparation + corridor + photos, week 2 â€” KV.ee publication, weeks 3â€“4 â€” showings, week 5 â€” negotiations, week 6 â€” notary.',
                    'intro' => '<p>Average selling time in Tallinn is 60â€“90 days. Our plan halves it while maintaining (and often increasing) the price.</p>',
                    'sections' => [
                        ['heading' => 'Week 1: Preparation', 'body' => '<p>Price corridor calculation, decluttering, photo session.</p>'],
                        ['heading' => 'Week 2: Publication', 'body' => '<p>KV.ee publication Tueâ€“Thu morning. Premium package.</p>'],
                    ],
                    'cta' => ['heading' => 'Want to sell in 30â€“45 days?', 'text' => 'Get a personalized sales plan for free.', 'button' => 'Get Plan'],
                ]),
            ]),
        ];
    }

    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    //  AUDIT DATA
    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•

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
            'related_guide_slugs'  => (['kv-ee-listing-checklist', 'sell-apartment-without-losing-money']),
            'related_audit_slugs'  => (['price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'ÐÑƒÐ´Ð¸Ñ‚ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee: Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ€Ð°Ð·Ð±Ð¾Ñ€ 2-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ Ð² Kesklinn',
                'excerpt' => 'Ð Ð°Ð·Ð±Ð¸Ñ€Ð°ÐµÐ¼ Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ðµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ: Ñ‡Ñ‚Ð¾ Ð½Ðµ Ñ‚Ð°Ðº Ñ Ñ„Ð¾Ñ‚Ð¾, Ñ†ÐµÐ½Ð¾Ð¹ Ð¸ Ñ‚ÐµÐºÑÑ‚Ð¾Ð¼. Ð”Ð¾ Ð¸ Ð¿Ð¾ÑÐ»Ðµ Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð°Ñ†Ð¸Ð¸.',
                'meta_title' => 'ÐÑƒÐ´Ð¸Ñ‚ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ KV.ee â€” Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ€Ð°Ð·Ð±Ð¾Ñ€ | CityEE',
                'meta_description' => 'ÐÑƒÐ´Ð¸Ñ‚ Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ð³Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee: 2-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð°Ñ Ð² Kesklinn. ÐžÑˆÐ¸Ð±ÐºÐ¸ Ñ„Ð¾Ñ‚Ð¾, Ñ†ÐµÐ½Ñ‹ Ð¸ Ñ‚ÐµÐºÑÑ‚Ð°. Ð ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ð¸.',
                'ai_summary' => 'ÐÑƒÐ´Ð¸Ñ‚ Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ð³Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ 2-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² Kesklinn Ð½Ð° KV.ee. Ð’Ñ‹ÑÐ²Ð»ÐµÐ½Ñ‹ 12 ÐºÑ€Ð¸Ñ‚Ð¸Ñ‡ÐµÑÐºÐ¸Ñ… Ð¾ÑˆÐ¸Ð±Ð¾Ðº: Ñ‚Ñ‘Ð¼Ð½Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾ Ð±ÐµÐ· ÐµÑÑ‚ÐµÑÑ‚Ð²ÐµÐ½Ð½Ð¾Ð³Ð¾ ÑÐ²ÐµÑ‚Ð°, Ð·Ð°Ð²Ñ‹ÑˆÐµÐ½Ð½Ð°Ñ Ñ†ÐµÐ½Ð° Ð½Ð° 8% Ð²Ñ‹ÑˆÐµ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°, Ñ‚ÐµÐºÑÑ‚ Ð±ÐµÐ· ÐºÐ»ÑŽÑ‡ÐµÐ²Ñ‹Ñ… Ñ„Ð°ÐºÑ‚Ð¾Ð². ÐŸÐ¾ÑÐ»Ðµ Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð°Ñ†Ð¸Ð¸: Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ñ‹ Ð²Ñ‹Ñ€Ð¾ÑÐ»Ð¸ Ð½Ð° 340%, Ð¿Ð¾Ð»ÑƒÑ‡ÐµÐ½Ð¾ 4 Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ Ð·Ð° 10 Ð´Ð½ÐµÐ¹.',
                'key_takeaways' => ([
                    'Ð¢Ñ‘Ð¼Ð½Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾ ÑÐ½Ð¸Ð¶Ð°ÑŽÑ‚ CTR Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° 50â€“70%',
                    'Ð¦ÐµÐ½Ð° Ð²Ñ‹ÑˆÐµ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð½Ð° 8% = 0 Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹ Ð·Ð° 30 Ð´Ð½ÐµÐ¹',
                    'ÐžÑ‚ÑÑƒÑ‚ÑÑ‚Ð²Ð¸Ðµ Ð¿Ð»Ð¾Ñ‰Ð°Ð´Ð¸ Ð² Ð·Ð°Ð³Ð¾Ð»Ð¾Ð²ÐºÐµ â€” Ð¿Ð¾Ñ‚ÐµÑ€Ñ 20% Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð²',
                    'ÐŸÐ¾ÑÐ»Ðµ Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð°Ñ†Ð¸Ð¸: +340% Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð² Ð·Ð° Ð¿ÐµÑ€Ð²Ñ‹Ðµ 7 Ð´Ð½ÐµÐ¹',
                    'ÐŸÑ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾ + Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð°Ñ Ñ†ÐµÐ½Ð° = 4 Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ Ð·Ð° 10 Ð´Ð½ÐµÐ¹',
                ]),
                'location_tags' => (['Tallinn', 'Kesklinn']),
                'faq_json' => ($this->audit1FaqRu()),
                'content_blocks' => ([
                    'summary' => '<p>Ð’Ð»Ð°Ð´ÐµÐ»ÐµÑ† 2-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ (52 Ð¼Â²) Ð² Kesklinn Ð¾Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ¾Ð²Ð°Ð» Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð½Ð° KV.ee. Ð—Ð° 30 Ð´Ð½ÐµÐ¹ â€” 0 Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹, 180 Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð². ÐŸÐ¾ÑÐ»Ðµ Ð°ÑƒÐ´Ð¸Ñ‚Ð° CityEE Ð¸ Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð°Ñ†Ð¸Ð¸ â€” 4 Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ Ð·Ð° 10 Ð´Ð½ÐµÐ¹, Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð° Ð¿Ð¾ Ñ†ÐµÐ½Ðµ +3% Ð¾Ñ‚ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°.</p>',
                    'market_data' => '<div class="audit-stats"><div class="audit-stat"><span class="audit-stat__value">52 Ð¼Â²</span><span class="audit-stat__label">ÐŸÐ»Ð¾Ñ‰Ð°Ð´ÑŒ</span></div><div class="audit-stat"><span class="audit-stat__value">Kesklinn</span><span class="audit-stat__label">Ð Ð°Ð¹Ð¾Ð½</span></div><div class="audit-stat"><span class="audit-stat__value">3 200 â‚¬/Ð¼Â²</span><span class="audit-stat__label">ÐœÐµÐ´Ð¸Ð°Ð½Ð° Maa-amet</span></div><div class="audit-stat"><span class="audit-stat__value">+340%</span><span class="audit-stat__label">Ð Ð¾ÑÑ‚ Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð²</span></div></div>',
                    'sections' => [
                        ['heading' => 'ÐžÑˆÐ¸Ð±ÐºÐ° 1: Ð¢Ñ‘Ð¼Ð½Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾', 'snippet' => 'Ð¤Ð¾Ñ‚Ð¾ Ð±ÐµÐ· ÐµÑÑ‚ÐµÑÑ‚Ð²ÐµÐ½Ð½Ð¾Ð³Ð¾ ÑÐ²ÐµÑ‚Ð° ÑÐ½Ð¸Ð¶Ð°ÑŽÑ‚ CTR Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° 50â€“70%.', 'body' => '<p>Ð’ÑÐµ 6 Ñ„Ð¾Ñ‚Ð¾ ÑÐ´ÐµÐ»Ð°Ð½Ñ‹ Ð²ÐµÑ‡ÐµÑ€Ð¾Ð¼ Ð¿Ñ€Ð¸ Ð¸ÑÐºÑƒÑÑÑ‚Ð²ÐµÐ½Ð½Ð¾Ð¼ Ð¾ÑÐ²ÐµÑ‰ÐµÐ½Ð¸Ð¸. ÐšÐ¾Ð¼Ð½Ð°Ñ‚Ñ‹ Ð²Ñ‹Ð³Ð»ÑÐ´ÑÑ‚ Ñ‚ÐµÑÐ½Ñ‹Ð¼Ð¸ Ð¸ Ñ‚Ñ‘Ð¼Ð½Ñ‹Ð¼Ð¸. Ð ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ñ: Ð¿ÐµÑ€ÐµÑÑŠÑ‘Ð¼ÐºÐ° Ð´Ð½Ñ‘Ð¼, 10+ Ñ„Ð¾Ñ‚Ð¾ Ñ ÑˆÐ¸Ñ€Ð¾ÐºÐ¸Ð¼ ÑƒÐ³Ð»Ð¾Ð¼.</p>'],
                        ['heading' => 'ÐžÑˆÐ¸Ð±ÐºÐ° 2: Ð—Ð°Ð²Ñ‹ÑˆÐµÐ½Ð½Ð°Ñ Ñ†ÐµÐ½Ð°', 'snippet' => 'Ð¦ÐµÐ½Ð° Ð±Ñ‹Ð»Ð° Ð²Ñ‹ÑˆÐµ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð½Ð° 8% â€” ÑÑ‚Ð¾ Ð¾Ñ‚ÑÐµÐºÐ°ÐµÑ‚ 80% Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹.', 'body' => '<p>Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð¿Ð¾ Maa-amet: 155 000â€“172 000 â‚¬. Ð’Ñ‹ÑÑ‚Ð°Ð²Ð»ÐµÐ½Ð½Ð°Ñ Ñ†ÐµÐ½Ð°: 185 000 â‚¬. Ð ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ñ: 172 000 â‚¬ (Ð²ÐµÑ€Ñ…Ð½ÑÑ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ð° ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°).</p>'],
                        ['heading' => 'ÐžÑˆÐ¸Ð±ÐºÐ° 3: Ð¡Ð»Ð°Ð±Ñ‹Ð¹ Ñ‚ÐµÐºÑÑ‚', 'body' => '<p>ÐÐµÑ‚ Ð¿Ð»Ð¾Ñ‰Ð°Ð´Ð¸ Ð² Ð·Ð°Ð³Ð¾Ð»Ð¾Ð²ÐºÐµ, Ð½ÐµÑ‚ Ð¸Ð½Ñ„Ð¾Ñ€Ð¼Ð°Ñ†Ð¸Ð¸ Ð¾Ð± Ð¸Ð½Ñ„Ñ€Ð°ÑÑ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ðµ, Ð¾Ð¿Ð¸ÑÐ°Ð½Ð¸Ðµ Ñ‚Ð¾Ð»ÑŒÐºÐ¾ Ð½Ð° Ñ€ÑƒÑÑÐºÐ¾Ð¼. Ð ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ñ: Ð´Ð²ÑƒÑÐ·Ñ‹Ñ‡Ð½Ð¾Ðµ Ð¾Ð¿Ð¸ÑÐ°Ð½Ð¸Ðµ Ñ Ñ„Ð°ÐºÑ‚Ð°Ð¼Ð¸.</p>'],
                        ['heading' => 'Ð ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚ Ð¿Ð¾ÑÐ»Ðµ Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð°Ñ†Ð¸Ð¸', 'snippet' => 'ÐŸÐ¾ÑÐ»Ðµ Ð²Ð½ÐµÐ´Ñ€ÐµÐ½Ð¸Ñ Ñ€ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ð¹: +340% Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð², 4 Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ Ð·Ð° 10 Ð´Ð½ÐµÐ¹, Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð° +3% Ð¾Ñ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°.', 'body' => '<p>ÐÐ¾Ð²Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾, Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð°Ñ Ñ†ÐµÐ½Ð°, Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ Ñ‚ÐµÐºÑÑ‚ â€” Ð¸ Ñ€ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚ Ð½Ðµ Ð·Ð°ÑÑ‚Ð°Ð²Ð¸Ð» ÑÐµÐ±Ñ Ð¶Ð´Ð°Ñ‚ÑŒ.</p>'],
                    ],
                    'cta' => ['heading' => 'Ð¥Ð¾Ñ‚Ð¸Ñ‚Ðµ Ñ‚Ð°ÐºÐ¾Ð¹ Ð¶Ðµ Ñ€Ð°Ð·Ð±Ð¾Ñ€?', 'text' => 'Ð‘ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ð°ÑƒÐ´Ð¸Ñ‚ Ð²Ð°ÑˆÐµÐ³Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee Ð·Ð° 2 Ñ‡Ð°ÑÐ°.', 'button' => 'Ð—Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð°ÑƒÐ´Ð¸Ñ‚'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'KV.ee kuulutuse audit: tegelik analÃ¼Ã¼s â€” 2-toaline Kesklinnas',
                'excerpt' => 'AnalÃ¼Ã¼sime tegelikku kuulutust: mis on valesti fotode, hinna ja tekstiga. Enne ja pÃ¤rast optimeerimist.',
                'meta_title' => 'KV.ee kuulutuse audit â€” tegelik analÃ¼Ã¼s | CityEE',
                'meta_description' => 'Tegeliku KV.ee kuulutuse audit: 2-toaline Kesklinnas. Fotode, hinna ja teksti vead. Soovitused.',
                'ai_summary' => 'Tegeliku 2-toalise korteri kuulutuse audit KV.ee-s Kesklinnas. Tuvastatud 12 kriitilist viga: tumedad fotod, 8% koridorist kÃµrgem hind, puudulikud faktid.',
                'key_takeaways' => ([
                    'Tumedad fotod vÃ¤hendavad CTR-i 50â€“70%',
                    'Hind 8% koridorist kÃµrgem = 0 pakkumist 30 pÃ¤evaga',
                    'PÃ¤rast optimeerimist: +340% vaatamisi 7 pÃ¤evaga',
                    'Profifotod + Ãµige hind = 4 pakkumist 10 pÃ¤evaga',
                ]),
                'location_tags' => (['Tallinn', 'Kesklinn']),
                'faq_json' => ($this->audit1FaqEt()),
                'content_blocks' => ([
                    'summary' => '<p>2-toalise korteri (52 mÂ²) omanik Kesklinnas avaldas KV.ee kuulutuse. 30 pÃ¤eva â€” 0 pakkumist. PÃ¤rast CityEE auditi ja optimeerimist â€” 4 pakkumist 10 pÃ¤evaga.</p>',
                    'sections' => [
                        ['heading' => 'Viga 1: Tumedad fotod', 'body' => '<p>KÃµik fotod tehtud Ãµhtul. Soovitus: Ã¼mberpildistamine pÃ¤eval.</p>'],
                        ['heading' => 'Viga 2: Liiga kÃµrge hind', 'body' => '<p>Hinnakoridor: 155 000â€“172 000 â‚¬. Pandud hind: 185 000 â‚¬.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite sama analÃ¼Ã¼si?', 'text' => 'Tasuta KV.ee kuulutuse audit 2 tunniga.', 'button' => 'Telli audit'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'KV.ee Listing Audit: Real Case Study â€” 2-Room in Kesklinn',
                'excerpt' => 'We analyze a real listing: what\'s wrong with photos, price, and copy. Before and after optimization.',
                'meta_title' => 'KV.ee Listing Audit â€” Real Case Study | CityEE',
                'meta_description' => 'Real KV.ee listing audit: 2-room in Kesklinn. Photo, price, and copy errors. Recommendations.',
                'ai_summary' => 'Audit of a real 2-room apartment listing on KV.ee in Kesklinn. Found 12 critical errors: dark photos, price 8% above corridor, missing key facts. After optimization: +340% views, 4 offers in 10 days.',
                'key_takeaways' => ([
                    'Dark photos reduce listing CTR by 50â€“70%',
                    'Price 8% above corridor = 0 offers in 30 days',
                    'After optimization: +340% views in 7 days',
                    'Professional photos + correct price = 4 offers in 10 days',
                ]),
                'location_tags' => (['Tallinn', 'Kesklinn']),
                'faq_json' => ($this->audit1FaqEn()),
                'content_blocks' => ([
                    'summary' => '<p>Owner of a 2-room apartment (52 sqm) in Kesklinn published on KV.ee. 30 days â€” 0 offers. After CityEE audit â€” 4 offers in 10 days, sold at +3% above corridor.</p>',
                    'sections' => [
                        ['heading' => 'Error 1: Dark Photos', 'body' => '<p>All photos taken in the evening. Recommendation: reshoot during daytime.</p>'],
                        ['heading' => 'Error 2: Overpriced', 'body' => '<p>Price corridor: 155,000â€“172,000 â‚¬. Listed at: 185,000 â‚¬.</p>'],
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
            'related_guide_slugs'  => (['real-price-corridor', 'sell-apartment-without-losing-money']),
            'related_audit_slugs'  => (['kv-ee-listing-audit']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ + ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð²: Ñ€Ð°Ð·Ð±Ð¾Ñ€ 3-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ Ð² MustamÃ¤e',
                'excerpt' => 'ÐšÐ°Ðº Ð¼Ñ‹ Ð½Ð°ÑˆÐ»Ð¸ Ñ‚Ð¾Ñ‡Ð½Ñ‹Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð¸ Ð²Ñ‹Ñ‚Ð¾Ñ€Ð³Ð¾Ð²Ð°Ð»Ð¸ +7 000 â‚¬ Ð´Ð»Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð²Ñ†Ð°. Ð ÐµÐ°Ð»ÑŒÐ½Ñ‹Ðµ Ñ†Ð¸Ñ„Ñ€Ñ‹ Ð¸ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ.',
                'meta_title' => 'Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð¸ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹ â€” Ñ€Ð°Ð·Ð±Ð¾Ñ€ | CityEE',
                'meta_description' => 'Ð ÐµÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ€Ð°Ð·Ð±Ð¾Ñ€: Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ 3-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ Ð² MustamÃ¤e + ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð² = +7 000 â‚¬ Ð´Ð»Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð²Ñ†Ð°.',
                'ai_summary' => 'Ð Ð°Ð·Ð±Ð¾Ñ€ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ 3-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ (68 Ð¼Â²) Ð² MustamÃ¤e. Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð¿Ð¾ Maa-amet: 136 000â€“156 000 â‚¬. Ð¡Ñ‚Ð°Ñ€Ñ‚Ð¾Ð²Ð°Ñ Ñ†ÐµÐ½Ð°: 155 000 â‚¬ (Ð²ÐµÑ€Ñ…Ð½ÑÑ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ð°). ÐŸÑ€Ð¸Ð¼ÐµÐ½ÐµÐ½Ð¸Ðµ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ð¸ Â«Ð´Ð²ÑƒÑ… Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹Â» Ð¸ Ð°Ñ€Ð³ÑƒÐ¼ÐµÐ½Ñ‚Ð°Ñ†Ð¸Ð¸ Ð½Ð° Ð´Ð°Ð½Ð½Ñ‹Ñ… Ð¿Ð¾Ð·Ð²Ð¾Ð»Ð¸Ð»Ð¾ Ð·Ð°ÐºÑ€Ñ‹Ñ‚ÑŒ ÑÐ´ÐµÐ»ÐºÑƒ Ð½Ð° 149 000 â‚¬ (Ð½Ð° 7 000 â‚¬ Ð²Ñ‹ÑˆÐµ Ð¿ÐµÑ€Ð²Ð¾Ð³Ð¾ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»Ñ).',
                'key_takeaways' => ([
                    'ÐšÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð¿Ð¾ Maa-amet: 136 000â€“156 000 â‚¬ (68 Ð¼Â², MustamÃ¤e)',
                    'Ð¡Ñ‚Ð°Ñ€Ñ‚Ð¾Ð²Ð°Ñ Ñ†ÐµÐ½Ð° = 155 000 â‚¬ (Ð²ÐµÑ€Ñ…Ð½ÑÑ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ð°)',
                    'ÐŸÐµÑ€Ð²Ð¾Ðµ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ðµ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»Ñ: 142 000 â‚¬',
                    'Ð¡Ñ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Â«Ð´Ð²ÑƒÑ… Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹Â» + Ð°Ñ€Ð³ÑƒÐ¼ÐµÐ½Ñ‚Ñ‹ Ð¿Ð¾ Ð´Ð°Ð½Ð½Ñ‹Ð¼',
                    'Ð¤Ð¸Ð½Ð°Ð»ÑŒÐ½Ð°Ñ Ñ†ÐµÐ½Ð°: 149 000 â‚¬ (+7 000 â‚¬ Ð¾Ñ‚ Ð¿ÐµÑ€Ð²Ð¾Ð³Ð¾ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ)',
                ]),
                'location_tags' => (['Tallinn', 'MustamÃ¤e']),
                'faq_json' => ($this->audit2FaqRu()),
                'content_blocks' => ([
                    'summary' => '<p>Ð¡Ð¾Ð±ÑÑ‚Ð²ÐµÐ½Ð½Ð¸Ðº 3-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹ Ð² MustamÃ¤e (68 Ð¼Â², 5 ÑÑ‚Ð°Ð¶, ÐºÐ°Ð¿Ñ€ÐµÐ¼Ð¾Ð½Ñ‚ 2019) Ð¾Ð±Ñ€Ð°Ñ‚Ð¸Ð»ÑÑ Ð² CityEE Ð¿Ð¾ÑÐ»Ðµ 45 Ð´Ð½ÐµÐ¹ Ð±ÐµÐ· Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹. ÐœÑ‹ Ð¿ÐµÑ€ÐµÑÑ‡Ð¸Ñ‚Ð°Ð»Ð¸ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€, Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð¸Ñ€Ð¾Ð²Ð°Ð»Ð¸ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð¸ Ð¿Ñ€Ð¸Ð¼ÐµÐ½Ð¸Ð»Ð¸ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÑŽ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð². Ð ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚: +7 000 â‚¬ Ðº Ð¿ÐµÑ€Ð²Ð¾Ð¼Ñƒ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸ÑŽ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»Ñ.</p>',
                    'market_data' => '<div class="audit-stats"><div class="audit-stat"><span class="audit-stat__value">68 Ð¼Â²</span><span class="audit-stat__label">ÐŸÐ»Ð¾Ñ‰Ð°Ð´ÑŒ</span></div><div class="audit-stat"><span class="audit-stat__value">MustamÃ¤e</span><span class="audit-stat__label">Ð Ð°Ð¹Ð¾Ð½</span></div><div class="audit-stat"><span class="audit-stat__value">136â€“156k â‚¬</span><span class="audit-stat__label">ÐšÐ¾Ñ€Ð¸Ð´Ð¾Ñ€</span></div><div class="audit-stat"><span class="audit-stat__value">+7 000 â‚¬</span><span class="audit-stat__label">Ð’Ñ‹Ð¸Ð³Ñ€Ñ‹Ñˆ</span></div></div>',
                    'sections' => [
                        ['heading' => 'Ð­Ñ‚Ð°Ð¿ 1: ÐŸÐµÑ€ÐµÑÑ‡Ñ‘Ñ‚ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°', 'body' => '<p>ÐŸÐ¾ Ð´Ð°Ð½Ð½Ñ‹Ð¼ Maa-amet Ð·Ð° Ð¿Ð¾ÑÐ»ÐµÐ´Ð½Ð¸Ðµ 6 Ð¼ÐµÑÑÑ†ÐµÐ²: 8 Ð°Ð½Ð°Ð»Ð¾Ð³Ð¸Ñ‡Ð½Ñ‹Ñ… ÑÐ´ÐµÐ»Ð¾Ðº Ð² MustamÃ¤e â†’ Ð¼ÐµÐ´Ð¸Ð°Ð½Ð° 2 150 â‚¬/Ð¼Â² â†’ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ 136 000â€“156 000 â‚¬.</p>'],
                        ['heading' => 'Ð­Ñ‚Ð°Ð¿ 2: ÐžÐ¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð°Ñ†Ð¸Ñ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ', 'body' => '<p>ÐÐ¾Ð²Ñ‹Ðµ Ñ„Ð¾Ñ‚Ð¾, Ð´Ð²ÑƒÑÐ·Ñ‹Ñ‡Ð½Ñ‹Ð¹ Ñ‚ÐµÐºÑÑ‚, ÑÐºÐ¾Ñ€Ñ€ÐµÐºÑ‚Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ð°Ñ Ñ†ÐµÐ½Ð° 155 000 â‚¬. Ð—Ð° 10 Ð´Ð½ÐµÐ¹: 4 Ð·Ð°Ð¿Ñ€Ð¾ÑÐ° Ð½Ð° Ð¿Ð¾ÐºÐ°Ð·.</p>'],
                        ['heading' => 'Ð­Ñ‚Ð°Ð¿ 3: Ð¡Ñ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð²', 'body' => '<p>ÐŸÐµÑ€Ð²Ð¾Ðµ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ðµ: 142 000 â‚¬. ÐœÑ‹ Ð½Ðµ ÑÐ¾Ð³Ð»Ð°ÑˆÐ°ÐµÐ¼ÑÑ. ÐÑ€Ð³ÑƒÐ¼ÐµÐ½Ñ‚: Ð´Ð°Ð½Ð½Ñ‹Ðµ Maa-amet + Ð²Ñ‚Ð¾Ñ€Ð¾Ð¹ Ð·Ð°Ð¸Ð½Ñ‚ÐµÑ€ÐµÑÐ¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑŒ. Ð’Ñ‚Ð¾Ñ€Ð¾Ðµ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ðµ: 146 000 â‚¬. ÐšÐ¾Ð½Ñ‚Ñ€Ð°Ñ€Ð³ÑƒÐ¼ÐµÐ½Ñ‚: Ñ€ÐµÐ¼Ð¾Ð½Ñ‚ 2019, ÑÐ½ÐµÑ€Ð³Ð¾ÐºÐ»Ð°ÑÑ. Ð¤Ð¸Ð½Ð°Ð»ÑŒÐ½Ð¾Ðµ: 149 000 â‚¬.</p>'],
                    ],
                    'cta' => ['heading' => 'Ð¥Ð¾Ñ‚Ð¸Ñ‚Ðµ Ñ‚Ð°ÐºÑƒÑŽ Ð¶Ðµ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÑŽ?', 'text' => 'Ð‘ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ñ€Ð°ÑÑ‡Ñ‘Ñ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð¸ Ð¿Ð»Ð°Ð½ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð² Ð·Ð° 24 Ñ‡Ð°ÑÐ°.', 'button' => 'ÐŸÐ¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÑŽ'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'Hinnakoridor + lÃ¤birÃ¤Ã¤kimisstrateegia: 3-toalise analÃ¼Ã¼s MustamÃ¤el',
                'excerpt' => 'Kuidas leidsime tÃ¤pse koridori ja kaublesime mÃ¼Ã¼jale +7 000 â‚¬. Tegelikud numbrid.',
                'meta_title' => 'Hinnakoridor ja lÃ¤birÃ¤Ã¤kimised â€” analÃ¼Ã¼s | CityEE',
                'meta_description' => 'Tegelik analÃ¼Ã¼s: 3-toalise hinnakoridor MustamÃ¤el + lÃ¤birÃ¤Ã¤kimisstrateegia = +7 000 â‚¬ mÃ¼Ã¼jale.',
                'ai_summary' => '3-toalise korteri mÃ¼Ã¼gianalÃ¼Ã¼s MustamÃ¤el (68 mÂ²). Maa-ameti hinnakoridor: 136 000â€“156 000 â‚¬. Kahe ostja strateegia andis +7 000 â‚¬ esimesest pakkumisest.',
                'key_takeaways' => ([
                    'Maa-ameti koridor: 136 000â€“156 000 â‚¬ (68 mÂ²)',
                    'Esimene pakkumine: 142 000 â‚¬',
                    'LÃµpphind: 149 000 â‚¬ (+7 000 â‚¬)',
                ]),
                'location_tags' => (['Tallinn', 'MustamÃ¤e']),
                'faq_json' => ($this->audit2FaqEt()),
                'content_blocks' => ([
                    'summary' => '<p>3-toalise korteri omanik MustamÃ¤el pÃ¶Ã¶rdus CityEE poole pÃ¤rast 45 pÃ¤eva ilma pakkumisteta. Tulemus: +7 000 â‚¬.</p>',
                    'sections' => [
                        ['heading' => '1. etapp: Hinnakoridori Ã¼mberarvutus', 'body' => '<p>Maa-ameti andmed: 8 tehingut â†’ mediaan 2 150 â‚¬/mÂ² â†’ koridor 136 000â€“156 000 â‚¬.</p>'],
                        ['heading' => '2. etapp: LÃ¤birÃ¤Ã¤kimised', 'body' => '<p>Esimene pakkumine 142 000 â‚¬. LÃµpphind 149 000 â‚¬.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite sama strateegiat?', 'text' => 'Tasuta koridori arvutus ja lÃ¤birÃ¤Ã¤kimisplaan 24 tunniga.', 'button' => 'Saa strateegia'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => 'Price Corridor + Negotiation Strategy: 3-Room Case Study in MustamÃ¤e',
                'excerpt' => 'How we found the exact corridor and negotiated +7,000 â‚¬ for the seller. Real numbers and strategy.',
                'meta_title' => 'Price Corridor & Negotiations â€” Case Study | CityEE',
                'meta_description' => 'Real case study: 3-room price corridor in MustamÃ¤e + negotiation strategy = +7,000 â‚¬ for the seller.',
                'ai_summary' => 'Sale analysis of a 3-room apartment (68 sqm) in MustamÃ¤e. Maa-amet corridor: 136,000â€“156,000 â‚¬. The "two buyers" strategy yielded +7,000 â‚¬ above the first offer.',
                'key_takeaways' => ([
                    'Maa-amet corridor: 136,000â€“156,000 â‚¬ (68 sqm)',
                    'First offer: 142,000 â‚¬',
                    'Final price: 149,000 â‚¬ (+7,000 â‚¬)',
                ]),
                'location_tags' => (['Tallinn', 'MustamÃ¤e']),
                'faq_json' => ($this->audit2FaqEn()),
                'content_blocks' => ([
                    'summary' => '<p>Owner of a 3-room apartment in MustamÃ¤e came to CityEE after 45 days without offers. Result: +7,000 â‚¬.</p>',
                    'sections' => [
                        ['heading' => 'Stage 1: Price Corridor Recalculation', 'body' => '<p>Maa-amet data: 8 transactions â†’ median 2,150 â‚¬/sqm â†’ corridor 136,000â€“156,000 â‚¬.</p>'],
                        ['heading' => 'Stage 2: Negotiation', 'body' => '<p>First offer 142,000 â‚¬. Final price 149,000 â‚¬.</p>'],
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
            'related_guide_slugs'  => (['30-45-day-sales-plan', 'sell-apartment-without-losing-money']),
            'related_audit_slugs'  => (['price-corridor-negotiation-strategy']),
            'service_link_key' => 'sell',
        ];

        return [
            array_merge($base, [
                'locale' => 'ru',
                'title' => 'ÐŸÐ»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹: Ñ€Ð°Ð·Ð±Ð¾Ñ€ 1-ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ð½Ð¾Ð¹ Ð² LasnamÃ¤e',
                'excerpt' => 'ÐšÐ°Ðº Ð¼Ñ‹ Ð¿Ñ€Ð¾Ð´Ð°Ð»Ð¸ ÑÑ‚ÑƒÐ´Ð¸ÑŽ 28 Ð¼Â² Ð·Ð° 38 Ð´Ð½ÐµÐ¹ Ð¿Ð¾ Ð²ÐµÑ€Ñ…Ð½ÐµÐ¹ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ðµ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°. ÐŸÐ¾Ð»Ð½Ñ‹Ð¹ Ñ€Ð°Ð·Ð±Ð¾Ñ€ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ð¸.',
                'meta_title' => 'ÐŸÐ»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ 30â€“45 Ð´Ð½ÐµÐ¹ â€” Ñ€Ð°Ð·Ð±Ð¾Ñ€ | CityEE',
                'meta_description' => 'Ð Ð°Ð·Ð±Ð¾Ñ€: Ð¿Ð»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÑÑ‚ÑƒÐ´Ð¸Ð¸ Ð² LasnamÃ¤e Ð·Ð° 38 Ð´Ð½ÐµÐ¹. ÐŸÐ¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° â†’ KV.ee â†’ Ð¿Ð¾ÐºÐ°Ð·Ñ‹ â†’ ÑÐ´ÐµÐ»ÐºÐ°.',
                'ai_summary' => 'Ð Ð°Ð·Ð±Ð¾Ñ€ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ ÑÑ‚ÑƒÐ´Ð¸Ð¸ 28 Ð¼Â² Ð² LasnamÃ¤e Ð¿Ð¾ Ð¿Ð»Ð°Ð½Ñƒ Â«30â€“45 Ð´Ð½ÐµÐ¹Â». Ð¦ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€: 56 000â€“68 000 â‚¬. Ð’Ñ‹ÑÑ‚Ð°Ð²Ð»ÐµÐ½Ð° Ð·Ð° 67 000 â‚¬. ÐŸÑ€Ð¾Ð´Ð°Ð½Ð° Ð·Ð° 65 500 â‚¬ Ñ‡ÐµÑ€ÐµÐ· 38 Ð´Ð½ÐµÐ¹ â€” Ñ‚Ð¾Ñ‡Ð½Ð¾ Ð¿Ð¾ Ð¿Ð»Ð°Ð½Ñƒ. ÐšÐ»ÑŽÑ‡ÐµÐ²Ñ‹Ðµ Ñ„Ð°ÐºÑ‚Ð¾Ñ€Ñ‹: Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð°Ñ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° Ð·Ð° 5 Ð´Ð½ÐµÐ¹, Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð² Ð¾Ð¿Ñ‚Ð¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ðµ Ð²Ñ€ÐµÐ¼Ñ, 6 Ð¿Ð¾ÐºÐ°Ð·Ð¾Ð² Ð·Ð° 2 Ð½ÐµÐ´ÐµÐ»Ð¸, Ð·Ð°ÐºÑ€Ñ‹Ñ‚Ð¸Ðµ Ñ Ð¿ÐµÑ€Ð²Ñ‹Ð¼ ÑÐµÑ€ÑŒÑ‘Ð·Ð½Ñ‹Ð¼ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¼.',
                'key_takeaways' => ([
                    'ÐšÐ¾Ñ€Ð¸Ð´Ð¾Ñ€: 56 000â€“68 000 â‚¬ (28 Ð¼Â², LasnamÃ¤e)',
                    'Ð¡Ñ‚Ð°Ñ€Ñ‚Ð¾Ð²Ð°Ñ Ñ†ÐµÐ½Ð°: 67 000 â‚¬ â†’ Ñ„Ð¸Ð½Ð°Ð»ÑŒÐ½Ð°Ñ: 65 500 â‚¬',
                    'Ð¡Ñ€Ð¾Ðº Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸: 38 Ð´Ð½ÐµÐ¹ (Ð¿Ð»Ð°Ð½: 30â€“45)',
                    '5 Ð´Ð½ÐµÐ¹ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ¸, 6 Ð¿Ð¾ÐºÐ°Ð·Ð¾Ð², 2 Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ',
                    'ÐœÐ¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ð·Ð°Ñ‚Ñ€Ð°Ñ‚Ñ‹ Ð½Ð° Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÑƒ: 350 â‚¬',
                ]),
                'location_tags' => (['Tallinn', 'LasnamÃ¤e']),
                'faq_json' => ($this->audit3FaqRu()),
                'content_blocks' => ([
                    'summary' => '<p>Ð¡Ð¾Ð±ÑÑ‚Ð²ÐµÐ½Ð½Ð¸Ðº ÑÑ‚ÑƒÐ´Ð¸Ð¸ (28 Ð¼Â², LasnamÃ¤e, 9 ÑÑ‚Ð°Ð¶, Ð¾Ð±Ð½Ð¾Ð²Ð»Ñ‘Ð½Ð½Ñ‹Ð¹ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚) Ñ…Ð¾Ñ‚ÐµÐ» Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ Â«ÐºÐ°Ðº Ð¼Ð¾Ð¶Ð½Ð¾ Ð±Ñ‹ÑÑ‚Ñ€ÐµÐµÂ». ÐœÑ‹ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶Ð¸Ð»Ð¸ Ð¿Ð»Ð°Ð½ Â«30â€“45 Ð´Ð½ÐµÐ¹Â» â€” Ð¸ Ð²Ñ‹Ð¿Ð¾Ð»Ð½Ð¸Ð»Ð¸ ÐµÐ³Ð¾: Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð° Ð·Ð° 38 Ð´Ð½ÐµÐ¹ Ð¿Ð¾ 65 500 â‚¬.</p>',
                    'market_data' => '<div class="audit-stats"><div class="audit-stat"><span class="audit-stat__value">28 Ð¼Â²</span><span class="audit-stat__label">ÐŸÐ»Ð¾Ñ‰Ð°Ð´ÑŒ</span></div><div class="audit-stat"><span class="audit-stat__value">LasnamÃ¤e</span><span class="audit-stat__label">Ð Ð°Ð¹Ð¾Ð½</span></div><div class="audit-stat"><span class="audit-stat__value">65 500 â‚¬</span><span class="audit-stat__label">Ð¦ÐµÐ½Ð° ÑÐ´ÐµÐ»ÐºÐ¸</span></div><div class="audit-stat"><span class="audit-stat__value">38 Ð´Ð½ÐµÐ¹</span><span class="audit-stat__label">Ð¡Ñ€Ð¾Ðº</span></div></div>',
                    'sections' => [
                        ['heading' => 'Ð”Ð½Ð¸ 1â€“5: ÐŸÐ¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°', 'body' => '<p>Ð Ð°ÑÑ‡Ñ‘Ñ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°: 56 000â€“68 000 â‚¬. Decluttering + ÑƒÐ±Ð¾Ñ€ÐºÐ°: 150 â‚¬. Ð¤Ð¾Ñ‚Ð¾ÑÑŠÑ‘Ð¼ÐºÐ°: 200 â‚¬. Ð˜Ñ‚Ð¾Ð³Ð¾ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°: 350 â‚¬.</p>'],
                        ['heading' => 'Ð”Ð½Ð¸ 6â€“7: ÐŸÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ', 'body' => '<p>KV.ee Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð² ÑÑ€ÐµÐ´Ñƒ ÑƒÑ‚Ñ€Ð¾Ð¼. ÐŸÑ€ÐµÐ¼Ð¸ÑƒÐ¼-Ð¿Ð°ÐºÐµÑ‚ Ð½Ð° 14 Ð´Ð½ÐµÐ¹. Ð¦ÐµÐ½Ð°: 67 000 â‚¬.</p>'],
                        ['heading' => 'Ð”Ð½Ð¸ 8â€“28: ÐŸÐ¾ÐºÐ°Ð·Ñ‹', 'body' => '<p>6 Ð¿Ð¾ÐºÐ°Ð·Ð¾Ð² Ð·Ð° 3 Ð½ÐµÐ´ÐµÐ»Ð¸. 2 ÑÐµÑ€ÑŒÑ‘Ð·Ð½Ñ‹Ñ… Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ: 63 000 â‚¬ Ð¸ 64 500 â‚¬. ÐšÐ¾Ð½Ñ‚Ñ€Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ðµ: 65 500 â‚¬.</p>'],
                        ['heading' => 'Ð”Ð½Ð¸ 29â€“38: Ð—Ð°ÐºÑ€Ñ‹Ñ‚Ð¸Ðµ', 'body' => '<p>ÐŸÑ€ÐµÐ´Ð²Ð°Ñ€Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€ â†’ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÐ° Ð¾Ð±Ñ€ÐµÐ¼ÐµÐ½ÐµÐ½Ð¸Ð¹ â†’ Ð½Ð¾Ñ‚Ð°Ñ€Ð¸ÑƒÑ. Ð¡Ð´ÐµÐ»ÐºÐ° Ð·Ð°ÐºÑ€Ñ‹Ñ‚Ð° Ð½Ð° 38-Ð¹ Ð´ÐµÐ½ÑŒ.</p>'],
                    ],
                    'cta' => ['heading' => 'Ð¥Ð¾Ñ‚Ð¸Ñ‚Ðµ Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹?', 'text' => 'Ð‘ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ð°Ð½Ð°Ð»Ð¸Ð· Ð²Ð°ÑˆÐµÐ³Ð¾ Ð¾Ð±ÑŠÐµÐºÑ‚Ð° Ð¸ Ð¿Ð»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ Ð·Ð° 24 Ñ‡Ð°ÑÐ°.', 'button' => 'ÐŸÐ¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ð¿Ð»Ð°Ð½'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'et',
                'title' => 'MÃ¼Ã¼giplaan 30â€“45 pÃ¤eva: 1-toalise analÃ¼Ã¼s LasnamÃ¤el',
                'excerpt' => 'Kuidas mÃ¼Ã¼sime stuudio 28 mÂ² 38 pÃ¤evaga koridori Ã¼lemise piiri juures. TÃ¤ielik strateegia.',
                'meta_title' => 'MÃ¼Ã¼giplaan 30â€“45 pÃ¤eva â€” analÃ¼Ã¼s | CityEE',
                'meta_description' => 'AnalÃ¼Ã¼s: stuudio mÃ¼Ã¼giplaan LasnamÃ¤el 38 pÃ¤evaga. Ettevalmistus â†’ KV.ee â†’ nÃ¤itamised â†’ tehing.',
                'ai_summary' => 'Stuudio (28 mÂ²) mÃ¼Ã¼gianalÃ¼Ã¼s LasnamÃ¤el plaaniga "30â€“45 pÃ¤eva". Koridor: 56 000â€“68 000 â‚¬. MÃ¼Ã¼dud 65 500 â‚¬-ga 38 pÃ¤evaga.',
                'key_takeaways' => ([
                    'Koridor: 56 000â€“68 000 â‚¬ (28 mÂ², LasnamÃ¤e)',
                    'Stardihind: 67 000 â‚¬ â†’ lÃµpphind: 65 500 â‚¬',
                    'MÃ¼Ã¼giaeg: 38 pÃ¤eva (plaan: 30â€“45)',
                ]),
                'location_tags' => (['Tallinn', 'LasnamÃ¤e']),
                'faq_json' => ($this->audit3FaqEt()),
                'content_blocks' => ([
                    'summary' => '<p>Stuudio omanik (28 mÂ², LasnamÃ¤e) soovis mÃ¼Ã¼a kiiresti. CityEE plaan "30â€“45 pÃ¤eva" â€” mÃ¼Ã¼dud 38 pÃ¤evaga 65 500 â‚¬ eest.</p>',
                    'sections' => [
                        ['heading' => 'PÃ¤evad 1â€“5: Ettevalmistus', 'body' => '<p>Koridori arvutus, decluttering, fotosessioon. Kokku: 350 â‚¬.</p>'],
                        ['heading' => 'PÃ¤evad 6â€“38: MÃ¼Ã¼k', 'body' => '<p>KV.ee avaldamine, 6 nÃ¤itamist, 2 pakkumist, tehing.</p>'],
                    ],
                    'cta' => ['heading' => 'Soovite mÃ¼Ã¼a 30â€“45 pÃ¤evaga?', 'text' => 'Tasuta analÃ¼Ã¼s ja mÃ¼Ã¼giplaan 24 tunniga.', 'button' => 'Saa plaan'],
                ]),
            ]),
            array_merge($base, [
                'locale' => 'en',
                'title' => '30â€“45 Day Sales Plan: Studio Case Study in LasnamÃ¤e',
                'excerpt' => 'How we sold a 28 sqm studio in 38 days at the upper corridor boundary. Full strategy breakdown.',
                'meta_title' => '30â€“45 Day Sales Plan â€” Case Study | CityEE',
                'meta_description' => 'Case study: studio sales plan in LasnamÃ¤e in 38 days. Preparation â†’ KV.ee â†’ showings â†’ closing.',
                'ai_summary' => 'Sale analysis of a 28 sqm studio in LasnamÃ¤e using the "30â€“45 day" plan. Corridor: 56,000â€“68,000 â‚¬. Sold for 65,500 â‚¬ in 38 days.',
                'key_takeaways' => ([
                    'Corridor: 56,000â€“68,000 â‚¬ (28 sqm, LasnamÃ¤e)',
                    'Starting price: 67,000 â‚¬ â†’ final: 65,500 â‚¬',
                    'Selling time: 38 days (plan: 30â€“45)',
                ]),
                'location_tags' => (['Tallinn', 'LasnamÃ¤e']),
                'faq_json' => ($this->audit3FaqEn()),
                'content_blocks' => ([
                    'summary' => '<p>Studio owner (28 sqm, LasnamÃ¤e) wanted to sell fast. CityEE "30â€“45 day" plan â€” sold in 38 days for 65,500 â‚¬.</p>',
                    'sections' => [
                        ['heading' => 'Days 1â€“5: Preparation', 'body' => '<p>Corridor calculation, decluttering, photo session. Total: 350 â‚¬.</p>'],
                        ['heading' => 'Days 6â€“38: Sale', 'body' => '<p>KV.ee publication, 6 showings, 2 offers, closing.</p>'],
                    ],
                    'cta' => ['heading' => 'Want to sell in 30â€“45 days?', 'text' => 'Free analysis and sales plan within 24 hours.', 'button' => 'Get Plan'],
                ]),
            ]),
        ];
    }

    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•
    //  FAQ DATA (8-10 items per guide/audit per locale)
    // â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•â•

    // â”€â”€â”€â”€ Guide 1 FAQ â”€â”€â”€â”€

    private function guide1FaqRu(): array
    {
        return [
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ ÑÑ‚Ð¾Ð¸Ñ‚ Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ñ‡ÐµÑ€ÐµÐ· Ð¼Ð°ÐºÐ»ÐµÑ€Ð°?', 'answer' => 'ÐšÐ¾Ð¼Ð¸ÑÑÐ¸Ñ Ð¼Ð°ÐºÐ»ÐµÑ€Ð° Ð² Ð­ÑÑ‚Ð¾Ð½Ð¸Ð¸ Ð¾Ð±Ñ‹Ñ‡Ð½Ð¾ 3â€“4% Ð¾Ñ‚ Ñ†ÐµÐ½Ñ‹ ÑÐ´ÐµÐ»ÐºÐ¸. ÐÐ¾ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ñ‹Ð¹ Ð¼Ð°ÐºÐ»ÐµÑ€ Ð¿Ð¾Ð¼Ð¾Ð³Ð°ÐµÑ‚ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ð½Ð° 5â€“15% Ð±Ð¾Ð»ÑŒÑˆÐµ â€” Ñ‚.Ðµ. Ð¾ÐºÑƒÐ¿Ð°ÐµÑ‚ÑÑ Ð¼Ð½Ð¾Ð³Ð¾ÐºÑ€Ð°Ñ‚Ð½Ð¾.'],
            ['question' => 'ÐœÐ¾Ð¶Ð½Ð¾ Ð»Ð¸ Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ ÑÐ°Ð¼Ð¾ÑÑ‚Ð¾ÑÑ‚ÐµÐ»ÑŒÐ½Ð¾?', 'answer' => 'Ð”Ð°, Ð½Ð¾ Ð¿Ð¾ ÑÑ‚Ð°Ñ‚Ð¸ÑÑ‚Ð¸ÐºÐµ ÑÐ°Ð¼Ð¾ÑÑ‚Ð¾ÑÑ‚ÐµÐ»ÑŒÐ½Ñ‹Ðµ Ð¿Ñ€Ð¾Ð´Ð°Ð²Ñ†Ñ‹ Ð² ÑÑ€ÐµÐ´Ð½ÐµÐ¼ Ð¿Ð¾Ð»ÑƒÑ‡Ð°ÑŽÑ‚ Ð½Ð° 5â€“15 000 â‚¬ Ð¼ÐµÐ½ÑŒÑˆÐµ Ð¸Ð·-Ð·Ð° Ð¾ÑˆÐ¸Ð±Ð¾Ðº Ð² Ñ†ÐµÐ½Ð¾Ð¾Ð±Ñ€Ð°Ð·Ð¾Ð²Ð°Ð½Ð¸Ð¸ Ð¸ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð°Ñ….'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ Ð²Ñ€ÐµÐ¼ÐµÐ½Ð¸ Ð·Ð°Ð½Ð¸Ð¼Ð°ÐµÑ‚ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð° ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹?', 'answer' => 'Ð’ ÑÑ€ÐµÐ´Ð½ÐµÐ¼ 60â€“90 Ð´Ð½ÐµÐ¹. Ð¡ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð¾Ð¹ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÐµÐ¹ CityEE â€” 30â€“45 Ð´Ð½ÐµÐ¹.'],
            ['question' => 'ÐšÐ°ÐºÐ¸Ðµ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ñ‹ Ð½ÑƒÐ¶Ð½Ñ‹ Ð´Ð»Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸?', 'answer' => 'Ð’Ñ‹Ð¿Ð¸ÑÐºÐ° Ð¸Ð· Kinnistusraamat (Ð·ÐµÐ¼ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ñ€ÐµÐ³Ð¸ÑÑ‚Ñ€), ÑÐ½ÐµÑ€Ð³Ð¾ÑÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚, Ð¿Ð»Ð°Ð½ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹, Ð´Ð°Ð½Ð½Ñ‹Ðµ Ð¾ ÐºÐ¾Ð¼Ð¼ÑƒÐ½Ð°Ð»ÑŒÐ½Ñ‹Ñ… Ð¿Ð»Ð°Ñ‚ÐµÐ¶Ð°Ñ….'],
            ['question' => 'ÐÑƒÐ¶ÐµÐ½ Ð»Ð¸ ÑÐ½ÐµÑ€Ð³Ð¾ÑÐµÑ€Ñ‚Ð¸Ñ„Ð¸ÐºÐ°Ñ‚?', 'answer' => 'Ð”Ð°, ÑÑ‚Ð¾ Ð¾Ð±ÑÐ·Ð°Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚ Ð´Ð»Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸ Ð² Ð­ÑÑ‚Ð¾Ð½Ð¸Ð¸. Ð¡Ñ‚Ð¾Ð¸Ð¼Ð¾ÑÑ‚ÑŒ: 100â€“200 â‚¬, ÑÑ€Ð¾Ðº Ð¸Ð·Ð³Ð¾Ñ‚Ð¾Ð²Ð»ÐµÐ½Ð¸Ñ 3â€“5 Ð´Ð½ÐµÐ¹.'],
            ['question' => 'ÐšÐ¾Ð³Ð´Ð° Ð»ÑƒÑ‡ÑˆÐµ Ð²ÑÐµÐ³Ð¾ Ð¿Ñ€Ð¾Ð´Ð°Ð²Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ?', 'answer' => 'Ð’ÐµÑÐ½Ð° (Ð¼Ð°Ñ€Ñ‚â€“Ð¼Ð°Ð¹) Ð¸ Ð¾ÑÐµÐ½ÑŒ (ÑÐµÐ½Ñ‚ÑÐ±Ñ€ÑŒâ€“Ð½Ð¾ÑÐ±Ñ€ÑŒ) â€” Ð¿Ð¸ÐºÐ¾Ð²Ñ‹Ðµ ÑÐµÐ·Ð¾Ð½Ñ‹. ÐÐ¾ Ñ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð¾Ð¹ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÐµÐ¹ Ð¼Ð¾Ð¶Ð½Ð¾ Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ Ð² Ð»ÑŽÐ±Ð¾Ðµ Ð²Ñ€ÐµÐ¼Ñ.'],
            ['question' => 'ÐšÐ°Ðº Ð¾Ð¿Ñ€ÐµÐ´ÐµÐ»Ð¸Ñ‚ÑŒ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½ÑƒÑŽ Ñ†ÐµÐ½Ñƒ?', 'answer' => 'Ð˜ÑÐ¿Ð¾Ð»ÑŒÐ·ÑƒÐ¹Ñ‚Ðµ Ð¼ÐµÑ‚Ð¾Ð´ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°: Ð°Ð½Ð°Ð»Ð¸Ð· Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ñ… ÑÐ´ÐµÐ»Ð¾Ðº Maa-amet Ð·Ð° 6 Ð¼ÐµÑÑÑ†ÐµÐ² Ð² Ð²Ð°ÑˆÐµÐ¼ Ñ€Ð°Ð¹Ð¾Ð½Ðµ. ÐÐ• Ð¾Ñ€Ð¸ÐµÐ½Ñ‚Ð¸Ñ€ÑƒÐ¹Ñ‚ÐµÑÑŒ Ð½Ð° Ñ†ÐµÐ½Ñ‹ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ð¹.'],
            ['question' => 'Ð¡Ñ‚Ð¾Ð¸Ñ‚ Ð»Ð¸ Ð´ÐµÐ»Ð°Ñ‚ÑŒ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚ Ð¿ÐµÑ€ÐµÐ´ Ð¿Ñ€Ð¾Ð´Ð°Ð¶ÐµÐ¹?', 'answer' => 'ÐŸÐ¾Ð»Ð½Ñ‹Ð¹ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚ Ð½Ðµ Ð¾ÐºÑƒÐ¿Ð°ÐµÑ‚ÑÑ. ÐÐ¾ Ð¼Ð¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ð°Ñ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° (ÑƒÐ±Ð¾Ñ€ÐºÐ°, Ð¼ÐµÐ»ÐºÐ¸Ðµ Ð¿Ð¾Ñ‡Ð¸Ð½ÐºÐ¸, staging): Ð²Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ 200â€“500 â‚¬ â†’ Ð²Ð¾Ð·Ð²Ñ€Ð°Ñ‚ 1 000â€“3 000 â‚¬.'],
            ['question' => 'Ð§Ñ‚Ð¾ Ñ‚Ð°ÐºÐ¾Ðµ Ð¿Ñ€ÐµÐ´Ð²Ð°Ñ€Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€?', 'answer' => 'Ð®Ñ€Ð¸Ð´Ð¸Ñ‡ÐµÑÐºÐ¸ Ð¾Ð±ÑÐ·Ñ‹Ð²Ð°ÑŽÑ‰Ð¸Ð¹ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚ Ð¿ÐµÑ€ÐµÐ´ Ð½Ð¾Ñ‚Ð°Ñ€Ð¸Ð°Ð»ÑŒÐ½Ð¾Ð¹ ÑÐ´ÐµÐ»ÐºÐ¾Ð¹. Ð¤Ð¸ÐºÑÐ¸Ñ€ÑƒÐµÑ‚ Ñ†ÐµÐ½Ñƒ, ÑÑ€Ð¾ÐºÐ¸ Ð¸ ÑƒÑÐ»Ð¾Ð²Ð¸Ñ. ÐžÐ±Ñ‹Ñ‡Ð½Ð¾ Ñ Ð·Ð°Ð´Ð°Ñ‚ÐºÐ¾Ð¼ 5â€“10%.'],
            ['question' => 'ÐšÑ‚Ð¾ Ð¿Ð»Ð°Ñ‚Ð¸Ñ‚ Ð½Ð¾Ñ‚Ð°Ñ€Ð¸Ð°Ð»ÑŒÐ½Ñ‹Ðµ Ñ€Ð°ÑÑ…Ð¾Ð´Ñ‹?', 'answer' => 'Ð’ Ð­ÑÑ‚Ð¾Ð½Ð¸Ð¸ Ð¿Ð¾ ÑƒÐ¼Ð¾Ð»Ñ‡Ð°Ð½Ð¸ÑŽ â€” Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑŒ. ÐÐ¾Ñ‚Ð°Ñ€Ð¸Ð°Ð»ÑŒÐ½Ñ‹Ð¹ ÑÐ±Ð¾Ñ€: 0.1â€“0.5% Ð¾Ñ‚ Ñ†ÐµÐ½Ñ‹ ÑÐ´ÐµÐ»ÐºÐ¸ + Ð³Ð¾ÑÑƒÐ´Ð°Ñ€ÑÑ‚Ð²ÐµÐ½Ð½Ð°Ñ Ð¿Ð¾ÑˆÐ»Ð¸Ð½Ð°.'],
        ];
    }

    private function guide1FaqEt(): array
    {
        return [
            ['question' => 'Kui palju maksab korteri mÃ¼Ã¼k maakleri kaudu?', 'answer' => 'Maakleri tasu Eestis on tavaliselt 3â€“4% tehingu hinnast. Ã•ige maakler aitab saada 5â€“15% rohkem.'],
            ['question' => 'Kas ma saan ise korterit mÃ¼Ã¼a?', 'answer' => 'Jah, aga statistiliselt saavad iseseisvad mÃ¼Ã¼jad keskmiselt 5â€“15 000 â‚¬ vÃ¤hem.'],
            ['question' => 'Kui kaua vÃµtab korteri mÃ¼Ã¼k aega?', 'answer' => 'Keskmiselt 60â€“90 pÃ¤eva. CityEE strateegiaga â€” 30â€“45 pÃ¤eva.'],
            ['question' => 'Millised dokumendid on mÃ¼Ã¼giks vajalikud?', 'answer' => 'Kinnistusraamatu vÃ¤ljavÃµte, energiamÃ¤rgis, korteri plaan, kommunaalarvete andmed.'],
            ['question' => 'Kas energiamÃ¤rgis on kohustuslik?', 'answer' => 'Jah, see on Eestis mÃ¼Ã¼giks kohustuslik dokument. Hind: 100â€“200 â‚¬, valmistamine 3â€“5 pÃ¤eva.'],
            ['question' => 'Millal on parim aeg korterit mÃ¼Ã¼a?', 'answer' => 'Kevad (mÃ¤rtsâ€“mai) ja sÃ¼gis (septemberâ€“november) on tippperioodid.'],
            ['question' => 'Kuidas mÃ¤Ã¤rata Ãµige hind?', 'answer' => 'Kasutage hinnakoridori meetodit: Maa-ameti tehingute analÃ¼Ã¼s viimase 6 kuu jooksul.'],
            ['question' => 'Kas enne mÃ¼Ã¼ki tasub remonti teha?', 'answer' => 'TÃ¤isremont ei tasu end Ã¤ra. Aga minimaalne ettevalmistus (koristus, vÃ¤iksed parandused): 200â€“500 â‚¬ â†’ tagasi 1 000â€“3 000 â‚¬.'],
        ];
    }

    private function guide1FaqEn(): array
    {
        return [
            ['question' => 'How much does it cost to sell through a broker?', 'answer' => 'Broker commission in Estonia is typically 3â€“4% of the deal price. A good broker helps get 5â€“15% more.'],
            ['question' => 'Can I sell my apartment myself?', 'answer' => 'Yes, but statistically independent sellers get 5â€“15,000 â‚¬ less on average.'],
            ['question' => 'How long does it take to sell?', 'answer' => 'On average 60â€“90 days. With CityEE strategy â€” 30â€“45 days.'],
            ['question' => 'What documents are needed?', 'answer' => 'Land registry excerpt, energy certificate, apartment plan, utility bill data.'],
            ['question' => 'Is an energy certificate mandatory?', 'answer' => 'Yes, it\'s mandatory in Estonia. Cost: 100â€“200 â‚¬, delivery 3â€“5 business days.'],
            ['question' => 'When is the best time to sell?', 'answer' => 'Spring (Marchâ€“May) and autumn (Septemberâ€“November) are peak seasons.'],
            ['question' => 'How to set the right price?', 'answer' => 'Use the price corridor method: analyze real Maa-amet transactions from the past 6 months in your area.'],
            ['question' => 'Should I renovate before selling?', 'answer' => 'Full renovation doesn\'t pay off. But minimal preparation (cleaning, minor fixes): invest 200â€“500 â‚¬ â†’ return 1,000â€“3,000 â‚¬.'],
        ];
    }

    // â”€â”€â”€â”€ Guide 2 FAQ â”€â”€â”€â”€

    private function guide2FaqRu(): array
    {
        return [
            ['question' => 'Ð§Ñ‚Ð¾ Ñ‚Ð°ÐºÐ¾Ðµ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð¹ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€?', 'answer' => 'Ð”Ð¸Ð°Ð¿Ð°Ð·Ð¾Ð½ Ð¼ÐµÐ¶Ð´Ñƒ Ð¼Ð¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ð¸ Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½Ð¾Ð¹ Ñ€ÐµÐ°Ð»ÑŒÐ½Ð¾Ð¹ Ñ†ÐµÐ½Ð¾Ð¹ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸, Ð¾ÑÐ½Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹ Ð½Ð° Ð·Ð°Ð²ÐµÑ€ÑˆÑ‘Ð½Ð½Ñ‹Ñ… ÑÐ´ÐµÐ»ÐºÐ°Ñ… Maa-amet Ð·Ð° Ð¿Ð¾ÑÐ»ÐµÐ´Ð½Ð¸Ðµ 6 Ð¼ÐµÑÑÑ†ÐµÐ².'],
            ['question' => 'Ð“Ð´Ðµ Ð½Ð°Ð¹Ñ‚Ð¸ Ð´Ð°Ð½Ð½Ñ‹Ðµ Ð¾ Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ñ… ÑÐ´ÐµÐ»ÐºÐ°Ñ…?', 'answer' => 'ÐÐ° ÑÐ°Ð¹Ñ‚Ðµ Maa-amet: maaamet.ee/kinnisvara/hinnast â€” Ð³Ð¾ÑÑƒÐ´Ð°Ñ€ÑÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ñ€ÐµÐµÑÑ‚Ñ€ Ð²ÑÐµÑ… ÑÐ´ÐµÐ»Ð¾Ðº Ñ Ð½ÐµÐ´Ð²Ð¸Ð¶Ð¸Ð¼Ð¾ÑÑ‚ÑŒÑŽ Ð² Ð­ÑÑ‚Ð¾Ð½Ð¸Ð¸.'],
            ['question' => 'ÐŸÐ¾Ñ‡ÐµÐ¼Ñƒ Ð½ÐµÐ»ÑŒÐ·Ñ Ð¾Ñ€Ð¸ÐµÐ½Ñ‚Ð¸Ñ€Ð¾Ð²Ð°Ñ‚ÑŒÑÑ Ð½Ð° Ñ†ÐµÐ½Ñ‹ KV.ee?', 'answer' => 'Ð¦ÐµÐ½Ñ‹ Ð½Ð° KV.ee â€” ÑÑ‚Ð¾ Â«wish priceÂ» Ð¿Ñ€Ð¾Ð´Ð°Ð²Ñ†Ð¾Ð². Ð ÐµÐ°Ð»ÑŒÐ½Ñ‹Ðµ ÑÐ´ÐµÐ»ÐºÐ¸ Ð¾Ð±Ñ‹Ñ‡Ð½Ð¾ Ð½Ð° 5â€“15% Ð½Ð¸Ð¶Ðµ.'],
            ['question' => 'ÐšÐ°Ðº Ñ‡Ð°ÑÑ‚Ð¾ Ð¿ÐµÑ€ÐµÑÑ‡Ð¸Ñ‚Ñ‹Ð²Ð°Ñ‚ÑŒ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€?', 'answer' => 'ÐšÐ°Ð¶Ð´Ñ‹Ðµ 2â€“3 Ð¼ÐµÑÑÑ†Ð° Ð¸Ð»Ð¸ Ð¿Ñ€Ð¸ Ð·Ð½Ð°Ñ‡Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ñ… Ð¸Ð·Ð¼ÐµÐ½ÐµÐ½Ð¸ÑÑ… Ñ€Ñ‹Ð½ÐºÐ°. Ð•ÑÐ»Ð¸ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð²Ð¸ÑÐ¸Ñ‚ 14+ Ð´Ð½ÐµÐ¹ Ð±ÐµÐ· Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹ â€” Ð¿ÐµÑ€ÐµÑÑ‡Ð¸Ñ‚Ð°Ð¹Ñ‚Ðµ.'],
            ['question' => 'Ð§Ñ‚Ð¾ Ð²Ð»Ð¸ÑÐµÑ‚ Ð½Ð° Ñ†ÐµÐ½Ñƒ Ð±Ð¾Ð»ÑŒÑˆÐµ Ð²ÑÐµÐ³Ð¾?', 'answer' => 'Ð Ð°Ð¹Ð¾Ð½, Ð¿Ð»Ð¾Ñ‰Ð°Ð´ÑŒ, ÑÑ‚Ð°Ð¶, Ñ€ÐµÐ¼Ð¾Ð½Ñ‚, Ñ‚Ð¸Ð¿ Ð´Ð¾Ð¼Ð° (ÐºÐ¸Ñ€Ð¿Ð¸Ñ‡ vs Ð¿Ð°Ð½ÐµÐ»ÑŒ), Ð¸Ð½Ñ„Ñ€Ð°ÑÑ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð° Ð² Ñ€Ð°Ð´Ð¸ÑƒÑÐµ 500Ð¼.'],
            ['question' => 'ÐœÐ¾Ð¶Ð½Ð¾ Ð»Ð¸ Ð²Ñ‹ÑÑ‚Ð°Ð²Ð¸Ñ‚ÑŒ Ñ†ÐµÐ½Ñƒ Ð²Ñ‹ÑˆÐµ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°?', 'answer' => 'ÐœÐ¾Ð¶Ð½Ð¾, Ð½Ð¾ Ñ€Ð¸ÑÐº: Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Â«Ð·Ð°Ð²Ð¸ÑÐ½ÐµÑ‚Â» Ð½Ð° 60+ Ð´Ð½ÐµÐ¹. Ð ÐµÐºÐ¾Ð¼ÐµÐ½Ð´ÑƒÐµÐ¼: Ð²ÐµÑ€Ñ…Ð½ÑÑ Ð³Ñ€Ð°Ð½Ð¸Ñ†Ð° ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° = ÑÑ‚Ð°Ñ€Ñ‚Ð¾Ð²Ð°Ñ Ñ†ÐµÐ½Ð°.'],
            ['question' => 'Ð§ÐµÐ¼ Ð¾Ñ‚Ð»Ð¸Ñ‡Ð°ÐµÑ‚ÑÑ Ð¾Ñ†ÐµÐ½ÐºÐ° Ð±Ð°Ð½ÐºÐ° Ð¾Ñ‚ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°?', 'answer' => 'ÐžÑ†ÐµÐ½ÐºÐ° Ð±Ð°Ð½ÐºÐ° â€” Ð´Ð»Ñ Ð¸Ð¿Ð¾Ñ‚ÐµÐºÐ¸, Ð¾Ð±Ñ‹Ñ‡Ð½Ð¾ ÐºÐ¾Ð½ÑÐµÑ€Ð²Ð°Ñ‚Ð¸Ð²Ð½Ð°Ñ (Ð½Ð° 5â€“10% Ð½Ð¸Ð¶Ðµ Ñ€Ñ‹Ð½ÐºÐ°). ÐšÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ â€” Ð´Ð»Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸, Ð¿Ð¾ÐºÐ°Ð·Ñ‹Ð²Ð°ÐµÑ‚ Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¸Ð°Ð¿Ð°Ð·Ð¾Ð½.'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ ÑÑ‚Ð¾Ð¸Ñ‚ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð°Ñ Ð¾Ñ†ÐµÐ½ÐºÐ°?', 'answer' => 'Ð‘Ð°Ð½ÐºÐ¾Ð²ÑÐºÐ°Ñ Ð¾Ñ†ÐµÐ½ÐºÐ°: 200â€“400 â‚¬. Ð Ð°ÑÑ‡Ñ‘Ñ‚ Ñ†ÐµÐ½Ð¾Ð²Ð¾Ð³Ð¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð¾Ñ‚ CityEE â€” Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð¾.'],
        ];
    }

    private function guide2FaqEt(): array
    {
        return [
            ['question' => 'Mis on hinnakoridor?', 'answer' => 'Vahemik minimaalse ja maksimaalse reaalse mÃ¼Ã¼gihinna vahel, pÃµhinedes Maa-ameti tehingutel viimase 6 kuu jooksul.'],
            ['question' => 'Kust leida tegelike tehingute andmeid?', 'answer' => 'Maa-ameti veebilehelt: maaamet.ee/kinnisvara/hinnast.'],
            ['question' => 'Miks ei saa tugineda KV.ee hindadele?', 'answer' => 'KV.ee hinnad on mÃ¼Ã¼jate "soovhinnad". Tegelikud tehingud on tavaliselt 5â€“15% madalamad.'],
            ['question' => 'Kui tihti tuleks koridori Ã¼mber arvutada?', 'answer' => 'Iga 2â€“3 kuu jÃ¤rel. Kui kuulutus on 14+ pÃ¤eva ilma pakkumisteta â€” arvutage Ã¼mber.'],
            ['question' => 'Mis mÃµjutab hinda kÃµige rohkem?', 'answer' => 'Piirkond, pindala, korrus, remont, maja tÃ¼Ã¼p, infrastruktuur 500m raadiuses.'],
            ['question' => 'Kas saab hinna panna koridorist kÃµrgemale?', 'answer' => 'Saab, aga risk: kuulutus jÃ¤Ã¤b 60+ pÃ¤evaks "rippuma". Soovitus: koridori Ã¼lemine piir = stardihind.'],
            ['question' => 'Kuidas erineb panga hindamine hinnakoridorist?', 'answer' => 'Panga hinnang on laenu jaoks, tavaliselt konservatiivne. Koridor nÃ¤itab tegelikku mÃ¼Ã¼givahemikku.'],
            ['question' => 'Palju maksab professionaalne hindamine?', 'answer' => 'Panga hindamine: 200â€“400 â‚¬. CityEE hinnakoridori arvutus â€” tasuta.'],
        ];
    }

    private function guide2FaqEn(): array
    {
        return [
            ['question' => 'What is a price corridor?', 'answer' => 'The range between the minimum and maximum realistic sale price, based on Maa-amet completed transactions over the past 6 months.'],
            ['question' => 'Where to find real transaction data?', 'answer' => 'Maa-amet website: maaamet.ee/kinnisvara/hinnast â€” state registry of all real estate transactions in Estonia.'],
            ['question' => 'Why not rely on KV.ee prices?', 'answer' => 'KV.ee prices are sellers\' "wish prices." Real deals are typically 5â€“15% lower.'],
            ['question' => 'How often should I recalculate the corridor?', 'answer' => 'Every 2â€“3 months. If listing has been 14+ days without offers â€” recalculate.'],
            ['question' => 'What affects the price most?', 'answer' => 'District, area, floor, renovation, building type, infrastructure within 500m.'],
            ['question' => 'Can I price above the corridor?', 'answer' => 'You can, but risk: listing may sit for 60+ days. Recommend: upper corridor boundary = starting price.'],
            ['question' => 'How does a bank appraisal differ?', 'answer' => 'Bank appraisal is for mortgage, usually conservative (5â€“10% below market). Corridor shows the real selling range.'],
            ['question' => 'How much does a professional appraisal cost?', 'answer' => 'Bank appraisal: 200â€“400 â‚¬. CityEE corridor calculation â€” free.'],
        ];
    }

    // â”€â”€â”€â”€ Guide 3 FAQ â”€â”€â”€â”€

    private function guide3FaqRu(): array
    {
        return [
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ Ñ„Ð¾Ñ‚Ð¾ Ð½ÑƒÐ¶Ð½Ð¾ Ð´Ð»Ñ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee?', 'answer' => 'ÐœÐ¸Ð½Ð¸Ð¼ÑƒÐ¼ 10. Ð˜Ð´ÐµÐ°Ð»ÑŒÐ½Ð¾ 15â€“20: Ð²ÑÐµ ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ñ‹, ÐºÑƒÑ…Ð½Ñ, Ð²Ð°Ð½Ð½Ð°Ñ, Ð±Ð°Ð»ÐºÐ¾Ð½, Ð²Ð¸Ð´, Ð¿Ð¾Ð´ÑŠÐµÐ·Ð´, Ð´Ð²Ð¾Ñ€, Ñ„Ð°ÑÐ°Ð´, Ð¿Ð»Ð°Ð½.'],
            ['question' => 'ÐÐ° ÐºÐ°ÐºÐ¾Ð¼ ÑÐ·Ñ‹ÐºÐµ Ð¿Ð¸ÑÐ°Ñ‚ÑŒ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ?', 'answer' => 'ÐžÐ±ÑÐ·Ð°Ñ‚ÐµÐ»ÑŒÐ½Ð¾ Ð½Ð° Ð´Ð²ÑƒÑ…: ÑÑÑ‚Ð¾Ð½ÑÐºÐ¾Ð¼ Ð¸ Ñ€ÑƒÑÑÐºÐ¾Ð¼. Ð­Ñ‚Ð¾ Ð¿Ð¾ÐºÑ€Ñ‹Ð²Ð°ÐµÑ‚ 95% Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹ Ð² Ð¢Ð°Ð»Ð»Ð¸Ð½Ð½Ðµ.'],
            ['question' => 'Ð¡Ñ‚Ð¾Ð¸Ñ‚ Ð»Ð¸ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÑŒ Ð¿Ñ€ÐµÐ¼Ð¸ÑƒÐ¼-Ð¿Ð°ÐºÐµÑ‚ Ð½Ð° KV.ee?', 'answer' => 'Ð”Ð°, Ð½Ð° Ð¿ÐµÑ€Ð²Ñ‹Ðµ 14 Ð´Ð½ÐµÐ¹ Ð¾Ð±ÑÐ·Ð°Ñ‚ÐµÐ»ÑŒÐ½Ð¾. Ð­Ñ‚Ð¾ ÑÐ°Ð¼Ð¾Ðµ Ð²Ð°Ð¶Ð½Ð¾Ðµ Ð¾ÐºÐ½Ð¾: 60% Ð²ÑÐµÑ… Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð² Ð¿Ñ€Ð¸Ñ…Ð¾Ð´Ð¸Ñ‚ÑÑ Ð½Ð° Ð¿ÐµÑ€Ð²Ñ‹Ðµ 2 Ð½ÐµÐ´ÐµÐ»Ð¸.'],
            ['question' => 'Ð§Ñ‚Ð¾ Ð¿Ð¸ÑÐ°Ñ‚ÑŒ Ð² Ð·Ð°Ð³Ð¾Ð»Ð¾Ð²ÐºÐµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ?', 'answer' => 'Ð Ð°Ð¹Ð¾Ð½ + Ñ‚Ð¸Ð¿ + ÐºÐ»ÑŽÑ‡ÐµÐ²Ð¾Ðµ Ð¿Ñ€ÐµÐ¸Ð¼ÑƒÑ‰ÐµÑÑ‚Ð²Ð¾. ÐŸÑ€Ð¸Ð¼ÐµÑ€: Â«Kesklinn | 2-Ðº ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ð° 52Ð¼Â² | ÐŸÐ°Ð½Ð¾Ñ€Ð°Ð¼Ð½Ñ‹Ð¹ Ð²Ð¸Ð´Â».'],
            ['question' => 'ÐšÐ°Ðº Ñ‡Ð°ÑÑ‚Ð¾ Ð¾Ð±Ð½Ð¾Ð²Ð»ÑÑ‚ÑŒ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ?', 'answer' => 'Ð Ð°Ð· Ð² 7 Ð´Ð½ÐµÐ¹ â€” ÑÑ‚Ð¾ Ð¿Ð¾Ð´Ð½Ð¸Ð¼Ð°ÐµÑ‚ ÐµÐ³Ð¾ Ð² Ð²Ñ‹Ð´Ð°Ñ‡Ðµ KV.ee.'],
            ['question' => 'ÐÑƒÐ¶ÐµÐ½ Ð»Ð¸ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ñ„Ð¾Ñ‚Ð¾Ð³Ñ€Ð°Ñ„?', 'answer' => 'Ð”Ð°. Ð Ð°Ð·Ð½Ð¸Ñ†Ð° Ð² CTR Ð¼ÐµÐ¶Ð´Ñƒ Ð»ÑŽÐ±Ð¸Ñ‚ÐµÐ»ÑŒÑÐºÐ¸Ð¼Ð¸ Ð¸ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¼Ð¸ Ñ„Ð¾Ñ‚Ð¾: 40â€“60%. Ð¡Ñ‚Ð¾Ð¸Ð¼Ð¾ÑÑ‚ÑŒ: 100â€“200 â‚¬.'],
            ['question' => 'Ð¡Ñ‚Ð¾Ð¸Ñ‚ Ð»Ð¸ Ð´Ð¾Ð±Ð°Ð²Ð»ÑÑ‚ÑŒ Ð²Ð¸Ð´ÐµÐ¾Ñ‚ÑƒÑ€?', 'answer' => 'Ð”Ð°, Ð²Ð¸Ð´ÐµÐ¾Ñ‚ÑƒÑ€ ÑƒÐ²ÐµÐ»Ð¸Ñ‡Ð¸Ð²Ð°ÐµÑ‚ Ð²Ð¾Ð²Ð»ÐµÑ‡Ñ‘Ð½Ð½Ð¾ÑÑ‚ÑŒ Ð½Ð° 30â€“40%. ÐžÑÐ¾Ð±ÐµÐ½Ð½Ð¾ Ð²Ð°Ð¶Ð½Ð¾ Ð´Ð»Ñ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹ Ð·Ð° Ñ€ÑƒÐ±ÐµÐ¶Ð¾Ð¼.'],
            ['question' => 'ÐšÐ°ÐºÐ¾Ð¹ Ñ„Ð¾Ñ€Ð¼Ð°Ñ‚ Ð¾Ð¿Ð¸ÑÐ°Ð½Ð¸Ñ Ð»ÑƒÑ‡ÑˆÐµ?', 'answer' => 'Ð¡Ñ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð½Ñ‹Ð¹: Ñ„Ð°ÐºÑ‚Ñ‹ Ð² Ð½Ð°Ñ‡Ð°Ð»Ðµ (Ð¿Ð»Ð¾Ñ‰Ð°Ð´ÑŒ, Ñ€ÐµÐ¼Ð¾Ð½Ñ‚, Ð¾Ñ‚Ð¾Ð¿Ð»ÐµÐ½Ð¸Ðµ), Ð¿Ð¾Ñ‚Ð¾Ð¼ â€” Ð¸Ð½Ñ„Ñ€Ð°ÑÑ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð° Ð¸ Ð¿Ñ€ÐµÐ¸Ð¼ÑƒÑ‰ÐµÑÑ‚Ð²Ð°.'],
        ];
    }

    private function guide3FaqEt(): array
    {
        return [
            ['question' => 'Mitu fotot on KV.ee kuulutusel vaja?', 'answer' => 'VÃ¤hemalt 10. Ideaalis 15â€“20.'],
            ['question' => 'Mis keeles kuulutus kirjutada?', 'answer' => 'Kindlasti kahes: eesti ja vene keeles. See katab 95% ostjaid Tallinnas.'],
            ['question' => 'Kas tasub KV.ee premium paketti osta?', 'answer' => 'Jah, esimesed 14 pÃ¤eva kindlasti. 60% vaatamistest tuleb esimesel 2 nÃ¤dalal.'],
            ['question' => 'Mida pealkirja kirjutada?', 'answer' => 'Piirkond + tÃ¼Ã¼p + peamine eelis. NÃ¤ide: Â«Kesklinn | 2-t korter 52mÂ² | PanoraamvaadeÂ».'],
            ['question' => 'Kui tihti kuulutust uuendada?', 'answer' => 'Iga 7 pÃ¤eva jÃ¤rel â€” see tÃµstab positsiooni KV.ee-s.'],
            ['question' => 'Kas professionaalne fotograaf on vajalik?', 'answer' => 'Jah. Profi- ja amatÃ¶Ã¶rfotode CTR vahe: 40â€“60%. Hind: 100â€“200 â‚¬.'],
            ['question' => 'Kas videotuuri tasub lisada?', 'answer' => 'Jah, videotuur suurendab kaasatust 30â€“40%.'],
            ['question' => 'Milline kirjelduse formaat on parim?', 'answer' => 'Struktureeritud: faktid alguses (pindala, remont, kÃ¼te), seejÃ¤rel infrastruktuur ja eelised.'],
        ];
    }

    private function guide3FaqEn(): array
    {
        return [
            ['question' => 'How many photos for a KV.ee listing?', 'answer' => 'Minimum 10. Ideally 15â€“20.'],
            ['question' => 'What language for the listing?', 'answer' => 'Both Estonian and Russian. This covers 95% of buyers in Tallinn.'],
            ['question' => 'Should I buy the KV.ee premium package?', 'answer' => 'Yes, for the first 14 days â€” 60% of views come in the first 2 weeks.'],
            ['question' => 'What to write in the headline?', 'answer' => 'District + type + key advantage. Example: "Kesklinn | 2-room 52sqm | Panoramic view".'],
            ['question' => 'How often to refresh the listing?', 'answer' => 'Every 7 days to boost position on KV.ee.'],
            ['question' => 'Do I need a professional photographer?', 'answer' => 'Yes. CTR difference between amateur and professional photos: 40â€“60%. Cost: 100â€“200 â‚¬.'],
            ['question' => 'Should I add a video tour?', 'answer' => 'Yes, video tours increase engagement by 30â€“40%.'],
            ['question' => 'What description format is best?', 'answer' => 'Structured: facts first (area, renovation, heating), then infrastructure and advantages.'],
        ];
    }

    // â”€â”€â”€â”€ Guide 4 FAQ â”€â”€â”€â”€

    private function guide4FaqRu(): array
    {
        return [
            ['question' => 'ÐšÐ°ÐºÐ¾Ð¹ Ð·Ð°Ð»Ð¾Ð³ Ð¿Ñ€Ð¾ÑÐ¸Ñ‚ÑŒ Ñƒ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð°?', 'answer' => 'ÐœÐ¸Ð½Ð¸Ð¼ÑƒÐ¼ 2 Ð¼ÐµÑÑÑ†Ð° Ð°Ñ€ÐµÐ½Ð´Ñ‹. ÐŸÑ€Ð¸ Ð²Ñ‹ÑÐ¾ÐºÐ¸Ñ… Ñ€Ð¸ÑÐºÐ°Ñ… (Ð´Ð¾Ð¼Ð°ÑˆÐ½Ð¸Ðµ Ð¶Ð¸Ð²Ð¾Ñ‚Ð½Ñ‹Ðµ, Ð¼Ð°Ð»Ð¾ Ð¸ÑÑ‚Ð¾Ñ€Ð¸Ð¸) â€” 3 Ð¼ÐµÑÑÑ†Ð°.'],
            ['question' => 'ÐšÐ°Ðº Ð¿Ñ€Ð¾Ð²ÐµÑ€Ð¸Ñ‚ÑŒ ÐºÑ€ÐµÐ´Ð¸Ñ‚Ð½ÑƒÑŽ Ð¸ÑÑ‚Ð¾Ñ€Ð¸ÑŽ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð°?', 'answer' => 'Ð§ÐµÑ€ÐµÐ· Creditinfo: Ð·Ð°Ð¿Ñ€Ð¾ÑÐ¸Ñ‚Ðµ Ñƒ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð° ÑÐ¾Ð³Ð»Ð°ÑÐ¸Ðµ Ð¸ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÑŒÑ‚Ðµ Ð¿ÑƒÐ±Ð»Ð¸Ñ‡Ð½Ñ‹Ðµ Ð´Ð¾Ð»Ð³Ð¸ Ð¸ ÐºÑ€ÐµÐ´Ð¸Ñ‚Ð½Ñ‹Ðµ Ð¾Ð±ÑÐ·Ð°Ñ‚ÐµÐ»ÑŒÑÑ‚Ð²Ð°.'],
            ['question' => 'ÐÐ° ÐºÐ°ÐºÐ¾Ð¼ ÑÐ·Ñ‹ÐºÐµ Ð´Ð¾Ð»Ð¶ÐµÐ½ Ð±Ñ‹Ñ‚ÑŒ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€?', 'answer' => 'ÐÐ° ÑÑÑ‚Ð¾Ð½ÑÐºÐ¾Ð¼ â€” ÑÑ‚Ð¾ ÑŽÑ€Ð¸Ð´Ð¸Ñ‡ÐµÑÐºÐ¸ Ð¾Ð±ÑÐ·Ð°Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ ÑÐ·Ñ‹Ðº. ÐŸÐµÑ€ÐµÐ²Ð¾Ð´ Ð½Ð° Ñ€ÑƒÑÑÐºÐ¸Ð¹/Ð°Ð½Ð³Ð»Ð¸Ð¹ÑÐºÐ¸Ð¹ â€” Ð´Ð»Ñ ÑƒÐ´Ð¾Ð±ÑÑ‚Ð²Ð° ÑÑ‚Ð¾Ñ€Ð¾Ð½.'],
            ['question' => 'ÐÑƒÐ¶ÐµÐ½ Ð»Ð¸ Ð°ÐºÑ‚ Ð¿Ñ€Ð¸Ñ‘Ð¼Ð°-Ð¿ÐµÑ€ÐµÐ´Ð°Ñ‡Ð¸?', 'answer' => 'ÐžÐ±ÑÐ·Ð°Ñ‚ÐµÐ»ÐµÐ½. Ð¡ Ñ„Ð¾Ñ‚Ð¾ ÐºÐ°Ð¶Ð´Ð¾Ð¹ ÐºÐ¾Ð¼Ð½Ð°Ñ‚Ñ‹, Ð¾Ð¿Ð¸ÑÐ°Ð½Ð¸ÐµÐ¼ Ð¸Ð½Ð²ÐµÐ½Ñ‚Ð°Ñ€Ñ Ð¸ ÑÐ¾ÑÑ‚Ð¾ÑÐ½Ð¸Ñ. Ð­Ñ‚Ð¾ Ð·Ð°Ñ‰Ð¸Ñ‚Ð° Ð¿Ñ€Ð¸ Ð²Ð¾Ð·Ð²Ñ€Ð°Ñ‚Ðµ Ð·Ð°Ð»Ð¾Ð³Ð°.'],
            ['question' => 'Ð§Ñ‚Ð¾ Ð´ÐµÐ»Ð°Ñ‚ÑŒ Ð¿Ñ€Ð¸ Ð½ÐµÐ¾Ð¿Ð»Ð°Ñ‚Ðµ Ð°Ñ€ÐµÐ½Ð´Ñ‹?', 'answer' => 'Ð¨Ð°Ð³ 1: Ð¿Ð¸ÑÑŒÐ¼ÐµÐ½Ð½Ð¾Ðµ Ð¿Ñ€ÐµÐ´ÑƒÐ¿Ñ€ÐµÐ¶Ð´ÐµÐ½Ð¸Ðµ. Ð¨Ð°Ð³ 2: 14-Ð´Ð½ÐµÐ²Ð½Ñ‹Ð¹ ÑÑ€Ð¾Ðº. Ð¨Ð°Ð³ 3: Ñ€Ð°ÑÑ‚Ð¾Ñ€Ð¶ÐµÐ½Ð¸Ðµ + Ð·Ð°ÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð² ÑÑƒÐ´. Ð¡Ñ€ÐµÐ´Ð½Ð¸Ð¹ ÑÑ€Ð¾Ðº Ð¿Ñ€Ð¾Ñ†ÐµÑÑÐ°: 3â€“6 Ð¼ÐµÑÑÑ†ÐµÐ².'],
            ['question' => 'ÐœÐ¾Ð¶Ð½Ð¾ Ð»Ð¸ Ð¾Ñ‚ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ñƒ?', 'answer' => 'Ð”Ð°, Ð½Ð¾ Ð½ÐµÐ»ÑŒÐ·Ñ Ð´Ð¸ÑÐºÑ€Ð¸Ð¼Ð¸Ð½Ð¸Ñ€Ð¾Ð²Ð°Ñ‚ÑŒ Ð¿Ð¾ Ð½Ð°Ñ†Ð¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾ÑÑ‚Ð¸, Ð¿Ð¾Ð»Ñƒ, Ð²Ð¾Ð·Ñ€Ð°ÑÑ‚Ñƒ. ÐœÐ¾Ð¶Ð½Ð¾ Ð¾Ñ‚ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð½Ð° Ð¾ÑÐ½Ð¾Ð²Ð°Ð½Ð¸Ð¸ ÐºÑ€ÐµÐ´Ð¸Ñ‚Ð½Ð¾Ð¹ Ð¸ÑÑ‚Ð¾Ñ€Ð¸Ð¸, Ð´Ð¾Ñ…Ð¾Ð´Ð¾Ð², Ñ€ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ð¹.'],
            ['question' => 'ÐšÐ°Ðº Ñ€Ð°Ð·Ñ€ÐµÑˆÐ¸Ñ‚ÑŒ ÐºÐ¾Ð½Ñ„Ð»Ð¸ÐºÑ‚ Ñ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð¾Ð¼?', 'answer' => 'ÐœÐµÐ´Ð¸Ð°Ñ†Ð¸Ñ Ñ‡ÐµÑ€ÐµÐ· ÃœÃ¼rikomisjon (Ð°Ñ€ÐµÐ½Ð´Ð½Ð°Ñ ÐºÐ¾Ð¼Ð¸ÑÑÐ¸Ñ) â€” Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ð³Ð¾ÑÑƒÐ´Ð°Ñ€ÑÑ‚Ð²ÐµÐ½Ð½Ñ‹Ð¹ Ð¾Ñ€Ð³Ð°Ð½ Ð´Ð»Ñ Ñ€Ð°Ð·Ñ€ÐµÑˆÐµÐ½Ð¸Ñ Ð°Ñ€ÐµÐ½Ð´Ð½Ñ‹Ñ… ÑÐ¿Ð¾Ñ€Ð¾Ð².'],
            ['question' => 'ÐšÐ°ÐºÐ¸Ðµ Ñ€Ð°ÑÑ…Ð¾Ð´Ñ‹ Ð½ÐµÑÑ‘Ñ‚ Ð°Ñ€ÐµÐ½Ð´Ð¾Ð´Ð°Ñ‚ÐµÐ»ÑŒ?', 'answer' => 'ÐÐ°Ð»Ð¾Ð³ Ð½Ð° Ð´Ð¾Ñ…Ð¾Ð´Ñ‹ (20%), ÑÑ‚Ñ€Ð°Ñ…Ð¾Ð²ÐºÐ° (50â€“200 â‚¬/Ð³Ð¾Ð´), Ð°Ð¼Ð¾Ñ€Ñ‚Ð¸Ð·Ð°Ñ†Ð¸Ñ, ÐºÐ°Ð¿Ñ€ÐµÐ¼Ð¾Ð½Ñ‚. ÐšÐ¾Ð¼Ð¼ÑƒÐ½Ð°Ð»ÑŒÐ½Ñ‹Ðµ â€” Ð¾Ð±Ñ‹Ñ‡Ð½Ð¾ Ð·Ð° ÑÑ‡Ñ‘Ñ‚ Ð°Ñ€ÐµÐ½Ð´Ð°Ñ‚Ð¾Ñ€Ð°.'],
        ];
    }

    private function guide4FaqEt(): array
    {
        return [
            ['question' => 'Millist tagatisraha Ã¼Ã¼rnikult kÃ¼sida?', 'answer' => 'VÃ¤hemalt 2 kuu Ã¼Ã¼r. KÃµrgema riski korral â€” 3 kuud.'],
            ['question' => 'Kuidas kontrollida Ã¼Ã¼rniku krediidiajalugu?', 'answer' => 'Creditinfo kaudu: kÃ¼sige Ã¼Ã¼rnikult nÃµusolekut ja kontrollige avalikke vÃµlgu.'],
            ['question' => 'Mis keeles peab leping olema?', 'answer' => 'Eesti keeles â€” see on juriidiliselt siduv keel. TÃµlge mugavuse jaoks.'],
            ['question' => 'Kas Ã¼leandmisakt on vajalik?', 'answer' => 'Kohustuslik. Fotodega igast toast, inventari ja seisukorra kirjeldusega.'],
            ['question' => 'Mida teha Ã¼Ã¼ri maksmata jÃ¤tmisel?', 'answer' => 'Kirjalik hoiatus â†’ 14 pÃ¤eva â†’ lepingu lÃµpetamine + kohtusse.'],
            ['question' => 'Kas saan Ã¼Ã¼rnikust keelduda?', 'answer' => 'Jah, aga ei tohi diskrimineerida. Saab keelduda krediidiajaloo, sissetuleku pÃµhjal.'],
            ['question' => 'Kuidas konflikti lahendada?', 'answer' => 'ÃœÃ¼rikomisjoni kaudu â€” tasuta riiklik organ Ã¼Ã¼rivaidluste lahendamiseks.'],
            ['question' => 'Millised kulud jÃ¤Ã¤vad Ã¼Ã¼rileandja kanda?', 'answer' => 'Tulumaks (20%), kindlustus, amortisatsioon, suurem remont.'],
        ];
    }

    private function guide4FaqEn(): array
    {
        return [
            ['question' => 'What deposit to request from a tenant?', 'answer' => 'Minimum 2 months rent. For higher risk (pets, little history) â€” 3 months.'],
            ['question' => 'How to check tenant credit history?', 'answer' => 'Through Creditinfo: request tenant consent and check public debts.'],
            ['question' => 'What language should the contract be in?', 'answer' => 'Estonian â€” it\'s the legally binding language. Translation for convenience.'],
            ['question' => 'Is a handover act necessary?', 'answer' => 'Mandatory. With photos of every room, inventory, and condition description.'],
            ['question' => 'What to do about unpaid rent?', 'answer' => 'Step 1: written warning. Step 2: 14-day period. Step 3: termination + court.'],
            ['question' => 'Can I refuse a tenant?', 'answer' => 'Yes, but no discrimination. Can refuse based on credit history, income, references.'],
            ['question' => 'How to resolve a conflict?', 'answer' => 'Through ÃœÃ¼rikomisjon â€” free state body for rental dispute resolution.'],
            ['question' => 'What expenses does the landlord bear?', 'answer' => 'Income tax (20%), insurance, depreciation, major repairs. Utilities â€” usually tenant.'],
        ];
    }

    // â”€â”€â”€â”€ Guide 5 FAQ â”€â”€â”€â”€

    private function guide5FaqRu(): array
    {
        return [
            ['question' => 'Ð ÐµÐ°Ð»ÑŒÐ½Ð¾ Ð»Ð¸ Ð¿Ñ€Ð¾Ð´Ð°Ñ‚ÑŒ ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñƒ Ð·Ð° 30 Ð´Ð½ÐµÐ¹?', 'answer' => 'Ð”Ð°, Ð¿Ñ€Ð¸ Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð¾Ð¼ Ñ†ÐµÐ½Ð¾Ð¾Ð±Ñ€Ð°Ð·Ð¾Ð²Ð°Ð½Ð¸Ð¸ Ð¸ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐµ. 65% Ð½Ð°ÑˆÐ¸Ñ… ÑÐ´ÐµÐ»Ð¾Ðº Ð·Ð°ÐºÑ€Ñ‹Ð²Ð°ÑŽÑ‚ÑÑ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹.'],
            ['question' => 'Ð§Ñ‚Ð¾ ÐµÑÐ»Ð¸ Ð·Ð° 45 Ð´Ð½ÐµÐ¹ Ð½Ðµ Ð¿Ñ€Ð¾Ð´Ð°ÑÑ‚ÑÑ?', 'answer' => 'ÐŸÐµÑ€ÐµÑÐ¼Ð¾Ñ‚Ñ€ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ð¸: ÐºÐ¾Ñ€Ñ€ÐµÐºÑ†Ð¸Ñ Ñ†ÐµÐ½Ñ‹ (-3â€“5%), Ð¾Ð±Ð½Ð¾Ð²Ð»ÐµÐ½Ð¸Ðµ Ñ„Ð¾Ñ‚Ð¾, Ñ€Ð°ÑÑˆÐ¸Ñ€ÐµÐ½Ð¸Ðµ ÐºÐ°Ð½Ð°Ð»Ð¾Ð² Ð¿Ñ€Ð¾Ð´Ð²Ð¸Ð¶ÐµÐ½Ð¸Ñ.'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ ÑÑ‚Ð¾Ð¸Ñ‚ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°?', 'answer' => 'ÐœÐ¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ð°Ñ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ°: 200â€“500 â‚¬. Ð’Ð¾Ð·Ð²Ñ€Ð°Ñ‚: 1 000â€“3 000 â‚¬ Ð² Ñ†ÐµÐ½Ðµ ÑÐ´ÐµÐ»ÐºÐ¸.'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ Ð¿Ð¾ÐºÐ°Ð·Ð¾Ð² Ð² ÑÑ€ÐµÐ´Ð½ÐµÐ¼ Ð½ÑƒÐ¶Ð½Ð¾?', 'answer' => '5â€“8 Ð¿Ð¾ÐºÐ°Ð·Ð¾Ð² Ð´Ð»Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸. Ð•ÑÐ»Ð¸ Ð¿Ð¾ÑÐ»Ðµ 10 Ð¿Ð¾ÐºÐ°Ð·Ð¾Ð² Ð½ÐµÑ‚ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹ â€” Ð¿Ñ€Ð¾Ð±Ð»ÐµÐ¼Ð° Ð² Ñ†ÐµÐ½Ðµ.'],
            ['question' => 'ÐšÐ¾Ð³Ð´Ð° Ð»ÑƒÑ‡ÑˆÐµ Ð½Ð°Ñ‡Ð¸Ð½Ð°Ñ‚ÑŒ?', 'answer' => 'ÐœÐ°Ñ€Ñ‚â€“Ð°Ð¿Ñ€ÐµÐ»ÑŒ Ð¸Ð»Ð¸ ÑÐµÐ½Ñ‚ÑÐ±Ñ€ÑŒâ€“Ð¾ÐºÑ‚ÑÐ±Ñ€ÑŒ â€” Ð¿Ð¸ÐºÐ¾Ð²Ñ‹Ðµ ÑÐµÐ·Ð¾Ð½Ñ‹. ÐÐ¾ Ð¿Ð»Ð°Ð½ Ñ€Ð°Ð±Ð¾Ñ‚Ð°ÐµÑ‚ ÐºÑ€ÑƒÐ³Ð»Ñ‹Ð¹ Ð³Ð¾Ð´.'],
            ['question' => 'ÐÑƒÐ¶ÐµÐ½ Ð»Ð¸ Ð¿Ñ€ÐµÐ´Ð²Ð°Ñ€Ð¸Ñ‚ÐµÐ»ÑŒÐ½Ñ‹Ð¹ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€?', 'answer' => 'Ð ÐµÐºÐ¾Ð¼ÐµÐ½Ð´ÑƒÐµÑ‚ÑÑ. ÐžÐ½ Ñ„Ð¸ÐºÑÐ¸Ñ€ÑƒÐµÑ‚ Ñ†ÐµÐ½Ñƒ Ð¸ ÑÑ€Ð¾ÐºÐ¸, Ñ‡Ñ‚Ð¾Ð±Ñ‹ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑŒ Ð½Ðµ Ð¿ÐµÑ€ÐµÐ´ÑƒÐ¼Ð°Ð». Ð—Ð°Ð´Ð°Ñ‚Ð¾Ðº 5â€“10%.'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ Ð·Ð°Ð½Ð¸Ð¼Ð°ÐµÑ‚ Ð½Ð¾Ñ‚Ð°Ñ€Ð¸Ð°Ð»ÑŒÐ½Ð°Ñ ÑÐ´ÐµÐ»ÐºÐ°?', 'answer' => '1â€“3 Ð´Ð½Ñ Ð½Ð° Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÑƒ Ð´Ð¾ÐºÑƒÐ¼ÐµÐ½Ñ‚Ð¾Ð² + 30â€“60 Ð¼Ð¸Ð½ÑƒÑ‚ Ñƒ Ð½Ð¾Ñ‚Ð°Ñ€Ð¸ÑƒÑÐ°. Ð”ÐµÐ½ÑŒÐ³Ð¸ Ð¿ÐµÑ€ÐµÐ²Ð¾Ð´ÑÑ‚ÑÑ Ð² Ð´ÐµÐ½ÑŒ ÑÐ´ÐµÐ»ÐºÐ¸.'],
            ['question' => 'ÐœÐ¾Ð³Ñƒ Ð»Ð¸ Ñ Ð¶Ð¸Ñ‚ÑŒ Ð² ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ðµ Ð²Ð¾ Ð²Ñ€ÐµÐ¼Ñ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸?', 'answer' => 'Ð”Ð°, Ð½Ð¾ Ð¿ÐµÑ€ÐµÐ´ Ð¿Ð¾ÐºÐ°Ð·Ð°Ð¼Ð¸ â€” Ð³ÐµÐ½ÐµÑ€Ð°Ð»ÑŒÐ½Ð°Ñ ÑƒÐ±Ð¾Ñ€ÐºÐ° Ð¸ decluttering. Ð”Ð»Ñ Ñ„Ð¾Ñ‚Ð¾ÑÑŠÑ‘Ð¼ÐºÐ¸ â€” ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ð° Ð´Ð¾Ð»Ð¶Ð½Ð° Ð±Ñ‹Ñ‚ÑŒ Ð¼Ð°ÐºÑÐ¸Ð¼Ð°Ð»ÑŒÐ½Ð¾ Â«Ñ‡Ð¸ÑÑ‚Ð¾Ð¹Â».'],
        ];
    }

    private function guide5FaqEt(): array
    {
        return [
            ['question' => 'Kas on reaalne mÃ¼Ã¼a korter 30 pÃ¤evaga?', 'answer' => 'Jah, Ãµige hinnastamise ja ettevalmistusega. 65% meie tehingutest sulguvad 30â€“45 pÃ¤evaga.'],
            ['question' => 'Mis siis, kui 45 pÃ¤evaga ei mÃ¼Ã¼?', 'answer' => 'Strateegia Ã¼levaatus: hinna korrigeerimine (-3â€“5%), fotode uuendamine, kanalite laiendamine.'],
            ['question' => 'Palju ettevalmistus maksab?', 'answer' => 'Minimaalne ettevalmistus: 200â€“500 â‚¬. Tagasi: 1 000â€“3 000 â‚¬ tehingu hinnas.'],
            ['question' => 'Mitu nÃ¤itamist on keskmiselt vaja?', 'answer' => '5â€“8 nÃ¤itamist mÃ¼Ã¼giks. Kui 10 nÃ¤itamist ilma pakkumiseta â€” probleem on hinnas.'],
            ['question' => 'Millal on parim alustada?', 'answer' => 'MÃ¤rtsâ€“aprill vÃµi septemberâ€“oktoober. Aga plaan tÃ¶Ã¶tab aastaringselt.'],
            ['question' => 'Kas eelleping on vajalik?', 'answer' => 'Soovitatav. See fikseerib hinna ja tÃ¤htajad. Tagatisraha 5â€“10%.'],
            ['question' => 'Kui kaua vÃµtab aega notariaaltehing?', 'answer' => '1â€“3 pÃ¤eva dokumentide ettevalmistus + 30â€“60 minutit notari juures.'],
            ['question' => 'Kas saan mÃ¼Ã¼gi ajal korteris elada?', 'answer' => 'Jah, aga enne nÃ¤itamisi â€” pÃµhjalik koristus ja decluttering.'],
        ];
    }

    private function guide5FaqEn(): array
    {
        return [
            ['question' => 'Is it realistic to sell in 30 days?', 'answer' => 'Yes, with proper pricing and preparation. 65% of our deals close in 30â€“45 days.'],
            ['question' => 'What if it doesn\'t sell in 45 days?', 'answer' => 'Strategy review: price correction (-3â€“5%), photo refresh, expanded promotion.'],
            ['question' => 'How much does preparation cost?', 'answer' => 'Minimal preparation: 200â€“500 â‚¬. Return: 1,000â€“3,000 â‚¬ in deal price.'],
            ['question' => 'How many showings are typically needed?', 'answer' => '5â€“8 showings for a sale. If 10 showings with no offers â€” the price is the issue.'],
            ['question' => 'When is the best time to start?', 'answer' => 'Marchâ€“April or Septemberâ€“October peak seasons. But the plan works year-round.'],
            ['question' => 'Is a preliminary contract needed?', 'answer' => 'Recommended. It locks in price and timeline. Deposit 5â€“10%.'],
            ['question' => 'How long does a notary transaction take?', 'answer' => '1â€“3 days document preparation + 30â€“60 minutes at the notary.'],
            ['question' => 'Can I live in the apartment during the sale?', 'answer' => 'Yes, but deep clean and declutter before showings.'],
        ];
    }

    // â”€â”€â”€â”€ Audit 1 FAQ â”€â”€â”€â”€

    private function audit1FaqRu(): array
    {
        return [
            ['question' => 'Ð§Ñ‚Ð¾ Ñ‚Ð°ÐºÐ¾Ðµ Ð°ÑƒÐ´Ð¸Ñ‚ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ?', 'answer' => 'ÐŸÑ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð°Ñ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÐ° Ð²Ð°ÑˆÐµÐ³Ð¾ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ñ Ð½Ð° KV.ee Ð¿Ð¾ 27 ÐºÑ€Ð¸Ñ‚ÐµÑ€Ð¸ÑÐ¼: Ñ„Ð¾Ñ‚Ð¾, Ñ‚ÐµÐºÑÑ‚, Ñ†ÐµÐ½Ð°, Ð¿Ð¾Ð·Ð¸Ñ†Ð¸Ð¾Ð½Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð¸Ðµ. Ð ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚: ÐºÐ¾Ð½ÐºÑ€ÐµÑ‚Ð½Ñ‹Ðµ Ñ€ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ð¸ Ð´Ð»Ñ ÑƒÐ²ÐµÐ»Ð¸Ñ‡ÐµÐ½Ð¸Ñ Ð·Ð²Ð¾Ð½ÐºÐ¾Ð².'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ ÑÑ‚Ð¾Ð¸Ñ‚ Ð°ÑƒÐ´Ð¸Ñ‚?', 'answer' => 'Ð‘Ð°Ð·Ð¾Ð²Ñ‹Ð¹ Ð°ÑƒÐ´Ð¸Ñ‚ â€” Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð¾. Ð Ð°ÑÑˆÐ¸Ñ€ÐµÐ½Ð½Ñ‹Ð¹ Ñ Ñ†ÐµÐ½Ð¾Ð²Ñ‹Ð¼ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð¾Ð¼ Ð¸ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÐµÐ¹ â€” Ð¾Ñ‚ 150 â‚¬.'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ Ð·Ð°Ð½Ð¸Ð¼Ð°ÐµÑ‚ Ð°ÑƒÐ´Ð¸Ñ‚?', 'answer' => '2â€“4 Ñ‡Ð°ÑÐ°. Ð’Ñ‹ Ð¿Ð¾Ð»ÑƒÑ‡Ð°ÐµÑ‚Ðµ Ð´ÐµÑ‚Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ð¾Ñ‚Ñ‡Ñ‘Ñ‚ Ñ ÐºÐ¾Ð½ÐºÑ€ÐµÑ‚Ð½Ñ‹Ð¼Ð¸ Ñ€ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸ÑÐ¼Ð¸.'],
            ['question' => 'Ð§Ñ‚Ð¾ Ð²Ñ…Ð¾Ð´Ð¸Ñ‚ Ð² Ð°ÑƒÐ´Ð¸Ñ‚?', 'answer' => 'ÐŸÑ€Ð¾Ð²ÐµÑ€ÐºÐ° Ñ„Ð¾Ñ‚Ð¾ (ÐºÐ°Ñ‡ÐµÑÑ‚Ð²Ð¾, ÐºÐ¾Ð»Ð¸Ñ‡ÐµÑÑ‚Ð²Ð¾, Ñ€Ð°ÐºÑƒÑ€ÑÑ‹), Ñ‚ÐµÐºÑÑ‚ (ÑÑ‚Ñ€ÑƒÐºÑ‚ÑƒÑ€Ð°, ÑÐ·Ñ‹Ðº, Ñ„Ð°ÐºÑ‚Ñ‹), Ñ†ÐµÐ½Ð° (ÑÑ€Ð°Ð²Ð½ÐµÐ½Ð¸Ðµ Ñ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð¾Ð¼), Ð¿Ð¾Ð·Ð¸Ñ†Ð¸Ð¾Ð½Ð¸Ñ€Ð¾Ð²Ð°Ð½Ð¸Ðµ (Ð¿Ð°ÐºÐµÑ‚, Ñ‚Ð°Ð¹Ð¼Ð¸Ð½Ð³).'],
            ['question' => 'ÐšÐ°ÐºÐ¾Ð¹ Ñ€ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚ Ð´Ð°Ñ‘Ñ‚ Ð°ÑƒÐ´Ð¸Ñ‚?', 'answer' => 'Ð’ ÑÑ€ÐµÐ´Ð½ÐµÐ¼ +200â€“400% Ð¿Ñ€Ð¾ÑÐ¼Ð¾Ñ‚Ñ€Ð¾Ð² Ð¸ +3â€“5 ÑÐµÑ€ÑŒÑ‘Ð·Ð½Ñ‹Ñ… Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹ Ð·Ð° Ð¿ÐµÑ€Ð²Ñ‹Ðµ 14 Ð´Ð½ÐµÐ¹ Ð¿Ð¾ÑÐ»Ðµ Ð¾Ð¿Ñ‚Ð¸Ð¼Ð¸Ð·Ð°Ñ†Ð¸Ð¸.'],
            ['question' => 'ÐÑƒÐ¶Ð½Ð¾ Ð»Ð¸ Ð¼Ð½Ðµ Ð¼ÐµÐ½ÑÑ‚ÑŒ Ð¼Ð°ÐºÐ»ÐµÑ€Ð° Ð¿Ð¾ÑÐ»Ðµ Ð°ÑƒÐ´Ð¸Ñ‚Ð°?', 'answer' => 'ÐÐµ Ð¾Ð±ÑÐ·Ð°Ñ‚ÐµÐ»ÑŒÐ½Ð¾. Ð’Ñ‹ Ð¼Ð¾Ð¶ÐµÑ‚Ðµ Ñ€ÐµÐ°Ð»Ð¸Ð·Ð¾Ð²Ð°Ñ‚ÑŒ Ñ€ÐµÐºÐ¾Ð¼ÐµÐ½Ð´Ð°Ñ†Ð¸Ð¸ ÑÐ°Ð¼Ð¾ÑÑ‚Ð¾ÑÑ‚ÐµÐ»ÑŒÐ½Ð¾ Ð¸Ð»Ð¸ Ð¿Ð¾Ð¿Ñ€Ð¾ÑÐ¸Ñ‚ÑŒ Ñ‚ÐµÐºÑƒÑ‰ÐµÐ³Ð¾ Ð¼Ð°ÐºÐ»ÐµÑ€Ð°.'],
            ['question' => 'ÐÑƒÐ´Ð¸Ñ‚ Ð¿Ð¾Ð´Ñ…Ð¾Ð´Ð¸Ñ‚ Ð´Ð»Ñ Ð°Ñ€ÐµÐ½Ð´Ñ‹?', 'answer' => 'Ð”Ð°, Ñ‚Ðµ Ð¶Ðµ Ð¿Ñ€Ð¸Ð½Ñ†Ð¸Ð¿Ñ‹ Ñ€Ð°Ð±Ð¾Ñ‚Ð°ÑŽÑ‚ Ð´Ð»Ñ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ð¹ Ð½Ð° Ð°Ñ€ÐµÐ½Ð´Ñƒ.'],
            ['question' => 'ÐšÐ°Ðº Ð·Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ð°ÑƒÐ´Ð¸Ñ‚?', 'answer' => 'ÐžÑ‚Ð¿Ñ€Ð°Ð²ÑŒÑ‚Ðµ ÑÑÑ‹Ð»ÐºÑƒ Ð½Ð° Ð²Ð°ÑˆÐµ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ðµ Ð² WhatsApp Ð¸Ð»Ð¸ Telegram â€” Ð¸ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ñ‚Ðµ Ð¾Ñ‚Ñ‡Ñ‘Ñ‚ Ð·Ð° 2â€“4 Ñ‡Ð°ÑÐ°.'],
        ];
    }

    private function audit1FaqEt(): array
    {
        return [
            ['question' => 'Mis on kuulutuse audit?', 'answer' => 'Professionaalne KV.ee kuulutuse kontroll 27 kriteeriumi jÃ¤rgi: fotod, tekst, hind, positsioneerimine.'],
            ['question' => 'Palju audit maksab?', 'answer' => 'Baasaudit â€” tasuta. Laiendatud hinnakoridori ja strateegiaga â€” alates 150 â‚¬.'],
            ['question' => 'Kui kaua audit aega vÃµtab?', 'answer' => '2â€“4 tundi. Saate Ã¼ksikasjaliku raporti konkreetsete soovitustega.'],
            ['question' => 'Mida audit sisaldab?', 'answer' => 'Fotode kontroll, tekst, hind (vÃµrdlus koridoriga), positsioneerimine.'],
            ['question' => 'Millist tulemust audit annab?', 'answer' => 'Keskmiselt +200â€“400% vaatamisi ja +3â€“5 tÃµsist pakkumist 14 pÃ¤evaga.'],
            ['question' => 'Kas pean pÃ¤rast auditi maaklerit vahetama?', 'answer' => 'Ei pea. Saate soovitusi ise rakendada.'],
            ['question' => 'Kas audit sobib Ã¼Ã¼rimiseks?', 'answer' => 'Jah, samad pÃµhimÃµtted kehtivad Ã¼Ã¼rikuulutustele.'],
            ['question' => 'Kuidas auditi tellida?', 'answer' => 'Saatke kuulutuse link WhatsAppi vÃµi Telegrami â€” raport 2â€“4 tunniga.'],
        ];
    }

    private function audit1FaqEn(): array
    {
        return [
            ['question' => 'What is a listing audit?', 'answer' => 'Professional review of your KV.ee listing across 27 criteria: photos, copy, price, positioning.'],
            ['question' => 'How much does an audit cost?', 'answer' => 'Basic audit â€” free. Extended with price corridor and strategy â€” from 150 â‚¬.'],
            ['question' => 'How long does an audit take?', 'answer' => '2â€“4 hours. You receive a detailed report with specific recommendations.'],
            ['question' => 'What\'s included in the audit?', 'answer' => 'Photo check, copy analysis, price comparison with corridor, positioning review.'],
            ['question' => 'What results does the audit provide?', 'answer' => 'On average +200â€“400% views and +3â€“5 serious offers within 14 days after optimization.'],
            ['question' => 'Do I need to change my broker?', 'answer' => 'Not necessarily. You can implement recommendations yourself.'],
            ['question' => 'Does the audit work for rentals?', 'answer' => 'Yes, the same principles apply to rental listings.'],
            ['question' => 'How to order an audit?', 'answer' => 'Send your listing link via WhatsApp or Telegram â€” report within 2â€“4 hours.'],
        ];
    }

    // â”€â”€â”€â”€ Audit 2 FAQ â”€â”€â”€â”€

    private function audit2FaqRu(): array
    {
        return [
            ['question' => 'Ð§Ñ‚Ð¾ Ñ‚Ð°ÐºÐ¾Ðµ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Â«Ð´Ð²ÑƒÑ… Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÐµÐ¹Â»?', 'answer' => 'Ð¡Ð¾Ð·Ð´Ð°Ð½Ð¸Ðµ ÐºÐ¾Ð½ÐºÑƒÑ€ÐµÐ½Ñ†Ð¸Ð¸ Ð¼ÐµÐ¶Ð´Ñƒ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑÐ¼Ð¸: ÐºÐ¾Ð³Ð´Ð° ÐµÑÑ‚ÑŒ 2+ Ð·Ð°Ð¸Ð½Ñ‚ÐµÑ€ÐµÑÐ¾Ð²Ð°Ð½Ð½Ñ‹Ñ…, ÐºÐ°Ð¶Ð´Ñ‹Ð¹ Ð³Ð¾Ñ‚Ð¾Ð² Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶Ð¸Ñ‚ÑŒ Ð±Ð¾Ð»ÑŒÑˆÐµ. ÐŸÐ¾Ð·Ð²Ð¾Ð»ÑÐµÑ‚ Ð¿Ð¾Ð»ÑƒÑ‡Ð¸Ñ‚ÑŒ Ð½Ð° 3â€“8% Ð²Ñ‹ÑˆÐµ Ð¿ÐµÑ€Ð²Ð¾Ð³Ð¾ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ.'],
            ['question' => 'ÐžÑ‚ÐºÑƒÐ´Ð° Ð±ÐµÑ€ÑƒÑ‚ÑÑ Ð´Ð°Ð½Ð½Ñ‹Ðµ Ð´Ð»Ñ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°?', 'answer' => 'Ð˜Ð· Ð³Ð¾ÑÑƒÐ´Ð°Ñ€ÑÑ‚Ð²ÐµÐ½Ð½Ð¾Ð³Ð¾ Ñ€ÐµÐµÑÑ‚Ñ€Ð° Maa-amet â€” Ð¾Ñ„Ð¸Ñ†Ð¸Ð°Ð»ÑŒÐ½Ð°Ñ ÑÑ‚Ð°Ñ‚Ð¸ÑÑ‚Ð¸ÐºÐ° Ð²ÑÐµÑ… ÑÐ´ÐµÐ»Ð¾Ðº Ñ Ð½ÐµÐ´Ð²Ð¸Ð¶Ð¸Ð¼Ð¾ÑÑ‚ÑŒÑŽ Ð² Ð­ÑÑ‚Ð¾Ð½Ð¸Ð¸. Ð­Ñ‚Ð¾ Ð½Ðµ Ñ†ÐµÐ½Ñ‹ Ð¾Ð±ÑŠÑÐ²Ð»ÐµÐ½Ð¸Ð¹, Ð° Ñ€ÐµÐ°Ð»ÑŒÐ½Ñ‹Ðµ Ñ†ÐµÐ½Ñ‹ ÑÐ´ÐµÐ»Ð¾Ðº.'],
            ['question' => 'Ð’ÑÐµÐ³Ð´Ð° Ð»Ð¸ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹ Ð¿Ð¾Ð¼Ð¾Ð³Ð°ÑŽÑ‚?', 'answer' => 'Ð’ 90% ÑÐ»ÑƒÑ‡Ð°ÐµÐ². Ð¡Ñ€ÐµÐ´Ð½Ð¸Ð¹ Â«Ð²Ñ‹Ð¸Ð³Ñ€Ñ‹ÑˆÂ» â€” 3â€“8% Ð¾Ñ‚ Ð¿ÐµÑ€Ð²Ð¾Ð³Ð¾ Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ñ. ÐÐ¾ Ð²Ð°Ð¶Ð½Ð° Ð¿Ñ€Ð°Ð²Ð¸Ð»ÑŒÐ½Ð°Ñ Ð°Ñ€Ð³ÑƒÐ¼ÐµÐ½Ñ‚Ð°Ñ†Ð¸Ñ, Ð¾ÑÐ½Ð¾Ð²Ð°Ð½Ð½Ð°Ñ Ð½Ð° Ð´Ð°Ð½Ð½Ñ‹Ñ….'],
            ['question' => 'Ð§Ñ‚Ð¾ ÐµÑÐ»Ð¸ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑŒ Ð½Ðµ Ñ‚Ð¾Ñ€Ð³ÑƒÐµÑ‚ÑÑ?', 'answer' => 'Ð•ÑÐ»Ð¸ Ñ†ÐµÐ½Ð° ÑÐ¿Ñ€Ð°Ð²ÐµÐ´Ð»Ð¸Ð²Ð°Ñ Ð¸ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑŒ Ð¼Ð¾Ñ‚Ð¸Ð²Ð¸Ñ€Ð¾Ð²Ð°Ð½ â€” Ð¾Ð½ Ð¼Ð¾Ð¶ÐµÑ‚ ÑÐ¾Ð³Ð»Ð°ÑÐ¸Ñ‚ÑŒÑÑ ÑÑ€Ð°Ð·Ñƒ. Ð­Ñ‚Ð¾ Ñ…Ð¾Ñ€Ð¾ÑˆÐ¸Ð¹ ÑÑ†ÐµÐ½Ð°Ñ€Ð¸Ð¹.'],
            ['question' => 'ÐÑƒÐ¶ÐµÐ½ Ð»Ð¸ Ð¼Ð½Ðµ Ð¼Ð°ÐºÐ»ÐµÑ€ Ð´Ð»Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð²?', 'answer' => 'Ð ÐµÐºÐ¾Ð¼ÐµÐ½Ð´ÑƒÐµÑ‚ÑÑ. Ð­Ð¼Ð¾Ñ†Ð¸Ð¸ â€” Ð²Ñ€Ð°Ð³ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð². ÐŸÑ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð» Ð²ÐµÐ´Ñ‘Ñ‚ Ð´Ð¸Ð°Ð»Ð¾Ð³ Ð¾Ð±ÑŠÐµÐºÑ‚Ð¸Ð²Ð½Ð¾ Ð¸ Ñ Ð¿Ð¾Ð·Ð¸Ñ†Ð¸Ð¸ Ð´Ð°Ð½Ð½Ñ‹Ñ….'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ Ð´Ð»ÑÑ‚ÑÑ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹?', 'answer' => 'ÐžÐ±Ñ‹Ñ‡Ð½Ð¾ 3â€“7 Ð´Ð½ÐµÐ¹. Ð”Ð²Ð°-Ñ‚Ñ€Ð¸ Ñ€Ð°ÑƒÐ½Ð´Ð° Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹ Ð¸ ÐºÐ¾Ð½Ñ‚Ñ€Ð¿Ñ€ÐµÐ´Ð»Ð¾Ð¶ÐµÐ½Ð¸Ð¹.'],
            ['question' => 'Ð§Ñ‚Ð¾ Ð²ÐºÐ»ÑŽÑ‡Ð°ÐµÑ‚ Ñ€Ð°Ð·Ð±Ð¾Ñ€ CityEE?', 'answer' => 'Ð Ð°ÑÑ‡Ñ‘Ñ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°, Ð°Ð½Ð°Ð»Ð¸Ð· Ñ€Ñ‹Ð½ÐºÐ°, ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸Ñ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð², Ð¿Ð¾Ð´Ð´ÐµÑ€Ð¶ÐºÐ° Ð´Ð¾ Ð·Ð°ÐºÑ€Ñ‹Ñ‚Ð¸Ñ ÑÐ´ÐµÐ»ÐºÐ¸.'],
            ['question' => 'ÐœÐ¾Ð¶Ð½Ð¾ Ð»Ð¸ Ð·Ð°ÐºÐ°Ð·Ð°Ñ‚ÑŒ Ñ‚Ð¾Ð»ÑŒÐºÐ¾ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€ Ð±ÐµÐ· Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð²?', 'answer' => 'Ð”Ð°, Ð±Ð°Ð·Ð¾Ð²Ñ‹Ð¹ Ñ€Ð°ÑÑ‡Ñ‘Ñ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° â€” Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð¾. ÐŸÐ¾Ð»Ð½Ð¾Ðµ ÑÐ¾Ð¿Ñ€Ð¾Ð²Ð¾Ð¶Ð´ÐµÐ½Ð¸Ðµ Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ð¾Ð² â€” Ð¿Ð¾ Ð´Ð¾Ð³Ð¾Ð²Ð¾Ñ€Ñ‘Ð½Ð½Ð¾ÑÑ‚Ð¸.'],
        ];
    }

    private function audit2FaqEt(): array
    {
        return [
            ['question' => 'Mis on "kahe ostja" strateegia?', 'answer' => 'Konkurentsi loomine ostjate vahel: 2+ huvitatud ostjat tÃ¤hendab kÃµrgemat hinda. Annab 3â€“8% esimesest pakkumisest rohkem.'],
            ['question' => 'Kust tulevad koridori andmed?', 'answer' => 'Maa-ameti riiklikust registrist â€” kÃµigi tehingute ametlik statistika.'],
            ['question' => 'Kas lÃ¤birÃ¤Ã¤kimised aitavad alati?', 'answer' => '90% juhtudest. Keskmine "vÃµit" â€” 3â€“8% esimesest pakkumisest.'],
            ['question' => 'Mis siis, kui ostja ei kauple?', 'answer' => 'Kui hind on Ãµiglane ja ostja motiveeritud â€” ta vÃµib kohe nÃµustuda. See on hea stsenaarium.'],
            ['question' => 'Kas mul on lÃ¤birÃ¤Ã¤kimisteks maaklerit vaja?', 'answer' => 'Soovitatav. Emotsioonid on lÃ¤birÃ¤Ã¤kimiste vaenlane.'],
            ['question' => 'Kui kaua lÃ¤birÃ¤Ã¤kimised kestavad?', 'answer' => 'Tavaliselt 3â€“7 pÃ¤eva. 2â€“3 vooru pakkumisi.'],
            ['question' => 'Mida CityEE analÃ¼Ã¼s sisaldab?', 'answer' => 'Koridori arvutus, turu analÃ¼Ã¼s, lÃ¤birÃ¤Ã¤kimisstrateegia, tugi tehingu sulgemiseni.'],
            ['question' => 'Kas saan tellida ainult koridori?', 'answer' => 'Jah, baasarvutus on tasuta. TÃ¤ielik lÃ¤birÃ¤Ã¤kimiste tugi â€” kokkuleppel.'],
        ];
    }

    private function audit2FaqEn(): array
    {
        return [
            ['question' => 'What is the "two buyers" strategy?', 'answer' => 'Creating competition between buyers: with 2+ interested parties, each is willing to offer more. Yields 3â€“8% above the first offer.'],
            ['question' => 'Where does the corridor data come from?', 'answer' => 'Maa-amet state registry â€” official statistics of all real estate transactions in Estonia.'],
            ['question' => 'Do negotiations always help?', 'answer' => 'In 90% of cases. Average "gain" is 3â€“8% above the first offer.'],
            ['question' => 'What if the buyer doesn\'t negotiate?', 'answer' => 'If the price is fair and buyer is motivated â€” they may agree immediately. That\'s a good scenario.'],
            ['question' => 'Do I need a broker for negotiations?', 'answer' => 'Recommended. Emotions are the enemy of negotiations.'],
            ['question' => 'How long do negotiations last?', 'answer' => 'Usually 3â€“7 days. Two-three rounds of offers and counteroffers.'],
            ['question' => 'What does CityEE analysis include?', 'answer' => 'Corridor calculation, market analysis, negotiation strategy, support until closing.'],
            ['question' => 'Can I order just the corridor?', 'answer' => 'Yes, basic calculation is free. Full negotiation support â€” by agreement.'],
        ];
    }

    // â”€â”€â”€â”€ Audit 3 FAQ â”€â”€â”€â”€

    private function audit3FaqRu(): array
    {
        return [
            ['question' => 'Ð§Ñ‚Ð¾ Ð²Ñ…Ð¾Ð´Ð¸Ñ‚ Ð² Ð¿Ð»Ð°Ð½ Â«30â€“45 Ð´Ð½ÐµÐ¹Â»?', 'answer' => 'Ð Ð°ÑÑ‡Ñ‘Ñ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð°, Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹, Ñ„Ð¾Ñ‚Ð¾ÑÑŠÑ‘Ð¼ÐºÐ°, Ð¿ÑƒÐ±Ð»Ð¸ÐºÐ°Ñ†Ð¸Ñ Ð½Ð° KV.ee, Ð¿Ð¾ÐºÐ°Ð·Ñ‹, Ð¿ÐµÑ€ÐµÐ³Ð¾Ð²Ð¾Ñ€Ñ‹, ÑÐ¾Ð¿Ñ€Ð¾Ð²Ð¾Ð¶Ð´ÐµÐ½Ð¸Ðµ Ð´Ð¾ Ð½Ð¾Ñ‚Ð°Ñ€Ð¸ÑƒÑÐ°.'],
            ['question' => 'Ð“Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ñ€ÑƒÐµÑ‚Ðµ Ð»Ð¸ Ð²Ñ‹ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ñƒ Ð·Ð° 45 Ð´Ð½ÐµÐ¹?', 'answer' => 'ÐœÑ‹ Ð½Ðµ Ð´Ð°Ñ‘Ð¼ Ð³Ð°Ñ€Ð°Ð½Ñ‚Ð¸Ð¹ Ð½Ð° ÑÑ€Ð¾Ðº, Ð½Ð¾ 65% Ð½Ð°ÑˆÐ¸Ñ… Ð¾Ð±ÑŠÐµÐºÑ‚Ð¾Ð² Ð¿Ñ€Ð¾Ð´Ð°ÑŽÑ‚ÑÑ Ð·Ð° 30â€“45 Ð´Ð½ÐµÐ¹. Ð•ÑÐ»Ð¸ Ð½ÐµÑ‚ â€” Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð¾ Ð¿ÐµÑ€ÐµÑÐ¼Ð°Ñ‚Ñ€Ð¸Ð²Ð°ÐµÐ¼ ÑÑ‚Ñ€Ð°Ñ‚ÐµÐ³Ð¸ÑŽ.'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ ÑÑ‚Ð¾Ð¸Ñ‚ Ð¿Ð»Ð°Ð½ Ð¿Ñ€Ð¾Ð´Ð°Ð¶Ð¸?', 'answer' => 'Ð Ð°Ð·Ñ€Ð°Ð±Ð¾Ñ‚ÐºÐ° Ð¿Ð»Ð°Ð½Ð° â€” Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ð¾. Ð ÐµÐ°Ð»Ð¸Ð·Ð°Ñ†Ð¸Ñ Ñ Ð¿Ð¾Ð»Ð½Ñ‹Ð¼ ÑÐ¾Ð¿Ñ€Ð¾Ð²Ð¾Ð¶Ð´ÐµÐ½Ð¸ÐµÐ¼ â€” ÑÑ‚Ð°Ð½Ð´Ð°Ñ€Ñ‚Ð½Ð°Ñ ÐºÐ¾Ð¼Ð¸ÑÑÐ¸Ñ 3â€“4%.'],
            ['question' => 'Ð Ð°Ð±Ð¾Ñ‚Ð°ÐµÑ‚ Ð»Ð¸ Ð¿Ð»Ð°Ð½ Ð´Ð»Ñ Ð´Ð¾Ñ€Ð¾Ð³Ð¸Ñ… Ð¾Ð±ÑŠÐµÐºÑ‚Ð¾Ð²?', 'answer' => 'Ð”Ð°, Ð½Ð¾ ÑÑ€Ð¾Ðº Ð¼Ð¾Ð¶ÐµÑ‚ Ð±Ñ‹Ñ‚ÑŒ 45â€“60 Ð´Ð½ÐµÐ¹ Ð´Ð»Ñ Ð¾Ð±ÑŠÐµÐºÑ‚Ð¾Ð² Ð¾Ñ‚ 300 000 â‚¬. ÐŸÑ€Ð¸Ð½Ñ†Ð¸Ð¿Ñ‹ Ñ‚Ðµ Ð¶Ðµ.'],
            ['question' => 'ÐœÐ¾Ð³Ñƒ Ð»Ð¸ Ñ Ñ€ÐµÐ°Ð»Ð¸Ð·Ð¾Ð²Ð°Ñ‚ÑŒ Ð¿Ð»Ð°Ð½ ÑÐ°Ð¼Ð¾ÑÑ‚Ð¾ÑÑ‚ÐµÐ»ÑŒÐ½Ð¾?', 'answer' => 'Ð”Ð°, Ð¸ÑÐ¿Ð¾Ð»ÑŒÐ·ÑƒÐ¹Ñ‚Ðµ Ð½Ð°Ñˆ Ð³Ð°Ð¹Ð´. ÐÐ¾ Ð¿Ñ€Ð¾Ñ„ÐµÑÑÐ¸Ð¾Ð½Ð°Ð»ÑŒÐ½Ð¾Ðµ ÑÐ¾Ð¿Ñ€Ð¾Ð²Ð¾Ð¶Ð´ÐµÐ½Ð¸Ðµ Ð¿Ð¾Ð²Ñ‹ÑˆÐ°ÐµÑ‚ Ñ€ÐµÐ·ÑƒÐ»ÑŒÑ‚Ð°Ñ‚ Ð½Ð° 10â€“20%.'],
            ['question' => 'Ð§Ñ‚Ð¾ ÐµÑÐ»Ð¸ Ð¿Ð¾ÐºÑƒÐ¿Ð°Ñ‚ÐµÐ»ÑŒ Ñ‚Ñ€ÐµÐ±ÑƒÐµÑ‚ ÑÐºÑÐ¿ÐµÑ€Ñ‚Ð¸Ð·Ñƒ?', 'answer' => 'Ð­Ñ‚Ð¾ Ð½Ð¾Ñ€Ð¼Ð°Ð»ÑŒÐ½Ð¾. Ð—Ð°ÐºÐ»Ð°Ð´Ñ‹Ð²Ð°ÐµÐ¼ 3â€“5 Ð´Ð½ÐµÐ¹ Ð½Ð° Ñ‚ÐµÑ…Ð½Ð¸Ñ‡ÐµÑÐºÑƒÑŽ Ð¿Ñ€Ð¾Ð²ÐµÑ€ÐºÑƒ. ÐžÐ±Ñ‹Ñ‡Ð½Ð¾ Ð½Ðµ Ð²Ð»Ð¸ÑÐµÑ‚ Ð½Ð° Ñ„Ð¸Ð½Ð°Ð»ÑŒÐ½Ñ‹Ð¹ ÑÑ€Ð¾Ðº.'],
            ['question' => 'Ð¡ÐºÐ¾Ð»ÑŒÐºÐ¾ ÑÑ‚Ð¾Ð¸Ñ‚ Ð¿Ð¾Ð´Ð³Ð¾Ñ‚Ð¾Ð²ÐºÐ° ÐºÐ²Ð°Ñ€Ñ‚Ð¸Ñ€Ñ‹?', 'answer' => 'ÐœÐ¸Ð½Ð¸Ð¼Ð°Ð»ÑŒÐ½Ñ‹Ð¹ Ð¿Ð°ÐºÐµÑ‚: 200â€“500 â‚¬. Ð’ÐºÐ»ÑŽÑ‡Ð°ÐµÑ‚: Ð³ÐµÐ½ÐµÑ€Ð°Ð»ÑŒÐ½Ð°Ñ ÑƒÐ±Ð¾Ñ€ÐºÐ°, Ð¼ÐµÐ»ÐºÐ¸Ð¹ Ñ€ÐµÐ¼Ð¾Ð½Ñ‚, Ñ„Ð¾Ñ‚Ð¾ÑÑŠÑ‘Ð¼ÐºÐ°.'],
            ['question' => 'ÐšÐ°Ðº Ð·Ð°Ð¿ÑƒÑÑ‚Ð¸Ñ‚ÑŒ Ð¿Ð»Ð°Ð½?', 'answer' => 'ÐÐ°Ð¿Ð¸ÑˆÐ¸Ñ‚Ðµ Ð² WhatsApp Ð¸Ð»Ð¸ Telegram. ÐŸÐµÑ€Ð²Ñ‹Ð¹ ÑˆÐ°Ð³: Ð±ÐµÑÐ¿Ð»Ð°Ñ‚Ð½Ñ‹Ð¹ Ñ€Ð°ÑÑ‡Ñ‘Ñ‚ ÐºÐ¾Ñ€Ð¸Ð´Ð¾Ñ€Ð° Ð·Ð° 2 Ñ‡Ð°ÑÐ°.'],
        ];
    }

    private function audit3FaqEt(): array
    {
        return [
            ['question' => 'Mida "30â€“45 pÃ¤eva" plaan sisaldab?', 'answer' => 'Koridori arvutus, ettevalmistus, fotod, KV.ee avaldamine, nÃ¤itamised, lÃ¤birÃ¤Ã¤kimised, tugi notarini.'],
            ['question' => 'Kas garanteerite mÃ¼Ã¼gi 45 pÃ¤evaga?', 'answer' => 'Garantiid ei anna, aga 65% meie objektidest mÃ¼Ã¼akse 30â€“45 pÃ¤evaga.'],
            ['question' => 'Palju mÃ¼Ã¼giplaan maksab?', 'answer' => 'Plaani koostamine â€” tasuta. TÃ¤issaatmine â€” standardne vahendustasu 3â€“4%.'],
            ['question' => 'Kas plaan tÃ¶Ã¶tab kallimate objektidega?', 'answer' => 'Jah, aga aeg vÃµib olla 45â€“60 pÃ¤eva objektidel alates 300 000 â‚¬.'],
            ['question' => 'Kas saan plaani ise ellu viia?', 'answer' => 'Jah, kasutage meie juhendit. Professionaalne tugi parandab tulemust 10â€“20%.'],
            ['question' => 'Mis siis, kui ostja tahab ekspertiisi?', 'answer' => 'See on normaalne. Arvestame 3â€“5 pÃ¤eva tehniliseks kontrolliks.'],
            ['question' => 'Palju ettevalmistus maksab?', 'answer' => 'Miinimumpakett: 200â€“500 â‚¬. Sisaldab: koristus, vÃ¤ikremont, fotod.'],
            ['question' => 'Kuidas plaani kÃ¤ivitada?', 'answer' => 'Kirjutage WhatsAppi vÃµi Telegrami. Esimene samm: tasuta koridori arvutus 2 tunniga.'],
        ];
    }

    private function audit3FaqEn(): array
    {
        return [
            ['question' => 'What\'s included in the "30â€“45 day" plan?', 'answer' => 'Corridor calculation, preparation, photos, KV.ee publication, showings, negotiations, support until notary.'],
            ['question' => 'Do you guarantee a sale in 45 days?', 'answer' => 'No guarantee on timing, but 65% of our properties sell in 30â€“45 days.'],
            ['question' => 'How much does the sales plan cost?', 'answer' => 'Plan development â€” free. Full execution â€” standard commission 3â€“4%.'],
            ['question' => 'Does the plan work for expensive properties?', 'answer' => 'Yes, but timeline may be 45â€“60 days for properties above 300,000 â‚¬.'],
            ['question' => 'Can I execute the plan independently?', 'answer' => 'Yes, use our guide. Professional support improves results by 10â€“20%.'],
            ['question' => 'What if the buyer requests an inspection?', 'answer' => 'Normal. We budget 3â€“5 days for technical inspection.'],
            ['question' => 'How much does preparation cost?', 'answer' => 'Minimum package: 200â€“500 â‚¬. Includes: deep cleaning, minor repairs, photos.'],
            ['question' => 'How to start the plan?', 'answer' => 'Message us on WhatsApp or Telegram. First step: free corridor calculation within 2 hours.'],
        ];
    }
}

