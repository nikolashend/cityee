<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * X999^5 §18 — first-party lead attribution regression suite.
 * Exercises the real middleware + controllers + service through routes.
 */
class LeadAttributionTest extends TestCase
{
    use RefreshDatabase;

    /** UTM + GCLID from the landing survive an internal navigation and reach the lead. */
    public function test_utm_and_gclid_preserved_through_navigation_to_lead(): void
    {
        $this->get('/ru/prodat-kvartiru-v-tallinne/?utm_source=google&utm_medium=cpc&utm_campaign=spring&gclid=ABC123');
        $this->get('/ru/makler-v-tallinne/');   // internal navigation, no params
        $this->postJson('/contact/callback', ['name' => 'A', 'tel' => '+372500'])->assertOk();

        $lead = Lead::firstOrFail();
        $this->assertSame('callback', $lead->form_type);
        $this->assertSame('google_ads', $lead->first_touch_source);
        $this->assertSame('google_ads', $lead->last_touch_source);
        $this->assertSame('ABC123', $lead->last_touch_gclid);
        $this->assertSame('spring', $lead->last_touch_campaign);
        $this->assertStringContainsString('/ru/prodat-kvartiru-v-tallinne', (string) $lead->landing_page);
    }

    /** A direct return must NOT overwrite a known non-direct first touch. */
    public function test_direct_return_does_not_overwrite_first_touch(): void
    {
        $this->get('/ru/?utm_source=newsletter&utm_medium=email&utm_campaign=june');
        $this->get('/ru/');   // direct-style return, no params
        $this->postJson('/contact/inquiry', ['name' => 'B', 'tel' => '+372501'])->assertOk();

        $lead = Lead::firstOrFail();
        $this->assertSame('other_organic', $lead->first_touch_source);   // newsletter/email
        $this->assertSame('june', $lead->first_touch_campaign);
    }

    /** A new paid click updates last touch (first touch unchanged). */
    public function test_new_paid_click_updates_last_touch(): void
    {
        $this->get('/ru/?utm_source=facebook&utm_medium=social&utm_campaign=fb1');
        $this->get('/ru/ocenka-kvartiry-v-tallinne/?gclid=NEWPAID');   // later paid click
        $this->postJson('/contact/callback', ['name' => 'C', 'tel' => '+372502'])->assertOk();

        $lead = Lead::firstOrFail();
        $this->assertSame('other_organic', $lead->first_touch_source);  // fb social first
        $this->assertSame('google_ads', $lead->last_touch_source);      // paid last
        $this->assertSame('NEWPAID', $lead->last_touch_gclid);
    }

    /** Repeated identical submissions collapse to ONE lead. */
    public function test_duplicate_submissions_create_one_lead(): void
    {
        $payload = ['name' => 'Dup', 'tel' => '+37255511122'];
        for ($i = 0; $i < 4; $i++) {
            $this->postJson('/contact/callback', $payload)->assertOk();
        }
        $this->assertSame(1, Lead::where('form_type', 'callback')->count());
    }

    /** The lead is persisted even when mail delivery fails (no mail server in tests). */
    public function test_lead_saved_even_when_mail_fails(): void
    {
        $this->postJson('/contact/inquiry', ['name' => 'M', 'tel' => '+372503'])->assertOk();
        $lead = Lead::firstOrFail();
        $this->assertContains($lead->mail_status, ['sent', 'failed']);
        $this->assertNotNull($lead->id);   // saved regardless of mail outcome
    }

    /** Malformed / oversized attribution params are sanitized, never stored raw. */
    public function test_params_are_sanitized(): void
    {
        $evil = '<script>alert(1)</script>';
        $huge = str_repeat('x', 5000);
        $this->get('/ru/?utm_source=' . urlencode($evil) . '&utm_campaign=' . urlencode($huge) . '&gclid=' . urlencode($evil));
        $this->postJson('/contact/callback', ['name' => 'S', 'tel' => '+372504'])->assertOk();

        $lead = Lead::firstOrFail();
        $this->assertStringNotContainsString('<script', (string) json_encode($lead->last_touch_json));
        $this->assertLessThanOrEqual(120, mb_strlen((string) $lead->last_touch_campaign));
    }

    /** The analytics payload (for GA4) must contain NO PII. */
    public function test_analytics_payload_has_no_pii(): void
    {
        $this->postJson('/contact/inquiry', [
            'name' => 'Ivan Petrov', 'tel' => '+37255599900', 'email' => 'ivan@example.com', 'comment' => 'secret',
        ])->assertOk();

        $payload = Lead::firstOrFail()->analyticsPayload();
        $blob = strtolower(json_encode($payload));
        foreach (['ivan', 'petrov', '55599900', 'example.com', 'secret'] as $pii) {
            $this->assertStringNotContainsString($pii, $blob, "PII leaked into analytics payload: {$pii}");
        }
        $this->assertArrayHasKey('lead_public_id', $payload);
        $this->assertArrayHasKey('source_class', $payload);
    }

    /** All four form types persist a lead with the correct form_type. */
    public function test_all_four_form_types_create_leads(): void
    {
        $this->postJson('/contact/callback', ['name' => 'a', 'tel' => '1'])->assertOk();
        $this->postJson('/contact/inquiry', ['name' => 'b', 'tel' => '2'])->assertOk();
        $this->postJson('/contact/audit-request', ['type' => 'apartment', 'goal' => 'sell', 'contact' => 'c'])->assertOk();
        $this->postJson('/contact/price-calculator', ['address' => 'Viru 2', 'contact' => 'd'])->assertOk();

        $this->assertEqualsCanonicalizing(
            ['callback', 'inquiry', 'audit', 'price_calculator'],
            Lead::pluck('form_type')->all()
        );
    }

    /** An internal referrer must not be classified as an external source. */
    public function test_internal_referrer_not_treated_as_source(): void
    {
        $this->get('/ru/', ['referer' => 'https://cityee.ee/ru/makler-v-tallinne/']);
        $this->postJson('/contact/callback', ['name' => 'I', 'tel' => '+372505'])->assertOk();
        $this->assertSame('direct', Lead::firstOrFail()->first_touch_source);
    }
}
