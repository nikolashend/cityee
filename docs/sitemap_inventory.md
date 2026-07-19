# Sitemap Inventory — CityEE (X999 §11–12)

Source of truth: `app/Http/Controllers/SitemapController.php` (deterministic generator,
no hand-edited XML). Sitemap index: **`/sitemap.xml`**.

All sitemap responses set `Content-Type: application/xml; charset=UTF-8` and
`X-Robots-Tag: noindex` (the sitemap files themselves are not indexed; the URLs
inside them are). All child sitemaps are referenced from the index except the
deprecated locations sitemap.

## Active sitemaps (referenced from /sitemap.xml)

| Sitemap | Route name | Contents | Status | Notes |
|---|---|---|---|---|
| `/sitemap.xml` | `sitemap` | Sitemap index → 5 children | 200 | Canonical index |
| `/sitemap-main.xml` | `sitemap.main` | All static pages ×3 languages, with `xhtml:link` hreflang alternates | 200 | Trailing-slash canonical URLs only; dashboard excluded (noindex) |
| `/sitemap-guides.xml` | `sitemap.guides` | Published DB `Guide` records, grouped by slug with hreflang | 200 | Empty-safe (try/catch if table absent) |
| `/sitemap-audits.xml` | `sitemap.audits` | Published DB `AreaAudit` records with hreflang | 200 | Empty-safe |
| `/sitemap-phase3.xml` | `sitemap.phase3` | RU-only intent landings, GEO hub `/ru/tallinn/`, districts, cases hub + cases | 200 | Driven by `config/cityee-phase3.php` |
| `/sitemap-knowledge.xml` | `sitemap.knowledge` | 7 trilingual pillar guides + cases hub, with hreflang | 200 | Driven by `config/cityee-knowledge.php` |

## Legacy / deprecated sitemaps

| Sitemap | Route name | Status | Action taken | Reason |
|---|---|---|---|---|
| `/sitemap-locations.xml` | `sitemap.locations` | 200 (empty `urlset`) | **Removed from index**; returns empty urlset with explanatory comment | All `/locations/{slug}` 301 → Phase 3 geo (`/ru/tallinn/{district}`); Phase 3 sitemap already covers canonical geo URLs. Kept as 200 empty for backward-compat if crawlers still request it. |

## Invariants enforced

- **Sitemap contains only preferred (canonical, trailing-slash) URLs** — verified by
  `cityee:seo-validate` CHECK-002/010/011/012 (no redirect URLs, no query params,
  HTTPS only, canonical domain only). Static: PASS.
- **No sitemap URL is robots-blocked or noindex** — dashboard and query URLs are
  excluded from the slug arrays (CHECK-003/004). PASS.
- **Every child sitemap exists as a route** — CHECK-019. PASS.
- **HTTP-level 200 / self-canonical / content-type** — run `cityee:seo-audit-sitemap`
  and `cityee:render-check` against a live host (CHECK-001/005/020 are HTTP-required).

## Known structural note

`SitemapController::buildHreflangMap()` / `pagesForLang()` currently re-declares the
per-language URL map that also lives in `App\Support\SeoLinks`. They agree today, but
this duplication is a drift risk (see hardening report §5). Recommended future change:
have `SitemapController` consume `SeoLinks` as the single URL source.
