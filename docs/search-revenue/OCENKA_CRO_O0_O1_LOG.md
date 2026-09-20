# OCENKA PAID-SEARCH CRO — O0 BASELINE FORENSIC + O1 IMPLEMENTATION LOG

**Target:** `https://cityee.ee/ru/ocenka-kvartiry-v-tallinne/` · **Date:** 2026-09-18 ·
**O1 commit:** `d70ec3d` (2 files, +15/−5) · **Batch 1A clock untouched:** T0 = 2026-09-17 15:39:20 EEST.

## O0 — A. Executive verdict → `O0_COMPLETE_WITH_OWNER_EVIDENCE_PENDING`; O1 gate = **GO (technical)**
Production + source **prove** a page-specific conversion-path defect stronger than the hypothesis: the
valuation-labelled primary CTA and the bottom CTA both scrolled to the **Audit** form; the audit-labelled
secondary button was the only path to the valuation form; forms rendered audit-first. No SEO/measurement
defect; no Batch 1A interference required. Paid/GA4 baseline is owner-only → `OWNER_EVIDENCE_PENDING`.

## B. Production architecture (baseline 2026-09-18 09:47:44 EEST)
HTTP 200 · final URL unchanged · title `Оценка квартиры в Таллине — реальный ценовой коридор | CityEE` ·
meta description present · canonical self · no robots meta (indexable) · H1 `Оценка квартиры в Таллине —
реальный ценовой коридор перед продажей` · hreflang ru-EE + x-default · 7 JSON-LD blocks.
DOM order: … H2 "Хотите узнать реальную стоимость квартиры?" → **`#v3-form-audit`** ("Заказать аудит
объявления") → `#v3-form-calc` ("Рассчитать реальную цену") → global popups (callback/inquiry).
CTAs (DOM order): hero "Узнать цену квартиры" (**→ #v3-form-audit**), "Получить аудит объекта" (→ #v3-form-calc),
sidebar "Узнать ценовой коридор"/"Заказать аудит", calc submit "Получить коридор цены", sticky "Бесплатный аудит".

## C. Source dependency map (DIRECT_REPO)
`routes/web.php:94` `/ocenka-kvartiry-v-tallinne` → `Phase3Controller::landing('ocenka-kvartiry-v-tallinne')`
→ `config/cityee-phase3.php` `landings.ocenka-kvartiry-v-tallinne` (labels/h1/meta/faq)
→ **shared** `resources/views/pages/phase3-landing.blade.php` (hero CTAs L66–67, bottom CTA L139, forms L159–160)
→ `components/v3/form-calc.blade.php` (valuation) + `components/v3/form-audit.blade.php` (audit)
→ `components/v3/form-scripts.blade.php` (AJAX, success-only `generate_lead` push via `cityee-lead-tracking.js` contract)
→ `POST /contact/price-calculator` / `POST /contact/audit-request` → `ContactController` → `LeadService::record()`
(save-before-mail, 10-min HMAC dedup) → `mail()` to info@cityee.ee → `analyticsPayload()` (event_id, non-PII).
Shared template also renders frozen `/ru/makler-v-tallinne/`, `/ru/prodat…`, `/ru/agentstvo…` (+ ne-prodaetsya, audit, sdat).

## D/E. Conversion paths (before)
Valuation (`price-calculator`): address*, area, rooms, floor, condition(select), contact* — **no listing URL needed**.
Audit (`audit-request`): link(url, optional), district, type*(select), goal*(select), contact*, language.
Server validation in `ContactController`; CSRF via web middleware + `@csrf`; no throttle/honeypot (pre-existing, untouched).

## F. Measurement path (CODE_PATH_VERIFIED)
Success → `{status:OK, lead:{event_id, lead_public_id, form_type, …}}` → exactly one `generate_lead` (success
allowlist, fail-closed for is_test, exactly-once guard) — `tests/js/lead-tracking.test.cjs` 50/50;
`test_analytics_payload_has_no_pii`, `test_duplicate_submissions_create_one_lead`, `test_all_four_form_types_create_leads`.
Live GTM/GA4 behaviour = previously owner-proven (inquiry test); not re-tested here.

## G. SEO baseline — protected, unchanged by O1
URL, title, meta description, canonical, robots, H1, JSON-LD, hreflang, sitemap, nav, body copy: **unchanged** (verified by render).

## H. CRO friction evidence
| claim | status |
|---|---|
| Valuation-labelled primary CTA targets the Audit form | **PROVEN** (template L66 hardcoded `#v3-form-audit` + config label) |
| Bottom valuation CTA targets the Audit form | **PROVEN** (L139) |
| Audit form precedes valuation form | **PROVEN** (L159–160) |
| Competing valuation/audit CTAs create choice friction | STRONGLY_SUPPORTED |
| This leakage lowers paid valuation CVR | POSSIBLE (needs Ads/GA4 baseline → owner) |

## I/J. Ads / GA4 / lead-quality evidence — `OWNER_EVIDENCE_PENDING` (no fabrication)
No Ads/GA4/GSC access here. Requests below. Lead-quality states (NEW/CONTACTED/QUALIFIED/…): **not in schema**
(leads carry attribution: first/last touch source/medium/campaign/gclid, landing_page, submission_page, public_id,
is_test, mail_status, analytics_status, consent_state, timestamps). → `LEAD_QUALITY_LEDGER_STATUS=PARTIAL`
(attribution captured; qualification/outcome absent — future: additive `qualification_status`/`outcome` columns +
CLI-only update, no CRM). `OFFLINE_QUALITY_LOOP_READINESS=PARTIAL` (gclid + event_id + public_id captured; no
qualification state, no upload mechanism). Notification path: 4 handlers → `mail()` to info@cityee.ee after persist.

## O1 — exact change (commit `d70ec3d`)
- `phase3-landing.blade.php`: anchors/form order become optional per-landing keys with **defaults = old markup**.
- `cityee-phase3.php` (ocenka only): `cta_primary_target=#v3-form-calc`, `cta_secondary_target=#v3-form-audit`,
  `cta_bottom_target=#v3-form-calc`, `forms_order=calc-first`; labels → "Получить реальный ценовой коридор" /
  "Аудит уже опубликованного объявления".
- Not changed: `calc_title`/`calc_submit`/`audit_*` (shared sitewide via `cityee-v3.php`, also on frozen `/ru/`),
  sticky "Бесплатный аудит" (shared partial) — residual audit competition **DEFERRED** (noted, not fixed).
- 2-step form: **DEFERRED_TO_O2_FOR_EXPERIMENT_ISOLATION**.

## Non-interference proof (Batch 1A)
Rendered before/after (CSRF-normalized, CR-normalized): `/ru/`, makler, tallinn, prodat, agentstvo,
ne-prodaetsya, audit, sdat → **0 changed lines each**. Only Ocenka differs (intended). `FROZEN_BATCH_1A_URLS_AFFECTED=0`.

## Gates
render-check 44/44 · seo:audit-intents PASS · seo:audit-links PASS · Feature tests 36/188 · JS matrix 50/50.
Diff: FILES_CHANGED=2 · LINES_ADDED=15 · LINES_REMOVED=5 · SEMANTIC_URLS_CHANGED=1 · SEO_FIELDS_CHANGED=0 ·
FORM_BEHAVIOR_CHANGED=order+anchors only (fields/validation/endpoints unchanged) · TRACKING_EVENT_DEFINITIONS_CHANGED=0 ·
SHARED_COMPONENTS_CHANGED=1 (template, default-preserving, proven no-op elsewhere) · UNRELATED_CHANGES_INCLUDED=0.

## Deployment gate (§67)
`LOCAL_O1_PREPARATION=ALLOWED` (done). `O1_PRODUCTION_DEPLOY=BLOCKED_PENDING_BASELINE`: capture the Ads + GA4
baseline for this LP **before** deploying (Ads/GA4 retain history, so this is a ~10-minute export, not a delay of days).
Then operator deploys: `git push origin main` → prod `git pull && php artisan optimize:clear` (no migrate/seed).
Pre-deploy drift gate: re-check production title/H1/canonical/CTA order equals the 09-18 baseline.

## OWNER_EVIDENCE_REQUESTS (baseline — required before deploy)
```
#1 SYSTEM=Google Ads · PATH=Campaigns > (Ocenka Tallinn / Ocenka Lasnamäe) > Ad groups + Landing pages
   DATE_RANGE=last 30 days ending the day before deploy · FILTER=final URL contains /ru/ocenka-kvartiry-v-tallinne/
   METRICS=impressions, clicks, CTR, avg CPC, cost, conversions (cityee.ee (web) generate_lead), device
   EXPECTED=CSV/screenshot · DO_NOT_CHANGE=keywords, bids, RSA, budgets, landing pages, conversion settings
#2 SYSTEM=Google Ads · PATH=Campaigns > Search terms · same range/filter · METRICS=search term, match type, clicks,
   impressions, CTR, CPC, cost, conversions · EXPECTED=CSV · DO_NOT_CHANGE=as above (log any hard-negatives with date/query/reason)
#3 SYSTEM=GA4 (G-569W1W9H0W) · PATH=Reports > Engagement > Pages / Landing page = /ru/ocenka-kvartiry-v-tallinne/
   DATE_RANGE=same 30 days · METRICS=sessions, users, generate_lead (key event) count, device, session source/medium
   EXPECTED=screenshot/export · DO_NOT_CHANGE=GA4/GTM config
#4 (business) SYSTEM=inbox/leads · leads from this LP in the same window: total, spam, buyer/rental, qualified owner,
   meeting — as available · via `php artisan leads:summary --from=<date>` (read-only, no PII) + owner classification
```

## Observation (after T0 is set on confirmed-live)
`OCENKA_CRO_O1_T0` = production-live confirmation time (Europe/Tallinn) — **PENDING deploy**. Freeze on target:
CTA, form order/fields, hero, layout; Ads strategic freeze (hard-negative hygiene allowed + logged).
T+3–7 technical/measurement sanity · T+14 directional CRO + qualified-lead review · T+21 primary directional gate if
volume · else HOLD_FOR_MORE_DATA. Success = more valid `generate_lead` from valuation intent with preserved/improved
qualified-owner share, no SEO/measurement regression, Audit still reachable. Rollback = revert `d70ec3d` only.

---

## 2026-09-18 — PRE-O1 BASELINE APPROVED · DEPLOY IN PROGRESS
**Owner baseline (captured, approved — Level 1/owner evidence):**
- GA4 landing page `/ru/ocenka-kvartiry-v-tallinne/`, 2026-08-19 → 2026-09-17: 24 sessions, 22 active users,
  21 new users, ~19 s avg engagement/session, **generate_lead = 0**.
- Google Ads Ocenka campaign, 2026-09-04 → 2026-09-17: 7 clicks, 81 impressions, CTR 8.64 %, avg CPC ≈ €0.65,
  cost €4.57, **conversions 0**. Device: predominantly mobile (captured separately).
- Ads change log (pre-O1): "сколько стоит моя квартира" Broad → Exact (before O1; not part of the experiment).
- Reading: 24 sessions / 7 paid clicks and 0 leads → any lead in the window is a signal; volumes are tiny →
  T+21 will likely be `HOLD_FOR_MORE_DATA` unless leads appear. Baseline is a valid before-state.

**Pre-deploy gates (2026-09-18):** worktree clean · approved commit `d70ec3d` in HEAD · production drift gate:
title/H1/canonical/CTA targets/form order == O0 baseline → `PRE_DEPLOY_BASELINE_DRIFT=NO`.
**Established workflow step 1 — push:** `origin/main` = `4871f08` (contains `d70ec3d`; other 2 commits docs-only).
**Step 2 — production pull:** operator action (no production shell here): `git pull && php artisan optimize:clear`.
Production polled ×3 after push: still old state (no auto-deploy). `OCENKA_CRO_O1_T0` **not set** — will be set
only when the O1 state is confirmed live.

**Post-pull verification to run (ready):** HTTP 200; hero primary → `#v3-form-calc`; bottom → `#v3-form-calc`;
secondary → `#v3-form-audit`; form order calc → audit; title/description/H1/canonical/robots/JSON-LD/hreflang
unchanged; Batch 1A frozen URLs unchanged; desktop/mobile sanity; one controlled valuation submission
(labelled `CITYEE-CRO-O1-TEST`, session marked `?gclid=CITYEE_TEST_O1` → `is_test=true`, never an Ads conversion)
+ immediate duplicate re-POST must return the same `lead_public_id` (dedup) — then T0.

---

## 2026-09-20 — O1 PRODUCTION VERIFIED · **OCENKA_CRO_O1_T0 = 2026-09-20 19:56:16 EEST (Europe/Tallinn, UTC+03:00)**
Production pull completed by operator (commit `d70ec3d`). Post-deploy verification (read-only GET, no-cache):

**Target `/ru/ocenka-kvartiry-v-tallinne/`:** HTTP 200 · final URL unchanged · hero primary
"Получить реальный ценовой коридор" → `#v3-form-calc` ✓ · bottom "Узнать ценовой коридор" → `#v3-form-calc` ✓ ·
secondary "Аудит уже опубликованного объявления" → `#v3-form-audit` ✓ · form order **price-calculator → audit-request** ✓ ·
title / meta description / H1 / canonical (self) / robots (none, indexable) / 7 JSON-LD blocks / hreflang ru+x-default —
**all unchanged** ✓.
**Batch 1A frozen URLs** (`/ru/` incl. its Batch 1A title, makler, tallinn, prodat, agentstvo): title/canonical/H1 unchanged ✓.
**Mobile (iPhone UA):** identical CTA targets and form order (single responsive template), viewport meta present, numeric
inputs for area/rooms — structural sanity PASS (desktop PASS likewise). No CSS/layout change was part of O1.

**Controlled valuation submission (live, labelled `CITYEE-CRO-O1-TEST`, session marked `?gclid=CITYEE_TEST_O1`):**
POST `/contact/price-calculator` → HTTP 200 `{"status":"OK", lead:{lead_public_id: 01M2ZVYEJ04WB397VJPPG5F4TY,
event_id: 7d3516b5…28e8, form_type: price_calculator, source_class: google_ads, has_gclid: true, **is_test: true**}}`
→ `LIVE_PERSISTENCE_VERIFIED` (a real production lead row exists; `is_test=true` ⇒ excluded from KPIs, frontend
suppresses `generate_lead`, can never become an Ads conversion). Payload contains **no PII** (address/contact absent).
**Immediate duplicate re-POST** → same `lead_public_id` → server-side dedup intact (no second lead, no second email).
One labelled notification email to info@cityee.ee was generated by the test — disregard.
Measurement: existing GTM→GA4 exactly-once and Ads config were owner-verified earlier; no regression path was
touched (form endpoints, `form-scripts`, `cityee-lead-tracking.js`, GTM/GA4/Ads/CMP all unchanged).

**Freeze active from T0 (target page):** primary CTA, form order/fields, hero, layout; Ads strategic freeze
(hard-negative hygiene allowed + logged). Batch 1A clock remains separate: 2026-09-17 15:39:20 EEST.

| checkpoint | date (Tallinn) | action |
|---|---|---|
| T+3–7 | 2026-09-23 → 09-27 | technical + measurement sanity only (state still live, form works, no duplicate events) |
| T+14 | 2026-10-04 | directional CRO + qualified-lead review (leads:summary --from=2026-09-20 --exclude-test; Ads/GA4 LP) |
| T+21 | 2026-10-11 | primary directional gate if volume sufficient; else HOLD_FOR_MORE_DATA |
| T+28+ | 2026-10-18+ | extended window if volume remains low |

Baseline for comparison: GA4 LP 24 sessions / 0 generate_lead (08-19→09-17); Ads 7 clicks / 0 conv (09-04→09-17).
Rollback = revert `d70ec3d` only. O2 (2-step form) NOT started. `O1_ROLLBACK_EXECUTED=NO`.
