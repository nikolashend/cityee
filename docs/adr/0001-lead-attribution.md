# ADR 0001 — First-party lead attribution

**Status:** Accepted (2026-07-31) · **Context:** CityEE X999⁵

## Decision
Adopt **Variant B**: first-party session/cookie attribution + a server-side `leads` registry +
a non-PII GA4 `generate_lead` event. The server is the source of truth; hidden form fields are
supplementary transport only and are never trusted over server-captured context.

## Options considered
- **A — hidden form fields only.** Rejected: spoofable, lost on internal navigation, no first-touch
  persistence, frontend-dependent.
- **B — session/cookie + DB lead + GA4 non-PII event.** **Chosen.** Survives internal navigation,
  minimal frontend dependency, first + last touch, maintainable, lead-level source, privacy-safe.
- **C — GA4-only reconstruction.** Rejected: lost on consent/ad-blockers, no reliable lead-level
  link, PII cannot be sent to GA4, fragile reconstruction.

## Consequences
- New additive `leads` table (SQLite-safe); PII in DB, never in logs; IP hashed (HMAC).
- Lead saved before mail → mail failure never loses a lead; duplicate fingerprint collapses retries.
- First-touch never overwritten by a direct return; last-touch updates on qualifying events only.
- GA4 receives only non-PII fields; analytics/mail failures cannot break submission.
