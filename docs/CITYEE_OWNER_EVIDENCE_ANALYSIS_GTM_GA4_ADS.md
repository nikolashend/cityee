# CITYEE X999⁵ — Owner Evidence Analysis: GTM + GA4 + Google Ads

**Date:** 2026-09-08 · **Evidence:** Aleksandr's OWNER EVIDENCE PACK (29 screenshots, `docs/CITYEE screens/`).
**Rule applied:** screenshots prove **configuration state, not runtime firing** — so nothing here is
declared runtime-PASS without DebugView/Preview. Config-level defects that are directly visible are
marked CONFIRMED (config); their runtime magnitude is marked PENDING (DebugView).

---

## CURRENT STATE captured (read-only, no changes made)

**GTM container:** `GTM-5DRRX5ZJ` (cityee.ee) · published **Version 11 "last"**, 04.08.2026 by
ads.adme@gmail.com · 7 tags, 4 triggers, 2 variables. (Version 10 was "Fixed GA4 Measurement ID".)

**GA4 property:** cityee.ee (under the `ads.adme` account). Key event: **`generate_lead`** (only).
Recent events: click, contact_telegram, contact_whatsapp, first_visit, form_start, generate_lead,
page_view, scroll, session_start, user_engagement. **No `lead_form_submit` and no
`lead_submit_success` GA4 event exists on the cityee.ee property.**

**GA4 measurement IDs in the container (two!):**
- `G-569W1W9H0W` — active; used by the base Google tag and all working GA4 event tags. (Google tag "cityee.ee" also lists `GT-M3VG7CDZ`.)
- `G-56M1W9H0W` — phantom; only referenced by the broken "Google Analytics Configuration" tag ("no Google tag / undefined parameter" warning).

**GTM tags (7):**
| Tag | Sends GA4 event | Trigger |
|---|---|---|
| 👉 GA4 – generate_lead (Form Submit) | `generate_lead` (no params mapped) | Custom Event **`lead_submit_success`** |
| GA4 - G-56M1W9H0W | `generate_lead` (+ `lead_type`, `lead_source`) | Custom Event **`lead_submit_success`** |
| GA4 - contact_mail | `contact_mail` | Click Mail (mailto:) |
| GA4 - contact_telegram | `contact_telegram` | Click Telegram (t.me) |
| GA4 – contact_whatsapp | `contact_whatsapp` | Click WhatsApp (wa.me) |
| Google Analytics Configuration | **`generate_lead`** → phantom `G-56M1W9H0W` | **All Pages (page view)** |
| Ter Google (base) | Google tag `G-569W1W9H0W`, `send_page_view=true` | All Pages |

**GTM triggers (4):** `lead_submit_success` (Custom Event → **2 tags**), Click-Telegram, Click-WhatsApp, Click-Mail. **There is NO `generate_lead` trigger.**

**Google Ads (shared account "ADME" 715-726-4144 — multiple clients):** CityEE's conversion is
**`cityee.ee (web) generate_lead`** — Source GA4, GA4 event `generate_lead`, **Primary**, **Count =
One conversion**, "Submit lead forms" account-default goal, data-driven attribution, created
3.08.2026 (1 conv, awaiting). Other Primary actions in the "Submit lead form" goal (Отправка формы
/`lead_form_submit` 56 conv, Positum – Lead Ads, Coralclean | Lead Submit, Lead form-Submit) belong
to **other businesses** in this shared account, not CityEE (they use different GA4 events/sites).

## Repository side (verifiable in code)
- Form submit pushes dataLayer **`{event:'generate_lead', event_id, form_type, source_class, has_gclid, submission_page, form_name:'lead_form'}`** ([cityee-lead-tracking.js:74](../public/assets/templates/offshors/js/cityee-lead-tracking.js#L74)).
- **`lead_submit_success`** is pushed by [datalayer-leads.blade.php:29](../resources/views/partials/datalayer-leads.blade.php#L29) — on **tel/mailto/WhatsApp/Telegram clicks**, not on form submit.

---

## FINDINGS

### F1 — Duplicate `generate_lead` sender · P1 · CONFIRMED (config)
**OBSERVED:** two tags ("GA4 – generate_lead (Form Submit)" and "GA4 - G-56M1W9H0W") both send GA4
`generate_lead` on the same `lead_submit_success` trigger (trigger "Links" list shows both).
**EXPECTED:** exactly one authoritative `generate_lead` per business lead.
**ROOT CAUSE:** two tags left mapped to one trigger.
**IMPACT:** every trigger fire = 2× `generate_lead` in GA4 → inflated GA4 leads; Ads bidding is
partly shielded by "Count = One", but GA4/Ads reporting is corrupted. **Runtime doubling: PENDING DebugView.**
**FIX (GTM, owner):** keep one tag, pause/delete the other. **REGRESSION RISK:** low. **ROLLBACK:** republish previous version.

### F2 — "Google Analytics Configuration" sends `generate_lead` on All Pages · P1 (latent P0) · CONFIRMED (config)
**OBSERVED:** a tag named like a base config is actually a GA4-**event** tag, event `generate_lead`,
trigger **All Pages**, targeting phantom `G-56M1W9H0W` ("no Google tag / undefined" warning).
**EXPECTED:** a base config sends page_view, never `generate_lead`; no lead event on page view.
**ROOT CAUSE:** mislabeled/misconfigured legacy tag pointing at a dead measurement ID.
**IMPACT:** currently likely non-firing (phantom ID) → **0 today (PENDING DebugView)**; but if anyone
ever creates the `G-56M1W9H0W` Google tag, **every page view becomes a lead** (P0). Dangerous.
**FIX (GTM, owner):** delete or disable this tag. **REGRESSION RISK:** none (it is misconfigured). **ROLLBACK:** republish previous version.

### F3 — Form-submit event-name mismatch (forms may not be measured) · P1 · CONFIRMED (code+config), runtime PENDING
**OBSERVED:** the only lead trigger is Custom Event `lead_submit_success`; there is **no
`generate_lead` trigger**. The site's form handlers push dataLayer `generate_lead`.
**EXPECTED:** the site's form-submit event name = the GTM lead trigger's event name.
**ROOT CAUSE:** the repo's safe-emission refactor standardized on `generate_lead`, but GTM still
triggers on `lead_submit_success`. The two were never reconciled.
**IMPACT:** with current repo JS, **real form submissions fire no GA4 lead event** — the original
"no event after form submit" symptom. (If production still runs older JS that pushed
`lead_submit_success` on submit, forms are measured but doubled per F1.) **Which is live: PENDING DebugView with a real form submit.**
**FIX (coordinated):** standardize on a **form-only** event and one trigger — recommended: GTM lead
tag triggers on Custom Event `generate_lead` (matches the site). **REGRESSION RISK:** medium — must
confirm with DebugView before/after. **ROLLBACK:** republish previous version.

### F4 — Contact-link clicks contaminate the lead conversion · P1 · CONFIRMED (code+config), runtime PENDING
**OBSERVED:** the site pushes `lead_submit_success` on tel/mailto/WhatsApp/Telegram clicks, and both
`generate_lead` tags fire on `lead_submit_success`. Contact clicks also have their own
contact_* events (native Click triggers).
**EXPECTED:** a WhatsApp/phone/email/Telegram **click is not a form lead** (business rule).
**ROOT CAUSE:** overloaded `lead_submit_success` event used for both contact clicks and (historically) form success.
**IMPACT:** contact clicks currently produce `generate_lead` (×2 per F1) → contact clicks miscounted
as leads and doubled. **Runtime: PENDING DebugView on a WhatsApp click.**
**FIX (site):** stop pushing `lead_submit_success` on contact clicks (keep contact_* via GTM Click
triggers as Secondary). **REGRESSION RISK:** low (contact_* events unaffected). Coordinate with F3.

### F5 — Dual GA4 measurement IDs · P2 · CONFIRMED (config)
**OBSERVED:** `G-569W1W9H0W` (active) + `G-56M1W9H0W` (phantom, only in the broken GAConfig tag).
**FIX:** remove references to `G-56M1W9H0W` (resolves with F2). **REGRESSION RISK:** none.

### F6 — `event_id` not forwarded to GA4 (designed dedup not wired) · P1 · CONFIRMED (config)
**OBSERVED:** the site pushes `event_id` on the dataLayer, but **neither** `generate_lead` tag maps
an `event_id` (or `transaction_id`) parameter (the "Form Submit" tag maps no params; the other maps
only `lead_type`/`lead_source`).
**EXPECTED:** the GA4 `generate_lead` event carries `event_id` for GA4↔Ads deduplication.
**IMPACT:** the cross-channel dedup we built server-side is **not actually delivered** to GA4/Ads.
**FIX (GTM, owner):** add a Data-Layer Variable `event_id` and map it as an event parameter
`event_id` (and optionally `transaction_id`) on the single authoritative tag. **REGRESSION RISK:** none.

### F7 — Consent Mode not evidenced · OWNER_EVIDENCE_PENDING (likely not implemented) · P1 if absent
**OBSERVED:** no CMP tag, no consent template, no consent variables in the container; no Consent Mode
in the repo either. The pack has no consent-overview screenshot.
**IMPACT:** cannot confirm consent-aware GA4/Ads. Lead persistence is consent-independent (proven in code).
**ACTION:** owner captures Admin → container settings / consent overview (Owner Action C below). If truly absent, that is a privacy/measurement gap to fix in a controlled step — **not** a reason to block lead persistence.

### F8 — Google Ads single Primary (CityEE) · PASS (config), dependent on F1/F6
**OBSERVED:** `cityee.ee (web) generate_lead` is the single CityEE Primary (Source GA4, Count = One).
The other Primary actions belong to other businesses in the shared ADME account.
**VERDICT:** single-authoritative-conversion holds for CityEE **at the Ads action level**; "Count =
One" shields bidding from the GA4 duplication. But GA4-side duplication (F1) and missing `event_id`
(F6) must still be fixed for correct reporting/dedup. **No Ads change recommended** beyond that.

---

## OWNER ACTIONS (GTM — read-only current state already captured; apply after go-ahead)
All paths in the Russian GTM UI. Do **one workspace change set**, use **Предварительный просмотр**
(Preview) to confirm in GA4 DebugView, then **Отправить** (publish). Capture before/after.

**OWNER ACTION A — remove duplicate + dangerous tags (fixes F1, F2, F5)**
- Менеджер тегов → cityee.ee → **Теги**.
- Open **"GA4 - G-56M1W9H0W"** → ⋮ → **Приостановить** (pause) or **Удалить** (delete). (removes the duplicate `generate_lead` sender)
- Open **"Google Analytics Configuration"** → ⋮ → **Приостановить**/**Удалить**. (removes the All-Pages `generate_lead` to the phantom ID)
- PASS condition: only **one** tag sends `generate_lead`; no tag sends `generate_lead` on All Pages.
- DO NOT touch: contact_* tags, "Ter Google" base tag.

**OWNER ACTION B — align the lead trigger + forward event_id (fixes F3, F6)**
- Keep the single tag **"👉 GA4 – generate_lead (Form Submit)"**.
- **Переменные** → Создать → Переменная уровня данных → name `event_id`, Data Layer Variable Name `event_id`. (repeat for `form_type`, `source_class` if desired)
- Open the tag → **Параметры события** → add parameter `event_id` = `{{event_id}}` (and `form_type`=`{{form_type}}`, `source_class`=`{{source_class}}` if added).
- **Триггеры** on that tag: replace `lead_submit_success` with a **new Custom Event trigger** `generate_lead` (Тип: Специальное событие, Название события: `generate_lead`). — this matches the site's form-submit push.
- PASS condition: DebugView shows exactly **one** `generate_lead` on a real form submit, carrying `event_id` and no PII.
- DO NOT change: the GA4 stream ID `G-569W1W9H0W`.

**OWNER ACTION C — Consent Mode current state (fills F7)**
- Администрирование → **Настройки контейнера** → enable/'**Consent Overview**' (Обзор согласований) in Теги view; screenshot the consent state of each tag.
- Also screenshot any CMP/Consent Mode tag if present. If none exists, state so.
- PASS condition: we can see whether ad/analytics tags are gated on consent.

**Website side (Claude — proposed, apply after the GTM trigger decision):** once OWNER ACTION B
repoints the trigger to `generate_lead`, remove the contact-click `lead_submit_success` push in
`datalayer-leads.blade.php` (F4) so contact clicks stop feeding the lead event; contact_* keep
firing via GTM Click triggers. Re-run the JS matrix + a DebugView check after.

## Verdict impact
- **PROOF_3_GA4 (exactly-once): FAIL (config-confirmed)** — duplicate `generate_lead` sender (F1) +
  All-Pages `generate_lead` (F2); runtime magnitude PENDING DebugView. This is a proven config defect, so per the addendum it is FAIL, not PENDING.
- **PROOF_4_ADS (single Primary): PASS (config)** for CityEE, dependent on fixing F1/F6.
- **PROOF_5_CONSENT: OWNER_EVIDENCE_PENDING** (Owner Action C).
- **event_id dedup: not wired in GTM (F6)** — our server-side dedup is not delivered to GA4/Ads until B is done.
