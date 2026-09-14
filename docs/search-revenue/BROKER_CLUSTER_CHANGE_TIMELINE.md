# BROKER CLUSTER CHANGE TIMELINE (extends `docs/CITYEE_SEO_CHANGE_TIMELINE.md`)

Source: `git log`/`git show` (DIRECT_GIT_HISTORY) + production (DIRECT_PRODUCTION 2026-09-12/14).

| date | commit | URL | field | before | after | intended reason | possible query impact | GSC behavior after | confidence |
|---|---|---|---|---|---|---|---|---|---|
| 2026-03-09/10 | c330b91, 19cb2c7, **8aae1b3** | `/ru/makler-v-tallinne/` | route + title + H1 + body (created) | — (did not exist) | title "Профессиональный маклер и риелтор в Таллине \| 10+ лет, 300+ сделок"; H1 "Профессиональный маклер и риелтор по прода…" | Phase 3 seller specialist | becomes MAKLER/RIELTOR owner | strong prev-period (pos ~7.6–7.8) | HIGH |
| **2026-03-11** | **a3ea5c0** | `/ru/` | **`meta_title` (ADDED)** + config `h1` (ADDED, unused by live template) | no RU homepage `meta_title` key in this block | **"Маклер в Таллинне — продажа и аренда недвижимости \| CityEE"** | "SEO meta" pass (commit msg) | homepage now claims MAKLER head term → competes with specialist | MAKLER pos 7.75→10.69 with impr flat (owner-stated) | HIGH (git) / MEDIUM (effect) |
| 2026-03-10 | 8aae1b3 | `/ru/tallinn/` | title + H1 (created) | — | title "Продажа квартир в районах Таллина \| Маклер по районам"; H1 "Продажа квартир в районах Таллина" (`cityee-phase3.php:510-512`) | geo hub | secondary MAKLER competitor; geo/buyer mix | pos 15.9→22.4, impr up (subtree) | MEDIUM |
| 2026-03-10 | 8aae1b3 | `/ru/agentstvo-nedvizhimosti-tallinn/` | title (created) | — | "Агентство недвижимости в Таллине — продажа, аренда, аудит" | agency page | broad; minor overlap | no rows supplied | LOW |
| 2026-03-17 | 50da00b | sitewide | internal links/entity/schema | — | + service-crosslinks, silo-related, knowledge-crosslinks (12 anchors → makler) | authority hardening | reinforces makler ownership (anchors are broker-specific) | — | MEDIUM |
| 2026-03-23 | 31f09f0 | `/locations/*` | sitemap/redirects | ET "Kinnisvaramaakler Tallinnas" locations page | `/locations/tallinn/` → **301 → `/ru/tallinn/`** (live today) | GSC hardening; locations deprecated | removes ET specialist; root `/` sole ET broker owner | ET maakler weakening (owner-stated, unquantified) | MEDIUM |
| 2026-07-20/27 | 33b8bc4, 813333b | registries + `seo:audit-intents` | new | — | `search_intents.php` declares makler as sole broker primary; gate compares **registry primaries only** | regression safety | gate blind to homepage/hub titles → collision passes CI | — | HIGH |
| 2026-09-12 | — | `/` (root) | production check | — | `lang=et`, x-default → `/`, **0 Cyrillic** broker terms | — | root's RU impressions = x-default/entity, not text | RIELTOR/YO supporting | HIGH |

**Inflection candidate:** 2026-03-11 (homepage title added) — `WEAK_TEMPORAL_MATCH` until GSC daily
data; MAKLER loss is measured only at 3M-vs-3M granularity.
**Production/repository drift:** none on live signals (title == config; H1 == `home.blade.php`).
The config `h1` "МАКЛЕР ПО НЕДВИЖИМОСТИ В ТАЛЛИННЕ" is **dead config** (live template hardcodes its H1) — not drift, but note it so a future template change doesn't silently activate a broker H1 on `/ru/`.
