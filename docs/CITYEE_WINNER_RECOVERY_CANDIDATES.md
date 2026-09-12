# CITYEE — Winner Recovery Candidates (NO implementation)

Smallest-evidence-supported-change-first (§33). Each is a *future* recommendation, gated on the owner
evidence in `CITYEE_SEARCH_OWNER_EVIDENCE_REQUESTS.md`. Nothing here is executed.

## MAKLER_QUERY_OWNERSHIP_MAP (§51 — highest priority)
Broker/"маклер" impressions are targeted by 4 URLs; registry intends ONE owner.

| query | intended owner | competing URLs (by title, PROD_HTTP) | pos delta (owner_gsc) | overlap type |
|---|---|---|---|---|
| маклер таллинн | `/ru/makler-v-tallinne/` | `/ru/` ("Маклер в Таллинне — продажа…"), `/ru/tallinn/` ("Маклер по районам"), `/ru/agentstvo…/` (broad) | 7.63→10.66 | title + intent |
| маклер | `/ru/makler-v-tallinne/` | same | 7.75→10.69 (impr 106→106) | title + intent |
| маклер в таллинне | `/ru/makler-v-tallinne/` | `/ru/` title leads with this exact phrase | pending | exact-phrase title collision |

Dominant diagnosis: **CANNIBALIZATION** (not RANKING_LOSS-in-isolation, not AUTHORITY_DILUTION —
makler is the most-linked winner, §14). Confidence STRONGLY_SUPPORTED; PROVEN pending GSC Query→Page.

---

## Candidate R1 — de-conflict homepage & geo-hub titles from the broker primary  ★ top
- **URL(s):** `/ru/` title, `/ru/tallinn/` title (NOT the makler page).
- **Current problem:** both carry "Маклер (в) Таллинне / по районам", competing with `/ru/makler-v-tallinne/`.
- **Root cause:** RC-02.
- **Recommended future change:** rephrase the homepage title to a brand+breadth angle without the exact broker head term (e.g. lead with agency/brand, keep "маклер" only in the specialist page); drop "Маклер по районам" from the geo-hub title in favour of a districts/geo angle.
- **Expected mechanism:** returns sole broker-query ownership to the specialist → rank recovery toward historical pos ~9.
- **Confidence:** MEDIUM-HIGH (STRONGLY_SUPPORTED root cause). **Change risk:** R1–R2 (title edits on non-winner pages; the protected makler page itself is untouched). **Rollback:** revert title strings (one commit).
- **Measurement plan:** change ONE title first (homepage), watch broker-query position for `/ru/makler-v-tallinne/` over 2–3 weeks; only then touch the geo hub.

## Candidate R2 — extend the cannibalization gate to homepage/hubs
- **Problem:** `seo:audit-intents` only compares registry primaries → homepage/hub competition is a blind spot (proved by its PASS despite the collision).
- **Change:** include homepage + geo hubs in the competing-title check. **Risk:** R0 (tooling only, no production effect). **Confidence:** HIGH.

## Candidate R3 — classify `/ru/` NEW_QUERY_SET, then decide expansion vs focus
- **Problem:** `/ru/` impressions ~doubled while position fell (fallback breadth).
- **Change:** none yet — first classify the new queries (owner export). If low-value inflation → tighten homepage focus; if valuable → route those intents to/ create specialist owners (future phase). **Risk:** R0 now. **Confidence:** MEDIUM.

## Candidate R4 — non-brand homepage CTR review (`/`)
- **Problem:** non-brand position soft, CTR down.
- **Change:** snippet/title review ONLY if GSC shows position stable + CTR loss (RC-03). Do not rewrite pre-emptively. **Risk:** R1. **Confidence:** LOW until GSC.

## Candidate R5 — internal anchor tightening toward the makler primary
- **Problem:** many internal anchors to makler are generic ("Маклер в Таллине"); some hubs also link broadly.
- **Change:** ensure contextual broker anchors point to the specialist, not the homepage/hub. **Risk:** R1. **Confidence:** LOW-MEDIUM (needs anchor-graph diff).

**Explicitly NOT recommended:** redirects, canonical changes, URL changes, or content rewrites on any
protected winner; doorway service×district pages (§28); homepage expansion before NEW_QUERY_SET is known.
