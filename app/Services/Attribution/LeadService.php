<?php

namespace App\Services\Attribution;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Lead persistence pipeline (X999^5 §10/§11). The lead is saved BEFORE mail is
 * sent, in a short transaction, so it is never lost if PHP mail() fails. Mail and
 * analytics failures are recorded on the lead, never propagated as a lost lead.
 * Duplicate submissions within a short window collapse to a single lead + mail.
 */
class LeadService
{
    public function __construct(private AttributionContextService $attribution)
    {
    }

    /**
     * @param array{name?:?string,phone?:?string,email?:?string,message?:?string,metadata?:array} $fields
     * @param callable(Lead):bool $mailer  Sends the notification; returns success.
     */
    public function record(Request $request, string $formType, array $fields, callable $mailer): Lead
    {
        $phone = $this->norm($fields['phone'] ?? null);
        $email = $this->norm($fields['email'] ?? null);
        $fingerprint = $this->fingerprint($formType, $phone, $email, $fields);

        // Idempotent: same submission within the window → return the existing lead, no new mail.
        $existing = Lead::where('duplicate_fingerprint', $fingerprint)
            ->where('created_at', '>=', now()->subMinutes(10))
            ->first();
        if ($existing) {
            return $existing;
        }

        $ctx = $this->attribution->contextForLead($request);
        $first = $ctx['first'] ?? [];
        $last  = $ctx['last'] ?? [];

        // Synthetic/test click-id (§8B/§21): a test gclid must NEVER become a real
        // Ads conversion. Flag the lead so the frontend suppresses generate_lead.
        $isTest = $this->isSyntheticClickId($first['gclid'] ?? null)
            || $this->isSyntheticClickId($last['gclid'] ?? null)
            || $this->isSyntheticClickId($first['gbraid'] ?? null)
            || $this->isSyntheticClickId($last['gbraid'] ?? null)
            || $this->isSyntheticClickId($last['wbraid'] ?? null);

        // Short transaction — no network/mail inside it.
        $lead = DB::transaction(fn () => Lead::create([
            'form_type'            => $formType,
            'name'                 => $fields['name'] ?? null,
            'phone'                => $fields['phone'] ?? null,
            'email'                => $fields['email'] ?? null,
            'message'              => $fields['message'] ?? null,
            'metadata_json'        => $fields['metadata'] ?? null,
            'landing_page'         => $ctx['landing_page'] ?? null,
            'submission_page'      => $ctx['submission_page'] ?? null,
            'referrer'             => $ctx['referrer'] ?? null,
            'first_touch_source'   => $first['class'] ?? null,
            'first_touch_medium'   => $first['medium'] ?? null,
            'first_touch_campaign' => $first['campaign'] ?? null,
            'first_touch_gclid'    => $first['gclid'] ?? null,
            'first_touch_json'     => $first,
            'last_touch_source'    => $last['class'] ?? null,
            'last_touch_medium'    => $last['medium'] ?? null,
            'last_touch_campaign'  => $last['campaign'] ?? null,
            'last_touch_gclid'     => $last['gclid'] ?? null,
            'last_touch_json'      => $last,
            'ga_client_id'         => $ctx['ga_client_id'] ?? null,
            'ga_session_id'        => $ctx['ga_session_id'] ?? null,
            'ip_hash'              => $this->ipHash($request->ip()),
            'consent_state'        => $this->norm($request->input('consent')) ?? 'unknown',
            'duplicate_fingerprint'=> $fingerprint,
            'is_test'              => $isTest,
            'mail_status'          => 'pending',
            'analytics_status'     => $isTest ? 'suppressed_test' : 'unknown',
        ]));

        // Mail AFTER commit. Failure is recorded, not fatal (lead already saved).
        $sent = false;
        try {
            $sent = (bool) $mailer($lead);
        } catch (\Throwable $e) {
            Log::error('Lead mail failed', ['lead' => $lead->public_id, 'form' => $formType, 'error' => $e->getMessage()]);
        }
        $lead->forceFill([
            'mail_status'  => $sent ? 'sent' : 'failed',
            'mail_sent_at' => $sent ? now() : null,
        ])->save();

        return $lead;
    }

    /** HMAC fingerprint over form_type + normalized contact + payload hash + 10-min bucket. */
    private function fingerprint(string $formType, ?string $phone, ?string $email, array $fields): string
    {
        $payload = $formType . '|' . ($phone ?? '') . '|' . ($email ?? '')
            . '|' . sha1(json_encode($fields['metadata'] ?? []) . ($fields['message'] ?? ''))
            . '|' . floor(now()->timestamp / 600);        // 10-minute bucket
        return hash_hmac('sha256', $payload, (string) config('app.key'));
    }

    private function ipHash(?string $ip): ?string
    {
        return $ip ? hash_hmac('sha256', $ip, (string) config('app.key')) : null;
    }

    /** Detect obvious test / synthetic click identifiers (never a real conversion).
     * Matches explicit test markers (underscores are word chars, so \b is unreliable). */
    private function isSyntheticClickId(?string $id): bool
    {
        if (! $id) return false;
        return (bool) preg_match('/(^test|test\d|test[-_]?gclid|cityee[-_]?test|closure[-_]?test|synthetic|not[-_]?real)/i', $id);
    }

    private function norm(?string $v): ?string
    {
        if ($v === null) return null;
        $v = strtolower(trim(preg_replace('/\s+/', '', $v)));
        return $v === '' ? null : $v;
    }
}
