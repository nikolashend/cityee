# CITYEE — Search Owner Evidence Requests (GSC)

Minimal, batched (§43/§44). Named `..._SEARCH_...` to avoid overwriting the attribution-phase
`CITYEE_OWNER_EVIDENCE_REQUESTS.md`. Claude has exhausted repo/git/production evidence first; these
GSC exports elevate the STRONGLY_SUPPORTED hypotheses to PROVEN. **One export (#1) answers most.**

---

## OWNER_EVIDENCE_REQUEST #1 — broker cluster Query→Page (the decisive one)
```
SYSTEM:  Google Search Console
PATH:    Performance → Search results
FILTER:  Query contains "маклер"  (add a second run: Query contains "риелтор")
DIMENSION: Pages  (then also Queries)
PERIOD:  Window A — last 3 months vs previous 3 months (Compare)
COUNTRY: Estonia
METRICS: Clicks, Impressions, CTR, Position
OUTPUT:  export CSV/XLSX (both the Pages table and the Queries table)
WHY:     prove WHICH URL now receives "маклер"/broker impressions. If /ru/ or /ru/tallinn/ now
         appears alongside/above /ru/makler-v-tallinne/, cannibalization (RC-02) is PROVEN.
DO NOT CHANGE: nothing — read-only export.
```

## OWNER_EVIDENCE_REQUEST #2 — /ru/ NEW_QUERY_SET (homepage expansion)
```
SYSTEM:  GSC → Performance
FILTER:  Page = https://cityee.ee/ru/
DIMENSION: Queries
PERIOD:  Window A (3M vs previous 3M, Compare)
METRICS: Clicks, Impressions, CTR, Position
OUTPUT:  CSV
WHY:     classify the queries that drove /ru/ impressions +102% (538→1088) as seller/generic/
         buyer/rental/brand/noise → HEALTHY_EXPANSION vs INTENT_DILUTION vs HOMEPAGE_FALLBACK.
DO NOT CHANGE: nothing.
```

## OWNER_EVIDENCE_REQUEST #3 — CTR regression pairs (position-stable, CTR-down)
```
SYSTEM:  GSC → Performance
DIMENSION: Queries + Pages
PERIOD:  Window A + Window B (28d)
DEVICE:  export Mobile and Desktop separately
METRICS: Clicks, Impressions, CTR, Position
OUTPUT:  CSV
WHY:     isolate query/URL pairs where Position stable/up but CTR down (RC-03) from true ranking
         loss (RC-01/02). Feeds CTR_REGRESSION_CANDIDATES. Mobile split tests §9/§53.
DO NOT CHANGE: nothing.
```

## OWNER_EVIDENCE_REQUEST #4 (optional) — index coverage buckets
```
SYSTEM:  GSC → Pages (Index coverage)
OUTPUT:  screenshot/export of the excluded categories (redirected / crawled-not-indexed / 4xx / 5xx / robots)
WHY:     confirm no exclusion touches the 8 protected winners or their resources. Winners already
         verified 200/indexable via PROD_HTTP; this only closes the site-wide question.
DO NOT CHANGE: nothing — do NOT mass-submit URLs for indexing.
```

---

### After the export returns
Paste it back into this task with header `OWNER EVIDENCE — GSC`. Claude will: (a) fill the Query→URL
current_owner columns in `CITYEE_QUERY_OWNERSHIP_REGISTRY.csv`; (b) elevate/adjust confidence in the
root-cause map; (c) confirm or reject the cannibalization thesis; (d) finalize the recovery order.
No production/SEO change happens until that plan is approved and change-budgeted.
