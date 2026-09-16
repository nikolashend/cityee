# BATCH 1A — IMPLEMENTATION LOG (RU homepage title de-confliction)

**Commit:** `b1e811e` — `config/cityee.php` `home.ru.meta_title` (1 file / +1 −1 / 1 semantic field).
**Old:** `Маклер в Таллинне — продажа и аренда недвижимости | CityEE`
**New:** `Продажа и аренда недвижимости в Таллинне и Харьюмаа | CityEE`
**Rollback value:** the Old string above (only that line).

## Pre-change production baseline — 2026-09-16 15:19:43 UTC (= 18:19:43 Europe/Tallinn, EEST)
| URL | HTTP | final | title | canonical | robots | H1 |
|---|---|---|---|---|---|---|
| /ru/ | 200 | same | Маклер в Таллинне — продажа и аренда недвижимости \| CityEE | https://cityee.ee/ru/ | none | Продажа недвижимости в Таллинне и Харьюмаа… |
| /ru/makler-v-tallinne/ | 200 | same | Профессиональный маклер и риелтор в Таллине \| 10+ лет, 300+ сделок \| CityEE | self | none | Профессиональный маклер и риелтор по… |
| /ru/tallinn/ | 200 | same | Продажа квартир в районах Таллина \| Маклер по районам \| CityEE | self | none | Продажа квартир в районах Таллина |
| /ru/prodat-kvartiru-v-tallinne/ | 200 | same | Продать квартиру в Таллине — стратегия 30–45 дней \| 2% комиссия \| CityEE | self | none | unchanged |
| /ru/ocenka-kvartiry-v-tallinne/ | 200 | same | Оценка квартиры в Таллине — реальный ценовой коридор \| CityEE | self | none | unchanged |
| /ru/agentstvo-nedvizhimosti-tallinn/ | 200 | same | Агентство недвижимости в Таллине — продажа, аренда, аудит \| CityEE | self | none | unchanged |
Baseline == forensic baseline → BASELINE_DRIFT=NO.

## Side effects
`og:title` is rendered from the same `@yield('title')` section → **EXPECTED_DERIVED_OUTPUT** (permitted).
Schema/JSON-LD does not read `meta_title` → no schema change. Config `home.ru.h1` is unused by the live
template (`pages/home.blade.php` hardcodes its H1) → untouched, no H1 change.

## Local verification (post-change, app kernel render)
/ru/: title = NEW ✓ · og:title = NEW (derived) ✓ · H1 unchanged ✓ · canonical https://cityee.ee/ru/ ✓ · robots none ✓.
Protected pages (makler, tallinn, prodat, ocenka, agentstvo): title/H1/canonical identical to baseline ✓.
Gates: `cityee:render-check` 44/44 · `seo:audit-intents` PASS · `seo:audit-links` PASS ·
SEO tests 15 passed/110 · `tests/js/lead-tracking.test.cjs` 50/50 (measurement untouched).
Diff forensics: FILES_CHANGED=1 · LINES_ADDED=1 · LINES_REMOVED=1 · SEMANTIC_FIELDS_CHANGED=1 ·
PROTECTED_FILES_CHANGED=0 · UNRELATED_CHANGES_INCLUDED=0.

## Deployment — OWNER_OR_OPERATOR_ACTION_REQUIRED
This environment has no production shell. Operator (Nikolai) deploys:
```
# local (if not yet pushed):  git push origin main
# production host:
git pull
php artisan optimize:clear      # config/view/route caches — REQUIRED, config is the changed file
# no migration, no seed, no other steps
```
Then verify live and report the confirmed-live timestamp (Europe/Tallinn):
```
curl -s -L https://cityee.ee/ru/ | grep -oE '<title>[^<]*</title>|rel="canonical"[^>]*'
curl -s -L https://cityee.ee/ru/makler-v-tallinne/ | grep -oE '<title>[^<]*</title>'
```
Expected: /ru/ title = NEW; canonical unchanged; makler title unchanged.

## T0 / observation
`BATCH_1A_T0` = confirmed production-live time (NOT commit/edit time) — **PENDING deploy**.
From T0: SEO freeze on /ru/, /ru/makler-v-tallinne/, /ru/tallinn/, /ru/agentstvo…, /ru/prodat…
and broker-family anchors. T+3–7 sanity only · T+14 directional · T+21 primary gate ·
low volume → HOLD_FOR_MORE_DATA. Batch 1B (/ru/tallinn/) DEFERRED / WATCH. ET deferred.
