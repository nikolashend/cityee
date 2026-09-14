# ROOT CAUSE CAUSALITY MATRIX — broker cluster (0 unsupported · 1 weak · 2 moderate · 3 strong)

| cause | temporal | query | URL | directional | control-group | technical | alt-explanation | **total /21** | status |
|---|---|---|---|---|---|---|---|---|---|
| **RC-02 broker ownership fragmentation (MAKLER via `/ru/` title)** | 3 (03-09 specialist, 03-11 homepage title) | 3 (exact phrase "Маклер в Таллинне" in `/ru/` title; family flat demand) | 3 (non-owner carries head term; owner is registry primary) | 3 (impr flat, pos down = rank loss on same demand) | 3 (ocenka: no competitor → stable) | 2 (no defect needed; semantic) | 2 (query-mix rejected for MAKLER because impr flat) | **19** | **PROBABLE — selected** |
| RC-04 CTR/snippet regression | 1 | 2 (CTR 5.95→1.56 on "маклер таллинн") | 2 | 1 (CTR fell *with* position, so position-driven) | 1 | 0 | 1 | 8 | PARTIAL (secondary effect of rank loss) |
| RC-03 demand decline | 0 (impr flat for "маклер") | 0 | 0 | 0 | 1 | 0 | 0 | 1 | REJECTED for MAKLER |
| RC-08 language/hreflang ambiguity (root `/` gets RU broker impr) | 1 | 2 (RIELTOR/YO on root) | 2 (x-default → root) | 1 (root held, didn't rise) | 1 | 1 (config is legitimate, not a defect) | 1 | 9 | BENIGN — explains root's supporting visibility, not the loss |
| RC-05 internal authority dilution | 1 | 0 | 1 (makler is the most-linked winner, 12 refs) | 0 | 1 | 0 | 0 | 3 | REJECTED |
| RC-01 technical indexing regression | 0 | 0 | 0 (all winners 200/self-canonical/indexable) | 0 | 0 | 0 | 0 | 0 | REJECTED |
| RC-06 content quality regression | 0 (no body change evidenced on specialist since creation) | 1 | 1 | 1 | 1 | 0 | 1 | 5 | WEAK / INSUFFICIENT |
| RC-07 geo architecture ambiguity (`/ru/tallinn/` "Маклер по районам") | 2 | 2 | 2 | 1 | 1 | 0 | 1 | 9 | POSSIBLE secondary (Batch 1B candidate); separate P2 for kristiine |
| RC-09 SERP composition change | 0 (no external evidence) | 1 | 0 | 1 | 1 | 0 | 1 | 4 | EXTERNAL_SERP_EVIDENCE_REQUIRED |
| RC-10 measurement artifact | 1 (approx. owner figures; /ru/ export is URL_CONTAINS) | 1 | 1 | 0 | 0 | 0 | 2 (partially: avg-position + query-mix explains RIELTOR/YO softening) | 5 | PARTIAL — explains RIELTOR/YO, **not** MAKLER (impr flat) |

**Reading:** RC-02 (MAKLER via the `/ru/` title) dominates; RC-10/query-mix explains the RIELTOR /
RIELTOR_YO position softening; root `/` is benign supporting visibility (RC-08 benign). No cause
reaches PROVEN at CSV precedence because the exact `/ru/` page export is absent — hence PROBABLE.
