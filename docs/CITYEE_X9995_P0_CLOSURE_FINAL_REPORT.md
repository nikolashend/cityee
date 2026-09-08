# CITYEE X999⁵ — P0 PRODUCTION ATTRIBUTION CLOSURE · Final Report

**Date:** 2026-09-08 · **Basis:** Stage A (Claude-only) complete under the *Owner Evidence Handoff
Protocol*, which overrides the main TZ §13/§20 FAIL rule: missing owner/server access is **PENDING,
not FAIL**. No fabricated schema, GA4, Ads, inbox, or monitoring evidence.

---

## Executive verdict

> ## IMPLEMENTATION_PASS + PRODUCTION_OWNER_EVIDENCE_PENDING
> The attribution implementation is proven correct and non-regressing from the repository. Every
> remaining proof is **owner/server-gated evidence, not a defect** — the healthy, expected outcome
> of Stage A. This is **not** GLOBAL FAIL: zero defects are proven.

**Access reality (Step 0):** this Claude Code session runs on a **local checkout**
(`APP_ENV=local`, `APP_URL=http://localhost`, no CityEE production host in SSH config). So
production-server proofs are `SERVER_ACCESS_PENDING` (Nikolai/DevOps); Google-account proofs are
`OWNER_EVIDENCE_PENDING` (Aleksandr); the inbox proof is `OWNER_EVIDENCE_PENDING` (mailbox owner).

## Layered result

| Layer | Status | Basis |
|---|---|---|
| **IMPLEMENTATION** | ✅ `PASS` | 38 PHP tests / 190 assertions + JS matrix 50/50 + render-check 44/44 |
| **PRODUCTION (server)** | ⏳ `SERVER_ACCESS_PENDING` | migration-applied, prod schema, prod lead count — needs prod shell (Owner Action #0) |
| **GA4** | ⏳ `OWNER_EVIDENCE_PENDING` | exactly-once `generate_lead` + suppression — DebugView (Owner Action #1) |
| **GOOGLE ADS** | ⏳ `OWNER_EVIDENCE_PENDING` | single Primary conversion — inventory (Owner Action #2) |
| **GTM + CONSENT** | ⏳ `OWNER_EVIDENCE_PENDING` | lead tag + Consent Mode — GTM `GTM-5DRRX5ZJ` (Owner Action #3) |
| **MAIL DELIVERY** | ⏳ `OWNER_EVIDENCE_PENDING` | one email per submission — inbox (Owner Action #4) |
| **LIVE FORM QA** | ⏳ pending | 4 forms + dup + consent test cases defined (QA-REAL/TEST/02–04/DUP/CONSENT) |
| **72H OBSERVABILITY** | `NOT_STARTED` | gate not yet green; cannot be simulated |

## §26 verdict block

```
CITYEE X999⁵  PRODUCTION ATTRIBUTION CLOSURE

Commit:              17cc665 (impl) · babc444 (evidence) · this report
Production release:  UNKNOWN — session on local checkout (SERVER_ACCESS_PENDING)
Baseline start:      NOT STARTED

Proof 1 — Production schema:          SERVER_ACCESS_PENDING   (Owner Action #0)
Proof 2 — Four live forms + email:    OWNER_EVIDENCE_PENDING  (Owner Actions #4 + QA)
Proof 3 — GA4 exactly-once:           OWNER_EVIDENCE_PENDING  (Owner Action #1)
Proof 4 — Google Ads single Primary:  OWNER_EVIDENCE_PENDING  (Owner Action #2)
Proof 5 — Consent Mode:               OWNER_EVIDENCE_PENDING  (Owner Action #3)

Dedup:                CONTAINED_UNREACHABLE   (live path complete; fallback code-unreachable)
SEO non-regression:   PASS (code-side)        (render-check 44/44; prod HTTP pending)
Security red-team:    PASS (22) / 1 PARTIAL / 2 PENDING (GTM/Ads)

72H monitoring:       NOT STARTED
14-day baseline:      NOT STARTED

P0 defects: 0   P1 defects: 0   P2 defects: 0

GLOBAL VERDICT:  IMPLEMENTATION_PASS + PRODUCTION_OWNER_EVIDENCE_PENDING
                 (NOT GLOBAL FAIL — no defect proven)

NEXT SAFE ACTION:
  Run Owner Action #0 (production schema — 3 read-only commands) and paste the text back
  into this context. That flips Proof 1 → PASS. Then Owner Actions #1–#4 per the requests doc.
```

## Stage A — what is proven (Claude-only, GREEN)

| Invariant | Evidence |
|---|---|
| Save-before-mail (lead survives mail failure) | `test_lead_saved_even_when_mail_fails`, `test_no_js_server_post_still_persists_lead` |
| One submission → one lead (dedup) | `test_duplicate_submissions_create_one_lead` (10-min HMAC fingerprint) |
| Deterministic non-PII `event_id` | `test_event_id_is_deterministic_and_non_pii` |
| Synthetic/test click never a real conversion | `test_synthetic_gclid_is_flagged_test_and_suppresses_event`; JS matrix rows 3/4/4b/5 |
| No PII in analytics or logs | `test_analytics_payload_has_no_pii`; PII logging removed from `ContactController` |
| Consent-denied still persists the lead | `test_consent_denied_still_persists_lead` |
| Export masks PII + neutralizes CSV injection | `test_export_masks_pii_by_default`, `test_export_escapes_csv_formula_injection` |
| Exactly-once safe emission (success allowlist, fail-closed) | `tests/js/lead-tracking.test.cjs` 50/50 (JSON/legacy/HTML-200/204/422/500/net-fail/double-click/4 forms) |
| Four forms share one attribution-safe pipeline | all handlers `→ $this->ok($lead)`; `test_all_four_form_types_create_leads` |
| Dedup fallback resolved | `docs/dedup-production-verdict.md` — CONTAINED_UNREACHABLE |
| Consent business invariant | `docs/consent-mode-production-proof.md` |
| Zero SEO/render regression (code-side) | `cityee:render-check` 44/44; `seo:audit-links`/`seo:audit-intents` PASS |
| Local schema contract | `storage/app/audit/production-attribution-schema-proof.txt` (33 cols, is_test, unique public_id, 8 indexes) |

## Stage B — the owner-evidence loop
All remaining proofs are packaged as ready-to-forward blocks in
**`docs/CITYEE_OWNER_EVIDENCE_REQUESTS.md`** (Owner Actions #0–#4 + the QA test cases). Flow:
```
CLAUDE → OWNER_EVIDENCE_REQUEST → Nikolai → holder → screenshot/text
       → Nikolai (paste into THIS context) → CLAUDE validates → next smallest action
```
Rules of the loop: read-only current state first; no GTM/Ads/consent changes before Claude analyses;
QA submissions carry known ids and the synthetic marker where they must not train Ads; the inbox
proof has a named owner. See `docs/CITYEE_OWNER_EVIDENCE_HANDOFF_PROTOCOL.md`.

## Why not GLOBAL FAIL
The main TZ would force FAIL for anything unproven. The handoff protocol (§1) overrides that: a
correct implementation whose production evidence is simply gated behind someone else's account is
`PENDING`, not a failure. Zero defects are proven, so FAIL would be false. `GLOBAL PASS` will be
declared only after Owner Actions #0–#4 return real evidence and the 72H window completes.

## Deliverables (§25)
`production-attribution-schema-proof.txt` · `production-form-qa-results.csv` (skeleton) ·
`ga4-production-lead-proof.md` · `google-ads-conversion-inventory.csv` (skeleton) ·
`consent-mode-production-proof.md` · `dedup-production-verdict.md` ·
`CITYEE_ATTRIBUTION_RED_TEAM_EVIDENCE.md` · `CITYEE_72H_PRODUCTION_MONITORING_LOG.md` (template) ·
`CITYEE_14_DAY_REVENUE_INTELLIGENCE_BASELINE.md` (template) · **this report** ·
`CITYEE_OWNER_EVIDENCE_HANDOFF_PROTOCOL.md` · `CITYEE_OWNER_EVIDENCE_REQUESTS.md` ·
operator + rollback runbooks.
