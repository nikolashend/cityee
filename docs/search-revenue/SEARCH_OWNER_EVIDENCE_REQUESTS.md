# SEARCH OWNER EVIDENCE REQUESTS — remaining (2026-09-14)

Batched and minimal. **Requests #1–#3 are the PRE-DEPLOY BASELINE for Batch 1A** (§64); #1 also
closes the exact `/ru/` gap (§38). Everything else already exhausted from repo/git/production.
Return the files to this same task with header `OWNER EVIDENCE — GSC`. **Export the CSV/XLSX
(includes Filters.csv) — not screenshots** (§59).

## OWNER_EVIDENCE_REQUEST_RU_HOMEPAGE_EXACT  (#1 — closes the §38 gap)
```
SYSTEM:     Google Search Console
PATH:       Performance → Search results → Compare: last 3 months vs previous 3 months
            → Country = Estonia → Search type = Web
            → Page filter → EXACT URL → https://cityee.ee/ru/
            → Queries tab → Export (CSV/XLSX)
URL:        https://cityee.ee/ru/   (EXACT)
DIMENSION:  Queries (also export Devices)
METRICS:    Clicks, Impressions, CTR, Position (both periods)
OUTPUT:     export (must contain Filters.csv showing "Page: EXACT https://cityee.ee/ru/")
WHY:        confirm whether /ru/ itself captures "маклер / маклер таллинн / маклер в таллинне"
            impressions (MAKLER family share for the competing URL) — the only piece missing to
            move RC-02 (MAKLER) from PROBABLE to PROVEN, and the Batch 1A baseline for /ru/.
⚠ DO NOT USE "URL CONTAINS" (+https://cityee.ee/ru/) — that returns the whole RU subtree.
DO NOT CHANGE: nothing (read-only export).
```

## #2 — intended owner exact baseline
```
Same path; Page = EXACT https://cityee.ee/ru/makler-v-tallinne/ → Queries + Devices → Export.
WHY: frozen baseline for the specialist (clicks/impr/CTR/pos per broker query) before Batch 1A.
```

## #3 — broker family denominators (share math, §61)
```
Same path; no page filter; Query filter = contains "маклер" → Pages tab → Export.
Repeat separately: Query contains "риелтор"; Query contains "риэлтор". (three exports, not summed)
WHY: URL_IMPRESSION_SHARE per family, current vs previous → OWNER_SHARE_DELTA; also detects any
     other CityEE URL receiving broker impressions (agentstvo, tallinn, root).
```

## #4 — control + brand (light)
```
Page = EXACT https://cityee.ee/ru/ocenka-kvartiry-v-tallinne/ → Queries → Export (control freeze).
Query = "cityee" → Pages → Export (brand guard for /ru/ and /).
```

## #5 — P2 geo stream (separate; NOT needed for Batch 1A)
```
Page = EXACT https://cityee.ee/ru/tallinn/kristiine/ → Queries → Export.
WHY: which queries generate 751 impressions with 0 clicks (buyer/informational vs seller) before any change.
```

## Classification of the remaining gap
- `EXACT_RU_HOMEPAGE_GSC_EVIDENCE = PENDING` → **NONBLOCKING** for plan readiness (collision is
  directly observable in production/repo/git; change is reversible on the non-owner), **REQUIRED**
  as the pre-deploy baseline (precondition step of the sequence). Deploying without #1–#3 would
  leave the post-change evaluation without a per-URL baseline — so the implementation task must start
  with these exports.
