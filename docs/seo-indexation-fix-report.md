# SEO Indexation Fix Report — cityee.ee

**Date:** 2026-07-06
**Companion:** `docs/seo-indexation-diagnosis.md` (root-cause analysis)
**Scope:** Safe, production-ready SEO repair layer. No visual/frontend changes, no route deletions, no GTM/GA4 changes, no business-logic changes.

---

## 1. What was changed (and why)

| # | File | Change | Purpose |
|---|---|---|---|
| 1 | `app/Http/Controllers/SitemapController.php` | robots.txt: removed `Disallow: /*?category=`, `?type=`, `?q=`, `?filter=`, `?search=`, `?page=`, `?sort=`, `?ref=`, `?trk=`. Kept only tracking params (`utm_`, `fbclid`, `gclid`, `yclid`, `msclkid`) and added `gtm_debug`. | Content-filter query URLs now 301 to their clean canonical. Blocking them in robots stranded them as *"indexed, blocked by robots"* because Google could not crawl to see the redirect. |
| 2 | `app/Http/Middleware/RedirectOldUrls.php` | (a) Now **reads `config/seo_redirects.php` at runtime** and enforces it (301 or 410). Previously that config was declared but only read by audit commands — **never actually applied to requests**. (b) Added legacy-host guard: `ru.cityee.ee/*` → 301 `cityee.ee/ru/*`, `www.cityee.ee/*` → 301 `cityee.ee/*`. (c) Removed a duplicate `/ru/knowledge` array key. | Single enforced source of truth for redirects; app-level defence for the subdomain-indexation problem; cleaner code. |
| 3 | `config/seo_redirects.php` | Added precise 301s for the genuinely changed/removed slugs (see §2). | Turn real 404s into clean one-hop 301s to live equivalents. |
| 4 | `app/Console/Commands/SeoAuditUrlsCommand.php` | **New** — `php artisan seo:audit-urls [--googlebot]`. | Replays 33 GSC-critical URLs in-process and asserts expected status; `--googlebot` proves UA parity. |
| 5 | `app/Console/Commands/SeoAuditSitemapCommand.php` | **New** — `php artisan seo:audit-sitemap`. | Parses the sitemap index + all child sitemaps and verifies every `<loc>` is a clean, non-redirecting, indexable 200. |
| 6 | `tests/Feature/SeoIndexationTest.php` | **New** — 8 feature tests (robots, sitemaps, core 200s, query→301, obsolete→301, invalid→404, legacy-host→301, Googlebot parity). | Locks the contract so these problems cannot silently regress. |
| 7 | repo root | Removed junk debug leftovers: `test_pillar.php`, `test_pillar2.php`, `test_render.php`, `test_render2.php`, `test_view.php`. | Cleanup (not web-served; not SEO, but shouldn't be committed). |

**Deliberately NOT changed:** routes, controllers' business logic, view templates / design, GTM container `GTM-5DRRX5ZJ`, GA4 `G-56M1W9H0W`, the `lead_submit_success` dataLayer event, forms, canonical/hreflang tags (already correct — see §5).

---

## 2. Redirect map added (this change)

| Old URL (GSC 404) | New URL | Status | Reason |
|---|---|---|---|
| `/knowledge/labiraakimiste-strateegia-kinnisvara` | `/knowledge/labirakimiste-strateegia-kinnisvara` | 301 | Slug typo fixed (double `aa` → single) |
| `/ru/kvartira-ne-prodaetsya` | `/ru/ne-prodaetsya-kvartira-v-tallinne` | 301 | Old RU slug → current Phase-3 landing |
| `/guides/seo-strategi-2026` | `/guides` | 301 | Guide removed → section index (topical equivalent) |
| `/guides/geo-aeo-ai-optimizatsiya` | `/guides` | 301 | Guide removed → section index |
| `/ru/guides/seo-strategi-2026` | `/ru/guides` | 301 | Guide removed → section index (RU) |
| `/ru/guides/geo-aeo-ai-optimizatsiya` | `/ru/guides` | 301 | Guide removed → section index (RU) |

Legacy-host redirects (app-level, belt-and-suspenders for the server rule):

| Host + path | Target | Status |
|---|---|---|
| `ru.cityee.ee/{path}` | `https://cityee.ee/ru/{path}` | 301 |
| `www.cityee.ee/{path}` | `https://cityee.ee/{path}` | 301 |

All redirects are **one hop** (verified — see §4). We chose 301 over 410 for the removed guides to preserve link equity toward a live, topically-relevant section.

---

## 3. robots.txt — before / after

**Removed** (harmful — blocked crawling of URLs that 301):
```
Disallow: /*?sort=   /*?trk=   /*?page=   /*?ref=
Disallow: /*?category=   /*?type=   /*?q=   /*?filter=   /*?search=
```
**Kept / added** (tracking only):
```
Disallow: /*?utm_   /*?fbclid=   /*?gclid=   /*?yclid=   /*?msclkid=   /*?gtm_debug=
```
**Unchanged & confirmed:** `Allow: /`, `/ru/` and `/en/` **not** blocked, `dashboard`/`admin`/`login`/`search` blocked, AI crawlers allowed, `Sitemap: https://cityee.ee/sitemap.xml` declared.

---

## 4. Before / after status table (verified locally, in-process, full middleware)

| URL | GSC reported | Now |
|---|---|---|
| `/` , `/ru` , `/en` | — | **200** |
| `/aleksandr-primakov` | 403 | **200** (403 was CDN/WAF, not app) |
| `/muua-ise-vs-strateegiline-partner` | 403 | **200** |
| `/knowledge/kuidas-valmistada-korter-muugiks` | 403 | **200** |
| `/guides?category=pricing` | 403 | **301 → /guides** |
| `/guides?category=rent` | 403 | **301 → /guides** |
| `/en/guides?category=pricing` | 403 | **301 → /en/guides** |
| `/en/index` | 404 | **301 → /en** |
| `/knowledge/vead-mille-parast-kaotate-raha` | 404 | **200** (already fixed) |
| `/ru/knowledge/kak-podgotovit-kvartiru-k-prodazhe` | 404 | **200** |
| `/en/knowledge/mistakes-that-cost-money` | 404 | **200** |
| `/ru/knowledge/analiz-rynka-nedvizhimosti-tallinn-2026` | 404 | **200** |
| `/knowledge/labiraakimiste-strateegia-kinnisvara` | 403 | **301 → …/labirakimiste-…** |
| `/ru/kvartira-ne-prodaetsya/` | 404 | **301 → /ru/ne-prodaetsya-kvartira-v-tallinne** |
| `/guides/seo-strategi-2026` | 403 | **301 → /guides** |
| `/guides/geo-aeo-ai-optimizatsiya` | 404 | **301 → /guides** |
| `ru.cityee.ee/kinnisvara-muuk` | indexed/blocked | **301 → cityee.ee/ru/kinnisvara-muuk** |
| invalid slug (any section) | — | **404** (never 403/500) |

**Verification commands run:**
```
php artisan config:clear && route:clear && view:clear && cache:clear
php artisan seo:audit-urls              → PASS (33/33 match)
php artisan seo:audit-urls --googlebot  → PASS (33/33, UA parity)
php artisan seo:audit-sitemap           → PASS (123/123 URLs = 200)
php artisan cityee:redirect-check       → No chains or loops
php artisan cityee:seo-validate         → 14 PASS / 0 FAIL
php artisan test                        → 10 passed (57 assertions)
```

---

## 5. Canonical / hreflang / sitemap — audit result (no change needed)

- **Architecture is already the recommended one:** single domain, path-based (`/`, `/ru/`, `/en/`). The `ru.cityee.ee` subdomain is legacy and is now redirected. This is **Option A / the "stronger alternative"** from the brief — no migration required.
- Canonical + hreflang tags are self-referencing and consistent (`SitemapController::buildHreflangMap`, `GuideController`, `PageController::pillarGuide`), with `x-default = ET`. Sitemap `<loc>`s match the canonical trailing-slash form.
- `seo:audit-sitemap` confirms **all 123 sitemap URLs are 200**, none redirect, none carry noindex. `dashboard` is correctly excluded from the sitemap, `noindex`-ed, and robots-blocked.

---

## 6. GTM / GA4 preservation (confirmed untouched)

No layout/analytics files were modified. `GTM-5DRRX5ZJ`, GA4 `G-56M1W9H0W`, and the `lead_submit_success` dataLayer push are unchanged. The only response-header touch (robots query rules + `X-Robots-Tag` on query URLs) does not affect GTM/GA4 loading or the form-success event.

---

## 7. Remaining manual steps (server / CDN — outside this repo)

These are the **authoritative** fixes for the subdomain and 403 groups; the app-level guards above are defence-in-depth.

1. **nginx / Apache** — add the canonical-host redirects (also documented in `config/seo_redirects.php`):
   ```nginx
   server { listen 80;  server_name cityee.ee www.cityee.ee ru.cityee.ee;
            return 301 https://cityee.ee$request_uri; }
   server { listen 443 ssl; server_name www.cityee.ee;
            return 301 https://cityee.ee$request_uri; }
   server { listen 443 ssl; server_name ru.cityee.ee;
            return 301 https://cityee.ee/ru$request_uri; }
   ```
2. **Cloudflare / WAF (403 group)** — the app never returns 403 for public pages, so the reported 403s originate here:
   - Bot Fight / Super Bot Fight Mode → **Verified Bots: Allow** (do not challenge Googlebot).
   - Remove/relax any managed or custom rule returning 403 for requests with a query string.
   - Verify externally: `curl -A "Googlebot/2.1" -I "https://cityee.ee/guides?category=pricing"` → expect **301**, not 403.

---

## 8. What to do in Google Search Console

Once the site is deployed **and** the server/CDN steps in §7 are done:

| GSC report | When to click **Validate Fix** | Why |
|---|---|---|
| **Indexed though blocked by robots** | After the nginx `ru.cityee.ee` → `/ru` redirect is live | Subdomain now 301s to a crawlable path; robots.txt no longer blocks content-filter params |
| **403 Forbidden** | After the Cloudflare/WAF "allow Googlebot" change is live | App proven to return 200/301 for all listed URLs incl. Googlebot UA |
| **Server error (5xx)** | Can validate now | No 500 reproducible; invalid input degrades to 404. Re-run `seo:audit-sitemap` post-deploy to confirm 0×5xx |
| **404 Not Found** | After deploy of this change set | Changed/removed slugs now 301; the rest already return 200 |
| **Redirect pages** | After deploy | All redirects are clean single-hop 301 (verified by `cityee:redirect-check`) |

Then resubmit `https://cityee.ee/sitemap.xml` in GSC.

---

## 9. Ongoing guardrails

- `php artisan seo:audit-sitemap` — run after every deploy; fails (non-zero exit) if any sitemap URL is not a clean 200. Wire into CI/deploy.
- `php artisan seo:audit-urls` — regression check for the GSC-critical set.
- `tests/Feature/SeoIndexationTest.php` — runs in the normal test suite.
- Add future GSC 404s to `config/seo_redirects.php` (now the single enforced source of truth).
