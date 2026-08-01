# CITYEE X999⁵ — Production Attribution Closure — Final Report

**Date:** 2026-08-01 · **Mode:** production-closure & proof. Additive, privacy-by-design,
revenue-safe. No winner URL/title/H1/canonical/hreflang/schema/CTA/nav/design changed.

---

## 1. Executive verdict

### GLOBAL FAIL — code-side hardening complete & tested; production live-QA, GA4/Ads, and 72h monitoring remain unproven.

Everything buildable + testable here is **done and green (36 tests / 183 assertions)**: the
attribution correctness fixes (synthetic-click-id exclusion, deterministic dedup `event_id`),
the read-only masked `leads:export`, the retention `leads:prune`, SQLite concurrency hardening,
privacy/retention policy, and CSV-injection/privacy tests. It is **GLOBAL FAIL** because §25
mandates *production-observed* proof I cannot obtain from here: **live form submissions on
`cityee.ee`, GA4 DebugView, Google Ads conversion/dedup diagnostics, 72h monitoring, and the
production DB/schema proof** (prod shell). Each is BLOCKED below with the exact operator command.

## 2. Production commit / deployment state
`git rev-parse HEAD` = `959a85c…` (this closure adds correctness/CLI/tests on top). The attribution
system (leads table + pipeline) was deployed and verified live in the prior phase (pages 200,
trailing-slash + Commit C live). This closure must be deployed the same way (`git pull` +
`migrate --force` for `2026_08_01_000001_add_lead_test_flag` + `optimize:clear`).

## 3. Pre-flight evidence
`storage/app/audit/attribution-closure-preflight.txt`: clean working tree; leads migration
`[Ran]`; SEO gates PASS; **36 tests pass**.

## 4–5. DB backup / migration / schema proof
- **Local schema proof (PRAGMA):** `leads` has all mandatory columns + 7 indexes
  (`duplicate_fingerprint`, `first/last_touch_source`, `form_type`, `public_id` unique,
  `mail_status`, `created_at`) + new `is_test` index. **PASS (local).**
- **Production proof — BLOCKED (needs prod shell).** Operator runs:
  ```bash
  cp database/database.sqlite backups/database-before-attribution-closure-$(date +%Y%m%d-%H%M%S).sqlite
  sha256sum database/database.sqlite
  php artisan migrate:status | grep leads          # both leads migrations [Ran]
  php artisan tinker --execute="foreach(DB::select('PRAGMA table_info(leads)') as \$c){echo \$c->name.' ';}"
  php artisan tinker --execute="echo 'guides '.App\Models\Guide::count().' audits '.App\Models\AreaAudit::count().' leads '.App\Models\Lead::count();"
  ```

## 6. Read-only lead export — **PASS (local)**
`php artisan leads:export` — CLI-only, private path `storage/app/private/exports`, masked email/phone
by default, `--include-pii` gated + audited (no PII in audit line), CSV formula-injection escaped
(`= + - @` → leading quote), filters (`--from/--to/--form-type/--source/--mail-status/--limit`),
UTF-8 BOM. No web route (INV-008). Tests: `test_export_masks_pii_by_default`,
`test_export_include_pii_flag_reveals_raw`, `test_export_escapes_csv_formula_injection`.

## 7. Four form pipelines — **PASS (local); production live-QA BLOCKED**
All 4 handlers (callback/inquiry/audit/price) use the save-before-mail pipeline; `test_all_four_form_types_create_leads`.

## 8. Live QA (§7–8 Scenarios A–G) — **BLOCKED (needs production submissions)**
Locally the equivalents are covered by tests (UTM/gclid preservation, internal nav, direct return,
duplicate, no-JS, mail-failure, consent). Production submission of the labelled test leads
(`CITYEE-ATTR-CLOSURE-…`) must be run by the operator + verified via `leads:export`.

## 9–10. Lead record + GA4 event
- Non-PII `generate_lead` payload: `lead_public_id`, **`event_id`** (HMAC dedup key), `form_type`,
  `submission_page`, `source_class`, `campaign_name`, `has_gclid`, `is_test`. No PII
  (`test_event_id_is_deterministic_and_non_pii`, `test_analytics_payload_has_no_pii`). GA4
  DebugView/Realtime verification — **BLOCKED (needs GA4 access)**.
- **Synthetic click-id exclusion (§8B/§21):** a test gclid (`CITYEE_TEST…`, `TEST-GCLID…`) sets
  `is_test=true`, the frontend **skips** `generate_lead`, so it can never be a real Ads conversion
  (`test_synthetic_gclid_is_flagged_test_and_suppresses_event`); a real gclid is not flagged.

## 11–13. Google Ads conversion architecture + dedup — **BLOCKED (needs Ads account)**
Contract in `docs/CITYEE_GOOGLE_ADS_CONVERSION_CONTRACT.md`: primary = `generate_lead` (count one),
dedup by `event_id`/`lead_public_id`, secondaries not bid-optimized. The **actual** current
architecture (GA4-import vs direct tag vs both) and the "≤1 primary conversion per lead" proof
require Google Ads/GA4 access → **BLOCKED** (not claimed PASS).

## 14. Consent & privacy — **PASS**
`docs/CITYEE_ATTRIBUTION_PRIVACY_AND_RETENTION_POLICY.md`. Lead persists regardless of consent;
`consent_state` stored; PII never in analytics/logs; IP hashed. `test_consent_denied_still_persists_lead`.

## 15. Retention / prune — **PASS**
`config/attribution.php` (`lead_retention_days=400`, `attribution_cookie_days=90`,
`prune_min_age_days=90`). `php artisan leads:prune` dry-run by default; `--execute` deletes only
past-retention, never recent, audited. Tests: `test_prune_dry_run_deletes_nothing`,
`test_prune_execute_deletes_only_old_leads`.

## 16. 72-hour monitoring — **BLOCKED (needs prod + elapsed time)**
`CITYEE_72H_PRODUCTION_MONITORING_LOG.md` skeleton; checkpoints NOT_RECORDED until run.

## 17. SQLite concurrency — **PASS (mitigation added)**
`config/database.php`: `busy_timeout=5000` (waits for a lock instead of "database is locked" under
concurrent writes); WAL is opt-in via `DB_JOURNAL_MODE` env only where the host FS supports it
(rollback = unset env). No DB migration performed. Lead is saved in a short transaction with mail
sent **after** commit (no network in transaction).

## 18. Security — **PASS (code)**
CSRF (web middleware; tokenless POST → 419), no mass assignment of `id` (guarded), attribution
params sanitized (strip HTML/`<>{}`, length-limited — `test_params_are_sanitized`), export path
`basename()` (no traversal), private export dir, CSV formula-injection escaped, no PII in logs.

## 19. SEO regression — **PASS**
`seo:audit-links` 0 broken/redirect/orphan; render 44/44; winners 200 + canonical/title/H1 unchanged
(`RevenueSafeClosureTest`). No winner URL/title/H1/canonical/hreflang/inlink/depth change.

## 20. Test suite — **PASS**
`php artisan test` → **36 passed / 183 assertions** (26 prior + 10 closure). New:
synthetic-id exclusion, real-gclid, event_id determinism/no-PII, export masking/PII/CSV-injection,
prune dry-run/execute, no-JS, consent persistence.

## 21. Red-team (selected; full attacks mapped to tests/code)
duplicate double-click → one lead [test]; synthetic GCLID → not sent as Ads [test]; oversized/script
UTM → sanitized [test]; CSV formula injection → escaped [test]; export path traversal → basename;
public lead access → no route; PII in analytics/logs → none [test+code]; raw IP → hashed [test];
direct overwrites first touch → prevented [test]; prune recent → safety floor [test]; prune without
execute → dry-run [test]; DB locked → busy_timeout mitigation. Live-only attacks (two Ads
conversions, GA4 DebugView, consent-denied event gating, 72h) → **BLOCKED** pending prod/Ads.

## 22. Production acceptance matrix
| Requirement | Production evidence | Result |
|---|---|---|
| Migration applied | migrate:status (prod) | **BLOCKED** (local: Ran) |
| Leads table + schema | PRAGMA (prod) | **BLOCKED** (local: PASS) |
| 4 forms save leads | live QA + export | **BLOCKED** (local: PASS) |
| First/last touch, UTM, GCLID | DB record (prod) | **BLOCKED** (local: PASS) |
| Mail sent | status + inbox | **BLOCKED** (local: pipeline PASS) |
| Duplicate collapsed | counts (prod) | **BLOCKED** (local: PASS) |
| GA4 generate_lead | DebugView | **BLOCKED** (payload: PASS) |
| Ads primary conversion + no double-count | Ads diagnostics | **BLOCKED** (event_id dedup: PASS) |
| No PII in analytics | payload | **PASS** |
| Synthetic id not a conversion | is_test suppression | **PASS** |
| Export privacy / CSV-injection | tests | **PASS** |
| Retention / prune safety | tests | **PASS** |
| SQLite concurrency | busy_timeout | **PASS** |
| 72h monitoring | log | **BLOCKED** |
| SEO unchanged | audits | **PASS** |
| All tests | 36/183 | **PASS** |

## 23. Rollback
Code: `git checkout` prior tag + remove the closure files. DB: the two migrations are additive —
**keep** the `leads`/`is_test` columns (never auto-drop; export before any restore). `busy_timeout`
= unset `DB_BUSY_TIMEOUT`. Independent of DB restore.

## 24. Historical four leads — **UNKNOWN (honestly proven)**
`storage/app/audit/historical-four-leads-attribution.csv` — the pre-change app stored no source
data; needs GA4+Ads exports. Per §25 this does not block technical PASS.

## 25. Remaining blockers (all production/analytics access)
1. Deploy this closure (migrate the `is_test` flag) + run §4-5 prod DB/schema proof.
2. Run §7-8 live form QA on production; verify via `leads:export`.
3. GA4 DebugView + Google Ads architecture/dedup audit (need account access).
4. Complete 72h monitoring.

## 26. Final verdict

**GLOBAL FAIL — one or more mandatory production attribution/analytics/monitoring invariants not
proven.** The code-side closure is complete, tested (36/183), privacy-by-design, concurrency-safe,
and revenue-safe; it is unproven only where production submissions, GA4/Google Ads access, or 72h
monitoring are required — each enumerated with its exact operator command. No PASS is claimed for
local scope.
