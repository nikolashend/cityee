# CITYEE — Selective Winner Recovery · BATCH 1 PLAN (implementation-ready, NOT implemented)

**Date:** 2026-09-14 · **Status:** `IMPLEMENTATION_READY=YES` · `IMPLEMENTATION_EXECUTED=NO` ·
`PRODUCTION_CHANGED=NO` · `DEPLOY_EXECUTED=NO` · `WAITING_FOR_OWNER_APPROVAL_FOR_BATCH_1=YES`

## Senior decision question (§55)
*"If we could change only ONE thing on ONE URL and then wait long enough to measure it, what has
the strongest evidence-to-risk ratio?"* → **Remove the exact broker head-term "Маклер в Таллинне"
from the `/ru/` homepage `<title>`** — the only broker-claiming signal on the non-owner, introduced
the same week the specialist was created, on the one query family (MAKLER) whose loss is a clean
ranking-loss signature (impressions flat, position down). Non-owner first (§22); title-only
(§2.5); one variable (§2.6); fully reversible.

## BATCH 1A

| Field | Value |
|---|---|
| **RECOVERY_ID** | `RB1A-RU-HOME-TITLE-DECONFLICT` |
| **target_url** | `https://cityee.ee/ru/` (RU language homepage — the **non-owner**) |
| **intended owner (protected, untouched)** | `https://cityee.ee/ru/makler-v-tallinne/` |
| **query_family** | MAKLER (маклер · маклер таллинн · маклер в таллинне · маклер недвижимости · услуги маклера) |
| **root_cause** | RC-02 broker ownership fragmentation — MAKLER lexical family (PROBABLE_CANNIBALIZATION) |
| **exact_current_signal** | `<title>Маклер в Таллинне — продажа и аренда недвижимости \| CityEE</title>` (DIRECT_PRODUCTION 2026-09-12) |
| **exact_proposed_signal** | `<title>Продажа и аренда недвижимости в Таллинне и Харьюмаа \| CityEE</title>` |
| **tokens removed** | `Маклер в Таллинне —` |
| **tokens added** | `и Харьюмаа` (geo already in the live H1; keeps homepage geo scope) |
| **repository location** | `config/cityee.php` → `'home'`-level `'ru' => ['meta_title' => …]` at **line 585** (validated: production title == this config value) |
| **why smallest safe change** | On `/ru/` the live H1 is already "Продажа недвижимости в Таллинне и Харьюмаа без потери в цене" (`resources/views/pages/home.blade.php:17`) — no broker term. Only the `<title>` claims the broker head term. Changing the title aligns title↔H1 and removes the collision **without** touching H1/hero/body/links/canonical/hreflang/route. |
| **intended ownership after** | MAKLER family → `/ru/makler-v-tallinne/` sole primary; `/ru/` = RU service-ecosystem entry (seller/rental proposition + geo). |
| **protected intent retained on /ru/** | seller proposition ("продажа"), rental ("аренда"), geo (Таллинн + Харьюмаа), brand suffix. Homepage keeps independent seller intent. |
| **queries expected to benefit** | маклер, маклер таллинн, маклер в таллинне (specialist regains sole title-level claim) |
| **queries that must stay protected** | "cityee" brand (unaffected — brand suffix kept); продать/продажа квартиры (owner `/ru/prodat-kvartiru-v-tallinne/`, untouched); оценка (control, untouched); риелтор/риэлтор (root `/` supporting visibility is benign and untouched) |
| **pages that must NOT change in 1A** | `/`, `/ru/makler-v-tallinne/`, `/ru/tallinn/`, `/ru/agentstvo-nedvizhimosti-tallinn/`, `/ru/prodat-kvartiru-v-tallinne/`, `/ru/ocenka-kvartiry-v-tallinne/`, all ET/EN pages, nav/footer/links, canonical/hreflang/schema |
| **rollback value (exact)** | `'meta_title' => 'Маклер в Таллинне — продажа и аренда недвижимости \| CityEE',` |
| **change budget** | 1 URL · 1 field (`<title>`) · 1 config line |
| **confidence** | MEDIUM (mechanism PROBABLE; exact `/ru/` Query→Page CSV not yet validated — see gap) |

## Evidence behind 1A (classified)
- DIRECT_REPO: `config/search_intents.php` `broker_tallinn` → primary `/ru/makler-v-tallinne/`, tier S.
- DIRECT_PRODUCTION: `/ru/` title carries the exact phrase; `/ru/` H1 does not; root `/` has zero RU text.
- DIRECT_GIT_HISTORY: `a3ea5c0` (2026-03-11) **added** the `/ru/` `meta_title` with "Маклер в Таллинне"; specialist created `8aae1b3` (03-10).
- OWNER_STATED (approx., screenshot-level precedence): "маклер" impr 106→106, pos 7.75→10.69; "маклер таллинн" pos 7.63→10.66 → ranking loss not explained by demand/query-mix.
- CORRELATION: same-week introduction; control (ocenka) with a single clean owner stayed stable.

## Evidence gap classification (§38 / §65-J)
No supplied dataset is an **EXACT** `/ru/` page export (the `/ru/` file is `URL_CONTAINS` / RU
subtree — §58). Classification: **NONBLOCKING for plan readiness** (the collision is directly
observable in production + repo + git, and the change is reversible on a non-owner), but the exact
`/ru/` export is **REQUIRED as the pre-deploy BASELINE** (§64) — it is the PRECONDITION step below,
not a reason to hold the plan. Request: `SEARCH_OWNER_EVIDENCE_REQUESTS.md` #1.

## Sequence (§47)
```
PRECONDITION  → owner exports EXACT /ru/ Queries (3M vs prev 3M, Estonia) + exact /ru/makler-v-tallinne/
                Queries + Query-contains "маклер" Pages  → baseline frozen (§64 spec below)
      ↓
BATCH 1A      → change config/cityee.php:585 meta_title (1 line) → deploy → view:clear
      ↓
RECRAWL       → confirm new <title> live (curl) → request GSC URL inspection/live test (no indexing spam)
      ↓
OBSERVE       → 14–21 days after reprocessing (28d + 3M context)
      ↓
GO / HOLD / ROLLBACK (gates below)
      ↓
BATCH 1B      → only if justified: /ru/tallinn/ title "…| Маклер по районам" → geo angle (separate variable)
```

## Frozen baseline spec (§64) — capture immediately before deploy
| slice | URL | dims | window | metrics |
|---|---|---|---|---|
| intended owner | `/ru/makler-v-tallinne/` (EXACT) | Queries; Devices | last 28d + last 3M vs prev 3M, Estonia | clicks, impr, CTR, avg pos |
| competing URL | `/ru/` (EXACT — not contains) | Queries; Devices | same | same |
| total family | Query contains `маклер` (and `риелтор`, `риэлтор` separately) | Pages | same | same → URL_IMPRESSION_SHARE per family |
| controls | `/ru/ocenka-kvartiry-v-tallinne/` (EXACT); brand query `cityee` | Queries | same | same |

## Pre-deploy tests (existing, safe)
`php artisan test --filter='SeoIndexationTest|TrailingSlashLinksTest'` (11 pass baseline) ·
`php artisan cityee:render-check` (44/44) · `php artisan seo:audit-intents` · `seo:audit-links`.
Do not update snapshots to force green.

## Post-deploy checks
- HTTP: `curl -sI https://cityee.ee/ru/` → 200; `<title>` == proposed; canonical unchanged
  (`https://cityee.ee/ru/`); hreflang unchanged (et/ru/en/x-default); no `noindex`.
- Render: `cityee:render-check` 44/44; H1 unchanged; nav/footer unchanged.
- SEO: `seo:audit-intents` PASS; `seo:audit-links` PASS; sitemap unchanged.
- Analytics non-regression: `generate_lead` still fires on a form submit (GTM unchanged — this task
  touches no measurement); `node tests/js/lead-tracking.test.cjs` 50/50.

## Observation & gates (§44–§46)
- **Success:** `/ru/makler-v-tallinne/` avg position for MAKLER family improves toward ≤9 (from
  ~10.7) and/or its URL_IMPRESSION_SHARE rises; specialist clicks/CTR up; total MAKLER-family
  impressions stable or up; `/ru/` brand ("cityee") visibility unchanged.
- **Failure:** total MAKLER-family impressions fall materially (> −25%) with no specialist gain; or
  `/ru/` loses branded visibility; or an unrelated seller cluster (prodat/ocenka) deteriorates.
- **Stop/rollback:** any failure signal sustained ≥ 10 days (not 1–3 days of noise); indexing/snippet
  anomaly on `/ru/`. Rollback = restore the exact title string above (1 line), redeploy, `view:clear`.

## No-regression targets (§40) — all preserved by design
HTTP status · canonical · indexability · hreflang · schema · language routing · navigation · lead
forms · analytics · consent · rendering · CWV-sensitive structure — **none touched** (title string only).

## Explicitly NOT in Batch 1
Root `/` (no removable RU token; x-default/entity authority; benign SUPPORTING); `/ru/tallinn/`
(1B candidate, separate variable); agentstvo (not a material competitor on evidence); the specialist
itself (owner, protected); any ET page; any redirect/canonical/URL/H1/body change; measurement stack.

---

## 2026-09-15 GATE RESULT (exact GSC reconciliation) — supersedes the 09-14 confidence line
See `EXACT_GSC_EVIDENCE_RECONCILIATION_2026-09-15.md`.
- Exact `/ru/` + exact specialist page data validated (GSC chips without "+" = exact; XLSX files not on disk).
- Decisive: head query "маклер" **transferred** from the specialist (prev 105 impr / 2 clicks -> 0 / 0)
  to `/ru/` (0 -> 106 impr / 2 clicks @ 10.69). RC-02 ownership overlap = PROVEN; causal = STRONGLY_SUPPORTED.
- Control correction: ocenka = MIXED / NOT_CLEAN_STABLE_CONTROL (aggregate worse, primary query improved).
- Proposed title: ACCEPT_WITH_CONCERN (aligns with existing H1; no new head claim).
- **BATCH_1A_DECISION = GO** (G1-G12 pass). **BATCH_1A_CONFIDENCE = MEDIUM_HIGH** (was MEDIUM).
- Baseline: Datasets A + B already captured; no new 3-month forensic needed before deployment.
- Still: IMPLEMENTATION_EXECUTED=NO / PRODUCTION_CHANGED=NO / DEPLOY_EXECUTED=NO. Requires a separate,
  explicitly owner-approved implementation task. One variable only; `/ru/tallinn/`, `/`, specialist, ET untouched.
