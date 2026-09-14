# BROKER QUERY FAMILY ANALYSIS — RC-02 re-test with new owner evidence

**Verdict: RC-02 = REFINED.** Not "`/ru/` cannibalizes makler" wholesale. Broker ownership is
**fragmented by lexical family**, and only ONE family shows a true ranking-loss signature:

| family | intended owner | current dominant | supporting | signature (owner-stated) | classification | mechanism |
|---|---|---|---|---|---|---|
| **MAKLER** (маклер, маклер таллинн, маклер в таллинне…) | `/ru/makler-v-tallinne/` | specialist still owns rows, weakened | `/ru/` (title claims exact head term), `/ru/tallinn/` ("Маклер по районам"), agentstvo (broad) | "маклер" impr **106→106**, pos **7.75→10.69**; "маклер таллинн" 84→64, 7.63→10.66, CTR 5.95→1.56 | **PROBABLE_CANNIBALIZATION** | demand flat + rank down ⇒ not RC-03 demand, not query-mix. Exact-phrase competitor on `/ru/` `<title>` (added `a3ea5c0`, same week as specialist). |
| **RIELTOR** (риелтор) | `/ru/makler-v-tallinne/` | specialist (119 impr, 2.4× root) | root `/` (49 impr, pos 6.45→7.73) | specialist impr **86→119 (+38%)**, pos 5.69→7.28 | **BENIGN_MULTI_URL_VISIBILITY** | impressions grew on both; avg-position softening consistent with query-universe expansion (§4 principle). Root has **zero RU text** — its visibility is x-default/entity authority, not a removable signal. |
| **RIELTOR_YO** (риэлтор) | `/ru/makler-v-tallinne/` | specialist (80 impr) | root `/` (40 impr, held ~pos 6) | specialist impr **65→80 (+23%)**, pos **4.94→9.12 (−4.2)**; root ~6→~6 | **POSSIBLE_CANNIBALIZATION** (query-mix confounded) | root did **not** rise (it held), so this is not displacement by root; the specialist's avg fell while gaining impressions ⇒ new lower-ranked "риэлтор" variants entered. Needs query-level rows. Not a Batch 1 target. |
| AGENCY (агентство…) | `/ru/agentstvo…/` | pending | — | no rows supplied | NO_CONFLICT (distinct intent) | agentstvo is not a material broker competitor on evidence; do not modify. |

## Why the example mechanism in §17 is only PARTLY true
- "`/ru/` competes for MAKLER" — **supported** (title-level exact phrase + timeline + flat-demand rank loss).
- "root `/` competes for RIELTOR variants" — **rejected as harmful**: root is a benign supporting result
  (x-default, no RU text, held position). Its presence does not displace the specialist; the
  RIELTOR/RIELTOR_YO deltas are query-mix expansion, not ownership loss.

## URL_IMPRESSION_SHARE (§61) — computed only where owner-stated rows allow
- RIELTOR family (rows: specialist + root; "other URLs much smaller"): specialist share ≈ 119/(119+49)
  = **71%** now vs 86/(86+33) = **72%** prev → OWNER_SHARE_DELTA ≈ **−1pp** (stable). Benign.
- RIELTOR_YO: specialist ≈ 80/(80+40) = **67%** now vs 65/(65+26) = **71%** prev → ≈ **−4pp**. Mild.
- MAKLER: `/ru/` row for "маклер" **not supplied at exact-page precedence** (only RU-subtree
  `URL_CONTAINS`) → share **cannot be computed honestly** → `OWNER_EVIDENCE_PENDING` (request #1).
*(Shares use only the two supplied URLs per family; a full denominator needs the Pages export.)*

## Seller-intent filter + SEARCH_REVENUE_OPPORTUNITY_PROXY (not revenue)
| family | seller_intent | geo | hist_pos advantage | recoverability (pos 4–20) | conflict strength | risk of fix | PROXY rank |
|---|---|---|---|---|---|---|---|
| MAKLER | SELLER_HIGH | Tallinn | yes (7.6→10.7) | high | PROBABLE | low (non-owner title) | **1** |
| RIELTOR_YO | SELLER_HIGH | Tallinn | yes (4.9→9.1) | high | POSSIBLE/query-mix | n/a (no removable signal) | 2 (observe) |
| RIELTOR | SELLER_HIGH | Tallinn | mild (5.7→7.3) | medium | BENIGN | n/a | 3 (observe) |
| GEO `/ru/tallinn/*` (kristiine 751 impr/0 clicks) | UNKNOWN→likely BUYER mix | Tallinn | — | — | intent mismatch | — | **P2 separate stream** |

## Control-group revalidation (§25)
`/ru/ocenka-kvartiry-v-tallinne/`: title/H1 specialist ("Оценка квартиры в Таллине — реальный ценовой
коридор"), **no** homepage/hub title overlap for "оценка", pos 10.02→10.13 stable, assoc. query
18.11→10.55 improving. Difference vs makler: **the absence of a title-level competitor on the
homepage/hub**. One control ≠ proof of causality, but it isolates page-specific ownership collision
from any sitewide effect (brand also stable). Control **holds**.

## Separate P2 backlog (do NOT mix with broker recovery — §28)
`/ru/tallinn/kristiine/` (live 200, title "Продать квартиру в Kristiine — маклер CityEE"): 751 impr /
0 clicks / pos ~7.35 → likely buyer-heavy or informational impressions on a seller-titled page
(intent mismatch) or snippet weakness. **First** obtain its Queries export; no change before that.
