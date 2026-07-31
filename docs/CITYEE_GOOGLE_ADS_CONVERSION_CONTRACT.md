# CityEE — Google Ads Conversion Contract (X999⁵ §13)

## Conversions
| Conversion | Type | Count | Value | Bid-optimize? |
|---|---|---|---|---|
| **Qualified website lead** (primary) | `generate_lead` after successful server-side lead save | **One** | none (or later per-form value) | **Yes** |
| WhatsApp click | secondary micro-conversion | One | none | No (until separate decision) |
| Phone click | secondary | One | none | No |
| Telegram click | secondary | One | none | No |
| Form start | secondary | One | none | No |

## Import path
GA4 → Google Ads (recommended): mark the GA4 `generate_lead` event as a key event and import it as
the primary conversion. This reuses the existing GTM/GA4 setup and the non-PII payload
(`lead_public_id`, `form_type`, `source_class`, `campaign_name`, `has_gclid`, `submission_page`).
A direct Google Ads tag is an alternative but duplicates measurement — do **not** run both for the
same action without dedup.

## Deduplication
Deduplicate on `lead_public_id` (unique per lead; duplicate submissions already collapse to one lead
server-side). One `generate_lead` per lead.

## Attribution & window
Data-driven attribution; default conversion window. GCLID/GBRAID/WBRAID captured first-party and
stored on the lead enable enhanced-conversions eligibility (server-side upload is a future option).

## Consent
Fire `generate_lead` and any Ads tag only under Consent Mode `ad_storage=granted` /
`analytics_storage=granted` as applicable. No PII (name/phone/email/message/raw IP) is ever sent.

## Test procedure
Use a **test flag** so a `gclid=TEST-…` submission is NOT counted as a real Ads conversion. Verify:
one `generate_lead` per test submission, correct `source_class`, no PII in the event, and (in Ads)
the conversion appears only for real (non-test) clicks. Do not modify live campaigns/keywords here.

## Micro-conversion caution
WhatsApp/phone/telegram/form_start are **signals**, not qualified leads — keep them secondary and do
not let them optimize bidding as full leads until a separate, approved decision.
