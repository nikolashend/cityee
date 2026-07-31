<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * X999^5 revenue-safe closure — protected winners, form routes, SQLite safety.
 * Locks the invariants the current deploy must not break. Exercises real routes.
 */
class RevenueSafeClosureTest extends TestCase
{
    /** Protected winners return 200 with a canonical, a title and an H1 (INV-001). */
    public function test_protected_winners_render_with_canonical_title_and_h1(): void
    {
        $winners = [
            '/', '/ru/', '/ru/makler-v-tallinne/', '/ru/prodat-kvartiru-v-tallinne/',
            '/ru/ocenka-kvartiry-v-tallinne/', '/ru/agentstvo-nedvizhimosti-tallinn/',
            '/ru/kinnisvara-uur/', '/ru/aleksandr-primakov/', '/ru/tallinn/',
        ];
        foreach ($winners as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();
            $this->assertMatchesRegularExpression('#<link[^>]+rel=["\']canonical["\']#i', $html, "no canonical on {$url}");
            $this->assertMatchesRegularExpression('#<title>.+</title>#is', $html, "no <title> on {$url}");
            $this->assertMatchesRegularExpression('#<h1[^>]*>.*?\S.*?</h1>#is', $html, "no non-empty <h1> on {$url}");
        }
    }

    /** The 4 lead-form routes exist and enforce required-field validation (unchanged logic). */
    public function test_lead_form_routes_exist_and_validate(): void
    {
        // Missing required fields → 422 (validation), proving the route + rules are intact.
        $this->postJson('/contact/callback', [])->assertStatus(422);
        $this->postJson('/contact/inquiry', [])->assertStatus(422);
        $this->postJson('/contact/audit-request', [])->assertStatus(422);
        $this->postJson('/contact/price-calculator', [])->assertStatus(422);
    }

    /** Form <form action> POST endpoints are never rewritten to trailing-slash by the normalizer. */
    public function test_form_actions_are_not_slash_normalized(): void
    {
        $html = $this->get('/ru/kontaktid/')->assertStatus(200)->getContent();
        // The normalizer only touches <a href>; POST actions must remain slash-free routes.
        $this->assertStringNotContainsString('action="/contact/callback/"', $html);
        $this->assertStringNotContainsString('action="/contact/inquiry/"', $html);
    }

    /** SQLite DB must be gitignored (never version-controlled). */
    public function test_sqlite_database_is_gitignored(): void
    {
        $ignored = @file_get_contents(base_path('database/.gitignore'));
        $this->assertNotFalse($ignored, 'database/.gitignore missing');
        $this->assertStringContainsString('sqlite', $ignored, 'sqlite not ignored');
    }
}
