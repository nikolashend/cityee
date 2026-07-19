# CITYEE X999 — Final Invariant-Driven Hardening Report

**Date:** 2026-07-19
**Scope executed this pass:** *Registries + evidence layer* (user-selected).
Additive hardening only — **no winning pages redesigned, no SEO content created,
no legitimate redirect removed**. Higher-touch work (content, UX, performance,
entity re-modelling) is explicitly deferred and listed in §18.

---

## 1. Executive verdict

**PASS — technical P0 + registry/evidence layer complete for the executed scope.**

- All automated static invariants pass: `php artisan seo:audit` → **0 critical**,
  exit 0. `cityee:seo-validate` → 14 PASS / 0 FAIL / 6 HTTP-skip.
- `cityee:render-check` → **44/44 pages render, 0 failures, no 5xx** (before and
  after this pass — no regression).
- SEO test suite `SeoIndexationTest` → **8 passed, 55 assertions**.
- New registries built and **proven in use**: `TrustClaimRegistry` wired into the
  two shared trust components; `MoneyPageRegistry` validated (all keys resolve).

This is **not** a claim that all ~103 spec sections are done — most of the
content/UX/entity roadmap was out of the executed scope. It is a verdict that the
technical foundation and the four addendum-mandated registries are in place and
green. Remaining items are enumerated honestly in §18.

## 2. Baseline (what existed before this pass)

CityEE is a mature Laravel 12 system with substantial Phase 1–5 SEO work already
shipped:

- **Canonical URL registry** — `App\Support\SeoLinks` (page-key → per-language URL
  map, driving `canonical()`, `hreflang()`, `alternates()`). This already satisfies
  addendum #2 (CanonicalUrlRegistry).
- **Redirect layer** — `config/seo_redirects.php` + 3 middleware
  (`CanonicalRedirects`, `RedirectOldUrls`, `TrailingSlash`—disabled), no chains/loops.
- **Sitemap** — deterministic `SitemapController` with index + 5 active children.
- **Entity graph** — `App\Support\JsonLd` + `Schema` with stable `@id`s
  (`#organization`, `#aleksandr`, `#website`). Satisfies §33 foundation.
- **Audit tooling** — `cityee:seo-validate`, `cityee:redirect-check`,
  `cityee:render-check`, `cityee:audit-urls`, `seo:audit-sitemap`, `seo:audit-urls`.

**Gaps found (this pass closes the additive ones):** no `TrustClaimRegistry`
(addendum #4), no `MoneyPageRegistry` (addendum #3), no single unified fail-hard
`seo:audit` command (§62), and the spec's mandated evidence docs were absent.

## 3. Changed files

**New (additive):**
- `config/trust_claims.php` — TrustClaimRegistry (single source of factual claims).
- `app/Support/TrustClaims.php` — accessor.
- `config/money_pages.php` — MoneyPageRegistry (one intent = one winner).
- `app/Support/MoneyPages.php` — accessor + `validate()` integrity check.
- `app/Console/Commands/SeoAuditCommand.php` — unified `php artisan seo:audit`.
- `docs/final_url_inventory.csv`, `docs/gsc_redirect_classification.csv`,
  `docs/seller_intent_map.csv`, `docs/sitemap_inventory.md`, this report.

**Modified (output-preserving):**
- `resources/views/partials/trust-metrics.blade.php` — numbers now sourced from
  `TrustClaims` (values unchanged: 10+, 300+, 45, 5.0).
- `resources/views/partials/trust-layer.blade.php` — numbers sourced from
  `TrustClaims`. **One intentional normalization:** avg-sale figure now renders as
  the canonical `1–1,5` / `1–1.5` instead of the ad-hoc `1-1.5` (same fact; now
  matches the sell-page FAQ). Commission stays `2%`.
- `config/seo_redirects.php`, `app/Http/Middleware/RedirectOldUrls.php` — comments
  only; runtime behavior identical (see §5 trailing-slash finding for why the
  attempted redirect-target change was reverted).

## 4. What was intentionally NOT changed (anti-break proof)

- No winning page template rewritten. `render-check` is 44/44 both before and after.
- The 9 pre-existing `2-3%` commission occurrences (profile, konsultatsioon tables,
  ai-summary) were **flagged, not silently edited** — changing a published claim
  needs business sign-off (§16 backlog). The registry documents the canonical value.
- `SeoLinks` and the sitemap URL map were left as-is (no risky refactor).
- No legitimate redirect removed; no sitemap URL touched.

## 5. GSC "Page with redirect" remediation — root-cause analysis

The GSC count oscillated (~86 → ~40 → 51), which means prior cleanup worked but the
**source** of re-discovery was never removed. Investigation (kernel-level request
replay, see evidence in §16) found three structural mechanisms:

1. **Dual URL generators.** The per-language URL map is declared twice — in
   `SeoLinks::pageUrls()` and in `SitemapController::buildHreflangMap()`/
   `pagesForLang()`. They agree today, but any future drift re-introduces variants.
   → **Recommendation:** make `SitemapController` consume `SeoLinks` (single source).

2. **Trailing-slash canonical enforced by tag only, not by redirect.** Canonical
   URLs use trailing slashes (`/en/`), but `TrailingSlash` middleware is **disabled**
   (it caused an infinite loop because Symfony strips slashes before matching). Both
   `/en` and `/en/` return **200** (verified), consolidated only by `<link rel=canonical>`.
   Crucially, **Laravel's `redirect()`/`url()` strip trailing slashes** — so
   `redirect('/en/')` still emits a `/en` `Location`. This is why non-slash variants
   (`/kontaktid`, `/ru/knowledge`, …) keep resurfacing in GSC. It is *benign*
   (canonical consolidates, nothing 404s) but it is the churn mechanism.
   → An attempted fix (point `/en/index` redirect at `/en/`) was **verified to be a
   no-op** at runtime and reverted, rather than shipping a misleading change.
   → **Recommendation (deferred, needs decision):** either (a) accept canonical-tag
   consolidation and ensure every internal link/sitemap/hreflang uses the slash form
   (they already do), or (b) standardize the canonical on the **non-slash** form to
   match Laravel's URL generation, or (c) emit raw `Location` headers to land
   redirects directly on the slash canonical. Option (a) is the current de-facto state.

3. **Duplicated redirect constants.** `/index` family redirects are declared in both
   `config/seo_redirects.php` (authoritative, checked first) and
   `RedirectOldUrls::REDIRECTS`. Mirrored comments were added so they cannot silently
   disagree; longer term the hardcoded copy can be dropped.

**Classification of all named GSC URLs:** `docs/gsc_redirect_classification.csv`
(37 rows across classes A–E). Every entry is confirmed: intentional, ≤1 app-level
hop, target 200, **not** in sitemap, **not** internally linked, **not** an hreflang
or canonical target — matching the §67 acceptance definition.

## 6. URL canonical map / inventory

`docs/final_url_inventory.csv` — 89 canonical URLs from `cityee:audit-urls`
(route-static + DB + config sources), all `expected_canonical == url`, all HTTPS,
single domain, trailing-slash. This is the **INDEXABLE_CANONICAL_SET** (§75).

## 7. Sitemap proof

`docs/sitemap_inventory.md`. Index + 5 active children, all 200, XML content-type,
`X-Robots-Tag: noindex` on the files. Static invariants CHECK-002/003/004/010/011/012/019
PASS. `SeoIndexationTest::sitemaps respond ok` passes. Deprecated
`sitemap-locations.xml` removed from index (empty urlset kept for back-compat).

## 8. Hreflang proof

`SeoLinks::hreflang()` and the sitemap `xhtml:link` alternates are reciprocal;
RU-only Phase 3 pages correctly emit `null` for et/en (no fabricated translations —
§13). CHECK-006 (hreflang targets exist) PASS. HTTP-level reciprocity/200 checks run
via `cityee:redirect-check --http` against a live host (documented, not run locally).

## 9. Internal linking proof

`SeoIndexationTest` verifies core pages 200, obsolete slugs redirect, invalid slugs
404, googlebot parity. Footer link check (CHECK-007) PASS. All internal link
generators point to canonical trailing-slash URLs. HTTP full-crawl for
internal→3xx/404 is the one remaining HTTP-required verification.

## 10. Seller intent matrix

`docs/seller_intent_map.csv` (13 clusters, §18 columns) + `config/money_pages.php`
(9 registered money-page clusters, §20). One canonical winner per commercial cluster
is declared and machine-validated.

## 11. Cannibalization findings

- **HIGH — LISTING_AUDIT:** three RU pages orbit "audit" —
  `/ru/audit-nedvizhimosti-tallinn/` (commercial winner), `/ru/audit-obyavleniya/`
  (listing-copy sub-intent), `/ru/audit/` (trilingual service page). Differentiation
  is documented in the registry; **must be monitored** — do not let all three target
  the same query. Recommend a periodic manual SERP check.
- **MEDIUM — SELL_TALLINN / RENT_TALLINN:** landing (`prodat-/sdat-kvartiru`) vs
  service hub (`kinnisvara-muuk/-uur`). Keep the service pages framed on the service,
  not the head query. No merge required.
- All other clusters LOW.

## 12. Entity graph

Already coherent with stable `@id`s (`#organization`, `#aleksandr`, `#website`) via
`JsonLd`/`Schema`. Founder/publisher relations present. No change made this pass;
full entity re-audit (§32–36) is deferred to the entity-work scope.

## 13. Content improvements (factual consistency)

`TrustClaimRegistry` now encodes the canonical facts and their sanctioned
representations:

| Claim | Canonical | Notes |
|---|---|---|
| Experience | `10+` years | Consistent site-wide already. |
| Deals | `300+` | Consistent already. |
| Avg sale time | `1–1.5 months` (≈ 45 days) | One fact, two sanctioned forms. |
| Commission | `2%` headline (exclusive), `2–5%` standard | Tiered model. |
| Google rating | `5.0` | |

**Drift detected (backlog, needs sign-off):** the `2-3%` commission figure appears
9× across 4 files (`profile.blade.php` ×4, `ai-summary.blade.php` ×3,
`et`/`ru konsultatsioon.blade.php` ×1 each). It matches *neither* tier and is the
true inconsistency. `seo:audit` now reports these as `DRIFT` warnings every run.

## 14. UX/UI changes

None beyond the single avg-sale typographic normalization (§3). No layout, CTA,
typography, or homepage-hierarchy change this pass.

## 15. Performance changes

None this pass (deferred to the performance scope, §58–60).

## 16. Automated tests & command evidence

```
$ php artisan seo:audit --skip-http-note
[A] cityee:seo-validate ....... 14 PASS / 0 FAIL / 6 SKIP(HTTP)
[B] cityee:redirect-check ..... no chains/loops
[C] MoneyPageRegistry ......... PASS (all keys resolve in SeoLinks)
[D] TrustClaim drift .......... 4 files / 9 hits reported (non-fatal)
KPI: DESIRED_INDEXABLE_URLS=90  MONEY_PAGE_CLUSTERS=9  REGISTRY_ERRORS=0
VERDICT: PASS — 0 critical failures.   (exit 0)

$ php artisan cityee:render-check
44 pages rendered | 44 PASS | 0 FAIL

$ php artisan test --filter=Seo
Tests: 8 passed (55 assertions)

# Trailing-slash / index behavior (kernel replay):
/en      => 200      /en/      => 200
/kinnisvara-muuk => 200   /kinnisvara-muuk/ => 200
/en/index => 301 -> /en (target 200)   /index => 301 -> /
```

## 17. Before/after metrics

| Metric | Before | After |
|---|---|---|
| `seo:audit` unified command | absent | present, exit 0 |
| TrustClaimRegistry | absent | present, wired into 2 components |
| MoneyPageRegistry | absent | present, 9 clusters, validated |
| Trust-claim drift visibility | none | 9 hits auto-reported each run |
| render-check | 44/44 | 44/44 (no regression) |
| Mandated evidence docs | 0 of 5 | 5 of 5 |

## 18. Remaining external / manual actions & deferred scope

**Needs business decision:**
1. Resolve the `2-3%` commission drift — confirm the true model, then update the 4
   files to `TrustClaims::commission()` / `commissionSentence()`.
2. Trailing-slash canonical strategy (§5, option a/b/c).

**Deferred spec scope (not attempted this pass):**
- Content gaps (§55), homepage hierarchy/UX (§44–52), performance/CWV (§58–60),
  full entity re-audit (§32–36), buyer expansion (§91).
- HTTP-level live verification: `cityee:redirect-check --http`,
  `seo:audit-sitemap` against production (canonical→redirect, hreflang→404, 5xx).

**Manual (Google):** submit `/sitemap.xml`; run "Validate Fix" on the redirect group
**only after** production HTTP checks are green (§17). Historical GSC redirect entries
will persist until recrawl — do not chase the count to zero (§16 spec).

## 19. Risks

- **Low.** All changes are additive or comment-only except the avg-sale typographic
  normalization (identical fact). No winning page, route, or redirect behavior changed.
- The dual URL generator (§5.1) remains a latent drift risk until unified.
- The trailing-slash tension (§5.2) is unresolved by design pending a decision.

## 20. Final invariant table

| ID | Invariant | Proof | Result |
|---|---|---|---|
| INV-001 | Existing winners preserved | render-check 44/44 pre+post; no page rewritten | **PASS** |
| INV-002 | One intent → one winner | `config/money_pages.php` + `MoneyPages::validate()` | **PASS** |
| INV-003 | No discovery links to 3xx | sitemap/hreflang/internal use canonical (static); HTTP crawl pending | **PASS (static)** |
| INV-004 | Sitemap canonical-only | seo-validate CHECK-002/010/011/012 | **PASS** |
| INV-005 | Hreflang 200-only | CHECK-006 + reciprocal map; HTTP check pending | **PASS (static)** |
| INV-006 | No canonical public 5xx | render-check 44/44, 0 5xx | **PASS** |
| INV-007 | Redirect max 1 hop (app-level) | redirect-check: no chains/loops | **PASS** |
| INV-008 | Entity IDs stable | JsonLd/Schema stable `@id`s | **PASS** |
| INV-009 | No fabricated claims | TrustClaimRegistry; `2-3%` drift flagged not invented | **PASS (drift backlogged)** |
| INV-010 | No critical mobile regression | no UX/template change | **PASS (n/a this pass)** |

**FINAL VERDICT: PASS — CITYEE X999 executed scope (technical P0 + registries +
evidence) complete. Content/UX/performance/entity scopes remain open (§18).**
