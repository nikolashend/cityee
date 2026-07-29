# CityEE — SQLite Production Safety (X999^5 §7)

**Status:** the production database is **no longer tracked in git** and is ignored.

## Current state (verified)

- `git ls-files database/database.sqlite` → *(empty)* — **not tracked**.
- `git check-ignore -v database/database.sqlite` → `database/.gitignore:1:*.sqlite*` — **ignored**
  (plus an explicit `/database/database.sqlite` line added to the root `.gitignore`).
- Production runs on SQLite: `DB_CONNECTION=sqlite`, file `database/database.sqlite`.

## Why this matters

Earlier, `database/database.sqlite` was **committed to git**. A `git pull` on production
therefore **overwrote the live database** with the repo's copy — that is how corrupted
(mojibake) content reached production. A database must never be version-controlled.

## The one-time production procedure (if pulling the untracking commit)

When a commit that *removes* a previously-tracked file lands, `git pull` can delete that
file from the working tree. Guard against it:

```bash
# ON PRODUCTION, before pulling the commit that untracks the DB:
cp database/database.sqlite database/database.sqlite.safe-backup

git pull

# If git removed the file during the pull, restore it:
[ -f database/database.sqlite ] || cp database/database.sqlite.safe-backup database/database.sqlite

# Sanity check
php artisan tinker --execute="echo App\Models\Guide::count().' guides';"
```

(If the DB was already untracked before this commit — as it is now — no deletion occurs and
no restore is needed.)

## Deploy policy going forward

- **Never** commit `database/database.sqlite`.
- Deploy must **not** create a blank DB or run destructive seeders against production.
- Migrations: `php artisan migrate --force` is safe (additive).
- Content (guides/audits) is (re)seeded **explicitly and idempotently**:
  ```bash
  php artisan db:seed --class=GuideAndAuditSeeder --force
  ```
  This seeder truncates + recreates the `guides`/`area_audits` tables only. Do **not** run a
  blanket `php artisan db:seed --force` on production expecting it to build content —
  `DatabaseSeeder` runs `ContentMachineSeeder` (a different, older content set).

## Restore procedure

1. Keep periodic copies: `cp database/database.sqlite backups/db-$(date +%F).sqlite` (cron).
2. To restore: stop traffic briefly, `cp backups/db-<date>.sqlite database/database.sqlite`,
   `php artisan optimize:clear`, verify a guide page renders.

## Residual risk

- SQLite on a single node has no replication; rely on file backups.
- If the host's deploy tooling does a clean checkout, ensure it does **not** wipe
  `database/database.sqlite` (it's ignored, so a normal `git pull` won't — but a
  `git clean -x` or fresh clone would). Document the deploy command used.
