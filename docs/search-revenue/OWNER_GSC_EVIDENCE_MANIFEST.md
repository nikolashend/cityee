# OWNER GSC EVIDENCE MANIFEST (2026-09-14)

**Discovery result:** no CityEE GSC export files (`Filters.csv` / `Queries.csv` / `Pages.csv` /
`.xlsx`) exist in the repository or the user's Downloads/Desktop/Documents. The only "Performance on
Search" XLSX files found are for **adme.ee** (different property, adme staging folder) → **EXCLUDED**
(wrong property; using them would be fabrication). The "new owner evidence" therefore exists only as
the **owner-stated approximate figures inline in the task (§6–§8)**. Precedence (§59): these rank at
screenshot/statement level, **below** validated CSV — every claim built on them is capped at
`OWNER_STATED` / MEDIUM confidence, never "PROVEN" at CSV precedence.

| evidence_id | source | period | comparison | country | search_type | page_filter | query_filter | filter_class | dims | usable_for | limitations / overlap |
|---|---|---|---|---|---|---|---|---|---|---|---|
| E-01 | owner-stated (task §7) | last 3M | prev 3M | Estonia | Web | none | none | **SITEWIDE** | totals | site trend | approximate; overlaps all others (same population) |
| E-02 | owner-stated (task §6.1) | last 3M | prev 3M | Estonia | Web | none | family "риелтор" | **QUERY_CONTAINS** (assumed; Filters.csv absent) | Pages | RIELTOR ownership | approximate; exact operator unknown → cannot be used for CSV-level share math |
| E-03 | owner-stated (task §6.2) | last 3M | prev 3M | Estonia | Web | none | family "риэлтор" | **QUERY_CONTAINS** (assumed) | Pages | RIELTOR_YO ownership | as above; overlaps E-02 only if operator is "contains" on a shared stem — treat as separate views, do NOT sum |
| E-04 | owner-stated (prior task §3.2, 2026-09-12) | last 3M | prev 3M | Estonia | Web | `/ru/makler-v-tallinne/` (exact, per prior owner report) | — | EXACT_URL (owner-reported) | Queries | MAKLER loss | approximate; rows for "маклер таллинн", "маклер" |
| E-05 | owner-stated (task §5/§8/§58) | last 3M | prev 3M | Estonia | Web | `+https://cityee.ee/ru/` | — | **URL_CONTAINS / RU_SUBTREE** | Pages/Queries | subtree context only | **NOT exact /ru/ homepage evidence** — rows must not be attributed to `/ru/` |
| E-06 | owner-stated (task §8) | last 3M | prev 3M | Estonia | Web | `/ru/tallinn/` subtree | — | URL_CONTAINS / SUBTREE | Pages | geo cluster (P2) | includes `/ru/tallinn/kristiine/` (751 impr, 0 clicks) — separate P2 stream |
| E-07 | owner-stated (prior task §3.5) | last 3M | prev 3M | Estonia | Web | `/` | brand "cityee" | EXACT_URL + QUERY | Queries | brand control | approximate |
| E-08 | adme.ee XLSX in Downloads (2026-09-12) | — | — | — | — | — | — | **WRONG_PROPERTY** | — | **EXCLUDED** | not CityEE |

**Overlap rule (§60):** E-01…E-07 are views of ONE GSC population (Estonia, Web, same windows) — never
summed. **Exact `/ru/` homepage evidence: ABSENT → `OWNER_EVIDENCE_PENDING`** (§58).
