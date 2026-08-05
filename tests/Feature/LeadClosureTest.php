<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * X999^5 §20 — production-closure suite: test-click exclusion, dedup event_id,
 * export privacy + CSV-injection, prune, no-JS, consent persistence.
 */
class LeadClosureTest extends TestCase
{
    use RefreshDatabase;

    public function test_synthetic_gclid_is_flagged_test_and_suppresses_event(): void
    {
        $this->get('/ru/?gclid=CITYEE_TEST_GCLID_NOT_REAL');
        $this->postJson('/contact/callback', ['name' => 'A', 'tel' => '+372500'])->assertOk();

        $lead = Lead::firstOrFail();
        $this->assertTrue((bool) $lead->is_test);
        $this->assertSame('suppressed_test', $lead->analytics_status);
        $this->assertTrue($lead->analyticsPayload()['is_test']);   // frontend skips generate_lead
    }

    public function test_real_gclid_is_not_flagged_test(): void
    {
        $this->get('/ru/?gclid=Cj0KCQjwabc123realclickid');
        $this->postJson('/contact/callback', ['name' => 'B', 'tel' => '+372501'])->assertOk();
        $lead = Lead::firstOrFail();
        $this->assertFalse((bool) $lead->is_test);
        $this->assertSame('google_ads', $lead->last_touch_source);
    }

    public function test_event_id_is_deterministic_and_non_pii(): void
    {
        $this->postJson('/contact/inquiry', ['name' => 'Ivan', 'tel' => '+37255500099', 'email' => 'ivan@x.ee']);
        $lead = Lead::firstOrFail();
        $p1 = $lead->analyticsPayload();
        $p2 = $lead->fresh()->analyticsPayload();
        $this->assertSame($p1['event_id'], $p2['event_id']);   // stable → dedup
        $this->assertStringNotContainsString('ivan', strtolower(json_encode($p1)));
        $this->assertStringNotContainsString('55500099', json_encode($p1));
    }

    public function test_export_masks_pii_by_default(): void
    {
        Lead::create(['form_type' => 'inquiry', 'name' => 'Ivan Petrov', 'phone' => '+37255512345',
            'email' => 'ivan@example.com', 'duplicate_fingerprint' => 'x']);

        $this->artisan('leads:export')->assertSuccessful();
        $file = collect(Storage::files('private/exports'))->last();
        $csv = Storage::get($file);

        $this->assertStringNotContainsString('Ivan Petrov', $csv);
        $this->assertStringNotContainsString('55512345', $csv);
        $this->assertStringContainsString('i***@example.com', $csv);   // masked email
        $this->assertStringContainsString('***345', $csv);             // masked phone tail
    }

    public function test_export_include_pii_flag_reveals_raw(): void
    {
        Lead::create(['form_type' => 'callback', 'name' => 'Raw Name', 'phone' => '+37255599999',
            'duplicate_fingerprint' => 'y']);
        $this->artisan('leads:export', ['--include-pii' => true])->assertSuccessful();
        $csv = Storage::get(collect(Storage::files('private/exports'))->last());
        $this->assertStringContainsString('Raw Name', $csv);
    }

    public function test_export_escapes_csv_formula_injection(): void
    {
        Lead::create(['form_type' => 'callback', 'first_touch_campaign' => '=HYPERLINK("evil")',
            'last_touch_campaign' => '=HYPERLINK("evil")', 'duplicate_fingerprint' => 'z']);
        $this->artisan('leads:export')->assertSuccessful();
        $csv = Storage::get(collect(Storage::files('private/exports'))->last());
        $this->assertStringContainsString('"\'=HYPERLINK', $csv);   // neutralized with leading quote
        $this->assertStringNotContainsString('"=HYPERLINK', $csv);
    }

    public function test_prune_dry_run_deletes_nothing(): void
    {
        Lead::create(['form_type' => 'callback', 'duplicate_fingerprint' => 'a', 'created_at' => now()->subDays(1000)]);
        $this->artisan('leads:prune')->assertSuccessful();
        $this->assertSame(1, Lead::count());   // dry-run kept it
    }

    public function test_prune_execute_deletes_only_old_leads(): void
    {
        Lead::create(['form_type' => 'callback', 'duplicate_fingerprint' => 'old', 'created_at' => now()->subDays(1000)]);
        Lead::create(['form_type' => 'callback', 'duplicate_fingerprint' => 'new', 'created_at' => now()]);
        $this->artisan('leads:prune', ['--execute' => true])->assertSuccessful();
        $this->assertSame(1, Lead::count());   // only the recent one remains
        $this->assertSame('new', Lead::first()->duplicate_fingerprint);
    }

    public function test_no_js_server_post_still_persists_lead(): void
    {
        // No X-Requested-With header (simulates a plain form POST) — still saves.
        $this->post('/contact/callback', ['name' => 'NoJS', 'tel' => '+372502'])->assertOk();
        $this->assertSame(1, Lead::where('form_type', 'callback')->count());
    }

    public function test_consent_denied_still_persists_lead(): void
    {
        $this->postJson('/contact/callback', ['name' => 'C', 'tel' => '+372503', 'consent' => 'denied'])->assertOk();
        $lead = Lead::firstOrFail();
        $this->assertSame('denied', $lead->consent_state);
        $this->assertNotNull($lead->id);
    }

    public function test_client_submission_id_extra_field_is_accepted_harmlessly(): void
    {
        // The frontend sends client_submission_id for cross-channel de-dup. The
        // backend does not persist it yet; it must be ignored, never break the save.
        $this->postJson('/contact/callback', [
            'name' => 'D', 'tel' => '+372504', 'client_submission_id' => 'cs_abc123',
        ])->assertOk();
        $this->assertSame(1, Lead::where('form_type', 'callback')->count());
        $this->assertArrayNotHasKey('client_submission_id', Lead::firstOrFail()->getAttributes());
    }

    public function test_summary_report_is_zero_row_safe_and_non_pii(): void
    {
        $this->artisan('leads:summary')->assertSuccessful();   // empty DB

        Lead::create(['form_type' => 'callback', 'name' => 'Ivan Petrov', 'phone' => '+37255500011',
            'last_touch_source' => 'google_ads', 'last_touch_campaign' => 'spring', 'duplicate_fingerprint' => 'q']);
        $this->artisan('leads:summary --json')
            ->assertSuccessful()
            ->doesntExpectOutputToContain('Ivan')
            ->doesntExpectOutputToContain('55500011');
    }
}
