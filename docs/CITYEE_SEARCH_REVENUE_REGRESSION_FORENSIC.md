# CITYEE — Search Revenue Regression Forensic (READ-ONLY)

**Date:** 2026-09-12 · **Mode:** forensic, zero mutation · **Scope:** why qualified search
visibility declined; evidence package for a later *selective* Historical Winner Recovery. **No
recovery implemented.** GSC query-level data I cannot access is marked `OWNER_EVIDENCE_PENDING`; the
owner's §3 baseline is treated as input evidence, verified against repo/production where possible.

Evidence provenance tags: `PROD_HTTP` (live GET), `REPO` (code), `GIT` (history), `OWNER_GSC`
(owner-supplied §3), `TOOL` (repo audit command). Confidence: `PROVEN / STRONGLY_SUPPORTED /
PLAUSIBLE / WEAK / REJECTED / INSUFFICIENT_EVIDENCE`.

---

## 1. Executive verdict — **FORENSIC_COMPLETE_WITH_NONBLOCKING_EVIDENCE_GAPS**

The decline is **not** a Google penalty, **not** a sitewide technical defect, and **not** a brand
collapse — all rejected by evidence (§24). The dominant, evidence-backed root cause on the flagship
commercial cluster is **intent-ownership cannibalization (RC-02)**: multiple RU URLs compete for the
broker/"маклер" query the registry assigns to a single specialist page. Secondary contributors:
homepage-as-fallback expansion on `/ru/` (RC-02/RC-04) and a mobile-weighted CTR/position pattern
(RC-03) that needs GSC query-level confirmation. No `P0_SEARCH_DEFECT` found: every protected winner
is `200`, self-canonical, indexable (no `noindex`).

**One thing elevates the top hypotheses from STRONGLY_SUPPORTED to PROVEN:** a GSC *Query→Page*
export for the broker/valuation clusters over Window A (see Owner Evidence Requests). It is
non-blocking for handoff — the recovery direction is already clear and low-risk.

## 2. Scope
Google organic search revenue regression for CITYEE.ee, seller-intent-weighted. Priority URLs (§12):
`/ru/makler-v-tallinne/`, `/ru/tallinn/`, `/`, `/ru/`, `/ru/ocenka-kvartiry-v-tallinne/` (control),
`/ru/prodat-kvartiru-v-tallinne/`, `/ru/agentstvo-nedvizhimosti-tallinn/`,
`/en/knowledge/real-estate-market-analysis-tallinn-2026/`.

## 3. Evidence sources
- `PROD_HTTP`: live GET of the 8 priority URLs (status, title, H1, canonical, hreflang, robots).
- `REPO`: routes, `config/cityee-phase3.php`, `config/cityee.php`, `config/search_intents.php`, `config/money_pages.php`, `config/seo_protected_assets.php`, templates, internal links.
- `GIT`: full history with dates for the priority templates/config.
- `TOOL`: `seo:audit-intents`, `cityee:render-check` (44/44), `SeoIndexationTest`/`TrailingSlashLinksTest` (11 passed).
- `OWNER_GSC`: the §3 baseline figures (approximate, owner-exported).

## 4. Data limitations
- No direct GSC/API access → query×URL ownership over time is `OWNER_EVIDENCE_PENDING`.
- Git history reflects the **repository**; production is verified separately (§36) — no material drift found on the priority URLs' head signals.
- 7-day figures are early-warning only; not used to drive conclusions (§3.9).

## 5. Site-level search trend (`OWNER_GSC`, verified direction)
~171 clicks / 12.7K impr / CTR ~1.3% / pos ~12.7 (3M). Clicks fell materially while impressions fell
much less → **not a pure demand collapse** (STRONGLY_SUPPORTED). Impression stability with click loss
points to query-mix / ownership / CTR effects, not disappearance of the site.

## 6. Qualified seller visibility trend
Aggregate site numbers **understate** the commercial problem: the highest-value cluster (broker) lost
rank while a control cluster (valuation) held. Seller-weighted visibility declined more than the
aggregate suggests (STRONGLY_SUPPORTED via §10/§11 winner deltas; exact seller-query totals =
`OWNER_EVIDENCE_PENDING`).

## 7. Language analysis
- **RU** — the commercial core; both the loss (makler, /ru/tallinn/) and the control (ocenka) are RU. Focus of this forensic.
- **ET** — highest *future* priority; registry defines ET owners (`kinnisvara-muuk`, etc.). No ET regression evidenced here; ET risk is *architectural* (avoid repeating RU cannibalization). No ET pages created (out of scope).
- **EN** — authority layer; the market-analysis page is `200`/canonical/trilingual hreflang. Protect; no evidence it steals RU commercial intent.

## 8. Geo analysis
Priority geo = Estonia → Tallinn → Harjumaa. Owner 28-day Estonia data shows position improving
(14.98→13.40) while clicks fell (47→33) → query-mix/CTR effect, not pure rank loss (RC-03/RC-04).
Sub-geo (Tallinn vs Harjumaa) splits = `OWNER_EVIDENCE_PENDING`.

## 9. Device analysis
`OWNER_GSC`: historical mobile deteriorated more (clicks 145→94, pos 7.89→9.53) than desktop; recent
28-day mobile *position recovered* (11.88→7.89) while clicks fell (35→19). → decline is **not**
explained by ranking alone; a mobile CTR/query-mix component exists (RC-03). **Do NOT attribute to
Core Web Vitals** without page-level temporal evidence (none found) — `WEAK/REJECTED` for CWV.

## 10. Historical winner analysis (`PROD_HTTP` + `OWNER_GSC`)
| URL | Current head (PROD_HTTP) | Owner GSC (prev→cur) | Read |
|---|---|---|---|
| `/ru/makler-v-tallinne/` | 200, self-canon, no noindex, title "Профессиональный маклер и риелтор… 10+ лет, 300+ сделок", hreflang ru+x-default | pos 9.33→14.10, clicks 28→15 | **RANKING_LOSS on the winner while it still holds the query** — classic cannibalization signature (query impressions stable, position down) |
| `/ru/tallinn/` | 200, title "Продажа квартир в районах Таллина \| Маклер по районам" | pos 15.9→22.4, clicks 21→7 | broad geo hub, title also carries "Маклер" → competes |
| `/ru/ocenka-kvartiry-v-tallinne/` | 200, title "Оценка квартиры… реальный ценовой коридор" | pos ~10.0→10.1 (stable) | **CONTROL** — single clean owner, no title competitor |
| `/ru/agentstvo-nedvizhimosti-tallinn/` | 200, title "Агентство недвижимости… продажа, аренда, аудит" (broad) | — | broad; overlaps broker intent |
| `/ru/` | 200, title **"Маклер в Таллинне — продажа и аренда…"** | impr 538→1088, pos 18.83→26.49 | homepage expanded into many queries incl. broker |
| `/` | 200, ET title, brand "cityee" pos ~3 stable | non-brand pos 13.24→15.19 | brand healthy; non-brand soft |
| EN market-analysis | 200, trilingual hreflang | — | authority asset, protect |

## 11. Query ownership analysis
Registry (`config/search_intents.php`, `REPO`) declares single owners per cluster — e.g.
`broker_tallinn` (queries "маклер таллинн", "маклер в таллинне", "риелтор таллинн", …) → **primary
`/ru/makler-v-tallinne/`, tier S**. Production titles show the homepage and geo-hub competing for that
exact cluster. See `CITYEE_QUERY_OWNERSHIP_REGISTRY.csv`. Current live SERP owner per query =
`OWNER_EVIDENCE_PENDING` (GSC Query→Page).

## 12. Cannibalization analysis (core finding — RC-02)
**STRONGLY_SUPPORTED.** Four RU URLs carry broker/"маклер" intent in their production titles:
1. `/ru/makler-v-tallinne/` — the registry's intended owner (specialist).
2. `/ru/` — homepage title *leads* with "Маклер в Таллинне — продажа…" (`config/cityee.php:585`; introduced `a3ea5c0`, 2026-03-11 `GIT`).
3. `/ru/tallinn/` — title "…\| Маклер по районам" (`config/cityee-phase3.php:510`).
4. `/ru/agentstvo-nedvizhimosti-tallinn/` — broad "продажа, аренда, аудит".

The automated gate `seo:audit-intents` returns **PASS / 0 competing pairs** — but only compares
*registry primaries* to each other; the homepage and geo hub are **not** registry primaries, so their
competing titles are a **blind spot** (`TOOL`). This explains why cannibalization passed CI yet exists
on-page. Confirmation that Google reassigned the query to `/ru/` requires GSC Query→Page
(`OWNER_EVIDENCE_PENDING`).

## 13. Homepage analysis (§24)
Brand ("cityee") stable (pos ~3). `/ru/` impressions ~doubled while position fell sharply → homepage
became a **broad fallback owner** (RC-02/RC-04). Whether this is healthy expansion or intent dilution
depends on the new query set's commercial value → `NEW_QUERY_SET` classification is
`OWNER_EVIDENCE_PENDING` (GSC `/ru/` Queries, Window A). Do **not** expand the homepage until owner is known.

## 14. Internal authority analysis (`REPO`)
`/ru/makler-v-tallinne/` has the **most** internal inbound references (12 in `resources/`) vs agentstvo 5,
prodat 9, ocenka 7 — it is **well-linked, not authority-starved**. → **RC-06 authority dilution
REJECTED as primary cause** for makler. (Anchor-text distribution + historical inbound counts =
`INSUFFICIENT_EVIDENCE` without a crawl diff; see recovery candidates for a low-risk anchor tightening.)

## 15. Git historical change analysis (`GIT`) — see `CITYEE_SEO_CHANGE_TIMELINE.md`
- **2026-02-27 → 03-23:** the big build — `82a4cae` phase 3, `820e92a` phases 4-6, `8aae1b3` "Phase 3: full recovery + SEO domination" (winners created), **`a3ea5c0` 03-11 "SEO meta …"** (homepage retitled to lead with "Маклер в Таллинне"), `50da00b` 03-17 "Phase 1-4 hardening", `31f09f0` 03-23 "GSC hardening".
- **2026-07:** registry/gate wave (`33b8bc4`, `813333b`) — added protected-asset/intent registries + cannibalization gate (the one with the homepage blind spot).
**Temporal correlation:** the specialist page and the competing homepage title were introduced **the
same week (2026-03-09..11)**. Causality status: **POSSIBLY_CAUSAL → LIKELY_CAUSAL** pending GSC
Query→Page. `CORRELATION != CAUSATION` — flagged accordingly.

## 16. Technical SEO analysis (`PROD_HTTP`) — clean on winners
All 8 priority URLs: `200`, self-referential canonical, **no `noindex`**. No redirect/status defect
on winners. → **RC-05 technical regression REJECTED for the winners** (site-wide crawl beyond these 8
= `seo:audit-production` recommended, not run destructively here).

## 17. Canonical analysis
All priority URLs: `CANONICAL_OK` (self canonical, absolute https, trailing slash). No collision
observed on the 8. Full-site slash/param variants = `INSUFFICIENT_EVIDENCE` here (use `seo:audit-production`).

## 18. Hreflang analysis (finding)
Asymmetry (`PROD_HTTP`): hubs `/`, `/ru/`, EN market-analysis carry full `et/ru/en/x-default`; the RU
seller winners (`makler`, `prodat`, `ocenka`, `agentstvo`, `tallinn`) carry **only `ru-EE + x-default`**.
Not a ranking-loss cause (hreflang doesn't drop a page 9→14), but it means the RU seller pages are an
**RU-only cluster with no ET/EN intent siblings** — relevant to §8 language-parity-by-intent and to ET
planning. Classify: `PLAUSIBLE` contributor to language-collision only; `WEAK` for the rank loss.

## 19. Sitemap / indexability analysis
Winners are indexable and self-canonical (§16). Historical GSC exclusion buckets (redirected /
crawled-not-indexed / 4xx / 5xx) = `OWNER_EVIDENCE_PENDING` at counts; **critical question answered
for winners: no exclusion affects the 8 protected URLs** (they are live 200/indexable). Do not chase
exclusions to zero (§19 rule).

## 20. Mobile analysis
Mobile deteriorated more historically but position recovered recently (§9). No page-level mobile
rendering defect evidenced on the winners (they render title/H1/canonical server-side). CWV causation
`REJECTED` (no temporal/page evidence). Mobile CTR/query-mix split = `OWNER_EVIDENCE_PENDING`.

## 21. Content / semantic drift analysis
`/ru/tallinn/` and `/ru/agentstvo/` are **broad** (geo hub across districts; "продажа, аренда, аудит")
→ they naturally absorb broker/seller impressions. `/ru/makler-v-tallinne/` stays specialist. The
homepage title broadened into broker intent (§12). Body-level historical diff of each winner =
`INSUFFICIENT_EVIDENCE` without per-page git diffs (candidate for the recovery phase, not needed to
act on the title cannibalization).

## 22. Entity / trust analysis
Broker identity present (Aleksandr Primakov page in registry supporting set; "10+ лет, 300+ сделок" in
makler title). Schema treated as trust layer only (not a ranking hack). No entity defect found;
`INSUFFICIENT_EVIDENCE` for deeper structured-data audit (out of scope, read-only).

## 23. Root cause map — see `CITYEE_SEARCH_REVENUE_ROOT_CAUSE_MAP` in §27 / recovery file
| Cluster/URL | Root cause | Confidence | Priority |
|---|---|---|---|
| broker "маклер" / `/ru/makler-v-tallinne/` | RC-02 cannibalization (homepage + geo-hub + agency titles) | STRONGLY_SUPPORTED | **P0** |
| `/ru/` expansion | RC-02/RC-04 homepage fallback / low-value impression inflation | PLAUSIBLE (needs NEW_QUERY_SET) | **P0-D** |
| `/ru/tallinn/` | RC-02 broad geo hub competing + possible RC-01 | PLAUSIBLE | P0-B |
| non-brand `/` | RC-03/RC-04 CTR/query-mix | PLAUSIBLE | P0-C |
| mobile | RC-03 CTR / query-mix | PLAUSIBLE | P1 |
| `/ru/ocenka…/` | none — STABLE control | PROVEN stable (owner) | DO-NOT-TOUCH |

## 24. Rejected hypotheses (§42)
- "Google penalty" — **REJECTED/UNSUPPORTED** (no evidence; winners indexable).
- "All pages lost rankings" — **REJECTED** (ocenka control stable/improving; brand stable).
- "Brand collapsed" — **REJECTED** ("cityee" pos ~2.95→3.06, clicks 10→14).
- "Core Web Vitals caused it" — **REJECTED** (no page/temporal evidence; mobile position actually recovered recently).
- "Sitewide technical/canonical/noindex defect" — **REJECTED for winners** (all 200/self-canonical/indexable).
- "Authority dilution starved makler of links" — **REJECTED** (makler is the most-linked winner).

## 25. Protected winners (§7) — see `CITYEE_DO_NOT_TOUCH_REGISTER.md`
All eight priority URLs remain protected. No destructive/speculative change authorized.

## 26. Do-not-touch register
See `CITYEE_DO_NOT_TOUCH_REGISTER.md` (ocenka control first).

## 27. Recovery candidate ranking
See `CITYEE_WINNER_RECOVERY_CANDIDATES.md`. Highest-value, lowest-risk first: **tighten homepage &
geo-hub titles off the "маклер (в) таллинне" primary query (R1–R2, reversible)** so the specialist
regains sole ownership — *pending* GSC Query→Page confirmation. No redirects/canonical/URL changes.

## 28. Owner evidence requests
See `CITYEE_SEARCH_OWNER_EVIDENCE_REQUESTS.md` (batched, minimal — one Query→Page export answers most).

## 29. Recommended Phase II
Selective Historical Winner Recovery, smallest-change-first (§33): (1) confirm ownership via GSC;
(2) if confirmed, de-conflict homepage/geo-hub titles from the broker primary (R1–R2); (3) extend the
`seo:audit-intents` gate to include homepage/hubs so this blind spot can't recur; (4) measure one
change at a time to preserve causal observability.

## 30. Final verdict (2026-09-12)
**FORENSIC_COMPLETE_WITH_NONBLOCKING_EVIDENCE_GAPS.** Root cause identified with strong evidence
(cannibalization of the broker cluster + homepage fallback expansion), controls and rejected
hypotheses documented, protected winners intact, recovery direction low-risk and reversible. Elevation
to PROVEN needs one GSC Query→Page export (non-blocking). No P0 search defect. No changes made.

---

# ADDENDUM 2026-09-14 — OWNER-EVIDENCE CLOSURE + BROKER OWNERSHIP PROOF + BATCH 1 PLAN
Continues commit `5634397`. Detailed artifacts in `docs/search-revenue/`. READ-ONLY; nothing deployed.

## A. Executive verdict → **RECOVERY_PLAN_READY_WITH_NONBLOCKING_EVIDENCE_GAP**
Batch 1A is implementation-ready (not implemented): remove the exact broker head term "Маклер в
Таллинне" from the `/ru/` homepage `<title>` (1 URL, 1 field, 1 config line, exact rollback). The
only remaining gap — an EXACT `/ru/` page export — is NONBLOCKING for the plan and REQUIRED as the
pre-deploy baseline. `P0_SEARCH_DEFECT = NONE`.

## B. What the new owner evidence changed
- RC-02 is **REFINED**, not confirmed wholesale: fragmentation is **by lexical family**. Only
  **MAKLER** shows a clean ranking-loss signature (impr 106→106, pos 7.75→10.69); **RIELTOR** is
  benign multi-URL visibility (both URLs' impressions grew; specialist keeps 71% share); **RIELTOR_YO**
  is query-mix-confounded (impr +23%, avg pos −4.2, root *held* ~6 — not displaced).
- Root `/` is **not** a fixable competitor: `lang=et`, x-default → `/`, **zero Cyrillic** on page.
  Its RU broker impressions are entity/x-default authority → benign SUPPORTING. Do not touch.
- ET mechanism is **DIFFERENT_FROM_RU**: `/locations/tallinn/` (ET "Kinnisvaramaakler Tallinnas")
  **301s to `/ru/tallinn/`**; there is no live ET specialist and no ET broker family in the registry —
  root is the sole de-facto ET owner (registry gap, not a collision). No ET change in Batch 1.

## C. GSC evidence quality / filter validation
**No CityEE CSV/XLSX exports were found** (repo, Downloads, Desktop, Documents). The only XLSX are
for **adme.ee** (wrong property) → excluded. The supplied evidence is owner-stated approximate figures
(screenshot-level precedence). The `/ru/` dataset is `URL_CONTAINS / RU_SUBTREE` (§58) → **not**
exact homepage evidence → `EXACT_RU_HOMEPAGE_GSC_EVIDENCE = PENDING`. Manifest:
`search-revenue/OWNER_GSC_EVIDENCE_MANIFEST.md`. No rows fabricated; shares computed only where two
supplied URLs allow (RIELTOR 71%→… stable; RIELTOR_YO 71%→67%; MAKLER share = pending).

## D. Broker query ownership verdict
`BROKER_PRIMARY_OWNER_RU = /ru/makler-v-tallinne/` (registry + still holds the rows). MAKLER =
PROBABLE_CANNIBALIZATION by `/ru/` title; RIELTOR = BENIGN; RIELTOR_YO = POSSIBLE (query-mix);
AGENCY = NO_CONFLICT. Matrix: `search-revenue/BROKER_QUERY_URL_OWNERSHIP_MATRIX.csv`.

## E. RC-02 final status → **REFINED** (mechanism: MAKLER head-term collision on `/ru/` `<title>`,
introduced `a3ea5c0` 2026-03-11 — the `meta_title` key was **added**, no prior broker title existed;
`/ru/` live H1 carries no broker term, so title-only de-confliction suffices).

## F. Exact roles
| URL | role | JTBD (one sentence) | flag |
|---|---|---|---|
| `/` | HOMEPAGE (brand, ET entry, x-default) | Brand + overall seller proposition in ET; sole de-facto ET broker owner. | benign RU supporting; DO NOT TOUCH |
| `/ru/` | LANG_HOMEPAGE (RU service ecosystem) | RU entry to the seller/rental service ecosystem in Tallinn/Harjumaa. | `<title>` claims MAKLER head term → **Batch 1A** |
| `/ru/tallinn/` | GEO_HUB | Tallinn district market/service hub for sellers by district. | trailing "Маклер по районам" → INTENT_DIFFERENTIATION_WEAK vs makler; 1B candidate |
| `/ru/makler-v-tallinne/` | PRIMARY_OWNER (broker) | Choosing/hiring a professional broker in Tallinn. | protected |
| `/ru/agentstvo-nedvizhimosti-tallinn/` | ALTERNATE_SERVICE (agency/company) | Agency/company/service-provider intent. | not material; no change |

## G. Alternative root causes — see `search-revenue/ROOT_CAUSE_CAUSALITY_MATRIX.md`
Accepted: RC-02 (MAKLER, 19/21). Partial: RC-04 CTR (secondary to rank), RC-10 query-mix (explains
RIELTOR/YO only), RC-07 geo hub (secondary). Rejected: RC-01, RC-03 (for MAKLER), RC-05, RC-06 (weak),
RC-09 (external evidence required).

## H. Control-group result — HOLDS. `/ru/ocenka…/` stable (10.02→10.13; assoc. query 18.1→10.6),
no homepage/hub title competitor for "оценка"; brand stable. Isolates page-specific collision.

## I. ET cross-language — `ET_BROKER_MECHANISM = DIFFERENT_FROM_RU` (no live ET specialist; root
sole owner; registry has no ET broker family). Confidence MEDIUM (ET GSC rows not supplied).

## J. Recovery options
- **A — title-only de-confliction on `/ru/`** (non-owner, 1 field): benefit high on MAKLER; evidence
  strong; risk R1–R2; reversible; causally clean; winner untouched; scope 1 line; observe 14–21d. ★
- **B — title + H1/hero de-confliction on `/ru/`**: unnecessary — live H1 already has no broker term;
  adds a variable for no gain. Rejected.
- **C — internal anchor reinforcement to the specialist**: anchors already broker-specific and the
  specialist is the most-linked page; low expected benefit; keep as later support (R1). Not first.
- **D — staged combined (A → observe → 1B `/ru/tallinn/` title)**: selected as the *sequence*, with A
  as the only Batch 1A variable.

## K. Selected strategy — D with A as Batch 1A (one variable, non-owner first, then observe).

## L. Batch 1A exact proposal — `search-revenue/SELECTIVE_WINNER_RECOVERY_BATCH_1_PLAN.md`
`config/cityee.php:585` `meta_title`: **"Маклер в Таллинне — продажа и аренда недвижимости | CityEE"**
→ **"Продажа и аренда недвижимости в Таллинне и Харьюмаа | CityEE"** (removes "Маклер в Таллинне —";
aligns with live H1; keeps seller/rental/geo/brand). Budget 1 URL / 1 field. Rollback = exact current string.

## M. Do-not-touch — `search-revenue/DO_NOT_TOUCH_REGISTER.md` (root `/`, specialist, ocenka control,
prodat, agentstvo, ET pages, `/ru/tallinn/` in 1A, measurement stack).

## N. Remaining owner evidence — `search-revenue/SEARCH_OWNER_EVIDENCE_REQUESTS.md` (#1 EXACT `/ru/`
Queries — **not URL-contains**; #2 exact specialist; #3 family Pages denominators; #4 control/brand;
#5 kristiine P2).

## O. Implementation readiness — **YES** (§65 A–I true; J classified NONBLOCKING with baseline precondition).

## P. Next action — owner exports #1–#3 (baseline) → owner approves a **separate** implementation task
for Batch 1A → deploy 1 line → observe 14–21d → GO/HOLD/ROLLBACK.

```
SEARCH_FORENSIC_FINAL_STATUS=RECOVERY_PLAN_READY_WITH_NONBLOCKING_EVIDENCE_GAP
P0_SEARCH_DEFECT=NONE
RC02_STATUS=REFINED
BROKER_PRIMARY_OWNER_RU=/ru/makler-v-tallinne/
MAKLER_FAMILY_CURRENT_OWNER=/ru/makler-v-tallinne/ (weakened; /ru/ title competitor; exact share PENDING)
RIELTOR_FAMILY_CURRENT_OWNER=/ru/makler-v-tallinne/ (71% share; root / supporting, benign)
RIELTOR_YO_FAMILY_CURRENT_OWNER=/ru/makler-v-tallinne/ (67% share; root / supporting; query-mix softening)
ROOT_HOMEPAGE_CONFLICT=BENIGN_SUPPORTING (x-default/entity; zero RU text; no removable signal)
RU_HOMEPAGE_CONFLICT=PROBABLE_CANNIBALIZATION (MAKLER; <title> only)
RU_TALLINN_HUB_CONFLICT=POSSIBLE_SECONDARY (trailing "Маклер по районам"; Batch 1B candidate)
AGENTSTVO_CONFLICT=NO_MATERIAL_CONFLICT
ET_BROKER_MECHANISM=DIFFERENT_FROM_RU
EXACT_RU_HOMEPAGE_GSC_EVIDENCE=PENDING (NONBLOCKING; required as pre-deploy baseline)
BATCH_1_TARGET_URL=https://cityee.ee/ru/
BATCH_1_CHANGE_TYPE=TITLE_ONLY (config/cityee.php:585 meta_title)
BATCH_1_CHANGE_BUDGET=1 URL / 1 field / 1 line
BATCH_1_CONFIDENCE=MEDIUM
OWNER_EVIDENCE_BLOCKING=NO
IMPLEMENTATION_READY=YES
IMPLEMENTATION_EXECUTED=NO
PRODUCTION_CHANGED=NO
DEPLOY_EXECUTED=NO
WAITING_FOR_OWNER_APPROVAL_FOR_BATCH_1=YES
```
