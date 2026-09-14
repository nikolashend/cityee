# INTENT COLLISION GATE v2 — SPECIFICATION (design only, NOT implemented)

## Why v1 missed the collision
`seo:audit-intents` v1 compares **registered primaries against each other** (duplicate primary
ownership, competing title/H1 pairs among primaries). The `/ru/` homepage and `/ru/tallinn/` geo hub
are not registry primaries, so their titles claiming the MAKLER head term were never compared →
**PASS with a live collision**. Confirmed 2026-09-12 (`Competing title/H1 pairs: 0`).

## v2 comparison set (per query family)
For each family in `config/search_intents.php` (`primary` + `queries`), evaluate the primary against:
1. root homepage `/`
2. language homepages `/ru/`, `/en/` (and `/` as ET)
3. geo hubs (`/ru/tallinn/`, ET/EN equivalents; district children as a group)
4. service hubs / alternate services in the same language (e.g. agentstvo, konsultatsioon)
5. every other `seo_protected_assets.php` entry
6. the family's declared `supporting` URLs (allowed context — see false-positive rules)

## Signals (no naive exact-keyword matching)
- **Title overlap:** normalized head-term match (stem/lemma per language; RU ё/е folding: риелтор≡риэлтор;
  case-fold; strip brand suffix "| CityEE"). Score = fraction of the family's `queries` head terms
  present in the candidate `<title>` **as the leading phrase** (position-weighted: leading phrase ×1.0,
  mid-title ×0.5, trailing modifier ×0.25).
- **H1 overlap:** same, on rendered H1 (fetch the *rendered* page via the app, not config — v1 dead
  config `h1` keys must not count).
- **Declared-intent overlap:** candidate's own registry intent (if any) shares `seller_intent_class`
  with the family.
- **Route-role overlap:** candidate role ∈ {HOMEPAGE, LANG_HOMEPAGE, GEO_HUB, SERVICE_HUB} AND title
  overlap ≥ threshold.

## Verdict rules
- `COLLISION` if a non-primary, non-supporting URL has **leading-phrase title overlap ≥ 0.6** OR
  (title ≥ 0.4 AND H1 ≥ 0.4) for a tier-S family.
- `WARN` if 0.3 ≤ overlap < 0.6 on a hub/homepage.
- `OK` otherwise.
- **False-positive guards:** (a) declared `supporting` URLs are exempt from COLLISION (may WARN);
  (b) a trailing modifier mention (e.g. "…| Маклер по районам") scores ≤0.25 → WARN not COLLISION
  unless combined with H1 overlap; (c) brand queries excluded; (d) the family's own primary is never
  compared to itself; (e) cross-language titles are compared only within the same language.

## Output
`storage/app/audit/intent-collision-v2.csv`: family, primary, candidate_url, candidate_role,
title_overlap, h1_overlap, intent_overlap, verdict, evidence (matched tokens). Exit non-zero on any
COLLISION for tier-S families (fail-hard), zero on WARN.

## Expected result on today's production
- `broker_tallinn` vs `/ru/`: leading-phrase "Маклер в Таллинне" → title overlap ≈ 1.0 → **COLLISION**
  (this is the Batch 1A target; after 1A it drops to OK).
- `broker_tallinn` vs `/ru/tallinn/`: trailing "Маклер по районам" → ≈ 0.25, H1 no overlap → **WARN**.
- `valuation_tallinn` (ocenka) vs all: **OK** (control).
- Also add: an **ET broker family** is currently **absent** from the registry → gate should emit
  `MISSING_OWNER` for ET "kinnisvaramaakler tallinn" (root `/` de-facto owner) so ET planning is explicit.

## Non-goals
No production behavior change; no auto-fix; no title generation. Tooling + report only. Implement in
a separate, approved task.
