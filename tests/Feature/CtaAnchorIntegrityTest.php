<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * PAID_DESTINATION_ANCHOR_INTEGRITY V1 — every fragment CTA a visitor can
 * actually reach must point at an id that exists in the same document.
 *
 * Guards three defects found live on 2026-10-24/25:
 *   AI-01  /audit, /ru/audit/, /en/audit sticky CTA -> #v3-form-audit (absent)
 *   AI-02  the same pages' floating calculator      -> #v3-form-calc  (absent)
 *   AI-03  the Bank PPC page's floating calculator  -> #v3-form-calc  (absent)
 *
 * The suppression in AI-02/AI-03 is page-local CSS, so the dead href survives
 * in the raw markup by design. These tests therefore assert on the *visible*
 * contract: a control is acceptable when its target exists OR the page hides
 * it, and never acceptable when it is both reachable and dangling.
 */
class CtaAnchorIntegrityTest extends TestCase
{
    /** Ids and anchor names defined in a document. */
    private function targets(string $html): array
    {
        preg_match_all('/\bid="([^"]+)"/i', $html, $ids);
        preg_match_all('/<a\b[^>]*\bname="([^"]+)"/i', $html, $names);

        return array_flip(array_merge($ids[1], $names[1]));
    }

    /** True when a page-local <style> block hides the given class outright. */
    private function hiddenByPageCss(string $html, string $class): bool
    {
        preg_match_all('#<style\b[^>]*>(.*?)</style>#is', $html, $blocks);
        foreach ($blocks[1] as $css) {
            $pattern = '/[^{}]*\b' . preg_quote($class, '/') . '\b[^{}]*\{[^}]*display\s*:\s*none[^}]*\}/i';
            if (preg_match($pattern, $css)) {
                return true;
            }
        }

        return false;
    }

    private function stickyCtaHref(string $html): ?string
    {
        if (! preg_match('/<a\b[^>]*class="[^"]*\bsticky-cta__btn\b[^"]*"[^>]*>/i', $html, $tag)) {
            return null;
        }

        return preg_match('/href="([^"]*)"/i', $tag[0], $h) ? $h[1] : null;
    }

    /** AI-01 — the sticky bar reaches the audit form that the page really has. */
    public function test_audit_sticky_cta_points_at_the_existing_audit_form(): void
    {
        foreach (['/audit/', '/ru/audit/', '/en/audit/'] as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();

            $this->assertSame('#audit-form', $this->stickyCtaHref($html),
                "Sticky CTA must target #audit-form on {$url}");
            $this->assertArrayHasKey('audit-form', $this->targets($html),
                "#audit-form must exist on {$url}");
            $this->assertSame(1, substr_count($html, 'id="audit-form"'),
                "#audit-form must be defined exactly once on {$url}");
        }
    }

    /** AI-02 — the calculator control is gone from the audit pages, not re-aimed. */
    public function test_audit_pages_suppress_the_calculator_control(): void
    {
        foreach (['/audit/', '/ru/audit/', '/en/audit/'] as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();

            $this->assertTrue($this->hiddenByPageCss($html, 'sticky-btn--calc'),
                "Audit must hide the floating calculator on {$url}");
            $this->assertArrayNotHasKey('v3-form-calc', $this->targets($html),
                "Audit must not grow a calculator form on {$url}");
            // The dead href must never be quietly re-pointed at the audit form
            // while still saying "calculate the price".
            $this->assertStringContainsString('href="#v3-form-calc"', $html,
                "Expected the suppressed control to keep its own href on {$url}");
        }
    }

    /** AI-03 — Bank hides the calculator; Lasnamae keeps its working one. */
    public function test_paid_landing_pages_keep_their_own_single_job(): void
    {
        $bank = $this->get('/ru/lp/ocenochnyy-akt-dlya-banka/')->assertStatus(200)->getContent();
        $this->assertTrue($this->hiddenByPageCss($bank, 'sticky-btn--calc'),
            'Bank must hide the floating calculator at every width');
        $this->assertSame('#v3-form-bank', $this->stickyCtaHref($bank));
        $this->assertArrayHasKey('v3-form-bank', $this->targets($bank));
        $this->assertArrayNotHasKey('v3-form-calc', $this->targets($bank));

        $lasnamae = $this->get('/ru/lp/ocenka-lasnamae/')->assertStatus(200)->getContent();
        $this->assertFalse($this->hiddenByPageCss($lasnamae, 'sticky-btn--calc'),
            'Lasnamae calculator works and must stay visible');
        $this->assertSame('#v3-form-calc', $this->stickyCtaHref($lasnamae));
        $this->assertArrayHasKey('v3-form-calc', $this->targets($lasnamae));
    }

    /**
     * No page in the targeted corpus may offer a reachable fragment CTA whose
     * destination is missing. Controls hidden by page-local CSS are excluded,
     * which is exactly the distinction the release has to hold.
     */
    public function test_no_reachable_fragment_cta_is_dangling(): void
    {
        $urls = [
            '/audit/', '/ru/audit/', '/en/audit/',
            '/ru/lp/ocenochnyy-akt-dlya-banka/',
            '/ru/lp/ocenka-lasnamae/',
            '/ru/ne-prodaetsya-kvartira-v-tallinne/',
        ];

        foreach ($urls as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();
            $targets = $this->targets($html);

            preg_match_all('/<a\b([^>]*\bhref="#([^"]+)"[^>]*)>/i', $html, $links, PREG_SET_ORDER);

            $dangling = [];
            foreach ($links as $link) {
                [, $attrs, $fragment] = $link;
                if (isset($targets[$fragment])) {
                    continue;
                }
                if (preg_match('/class="([^"]*)"/i', $attrs, $c)
                    && preg_match('/\b(sticky-btn--[a-z]+)\b/i', $c[1], $cls)
                    && $this->hiddenByPageCss($html, $cls[1])) {
                    continue; // suppressed page-locally, not reachable
                }
                $dangling[] = '#' . $fragment;
            }

            $this->assertSame([], array_values(array_unique($dangling)),
                "Reachable CTA(s) pointing at a missing fragment on {$url}");
        }
    }

    /** Both operator-confirmed WhatsApp numbers stay reachable, unchanged. */
    public function test_both_whatsapp_recipients_survive(): void
    {
        foreach (['/ru/audit/', '/ru/lp/ocenochnyy-akt-dlya-banka/'] as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();
            $this->assertStringContainsString('wa.me/3725113411', $html, "on {$url}");
            $this->assertStringContainsString('37258829892', $html, "on {$url}");
        }
    }
}
