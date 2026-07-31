# CityEE — Change Freeze: Current Release (X999^5 §4)

**Freeze start:** 2026-07-30 · **Checkpoint tag:** `cityee-pre-revenue-safe-production-closure-20260730-1450`
**Freeze end condition:** production deploy of Commits A–C verified (§9–§10 acceptance met)
**+ 72-hour monitoring completed with 0 unresolved critical incidents (§16)**.

## Release scope (what is being deployed)

Commits A–C, already implemented + locally proven:
- **A** — SQLite production safety (untracked + ignored + `docs/CITYEE_SQLITE_PRODUCTION_SAFETY.md`).
- **B** — `NormalizeInternalLinkSlashes` middleware (internal `<a href>` → trailing-slash canonical) + `seo:audit-production` slash-sensitive cache fix + regression tests.
- **C** — winner internal-authority strengthening (diversified/added contextual links; agency depth 3→2). No winner content/URL/title/H1/hero/form changed.

## Allowed changes during freeze

Only: production deploy runbook execution, SQLite backup, `git pull` + `optimize:clear`,
`migrate --force` (if pending), production HTTP verification/crawl, log review, form
**verification** (no logic change), attribution **investigation**, and a **minimal patch for a
reproducible critical defect caused by this deploy** (with rollback + documentation).

## Forbidden during freeze

routes · forms · form logic · CTAs · CTA text · analytics · GTM · GA4 · Google Ads
conversions · winner titles · winner H1 · winner URLs · canonicals · hreflang · schema ·
new entity claims · commission · header nav · footer nav · content blocks · CSS tokens ·
typography · JS behavior · new/GEO/seller pages · re-diversifying anchors · additional
authority links · running seeders · mass refactor.

## Protected files / components

- Winner pages: `/`, `/ru/`, `/ru/makler-v-tallinne/`, `/ru/prodat-kvartiru-v-tallinne/`,
  `/ru/ocenka-kvartiry-v-tallinne/`, `/ru/agentstvo-nedvizhimosti-tallinn/`,
  `/ru/kinnisvara-uur/`, `/ru/aleksandr-primakov/`, `/ru/tallinn/` + ET/EN equivalents.
- `app/Http/Controllers/ContactController.php` (forms), form Blade partials, CTA blocks.
- `config/trust_claims.php`, `config/money_pages.php`, `config/search_intents.php`,
  `config/seo_protected_assets.php`, schema (`app/Support/JsonLd.php`, `Schema.php`).
- Header/footer in `resources/views/layouts/app.blade.php`, analytics scripts.

## Rollback trigger (any one → immediate rollback, §18)

production DB missing/corrupt · guide/audit content loss · lead loss · forms not submitting ·
new 5xx on money pages · new internal 4xx · redirect loop · UTM/GCLID destroyed by middleware ·
winner URL/canonical/title/H1 changed · mobile CTA blocked · critical log spike.

## Responsible commands (rollback)

```bash
git checkout cityee-pre-revenue-safe-production-closure-20260730-1450   # code
cp backups/database-before-revenue-safe-<ts>.sqlite database/database.sqlite  # DB
php artisan optimize:clear
```
