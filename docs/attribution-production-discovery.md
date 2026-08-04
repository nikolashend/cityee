# CityEE — Attribution Production Discovery (X999^5 §2)

**Date:** 2026-08-02 · Repository inspection before any change. Distinguishes repo evidence from
GTM/GA4/Ads/production evidence (the latter not accessible from this environment → BLOCKED).

## Repository evidence (verifiable here)

| Item | Finding |
|---|---|
| Git commit / branch | `main`, working tree clean (pre-flight artifact) |
| Lead migrations | `2026_07_31_000001_create_leads_table`, `2026_08_01_000001_add_lead_test_flag` — both `[Ran]` locally |
| Leads schema | all mandatory columns + 7 indexes + `is_test` (PRAGMA proof) |
| Form POST routes | `/contact/{callback,inquiry,audit-request,price-calculator}` (`routes/web.php`) |
| Form controllers/services | `ContactController` → `LeadService` + `AttributionContextService` (all 4 forms; INV-003) |
| Form JS handlers | **two**: `main.js` `.ajax-form` (callback + inquiry) and `components/v3/form-scripts.blade.php` (`[data-v3-form]`) — **both** now emit `generate_lead` and accept the JSON response |
| GA4 `generate_lead` emission | frontend `dataLayer.push({event:'generate_lead', event_id, …})`, non-PII, skipped for `is_test` |
| **GTM** | container **`GTM-5DRRX5ZJ`** present in layout (lines 145/161) |
| **Direct GA4 gtag** | **none** in repo — GA4 is loaded/configured via GTM |
| **Google Ads tag (`AW-…`)** | **none** in repo — any Ads conversion is configured inside GTM |
| **Consent Mode** (`gtag('consent',…)`, `ad_storage`/`analytics_storage`) | **NONE in repo** |
| **Cookie-consent banner** | **NONE** in `resources/` or `public/assets/` |
| Thank-you / success route | **none** — forms are AJAX; no thank-you page → no thank-you-page double-conversion risk |
| Env (GA4/Ads/consent) | no GA4/Ads/consent env keys; `.env` has app/session/DB only |

## GTM/GA4/Google Ads evidence — **BLOCKED (no access)**
GA4 property, the `generate_lead` key-event config, the Google Ads conversion action(s), their
primary/secondary status, dedup settings, and Consent Mode all live **inside the GTM container
`GTM-5DRRX5ZJ`** — not in the repository. They cannot be inspected or proven from this environment.

## Production evidence — **BLOCKED (no shell)**
Migration/schema/lead-count/mail-delivery on `cityee.ee` require a production shell.

## Key conflict to flag (§10)
The privacy policy states "GA4/Ads behavior must be consent-aware," but **no Consent Mode or
consent banner exists in the repository.** Either (a) consent is configured entirely in GTM
(unverifiable here) or (b) it is genuinely absent. This must be resolved by inspecting the GTM
container; until then, **Consent Mode = NOT_IMPLEMENTED (in code) / BLOCKED (GTM)**. Lead
persistence is consent-independent regardless (proven by test).

## Assumptions
- Production runs the deployed attribution code (verified live in the prior phase: pages 200,
  anchors live). This closure's `is_test` migration + `main.js` fix + `leads:summary` are new and
  must be deployed.
