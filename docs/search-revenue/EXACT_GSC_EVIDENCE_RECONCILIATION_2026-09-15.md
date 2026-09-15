# EXACT GSC EVIDENCE RECONCILIATION — 2026-09-15 · Batch 1A GO/HOLD/NO-GO gate

**Mode:** read-only, no deploy. Continues `5634397` → `01162f6`. Supersedes the 09-12/09-14
approximations where exact page-level data now exists (superseded items marked ⟶SUPERSEDED).

## B. Input integrity
- **XLSX files:** NOT located on this machine (Downloads / Desktop / Documents / OneDrive / docs
  searched; only unrelated `activities_export_*.xlsx`; the 09-12 adme folder is gone). ⇒ Level-1
  file-level validation could not be performed.
- **What was validated instead (Level 3 + Level 4):** the attached GSC UI screenshots of the exact
  reports, plus the task's XLSX-derived values. Filter semantics validated from the UI chips: GSC
  prefixes **"+"** for *contains* filters. The RU-subtree view shows `Страница: +https://cityee.e…`
  (17 clicks / 4.28K impr / pos 25.1); the `/ru/` compare view shows `Страница: https://cityee.e…`
  **without "+"** and only 641 impr — a strict subset ⇒ **EXACT `/ru/`**. Specialist chip likewise
  has no "+".
- Datasets: **A** exact `/ru/` (compare, Estonia, Web, 3M vs prev) — VALIDATED; **B** exact
  `/ru/makler-v-tallinne/` — VALIDATED; **C** ocenka exact — values task-stated, screenshot not
  attached (Level 4); **D** agentstvo exact — task-stated (Level 4); tablet-only views (+маклер,
  +риелтор, +риэлтор) — supplementary, negligible volume (1–4 impressions).

## C. Duplicates / exclusions
- `DATASET_DUPLICATES_DETECTED=YES`: two identical screenshots with **Query filter =
  "+cityee.ee/ru/makl…"** (a URL pasted into the *query* filter) → "Нет данных" → **UNUSABLE**,
  counted once, excluded.
- Google Ads *Keywords* screenshot → not GSC; out of scope for this gate.
- RU-subtree view (+contains) → context only (P2 geo stream), **not** homepage evidence.

## D. Exact `/ru/` homepage (Dataset A)
Aggregate: clicks **4 vs 1** (+3 — low-volume, not commercially meaningful growth), impressions
**641 vs 232** (+409, ≈+176%), CTR 0.62% vs 0.43% (+0.19pp), avg position **31.69 vs 23.73**
(+7.96 worse).

Broker footprint (exact rows):

| query | cur clicks | prev | cur impr | prev | cur pos | prev |
|---|---|---|---|---|---|---|
| **маклер** | 2 | 0 | **106** | **0** | 10.69 | — |
| маклер в таллинне | 1 | 0 | 18 | 12 | 19.83 | 19.75 |
| маклер таллинн | 0 | 1 | 34 | 38 | 18.29 | 13.00 |

Also present on `/ru/`: агентство недвижимости, сайты недвижимости в эстонии and generic real-estate
rows (homepage-typical). No material риелтор/риэлтор rows readable on `/ru/` — consistent with 09-14,
where that family's secondary URL is root `/`, not `/ru/`.

## E. Exact specialist `/ru/makler-v-tallinne/` (Dataset B)
Aggregate: clicks **3 vs 3** (0), impressions **418 vs 513** (−95, ≈−18.5%), CTR 0.72% vs 0.58%,
avg position **17.55 vs 10.14** (+7.41 worse).

| query | cur clicks | prev | cur impr | prev | cur pos | prev |
|---|---|---|---|---|---|---|
| **маклер** | **0** | **2** | **0** | **105** | — | (≈7.7) |
| маклер таллинн | 1 | 1 | 40 | 55 | 11.43 | 7.73 |
| маклер в таллинне | 0 | 0 | 16 | 20 | | |
| маклер по недвижимости | 0 | 0 | 14 | 18 | | |
| маклерские услуги | 0 | 0 | 15 | 12 | | |
| маклеры в таллинне отзывы | 1 | 0 | 17 | 6 | | |
| риелтор | 0 | 0 | 96 | 78 | | |
| риэлтор | 0 | 0 | 88 | 46 | | |
| риелторские услуги | 1 | 0 | 4 | 0 | | |

Device: mobile 249→191 impr, pos 7.07→10.42; desktop 263→221, pos 13.00→24.00; tablet 1→6 (ignore).
⇒ deterioration is **cross-device, dominated by desktop**; not mobile-only.

### ★ Decisive exact finding — head-term OWNERSHIP TRANSFER
The head query **"маклер"** (105–106 impressions, the family's largest) **moved from the specialist
to `/ru/`**: specialist prev **105 impr / 2 clicks → current 0 / 0**; `/ru/` prev **0 → current
106 impr / 2 clicks @ pos 10.69**. This is not overlap — Google **re-assigned** the head term to the
non-owner. The 09-12 site-level statement "маклер 106→106, pos 7.75→10.69" ⟶SUPERSEDED: it was two
different pages (prev = specialist @≈7.7; current = `/ru/` @10.69). The specialist's aggregate
collapse (10.14→17.55) is therefore partly **mechanical** (it lost its best, highest-position query)
and partly **real slippage** on the remaining rows (маклер таллинн 7.73→11.43).

## F. Control page correction — `/ru/ocenka-kvartiry-v-tallinne/` (task-stated exact)
Aggregate worsened: clicks 4→2, impr 88→63, pos 10.94→15.32. **But** primary query "оценка
недвижимости таллинн": impr 28→46, pos **16.57→13.07 (improved ≈3.5)**, clicks 2→1.
⇒ `OCENKA_CONTROL_STATUS = MIXED / NOT_CLEAN_STABLE_CONTROL` ⟶SUPERSEDES "stable control".
Page-level average worsened while its primary high-value query improved — page averages alone prove
neither a uniform sitewide regression nor a stationary baseline. It still shows **no ownership
transfer** of its head term (no title competitor), which is the relevant contrast with makler.

## G/H. Broker intent ownership verdict + query-family matrix
`BROKER_PRIMARY_OWNER_RU = /ru/makler-v-tallinne/` (registry tier S, unchanged — verified).

| family | intended | observed owners (exact) | direction | status | action |
|---|---|---|---|---|---|
| A МАКЛЕР | specialist | **`/ru/` now sole owner (106/0)**; specialist 105→0 | transfer | **PROVEN_OWNERSHIP_COLLISION (transfer)** | Batch 1A |
| B МАКЛЕР ТАЛЛИНН | specialist | specialist 55→40 @7.73→11.43; `/ru/` 38→34 @13.0→18.3 | both weaker | PROVEN_OWNERSHIP_COLLISION (shared) | Batch 1A |
| C МАКЛЕР В ТАЛЛИННЕ | specialist | specialist 20→16; `/ru/` 12→18 @19.8 | homepage gaining | PROBABLE_CANNIBALIZATION | Batch 1A |
| D РИЕЛТОР | specialist | specialist 78→96 (growing); secondary = root `/` (09-14) | benign | BENIGN_MULTI_URL_VISIBILITY | none |
| E РИЭЛТОР | specialist | specialist 46→88 (growing); root `/` secondary | benign / query-mix | BENIGN / POSSIBLE | none |
| F AGENCY | agentstvo | agentstvo 181→222 impr, pos 20.1→26.8 (query-mix) | not broker-material | NO_MATERIAL_CONFLICT | none |

Conclusion preserved and sharpened: the problem is **MAKLER-lexical**, not uniform across synonyms.

## I. RC-02 reconciliation (two separate labels)
- `RC02_OWNERSHIP_OVERLAP_STATUS = PROVEN` — exact page data shows `/ru/` owns the head term and
  shares B/C.
- `RC02_CAUSAL_STATUS = STRONGLY_SUPPORTED` (not PROVEN). **For:** the `<title>` is the **only**
  broker signal on `/ru/` (H1 has none; git-verified constant since `a3ea5c0` 2026-03-11, no July/Aug
  change); the transfer landed on exactly the page carrying that title; the control's head term
  stayed with its owner. **Against:** the title existed through the previous window while the
  specialist still owned "маклер" — the transfer happened Jun–Sep with the title unchanged ⇒ the
  title is the persistent **eligibility** signal, not a datable trigger; external SERP shifts are
  invisible in GSC. `CANNIBALIZATION_CAUSAL_CONFIDENCE = MEDIUM_HIGH`.
  `ALL_MAKLER_RANKING_LOSS_CAUSED_BY_CANNIBALIZATION` is **not** claimed.

## J. Alternative root causes
Accepted: RC-02 (transfer). Partial: RC-10 query-mix (explains RIELTOR/YO softening and part of the
specialist's average via the lost head query); RC-04 CTR (secondary to position). Rejected: penalty
(no evidence); P0 technical (all 200 / self-canonical / indexable); authority dilution (most-linked
winner); mobile-only / CWV (desktop is worst). RC-09 external SERP: EXTERNAL_SERP_EVIDENCE_REQUIRED
(not disproven).

## K. Batch 1A title collision review
Current: `Маклер в Таллинне — продажа и аренда недвижимости | CityEE` (`config/cityee.php:585`,
`a3ea5c0`). Proposed: `Продажа и аренда недвижимости в Таллинне и Харьюмаа | CityEE`.
Checks: `/ru/` live H1 already = "Продажа недвижимости в Таллинне и Харьюмаа без потери в цене" ⇒
the proposed title **introduces no new claim** (aligns title↔H1). vs `/ru/prodat…` ("Продать
**квартиру**…"; registry sell owner targets "квартиру") — different noun/scope; vs `/ru/tallinn/`
("Продажа **квартир** в районах…") — distinct; vs agentstvo (head "Агентство недвижимости") —
retained there, absent here. Concern: mild generic overlap on "продажа недвижимости" with
prodat/agentstvo modifiers. `PROPOSED_TITLE_STATUS = ACCEPT_WITH_CONCERN`.
Alternatives (not substituted): (1) `CityEE — недвижимость в Таллинне и Харьюмаа: продажа и аренда`
(brand-led; weakest generic overlap; slightly less natural); (2) `Продажа и аренда недвижимости в
Таллинне | CityEE` (drops Harjumaa — loses geo scope the H1 already carries). The proposed title
remains the smallest semantic correction.

## L. Three options
- **A — WAIT:** maximum safety; but a **proven** head-term transfer to a non-owner persists — the
  cost is ongoing.
- **B — TITLE-ONLY (1 URL / 1 field):** removes the only broker signal on the non-owner; specialist
  untouched; causally clean; reversible. Risk: `/ru/` may lose its 2 "маклер" clicks (acceptable —
  broker intent belongs on the specialist) and Google might pick another non-owner
  (`/ru/tallinn/`) — observable, and the 1B trigger.
- **C — MULTI-SIGNAL:** REJECT / DEFER — destroys observability, breaches the change budget,
  touches protected winners.

## M. Gate G1–G12 → **BATCH_1A_DECISION = GO**
G1 ✓ (exact chip; strict subset of the subtree; XLSX file absent — nonblocking) · G2 ✓ · G3 ✓ PROVEN
(106-impression head term on `/ru/`) · G4 ✓ · G5 ✓ (H1 needs no broker term) · G6 ✓ · G7 ✓ · G8 ✓
(ACCEPT_WITH_CONCERN, H1-aligned) · G9 ✓ (no new head claim) · G10 ✓ · G11 ✓ · G12 ✓ (no further
screenshots needed to decide).
`BATCH_1A_CONFIDENCE = MEDIUM_HIGH` — HIGH withheld because: sole-cause unproven (title constant
while the transfer lagged), volumes tiny (2–4 clicks), XLSX not file-verified, external SERP
unobservable.

## Senior challenge (strongest counterargument)
"The title was constant since March, yet the specialist still owned 'маклер' in Mar–Jun; the
transfer happened later — so removing the title may not return the query." Answer: the title is the
eligibility condition; without it `/ru/` carries no broker signal at all, so the head term must
resolve to a page that does (the specialist keeps full title/H1/anchors). Worst realistic outcome is
a move to `/ru/tallinn/` (trailing phrase) — cleanly detectable and exactly the 1B trigger. Downside
to `/ru/`'s legitimate query set (agency/sites/general) is not tied to the "Маклер" head; brand is
unaffected. Decision stands: **GO**.

## P/Q/R. Baseline · observation · rollback
Baseline = Datasets A + B as captured here (Estonia, Web, 3M vs prev, all devices + mobile/desktop
split for B); families маклер / маклер таллинн / маклер в таллинне / риелтор / риэлтор. **No new
3-month forensic required.** Observation: T0 deploy; T+3–7 indexing/title sanity only; T+14
directional; T+21 primary decision; extend if volume is low. Keep signals: specialist regains
"маклер" (impr > 0, pos ≤ ~11) and MAKLER share; `/ru/` keeps its non-broker set; no new non-owner
takes the head term. Hold: sparse / mixed / recrawl incomplete. Rollback: `/ru/` loses legitimate
commercial visibility without specialist recovery, a worse non-owner appears, or the specialist
worsens after adequate observation — restore **only** `Маклер в Таллинне — продажа и аренда
недвижимости | CityEE`.

## S. Remaining gaps
BLOCKING: none. NONBLOCKING: XLSX files for file-level re-verification; ocenka/agentstvo
screenshots; external SERP composition; ET GSC rows (ET firewall — no action in 1A).
