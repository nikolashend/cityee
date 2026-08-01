# CityEE — Attribution Privacy & Retention Policy (X999^5 §14)

> Engineering policy, not a legal opinion. Legal/GDPR compliance requires separate review.

## Data stored per lead
| Data | Purpose | Notes |
|---|---|---|
| name, phone, email, message | fulfil the enquiry (the actual lead) | PII — never sent to analytics, never in plain logs |
| form_type, landing/submission page, referrer | routing + attribution | non-PII |
| first/last-touch source/medium/campaign, gclid/gbraid/wbraid | attribute the lead to a channel/campaign | click-ids are pseudonymous ad identifiers |
| ga_client_id, ga_session_id | link to GA4 (non-PII) | from `_ga` cookies |
| ip_hash | duplicate/abuse detection | **HMAC-SHA256(ip, app_key)** — raw IP is never stored |
| consent_state | record consent at submit | |
| duplicate_fingerprint, is_test | dedup + test exclusion | HMAC, non-reversible to PII |
| mail/analytics status | operations | |

## PII handling
- **Never** in GA4/GTM/Google Ads payloads — only `lead_public_id`, `event_id`, `form_type`,
  `submission_page`, `source_class`, `campaign_name`, `has_gclid`, `is_test`.
- **Never** in application logs (controllers log no PII; errors log `public_id` only).
- Export masks email/phone by default; raw PII requires `--include-pii` (CLI-only, audited,
  private path, no PII in the audit line).

## Access & export
- No public route, API, or unauthenticated export exposes leads (INV-008).
- `php artisan leads:export` — CLI-only, writes to `storage/app/private/exports` (not web-served),
  masked by default, CSV formula-injection escaped.

## Retention (config/attribution.php)
- `lead_retention_days` (default 400) — leads older than this are eligible for pruning.
- `attribution_cookie_days` (default 90) — first-party attribution session lifetime.
- `prune_min_age_days` (default 90) — safety floor; recent leads are never pruned.
- `php artisan leads:prune` — **dry-run by default**; `--execute` required to delete; audited.

## Consent
- The lead is **always** persisted (fulfilment basis), regardless of consent.
- The GA4 `generate_lead` analytics event / advertising identifiers should be gated by the site's
  Consent Mode configuration; a denied consent must not block lead persistence.
- `consent_state` is recorded on each lead.

## Cookie / session lifetime
First-party attribution uses the Laravel session (see `config/session.php` lifetime) plus
`attribution_cookie_days` as the intended attribution window. No third-party cookies are set by
this system.

## Deletion
`leads:prune --execute` removes leads past retention. A subject-specific deletion (right to erasure)
can be performed by `public_id` via Tinker/an authorized command; document each such action.
