# CityEE Seller-Domination Baseline (X999^5 §2)

**Date:** 2026-07-22 · **Source:** `php artisan seo:seller-baseline` (read-only kernel render + full internal crawl of 89 canonical seeds).
**Machine-readable:** `storage/app/audit/seller-money-pages-baseline.csv`, `storage/app/audit/money-page-link-graph.csv`.

This baseline is captured **before any seller-money-page edit**, so any future change is provable before/after. No page was modified to produce it.

## Money-page snapshot

| # | URL | Status | H1 | Word count | Inlinks | Unique sources | Anchor diversity | Click depth |
|---|---|---|---|---|---|---|---|---|
| 1 | `/` (ET home) | 200 | present | high | 110 | 29 | 2 | 0 |
| 2 | `/ru/` | 200 | present (extractor false-neg) | high | 129 | 29 | 2 | 1 |
| 3 | `/ru/makler-v-tallinne/` | 200 | present | — | 57 | 26 | **1** ⚠ | 2 |
| 4 | `/ru/prodat-kvartiru-v-tallinne/` | 200 | present | — | **23** | 17 | 2 | 2 |
| 5 | `/ru/ocenka-kvartiry-v-tallinne/` | 200 | present | — | 56 | 26 | **1** ⚠ | 2 |
| 6 | `/ru/kinnisvara-uur/` (rent) | 200 | present | — | 107 | 28 | 7 | 2 |
| 7 | `/ru/agentstvo-nedvizhimosti-tallinn/` | 200 | present | — | **23** | 16 | **1** ⚠ | 3 |
| 8 | `/ru/aleksandr-primakov/` | 200 | present | — | 61 | 28 | 5 | 2 |
| 9 | `/ru/tallinn/` | 200 | present | — | 56 | 26 | 2 | 2 |

Full per-page fields (canonical, meta robots, title, meta description, schema types, hreflang count, outgoing links) are in the CSV.

## Observations (evidence, not yet actioned)

1. **RU homepage `/ru/` H1 — verified present** (`pages/ru/home.blade.php:17`: "Желаете купить или продать / сдать в аренду Вашу недвижимость?"). The baseline extractor's "not detected" was a **false-negative** (checked and corrected — no defect). Minor content note: this H1 mixes buy/sell/rent intent; a seller-first H1 would be more owner-aligned, but that is a discretionary content decision on a protected winner, not a fix.
2. **Low anchor diversity on 3 S-tier winners** — `makler`, `ocenka`, `agentstvo` each receive ~26/16 inbound links but with a **single** exact-match anchor. §10 recommends natural anchor variation; heavy exact-match sitewide is the pattern to avoid. This is an internal-linking *quality* opportunity, not a broken state.
3. **Thinner authority on `prodat-kvartiru` and `agentstvo`** (23 inlinks each; `agentstvo` at click depth 3). Corroborates §8's note that `/ru/prodat-kvartiru-v-tallinne/` ranks weakly despite strong query relevance — its internal authority is the lightest of the sell cluster.
4. **No orphans, no depth>3** — every money page is discoverable; INV-011/012 hold at baseline.

## How to use

Re-run `php artisan seo:seller-baseline` after any seller-page change and diff the CSV to prove: inlinks not reduced, click depth not increased, title/H1/canonical unchanged on protected winners (INV-001), word count changes are additive.
