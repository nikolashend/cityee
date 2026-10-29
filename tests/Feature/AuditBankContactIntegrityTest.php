<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * AUDIT_BANK_CONTACT_INTEGRITY V1.
 *
 * `/contact/price-calculator` was fixed on 2026-10-27 (83007d2). The same
 * `required|string|max:255` contact rule was still live on the two other
 * backend lead endpoints, so both would accept a submission nobody can answer:
 *
 *   POST /contact/audit-request   — form_type `audit`
 *   POST /contact/bank-appraisal  — form_type `bank_appraisal`
 *
 * Mail is only ever sent from inside LeadService::record(), after a Lead row
 * exists, so "no Lead row" is also proof that no notification was sent and no
 * success response could carry a generate_lead payload.
 *
 * Two contact contracts, deliberately different, because the two forms promise
 * different things to the visitor:
 *
 *   audit   — its label reads "Telefon / WhatsApp / Telegram", so a Telegram
 *             handle is a channel the page itself offers and must be accepted.
 *   bank    — phone or email only; no Telegram is offered on that landing page.
 *
 * No production request is made anywhere in this file and no real customer
 * data is used as a fixture: every value is synthetic.
 */
class AuditBankContactIntegrityTest extends TestCase
{
    use RefreshDatabase;

    private const AUDIT = '/contact/audit-request';
    private const BANK  = '/contact/bank-appraisal';
    private const CALC  = '/contact/price-calculator';

    private function auditPayload(array $override = []): array
    {
        return array_merge([
            'link'     => 'https://www.kv.ee/kuulutus/0000000',
            'district' => 'Lasnamäe',
            'type'     => 'apartment',
            'goal'     => 'sell',
            'language' => 'ru',
            'locale'   => 'ru',
        ], $override);
    }

    private function bankPayload(array $override = []): array
    {
        return array_merge([
            'address' => 'Punane 1, Tallinn',
            'bank'    => 'Swedbank',
            'purpose' => 'Ипотека',
            'locale'  => 'ru',
        ], $override);
    }

    // ────────────────────────────────────────────────────────────────────
    //  AU — /contact/audit-request
    // ────────────────────────────────────────────────────────────────────

    /** AU-01, AU-02, AU-03, AU-04, AU-05(invalid email), AU-06, AU-07. */
    public function test_au_unreachable_audit_contact_is_rejected(): void
    {
        $unreachable = [
            'AU-01 missing'          => null,
            'AU-01 empty'            => '',
            'AU-01 whitespace'       => "   \t ",
            'AU-02 ru no'            => 'Нет',
            'AU-02 ru no lower'      => 'нет',
            'AU-02 en no'            => 'No',
            'AU-02 none'             => 'none',
            'AU-02 n/a'              => 'N/A',
            'AU-02 dash'             => '-',
            'AU-02 question'         => '???',
            'AU-04 test'             => 'test',
            'AU-04 word'             => 'abc',
            'AU-03 email no at'      => 'ownermail.com',
            'AU-03 email no domain'  => 'owner@',
            'AU-03 email bad domain' => 'owner@example..com',
            'AU-03 email no local'   => '@example.com',
            'AU-06 digits too few'   => '12345',
            'AU-06 digits too many'  => '1234567890123456789',
            'AU-07 repeated digit'   => '0000000000',
            'AU-07 counting up'      => '1234567',
            // A bare word is NOT treated as a Telegram handle: only an explicit
            // @handle or a t.me/ link is, so junk cannot slip through that door.
            'AU-07 bare word 5ch'    => 'nikol',
            'AU-07 bare word long'   => 'someusername',
            // Not a Telegram handle: too short, or illegal characters.
            'AU-07 short handle'     => '@abc',
            'AU-07 dotted handle'    => '@owner.name',
        ];

        foreach ($unreachable as $id => $value) {
            Lead::query()->delete();

            $payload = $this->auditPayload();
            if ($value !== null) {
                $payload['contact'] = $value;
            }

            $response = $this->postJson(self::AUDIT, $payload);

            $this->assertSame(422, $response->status(), "{$id}: expected 422");
            $response->assertJsonValidationErrors('contact');
            $this->assertSame(0, Lead::count(), "{$id}: no lead may be stored");
        }
    }

    /** AU-04, AU-05, AU-06 — a real channel is accepted and stored verbatim. */
    public function test_au_reachable_audit_contact_is_accepted(): void
    {
        $reachable = [
            'AU-04 estonian mobile'   => '+372 5555 1234',
            'AU-04 landline 7 digits' => '6001234',
            'AU-05 international'     => '+44 7700 900123',
            'AU-05 punctuation'       => '(372) 555-11-22',
            'AU-05 whatsapp prefix'   => 'WhatsApp 5551234',
            'AU-06 email mixed case'  => 'Owner.Name@Example.COM',
            'AU-06 email plus tag'    => 'owner+kv@example.com',
            // The audit label offers Telegram, so these must work.
            'AU-TG handle'            => '@owner_tallinn',
            'AU-TG t.me link'         => 't.me/owner_tallinn',
            'AU-TG https t.me link'   => 'https://t.me/owner_tallinn',
        ];

        foreach ($reachable as $id => $value) {
            Lead::query()->delete();

            $response = $this->postJson(self::AUDIT, $this->auditPayload(['contact' => $value]));

            $this->assertSame(200, $response->status(), "{$id}: expected 200");
            $response->assertJsonPath('status', 'OK');
            $this->assertSame(1, Lead::count(), "{$id}: exactly one lead");

            $lead = Lead::first();
            $this->assertSame('audit', $lead->form_type, "{$id}: form_type must stay 'audit'");
            $this->assertSame(trim($value), $lead->phone, "{$id}: contact stored verbatim");
        }
    }

    /** AU-08 — a double submit yields one lead, one mail, one logical event. */
    public function test_au_duplicate_submission_is_idempotent(): void
    {
        $payload = $this->auditPayload(['contact' => '+372 5555 1234']);

        $first  = $this->postJson(self::AUDIT, $payload);
        $second = $this->postJson(self::AUDIT, $payload);

        $first->assertStatus(200);
        $second->assertStatus(200);
        $this->assertSame(1, Lead::count(), 'the 10-minute fingerprint must collapse the retry');
        $this->assertSame(
            $first->json('lead.lead_public_id'),
            $second->json('lead.lead_public_id'),
            'the same lead id must come back, so no second conversion can fire'
        );
    }

    /** AU-09 — the non-JSON (no-JS) path rejects too, and never 500s. */
    public function test_au_form_post_without_json_is_rejected_not_crashed(): void
    {
        $response = $this->from('/ru/')->post(self::AUDIT, $this->auditPayload(['contact' => 'Нет']));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('contact');
        $this->assertSame(0, Lead::count());
    }

    /** AU-09 — a localised message is returned for each locale. */
    public function test_au_rejection_message_follows_the_locale(): void
    {
        foreach (['ru', 'et', 'en'] as $locale) {
            $response = $this->postJson(self::AUDIT, $this->auditPayload([
                'contact' => 'Нет',
                'locale'  => $locale,
            ]));

            $response->assertStatus(422);
            $message = $response->json('errors.contact.0');

            $this->assertNotEmpty($message, "{$locale}: a message is required");
            $this->assertStringNotContainsStringIgnoringCase(
                'validation.',
                $message,
                "{$locale}: must not leak a raw translation key"
            );
        }
    }

    /**
     * AU-10 — the endpoints stay inside the CSRF-protected web group.
     *
     * VerifyCsrfToken deliberately stands down while the test suite runs, so a
     * 419 cannot be asserted here. What can be asserted, and is what actually
     * matters, is that the route still resolves through the `web` group and
     * that the group still contains the CSRF middleware. There is no throttle
     * on these routes today and this release does not add one.
     */
    public function test_au_endpoints_stay_in_the_csrf_protected_web_group(): void
    {
        // The `web` group is assembled by the framework in Laravel 12, so it is
        // not in Router::getMiddlewareGroups(); it is read off the HTTP kernel.
        $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
        $property = (new \ReflectionClass($kernel))->getProperty('middlewareGroups');
        $property->setAccessible(true);
        $web = $property->getValue($kernel)['web'] ?? [];

        $this->assertContains(
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            $web,
            'the web group must still validate CSRF'
        );
        $this->assertContains(\Illuminate\Session\Middleware\StartSession::class, $web);
        $this->assertContains(\App\Http\Middleware\CaptureAttribution::class, $web);

        $router = app(\Illuminate\Routing\Router::class);

        foreach (['contact.audit-request', 'contact.bank-appraisal', 'contact.price-calculator'] as $name) {
            $route = $router->getRoutes()->getByName($name);
            $this->assertNotNull($route, "{$name}: route must still exist");
            $this->assertContains('web', $route->gatherMiddleware(), "{$name}: must stay in the web group");
            $this->assertSame(['POST'], array_values(array_diff($route->methods(), ['HEAD'])), "{$name}: POST only");
        }
    }

    /** AU-11 — attribution is preserved and the payload carries no PII. */
    public function test_au_accepted_lead_keeps_attribution_and_leaks_no_pii(): void
    {
        $response = $this->postJson(self::AUDIT, $this->auditPayload([
            'contact'  => 'owner@example.com',
            'district' => 'Mustamäe',
        ]));

        $response->assertStatus(200);
        $payload = $response->json('lead');

        $this->assertSame('audit', $payload['form_type']);
        $this->assertArrayHasKey('lead_public_id', $payload);
        $this->assertArrayHasKey('event_id', $payload);
        $this->assertArrayHasKey('source_class', $payload);

        // The payload is a closed allowlist: a new key is how PII would arrive.
        $this->assertSame([
            'lead_public_id', 'event_id', 'form_type', 'submission_page',
            'source_class', 'campaign_name', 'has_gclid', 'is_test',
        ], array_keys($payload), 'the analytics payload key set must not grow');

        // No submitted value may appear in any payload VALUE. `submission_page`
        // is the endpoint path, which legitimately reads "/contact/..."; that is
        // a route, not a contact, so values are checked rather than the blob.
        foreach (['owner@example.com', 'Mustamäe', 'kv.ee', '@'] as $submitted) {
            foreach ($payload as $key => $value) {
                if (! is_string($value)) {
                    continue;
                }
                $this->assertStringNotContainsStringIgnoringCase(
                    $submitted,
                    $value,
                    "analytics payload value '{$key}' must not carry '{$submitted}'"
                );
            }
        }

        $lead = Lead::first();
        $this->assertSame('Mustamäe', $lead->metadata_json['district'] ?? null);
        $this->assertSame('apartment', $lead->metadata_json['type'] ?? null);
        $this->assertSame('sell', $lead->metadata_json['goal'] ?? null);
    }

    /** AU-12 — the other required audit fields still gate the request. */
    public function test_au_other_audit_fields_keep_their_rules(): void
    {
        $this->postJson(self::AUDIT, $this->auditPayload([
            'contact' => '+372 5555 1234',
            'type'    => 'spaceship',
        ]))->assertStatus(422)->assertJsonValidationErrors('type');

        $this->postJson(self::AUDIT, $this->auditPayload([
            'contact' => '+372 5555 1234',
            'goal'    => 'barter',
        ]))->assertStatus(422)->assertJsonValidationErrors('goal');

        $this->postJson(self::AUDIT, $this->auditPayload([
            'contact' => '+372 5555 1234',
            'link'    => 'not-a-url',
        ]))->assertStatus(422)->assertJsonValidationErrors('link');

        $this->assertSame(0, Lead::count());
    }

    // ────────────────────────────────────────────────────────────────────
    //  BK — /contact/bank-appraisal
    // ────────────────────────────────────────────────────────────────────

    /** BK-01 — an unreachable bank contact is rejected. */
    public function test_bk_unreachable_bank_contact_is_rejected(): void
    {
        $unreachable = [
            'BK-01 missing'          => null,
            'BK-01 empty'            => '',
            'BK-01 whitespace'       => '    ',
            'BK-01 ru no'            => 'Нет',
            'BK-01 en no'            => 'No',
            'BK-01 n/a'              => 'N/A',
            'BK-01 dash'             => '-',
            'BK-01 test'             => 'test',
            'BK-01 email no at'      => 'ownermail.com',
            'BK-01 email no domain'  => 'owner@',
            'BK-01 digits too few'   => '12345',
            'BK-01 repeated digit'   => '1111111',
            // The bank landing page offers no Telegram channel, so a handle is
            // NOT a usable contact there; it must be refused.
            'BK-01 telegram handle'  => '@owner_tallinn',
        ];

        foreach ($unreachable as $id => $value) {
            Lead::query()->delete();

            $payload = $this->bankPayload();
            if ($value !== null) {
                $payload['contact'] = $value;
            }

            $response = $this->postJson(self::BANK, $payload);

            $this->assertSame(422, $response->status(), "{$id}: expected 422");
            $response->assertJsonValidationErrors('contact');
            $this->assertSame(0, Lead::count(), "{$id}: no lead may be stored");
        }
    }

    /** BK-02, BK-03, BK-04 — a valid bank request stays a bank request. */
    public function test_bk_reachable_bank_contact_is_accepted_as_bank_appraisal(): void
    {
        foreach (['+372 5555 1234', 'owner@example.com', '(372) 555-11-22'] as $value) {
            Lead::query()->delete();

            $response = $this->postJson(self::BANK, $this->bankPayload(['contact' => $value]));

            $response->assertStatus(200)->assertJsonPath('status', 'OK');
            $this->assertSame(1, Lead::count());

            $lead = Lead::first();
            // BK-04 — never silently reclassified.
            $this->assertSame('bank_appraisal', $lead->form_type);
            $this->assertNotSame('price_calculator', $lead->form_type);
            $this->assertSame(trim($value), $lead->phone);
            // BK-03 — the bank-specific fields survive.
            $this->assertSame('Punane 1, Tallinn', $lead->message);
            $this->assertSame('Swedbank', $lead->metadata_json['bank'] ?? null);
            $this->assertSame('Ипотека', $lead->metadata_json['purpose'] ?? null);
            $this->assertSame('bank_appraisal', $response->json('lead.form_type'));
        }
    }

    /** BK-01 — the address rule and its Russian message are untouched. */
    public function test_bk_address_remains_required_with_its_own_message(): void
    {
        $payload = $this->bankPayload(['contact' => '+372 5555 1234']);
        unset($payload['address']);

        $response = $this->postJson(self::BANK, $payload);

        $response->assertStatus(422)->assertJsonValidationErrors('address');
        $this->assertSame(
            'Пожалуйста, укажите адрес объекта.',
            $response->json('errors.address.0'),
            'the existing bank address message must not change'
        );
        $this->assertSame(0, Lead::count());
    }

    /** BK-05 — a duplicate bank submission does not double-count. */
    public function test_bk_duplicate_submission_is_idempotent(): void
    {
        $payload = $this->bankPayload(['contact' => '+372 5555 1234']);

        $first  = $this->postJson(self::BANK, $payload);
        $second = $this->postJson(self::BANK, $payload);

        $first->assertStatus(200);
        $second->assertStatus(200);
        $this->assertSame(1, Lead::count());
        $this->assertSame(
            $first->json('lead.lead_public_id'),
            $second->json('lead.lead_public_id')
        );
    }

    /** BK-06, BK-07 — the bank landing page's own contract is unchanged. */
    public function test_bk_bank_landing_page_contract_is_preserved(): void
    {
        $html = $this->get('/ru/lp/ocenochnyy-akt-dlya-banka/')->assertStatus(200)->getContent();

        // BK-06 — noindex, one h1, approved wording, no Ads activation.
        $this->assertStringContainsString('noindex, follow', $html);
        $this->assertSame(1, preg_match_all('/<h1\b/', $html));
        $this->assertStringContainsString('300', $html, 'the approximate price must stay on the page');

        // BK-07 — its own CTA target, and the accepted hidden legacy calc link.
        $this->assertStringContainsString('id="v3-form-bank"', $html);
        $this->assertStringContainsString('.sticky-btn--calc', $html);
        $this->assertStringNotContainsString('id="v3-form-calc"', $html);

        // It posts to its own endpoint and is not a calculator consumer.
        $this->assertStringContainsString('action="/contact/bank-appraisal"', $html);
        $this->assertStringNotContainsString('data-v3-form="price-calculator"', $html);
        $this->assertStringNotContainsString('data-v3-form="audit-request"', $html);
    }

    /**
     * BK — the bank landing page gains the inline error slot.
     *
     * Safe to change because it is genuinely page-local: this is the only URL
     * on the site that renders the bank form, it is noindex, it is not Ads
     * active, and it carries neither the calculator nor the audit form.
     */
    public function test_bk_bank_form_gained_a_page_local_error_slot(): void
    {
        $html = $this->get('/ru/lp/ocenochnyy-akt-dlya-banka/')->assertStatus(200)->getContent();

        $this->assertSame(1, substr_count($html, 'id="bank_contact_error"'));
        $this->assertSame(1, substr_count($html, 'data-error-for="contact"'));
        $this->assertStringContainsString('Телефон / WhatsApp или email', $html);
        $this->assertStringContainsString('autocomplete="tel email"', $html);
        $this->assertStringContainsString('aria-describedby="bank_contact_error"', $html);
        // Empty and hidden on a fresh GET.
        $this->assertMatchesRegularExpression(
            '/id="bank_contact_error"[\s\S]{0,200}?style="display:none;"[\s\S]{0,120}?role="alert"><\/p>/',
            $html
        );
    }

    /**
     * The audit form's MARKUP is deliberately not touched by this release.
     *
     * Every one of the 49 URLs that renders the audit form is also one of the
     * 50 protected price-calculator consumers — the form has no page of its
     * own — so an inline error slot there would be a shared-component change
     * landing only on protected pages, including three under open organic
     * observation until 2026-11-13. The spec allows page-local form error UI
     * only, so the audit UI is deferred and the backend rule ships alone.
     */
    public function test_audit_form_markup_is_unchanged_by_this_release(): void
    {
        foreach (['/ru/', '/', '/en/'] as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();

            $this->assertSame(1, substr_count($html, 'data-v3-form="audit-request"'), "{$url}: one audit form");
            $this->assertStringContainsString('WhatsApp / Telegram', $html, "{$url}: audit label unchanged");
            $this->assertSame(0, substr_count($html, 'id="audit_contact_error"'), "{$url}: no audit slot added");
            $this->assertSame(0, substr_count($html, 'id="bank_contact_error"'), "{$url}: no bank markup leaked");
            // The calculator's single slot is the only error slot on the page,
            // exactly as the 2026-10-28 release left it.
            $this->assertSame(1, substr_count($html, 'class="v3-form__error"'), "{$url}: slot count unchanged");
        }
    }

    // ────────────────────────────────────────────────────────────────────
    //  WA — the main Audit → WhatsApp handoff must stay a handoff
    // ────────────────────────────────────────────────────────────────────

    /** The three audit pages keep the WhatsApp handoff and gain no backend form. */
    public function test_wa_audit_whatsapp_handoff_is_untouched(): void
    {
        foreach (['/audit/', '/ru/audit/', '/en/audit/'] as $url) {
            $html = $this->get($url)->assertStatus(200)->getContent();

            // Still a GET handoff to WhatsApp, still user-visible, never auto-sent.
            $this->assertStringContainsString('buildAuditWhatsApp', $html, "{$url}: handoff script");
            $this->assertStringContainsString('wa.me/3725113411', $html, "{$url}: handoff target");
            $this->assertStringContainsString('method="get"', $html, "{$url}: still a GET form");

            // It must NOT have been converted into a backend lead endpoint.
            $this->assertStringNotContainsString('action="/contact/audit-request"', $html, "{$url}: no backend POST");
            $this->assertStringNotContainsString('data-v3-form="audit-request"', $html, "{$url}: no AJAX lead form");

            // Its own form anchor from the accepted 2026-10-25 release still resolves.
            $this->assertStringContainsString('id="audit-form"', $html, "{$url}: anchor target");

            // Opening WhatsApp is a handoff attempt, never a conversion.
            $this->assertStringNotContainsString("generate_lead', { 'form_type': 'whatsapp'", $html);
        }
    }

    /** Both intentionally supported WhatsApp numbers survive. */
    public function test_wa_both_whatsapp_numbers_are_preserved(): void
    {
        $html = $this->get('/ru/')->assertStatus(200)->getContent();

        $this->assertStringContainsString('3725113411', $html);
        $this->assertStringContainsString('37258829892', $html);
    }

    // ────────────────────────────────────────────────────────────────────
    //  PC — the protected price calculator must not move
    // ────────────────────────────────────────────────────────────────────

    /** The 2026-10-27 release keeps its exact behaviour. */
    public function test_pc_price_calculator_contract_is_unchanged(): void
    {
        $base = [
            'address' => 'Viru väljak 2, Tallinn',
            'locale'  => 'ru',
        ];

        $this->postJson(self::CALC, $base + ['contact' => 'Нет'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('contact');
        $this->assertSame(0, Lead::count());

        $this->postJson(self::CALC, $base + ['contact' => '+372 5555 1234'])
            ->assertStatus(200)
            ->assertJsonPath('status', 'OK')
            ->assertJsonPath('lead.form_type', 'price_calculator');
        $this->assertSame(1, Lead::count());

        Lead::query()->delete();

        $this->postJson(self::CALC, $base + ['contact' => 'owner@example.com'])
            ->assertStatus(200)
            ->assertJsonPath('lead.form_type', 'price_calculator');

        // A Telegram handle is NOT part of the calculator's contract: that page
        // offers phone or email only, and its shipped rule must not widen.
        Lead::query()->delete();
        $this->postJson(self::CALC, $base + ['contact' => '@owner_tallinn'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('contact');
        $this->assertSame(0, Lead::count());
    }

    /** The calculator form component is not a consumer of any audit change. */
    public function test_pc_calculator_markup_is_not_altered_by_this_release(): void
    {
        $html = $this->get('/ru/ocenka-kvartiry-v-tallinne/')->assertStatus(200)->getContent();

        $this->assertSame(1, substr_count($html, 'action="/contact/price-calculator"'));
        $this->assertSame(1, substr_count($html, 'id="calc_contact_error"'));
        $this->assertStringContainsString('autocomplete="tel email"', $html);
        $this->assertStringContainsString('Телефон / WhatsApp или email', $html);
        $this->assertSame(1, preg_match_all('/<h1\b/', $html));
    }

    // ────────────────────────────────────────────────────────────────────
    //  Shared — the sibling endpoints keep their own rules
    // ────────────────────────────────────────────────────────────────────

    /** /contact/callback and /contact/inquiry are not in this release's scope. */
    public function test_sibling_endpoints_keep_their_existing_rules(): void
    {
        $this->postJson('/contact/callback', [])->assertStatus(422);
        $this->postJson('/contact/inquiry', [])->assertStatus(422);
        $this->assertSame(0, Lead::count());

        // Their own contact rules are deliberately untouched by this release.
        $this->postJson('/contact/callback', ['name' => 'Synthetic Tester', 'tel' => '+372 5555 1234'])
            ->assertStatus(200);
    }

    /** The bank landing copy keeps its approved, hedged claims. */
    public function test_bank_public_claims_stay_approximate(): void
    {
        $copy = Config::get('cityee-ppc.landings');
        $bank = collect($copy)->firstWhere('form', 'bank-appraisal');

        $this->assertNotNull($bank, 'the bank landing must still be configured');
        $this->assertSame('Телефон / WhatsApp или email', $bank['form_copy']['contact']);
    }
}
