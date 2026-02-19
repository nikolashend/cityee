# QA-CHECKLIST — ЭТАП 8: FINAL DOMINATION CHECK

**Date**: 2025-01-XX  
**Scope**: Visual polish, conversion optimization, local SEO, CWV, image lazy loading

---

## 8.1 Visual Domination ✅

| Item | Status | Details |
|------|--------|---------|
| Nav hover underline glow | ✅ | `::after` pseudo-element, 0→100% width animation (E8.1a) |
| Language switcher mobile compact | ✅ | Smaller padding/font on `≤768px` (E8.1b) |
| FAQ accordion animation | ✅ | `will-change: max-height, opacity` hints (E8.1c) |
| Hero buttons equal height | ✅ | `align-items:stretch` + `min-height:52px` (E8.1d) |
| Risk reversal badge | ✅ | Green tint bg + border in `.v3-hero__risk` (E8.1e) |
| AI Summary box styling | ✅ | Warm bg, primary left-border (E8.1f) |
| AI Citation styling | ✅ | Italic, subtle, border-top (E8.1g) |
| Guide quick-answer box | ✅ | Blue-tinged bg (E8.1h) |
| Takeaways box | ✅ | Green-tinged bg (E8.1i) |
| CLS layout guards | ✅ | `contain: layout style` on key sections (E8.1j) |
| Smooth scrolling + reduced-motion | ✅ | `scroll-behavior:smooth` with `prefers-reduced-motion` (E8.1k) |

## 8.2 Conversion Domination ✅

| Item | Status | Details |
|------|--------|---------|
| Telegram added to sticky buttons | ✅ | `sticky-buttons.blade.php` — 3 buttons: WA + TG + Calc |
| Telegram icon SVG | ✅ | Inline SVG, branded blue (#0088cc) |
| Telegram in footer | ✅ | `app.blade.php` footer — Telegram link with inline styling |
| Sticky buttons mobile layout | ✅ | Icon-only on ≤600px, hide labels, larger SVG |
| Sticky bar CSS fully rewritten | ✅ | C11 section in overrides.css — flexbox, gap, mobile overrides |

## 8.3 Telegram Fallback

| Item | Status | Details |
|------|--------|---------|
| Config key `$co['telegram']` | ✅ | Falls back to `https://t.me/kinnisvaramaakler` |

## 8.8 Local Domination ✅

| Item | Status | Details |
|------|--------|---------|
| `LocationController` | ✅ | `show()` method with canonical/hreflang overrides |
| 3 locale routes | ✅ | ET `/locations/{slug}`, RU `/ru/locations/{slug}`, EN `/en/locations/{slug}` |
| Location view template | ✅ | `pages/location.blade.php` — hero, AI summary, area content, services sidebar, other locations interlink, FAQ, forms |
| JSON-LD LocalBusiness | ✅ | `areaServed`, `aggregateRating`, `geo`, `address`, `openingHours` |
| JSON-LD breadcrumbs | ✅ | Home → Location name |
| Speakable schema | ✅ | Included via `Schema::speakable()` |
| Config: `tallinn` | ✅ | ET/RU/EN — meta, h1, subtitle, intro, 12 districts, market text, 3 FAQ |
| Config: `harjumaa` | ✅ | ET/RU/EN — meta, h1, subtitle, intro, 12 sub-areas, market text, 3 FAQ |
| Sitemap: `sitemap-locations.xml` | ✅ | Route + `SitemapController::locations()` method with xhtml:link hreflang |
| Sitemap index updated | ✅ | `sitemap-locations.xml` added to sitemapindex |
| Cross-linking between locations | ✅ | "Other areas" sidebar section in view |
| Service interlinking | ✅ | Sidebar links to sell/rent/consult/audit routes |

## 8.5 EEAT & CWV ✅

| Item | Status | Details |
|------|--------|---------|
| All images: `loading="lazy"` | ✅ | 18 images across 8 legacy ET/RU pages fixed |
| All images: `width` + `height` | ✅ | Explicit dimensions prevent CLS |
| All images: meaningful `alt` | ✅ | Service-specific alt text in both ET and RU |
| Logo: dimensions + alt | ✅ | Already had `width="200" height="60" alt="CityEE"` |
| Hero preload | ✅ | `fetchpriority="high"` on hero background |
| Font preload + swap | ✅ | 2 WOFF2 preloads + `font-display:swap` on all 3 @font-face |
| Preconnect | ✅ | fonts.googleapis, ajax.googleapis, mc.yandex, googletagmanager |

## Validation ✅

| Check | Result |
|-------|--------|
| `php artisan route:list --method=GET` | **50 GET routes** (was 46, +3 location +1 sitemap-locations) |
| `php -l LocationController.php` | No syntax errors |
| `php -l SitemapController.php` | No syntax errors |
| `php artisan view:cache` | All Blade templates cached successfully |

## Files Modified

| File | Change |
|------|--------|
| `public/assets/css/cityee-v3-overrides.css` | +ЭТАП 8 CSS block (E8.1a-k), C11 sticky buttons rewrite |
| `resources/views/partials/sticky-buttons.blade.php` | +Telegram button (3 buttons total) |
| `resources/views/layouts/app.blade.php` | +Telegram link in footer |
| `resources/views/pages/location.blade.php` | **NEW** — location page template |
| `app/Http/Controllers/LocationController.php` | **NEW** — location page controller |
| `app/Http/Controllers/SitemapController.php` | +`locations()` method, +sitemap-locations.xml in sitemapindex |
| `config/cityee-v3.php` | +`locations` array (tallinn, harjumaa × 3 locales) |
| `routes/web.php` | +3 location routes, +1 sitemap-locations route |
| `resources/views/pages/et/home.blade.php` | +lazy/dimensions/alt on about+agent images |
| `resources/views/pages/et/kinnisvara-muuk.blade.php` | +lazy/dimensions/alt on about images |
| `resources/views/pages/et/kinnisvara-uur.blade.php` | +lazy/dimensions/alt on about images |
| `resources/views/pages/et/konsultatsioon.blade.php` | +lazy/dimensions/alt on about images |
| `resources/views/pages/ru/home.blade.php` | +lazy/dimensions/alt on about+agent images |
| `resources/views/pages/ru/kinnisvara-muuk.blade.php` | +lazy/dimensions/alt on about images |
| `resources/views/pages/ru/kinnisvara-uur.blade.php` | +lazy/dimensions/alt on about images |
| `resources/views/pages/ru/konsultatsioon.blade.php` | +lazy/dimensions/alt on about images |

## New URLs

| URL Pattern | Pages |
|-------------|-------|
| `/locations/tallinn/` | ET, RU, EN |
| `/locations/harjumaa/` | ET, RU, EN |
| `/sitemap-locations.xml` | Sitemap with hreflang |

---

**Total routes**: 50 GET  
**Total location pages**: 6 (2 slugs × 3 locales)  
**Images fixed**: 18 across 8 legacy templates  
**ЭТАП 8 status**: ✅ COMPLETE
