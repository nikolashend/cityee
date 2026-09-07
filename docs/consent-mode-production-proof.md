# CityEE — Consent Mode Production Proof (X999⁵ §8)

**Date:** 2026-09-08 · **PROOF_5_CONSENT: BLOCKED** (GA4/Ads consent behavior lives in GTM
`GTM-5DRRX5ZJ`, not in the repo). The one business-critical invariant — **lead persists regardless
of consent** — is PROVEN locally; the analytics/ads consent behavior is unverifiable from here.

## Repository evidence (verifiable here)
| Item | Finding |
|---|---|
| Consent Mode calls (`gtag('consent', …)`, `ad_storage`, `analytics_storage`, `ad_user_data`, `ad_personalization`) | **NONE in repo** |
| Cookie-consent banner / CMP | **NONE** in `resources/` or `public/assets/` |
| Analytics loader | GTM container `GTM-5DRRX5ZJ` only ([layouts/app.blade.php](../resources/views/layouts/app.blade.php)) |
| Direct gtag / `AW-` tag | none — GA4 + Ads + any Consent Mode are configured **inside GTM** |
| `consent` field capture | `ContactController` passes `consent` → `LeadService` stores `consent_state` on the lead |

**Conclusion:** Consent Mode is either configured entirely in the GTM container (unverifiable here)
or absent. **Consent Mode = NOT_IMPLEMENTED (in code) / BLOCKED (GTM).**

## Scenario A — consent granted (procedure, BLOCKED on GA4/GTM)
1. On production, accept consent in the CMP (if one exists in GTM).
2. Submit one controlled QA lead.
3. Expected: lead persists (see invariant below); GA4 `generate_lead` fires per configured policy;
   Ads conversion eligible per policy. **Evidence:** GA4 DebugView + GTM preview — not accessible here.

## Scenario B — consent denied (procedure, BLOCKED on GA4/GTM)
1. Deny analytics/advertising consent in the CMP.
2. Submit one controlled QA lead.
3. Expected: **lead still persists** (proven below); GA4/Ads behave per the configured Consent Mode
   (e.g. cookieless pings or suppression). **Evidence:** GA4 DebugView + GTM preview — BLOCKED here.

## Business invariant — PROVEN locally (GREEN)
**Consent denial must never destroy a legitimate contact request.**
`test_consent_denied_still_persists_lead`: a submission with `consent=denied` returns HTTP OK,
stores the lead, and records `consent_state='denied'`. Lead persistence is entirely independent of
analytics/marketing consent, by construction (save-before-mail, no analytics gate on the write).
PII is never sent to analytics regardless of consent (`test_analytics_payload_has_no_pii`).

## Conflict to resolve (operator, in GTM)
The privacy posture requires consent-aware GA4/Ads, but nothing enforces it in the repository.
The operator must open `GTM-5DRRX5ZJ` and confirm: a Consent Mode default state exists, a CMP
updates it, and GA4/Ads tags respect `analytics_storage` / `ad_storage`. Until that inspection:
**PROOF_5_CONSENT = BLOCKED** (lead-persistence half GREEN; analytics/ads half unverifiable).
