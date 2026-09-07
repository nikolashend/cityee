# CityEE X999⁵ — Production Lead Attribution · GLOBAL PASS/FAIL Final Report

**Date:** 2026-09-07 (refreshed) · **Repo commit:** `17cc665` (`fix(cityee): safely emit lead
conversion after confirmed submissions`) · **Scope:** production lead-attribution proof (form QA,
GA4, Google Ads dedup, consent, 72h monitoring) · **Rule applied:** *"If it cannot be proven, it
does not exist. The strongest result may be to change no code and provide production evidence.
Preserve revenue before optimizing growth."*

---

## Executive verdict: **GLOBAL FAIL — BLOCKED ON PRODUCTION / GTM / GA4 / ADS ACCESS**

This is a deliberate FAIL, not a "PASS for executed scope." The spec demands **production-observed
evidence**. Six required proofs cannot be produced from this environment because they live on the
production server, inside the GTM container `GTM-5DRRX5ZJ`, in GA4, and in Google Ads — none of
which are accessible here. Per the FINAL RULE, unprovable = does not exist → GLOBAL FAIL until the
operator runs the runbook and attaches evidence.

The **code and data foundation is GREEN and non-regressing** (Feature suite pass + `node
tests/js/lead-tracking.test.cjs` 50/50, all SEO/render gates pass, no winner page or form touched
destructively). But green code is not the deliverable this spec asked for. The deliverable is proof,
and proof is BLOCKED.

---

## Proof matrix

| # | Required proof (§) | Status | Why | Unblock |
|---|---|---|---|---|
| 1 | Production migration/schema live (`leads` + `is_test`) | **BLOCKED** | no production shell | Runbook §1 |
| 2 | Live form QA — 4 forms save + email, exactly once (§6) | **BLOCKED** | no live site submit + inbox | Runbook §5 → `production-form-qa-results.csv` |
| 3 | GA4 DebugView `generate_lead`, non-PII, 1× (§7) | **BLOCKED** | no GA4 / GTM access | `ga4-production-lead-proof.md` |
| 4 | Google Ads single **primary** conversion, no double count (§8) | **BLOCKED** | no Ads / GTM access | `google-ads-conversion-inventory.csv` |
| 5 | Consent-denied production behavior (§10) | **BLOCKED** | Consent Mode is **not in repo** — GTM-only | Discovery §33 + GTM inspection |
| 6 | 72-hour monitoring baseline (§17) | **BLOCKED** | requires 3 days of live data post-deploy | `CITYEE_14_DAY_REVENUE_INTELLIGENCE_BASELINE.md` |

## What IS proven here (repository + local — GREEN)

| Claim | Evidence |
|---|---|
| Leads persist independently of mail (save-before-mail) | `LeadService::record()` + `test_no_js_server_post_still_persists_lead` |
| No PII in analytics payload or logs | `test_analytics_payload_has_no_pii`, `test_event_id_is_deterministic_and_non_pii`; PII logging removed from `ContactController` |
| `event_id` deterministic → GA4↔Ads dedup key | `test_event_id_is_deterministic_and_non_pii` |
| Synthetic click-ids never become real conversions | `test_synthetic_gclid_is_flagged_test_and_suppresses_event` (`is_test=1`, event skipped) |
| Duplicate submissions collapse to one lead | 10-min HMAC fingerprint; dedup test |
| Consent-denied still saves the lead | `test_consent_denied_still_persists_lead` |
| Export masks PII + neutralizes CSV injection | `test_export_masks_pii_by_default`, `test_export_escapes_csv_formula_injection` |
| Both form JS handlers accept the JSON response | `main.js?v=6` + `cityee-lead-tracking.js` + `form-scripts.blade.php` |
| **Safe lead-conversion emission** — fires only on an explicit success allowlist; **fail-closed** for synthetic clicks (backend flag ∪ persisted synthetic-landing marker ∪ live URL click-id); exactly-once per lead; no PII | commit `17cc665`; `tests/js/lead-tracking.test.cjs` 50/50 (matrix: JSON/legacy/HTML-200/204/422/500/net-fail/double-click/4 forms) |
| Local leads schema contract (33 cols, `is_test`, unique `public_id`, 8 indexes) | `storage/app/audit/production-attribution-schema-proof.txt` (§A) |
| Red-team: 22 PASS / 1 PARTIAL / 2 BLOCKED, no code change required | `docs/CITYEE_ATTRIBUTION_RED_TEAM_EVIDENCE.md` |
| Analytics stack is GTM-only (`GTM-5DRRX5ZJ`); no gtag/AW-/Consent Mode/banner in repo | `attribution-production-discovery.md` |
| Zero SEO/render regression | `seo:audit-links` PASS, `seo:audit-intents` PASS, `cityee:render-check` 44/44 |

**Dedup honesty (§9):** on the normal JSON path dedup is **complete** (backend `event_id` = `HMAC(public_id)`); on the legacy/fallback path it is **partial** — a pre-request `client_submission_id` is sent and reused as `event_id`, but the backend does not yet persist/dedupe on it (`test_client_submission_id_extra_field_is_accepted_harmlessly`). Not claimed as complete.

## Conflict flagged (§10 — must be resolved by operator)
The privacy posture requires consent-aware GA4/Ads, but **no Consent Mode or cookie banner exists
in the repository.** Either consent is configured entirely inside GTM (unverifiable here) or it is
genuinely absent. **Consent Mode = NOT_IMPLEMENTED (in code) / BLOCKED (GTM).** Lead persistence is
consent-independent regardless (proven).

## §18 deliverables — status
| # | Deliverable | Status |
|---|---|---|
| 1 | `docs/attribution-production-discovery.md` | ✅ present |
| 2 | `storage/app/audit/production-attribution-schema-proof.txt` | ✅ present (local GREEN + prod BLOCKED template) |
| 3 | `docs/production-form-qa-results.csv` | ✅ skeleton (rows BLOCKED — operator fills) |
| 4 | `docs/ga4-production-lead-proof.md` | ✅ procedure (BLOCKED — GA4/GTM) |
| 5 | `docs/google-ads-conversion-inventory.csv` | ✅ skeleton (BLOCKED — Ads/GTM) |
| 6 | `docs/form-mail-delivery-proof.csv` | ✅ skeleton (BLOCKED — inbox) |
| 7 | `docs/CITYEE_72H_PRODUCTION_MONITORING_LOG.md` | ✅ template (BLOCKED — needs live data) |
| 8 | `docs/CITYEE_14_DAY_REVENUE_INTELLIGENCE_BASELINE.md` | ✅ template (no fabricated numbers) |
| 9 | this report | ✅ present |
| 10 | `docs/CITYEE_ATTRIBUTION_RED_TEAM_EVIDENCE.md` | ✅ present (22 PASS / 1 PARTIAL / 2 BLOCKED) |
| 11 | before/after regression evidence | ✅ `storage/app/audit/*baseline*` + `seo:*`/`render-check` gates |
| 12 | `docs/CITYEE_ATTRIBUTION_OPERATOR_RUNBOOK.md` | ✅ present |
| 13 | `docs/CITYEE_ATTRIBUTION_ROLLBACK_RUNBOOK.md` | ✅ present |

Supporting code: `app/Console/Commands/LeadsSummaryCommand.php` (read-only revenue snapshot),
`public/assets/templates/offshors/js/cityee-lead-tracking.js` (canonical safe-emission module).

## Operator path to GLOBAL PASS
1. Deploy (backup → `git pull` → `migrate --force` → `optimize:clear`) — Operator Runbook §0.
2. Fill proofs 1–2 with `leads:summary` + live form QA + inbox check.
3. Fill proofs 3–5 inside GTM/GA4/Ads (DebugView + single primary conversion + consent behavior).
4. Run 72h, complete the 14-day baseline (proof 6).
5. Re-issue verdict. GLOBAL PASS only when all six cells are GREEN with attached evidence.

**No code change is recommended to reach PASS. The gap is evidence, not implementation.**
