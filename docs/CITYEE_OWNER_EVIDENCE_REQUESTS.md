# CITYEE X999⁵ — OWNER EVIDENCE REQUESTS (Stage B)

Claude has finished Stage A (repo/code). These are the exact proofs it still needs, **one at a
time, read-only, current state**. Forward each block verbatim to the holder named in `SYSTEM`.
Paste the returned screenshot/output back into **this same Claude Code context** with the
`OWNER EVIDENCE` header (see handoff protocol §8). Reference facts: GA4 lead event =
`generate_lead`; GTM container = `GTM-5DRRX5ZJ`; four forms = `callback`, `inquiry`,
`audit-request`, `price-calculator`; synthetic-click marker = `CITYEE_TEST…` → `is_test=true` →
event suppressed.

---

## OWNER ACTION #0 — production schema (SERVER_ACCESS_PENDING · Nikolai/DevOps)
Unblocks **Proof 1**. Run on the CityEE production host, paste raw text (no PII involved):
```
OWNER ACTION REQUIRED
PROOF_ID:            P1-SCHEMA
SYSTEM:             Prod server (SSH)
WHAT TO OPEN:       project root on production
WHAT TO FIND / RUN:
  php artisan migrate:status | grep -i lead
  php artisan tinker --execute="echo Schema::hasColumn('leads','is_test')?'is_test OK':'MISSING';"
  php artisan tinker --execute="echo App\Models\Lead::count();"
EXPECTED VALUE:     both lead migrations 'Ran'; 'is_test OK'; a lead count >= 0
SCREENSHOT REQUIRED: no — paste the three command outputs as text
PASS CONDITION:     migrations Ran AND is_test present AND count query succeeds
FAIL CONDITION:     migration 'Pending', or is_test MISSING, or table missing
DO NOT CHANGE:      do NOT run migrate:fresh / db:wipe / db:seed --force. Back up the SQLite file first.
```

## OWNER ACTION #1 — GA4 exactly-once `generate_lead` (OWNER_EVIDENCE_PENDING · Aleksandr)
Unblocks **Proof 3**. Requires one controlled **real** submission first (see TEST CASE QA-REAL below):
```
OWNER ACTION REQUIRED
PROOF_ID:            P3-GA4-ONCE
SYSTEM:             GA4
SCREEN / PATH:      Admin → DebugView  (enable debug, or use Realtime)
WHAT TO OPEN:       the debug stream while QA-REAL is submitted
WHAT TO FIND:       exactly ONE `generate_lead` event for that submission
EXPECTED VALUE:     1× generate_lead; params present: event_id, form_name=lead_form,
                    form_type, source_class, has_gclid, submission_page;
                    NO name / phone / email / message / address in the payload
TIME RANGE:         the minute QA-REAL is submitted
TEST ID / TIMESTAMP: CITYEE-PROD-QA-REAL + exact submit time
SCREENSHOT REQUIRED: yes — full DebugView panel incl. the event params list
PASS CONDITION:     exactly one generate_lead, params correct, zero PII fields
FAIL CONDITION:     0 events, ≥2 generate_lead for one submission, or any PII field present
DO NOT CHANGE:      do not edit tags/events/consent; read-only
```
```
OWNER ACTION REQUIRED
PROOF_ID:            P3-GA4-SUPPRESS
SYSTEM:             GA4
SCREEN / PATH:      Admin → DebugView
WHAT TO FIND:       for QA-TEST (synthetic gclid) — ZERO generate_lead events
EXPECTED VALUE:     no generate_lead fires (is_test suppression)
TEST ID / TIMESTAMP: CITYEE-PROD-QA-TEST + exact submit time
SCREENSHOT REQUIRED: yes — DebugView showing no generate_lead for that submission
PASS CONDITION:     zero generate_lead for the synthetic submission
FAIL CONDITION:     any generate_lead fires for the synthetic click
DO NOT CHANGE:      read-only
```

## OWNER ACTION #2 — Google Ads single Primary (OWNER_EVIDENCE_PENDING · Aleksandr)
Unblocks **Proof 4**. Inventory current state only:
```
OWNER ACTION REQUIRED
PROOF_ID:            P4-ADS-PRIMARY
SYSTEM:             Google Ads
SCREEN / PATH:      Goals → Conversions → Summary (conversion actions list)
WHAT TO FIND:       every conversion action with: name, source, Primary/Secondary
                    (‘Primary action’ / ‘Secondary’), and whether it counts a website lead
EXPECTED VALUE:     exactly ONE Primary action represents a website lead; any other lead-like
                    action (form_submit, GA4 import duplicate, thank-you, WhatsApp, phone) is
                    Secondary or not in ‘Conversions’
TIME RANGE:         current configuration
SCREENSHOT REQUIRED: yes — full conversion-actions table (names + source + status columns visible)
PASS CONDITION:     ≤1 Primary lead conversion; no two Primary actions counting the same lead
FAIL CONDITION:     two Primary actions counting the same website lead (P0/P1 double-count)
DO NOT CHANGE:      do NOT delete, do NOT flip Primary↔Secondary, do NOT edit goals/attribution/import
```

## OWNER ACTION #3 — GTM / Consent Mode (OWNER_EVIDENCE_PENDING · Aleksandr)
Unblocks **Proof 5** (analytics half). Current state only:
```
OWNER ACTION REQUIRED
PROOF_ID:            P5-GTM-CONSENT
SYSTEM:             GTM (container GTM-5DRRX5ZJ)
SCREEN / PATH:      Tags list; the GA4 generate_lead tag; the Ads conversion tag; Consent Overview
WHAT TO FIND:       (a) the tag that fires GA4 generate_lead on the generate_lead dataLayer event;
                    (b) whether a Google Ads conversion tag fires directly (vs GA4 import);
                    (c) Consent Mode: default state + whether tags require analytics_storage/ad_storage
EXPECTED VALUE:     one GA4 lead tag on the generate_lead event; Consent Mode present with a default
                    state and a CMP update; ad tags gated on ad_storage
SCREENSHOT REQUIRED: yes — tag list + the lead tag config + Consent Overview
PASS CONDITION:     lead tag maps correctly; Consent Mode present and gating ad/analytics storage
FAIL CONDITION:     no Consent Mode at all, or ad tags firing with ad_storage denied
DO NOT CHANGE:      do not publish a new version; do not edit tags/triggers/consent
```

## OWNER ACTION #4 — mail delivery (OWNER_EVIDENCE_PENDING · inbox owner)
Unblocks **Proof 2** (email half). For each QA submission:
```
OWNER ACTION REQUIRED
PROOF_ID:            P2-MAIL
SYSTEM:             Mailbox (info@cityee.ee or the real lead inbox)
WHAT TO FIND:       exactly ONE notification email per QA submission; none duplicated
EXPECTED VALUE:     1 email per QA test id, arriving within minutes
TEST ID / TIMESTAMP: CITYEE-PROD-QA-01..04 + times
SCREENSHOT REQUIRED: yes — inbox list showing the QA emails (mask unrelated customer PII)
PASS CONDITION:     one email per submission, no duplicates
FAIL CONDITION:     zero emails, or duplicate emails for one submission
DO NOT CHANGE:      just observe the inbox
```

---

## Controlled live-form QA test cases (run by whoever can submit on production)
Each submission carries a known time + test id. **QA-REAL uses a clean URL (fires the event);
QA-TEST uses a synthetic gclid (must be suppressed).** All four forms should get one real QA pass.

| TEST CASE ID | FORM URL (example) | FORM TYPE | is_test | Expected DB | Expected email | Expected GA4 | Expected Ads |
|---|---|---|---|---|---|---|---|
| CITYEE-PROD-QA-REAL | `https://cityee.ee/` (clean, no gclid) → callback | callback | false | 1 lead | 1 email | 1 generate_lead | eligible (1 known QA conv) |
| CITYEE-PROD-QA-TEST | `https://cityee.ee/?gclid=CITYEE_TEST_QA` → callback | callback | **true** | 1 lead (is_test) | 1 email | **0** generate_lead | **never** |
| CITYEE-PROD-QA-02 | inquiry form | inquiry | false | 1 | 1 | 1 | eligible |
| CITYEE-PROD-QA-03 | audit-request form | audit-request | false | 1 | 1 | 1 | eligible |
| CITYEE-PROD-QA-04 | price-calculator form | price-calculator | false | 1 | 1 | 1 | eligible |
| CITYEE-PROD-QA-DUP | submit callback twice in <10 min | callback | false | **1** (fingerprint) | 1 | 1 | ≤1 |
| CITYEE-PROD-QA-CONSENT | submit with consent denied | inquiry | false | **1** (persists) | 1 | per Consent Mode | per Consent Mode |

> The one QA-REAL conversion is a single, known, logged test — record its `public_id`/`event_id`/
> timestamp so it can be identified and, if wanted, annotated/excluded in Ads reporting. It must not
> be repeated many times. Everything synthetic (`CITYEE_TEST…`) is auto-excluded by `is_test`.

## Consent scenarios (pre-defined — Proof 5 behavior half)
```
TEST A — consent granted: lead saves · email sends · analytics per configured policy
TEST B — consent denied:  lead STILL saves · email STILL sends · GA4/Ads per Consent Mode
```
Claude validates each returned screenshot and issues the next smallest action until all mandatory
production proofs are `PASS`.
