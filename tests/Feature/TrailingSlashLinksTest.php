<?php

namespace Tests\Feature;

use App\Console\Commands\SeoAuditProductionCommand;
use ReflectionMethod;
use Tests\TestCase;

/**
 * X999^5 §8/§9 — trailing-slash internal links + audit-cache slash safety.
 * Exercises the real middleware through rendered routes (not hard-coded output).
 */
class TrailingSlashLinksTest extends TestCase
{
    /** Every internal content <a href> on a rendered page ends with a slash. */
    public function test_internal_content_links_use_trailing_slash(): void
    {
        foreach (['/ru/', '/ru/makler-v-tallinne/'] as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();

            preg_match_all('/<a\b[^>]*\bhref=(["\'])([^"\']*)\1/i', $html, $m);
            $offenders = [];
            foreach ($m[2] as $href) {
                if ($href === '' || str_contains($href, '?') || str_contains($href, '#')) {
                    continue;
                }
                // Resolve to a path for internal (root-relative or same-host absolute).
                if ($href[0] === '/' && ! str_starts_with($href, '//')) {
                    $path = $href;
                } elseif (preg_match('#^https?://(?:localhost|127\.0\.0\.1|cityee\.ee|www\.cityee\.ee)(/.*)$#i', $href, $u)) {
                    $path = $u[1];
                } else {
                    continue; // external / mailto / tel
                }
                $lastSegment = substr($path, strrpos($path, '/') + 1);
                if (str_contains($lastSegment, '.')) {
                    continue; // asset
                }
                if ($path !== '/' && ! str_ends_with($path, '/')) {
                    $offenders[] = $href;
                }
            }

            $this->assertSame([], array_values(array_unique($offenders)),
                "Internal content links without trailing slash on {$url}");
        }
    }

    /** The normalizer must NOT touch assets, external hosts, mailto/tel, or query URLs. */
    public function test_normalizer_leaves_special_links_untouched(): void
    {
        $html = $this->get('/ru/')->assertStatus(200)->getContent();

        // asset links keep their extension (no slash appended after .png/.css)
        $this->assertMatchesRegularExpression('#href=["\'][^"\']+\.(?:png|css|js|jpe?g|svg)["\']#i', $html);
        // mailto/tel untouched
        $this->assertStringContainsString('mailto:', $html);
    }

    /** §9 regression: /x and /x/ must map to DISTINCT status-cache keys. */
    public function test_audit_production_cache_key_distinguishes_slash(): void
    {
        $cmd = new SeoAuditProductionCommand();
        $ref = new ReflectionMethod($cmd, 'cacheKey');
        $ref->setAccessible(true);

        // host property is set in handle(); the method only reads it as a fallback,
        // and our URLs are absolute, so it isn't needed here.
        $a = $ref->invoke($cmd, 'https://cityee.ee/ru/guides');
        $b = $ref->invoke($cmd, 'https://cityee.ee/ru/guides/');

        $this->assertNotSame($a, $b, '/x and /x/ must not share a cache key');
        $this->assertSame('https://cityee.ee/ru/guides', $a);
        $this->assertSame('https://cityee.ee/ru/guides/', $b);
    }
}
