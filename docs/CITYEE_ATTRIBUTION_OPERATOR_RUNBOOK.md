# CityEE — Attribution Operator Runbook (X999^5 §18)

All commands are read-only or additive. **Never** run `migrate:fresh`, `db:seed --force`,
`db:wipe`, or `git clean -x` on production — they destroy the SQLite lead store.

## 0. Pre-deploy (once)
```bash
cp database/database.sqlite database/backups/database.$(date +%F).sqlite   # backup FIRST
git pull
php artisan migrate --force        # additive: create_leads_table, add_lead_test_flag
php artisan optimize:clear
```

## 1. Verify schema is live (production proof — §5)
```bash
php artisan tinker --execute="echo \Schema::hasTable('leads')?'leads OK':'MISSING';"
php artisan tinker --execute="echo \Schema::hasColumn('leads','is_test')?'is_test OK':'MISSING';"
```

## 2. Revenue snapshot (no PII)
```bash
php artisan leads:summary                       # last 30 days, tables
php artisan leads:summary --from=2026-07-01 --exclude-test --json
```

## 3. Export for a spreadsheet (PII masked by default)
```bash
php artisan leads:export                         # masked → storage/app/private/exports
php artisan leads:export --include-pii            # raw, audited — only when legally needed
```

## 4. Retention prune (dry-run first)
```bash
php artisan leads:prune                           # dry-run: shows what WOULD delete
php artisan leads:prune --execute                 # actually delete leads older than retention floor
```

## 5. Live form QA (fills docs/production-form-qa-results.csv)
Submit each form on the live site, then confirm in `leads:summary` + info@cityee.ee inbox:
- callback, inquiry, audit-request, price-calculator → one lead each, one email each.
- `?gclid=CITYEE_TEST_GCLID_NOT_REAL` first → that lead must show `is_test=1`, no GA4 event.
- Submit the same form twice within 10 min → only ONE lead (dedup).

## 6. GA4 / Google Ads (in GTM `GTM-5DRRX5ZJ`, GA4, Ads — not in repo)
See `docs/ga4-production-lead-proof.md` and `docs/google-ads-conversion-inventory.csv`.
