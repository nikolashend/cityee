<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * First-party lead record (X999^5 §9). Additive; never exposed via public routes.
 * PII (name/phone/email/message) must never be written to plain application logs.
 */
class Lead extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'metadata_json'    => 'array',
        'first_touch_json' => 'array',
        'last_touch_json'  => 'array',
        'mail_sent_at'     => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (empty($lead->public_id)) {
                $lead->public_id = (string) Str::ulid();
            }
        });
    }

    /** Non-PII payload for the GA4 generate_lead event / API response. */
    public function analyticsPayload(): array
    {
        return [
            'lead_public_id' => $this->public_id,
            // Stable, non-PII dedup key shared between GA4 and Google Ads (§10.5/§13).
            'event_id'       => hash_hmac('sha256', $this->public_id . '|generate_lead', (string) config('app.key')),
            'form_type'      => $this->form_type,
            'submission_page'=> $this->submission_page,
            'source_class'   => $this->last_touch_source ?: $this->first_touch_source ?: 'unknown',
            'campaign_name'  => $this->last_touch_campaign ?: $this->first_touch_campaign,
            'has_gclid'      => (bool) ($this->last_touch_gclid ?: $this->first_touch_gclid),
            // Test leads (synthetic click-id) must NOT fire a real conversion (§8B).
            'is_test'        => (bool) $this->is_test,
        ];
    }
}
