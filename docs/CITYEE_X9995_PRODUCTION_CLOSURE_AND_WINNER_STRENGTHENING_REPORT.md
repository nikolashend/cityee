# CITYEE X999⁵ — Production Closure & Winner Strengthening Report

**Date:** 2026-07-28 · **Mode:** evidence-first, production-verified against `https://cityee.ee`.

---

## 1. Executive verdict

### GLOBAL FAIL — production is stabilised, but strengthening scope + one technical invariant remain open.

This phase resolved a **production emergency** (24 pages returning HTTP 500 + garbled
Cyrillic) and fixed the guide/audit UX. Those are done and production-verified. However,
per the strict §21 Definition of Done, GLOBAL PASS requires **all** of: zero internal
redirect links, completed winner content strengthening, anchor-diversity targets met,
agentstvo click-depth ≤2, Lighthouse/CWV, systematic visual QA, and the new test suite.
Several of those are **not done**, and production still has **234 internal links passing
through a 301** (INV-002 `internal_redirect_links = 0` not met). Therefore: **GLOBAL FAIL**,
reported honestly — not because of regression (there is none), but because mandatory scope
is incomplete.

**What changed since the previous report:** the guide/audit **500s are gone** (24 → 0),
Cyrillic renders correctly, commission is unified, and the guide/audit design is fixed.

## 2. Scope actually executed

| Area | Status |
|---|---|
| Production 500 root-cause + fix (guides/audits) | **PASS** |
| Cyrillic mojibake fix (seeder source was double-encoded) | **PASS** |
| Commission unification → single source (§2/§17) | **PASS** |
| Production HTTP audit tool (§5) | **PASS** |
| Production asset verification (§6) | **PASS** |
| Guide/audit detail UX (hero overlap, typography, FAQ, breadcrumb, filter) | **PASS** |
| Winner content strengthening (§9–§12) | **FAIL (not done)** |
| Anchor-diversity targets (§8) | **FAIL (not done)** |
| Nav seller mega-menu (§7) | **NOT DONE** |
| Typography sitewide token layer (§13) | **PARTIAL** |
| Lighthouse / CWV (§15) | **BLOCKED (no runner)** |
| Systematic multi-viewport visual QA (§14) | **PARTIAL (ad-hoc via screenshots)** |
| New automated test suite (§18) | **NOT DONE** |

## 3. Assumptions & 4. Business facts used

- **Commission (§2):** standard **2%**, minimum **€2000**, "final terms depend on the
  property and agreed scope." Encoded in `config/trust_claims.php`.
- Production runs on **SQLite** (`DB_CONNECTION=sqlite`), same as local — confirmed via the
  `db:seed` diagnostics. No MySQL charset layer involved.

## 5. Files changed (this whole effort)

| File | Purpose |
|---|---|
| `database/seeders/DatabaseSeeder.php` | guard test-user seed to local/testing (faker is dev-only → crashed prod `db:seed`) |
| `database/seeders/GuideAndAuditSeeder.php` | **repaired double-encoded UTF-8** (mojibake source); creates the strategic guides/audits |
| `config/trust_claims.php`, `app/Support/TrustClaims.php` | commission → 2% / €2000 single source + `commissionMinimumEur()` |
| `resources/views/partials/ai-summary.blade.php`, `pages/profile.blade.php`, `pages/{et,ru}/konsultatsioon.blade.php`, `config/cityee.php` | reconciled 9× `2-3%` + consultation `2-3%` → registry `2%` |
| `resources/views/pages/guides/show.blade.php`, `audits/show.blade.php` | FAQ markup → home's clean accordion; (earlier) removed dead cards |
| `resources/views/pages/guides/index.blade.php` | client-side category filter (data attrs + JS) |
| `resources/views/layouts/app.blade.php` | CSS cache-version bumps (`v=5`); removed a conflicting global FAQ script |
| `public/assets/css/cityee-phase5-6.css` | guide/audit detail CSS: hero header-clearance, `.guide-intro`/howto/meta, audit content classes, breadcrumb, active-pill text, duplicate-icon hide, font bumps |
| `app/Console/Commands/SeoAuditProductionCommand.php` | new — live production HTTPS crawl |

**Routes changed:** none. **Winner URLs / titles / H1 / canonicals:** unchanged (INV-001 PASS).

## 6. Before/after winner table (seller-baseline)

No winner content or links were modified, so authority is **preserved, not reduced**
(INV-003 PASS) — but the strengthening targets were **not** applied.

| Winner | Status | Inlinks | Unique sources | Anchor diversity | Click depth |
|---|---|---|---|---|---|
| `/ru/makler-v-tallinne/` | 200 | 57 | 26 | **1** (target ≥5 ✗) | 2 |
| `/ru/prodat-kvartiru-v-tallinne/` | 200 | 23 (target ≥25 ✗) | 17 | 2 | 2 |
| `/ru/ocenka-kvartiry-v-tallinne/` | 200 | 56 | 26 | **1** (target ≥5 ✗) | 2 |
| `/ru/agentstvo-nedvizhimosti-tallinn/` | 200 | 23 | 16 | **1** (target ≥4 ✗) | **3** (target ≤2 ✗) |
| `/ru/kinnisvara-uur/` | 200 | 107 | 28 | 7 | 2 |
| `/ru/aleksandr-primakov/` | 200 | 61 | 28 | 5 | 2 |
| `/ru/tallinn/` | 200 | 56 | 26 | 2 | 2 |

## 7. Trust-claim consistency (§2/§17) — **PASS**

`seo:audit` [D] drift scan = **0 hits** (was 9 × `2-3%`). Single source of truth in
`config/trust_claims.php`; all displayed commission text now resolves to **2% / €2000**.

## 8. Production HTTP results (§5) — verified `https://cityee.ee`

| Metric | Result | Verdict |
|---|---|---|
| Guide/audit detail pages 200 (were 500) | **24 → 0 failures** | **PASS** |
| Canonical tag → non-200 | 0 | **PASS** |
| Canonical URLs (trailing-slash) return 200 | verified by direct curl | **PASS** |
| Hreflang targets (trailing-slash) return 200 | verified by direct curl | **PASS** |
| Mixed content | 0 | **PASS** |
| Internal links → 5xx | 0 | **PASS** |
| Rendered assets → 4xx/5xx | **0** | **PASS** |
| **Internal links → 3xx (redirect-through)** | **234** | **FAIL (INV-002/003)** |

**Tool note (honesty):** `seo:audit-production` raw output showed "10 canonical / 30 hreflang
non-200"; those are **false positives** — the tool caches status slash-insensitively and
conflated non-slash `/x` (301) with the real canonical `/x/` (200). Direct `curl` on the
trailing-slash canonicals (`/kontaktid/`, `/ru/guides/`, `/ru/makler-v-tallinne/`, `/ru/`,
`/ru/guides/real-price-corridor/`) all return **200**. The tool's cache needs a
slash-distinct key (follow-up).

## 9. The one real production defect — 234 internal links → 301

`route()`/`url()` emit **non-trailing-slash** URLs; production nginx **enforces** a trailing
slash and 301s. So internal links traverse one redirect. Benign (one hop, target 200) but it
violates `internal_redirect_links = 0`. **Fix options** (decision needed): (a) make link
generation emit trailing slashes; (b) drop the nginx slash-redirect and rely on canonical;
(c) switch the canonical policy to non-slash. This is the trailing-slash decision still open
from the first report.

## 10. Asset verification (§6) — **PASS**

Live crawl probed every rendered `<img>`: **0 broken on production**. The "45 asset 404s"
seen locally were **LOCAL_ONLY_ABSENCE** — the gallery images exist and serve on prod.

## 11. Structured data (§16) — **PARTIAL**

Stable `@id` graph (`#organization`/`#website`/`#aleksandr`) intact; no schema changed. Google
Rich Results Test / schema.org validator (external tools) **not run** → BLOCKED for formal sign-off.

## 12. Guide/audit UX fixes (this phase) — **PASS**

Root cause: these pages were 500 until seeded, so their styling was never exercised. Fixed:
fixed-header overlap on detail hero; unstyled `.guide-intro`/`.guide-howto-list`/meta +
audit `.audit-summary`/`.audit-section__body`/`.audit-market-data`; FAQ accordion (unified to
the home mechanism — a global handler I first added **broke home's FAQ** and was reverted);
breadcrumb (was a vertical numbered list → horizontal); category filter (was killed by the
`?category` query-strip redirect → now client-side JS); duplicate AI-summary robot icon; and
font bumps. All CSS additive, cache-versioned (`?v=5`).

## 13. Automated tests (§18)

Existing `SeoIndexationTest` → **8 passed / 55 assertions**. `seo:audit` (A–G), `seo:audit-links`
(0 broken / 0 orphans), `seo:audit-intents` (0 cannibalisation) all **PASS** locally. The new
mandated test classes (ProtectedWinnerTest, AnchorDiversityTest, ProductionCanonicalTest, …)
are **not written** → NOT DONE.

## 14. Lighthouse / CWV (§15) / Visual QA (§14) / Forms (§17)

- **CWV/Lighthouse:** BLOCKED — no Lighthouse runner in this environment. (Can run via PSI API
  or hand off.)
- **Visual QA:** PARTIAL — verified ad-hoc via user screenshots at desktop widths across several
  iterations; not the full 9-viewport matrix.
- **Forms/analytics QA:** NOT DONE this phase.

## 15. Red-team attacks

| Attack | Result |
|---|---|
| internal links → 4xx / 5xx | 0 (local + prod) |
| internal links → 3xx | **234 on prod** (trailing slash) — flagged, not hidden |
| duplicate primary intent | 0 (`seo:audit-intents`) |
| broken assets on prod | 0 |
| conflicting commission | 0 (drift scan) |
| guide/audit 500 on prod | 0 (resolved) |
| Cyrillic corruption | 0 (seeder repaired) |
| home FAQ regression I introduced | caught + reverted |

## 16. Rollback plan

All changes additive/reversible. Rollback = `git revert` of the listed commits + re-run
`php artisan db:seed --class=GuideAndAuditSeeder --force` (idempotent). No winner URL/route
changed. `database/database.sqlite` should be **untracked** from git (`git rm --cached`) so a
future `git pull` cannot overwrite production data again — **open risk**.

## 17. Requirement → status matrix (§21 DoD)

| DoD criterion | Status |
|---|---|
| LOCAL_CRITICAL_ERRORS = 0 | **PASS** |
| PRODUCTION_CRITICAL_ERRORS = 0 | **FAIL** (234 internal→301) |
| BROKEN_INTERNAL_LINKS = 0 | **PASS** |
| INTERNAL_REDIRECT_LINKS = 0 | **FAIL** (234) |
| ORPHAN_INDEXABLE_PAGES = 0 | **PASS** |
| DUPLICATE_PRIMARY_INTENTS = 0 | **PASS** |
| WINNER_REGRESSIONS = 0 | **PASS** |
| CONFLICTING_TRUST_CLAIMS = 0 | **PASS** |
| RENDERED_MISSING_ASSETS = 0 | **PASS** |
| HREFLANG_CRITICAL_ERRORS = 0 | **PASS** (verified 200) |
| CANONICAL_CRITICAL_ERRORS = 0 | **PASS** (verified 200) |
| FORM_CRITICAL_ERRORS = 0 | **BLOCKED** (not tested) |
| makler anchor diversity ≥ 5 | **FAIL** (1) |
| ocenka anchor diversity ≥ 5 | **FAIL** (1) |
| agentstvo anchor diversity ≥ 4 | **FAIL** (1) |
| agentstvo click depth ≤ 2 | **FAIL** (3) |
| prodat-kvartiru authority increased | **FAIL** (unchanged, 23) |
| all key pages visually verified | **PARTIAL** |
| all key pages production-tested | **PASS** |
| all factual claims unified | **PASS** |

## 18. Remaining risks / next actions

1. **Trailing-slash → 234 internal 301s** — pick option (a/b/c) in §9; I implement it.
2. **Winner strengthening (§8–§12)** — anchor diversity, prodat inlinks, agentstvo depth,
   makler/valuation content. Not started; ready once you approve editing winner pages.
3. **`database/database.sqlite` tracked in git** — untrack it (`git rm --cached`).
4. **Lighthouse/CWV** — run via PSI or hand off.
5. **New test suite (§18)** — write the mandated tests to lock invariants.

---

## FINAL VERDICT

**GLOBAL FAIL** — one or more mandatory invariants not proven.

Production is **stable and correct** (500s resolved, Cyrillic fixed, assets clean, commission
unified, canonical/hreflang verified 200, guide/audit UX fixed, no regression). But per §21 the
task is not closed: **234 internal redirect links** on production, and the **winner-strengthening,
anchor-diversity, agentstvo-depth, Lighthouse, visual-QA and test-suite** requirements are **not
done**. These are enumerated above with exact status — none is hidden.
