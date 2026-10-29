<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * PRICE_CALCULATOR_CONTACT_INTEGRITY V1.
 *
 * A price-calculator request promises a manual, individual price-corridor
 * answer, so a submission that is accepted but carries no reachable contact is
 * worse than a rejected one: the owner believes they asked and nobody can
 * reply. On 2026-10-26 a notification arrived reading "Contact: Нет".
 *
 * The rule under test: /contact/price-calculator accepts exactly one usable
 * channel — a plausible telephone number OR a syntax-valid email — and nothing
 * else. Mail is only ever sent from inside LeadService::record(), after a Lead
 * row exists, so "no Lead row" is also proof that no notification was sent.
 *
 * No production request is made anywhere in this file and no real customer
 * data is used as a fixture.
 */
class PriceCalculatorContactIntegrityTest extends TestCase
{
    use RefreshDatabase;

    private const URL = '/contact/price-calculator';

    private function payload(array $override = []): array
    {
        return array_merge([
            'address'   => 'Viru väljak 2, Tallinn',
            'area'      => 54,
            'rooms'     => 2,
            'floor'     => '3/5',
            'condition' => 'remonditud',
            'locale'    => 'ru',
        ], $override);
    }

    /** VAL-01..07 — anything that cannot be replied to must fail validation. */
    public function test_unreachable_contact_is_rejected(): void
    {
        $unreachable = [
            'VAL-01 missing'        => null,
            'VAL-02 empty'          => '',
            'VAL-02 spaces'         => '    ',
            'VAL-03 ru no'          => 'Нет',
            'VAL-03 ru no lower'    => 'нет',
            'VAL-03 en no'          => 'No',
            'VAL-03 none'           => 'none',
            'VAL-03 n/a'            => 'N/A',
            'VAL-03 dash'           => '-',
            'VAL-04 test'           => 'test',
            'VAL-04 abc'            => 'abc',
            'VAL-04 punctuation'    => '???',
            'VAL-05 no at'          => 'ownermail.com',
            'VAL-05 empty domain'   => 'owner@',
            'VAL-05 double dot'     => 'owner@example..com',
            'VAL-06 too short'      => '12345',
            'VAL-06 too long'       => '1234567890123456789',
            'VAL-07 repeated'       => '0000000000',
        ];

        foreach ($unreachable as $case => $contact) {
            $data = $this->payload();
            if ($contact !== null) {
                $data['contact'] = $contact;
            }

            $this->postJson(self::URL, $data)
                ->assertStatus(422)
                ->assertJsonValidationErrors('contact');
        }

        // No row => no notification, because mail is only sent inside record().
        $this->assertSame(0, Lead::count(),
            'An unreachable contact must never create a lead or a notification');
    }

    /** VAL-09..13 — a genuinely reachable contact still goes through. */
    public function test_reachable_contact_is_accepted_and_preserved(): void
    {
        $reachable = [
            'VAL-09 estonian mobile'  => '+372 5555 1234',
            'VAL-10 international'    => '+44 7700 900123',
            'VAL-11 punctuated'       => '(372) 555-11-22',
            'VAL-11 local landline'   => '6001234',
            'VAL-12 email mixed case' => '  Owner.Name@Example.COM  ',
            'VAL-13 legacy plain'     => '+3725551234',
        ];

        foreach ($reachable as $case => $contact) {
            Lead::query()->delete();

            $this->postJson(self::URL, $this->payload(['contact' => $contact]))
                ->assertOk()
                ->assertJsonPath('status', 'OK');

            $lead = Lead::firstOrFail();
            $this->assertSame('price_calculator', $lead->form_type, $case);

            // DATA-02/03: the stored value must still be usable. A leading "+"
            // and the international prefix must survive; only outer whitespace
            // is trimmed.
            $this->assertSame(trim($contact), $lead->phone,
                "{$case}: the reachable contact must be stored verbatim (trimmed only)");
        }
    }

    /** DATA-09 — the notification body can no longer render a placeholder. */
    public function test_stored_contact_is_never_a_placeholder(): void
    {
        $this->postJson(self::URL, $this->payload(['contact' => '+372 5555 1234']))->assertOk();

        $lead = Lead::firstOrFail();
        foreach (['нет', 'no', 'n/a', 'none', 'test'] as $placeholder) {
            $this->assertNotSame($placeholder, mb_strtolower((string) $lead->phone));
        }
    }

    /** DATA-07 — the analytics payload stays free of the contact and address. */
    public function test_analytics_payload_contains_no_contact_pii(): void
    {
        $this->postJson(self::URL, $this->payload([
            'contact' => '+372 5555 1234',
            'address' => 'Sepise 7, Tallinn',
        ]))->assertOk();

        $blob = strtolower(json_encode(Lead::firstOrFail()->analyticsPayload()));
        foreach (['5555', 'sepise', '@', 'owner'] as $pii) {
            $this->assertStringNotContainsString($pii, $blob,
                "PII leaked into the analytics payload: {$pii}");
        }
    }

    /** DATA-04 — an identical retry must not produce a second lead or mail. */
    public function test_duplicate_submission_is_idempotent(): void
    {
        $data = $this->payload(['contact' => '+372 5555 1234']);

        $first  = $this->postJson(self::URL, $data)->assertOk()->json('lead.lead_public_id');
        $second = $this->postJson(self::URL, $data)->assertOk()->json('lead.lead_public_id');

        $this->assertSame($first, $second, 'A retry must return the same lead');
        $this->assertSame(1, Lead::count(), 'A retry must not create a second lead or mail');
    }

    /**
     * The sibling endpoints still each produce their own lead type.
     *
     * Written for the 2026-10-27 release, when audit-request and
     * bank-appraisal still accepted the permissive `contact => 'c'` and this
     * test asserted that this release had not touched them. The 2026-10-29
     * release (AUDIT_BANK_CONTACT_INTEGRITY_V1) deliberately closed that same
     * weakness on both, so the fixtures now carry reachable contacts. The
     * assertion this test actually exists for — four endpoints, four distinct
     * form_type values, no cross-contamination from the calculator — is
     * unchanged. /contact/callback and /contact/inquiry remain untouched.
     */
    public function test_sibling_contact_endpoints_are_untouched(): void
    {
        $this->postJson('/contact/audit-request',
            ['type' => 'apartment', 'goal' => 'sell', 'contact' => '+372 5555 4321'])->assertOk();

        $this->postJson('/contact/bank-appraisal',
            ['address' => 'Viru 2', 'bank' => 'LHV', 'contact' => 'owner@example.com'])->assertOk();

        $this->postJson('/contact/callback', ['name' => 'a', 'tel' => '1'])->assertOk();
        $this->postJson('/contact/inquiry', ['name' => 'b', 'tel' => '2'])->assertOk();

        $this->assertEqualsCanonicalizing(
            ['audit', 'bank_appraisal', 'callback', 'inquiry'],
            Lead::pluck('form_type')->all()
        );
    }
}
