# CITYEE — SEO Change Timeline (GIT forensic)

Read-only reconstruction from `git log` (dates = author date). `CORRELATION != CAUSATION`.

| date | commit | component/URL | change_type | possible_search_effect | correlation_w_GSC | causality | confidence |
|---|---|---|---|---|---|---|---|
| 2026-02-27 | 82a4cae | phase3 system | new RU landing architecture begins | new URLs enter index | before decline window | CORRELATED_ONLY | — |
| 2026-03-01 | 820e92a | phases 4-6 | expansion | more crawl paths | — | CORRELATED_ONLY | — |
| 2026-03-09/10 | c330b91, 19cb2c7, **8aae1b3** | `config/cityee-phase3.php`, `phase3-landing.blade.php` | **RU seller winners created** (makler, agentstvo, ocenka, prodat, ne-prodaetsya, audit, /tallinn hub) | winners begin ranking | winners' "previous" strong period | LIKELY the source of the winners themselves | STRONGLY_SUPPORTED |
| **2026-03-11** | **a3ea5c0** | `config/cityee.php:585` | **RU homepage `meta_title` → "Маклер в Таллинне — продажа и аренда…"** | homepage competes for broker query | same week as makler page | **LIKELY_CAUSAL for RC-02 cannibalization** | STRONGLY_SUPPORTED |
| 2026-03-17 | 50da00b | layout/templates | "Phase 1-4 hardening: entity, linking, geo, schema" | internal-link/authority redistribution | within build window | POSSIBLY_CAUSAL | PLAUSIBLE |
| 2026-03-23 | 31f09f0 | robots/sitemap/footer | "GSC hardening" (dashboard noindex, sitemap trims, footer ET/EN) | crawl focus change | — | UNLIKELY_CAUSAL for winner rank | WEAK |
| 2026-07-20/27 | 33b8bc4, 813333b | `config/search_intents.php`, `seo_protected_assets.php`, audit gates | registries + **cannibalization gate added** | gate has homepage/hub **blind spot** (only checks registry primaries) | after winners live | explains why cannibalization passed CI | STRONGLY_SUPPORTED (blind spot) |
| 2026-07-28..08-05 | e24f19e, 17cc665, … | attribution/analytics, guide fixes | non-SEO measurement work | none on rankings | — | UNLIKELY_CAUSAL | — |

**Key inflection:** 2026-03-09..11 — specialist makler page and a broker-targeting homepage title
were introduced together. The registry codifying single ownership came **later** (July) and its gate
cannot see homepage/hub competition. Precise ranking-loss date = `INSUFFICIENT_DATA` (needs GSC daily).
Temporal match to the homepage retitle: `WEAK_TEMPORAL_MATCH` until GSC daily/Query→Page is supplied.
