# QA-CHECKLIST-ETAP7.md — Deep Technical Audit & Index Domination

**Date:** 2025-01-XX
**Scope:** robots.txt, sitemap, canonical, hreflang, 301 redirects, JSON-LD, CWV

---

## 7.1 robots.txt

| # | Check | Status |
|---|-------|--------|
| 1 | `GET /robots.txt` returns `Content-Type: text/plain` | ☐ |
| 2 | `User-agent: *` → `Allow: /` present | ☐ |
| 3 | Disallow: `/admin`, `/login`, `/register` | ☐ |
| 4 | Disallow: `/storage/`, `/vendor/`, `/node_modules/` | ☐ |
| 5 | Disallow: `/resources/`, `/bootstrap/`, `/config/` | ☐ |
| 6 | Disallow: `/database/`, `/tests/` | ☐ |
| 7 | Disallow: `/index`, `/index.html`, `/index.php` | ☐ |
| 8 | Disallow: `/*?utm_`, `/*?fbclid=`, `/*?gclid=`, `/*?yclid=` | ☐ |
| 9 | AI crawlers allowed: GPTBot, Google-Extended, ChatGPT-User, Bingbot, PerplexityBot | ☐ |
| 10 | `Host: cityee.ee` present | ☐ |
| 11 | `Sitemap: https://cityee.ee/sitemap.xml` present | ☐ |
| 12 | `public/robots.txt` static fallback matches dynamic version | ☐ |

---

## 7.2 Sitemap

| # | Check | Status |
|---|-------|--------|
| 13 | `GET /sitemap.xml` returns valid `<sitemapindex>` XML | ☐ |
| 14 | Index references: sitemap-main.xml, sitemap-guides.xml, sitemap-audits.xml | ☐ |
| 15 | `GET /sitemap-main.xml` — 11 pages × 3 languages = 33 `<url>` entries | ☐ |
| 16 | Each `<url>` has `<loc>`, `<lastmod>`, `<changefreq>`, `<priority>` | ☐ |
| 17 | Each `<url>` has 4 `<xhtml:link>` alternates (et-EE, ru-EE, en-EE, x-default) | ☐ |
| 18 | x-default points to ET version | ☐ |
| 19 | All `<loc>` URLs use trailing slashes | ☐ |
| 20 | `GET /sitemap-guides.xml` — has `<changefreq>monthly</changefreq>` | ☐ |
| 21 | `GET /sitemap-audits.xml` — has `<changefreq>monthly</changefreq>` | ☐ |
| 22 | Guides/audits sitemaps have per-slug hreflang + x-default | ☐ |

---

## 7.3 Canonical Strategy

| # | Check | Status |
|---|-------|--------|
| 23 | ET pages: `<link rel="canonical" href="https://cityee.ee/{slug}/">` | ☐ |
| 24 | RU pages: `<link rel="canonical" href="https://cityee.ee/ru/{slug}/">` | ☐ |
| 25 | EN pages: `<link rel="canonical" href="https://cityee.ee/en/{slug}/">` | ☐ |
| 26 | Each language's canonical points to **itself** (not to ET) | ☐ |
| 27 | Guides/show: canonical = `/guides/{slug}/` (not `/guides/`) | ☐ |
| 28 | Audits/show: canonical = `/audits/{slug}/` (not `/audits/`) | ☐ |
| 29 | OG:url matches canonical URL | ☐ |
| 30 | `$canonicalUrl` override works for dynamic pages | ☐ |

---

## 7.4 Hreflang

| # | Check | Status |
|---|-------|--------|
| 31 | All pages emit 4 hreflang links: et-EE, ru-EE, en-EE, x-default | ☐ |
| 32 | x-default → ET base version | ☐ |
| 33 | Hreflang URLs use trailing slashes | ☐ |
| 34 | No hreflang points to 404 | ☐ |
| 35 | Guides/audits show pages have per-slug hreflang based on DB alternates | ☐ |
| 36 | If only 2/3 language versions exist, only existing ones get hreflang | ☐ |

---

## 7.5 301 Redirects

| # | Check | Status |
|---|-------|--------|
| 37 | `/index.php` → 301 → `/` | ☐ |
| 38 | `/index.html` → 301 → `/` | ☐ |
| 39 | `/wp-admin` → 301 → `/` | ☐ |
| 40 | `/kontakt` → 301 → `/kontaktid/` | ☐ |
| 41 | `/sell` → 301 → `/en/sell-property/` | ☐ |
| 42 | `/kinnisvara-muuk` (no trailing slash) → 301 → `/kinnisvara-muuk/` | ☐ |
| 43 | `/ru/guides` (no trailing slash) → 301 → `/ru/guides/` | ☐ |
| 44 | No redirect loops detected | ☐ |
| 45 | RedirectOldUrls middleware runs before router | ☐ |

---

## 7.6 JSON-LD: Service Pages

| # | Check | Status |
|---|-------|--------|
| 46 | sell/rent/consultation: `@type: Service` with `provider: @id:#org` | ☐ |
| 47 | `areaServed`: City/Tallinn + AdministrativeArea/Harjumaa | ☐ |
| 48 | Service pages include FAQ entities when FAQ data exists | ☐ |
| 49 | Organization JSON-LD co-emitted on service pages | ☐ |

---

## 7.7 JSON-LD: Organization

| # | Check | Status |
|---|-------|--------|
| 50 | `@type: ['Organization', 'RealEstateAgent', 'LocalBusiness']` | ☐ |
| 51 | `@id: https://cityee.ee/#org` | ☐ |
| 52 | `sameAs`: Facebook, Instagram, LinkedIn, Telegram | ☐ |
| 53 | `contactPoint` with `availableLanguage: [Estonian, Russian, English]` | ☐ |
| 54 | `aggregateRating` present with ratingValue 5.0 | ☐ |
| 55 | `address` + `geo` coordinates for Viru väljak 2, Tallinn | ☐ |

---

## 7.8 JSON-LD: Person

| # | Check | Status |
|---|-------|--------|
| 56 | `@type: Person`, `@id: https://cityee.ee/#alex` | ☐ |
| 57 | `name: Aleksandr Primakov` | ☐ |
| 58 | `jobTitle: Real Estate Deal Optimization Partner` | ☐ |
| 59 | `worksFor: @id:#org` | ☐ |
| 60 | `sameAs`: LinkedIn, Facebook, Instagram, Telegram | ☐ |
| 61 | Person JSON-LD emitted on home page | ☐ |

---

## 7.9 JSON-LD: Breadcrumbs

| # | Check | Status |
|---|-------|--------|
| 62 | All 13 templates emit `BreadcrumbList` JSON-LD | ☐ |
| 63 | Home page breadcrumb: 1 item (Home) | ☐ |
| 64 | Service pages: Home → Service Title | ☐ |
| 65 | Guides/show: Home → Guides → Guide Title | ☐ |
| 66 | Audits/show: Home → Audits → Audit Title | ☐ |

---

## 7.10 JSON-LD: WebSite (Global)

| # | Check | Status |
|---|-------|--------|
| 67 | `@type: WebSite` with `SearchAction` emitted in layout head | ☐ |
| 68 | `publisher: @id:#org` | ☐ |
| 69 | `inLanguage: [et, ru, en]` | ☐ |

---

## 7.11 Trailing Slash Consistency

| # | Check | Status |
|---|-------|--------|
| 70 | TrailingSlash middleware registered in app.php | ☐ |
| 71 | GET `/kinnisvara-muuk` → 301 → `/kinnisvara-muuk/` | ☐ |
| 72 | GET `/sitemap.xml` — no trailing slash redirect (file extension) | ☐ |
| 73 | GET `/robots.txt` — no trailing slash redirect (file extension) | ☐ |
| 74 | POST routes not affected by trailing slash middleware | ☐ |

---

## 7.12 Middleware Order

| # | Check | Status |
|---|-------|--------|
| 75 | Order: RedirectOldUrls → CanonicalRedirects → TrailingSlash | ☐ |
| 76 | NoIndexQueryParams appended to web group | ☐ |
| 77 | `?utm_source=...` requests get `X-Robots-Tag: noindex, follow` | ☐ |

---

## 7.13 Validation

| # | Check | Status |
|---|-------|--------|
| 78 | `php artisan view:cache` — no errors | ✅ |
| 79 | `php artisan route:list --method=GET` — 46 routes | ✅ |
| 80 | PHP lint on all new middleware — no syntax errors | ✅ |
| 81 | No new compile/lint errors in workspace | ✅ |

---

## Files Modified (ЭТАП 7)

| File | Change |
|------|--------|
| `resources/views/layouts/app.blade.php` | Dynamic canonical/hreflang override + WebSite JSON-LD |
| `app/Http/Controllers/GuideController.php` | Pass `canonicalUrl` + `hreflangLinks` to show view |
| `app/Http/Controllers/AuditContentController.php` | Pass `canonicalUrl` + `hreflangLinks` to show view |
| `app/Http/Controllers/SitemapController.php` | Add Disallows to robots(), add changefreq to guides/audits |
| `public/robots.txt` | Updated static fallback with full Disallow list |
| `app/Http/Middleware/RedirectOldUrls.php` | **NEW** — 301 redirects for old/dead URLs |
| `app/Http/Middleware/TrailingSlash.php` | **NEW** — Force trailing slash on GET paths |
| `bootstrap/app.php` | Register RedirectOldUrls + TrailingSlash middleware |

---

## Search Console Actions (Manual)

1. Resubmit `https://cityee.ee/sitemap.xml` in Search Console
2. Run URL Inspection on: `/`, `/ru/`, `/en/`, `/kinnisvara-muuk/`, `/ru/kinnisvara-muuk/`
3. Check "Page indexing" report — verify "Alternate page with canonical tag" decreases
4. Check "Excluded" pages — verify old 404s now redirect
5. Validate hreflang via `hreflang-checker.com` or Screaming Frog
