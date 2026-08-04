# GA4 Production Lead Proof (X999^5 §7) — BLOCKED

**Status: BLOCKED** — requires GA4 access (DebugView/Realtime) + the GTM container `GTM-5DRRX5ZJ`.
Not accessible from this environment; not fabricated.

## What the code guarantees (verifiable here)
- The frontend pushes exactly one `generate_lead` per successful submission, with non-PII params
  only: `event_id`, `lead_public_id`, `form_type`, `submission_page`, `source_class`,
  `campaign_name`, `has_gclid`. No name/phone/email/message/IP (tests: `test_analytics_payload_has_no_pii`,
  `test_event_id_is_deterministic_and_non_pii`).
- For a synthetic click-id, `is_test=true` and the push is **skipped** (`test_synthetic_gclid_is_flagged_test_and_suppresses_event`).

## To close (operator, in GA4/GTM)
1. In GTM: confirm a tag fires GA4 `generate_lead` on the `generate_lead` dataLayer event, mapping
   `event_id`, `form_type`, `source_class`, `campaign_name`, `has_gclid`, `submission_page`.
2. Mark `generate_lead` a **key event** in GA4.
3. In GA4 DebugView, submit one real (non-test) form and confirm: exactly one `generate_lead`,
   correct params, no PII, `event_id` present.
4. Submit one synthetic-gclid form and confirm: **no** `generate_lead` event (is_test suppressed).
5. Deny consent and confirm the configured Consent Mode behavior (and that the lead still saved).
Attach DebugView screenshots as evidence references.
