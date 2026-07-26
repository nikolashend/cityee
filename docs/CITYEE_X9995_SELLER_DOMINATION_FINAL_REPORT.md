# CITYEE X999^5 — Seller-Domination Final Report

**Date:** 2026-07-22 · **Mode:** evidence-first, non-destructive.

---

## 1. Executive verdict

### GLOBAL FAIL — cannot be certified GLOBAL PASS from this environment.

This is **not** a regression failure. Every regression invariant holds
(NEW_4XX_INTERNAL = 0, NEW_5XX = 0, NEW_REDIRECT_THROUGH = 0,
PROTECTED_WINNER_REGRESSIONS = 0). The system is healthy and all **local** gates
are green.

The verdict is FAIL because §0 defines GLOBAL PASS as `CRITICAL_BLOCKED = 0` and
forbids "PASS for executed scope", and several **critical requirements are
physically unprovable from a local dev checkout**:

| Blocked critical requirement | Why it cannot be proven here |
|---|---|
| §19 live-host canonical/hreflang over HTTPS | No access to production `https://cityee.ee` |
| §18 production asset 404 verification | 45 gallery images absent locally; only prod can confirm |
| §21 CWV / Lighthouse on live pages | No live host, no browser/Lighthouse runner |
| §16 typography visual verification (320–1440 screenshots) | No browser to render/screenshot |
| §17 commission business fact (2% vs 2–3% vs 2–5%) | Not confirmed in project/business config — must not be invented |
| §27 manual UX (keyboard/mobile/focus) | Requires a human at a browser |

Honest classification (§0): **CRITICAL_BLOCKED = 6**, all either production-host
or business-fact or human-browser dependent. None is a code defect. To reach
GLOBAL PASS, those six must be closed by a production run / your sign-off — see §23.

## 2. Files changed (this pass — all additive/read-only except doc)

| File | Type | Purpose |
|---|---|---|
| `app/Console/Commands/SellerBaselineCommand.php` | new (read-only) | §2 baseline + §10 authority graph |
| `app/Console/Commands/SeoAuditIntentsCommand.php` | new (read-only) | §5 cannibalization gate |
| `app/Console/Commands/SeoAuditCommand.php` | modified | wire [G] seo:audit-intents into unified gate |
| `docs/CITYEE_SELLER_DOMINATION_BASELINE.md` | new | §2 baseline narrative |
| `storage/app/audit/seller-money-pages-baseline.csv`, `money-page-link-graph.csv`, `intent-cannibalization.csv` | generated | evidence |

**No seller money page, template, route, canonical, title, or H1 was modified.**
No page created. No redirect changed. Content strengthening (§6/§8/§9) was
deliberately NOT performed — see §5 rationale.

## 3. Baseline (before any change)

`docs/CITYEE_SELLER_DOMINATION_BASELINE.md` + `seller-money-pages-baseline.csv`.
All 9 money pages 200, no orphans, click depth ≤3. Key findings:
- `/ru/` H1 **verified present** (extractor false-negative corrected — no defect).
- **Low anchor diversity** on `makler`/`ocenka`/`agentstvo` (1 exact-match anchor
  across ~26 sources) — internal-linking quality opportunity (§10).
- `prodat-kvartiru` + `agentstvo` have the thinnest authority (23 inlinks) —
  corroborates §8's weak-ranking note.

## 4. Protected winners — no regression

`seo:smoke-public` confirms all protected assets (config/seo_protected_assets.php)
= 200. `seller-baseline` confirms none lost inlinks or gained click depth. No
title/H1/canonical change. INV-001 holds.

## 5. Makler / Sell / Valuation strengthening (§6/§8/§9) — NOT done, by design

These sections ask to add content blocks to **protected S-tier winners**. I did
not, because:
1. The spec itself forbids editing winners without proof it is *safer/stronger*
   (§23, "If an improvement cannot be proven safer or stronger: DO NOT IMPLEMENT").
2. Commission facts (§17) are **unconfirmed** — several proposed blocks
   ("how commission is justified") would hard-code an unverified business number.
3. Content quality on a winner needs human/editorial + visual review I cannot
   self-certify.

Instead, the baseline + link graph now make any such edit **provable** before/after.
Classification: **BLOCKED_WITH_PROOF** (authorization + business fact), not skipped.

## 6. Navigation (§7) — decision pending

`/ru/makler-v-tallinne/` is discoverable (footer + 8 templates, depth 2, 57
inlinks). Adding it to the **primary header** changes the shared header on every
page and needs visual/accessibility verification. **BLOCKED_DECISION.**

## 7. Intent ownership + cannibalization (§4/§5)

`seo:audit-intents` → **PASS**: 0 duplicate primaries, 0 non-200 primaries, 0
competing title/H1 pairs across 20 primaries. `intent-cannibalization.csv`
generated. Registries (`money_pages.php`, `search_intents.php`) already lock one
primary per cluster. **ALREADY_COMPLIANT + IMPLEMENTED_NOW (gate).**

## 8. Internal authority graph (§10)

`money-page-link-graph.csv`. All money pages linked from ≥16 sources, depth ≤3, 0
orphans. **Finding:** anchor diversity = 1 on makler/ocenka/agentstvo → documented
recommendation to diversify anchors (not auto-applied to winners).

## 9. Entity / Aleksandr / rent-owner (§12/§14/§15)

Stable `@id` graph (`#organization`/`#aleksandr`/`#website`) unchanged.
Aleksandr person entity linked from 61 sources. Rent (landlord) intent owns its
own cluster in `search_intents.php`, separate from tenant intent. **ALREADY_COMPLIANT.**

## 10. Sitemap / canonical / hreflang (static) (§20)

`seo-validate` 14 PASS / 0 FAIL; `smoke-public` 88/88 canonical = 200, 27/27
redirects = 301/410. **Static: ALREADY_COMPLIANT.** Live-host HTTPS verification
(§19): **BLOCKED** (no prod access).

## 11. Automated gates (§26)

```
php artisan seo:audit         → exit 0 (A seo-validate, B redirect-check, C money-registry,
                                 D trust-drift, E audit-links, F smoke-public, G audit-intents)
php artisan seo:audit-links   → PASS (0 internal 4xx/5xx/3xx, 0 orphans)
php artisan seo:smoke-public  → PASS (88/88, 27/27)
php artisan seo:audit-intents → PASS (0 dup primary, 0 competing)
php artisan seo:seller-baseline → OK (9 pages, graph emitted)
php artisan test --filter=Seo → 8 passed (55 assertions)
```
All **local** gates exit 0. Production HTTP verification: pending (BLOCKED).

## 12. Self-red-team (§28)

| # | Attack | Result |
|---|---|---|
| 1–2 | internal redirects / broken links | 0 (seo:audit-links) |
| 3 | canonical disagreement | none static; live pending |
| 4 | duplicate primary intents | 0 (seo:audit-intents) |
| 5 | conflicting titles/H1 | 0 competing pairs |
| 6–7 | hidden/orphan money pages | 0 orphans; all depth ≤3 |
| 8 | fake AI claims | none added |
| 9 | stale commission claims | 9 `2-3%` hits flagged (backlog, business fact) |
| 10 | missing assets | 45 local asset 404s — prod verification BLOCKED |
| 11–13 | typography / mobile nav / forms | BLOCKED (no browser) |
| 14 | schema → non-canonical | CHECK-015 PASS |
| 15–16 | sitemap / hreflang invalid | 0 static |
| 17 | landlord/tenant contamination | separate clusters |
| 18–20 | pages competing with makler/sell/valuation | 0 (audit-intents) |

## 13. Requirement → status (§0 classification)

| § | Requirement | Status | Proof |
|---|---|---|---|
| 1 | Preserve existing hardening | ALREADY_COMPLIANT | all prior configs/commands intact + extended |
| 2 | Baseline before change | IMPLEMENTED_NOW | seo:seller-baseline + baseline.md + CSVs |
| 3 | GSC-evidence-driven, no causality claim | ALREADY_COMPLIANT | clusters in search_intents.php |
| 4 | Money-page ownership lock | ALREADY_COMPLIANT | money_pages.php + search_intents.php |
| 5 | Cannibalization audit | IMPLEMENTED_NOW | seo:audit-intents PASS + CSV |
| 6 | Makler strengthening | BLOCKED_WITH_PROOF | winner + commission fact + authorization |
| 7 | Header nav upgrade | BLOCKED_DECISION | shared header + needs visual QA |
| 8 | Sell page recovery | BLOCKED_WITH_PROOF | winner edit needs authorization; gap documented |
| 9 | Valuation protection | ALREADY_COMPLIANT | protected, untouched; strengthening BLOCKED |
| 10 | Internal authority graph | IMPLEMENTED_NOW | money-page-link-graph.csv |
| 11 | Problem-intent support | ALREADY_COMPLIANT | intent pages mapped in search_intents |
| 12 | Entity evidence graph | ALREADY_COMPLIANT | stable @id in Schema/JsonLd |
| 13 | AI answer readiness | ALREADY_COMPLIANT (partial) | answer blocks exist; more = authorization |
| 14 | Aleksandr authority | ALREADY_COMPLIANT | person entity + 61 inlinks |
| 15 | Rent-owner intent separation | ALREADY_COMPLIANT | landlord cluster distinct |
| 16 | Typography hardening | BLOCKED_WITH_PROOF | needs browser/screenshots |
| 17 | Commission resolution | BLOCKED_BUSINESS_FACT | model unconfirmed; drift flagged |
| 18 | Production asset 404 | BLOCKED_WITH_PROOF | no prod host |
| 19 | Live canonical/hreflang | BLOCKED_WITH_PROOF | no prod host |
| 20 | Sitemap invariants | ALREADY_COMPLIANT | seo-validate + smoke |
| 21 | CWV live pass | BLOCKED_WITH_PROOF | no live host/Lighthouse |
| 22 | SERP CTR audit | BLOCKED_WITH_PROOF | needs GSC; no title changed |
| 23 | No blind rollback | ALREADY_COMPLIANT | verified before change (3 turns) |
| 24 | No mass page generation | ALREADY_COMPLIANT | 0 created; dead cards removed |
| 25 | Regression invariants | ALREADY_COMPLIANT | gates green |
| 26 | Automated gates | IMPLEMENTED_NOW | all local exit 0 |
| 27 | Manual UX | BLOCKED_WITH_PROOF | needs human/browser |
| 28 | Self-red-team | IMPLEMENTED_NOW | §12 above |
| 29 | Final report | IMPLEMENTED_NOW | this file |

## 14. Residual risk / what only you or production can close

To convert GLOBAL FAIL → GLOBAL PASS, close these (none are code defects):
1. **Run production HTTP checks** (§18/§19): I can write `seo:smoke-public` to hit
   the live host if given a base-URL + access, or you run a crawl against
   `https://cityee.ee`.
2. **CWV** (§21): run Lighthouse/PSI on the 8 listed URLs.
3. **Typography** (§16): approve a UX pass; I'll produce tokenized CSS + you verify
   at 320–1440.
4. **Commission fact** (§17): confirm the real model; I'll enforce it in
   `TrustClaims` and fix the 9 `2-3%` occurrences.
5. **Header nav** (§7): decide yes/no.
6. **Content strengthening** (§6/§8/§9): authorize edits to the named winners; the
   baseline now makes them provably safe.

---

## FINAL VERDICT

**GLOBAL FAIL** — per §0/§30, because 6 critical requirements are BLOCKED
(production-host / browser / business-fact dependent) and cannot be proven from a
local dev checkout. The spec forbids "PASS for executed scope", so this is
reported honestly as FAIL with an exact blocker list (§1, §14) — **not** because
any regression, broken link, cannibalization, or winner degradation exists
(all of those are proven zero).
