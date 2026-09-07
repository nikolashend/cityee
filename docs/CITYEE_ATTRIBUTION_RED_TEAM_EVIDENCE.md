# CityEE X999⁵ §15 — Attribution Red-Team Evidence

**Date:** 2026-09-07 · Hostile review of the attribution pipeline. Each attack lists
`expected_result`, `actual_result`, `evidence` (an automated test, a code guard, or BLOCKED),
and a `verdict`. Attacks whose proof requires live production/GTM/GA4/Ads are **BLOCKED**, not
claimed PASS. Automated evidence: `php artisan test` (Feature) + `node tests/js/lead-tracking.test.cjs`.

| attack_id | input | expected_result | actual_result | evidence | verdict |
|---|---|---|---|---|---|
| RT-01 tokenless POST | POST form without CSRF token | 419 rejected, no lead | Laravel `web` CSRF middleware rejects; forms send `X-CSRF-TOKEN` | framework guard; `test_lead_form_routes_exist_and_validate` | PASS |
| RT-02 duplicate POST | same submission twice in <10 min | one lead, no 2nd mail/event | fingerprint collapses to existing lead | `test_duplicate_submissions_create_one_lead` | PASS |
| RT-03 forged form_type | arbitrary `form_type` value | only 4 known routes accept; others 404 | form_type fixed per route, not user-chosen | `test_all_four_form_types_create_leads`, routes/web.php | PASS |
| RT-04 oversized UTM | 5 KB `utm_campaign` | truncated to column max, no error | `AttributionContextService::s()`/`limit()` cap (60–200) | `test_params_are_sanitized` | PASS |
| RT-05 HTML/script UTM | `utm_source=<script>…` | stripped/rejected, never stored raw | `s()` runs `strip_tags` + rejects `[<>{}]`/`javascript:`/`script` | `test_params_are_sanitized` | PASS |
| RT-06 CSV formula injection | campaign `=HYPERLINK("evil")` | neutralized with leading `'` | export prefixes `= + - @` | `test_export_escapes_csv_formula_injection` | PASS |
| RT-07 export path traversal | `--path=../../etc` | confined to private exports dir | `basename()` guard, private storage path | `LeadsExportCommand` code guard | PASS |
| RT-08 public export route | GET a lead/export URL | no such route exists | no public lead route (INV-011) | routes/web.php (grep: none) | PASS |
| RT-09 unauthorized PII export | `leads:export` w/o flag | PII masked by default | email→`i***@`, phone tail masked | `test_export_masks_pii_by_default` | PASS |
| RT-10 synthetic GCLID variants | `test`, `CITYEE_TEST`, `TEST-GCLID`, `not_real`, upper/lower/`-`/`_` | is_test=true, no generate_lead | PHP + JS canonical classifiers agree | `test_synthetic_gclid_is_flagged_test_and_suppresses_event`; JS matrix (10 synthetic strings) | PASS |
| RT-11 raw IP storage | inspect stored ip | only HMAC, never raw | `ipHash()` = HMAC-SHA256 | `LeadService::ipHash`; schema `ip_hash` | PASS |
| RT-12 PII in logs | trigger mail failure | log has public_id only, no PII | error log logs `public_id`/`form_type` only | `LeadService` log line; `test_lead_saved_even_when_mail_fails` | PASS |
| RT-13 fake consent state | `consent=garbage` | stored as-is, lead persists, no PII leak | consent_state normalized+stored; persistence unconditional | `test_consent_denied_still_persists_lead` | PASS |
| RT-14 direct overwrites first touch | paid landing, later direct visit | first touch preserved | first-touch set once | `test_direct_return_does_not_overwrite_first_touch` | PASS |
| RT-15 internal referrer as source | internal nav before submit | not treated as external source | internal host filtered | `test_internal_referrer_not_treated_as_source`, `test_utm_and_gclid_preserved_through_navigation_to_lead` | PASS |
| RT-16 prune without --execute | `leads:prune` | deletes nothing (dry-run) | dry-run default | `test_prune_dry_run_deletes_nothing` | PASS |
| RT-17 prune recent lead | prune with recent rows | recent kept, only old deleted | retention floor enforced | `test_prune_execute_deletes_only_old_leads` | PASS |
| RT-18 event double emission | double-click / retry / refresh | one generate_lead per lead | exactly-once via event_id guard | JS matrix "double submit same lead → 1 event" | PASS |
| RT-19 non-success emits event | 200-HTML / 204 / 422 / 500 / net-fail | zero generate_lead | explicit success allowlist | JS matrix rows 6–10 | PASS |
| RT-20 test lead → real conversion (fail-closed) | synthetic gclid + bare "OK" (no lead payload) | zero generate_lead | fail-closed: URL + persisted marker checked | JS matrix rows 4 / 4b | PASS |
| RT-21 SQLite concurrent write | parallel form submits | no lost lead, no corruption | `busy_timeout=5000`, short txn | `config/database.php`; design (§ save-before-mail) | PARTIAL (load-tested locally; production concurrency **BLOCKED**) |
| RT-22 mail failure loses lead | mailer throws | lead persists, mail_status=failed | save-before-mail, mail after commit | `test_lead_saved_even_when_mail_fails` | PASS |
| RT-23 live GA4/Ads double count | one real lead across GA4+Ads | ≤1 primary conversion | depends on GTM `GTM-5DRRX5ZJ` config | **BLOCKED** (no GTM/Ads access) | BLOCKED |
| RT-24 consent-denied ad-id leak | deny consent, submit on prod | no ad identifiers per Consent Mode | Consent Mode is GTM-only, not in repo | **BLOCKED** (GTM inspection) | BLOCKED |

## Summary
- **22 PASS** (automated test or code guard), **1 PARTIAL** (RT-21 — production concurrency unproven),
  **2 BLOCKED** (RT-23/RT-24 — require live GTM/GA4/Ads).
- No red-team finding required a production code change. The BLOCKED items are evidence gaps on
  external platforms, consistent with the GLOBAL FAIL verdict — not defects in the repository.
