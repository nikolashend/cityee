# CITYEE X999⁵ — P0 PRODUCTION ATTRIBUTION CLOSURE · Final Report

**Date:** 2026-09-08 · **Basis:** Stage A (Claude-only) complete under the *Owner Evidence Handoff
Protocol*, which overrides the main TZ §13/§20 FAIL rule: missing owner/server access is **PENDING,
not FAIL**. No fabricated schema, GA4, Ads, inbox, or monitoring evidence.

---

## Executive verdict

> ## GLOBAL FAIL — PROVEN GTM MEASUREMENT-CONFIGURATION DEFECT
> The Laravel/site **implementation is correct** (IMPLEMENTATION_PASS), but Aleksandr's owner
> evidence (GTM+GA4+Ads pack, 2026-09-08) revealed a **proven configuration-level defect cluster**
> in the GTM container `GTM-5DRRX5ZJ` (v11) that corrupts lead measurement. A defect is proven →
> per the handoff protocol this is FAIL (not PENDING). It is fixable with three owner actions in
> GTM; no SEO/site rewrite is needed. Full analysis: `docs/CITYEE_OWNER_EVIDENCE_ANALYSIS_GTM_GA4_ADS.md`.

**The defect cluster (config-confirmed from screenshots; runtime magnitude pending DebugView):**
- **F1** two GA4 tags send `generate_lead` on the same `lead_submit_success` trigger → duplicate lead event.
- **F2** a mislabeled "Google Analytics Configuration" tag sends `generate_lead` on **All Pages** (page view) to a phantom measurement ID — latent "every pageview = a lead".
- **F3** the site pushes dataLayer `generate_lead` on form submit, but the only lead trigger is `lead_submit_success` and there is **no `generate_lead` trigger** → real form submits may fire no GA4 lead event (the original "no event after submit" symptom).
- **F4** contact-link clicks (tel/WhatsApp/Telegram/email) push `lead_submit_success` → currently counted as leads (and doubled).
- **F6** the site's `event_id` is **not mapped** onto either GA4 tag → the designed GA4↔Ads dedup is not actually delivered.

**Access reality (Step 0):** this Claude Code session runs on a **local checkout**
(`APP_ENV=local`, no CityEE production host in SSH config). Production-server proofs remain
`SERVER_ACCESS_PENDING` (Nikolai/DevOps); the inbox proof is `OWNER_EVIDENCE_PENDING`; **GA4/GTM/Ads
owner evidence has now been received and analysed** (result: the defect cluster above).

## Layered result

| Layer | Status | Basis |
|---|---|---|
| **IMPLEMENTATION** | ✅ `PASS` | 38 PHP tests / 190 assertions + JS matrix 50/50 + render-check 44/44 |
| **PRODUCTION (server)** | ⏳ `SERVER_ACCESS_PENDING` | migration-applied, prod schema, prod lead count — needs prod shell (Owner Action #0) |
| **GA4 exactly-once** | ❌ `FAIL` | proven config defect: duplicate sender (F1) + All-Pages `generate_lead` (F2); event-name mismatch (F3); `event_id` not mapped (F6) |
| **GOOGLE ADS single Primary** | ✅ `PASS (config)` | one CityEE Primary `cityee.ee (web) generate_lead`, Count=One; dependent on fixing F1/F6 |
| **GTM + CONSENT** | ❌ `FAIL` (tags) / ⏳ `OWNER_EVIDENCE_PENDING` (consent) | tag defects F1–F4/F6 confirmed; Consent Mode not evidenced (F7) — Owner Action C |
| **MAIL DELIVERY** | ⏳ `OWNER_EVIDENCE_PENDING` | one email per submission — inbox |
| **LIVE FORM QA** | ⏳ pending | needed to confirm runtime magnitude of F1–F4 (DebugView) |
| **72H OBSERVABILITY** | `NOT_STARTED` | gate FAILs until the GTM defect is fixed and re-verified |

## §26 verdict block

```
CITYEE X999⁵  PRODUCTION ATTRIBUTION CLOSURE

Commit:              17cc665 (impl) · babc444 (evidence) · this report
Production release:  UNKNOWN — session on local checkout (SERVER_ACCESS_PENDING)
Baseline start:      NOT STARTED

Proof 1 — Production schema:          SERVER_ACCESS_PENDING   (prod shell — 3 read-only cmds)
Proof 2 — Four live forms + email:    OWNER_EVIDENCE_PENDING  (inbox + DebugView QA)
Proof 3 — GA4 exactly-once:           FAIL (config)           (F1 duplicate sender + F2 all-pages + F3 mismatch + F6 no event_id)
Proof 4 — Google Ads single Primary:  PASS (config)           (one CityEE Primary, Count=One; fix F1/F6)
Proof 5 — Consent Mode:               OWNER_EVIDENCE_PENDING  (Owner Action C — consent overview)

Dedup (code):         CONTAINED_UNREACHABLE   (server path complete; but event_id not wired in GTM → F6)
SEO non-regression:   PASS (code-side)        (render-check 44/44; prod HTTP pending)
Security red-team:    PASS (22) / 1 PARTIAL / 2 PENDING (GTM/Ads)

72H monitoring:       NOT STARTED (blocked until GTM defect fixed + re-verified)
14-day baseline:      NOT STARTED

Implementation defects (Laravel/site): 0
GTM measurement defects: P1 ×5 (F1,F3,F4,F6 + F7-pending), latent P0 ×1 (F2)

GLOBAL VERDICT:  GLOBAL FAIL — PROVEN GTM MEASUREMENT-CONFIGURATION DEFECT
                 (implementation PASS; the fault is in GTM container GTM-5DRRX5ZJ, not the code)

NEXT SAFE ACTION:
  Aleksandr applies GTM Owner Actions A + B (remove duplicate/all-pages generate_lead tags;
  repoint the single lead tag to Custom Event `generate_lead` and map event_id), then confirms
  in GA4 DebugView with one real form submit + one WhatsApp click. See the analysis doc.
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

## Stage B — owner evidence RECEIVED and analysed (2026-09-08)
Aleksandr's **OWNER EVIDENCE PACK** (29 screenshots: GA4 + Google Ads + GTM, `docs/CITYEE screens/`)
was analysed as a whole → the F1–F8 findings above. Full analysis + current-state capture + root
causes + rollback: **`docs/CITYEE_OWNER_EVIDENCE_ANALYSIS_GTM_GA4_ADS.md`**.

**Owner actions to fix (GTM — read-only state already captured; apply after go-ahead):**
- **A** — remove the duplicate `generate_lead` tag + the All-Pages `generate_lead` tag (F1, F2, F5).
- **B** — repoint the single lead tag to Custom Event `generate_lead` and map `event_id` (F3, F6).
- **C** — capture Consent Mode current state (F7).
- **Website (Claude, gated on B):** drop the contact-click `lead_submit_success` push so clicks stop feeding the lead event (F4).

Then confirm in GA4 DebugView: a real form submit → exactly one `generate_lead` with `event_id`, no
PII; a WhatsApp click → no `generate_lead`. Only after that does the 72H gate reopen.

## Why this is FAIL now (it was PENDING before the pack)
Before the pack, no defect was proven → the honest state was PENDING. Aleksandr's evidence changed
that: the GTM container has a **proven configuration defect** (duplicate `generate_lead` sender; a
lead event on every page view; the site/GTM event-name mismatch; `event_id` not forwarded). A proven
defect is FAIL, not PENDING. Crucially, the fault is **in the GTM container, not in the Laravel code**
— the implementation layer stays PASS. `GLOBAL PASS` needs Owner Actions A+B (+C) applied, confirmed
in DebugView, then a clean 72H window.

## Deliverables (§25)
`production-attribution-schema-proof.txt` · `production-form-qa-results.csv` (skeleton) ·
`ga4-production-lead-proof.md` · `google-ads-conversion-inventory.csv` (skeleton) ·
`consent-mode-production-proof.md` · `dedup-production-verdict.md` ·
**`CITYEE_OWNER_EVIDENCE_ANALYSIS_GTM_GA4_ADS.md` (GTM+GA4+Ads pack analysis)** ·
`CITYEE_ATTRIBUTION_RED_TEAM_EVIDENCE.md` · `CITYEE_72H_PRODUCTION_MONITORING_LOG.md` (template) ·
`CITYEE_14_DAY_REVENUE_INTELLIGENCE_BASELINE.md` (template) · **this report** ·
`CITYEE_OWNER_EVIDENCE_HANDOFF_PROTOCOL.md` · `CITYEE_OWNER_EVIDENCE_REQUESTS.md` ·
operator + rollback runbooks.
