# CITYEE — GA4 ↔ GSC ACQUISITION RECONCILIATION + MEASUREMENT FORENSIC

**Task:** CITYEE_GA4_GSC_RECONCILIATION_DOCS_CLOSURE · **Mode:** DOCS_ONLY / ZERO RUNTIME CHANGE
**Evidence date:** 2026-09-30 · **Document written:** 2026-10-01
**Evidence SSOT:** `docs/CITYEE_SEARCH_MEASUREMENT_FORENSIC_2026-09-30.zip`
**Repo baseline at writing:** `origin/main = 8f11291` (ET Valuation O1 T0 record; zero runtime changes)

This document persists findings from the completed evidence-pack audit. It introduces no new analysis, no
reinterpretation beyond the audited evidence, and no implementation roadmap.

---

## 1. Executive summary

The recent organic decline is **not one phenomenon**. The audited evidence separates at least two, and keeps a third
open:

1. **A click-rate collapse at roughly unchanged exposure.** Estonia / Web, 28 days: impressions **+~8 %** while clicks
   **−~50 %** and CTR roughly halved. This is not explained by broad visibility loss alone, and it is **not** a sitewide
   ranking collapse.
2. **A measurement divergence specific to organic.** GA4 Estonia Organic Search sessions fell far faster than GSC
   clicks — approximate capture **88.5 % → 34.6 %**. The missing sessions are **not** classified as SEO loss, and no
   tracking defect is claimed as proven.
3. **Mobile is where the click loss concentrates** — ~72 % of mobile clicks lost at approximately flat impressions and
   approximately flat average position. Status `MOBILE_CTR_PRIORITY`.

Three structural findings sit underneath: the ET homepage's visibility is substantially non-seller intent; the RU
valuation head query shows an **observed** ownership collision with the ET homepage; and the RU sell cluster shows
**observed** intent diffusion. Batch 1A reads as `PARTIAL_DIRECTIONAL_RECOVERY` only — the final gate is not reached.

Causal closure on the measurement divergence is **blocked** pending owner-side GA4/GTM evidence (§15), now including an
unresolved CMP question: a **CookieScript banner is visibly rendered in the user's real browser** while no CMP
integration was observed in inspected CityEE-owned source.

---

## 2. Evidence-pack integrity

```
PACK_INTEGRITY=PASS
MANIFEST_ENTRIES=23            (22 evidence files + README_EVIDENCE.txt)
HASH_VERIFICATION=23/23_OK
MANIFEST_ENTRIES_MISSING=0
UNMANIFESTED_EVIDENCE_FILES=0
```

Archive sha256 `e9912a0c392a1d97876a1c4897db3e42bbfdbbc2fdfe1d9df106404484fd41af`, 190 102 bytes. Extracted read-only;
the repository was not modified by the audit. Every available XLSX `Фильтры` (Filters) sheet was inspected during that
audit and is **not** re-audited here.

Pack hygiene as declared by `README_EVIDENCE.txt`: screenshots superseded by structured exports, duplicate XLSX copies of
GA4 CSVs, invalid B1A page exports, exploratory low-value query variants, wrong-period exports and the original invalid
GA4 3-month comparison were all intentionally excluded.

---

## 3. Evidence inventory / metadata audit

**Authoritative B1A exact query family** (exact query filter confirmed by data, not only by label — each `Запросы` sheet
returned exactly one query row, which a contains-filter could not do):
`B1A_EXACT_makler`, `B1A_EXACT_makler_tallinn`, `B1A_EXACT_makler_v_tallinne`, `B1A_EXACT_rieltor`,
`B1A_EXACT_rieltor_yo` — all `EE_17-28_vs_05-16`.

**Authoritative B1A page exports** (exact page filter; Estonia; search type Web; `17.09.2026–28.09.2026` vs
`05.09.2026–16.09.2026`, 12 days vs 12 days):
`B1A_PAGE_makler_ALLqueries_CORRECTED`, `B1A_PAGE_ru_home_ALLqueries_CORRECTED`,
`B1A_PAGE_tallinn_ALLqueries_CORRECTED`. Earlier similarly named B1A exports are superseded and must not be substituted.

**Authoritative GA4 files:** `GA4_ORGANIC_EE_LANDING_28D_vs_PREV28D.csv`,
`GA4_ORGANIC_EE_LANDING_3M_vs_PREV3M_CORRECTED.csv`,
`GA4_EE_TRAFFIC_ACQUISITION_CHANNEL_GROUP_28D_vs_PREV28D.csv`, `GA4_ORGANIC_EE_SOURCE_MEDIUM_28D_vs_PREV28D.csv`,
`GA4_ORGANIC_EE_DEVICE_28D_vs_PREV28D.csv`.

**Semantic distinction that must not be collapsed:** the channel-group file carries *Session default channel group*;
the source/medium file is the actual source/medium evidence and is intentionally Organic-Search-scoped. These are two
different datasets.

**Remaining GSC exports:** `OWNERSHIP_exact_ocenka_nedvizhimosti_tallinn`, `OWNERSHIP_exact_prodat_kvartiru` (exact
query, no `+` prefix), `SELL_cluster_prodat_kvartiru` (`+продать квартиру`, a contains filter — correctly described by
"cluster"), `PAGE_prodat_ALLqueries`, `PAGE_ET_HOME_queries`, `PAGE_ocenka_queries` (see caveat 1), `SITE_EE_28D`,
`SITE_EE_3M`, `SITE_EE_MOBILE_28D`.

---

## 4. Known caveats

1. **`PAGE_ocenka_queries_EE_3M_vs_PREV3M.xlsx` used a contains-page filter, not an exact-page filter.** Only one URL
   matched, so the numerical result remained usable — but it **must not be described as exact-page evidence**.
2. **GA4 landing exports contain multiple blocks:** all-users periods **plus** Estonia + Organic Search periods. Analyses
   must use the correct blocks; reading only the first block yields all-channel traffic.
3. **A scope contradiction exists between some GA4 "all users" totals.** Therefore **do not use all-channel
   denominator or share statements** until owner-side GA4 scope is verified.
4. **GSC and GA4 date windows may differ slightly** because of GSC reporting lag.
5. **Small volumes create substantial statistical uncertainty.** Every percentage below rests on low absolute counts.

---

## 5. GSC short-window findings (28D, Estonia, Web)

| Metric | Previous | Current | Change |
|---|---|---|---|
| Clicks | 52 | **26** | ≈ −50 % |
| Impressions | 2 557 | **2 766** | ≈ +8 % |
| CTR | 2.03 % | **0.94 %** | roughly halved |

**Interpretation:** impressions increased approximately 8 % while clicks declined approximately 50 % and CTR roughly
halved. The short-window decline is therefore **not explained by broad visibility loss alone**.

**This is not a sitewide ranking collapse** and must not be described as one.

---

## 6. GSC structural findings

Exposure is not the constraint — conversion of exposure into clicks is, and the composition of that exposure is a
second, independent problem. Two structural observations are carried in their own sections because they change what
"more impressions" is worth: the ET homepage query mix (§10) and the RU sell-intent diffusion (§12), plus the observed
valuation ownership collision (§11).

The common thread: **raw impression growth and qualified seller visibility are not the same quantity**, so impression
movement alone cannot be used to judge recovery or regression of the owner-lead business.

---

## 7. Mobile / desktop findings

| Mobile (28D, EE) | Previous | Current | Change |
|---|---|---|---|
| Clicks | 29 | **8** | ≈ −72 % |
| Impressions | 1 163 | **1 146** | approximately flat |
| Average position | 8.09 | **8.03** | approximately flat |

**Interpretation:** exposure approximately flat, average position approximately flat, clicks declined approximately
72 %. **Mobile accounts for the majority of recent click loss.**

```
STATUS=MOBILE_CTR_PRIORITY
```

**Mobile landing-page UX failure must NOT be inferred from GSC alone.** GSC shows what happened in the result list, not
what happened after the click.

---

## 8. GA4 Organic EE findings

GA4 Estonia / Organic Search landing sessions (correct blocks per caveat 2):

| | Previous 28D | Current 28D |
|---|---|---|
| Sessions | 46 | **9** |

**GA4 history limit.** GA4 has **no usable history before 2026-07-01**. Consequently **no GA4-based historical
comparison before July 2026 is allowed** — in either direction, for growth or decline. **GSC remains the historical
search-performance source.** The 3-month GA4 file is current-state / coverage evidence only: its historical comparison
baseline is effectively zero and non-comparable, and it must not be used to claim 3-month growth, 3-month decline,
percentage change, SEO deterioration or tracking deterioration.

**Key-event caution.** Generic GA4 "Key events" values are **not** interpreted as `generate_lead` anywhere in this
document, because no export in the pack proves the metric was explicitly restricted to that event. The previously
verified `generate_lead` exactly-once implementation remains a separate subsystem and is **not reopened**.

---

## 9. GSC ↔ GA4 reconciliation

| Window | GSC clicks (EE, Web) | GA4 sessions (EE, Organic Search) | Approximate capture |
|---|---|---|---|
| Previous 28D | 52 | 46 | **88.5 %** |
| Current 28D | 26 | **9** | **34.6 %** |

```
VERDICT=MATERIAL_ORGANIC_MEASUREMENT_DIVERGENCE
```

**The missing sessions are NOT classified as SEO loss.** GSC clicks and GA4 sessions are not equivalent metrics, and a
divergence between them is a measurement question first.

**No tracking defect is claimed as proven.**

**Global GA4 outage is not supported.** Across the same comparison: Direct approximately flat, Referral increased,
Cross-network approximately flat.

```
GLOBAL_GA4_TAG_OUTAGE_SUPPORTED=NO
```

The divergence **appears organic-specific in this evidence**. Causality beyond that statement is not asserted — see
§4 caveats 3–5 and §15.

---

## 10. ET homepage query-mix findings

The ET homepage receives substantial visibility from:

- buyer intent;
- rental intent;
- broad real-estate intent;
- keyboard-layout / kv.ee confusion queries;
- other non-owner / non-seller queries.

```
RAW_ET_HOMEPAGE_IMPRESSIONS != QUALIFIED_SELLER_VISIBILITY
```

**Homepage impressions must not be treated as monetisable organic demand.** A rise or fall in that number carries no
direct information about qualified property-owner demand.

---

## 11. RU valuation ownership collision

Exact query: **`оценка недвижимости таллинн`** (3-month evidence).

- Primary relevant URL: `/ru/ocenka-kvartiry-v-tallinne/`
- The ET homepage `/` **also receives material visibility** on the same query.

```
CLASSIFICATION=OBSERVED_OWNERSHIP_COLLISION
```

This is **no longer a purely hypothetical collision** — it is observed in exact-query evidence. **Not fixed in this
task.**

---

## 12. RU sell-intent diffusion

Query cluster: **`+продать квартиру`** (contains filter, correctly scoped as a cluster).

- `/ru/kinnisvara-muuk/` **has entered the cluster where it previously had no visibility**.
- At the same time, `/ru/prodat-kvartiru-v-tallinne/` **has weakened in average position** in the structural comparison.

```
SELL_INTENT_DIFFUSION_OBSERVED
CANNIBALIZATION_RISK=OBSERVED
SOLE_CAUSALITY=NOT_PROVEN
```

The co-occurrence is observed; it does not by itself establish that the newly surfacing URL caused the weakening. **No
URL de-confliction is performed in this task.**

---

## 13. Batch 1A directional state

Batch 1A evidence in this pack is **DIRECTIONAL ONLY — not a T+21 gate**, because:

- the comparison covers only 12 days;
- **17 Sep is a mixed deployment day**;
- click volume is extremely low.

| Asset | Impressions | Average position |
|---|---|---|
| `/ru/makler-v-tallinne/` | 35 → **53** | 17.74 → **5.81** |
| `/ru/` | 98 → 60 | 18.93 → **8.27** |
| `/ru/tallinn/` | 140 → 58 | 25.01 → 24.64 |

On the **exact** head query `маклер`, the surfacing URL is still `/ru/` rather than `/ru/makler-v-tallinne/`.

```
BATCH_1A_STATUS=PARTIAL_DIRECTIONAL_RECOVERY
HEAD_QUERY_RECOVERY=NOT_CONFIRMED
FINAL_GATE=NOT_REACHED
```

**No rollback. No modification. Batch 1B is not started.**

---

## 14. Consent / CMP unresolved state

Previous repo / live-source inspection found:

- no CMP integration identifiable in CityEE-owned source;
- no explicit consent-default block before GTM in the inspected application source;
- GTM `GTM-5DRRX5ZJ` loads;
- GA4 `G-569W1W9H0W` exists in the GTM runtime.

However, **the user's real browser visibly renders a CookieScript consent banner.**

```
CMP_SOURCE=UNRESOLVED
COOKIESCRIPT_PRESENT_IN_BROWSER=YES
COOKIESCRIPT_PRESENT_IN_INSPECTED_CITYEE_SOURCE=NOT_OBSERVED
```

Likely possibilities include external / GTM / dynamic injection, **but this is NOT yet proven.** Owner-side GTM/GA4
evidence is required. **CookieScript and any consent logic must not be removed or modified.**

---

## 15. Required owner-side evidence

Recorded as **OPEN / NONBLOCKING for this documentation closure**, but **REQUIRED before measurement closure**. No
conclusion is fabricated for any item below.

| ID | Evidence | Why |
|---|---|---|
| A | GA4 Property Change History, approximately 2026-08-01 → 2026-09-30 | whether a property-level change coincides with the divergence window |
| B | GA4 Web Data Stream / data-collection / consent-related settings | whether collection scope changed |
| C | GTM `GTM-5DRRX5ZJ` version history, especially **2026-09-05 → 2026-09-12** | the comparison windows are split by this period |
| D | GTM current published container: consent / cookie / CMP related tags, triggers and variables | whether a gate exists in the live container |
| E | CookieScript integration source | resolves `CMP_SOURCE=UNRESOLVED` (§14) |
| F | Any consent default/update logic involving `analytics_storage`, `ad_storage`, `ad_user_data`, `ad_personalization` | the only mechanism class that would explain an organic-specific capture change |

---

## 16. Frozen experiments / do-not-touch register

**Frozen URLs — not modified in this task:**
`/ru/` · `/ru/makler-v-tallinne/` · `/ru/tallinn/` · `/ru/prodat-kvartiru-v-tallinne/` · `/ru/kinnisvara-muuk/` ·
`/ru/ocenka-kvartiry-v-tallinne/` · `/kinnisvara-hinnaanaluus-tallinn/`

**Not changed:** titles · H1 · body content · internal links · schema · canonical · hreflang · robots · CTA/form
contracts · GTM · GA4 · Ads · CookieScript · Consent Mode · `generate_lead`.

**Active clocks remain independent:**

| Experiment | T0 (Europe/Tallinn) |
|---|---|
| Batch 1A | 2026-09-17 15:39:20 EEST |
| RU Ocenka CRO O1 | 2026-09-20 19:56:16 EEST |
| ET Valuation CRO O1 | 2026-09-28 22:16:20 EEST |

This forensic is independent of those observation clocks: no T0 is reset, no experiment is evaluated early, and nothing
here is an SEO experiment verdict.

---

## 17. Next decision gate

Measurement closure cannot be reached from this evidence pack. The gate is **owner-side evidence A–F (§15)**, which
alone can distinguish between the remaining explanations for `MATERIAL_ORGANIC_MEASUREMENT_DIVERGENCE` — and until it is
supplied, the divergence stays classified exactly as recorded here: organic-specific in this evidence, with no proven
tracking defect and no global tag outage.

Separately and independently, the three experiment clocks in §16 reach their own gates on their own schedules. Neither
this document nor the evidence in it advances or settles any of them.

No implementation roadmap is defined here by design.
