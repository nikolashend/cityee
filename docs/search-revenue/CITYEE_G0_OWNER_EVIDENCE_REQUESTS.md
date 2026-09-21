# G0 — OWNER EVIDENCE REQUESTS (all NONBLOCKING for architecture preparation)

Policy: no broad screenshot requests. Everything below is **batched into the pulls already scheduled**
(Batch 1A T+14 ≈ 2026-10-01 → extract a few days later for GSC lag; O1 T+14 = 2026-10-04). Nothing here blocks G0.

```
OWNER_EVIDENCE_REQUEST_ID: G0-01
SYSTEM: Google Search Console
EXACT_PATH: Performance → Search results → Compare last 3 months vs previous 3 months → Country = Estonia → Search type = Web
DATE_RANGE: at the Batch 1A T+14 pull (≈2026-10-03..05)
FILTER: Query contains "продать квартиру"  (then Pages tab)  — EXACT pages: /ru/prodat-kvartiru-v-tallinne/ and /ru/kinnisvara-muuk/ (Queries tab, one export each)
DIMENSION: Pages; Queries
METRIC: clicks, impressions, CTR, position (both periods)
WHAT_TO_SCREENSHOT_OR_EXPORT: export CSV/XLSX (contains Filters sheet)
WHY_NEEDED: quantify the RU sell-cluster overlap (prodat winner vs /ru/kinnisvara-muuk/ retitled in a3ea5c0) — same mechanism class as MAKLER
DECISION_IT_UNBLOCKS: W1-2 (de-conflict /ru/kinnisvara-muuk/ title) after the Batch 1A gate
BLOCKING=NO
```
```
OWNER_EVIDENCE_REQUEST_ID: G0-02
SYSTEM: Google Search Console
EXACT_PATH: same as G0-01
DATE_RANGE: same pull
FILTER: Query contains "maakler" ; Query contains "müük" ; Query contains "hind" (three separate exports, not summed) → Pages tab; plus EXACT page / (root) and /kinnisvara-muuk/ and /kinnisvara-hinnaanaluus-tallinn/ → Queries tab
DIMENSION: Pages; Queries; Devices
METRIC: clicks, impressions, CTR, position
WHAT_TO_SCREENSHOT_OR_EXPORT: export CSV/XLSX
WHY_NEEDED: first ET seller ownership picture (broker → root?, sell → root vs /kinnisvara-muuk/, valuation page visibility) — replaces OBSERVED_GSC=NO in the ET gap matrix
DECISION_IT_UNBLOCKS: W2-2 (ET sell de-confliction), W6-2 (ET broker decision), priority of W3-1
BLOCKING=NO
```
```
OWNER_EVIDENCE_REQUEST_ID: G0-03
SYSTEM: Google Search Console + Google Ads search terms
EXACT_PATH: GSC Performance → Query contains "дом" / "maja" / "kinnistu" / "ärikinnisvara" (Pages + Queries); Ads → Search terms (all campaigns, last 90 days) filtered the same way
DATE_RANGE: last 3 months (GSC); last 90 days (Ads)
FILTER: as above
DIMENSION: Queries; Pages; search term
METRIC: impressions, clicks, position / clicks, cost, conversions
WHAT_TO_SCREENSHOT_OR_EXPORT: export
WHY_NEEDED: property-type demand (house/land/commercial) — the only evidence that can pass G0-LP-02 for the house-sale LP
DECISION_IT_UNBLOCKS: W4-1 gate (house-sale owner page)
BLOCKING=NO
```
```
OWNER_EVIDENCE_REQUEST_ID: G0-04
SYSTEM: Google Search Console
EXACT_PATH: Performance → Page EXACT https://cityee.ee/ru/tallinn/kristiine/ → Queries
DATE_RANGE: last 3 months
FILTER: exact page
DIMENSION: Queries
METRIC: impressions, clicks, CTR, position
WHAT_TO_SCREENSHOT_OR_EXPORT: export
WHY_NEEDED: 751 impressions / 0 clicks on a seller-district page — classify buyer vs seller vs informational before any district CRO
DECISION_IT_UNBLOCKS: W3-2 design (district CTA) and P2 geo stream
BLOCKING=NO
```
Already scheduled (not new): Batch 1A T+14/T+21 (маклер families, /ru/, makler, tallinn) and O1 T+14 (Ads search terms/keywords/
clicks/spend/CPC/conversions; GA4 Ocenka sessions + generate_lead; lead-quality status).
