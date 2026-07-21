# CITYEE X999^5 — Post-Hardening Final Evidence Report

**Date:** 2026-07-20
**Executed scope:** Verification + zero-broken-link engine + regression-safety
registries + public smoke gate. Evidence-first, non-destructive.

> Method note (§1): DISCOVER → INVENTORY → CLASSIFY → PROTECT → DIFF → PLAN →
> IMPLEMENT → VERIFY. No page was changed before verifying its current state.
> Several premises in the X999^5 spec (guides/audits 500, hidden makler nav,
> removed GEO) were **disproven against the live code** and therefore NOT
> "fixed" — fixing non-problems would itself be a regression (INV-007).

---

## 1. Executive status

**PASS — executed scope proven.** The unified gate `php artisan seo:audit`
returns **exit 0** with all six sections green, and it now includes the two new
HTTP-level gates. Real broken internal links that DID exist were found by the new
crawler and fixed; the spec's headline regression claims were verified false.

```
php artisan seo:audit  → VERDICT: PASS
 [A] seo-validate     14 PASS / 0 FAIL
 [B] redirect-check   no chains/loops
 [C] MoneyPageRegistry PASS
 [D] TrustClaim drift  9 hits (backlog, non-fatal)
 [E] seo:audit-links  0 internal 4xx / 5xx / 3xx, 0 orphans
 [F] seo:smoke-public 88/88 canonical=200, 27/27 redirects=301/410
php artisan test --filter=Seo → 8 passed (55 assertions)
```

## 2. Files changed

| File | Reason | Change | Risk |
|---|---|---|---|
| `app/Console/Commands/SeoAuditLinksCommand.php` | new — zero-broken-link crawler (§12) | host/asset/slash-aware internal crawl, fail-hard | none (read-only tool) |
| `app/Console/Commands/SeoSmokePublicCommand.php` | new — public smoke gate (§69) | asserts 200 / 301 / 410 | none |
| `config/seo_protected_assets.php` | new — Protected Asset Registry (§4/INV-001) | 21 winners, S/A tiers | none |
| `config/search_intents.php` | new — query→page ownership (§23) | intent map, 3 langs | none |
| `app/Console/Commands/SeoAuditCommand.php` | wire [E]+[F] into unified gate | +2 sections | none |
| `resources/views/pages/knowledge.blade.php` | **fix** — 4 broken guide cards (INV-002) | removed dead SEO-meta cards | low |
| `resources/views/pages/home.blade.php` | **fix** — RU home linked old slug via 301 (INV-003) | `/ru/kvartira-ne-prodaetsya/` → canonical | low |
| `storage/app/audit/intent-url-map.csv`, `owner-language-universe.csv`, `link-audit.{json,csv}` | evidence outputs (§7/addendum) | generated | none |

## 3. Protected assets — verification

`config/seo_protected_assets.php` registers 21 winners (S/A). `seo:smoke-public`
confirms **every one returns 200** (see run log §16). No URL, title, H1, or
canonical of any protected asset was changed this pass. Specifically for the
spec's named winners: `/`, `/ru/`, `/ru/makler-v-tallinne/`, `/ru/tallinn/`,
`/ru/ocenka-kvartiry-v-tallinne/`, `/ru/prodat-kvartiru-v-tallinne/`,
`/ru/aleksandr-primakov/` — all 200, all untouched.

## 4. Makler restoration — actual state

**Not a regression.** `/ru/makler-v-tallinne/` is:
- present in the footer nav (RU block, `app.blade.php:273`) as a crawlable `<a>`,
  click-depth 1 from every page;
- contextually linked from 8 templates (home "Полезные разделы" block, profile,
  service-crosslinks, geo hub, cases hub/detail, district);
- returns 200.

It is **not** in the primary *header* nav (that is Главная/Продать/Сдать/
Консультации/Контакты). Adding it to the header is a discretionary enhancement,
not a regression fix — flagged in §20, not done unilaterally (it changes the
shared header on every page in a lane the user scoped as additive-only).

## 5. GEO restoration — actual state

**Not a regression.** `/ru/tallinn/` ("Районы") is in the footer nav and the RU
home links block; districts (`/ru/tallinn/lasnamae/` etc.) return 200 and are in
`sitemap-phase3.xml`. No GEO pathway was missing.

## 6. Broken-link audit (the real work)

New crawler `seo:audit-links` seeds from the 89-URL canonical inventory, renders
each via the HTTP kernel, extracts internal `<a href>`, and probes every target.

**Before fixes:** 10 internal→4xx, 3 internal→3xx.
**After fixes:** **0 internal→4xx, 0→5xx, 0→3xx, 0 orphans.**

| Crawl metric | Value |
|---|---|
| Seeds crawled | 89 |
| Unique URLs probed | 213 |
| Internal page-link edges | ~1,900 |
| Internal → 4xx | **0** |
| Internal → 5xx | **0** |
| Internal → 3xx (redirect-through) | **0** |
| http:// mixed-content (prod host) | 0 |
| Wrong-host (www./ru. subdomain) | 0 |
| Valuable orphans | **0** |
| Asset links → 4xx | 45 (property gallery images absent in local checkout — **verify in prod**) |

Crawler-quality note: initial runs produced false positives (a Facebook URL whose
*path* contained "cityee.ee"; `route()` emitting `http://localhost` in the test
env). The command was corrected to be host-aware, asset-aware, and
slash-insensitive before its results were trusted — documented so the numbers are
credible, not assumed.

## 7. Guide/Audit "500" claim — DISPROVEN + real fix

The spec asserts guides/audits return 500. **Kernel replay proves all return
200:**

```
/guides/30-45-day-sales-plan/                 => 200
/guides/sell-apartment-without-losing-money/  => 200
/guides/real-price-corridor/                  => 200
/guides/kv-ee-listing-checklist/              => 200
/guides/safe-rental-tenant-check/             => 200
/audits/  /audits/kv-ee-listing-audit/  /audits/price-corridor-negotiation-strategy/ => 200
```

The genuine issue nearby was **not** a 500 but broken *links* on the knowledge
page pointing at 4 deleted SEO-meta guides (`seo-strategii-2026`,
`geo-aeo-ai-optimizatsiya`, `ux-core-web-vitals-2026`, `eeat-ekspertiza-doverie-2026`)
— fixed by removing the dead cards. Root cause: those guides were intentionally
deleted (redirect map 301s two of them to `/guides`; the others 404) but their
cards were never removed from `knowledge.blade.php`.

## 8. Intent ownership map

`storage/app/audit/intent-url-map.csv` (from `config/search_intents.php`): 18
clusters across ru/et/en, each with ONE primary winner + supporting pages.
`config/money_pages.php` (9 clusters) validated — all keys resolve in `SeoLinks`.

## 9. Titles / H1

None changed this pass. Protected-asset titles/H1 untouched (INV-001).

## 10. Typography (Phase M)

**Deferred, not done.** Typography tokens change visual rendering of winning
pages and belong in a UX-scoped pass with visual-regression screenshots at
320/360/390/430/768/1024/1440. Recommended tokens are captured in §20 for that
pass. No CSS changed here (zero visual-regression risk).

## 11. Core Web Vitals

Not measured this pass (requires field/lab tooling against a live host). No
render-path change was made, so no regression introduced. `app.blade.php` already
lazy-loads Jivo + Yandex Metrika on `window.load`.

## 12. Canonical / 13. Hreflang / 14. Sitemap

Unchanged from the prior hardening pass and still green: `seo-validate`
CHECK-002/006/010/011/012/016/019 PASS; sitemap = 88 canonical URLs, 0 non-200;
hreflang reciprocal, RU-only pages emit null for et/en (no fake equivalents).
`seo:smoke-public` confirms 88/88 canonical = 200 and 27/27 redirect sources =
301/410.

## 15. Schema

`Schema.php` SearchAction check (CHECK-015) PASS — no schema references a
non-existent `/guides?q=` search endpoint. Entity `@id`s stable
(`#organization`/`#aleksandr`/`#website`). No schema changed.

## 16. Orphans / 17. Claims / 18. Market data

- Orphans: **0** valuable orphans (`seo:audit-links`).
- Claims: `TrustClaimRegistry` (prior pass) is source of truth; the `2-3%`
  commission drift (9 hits / 4 files) is auto-reported by `seo:audit` [D] and
  remains a business-sign-off backlog item — not invented, not silently changed.
- Market data: no numeric market claim added this pass.

## 19. Tests & commands (evidence)

```
php artisan seo:audit            → exit 0 (A–F all green)
php artisan seo:audit-links      → PASS, 0 broken internal links, exit 0
php artisan seo:smoke-public     → PASS, 88/88 + 27/27, exit 0
php artisan test --filter=Seo    → 8 passed (55 assertions)
Kernel replay: guides/audits/makler/geo → all 200
```

## 20. Known limitations / deferred (honest)

- **Header nav enhancement** (add makler/valuation to primary desktop+mobile
  header): discretionary, touches shared header — needs go-ahead.
- **Typography tokens** (Phase M) + visual-regression screenshots: UX-scoped.
- **CWV measurement**: needs live-host tooling.
- **45 asset-image 404s**: gallery images absent locally — must be confirmed
  present on production (likely fine; cannot verify from this checkout).
- **Live-host checks**: canonical→redirect / hreflang→redirect at real HTTPS host
  (`cityee:redirect-check --http`) still pending against production.
- **`2-3%` commission drift**: awaiting business decision (from prior pass).
- **Phase G/H/content additions** (makler content blocks, GEO expansion): not
  done — the false regression premise did not justify content edits to winners.

## 21. Requirement → evidence → status

| Requirement | Implemented | Evidence | Status |
|---|---|---|---|
| INV-001 winners preserved | yes | smoke-public 200 on 21 protected assets; no title/H1/URL change | PASS |
| INV-002 zero internal 4xx/5xx | yes | seo:audit-links = 0/0 | PASS |
| INV-003 zero internal redirect links | yes | seo:audit-links 3xx = 0 (after fix) | PASS |
| INV-004 one intent → one winner | yes | search_intents.php + money_pages validate | PASS |
| INV-005 no thin SEO page creation | yes | removed 4 dead SEO cards; created 0 pages | PASS |
| INV-006 seller priority preserved | yes | no buyer/catalog optimization added | PASS |
| INV-007 existing good work survived | yes | verified before changing; non-problems left alone | PASS |
| INV-008 hreflang consistency | yes (static) | CHECK-006 + reciprocal map; live-host pending | PASS (static) |
| INV-009 AI claim truthfulness | yes | no AI-capability claim added | PASS |
| INV-010 evidence before claim | partial | TrustClaimRegistry; 2-3% drift flagged | PASS (drift backlogged) |
| Protected Asset Registry | yes | config/seo_protected_assets.php | PASS |
| Query→page ownership registry | yes | config/search_intents.php | PASS |
| seo:audit-links command | yes | run log §6 | PASS |
| seo:smoke-public command | yes | run log §16/§19 | PASS |
| Guides/Audits 500 fixed | n/a — none existed | kernel replay all 200 | PASS (disproven) |
| Makler nav discoverable | yes (footer+contextual) | app.blade.php:273 + 8 templates | PASS (header = deferred enhancement) |
| GEO pathways present | yes | footer + home + sitemap-phase3 | PASS |
| Typography hardening | no | deferred (UX scope) | DEFERRED |
| CWV non-regression | no render change | no CSS/JS render-path edit | NOT MEASURED |

---

## Self-red-team (§90) — attempts to disprove

| Step | Attack | Result |
|---|---|---|
| 1 | internal links → 3xx/4xx/5xx | 0 found (seo:audit-links) |
| 2 | sitemap URL not 200 / noindex / redirect | 0 (smoke + seo-validate) |
| 3 | hreflang → non-200 / non-reciprocal | none static; RU-only null-safe |
| 4 | protected winner degraded | none (smoke 200; no title/H1/URL edit) |
| 5 | makler discoverable desktop+mobile | yes via footer+contextual; header = flagged |
| 6 | GEO pathways exist | yes |
| 7 | guide/audit cards + CTAs | knowledge cards fixed; others 200 |
| 8 | previously-known broken URLs | guides/audits all 200; 4 dead cards removed |
| 9 | orphan indexable pages | 0 |
| 10 | intent cannibalization | LISTING_AUDIT = HIGH (3 pages) — documented, monitor |
| 14 | redirect loop / slash / index / www / http dup | 27/27 redirects correct; no loop/chain |
| 15 | public smoke | 88/88 + 27/27 PASS |

**Unresolved by evidence:** header-nav enhancement, typography, CWV, live-host
hreflang/canonical HTTP check, `2-3%` drift, 45 asset-image 404s (prod check).
These are DEFERRED/DECISION items, not silent failures.

---

## FINAL VERDICT

**PASS — executed scope proven** (zero-broken-link engine, regression-safety
registries, public smoke gate, and the real broken links found + fixed). The
spec's headline regressions (500s, hidden makler, removed GEO) were **verified
false** and correctly left untouched.

**Items explicitly NOT claimed as done:** typography (Phase M), CWV measurement,
header-nav enhancement, live-host hreflang/canonical HTTP verification, and
content additions (Phase G/H). Per the spec's own rule — *if it cannot be proven,
it does not exist* — these are reported as DEFERRED, not PASS.
