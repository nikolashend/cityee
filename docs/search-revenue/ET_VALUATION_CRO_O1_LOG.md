# ET VALUATION CRO O1 — IMPLEMENTATION LOG

**Task:** CITYEE_ET_VALUATION_CRO_O1_IMPLEMENTATION · **Date:** 2026-09-24
**Target:** `https://cityee.ee/kinnisvara-hinnaanaluus-tallinn/` (locale ET, intent `price_analysis`)
**Preflight verdict:** `READY_WITH_CONCERNS` (shared template `intent.blade.php` serves 21 intent routes → required a
default-preserving extension plus proof of zero delta on the other 20).
**Implementation commit:** `a4734b9810e65e3061f5cff7819eefc9fd94fafb`

## Pre-change state (verified 2026-09-24, production read-only)
HTTP 200 · 0 redirects · title `Kinnisvara hinnaanalüüs Tallinnas | CityEE` · H1 `Kinnisvara hinnaanalüüs Tallinnas —
reaalne turuhind` · self-canonical · indexable (no robots meta) · 4 hreflang · 6 JSON-LD.
Conversion contract: **3 CTAs → `#v3-form-audit`**, forms **audit-request → price-calculator**; the only `#v3-form-calc`
anchor was the unlabelled sitewide sticky icon *after* both forms.
`PRE_DEPLOY_BASELINE_DRIFT=NO` (identical to Preflight). Protected set (Batch 1A + RU O1) verified intact beforehand.

## Approved scope (change budget)
1 URL / ET only / `price_analysis.et` only → primary CTA target `#v3-form-audit` → `#v3-form-calc`; form order
`audit-first` → `calc-first`; Audit remains present and second. Nothing else.

## Exact source changes (2 files, +9 / −1)
**`resources/views/pages/intent.blade.php`** — default-preserving optional keys (RU O1 idiom):
```blade
- <a href="#v3-form-audit" class="btn btn-primary btn-lg">{{ $intent['cta_btn'] }}</a>
+ <a href="{{ $intent['cta_primary_target'] ?? '#v3-form-audit' }}" class="btn btn-primary btn-lg">{{ $intent['cta_btn'] }}</a>

+ @if(($intent['forms_order'] ?? 'audit-first') === 'calc-first')
+ @include('components.v3.form-calc',  ['locale' => $locale])
+ @include('components.v3.form-audit', ['locale' => $locale])
+ @else
  @include('components.v3.form-audit', ['locale' => $locale])
  @include('components.v3.form-calc',  ['locale' => $locale])
+ @endif
  @include('components.v3.form-scripts')
```
**`config/cityee-intent.php`** → `price_analysis.et` only:
```php
+ // ET valuation CRO O1: valuation intent -> valuation form (audit stays secondary/second)
+ 'cta_primary_target' => '#v3-form-calc',
+ 'forms_order'        => 'calc-first',
```

## Regression proof (local renders, CSRF-normalised, CR-normalised)
- **Route enumeration from the router (not memory): `INTENT_ROUTE_COUNT=21`**, all 200 in baseline corpus.
- **Target diff = allowlist only.** Line multiset proof: 1533 lines before and after; exactly **one** line present only in
  before (`<a href="#v3-form-audit" … >Soovin analüüsi</a>`) and **one** only in after (`…#v3-form-calc…`). Every other
  changed line exists identically in both files → the calc form block is a **pure relocation**, not a content change.
- **Non-target intent routes: 20 checked, 20 byte-identical, 0 failures.**
- **Protected / sibling pages byte-identical (12/12):** `/ru/` (Batch 1A title intact), makler, tallinn, prodat,
  agentstvo, `/ru/kinnisvara-muuk/`, **RU Ocenka O1**, ET home, ET `/kinnisvara-muuk/`, ET `/audit/`, EN home, EN sell-property.
- **Default-behaviour assertion (3 representative non-target intents — ET, EN, RU):** primary CTA still `#v3-form-audit`,
  first form still `audit-request`.
- **Target-override assertion:** primary CTA `#v3-form-calc` ("Soovin analüüsi" label unchanged), sections
  `#v3-form-calc` → `#v3-form-audit`, both forms present, all four anchor IDs unique.
- **Target SEO fields:** title, meta description, H1, canonical identical; hreflang 4→4; JSON-LD 6→6.

## Tests
`cityee:render-check` **44/44** · `seo:audit-intents` **PASS** (0 duplicate primaries, 0 competing title/H1) ·
`seo:audit-links` **PASS** · feature tests **36 passed / 188 assertions** · `tests/js/lead-tracking.test.cjs` **50/50** ·
config parses with both override keys · `git diff --check` clean. No new failures; `TEST_FILE_CHANGE_REQUIRED=NO`
(existing render/audit infrastructure already proves both contracts, and this log records the two assertions).

## Unchanged (verified in diff)
URL, title, meta, H1, body copy, CTA label, FAQ, "Arvuta reaalne hind"/"Saa hinnakoridor" wording, form fields/labels/
validation/endpoints/backend, micro-conversion "Soovin auditi", sitewide sticky "Tasuta audit", sticky calculator icon,
trust blocks, CSS, JS, schema, canonical, hreflang, robots, sitemap, internal links, GTM/GA4/Ads, `generate_lead`,
`event_id`, dedup, persistence, email. `DATABASE_CHANGE_REQUIRED=NO`.

## Deployment
Established CityEE flow: push to `origin/main` → operator runs on production `git pull && php artisan optimize:clear`
(config + view caches; **no migrate, no seed, no asset build**). This environment has no production shell →
`DEPLOYMENT_STATUS=OWNER_OR_OPERATOR_ACTION_REQUIRED`. **Revision to deploy: `a4734b9`.**
`ET_VALUATION_CRO_O1_T0` is **NOT set** — it is recorded only after the intended state is verified live.

## Post-deploy verification plan (next task)
HTTP 200 / final URL / primary CTA → `#v3-form-calc` / forms calc-first / Audit present & second / anchors unique /
title-meta-H1-canonical-robots-hreflang-schema unchanged / desktop + mobile structural / RU Ocenka O1 unchanged /
Batch 1A six URLs unchanged / representative non-target intent routes unchanged → then T0 (Europe/Tallinn).
`LIVE_FORM_SUBMISSION_EXECUTED=NO` — backend/endpoints/tracking untouched, so no test lead is warranted.

## Observation (after T0)
Freeze on target: CTA target, form order, CTA text, hero, form wording/fields, FAQ, sticky, micro-conversion, title, H1,
meta, schema, internal links. T+3–7 technical/conversion-path sanity · T+14 directional CRO + qualified owner review ·
T+21 primary gate if volume sufficient · low volume → `HOLD_FOR_MORE_DATA`.
**Primary KPI:** qualified ET owner valuation leads. Not QS, impressions, CTR, generic sessions or Audit leads.
Other clocks unaffected: Batch 1A T0 2026-09-17 15:39:20 EEST · RU Ocenka O1 T0 2026-09-20 19:56:16 EEST.

## Rollback
- **Target-contract rollback:** delete the two `price_analysis.et` keys → template defaults restore CTA→audit and
  audit-first; the shared optional mechanism stays inert for all pages.
- **Structural-regression rollback:** revert the whole commit `a4734b9` (correct response to any non-target page change).
Triggers: non-target intent render regression, RU O1 or Batch 1A regression, wrong canonical/indexability, broken anchor,
missing form, duplicate IDs, desktop/mobile structural failure, production ≠ approved diff. **Not** triggers: no leads for
a day, short-window traffic/ranking/Ads noise.

**ET_O2_STATUS = NOT_STARTED** (micro-conversion & sticky audit CTAs, valuation wording expectation, FAQ sequencing,
above-fold clarity, broker question on the valuation page, similar FAQ content — all remain frozen hypotheses).
