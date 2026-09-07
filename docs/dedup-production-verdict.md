# CityEE — Deduplication Production Verdict (X999⁵ §9)

**Date:** 2026-09-08 · **DEDUP_STATUS: CONTAINED_UNREACHABLE** (live-path dedup complete;
production response-body confirmation BLOCKED — one `curl` capture closes it).

## The question (§9)
Is the legacy/fallback emission path — where the frontend uses `client_submission_id` as the
`event_id` because the response carried no `lead` object — **reachable in production**? If reachable
and it lets duplicate submissions bypass authoritative dedup, that is a P1 integrity defect.

## Code evidence (verifiable here — GREEN)
1. All four lead routes go through one controller path:
   `ContactController::{callback,inquiry,auditRequest,priceCalculator}` each `return $this->ok($lead)`
   ([ContactController.php:40,76,107,139](../app/Http/Controllers/ContactController.php)).
2. `ok()` **always** returns the lead payload:
   `response()->json(['status' => 'OK', 'lead' => $lead->analyticsPayload()])`
   ([ContactController.php:149](../app/Http/Controllers/ContactController.php#L149)).
3. `analyticsPayload()` always includes a deterministic `event_id = HMAC(public_id.'|generate_lead')`
   — stable across retries, non-PII (`test_event_id_is_deterministic_and_non_pii`).
4. The JS fallback (`event_id = client_submission_id`) fires **only when `data.lead` is absent**
   (`cityee-lead-tracking.js` `buildEvent`). Given (1)–(3), a healthy production response never
   omits `lead`, so on the normal live path the browser always uses the **backend `event_id`** →
   **complete GA4↔Ads dedup**.

## Reachability conclusion
The fallback branch is a **defensive** path, reachable only when something between Laravel and the
browser removes the JSON body: a caching proxy returning a bare `OK`, a legacy build predating the
JSON response, or a truncated 2xx. Under the current codebase it is **code-unreachable**.

Even if reached, duplicate **business** leads are still prevented server-side: the 10-minute HMAC
`duplicate_fingerprint` collapses repeat submissions to one lead **before** insert
(`test_duplicate_submissions_create_one_lead`) — independent of the analytics `event_id`. So a
reachable fallback could at worst emit two *analytics* events with different client ids for one
lead; it can **never** create two DB leads or two mails.

## What remains BLOCKED (production)
Confirming the **actual bytes** production returns requires one live capture:
```
curl -s -X POST https://cityee.ee/contact/callback \
  -H 'X-Requested-With: XMLHttpRequest' -H 'Accept: application/json' \
  --data 'name=CITYEE-QA&tel=%2B372000000&client_submission_id=cs_probe' | head -c 300
# expect: {"status":"OK","lead":{...,"event_id":"...","is_test":...}}
```
If the body contains `lead.event_id`, the live path is confirmed complete and the fallback is
formally unreachable in production. Until that capture exists, this is CONTAINED, not FULL_PASS.

## Verdict
- **Live JSON path:** complete `event_id` dedup — GREEN (code + tests).
- **Fallback path:** code-unreachable; business-lead dedup guaranteed regardless by the server
  fingerprint — CONTAINED.
- **Production body confirmation:** BLOCKED (one curl).
- **DEDUP_STATUS = CONTAINED_UNREACHABLE** → does **not** block P0 attribution closure per §9.
