<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Guards the SEO indexation contract so the GSC problems fixed in
 * docs/seo-indexation-fix-report.md cannot silently regress.
 *
 * RefreshDatabase builds the schema in the in-memory test DB so DB-backed
 * routes (/guides, /audits) resolve to 200/404 rather than a "no such table"
 * 500 that would only ever occur in the test environment.
 */
class SeoIndexationTest extends TestCase
{
    use RefreshDatabase;

    /** robots.txt is served, declares the sitemap, and blocks nothing important. */
    public function test_robots_txt_is_correct(): void
    {
        $res = $this->get('/robots.txt');
        $res->assertOk();
        $body = $res->getContent();

        $this->assertStringContainsString('Sitemap: https://cityee.ee/sitemap.xml', $body);
        $this->assertStringContainsString('Allow: /', $body);

        // Must NOT block language folders or content-filter params.
        $this->assertStringNotContainsString("Disallow: /ru\n", $body);
        $this->assertStringNotContainsString("Disallow: /ru/\n", $body);
        $this->assertStringNotContainsString("Disallow: /en\n", $body);
        $this->assertStringNotContainsString('Disallow: /*?category=', $body);
        $this->assertStringNotContainsString('Disallow: /guides', $body);
        $this->assertStringNotContainsString('Disallow: /knowledge', $body);
    }

    /** sitemap.xml and all child sitemaps respond 200. */
    public function test_sitemaps_respond_ok(): void
    {
        foreach ([
            '/sitemap.xml', '/sitemap-main.xml', '/sitemap-guides.xml',
            '/sitemap-audits.xml', '/sitemap-phase3.xml', '/sitemap-knowledge.xml',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }

    /** Core public pages across all three languages return 200. */
    public function test_core_public_pages_return_200(): void
    {
        foreach ([
            '/', '/ru', '/en',
            '/kinnisvara-muuk', '/ru/kinnisvara-muuk', '/en/sell-property',
            '/kontaktid', '/en/contacts', '/audit',
            '/guides', '/ru/guides', '/en/guides',
            '/aleksandr-primakov', '/muua-ise-vs-strateegiline-partner',
            '/knowledge/labirakimiste-strateegia-kinnisvara',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }

    /** Query-filter URLs 301 to the clean canonical — never 403/500. */
    public function test_query_filter_urls_redirect_not_forbidden(): void
    {
        $this->get('/guides?category=pricing')->assertRedirect('/guides');
        $this->get('/guides?category=rent')->assertRedirect('/guides');
        $this->get('/en/guides?category=pricing')->assertRedirect('/en/guides');
    }

    /** Obsolete / changed slugs 301 (one hop) to a live equivalent. */
    public function test_obsolete_slugs_redirect(): void
    {
        $this->get('/en/index')->assertRedirect('/en');
        $this->get('/knowledge/labiraakimiste-strateegia-kinnisvara')
            ->assertRedirect('/knowledge/labirakimiste-strateegia-kinnisvara');
        $this->get('/ru/kvartira-ne-prodaetsya')
            ->assertRedirect('/ru/ne-prodaetsya-kvartira-v-tallinne');
        $this->get('/guides/seo-strategi-2026')->assertRedirect('/guides');
    }

    /** Invalid slugs return 404 — never 403 or 500. */
    public function test_invalid_slugs_return_404(): void
    {
        foreach ([
            '/knowledge/this-does-not-exist',
            '/guides/nonexistent-guide',
            '/ru/tallinn/nonexistent-district',
        ] as $path) {
            $this->get($path)->assertNotFound();
        }
    }

    /** Legacy subdomain / www hosts 301 to the canonical path-based host. */
    public function test_legacy_hosts_redirect_to_canonical(): void
    {
        $this->get('http://ru.cityee.ee/kinnisvara-muuk')
            ->assertRedirect('https://cityee.ee/ru/kinnisvara-muuk');
        $this->get('http://www.cityee.ee/guides')
            ->assertRedirect('https://cityee.ee/guides');
    }

    /** Googlebot UA gets the SAME status as a normal browser (parity). */
    public function test_googlebot_parity_on_public_pages(): void
    {
        $ua = ['User-Agent' => 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)'];
        $this->withHeaders($ua)->get('/')->assertOk();
        $this->withHeaders($ua)->get('/aleksandr-primakov')->assertOk();
        $this->withHeaders($ua)->get('/guides?category=pricing')->assertRedirect('/guides');
    }
}
