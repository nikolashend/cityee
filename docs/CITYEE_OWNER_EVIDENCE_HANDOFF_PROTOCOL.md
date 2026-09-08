# CITYEE X999⁵ — OWNER EVIDENCE HANDOFF PROTOCOL (final)

**Companion to:** *CLAUDE CODE TASK — CITYEE X999⁵ P0 PRODUCTION ATTRIBUTION CLOSURE + 72H REVENUE
OBSERVABILITY.* Forward **both** documents together. This protocol governs how missing access is
handled and how owner evidence flows back to Claude.

---

## 0. Access reality — establish this FIRST (edit #2)
Three different capabilities are involved; do not conflate them:

| Capability | Who holds it | Governs |
|---|---|---|
| Repository / code | Nikolai + Claude Code | implementation proofs |
| **Production server shell** (SSH / prod DB / deploy) | **Nikolai / DevOps** | migration-applied, prod schema, prod lead count, mail pipeline |
| **Google accounts** (GA4, GTM, Google Ads, GSC) | **Aleksandr** | analytics, ads, consent, search evidence |
| **Mailbox** `info@cityee.ee` (or the real lead inbox) | **inbox owner — name this person** | email-delivery proof (Proof 2) |

**Step 0 for Claude:** state plainly *where this Claude Code session runs* and whether it has a
production shell. If it runs on a local checkout (`APP_ENV=local`), production-server proofs are
`SERVER_ACCESS_PENDING`, **not** owner-pending and **not** FAIL.

## 1. Verdict rule — this protocol OVERRIDES the main TZ (edit #1)
> **This handoff protocol overrides §13 and §20 of the main TZ.** Missing owner access or missing
> server access is **PENDING, never FAIL**. `FAIL` is reserved for a **proven defect** only.

Without this line Claude is obligated by the main TZ to return GLOBAL FAIL for anything unproven —
which is exactly the wrong signal when the implementation is fine and only evidence is gated.

## 2. Status vocabulary (edit #4)
Use exactly these tokens, everywhere:

| Token | Meaning |
|---|---|
| `PASS` | proven from real evidence |
| `FAIL` | a **defect is proven** (never "unproven") |
| `SERVER_ACCESS_PENDING` | needs the production server shell (Nikolai / DevOps) |
| `OWNER_EVIDENCE_PENDING` | needs a Google-account screenshot (Aleksandr) |
| `NOT_STARTED` | time-dependent, cannot begin yet (e.g. 72H) |

**The expected, healthy outcome of Stage A is a success state, not a failure:**
`IMPLEMENTATION_PASS + PRODUCTION_OWNER_EVIDENCE_PENDING (+ SERVER_ACCESS_PENDING)`.

## 3. Order of work

### STAGE A — Claude Code works alone (no screenshots requested yet)
Claude first closes everything reachable from repo/server: attribution architecture, migrations,
lead persistence, save-before-mail, `event_id`, deduplication, synthetic/test protection, PII
safety, analytics emission contract, the four forms, mail pipeline (as far as reachable), and
SEO/render non-regression. Then Claude lists precisely which proofs are impossible without
Aleksandr's accounts or the production shell. **Do not ask Aleksandr for anything during Stage A.**

### STAGE B — owner-evidence, collected as ONE pack (batch)
While Claude runs Stage A, Aleksandr captures **one OWNER EVIDENCE PACK** covering **GA4 + Google
Ads + GTM** in a single pass (checklist: `CITYEE_OWNER_EVIDENCE_REQUESTS.md` → "OWNER EVIDENCE
PACK"). Aleksandr sends all screenshots in **one message**; Claude analyses the whole pack together
and asks for extra screenshots **only if a real gap is found**.
```
CLAUDE (Stage A) + ALEKSANDR (collects full pack in parallel)
       → Nikolai (upload the whole pack into the SAME Claude Code context)
       → CLAUDE validates the pack → requests deltas only if a gap exists
```
Nikolai never invents what to photograph — the pack checklist is exact. The production-server proof
(#0) and the mailbox proof (#4) have different holders and run in parallel, outside Aleksandr's
pack. Everything is captured **read-only, current state**, and pasted back **into this same
task/context** (not a new SEO task).

## 4. Owner-evidence request format (what Claude emits)
Every request Claude prints uses this block, one proof at a time:
```
OWNER ACTION REQUIRED
PROOF_ID:
SYSTEM:            GA4 | GTM | Google Ads | Mailbox | Prod server
SCREEN / PATH:
WHAT TO OPEN:
WHAT TO FIND:
EXPECTED VALUE:
TIME RANGE:
TEST ID / EVENT ID / TIMESTAMP:
SCREENSHOT REQUIRED: yes/no
PASS CONDITION:
FAIL CONDITION:
DO NOT CHANGE:      (list what must stay untouched)
```

## 5. Read-only first — no configuration changes before analysis
For GA4, Google Ads, and GTM/Consent: capture **current state only**. Do **not** delete conversions,
flip Primary↔Secondary, edit goals/attribution/import, publish a new GTM version, or change tags/
triggers/Consent Mode until Claude has analysed the current state and proposed a change with its
regression risk and rollback (see §9).

## 6. Controlled live form QA (edit #5 — must not train Ads)
If Claude needs a real production submission, it first emits a test case:
```
TEST CASE ID:        e.g. CITYEE-PROD-QA-01
FORM URL:
FORM TYPE:
EXPECTED BACKEND / EMAIL / GA4 / ADS RESULT:
EXPECTED CONSENT STATE:
```
**The QA submission must carry a marker that triggers `is_test`** — a click id matching the
synthetic pattern `CITYEE_TEST…` (e.g. open the form URL with `?gclid=CITYEE_TEST_QA01`). This makes
the lead `is_test=true`, so it is auto-excluded from GA4 `generate_lead` and can never become a real
Google Ads conversion. Never fire many random test submissions; each one has a known time, form,
test id, and consent state.

## 7. Consent test (pre-defined, not blind)
```
TEST A — consent granted: lead saves · email sends · analytics per configured policy
TEST B — consent denied:  lead STILL saves · email STILL sends · analytics/ads per Consent Mode
```
Claude defines expected behavior **before** the test runs. Privacy correctness outranks attribution
completeness — never force analytics storage just to obtain attribution.

## 8. How Aleksandr's screenshots come back
Aleksandr → Nikolai → pasted **into this same Claude Code context**. Prefix every upload:
```
OWNER EVIDENCE
System: GA4 / GTM / Google Ads / Mailbox / Prod server
Proof ID: [ID from Claude]
Captured: [date/time]
No configuration changes made before capture.
```
Then ask Claude: *"Validate this evidence against the required proof. Do not infer missing facts.
Return PASS / FAIL / OWNER_EVIDENCE_PENDING and the next smallest owner action."*
Screenshots must show enough context (account, section, conversion/event/tag, status) — mask
customer PII, but never hide the technical fields the proof needs.

## 9. If a defect is found
Do **not** auto-fix if the change could touch production leads, GA4, GTM, Ads, Consent Mode, SEO,
forms, or mail. First report: `OBSERVED / EXPECTED / ROOT CAUSE / IMPACT / PROPOSED FIX /
REGRESSION RISK / ROLLBACK`. After a safe fix, re-run only the necessary proofs and mark them
`POST-FIX`.

## 10. 72H start gate (edit #4 — split status)
Do not treat 72H as started at deploy. Claude records `BASELINE START` only after the mandatory
immediate proofs are closed to the degree the main TZ requires. Print:
```
72H BASELINE START
Production commit / Deployment / Schema / Forms / Lead persistence / Mail /
GA4 / Google Ads / Consent / Known issues / Start ts / Expected end ts
```

## 11. GSC deferred
GSC is **not** required for this closure — do not request GSC screenshots now unless Claude finds a
specific dependency. GSC belongs to the next phase (Search Revenue Recovery / Estonian Seller
Dominance / Historical Winner Recovery). Do not mix the two phases.

## 12. Final gate
Separate the result by layer: `IMPLEMENTATION / PRODUCTION / GA4 / GTM+CONSENT / GOOGLE ADS /
LIVE FORM QA / 72H`. `GLOBAL PASS` only when the mandatory proofs are really confirmed. Never PASS
by assumption; never FAIL merely because Aleksandr hasn't sent an owner-only screenshot yet — in
that case: `OWNER_EVIDENCE_PENDING`.

## 13. The one rule for Nikolai
Don't ask Aleksandr to figure out what to photograph. Claude says exactly which proof is missing →
you forward that block → Aleksandr sends the screenshot → you paste it back into this same context →
Claude validates and asks for the next smallest proof. Repeat until every mandatory production proof
is closed.
