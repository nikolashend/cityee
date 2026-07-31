# CITYEE X999⁵ — Lead Attribution & Revenue Measurement — Final Report

**Date:** 2026-07-31 · **Mode:** production-safe, additive, privacy-by-design. No winner page,
URL, title, H1, canonical, hreflang, schema, CTA, hero, nav, layout, or visible form copy changed.

---

## 1. Executive verdict

### GLOBAL FAIL — implementation complete & proven locally; production deploy + live QA + 72h monitoring not yet performed.

The first-party lead-attribution system is **fully implemented, migration-safe, revenue-safe, and
proven by 24 passing tests (151 assertions)**. Every form submission now creates a server-side
`leads` record with first/last-touch attribution that survives internal navigation and mail
failure. It is **GLOBAL FAIL** only because §22 mandates production-live proof I cannot perform
here: **deploy of the migration/code, live form QA on `cityee.ee`, and 72h monitoring** all need
production shell; the **4 historical leads remain UNKNOWN** (no captured source data + no GA4/Ads
access — §14 permits UNKNOWN, and that alone does not block, but the production items do). Each
blocker below carries the exact unblock step. No PASS is claimed for local scope.

## 2. Previous-report corrections
The production-closure report was corrected (dated note, §3 of prior spec): deploy/crawl/trailing-
slash/hreflang = PASS (production-verified); attribution capability at that date = NOT_IMPLEMENTED.
This report supersedes that line: **attribution capability is now IMPLEMENTED (local), deploy pending.**

## 3. 72-hour monitoring closure — **BLOCKED**
`CITYEE_72H_PRODUCTION_MONITORING_LOG.md` skeleton exists; checkpoints need production access +
elapsed time. Values not invented (NOT_RECORDED where applicable).

## 4. Architecture options considered (ADR: `docs/adr/0001-lead-attribution.md`)
- **A — hidden form fields only:** rejected — spoofable, lost on internal navigation, no first-touch.
- **B — first-party session/cookie attribution + server-side Lead registry + GA4 non-PII event:** **chosen.**
- **C — GA4-only reconstruction:** rejected — lost on consent/ad-blockers, no lead-level link, PII risk.

Selected **B**: server is source of truth; hidden fields not trusted over server context.

## 5. Files changed

| File | Purpose |
|---|---|
| `database/migrations/2026_07_31_000001_create_leads_table.php` | additive `leads` table |
| `app/Models/Lead.php` | model + non-PII `analyticsPayload()` |
| `app/Services/Attribution/AttributionContextService.php` | first/last touch capture, sanitize, deterministic classifier |
| `app/Services/Attribution/LeadService.php` | save-before-mail pipeline + duplicate fingerprint |
| `app/Http/Middleware/CaptureAttribution.php` | session first/last-touch on GET |
| `bootstrap/app.php` | register `CaptureAttribution` (web) |
| `app/Http/Controllers/ContactController.php` | 4 handlers → save lead, drop PII from logs |
| `resources/views/components/v3/form-scripts.blade.php` | GA4 `generate_lead` (non-PII) dataLayer push |
| `tests/Feature/LeadAttributionTest.php` | 9 attribution regression tests |
| `docs/CITYEE_GOOGLE_ADS_CONVERSION_CONTRACT.md`, `docs/adr/0001-lead-attribution.md`, this report | docs |

**Routes:** unchanged. **Form validation rules + email content:** unchanged.

## 6. Database migration — additive, SQLite-safe
New `leads` table only; **no existing table touched**. Indexes: `created_at`, `form_type`,
`mail_status`, `duplicate_fingerprint`, `first_touch_source`, `last_touch_source`, unique `public_id`.
Production migration procedure (backup + checksum + counts) in `CITYEE_SQLITE_PRODUCTION_SAFETY.md`
+ §19 acceptance; **run `migrate --force` only** (never `migrate:fresh`/`db:seed --force`).

## 7. Lead schema
`public_id` (ULID), `form_type`, name/phone/email/message, `metadata_json`, landing/submission/
referrer, first/last-touch (normalized + JSON), `ga_client_id/session_id`, `ip_hash` (HMAC-SHA256,
**never raw IP**), `consent_state`, `duplicate_fingerprint`, `mail_status/error/sent_at`,
`analytics_status`, timestamps.

## 8–9. First-touch / Last-touch
First-touch captured once (first landing, even direct) and **never overwritten by a direct return**.
Last-touch updates only on a **qualifying** event (paid click / UTM / external referrer). Internal
referrers ignored. Proven: `test_direct_return_does_not_overwrite_first_touch`,
`test_new_paid_click_updates_last_touch`, `test_internal_referrer_not_treated_as_source`.

## 10. Source classifier (deterministic, §8)
Priority: gclid/gbraid/wbraid → `google_ads`; explicit UTM (google+cpc → `google_ads`; google →
`google_organic`; bing → `bing_organic`; whatsapp/telegram; else `other_organic`/`referral`);
external search/other referrer; else `direct`. Never classifies "google/cpc" without a valid
UTM/click-id.

## 11. Duplicate prevention
`HMAC(form_type + normalized_contact + payload_hash + 10-min bucket, app_key)`. Repeated identical
submits → **one lead, one mail**. Proven: `test_duplicate_submissions_create_one_lead` (4 posts → 1).

## 12. Form pipeline & mail delivery
`validate → normalize → capture attribution → fingerprint → transaction(create lead) → commit →
mail → record mail_status → return non-PII JSON`. **The lead is saved before mail**, so mail failure
never loses a lead (`mail_status='failed'`, lead retained). Proven: `test_lead_saved_even_when_mail_fails`.
DB transaction holds no network/mail call. Email content unchanged.

## 13. GA4 event contract
On server success the response returns a **non-PII** payload (`lead_public_id`, `form_type`,
`submission_page`, `source_class`, `campaign_name`, `has_gclid`); the v3 form handler pushes
`generate_lead` to `dataLayer` with exactly those. **Never** sends name/phone/email/message/raw IP
(proven: `test_analytics_payload_has_no_pii`). Analytics failure cannot break submission (the push
is post-success, isolated).

## 14. Google Ads conversion contract
`docs/CITYEE_GOOGLE_ADS_CONVERSION_CONTRACT.md` — primary = qualified `generate_lead` (count: one);
secondaries = WhatsApp/phone/telegram/form_start (not bid-optimized as leads); dedup by
`lead_public_id`; consent + enhanced-conversions notes.

## 15. Live form QA — **BLOCKED** (needs production submissions)
Scenarios 1–6 defined; require prod. Locally, the equivalent flows are covered by tests.

## 16. Historical four leads — **UNKNOWN (honestly proven)**
`app/Http/Controllers/ContactController.php` (pre-change) stored **no** source data and **no** DB
record; the 4 leads exist only as emails + `laravel.log` lines (name/tel/mail_sent). Attribution
needs GA4 + Ads exports (no access). `storage/app/audit/historical-four-leads-attribution.csv` →
all `UNKNOWN`/`NONE`. Per §14/§22 this is acceptable and does not block technical PASS. **Going
forward, every new lead is attributed** by the new system.

## 17. Query-filter redirects — INTENTIONAL_QUERY_CANONICALIZATION (not fixed, per §17)
The 21 `?category=`/`?type=` internal redirects are intentional query canonicalization (RULE-006),
distinct from unwanted internal redirects (non-query internal 3xx = 0, verified in prod). Not
touched in this scope.

## 18. SEO / UX regression proof
Winner URLs/titles/H1/canonical/hreflang unchanged; `RevenueSafeClosureTest` + `seo:audit-links`
(0 broken/redirect/orphan) + `seo:audit-intents` (0). Visible form layout/labels/CTA unchanged
(only server logic + a post-success dataLayer push added).

## 19. Test results
`php artisan test --filter="LeadAttribution|RevenueSafeClosure|TrailingSlash|Seo"` →
**24 passed / 151 assertions.** Covers UTM/GCLID preservation, first/last touch, direct-return
protection, internal-referrer ignore, sanitization, duplicate collapse, mail-failure retention,
no-PII analytics, all 4 form types, winner integrity, slash contract.

## 20. Production deploy proof — **PENDING** (operator runs; runbook in closure report §8)

## 21. Red-team (selected; UTM injection / oversized / HTML-in-attribution → sanitized [test];
fake GCLID → not sent as real Ads until you configure the test flag; duplicate/double-click → one
lead [test]; GCLID lost after nav → preserved [test]; mail failure → lead kept [test]; PII in GA4/
logs → none [test + code]; raw IP stored → hashed [test]; direct overwrites first touch → prevented
[test]; internal referrer as source → prevented [test]; migrate:fresh/seed → forbidden in runbook;
public access to leads → no route). Live-only attacks (server restart mid-save, consent denied,
crawler hitting forms) → design-covered, production verification pending.

## 22. Rollback
Code: remove `CaptureAttribution` from `bootstrap/app.php` + revert `ContactController` (git). DB:
**keep** the additive `leads` table (never auto-drop; export first if restoring an older DB). Code
rollback and DB rollback are independent.

## 23. Remaining blockers
1. **Deploy** (migration + code) on production — operator.
2. **Live form QA** (6 scenarios) on production.
3. **72h monitoring** completion.
4. **4 historical leads** — UNKNOWN unless you supply GA4 + Ads exports for those timestamps.

## 24. Requirement → status matrix

| Requirement | Evidence | Status |
|---|---|---|
| Lead saved server-side w/ attribution | migration+service+test | **PASS (local)** |
| First-touch persistence | test | **PASS** |
| Last-touch update on paid | test | **PASS** |
| UTM/GCLID/GBRAID/WBRAID preserved | service+test | **PASS** |
| Internal referrer ignored | test | **PASS** |
| Param sanitization / oversize | test | **PASS** |
| Duplicate prevention | fingerprint+test | **PASS** |
| Mail-failure lead retention | pipeline+test | **PASS** |
| Analytics-failure isolation | pipeline | **PASS** |
| No PII in GA4 | payload+test | **PASS** |
| No PII in logs | controller (removed) | **PASS** |
| IP hashed, not raw | HMAC+test | **PASS** |
| Additive migration safe | migration | **PASS (local)** |
| Winner/SEO invariants | tests+audits | **PASS** |
| GA4 event contract | dataLayer push + doc | **PASS (local)** |
| Google Ads conversion contract | doc | **PASS** |
| Production migration verified | — | **BLOCKED (deploy)** |
| Lead registry production-live | — | **BLOCKED (deploy)** |
| Live form QA | — | **BLOCKED (prod)** |
| 72h monitoring | — | **BLOCKED (prod+time)** |
| 4 historical leads classified | no data + no GA4/Ads | **UNKNOWN (honestly proven)** |

## Final verdict

**GLOBAL FAIL — one or more mandatory production invariants not proven.** The attribution system is
complete, tested (24/151), privacy-by-design, migration-safe, and revenue-safe; it is unproven only
where production deploy / live QA / 72h monitoring / GA4-Ads access are required — each enumerated
with its exact unblock. The single code-side remaining step is **deploy**.
