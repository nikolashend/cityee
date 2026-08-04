# CityEE — 14-Day Revenue Intelligence Baseline (X999^5 §17)

**Purpose:** the reporting template the operator runs after deploy to establish the first
14-day attribution baseline. It contains **no fabricated numbers** — every cell is filled from
`php artisan leads:summary` on the production DB. Until then all metrics are **PENDING (deploy required)**.

## How to generate
```bash
php artisan leads:summary --from=<deploy_date> --exclude-test --json > docs/baseline-day14.json
```

## Metrics to record (from leads:summary)
| Metric | Source field | Day 0 | Day 14 | Note |
|---|---|---|---|---|
| Total leads | `total_leads` | PENDING | PENDING | exclude test |
| Test leads suppressed | `test_leads` | PENDING | PENDING | must be >0 if QA ran |
| Google Ads leads | `by_source_class.google_ads` | PENDING | PENDING | the paid-attribution proof |
| Google organic | `by_source_class.google_organic` | PENDING | PENDING | |
| Direct | `by_source_class.direct` | PENDING | PENDING | |
| Referral | `by_source_class.*_referral` | PENDING | PENDING | |
| Unknown/direct rate | `unknown_attr_rate` | PENDING | PENDING | **target < 25%**; high = attribution gap |
| Mail success rate | `mail_success_rate` | PENDING | PENDING | **target 100%**; <100 = delivery risk |
| Top campaign | `by_campaign[0]` | PENDING | PENDING | |
| Top landing page | `by_landing_page[0]` | PENDING | PENDING | which money page converts |
| Leads by form | `by_form_type` | PENDING | PENDING | callback/inquiry/audit/price |

## Decision rules
- **unknown_attr_rate ≥ 25%** → attribution capture is leaking (check CaptureAttribution middleware
  runs on GET, session cookie set, gclid landing pages reachable).
- **mail_success_rate < 100%** → a lead was saved but not emailed; investigate `mail_status=failed`
  rows via `leads:export --include-pii` (audited) and resend manually. Revenue is preserved (lead
  is in DB) but response time suffers.
- **google_ads leads = 0 while Ads spend > 0** → gclid not captured OR consent blocking; verify a
  real ad click lands with `?gclid=` and produces `last_touch_source=google_ads`.
