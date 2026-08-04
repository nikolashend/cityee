# CityEE — Attribution Rollback Runbook (X999^5 §18)

The attribution system is **save-before-mail** and **additive-only**: leads persist independently
of analytics, and no existing column/route/form was removed. Rollback is therefore low-risk.

## If the site errors after deploy
1. `php artisan optimize:clear` (stale view/route/config cache is the usual cause).
2. Restore the pre-deploy DB backup ONLY if the leads table is corrupt:
   `cp database/backups/database.<date>.sqlite database/database.sqlite`
   (Additive migrations do not touch existing rows, so this is rarely needed.)

## If a form stops submitting
- Symptom seen before: response shape changed to JSON and a JS handler still checked the bare
  `"OK"` string. Both handlers now accept `{status:"OK"}` (main.js v4, form-scripts.blade).
- Confirm the browser loaded `main.js?v=4` (hard-refresh / bump the version if a proxy cached v3).
- The server still saved the lead even when the JS showed no confirmation — check `leads:summary`.

## If GA4 double-counts conversions
- The frontend emits exactly one `generate_lead`. Double counting comes from a **second** tag in
  GTM (e.g. a direct `AW-` conversion firing alongside the GA4 import). Fix in GTM, not in code:
  keep the GA4 `generate_lead` import as the single **primary** conversion; set others to secondary.

## Code-level rollback (last resort)
- Reverting the attribution commits is safe: routes and forms fall back to the prior mail-only
  path. Leads already stored remain in SQLite. Do NOT drop the `leads` table to "clean up" —
  that is the revenue record.
