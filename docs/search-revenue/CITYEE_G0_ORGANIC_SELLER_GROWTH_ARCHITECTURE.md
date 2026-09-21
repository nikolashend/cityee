# CITYEE X999⁵ — PHASE G0 · ORGANIC SELLER GROWTH ARCHITECTURE & HIGH-CONVERSION LP OPPORTUNITY MAP

**Date:** 2026-09-21 · **Mode:** READ-ONLY (no runtime/config/template/content change; docs only) ·
**Active experiments untouched:** Batch 1A (T0 2026-09-17 15:39:20 EEST) · Ocenka CRO O1 (T0 2026-09-20 19:56:16 EEST).
Companion artifacts: `CITYEE_G0_URL_INTENT_MATRIX.csv`, `CITYEE_G0_OPPORTUNITY_BACKLOG.csv`, `CITYEE_G0_CRO_CONTRACTS.csv`,
`CITYEE_G0_ET_GAP_MATRIX.csv`, `CITYEE_G0_NEW_LP_GATE.csv`, `CITYEE_G0_OWNER_EVIDENCE_REQUESTS.md`.
Evidence tags: DIRECT_REPO · DIRECT_PRODUCTION (live GET 2026-09-21) · DIRECT_GIT · LEVEL_3 (prior reconciled GSC) · HYPOTHESIS.

---

## A. EXECUTIVE VERDICT

**Strongest current organic seller architecture:** the **RU phase3 seller stack** — specialist money pages (`makler`, `prodat`,
`ocenka`, `ne-prodaetsya`, `audit-nedvizhimosti`, `sdat`), the Tallinn hub + 5 districts, 6 RU case studies, 7 RU intent pages,
governed by a real intent registry (`config/search_intents.php`) and well-linked (makler 69 / ocenka 68 inlinks, anchor
diversity 5). ET has the broadest *service* layer but **no specialist owners** for broker, agency, valuation-specialist,
"korter ei müü" umbrella, or geo; EN mirrors ET and carries one high-value authority asset (market analysis 2026).

**Biggest seller-intent gaps — by kind, in priority order:**
1. **RECOVERY (in progress):** RU MAKLER head-term ownership → Batch 1A running. Nothing else to do until its gate.
2. **CRO CONTRACT (systemic, PROVEN in code + production):** every ET/EN/RU template hardcodes **Audit form first** and (on
   intent/district templates) **primary CTA → Audit form** regardless of page intent. O1 fixed this on *one* URL. The ET
   valuation owner `/kinnisvara-hinnaanaluus-tallinn/` ("reaalne turuhind") therefore sends its primary CTA to the Audit form
   and lists Audit before valuation — the pre-O1 Ocenka defect, replicated. All 5 RU district *seller* pages have primary CTA
   "Получить аудит". This is the single largest, cheapest, evidence-backed lever after O1 reads out.
3. **TITLE-LEVEL OVERLAPS created in `a3ea5c0` (2026-03-11)** beyond the known MAKLER case: `/ru/kinnisvara-muuk/` was retitled
   from "Продать **недвижимость**…" to "Продать **квартиру** в Таллинне…", colliding with the tier-S winner
   `/ru/prodat-kvartiru-v-tallinne/` (created 03-10). ET: homepage H1 == `/kinnisvara-muuk/` H1 (identical sentence) —
   the ET analogue of the RU homepage collision, on the *sell* cluster. Both are PROVEN signal overlaps; GSC impact
   EVIDENCE_REQUIRED; both **blocked/sequenced** (RU by Batch 1A; ET by ET deferral).
4. **LANGUAGE (ET):** missing intent owners, not missing translations — broker/maakler (root `/` owns it by title only),
   agency, valuation specialist (intent page exists but wrong CRO contract), "korter ei müü" umbrella, geo hub/districts.
5. **PROPERTY TYPE:** apartment-only everywhere — **zero** house / land / commercial / house-part owner pages in any language
   (DIRECT_REPO: no titles). Owner demand for houses/land in Harjumaa is a plausible but **unevidenced** gap → EVIDENCE_REQUIRED.
6. **GEO:** RU districts = Lasnamäe, Mustamäe, Kesklinn, Haabersti, Kristiine only; no Põhja-Tallinn/Nõmme/Pirita; no Harjumaa
   municipality coverage; ET has no geo layer at all (`/locations/*` 301 → `/ru/tallinn/`).
7. **INTERNAL AUTHORITY:** the tier-S sell winner `/ru/prodat…` has the **fewest** inlinks of the money set (35) while the
   rental page has the most (107); `/ru/tallinn/` anchor diversity is 2 (generic).

**Build later (gated):** (a) ET valuation CRO contract fix (existing URL, config-gated like O1); (b) ET broker/sell ownership
de-confliction (existing URLs: root title/H1 vs `/kinnisvara-muuk/`); (c) one **house-sale** owner page per language *only*
after demand + information-gain evidence (market data with proper labelling); (d) a **Price Corridor tool** as the valuation
asset (tool > another static LP); (e) prodat internal-authority repair after Batch 1A.
**Explicitly NOT to build:** service×district farms, риелтор/риэлтор duplicate LPs, per-room-count pages, Harjumaa municipality
pages without evidence, RU→ET clones, any `hindamisakt` page (service not provided), one-LP-per-Ads-keyword.
**Blocked by Batch 1A:** anything touching `/ru/`, makler, tallinn (+districts), prodat, agentstvo, their anchors, and the
`/ru/kinnisvara-muuk/` title (it changes prodat's competitive set). **Blocked by O1:** Ocenka; replicating the valuation-first
pattern anywhere should wait for O1's T+14 read to learn first (not a hard block for ET, but the sensible order).
**Preparable now without contamination:** ET architecture briefs, LP gate dossiers, tool spec, market-data labelling spec,
intent-gate v2 extension (homepage/hub/H1 comparison), knowledge→money mapping, evidence requests.
**Owner evidence truly required:** none blocking. Nonblocking: ET GSC query→page for maakler/korteri müük/korteri hind; the
sell cluster (prodat vs kinnisvara-muuk) at the Batch 1A T+14 pull; O1 T+14 Ads/GA4 as already scheduled.
**Next separate implementation task (after gates):** **ET valuation CRO contract fix** on `/kinnisvara-hinnaanaluus-tallinn/`
(1 URL, CTA/form order only, config-gated, no SEO field) — independent of RU experiments, highest ET value, smallest change.

## B. CURRENT EXPERIMENT GUARDRAILS
Batch 1A: `/ru/` title only; frozen `/ru/`, `/ru/makler-v-tallinne/`, `/ru/tallinn/` (+ districts as its children),
`/ru/prodat…`, `/ru/agentstvo…`, broker anchors; no new competing RU URL; T+14 ≈ 10-01, T+21 ≈ 10-08 (GSC lag ok).
O1: Ocenka hero/CTA/forms/layout/SEO frozen; T+14 = 10-04, T+21 = 10-11; O2 NOT_STARTED. Ads: Ocenka ON (€5–7/day,
exact-first + controlled phrase), Makler/Audit PAUSED — not altered. This report **recommends only after gates**.

## C. EVIDENCE INVENTORY & CONFIDENCE
DIRECT_REPO: routes (94 GET), `search_intents.php`, `money_pages.php`, `seo_protected_assets.php` (21), `cityee-phase3.php`
(8 landings, 5 districts, 6 cases), `cityee-v3.php`, `cityee-intent.php`, `cityee-knowledge.php` (39 entries), templates,
`storage/app/audit/money-page-link-graph.csv`. DIRECT_PRODUCTION: 12 live pages checked (status/title/H1/canonical/forms/CTA).
DIRECT_GIT: `a3ea5c0` diff. LEVEL_3: 09-12/09-15 GSC reconciliation. SERP_LAYER_STATUS=UNAVAILABLE (no web access in this run;
nonblocking). No GSC rows fabricated.

## D. CURRENT URL ARCHITECTURE (see URL_INTENT_MATRIX.csv)
- **RU (richest):** home · 8 phase3 landings · `/ru/tallinn/` + 5 districts · 6 cases · 7 intent pages (analiz-ceny, audit-obyavleniya,
  kak-prodat-bystree, oshibki, prodat-samomu-vs-partner, prodayu-sam-nikto-ne-zvonit, prosmotry-est-predlozheniy-net) ·
  services (`kinnisvara-muuk`, `kinnisvara-uur`, `konsultatsioon`) · profile · why · knowledge/guides/audits.
- **ET:** home · services (`kinnisvara-muuk`, `kinnisvara-uur`, `konsultatsioon`, `audit`) · intent pages (`kinnisvara-hinnaanaluus-tallinn`,
  `kuulutuse-audit`, `kuidas-muua-kiiremini`, `muud-ise-keegi-ei-helista`, `vaatamised-aga-pakkumisi-pole`, `vead-kinnisvara-muugil`,
  `muua-ise-vs-strateegiline-partner`) · profile · why · knowledge/guides/audits · `/locations/{slug}` (deprecated → 301).
- **EN:** mirror of ET set + `real-estate-market-analysis-tallinn-2026` (authority asset).
- **Technical:** all checked pages 200, self-canonical, indexable; no P0 found. `P0_DISCOVERED=NO`.
- **Intent-gate limitation (confirmed 09-12 by run + code):** `seo:audit-intents` compares registry primaries only; homepage,
  language homepages, geo hubs and H1-level overlap are outside its comparison → both `a3ea5c0` collisions passed CI.

## E. SELLER JOURNEY ARCHITECTURE
| stage | query types | seller strength | RU owner | ET owner | gap |
|---|---|---|---|---|---|
| 1 awareness/market | цены на квартиры, turg | low–mixed | knowledge/market analyses | knowledge | fine — supporting only |
| 2 price/value discovery | оценка/сколько стоит/стоимость · korteri hind/hindamine/turuhind | **high** | `/ru/ocenka…` (O1) | `/kinnisvara-hinnaanaluus-tallinn/` | ET CRO contract broken (audit-first) |
| 3 preparing to sell | как подготовить, документы | mid-high | knowledge + prodat | kuidas-muua-kiiremini / knowledge | ok |
| 4 DIY research | продать самому, ise müüa | mid | `/ru/prodat-samomu-vs-partner/` | `/muua-ise-vs-strateegiline-partner/` | ok |
| 5 choosing broker | маклер/риелтор/агентство · maakler/kinnisvaramaakler | **high** | makler (1A), agentstvo | **root `/` by title only** | ET no specialist; ET agency absent |
| 6 failed DIY / no calls / no viewings | не продаётся, никто не звонит · korter ei müü, keegi ei helista | **high** | ne-prodaetsya, no_calls, no_offers, audit | no_calls, no_offers, kuulutuse-audit | ET lacks the umbrella "miks korter ei müü" owner |
| 7 listing optimisation | аудит объявления · kuulutuse audit | high | audit-nedvizhimosti, audit-obyavleniya | kuulutuse-audit | ok |
| 8 transaction prep | нотариус, договор | mid | knowledge | knowledge | fine |
| 9 property-type | дом/земля/коммерческая · maja/kinnistu/ärikinnisvara | **high (owner)** | **none** | **none** | PROPERTY_TYPE_GAP (all languages) |
| 10 geo seller | продать квартиру Lasnamäe … | high | 5 districts (CTA→audit) | none | GEO_GAP ET; RU district CRO mismatch |
| 11 landlord | сдать квартиру · üürileandmine | mid | sdat, kinnisvara-uur (107 inlinks) | kinnisvara-uur | over-linked vs seller pages |
| 12 commercial owner | ärikinnisvara müük | mid-high | none | none | gap, evidence required |

## F. SELLER INTENT UNIVERSE (structured, not a keyword dump)
RU families: MAKLER · MAKLER_TALLINN · MAKLER_V_TALLINNE · RIELTOR · RIELTOR_YO · AGENCY · SELL_APARTMENT · APARTMENT_VALUE ·
VALUATION · HOW_MUCH_CAN_I_SELL · FAILED_SALE · NO_CALLS · NO_VIEWINGS/NO_OFFERS · LISTING_AUDIT · SELL_HOUSE · SELL_LAND ·
SELL_COMMERCIAL · LANDLORD · SELLER_DISTRICT · SELLER_HARJUMAA · COMMISSION · SALE_STRATEGY · SALE_PREP · TRANSACTION_DOCS.
ET seed concepts (OBSERVED_GSC = NO unless owner data says otherwise): maakler · kinnisvaramaakler · korteri müük · kuidas müüa
korterit · korteri hind · korteri väärtus · kinnisvara hindamine · müügihind · maja müük · kinnistu/maa müük · ärikinnisvara müük ·
korter ei müü · miks korter ei müü · maakleritasu · müügistrateegia · Tallinn + districts · Harjumaa + municipalities.
EN: foreign owner selling, expat seller, investor exit, relocation sale, market research — commercial share EVIDENCE_REQUIRED.
Business-intent model (§M): "сколько стоит моя квартира" = HIGH_SELLER; "сколько стоит 1-комнатная квартира" = MIXED/RESEARCH_HEAVY
(QS 1/10 reflects mismatch *and* weak business intent — do not optimise toward it); "оценочный акт / hindamisakt" =
PROFESSIONAL_SERVICE (bank valuation) — CITYEE does not issue it → do not target.

## G. INTENT OWNERSHIP REGISTRY V2 (analytical; see URL_INTENT_MATRIX.csv)
| cluster | primary owner | supporting | unintended competitors | conflict class | evidence |
|---|---|---|---|---|---|
| RU MAKLER | `/ru/makler-v-tallinne/` | profile, why | `/ru/` (title removed 1A), `/ru/tallinn/` (trailing "Маклер по районам"), districts ("— маклер CityEE" in titles) | PROVEN_OWNERSHIP_COLLISION → RECOVERY_IN_PROGRESS | LEVEL_3 |
| RU SELL_APARTMENT | `/ru/prodat-kvartiru-v-tallinne/` | kinnisvara-muuk, kak-prodat-bystree, oshibki | **`/ru/kinnisvara-muuk/` title "Продать квартиру в Таллинне…"** (a3ea5c0); districts "Продать квартиру в X" | PROVEN_OVERLAP (signal) · GSC impact EVIDENCE_REQUIRED | DIRECT_PRODUCTION+GIT |
| RU VALUATION | `/ru/ocenka…` | analiz-ceny, audit | none at title level | NO_CONFLICT (control) | LEVEL_3 |
| RU AGENCY | `/ru/agentstvo…` | makler, why | `/ru/o-kompanii/` (company) | POSSIBLE_OVERLAP | DIRECT_REPO |
| RU FAILED_SALE | `/ru/ne-prodaetsya…` | no_calls, no_offers, audit | audit-nedvizhimosti (both "аудит" claims) | BENIGN_SUPPORT | DIRECT_REPO |
| ET SELL | `/kinnisvara-muuk/` | kuidas-muua-kiiremini | **root `/` H1 identical** | PROVEN_OVERLAP (H1) · impact EVIDENCE_REQUIRED | DIRECT_PRODUCTION |
| ET BROKER (maakler) | **NO_OWNER** (root title de-facto) | — | — | NO_OWNER | DIRECT_PRODUCTION |
| ET VALUATION | `/kinnisvara-hinnaanaluus-tallinn/` | audit | none | NO_CONFLICT · CRO broken | DIRECT_PRODUCTION |
| ET FAILED_SALE | split: no_calls / no_offers / kuulutuse-audit | — | none | AMBIGUOUS_OWNER (no umbrella) | DIRECT_REPO |
| ET AGENCY / GEO / PROPERTY_TYPE | NO_OWNER | — | — | NO_OWNER | DIRECT_REPO |

## H. HISTORICAL WINNER PROTECTION → `CITYEE_G0…` Do-Not-Touch (§AC). Enhancement surfaces that do **not** touch ownership
signals: content modules below the fold, proof/method blocks, internal inbound links from knowledge (after gates), CRO CTA/form
order (page-specific, config-gated) — never title/H1/URL/canonical wholesale.

## I. EXISTING-URL-FIRST FINDINGS
Every major RU/ET intent already has a plausible existing URL except: property types (house/land/commercial), ET broker, ET agency,
ET geo. For all others: `STRENGTHEN_EXISTING_URL` or `CRO_ONLY_CANDIDATE` beats a new LP.

## J. CANNIBALIZATION / OWNERSHIP RISKS (ranked)
1 RU MAKLER (recovery running) · 2 RU SELL: `/ru/kinnisvara-muuk/` vs prodat (title, same commit pattern) · 3 ET SELL: root H1 vs
`/kinnisvara-muuk/` · 4 RU districts: "Продать квартиру в X — маклер CityEE" titles carry both sell + broker head terms →
low-grade broker competition (watch with 1A) · 5 agentstvo vs o-kompanii (company/agency) · 6 RU intent pages
`analiz-ceny-nedvizhimosti-tallinn` vs ocenka (both price) — currently BENIGN_SUPPORT per registry.

## K. RU GROWTH ARCHITECTURE (after recovery)
RECOVERY: Batch 1A → possible 1B (tallinn) only on evidence. EXISTING_URL_UPLIFT: (i) de-conflict `/ru/kinnisvara-muuk/` title back
toward "недвижимость" (BLOCKED_UNTIL_BATCH_1A_GATE — changes prodat's set); (ii) prodat internal authority (35 inlinks → contextual
anchors from knowledge; WAIT_BATCH_1A); (iii) district CRO: primary CTA audit → sell/valuation (WAIT_BATCH_1A + WAIT_O1). CRO: Ocenka
O1 running; Makler CRO ("Обсудить продажу квартиры / Получить стратегию продажи" as primary, valuation secondary) =
BLOCKED_BY_ACTIVE_EXPERIMENT. NEW_INTENT: house-sale owner page (gated), Price Corridor tool. No new RU URL during 1A.

## L. ET GROWTH ARCHITECTURE (see ET_GAP_MATRIX.csv) — ET_PRODUCTION_STATUS=DEFERRED
ET_EXISTING_URL_UPLIFT: 1) `/kinnisvara-hinnaanaluus-tallinn/` CRO contract (primary CTA → valuation form, valuation first) ★;
2) ET sell de-confliction (root H1 vs `/kinnisvara-muuk/`); 3) `/kuulutuse-audit/` pain-first framing (audit page only); 4) ET homepage
CTA/form order (audit-first). ET_NEW_INTENT_CANDIDATES: "miks korter ei müü" umbrella (distinct JTBD, ET has only fragments) —
gate PARTIAL (demand evidence required); "maja müük Harjumaal" (property type) — gate EVIDENCE_REQUIRED; ET maakler specialist —
**HOLD**: root currently owns it by title; creating a specialist without de-conflicting root would re-create the RU MAKLER
collision in ET → sequence is de-conflict-then-build, evidence first. ET_REJECT: district×service ET pages, literal RU clones,
hindamisakt page. Parity rule applied: by intent, not by page count.

## M. EN STRATEGIC ROLE
Protect `/en/knowledge/real-estate-market-analysis-tallinn-2026/` (authority; trilingual hreflang). EN seller pages mirror ET
(sell-property, listing-audit…) with the same audit-first contract. Commercial EN seller volume EVIDENCE_REQUIRED; do not expand.
KEEP_AS_IS + CRO_ONLY_CANDIDATE (same fix class), lowest priority.

## N. GEO ARCHITECTURE
Hierarchy: `/ru/tallinn/` hub → 5 districts (seller-district intent, CTA→audit mismatch). Missing districts (Põhja-Tallinn, Nõmme,
Pirita) and all Harjumaa = **EVIDENCE_REQUIRED** — no page until GSC/Ads terms show seller demand + unique local info exists.
Kristiine 751 impr/0 clicks (P2) suggests buyer/informational mix on a seller page → classify queries before touching.
ET geo: none; do not clone RU hub. Doorway protection applies (§AD).

## O. PROPERTY-TYPE ARCHITECTURE
APARTMENT: full coverage. HOUSE / HOUSE_PART / LAND / COMMERCIAL: **no owner page in any language**; only prose mentions.
Market prose exists (e.g. "Haabersti 2 200–3 200 €/m²", "Kesklinn ~3 000–4 500 €/m²") **without source/date/asking-price
labelling** → MARKET_DATA_LABELLING_GAP (report only). Recommendation: one **house-sale** owner page per priority language is the
only property-type candidate with plausible owner demand + information-gain path (datasets) → NEW_LP_GATE = EVIDENCE_REQUIRED.
LAND/COMMERCIAL: EVIDENCE_REQUIRED, lower priority. RENTAL_OWNER: covered (sdat/kinnisvara-uur).

## P. CRO CONVERSION CONTRACTS (see CRO_CONTRACTS.csv) — the systemic finding
Templates hardcode: `service-v3`, `intent`, `home`, `phase3-district`, `phase3-landing` → **audit-request form first, price-calculator
second**; `intent` and `phase3-district` → **primary CTA → `#v3-form-audit`**. Consequences: CONTRACT_COHERENT only where intent *is*
audit (kuulutuse-audit, audit-nedvizhimosti, ne-prodaetsya, audit-obyavleniya) and on Ocenka post-O1. MATERIAL_MISMATCH:
`/kinnisvara-hinnaanaluus-tallinn/` (valuation → audit CTA), all 5 RU districts (sell → audit CTA), `/ru/analiz-ceny…` (price → audit),
`/en/property-price-analysis-tallinn/`. MINOR_MISMATCH: sell pages (`kinnisvara-muuk` ×3 languages, prodat: strategy CTA → audit form),
homepages (audit-first order). Makler: "Получить аудит объекта" primary — coherent with template, but the *ideal* broker contract is
"discuss the sale / get a sale strategy" (BLOCKED_BY_ACTIVE_EXPERIMENT). Audit ideal: pain-first "Квартира не продаётся? Разберём,
где теряется покупатель" (AUDIT_CRO_STATUS=DEFERRED).

## Q. INTERNAL AUTHORITY GRAPH (money-page-link-graph.csv, DIRECT_REPO)
`/` 110 · `/ru` 129 · `/ru/kinnisvara-uur` **107** (rental — over-weighted) · makler 69 (div 5) · ocenka 68 (div 5) · profile 61 ·
tallinn 56 (**div 2**, generic) · agentstvo 36 · **prodat 35 (lowest)**. Findings: seller tier-S sell page under-linked vs rental;
tallinn anchors generic; broker anchors are specific and correct (reinforce makler). Recommendation map (future, after 1A):
contextual "продать квартиру…" anchors from knowledge/cases → prodat; diversify tallinn anchors toward district-seller semantics;
no anchor changes now.

## R. KNOWLEDGE → MONEY FLOW
39 knowledge entries; crosslinks partial routes to makler/prodat/ocenka. Selling-advice and pricing articles → SUPPORTS_OWNER;
market analyses (EN 2026, RU/ET equivalents) → UNUSED_AUTHORITY for valuation/house intents (no property-type destination);
district market prose sits on location/district pages, not linked to a valuation asset → OVERLAP_RISK low, opportunity medium.

## S. INFORMATION GAIN AUDIT (seller pages)
Ocenka: STRONG (method, comparables incl. reserved, corridor logic, FAQ). Makler/prodat/agentstvo: ADEQUATE→STRONG (process, 30–45-day
strategy, commission logic, cases). Districts: ADEQUATE (district prose, unsourced €/m²). ET service/intent pages: ADEQUATE, less
first-party evidence than RU. Knowledge market analyses: STRONG/FIRST_PARTY where dated. Gap: no FIRST_PARTY_EVIDENCE_RICH page for
house/land; unsourced price ranges reduce trust → labelling spec needed before any market-data expansion.

## T. MARKET INTELLIGENCE OPPORTUNITIES
Datasets referenced only as prose today. Future architecture: a labelled market module (source · date · sample · method ·
**asking-price, not transaction** caveat) reusable on ocenka/districts/house page; feeds the Price Corridor tool. No implementation.

## U. TOOL OPPORTUNITIES (see backlog W5)
**Price Corridor Calculator** — TOOL_CANDIDATE (valuation intent, lead capture = existing calc form, information gain high,
maintenance medium; standalone URL not required initially — embed on Ocenka/ET valuation after O1/O2 evidence).
**Why Is My Listing Not Selling? diagnostic** — TOOL_CANDIDATE for failed-sale (pain-first), pairs with Audit CRO (deferred).
**Sale Readiness Score / Seller Checklist / Timeline Estimator** — WATCH (lower search fit; content-module first).

## V. NEW LP CANDIDATE GATE RESULTS (see NEW_LP_GATE.csv)
House-sale owner page (RU/ET): G0-LP-01 ✓ 02 EVIDENCE_REQUIRED 03 ✓ 04 ✓ 05 ✓ (datasets) 06 ✓ 07 ✓ 08 ✓ 09 ✓ 10 ✓ 11 ✓ 12 ✓ →
**NEW_LP_CANDIDATE (gated on demand evidence)**. ET "miks korter ei müü": 01 ✓ 02 EVIDENCE_REQUIRED 03 partial (fragments exist) →
EVIDENCE_REQUIRED. ET maakler specialist: 03/04 ✗ until root de-conflicted → HOLD. Harjumaa municipality pages, extra districts,
land, commercial: EVIDENCE_REQUIRED. All doorway patterns: REJECT_DO_NOT_CREATE.

## W. EXISTING URL UPLIFT BACKLOG → `CITYEE_G0_OPPORTUNITY_BACKLOG.csv` (W1–W9 with scores, dependencies, change types).

## X. SEARCH / TRAFFIC QUALITY MODEL
KPI hierarchy: 1 Qualified Seller Visibility (query×URL ownership on HIGH_SELLER families) → 2 Qualified organic sessions →
3 Qualified owner leads (`generate_lead`, non-test, owner-classified) → 4 Meetings → 5 Exclusives → 6 Transactions.
Do not equate visibility/traffic/leads. Opportunity classes used in the backlog: HIGH_INTENT_WRONG_OWNER (RU sell, ET sell),
STRONG_PAGE_WEAK_CRO (ET valuation, districts), HIGH_INTENT_NO_OWNER (ET maakler, house), GEO_GAP, PROPERTY_TYPE_GAP, LANGUAGE_GAP.

## Y. SELLER OPPORTUNITY SCORES → backlog CSV (0–100, with confidence and risk penalties; no false precision).

## Z. EVIDENCE GAPS
NONBLOCKING: ET GSC query→page (maakler / korteri müük / korteri hind / kinnisvara hindamine); RU sell cluster GSC (prodat vs
kinnisvara-muuk); house/land demand; Harjumaa demand; EN seller share; SERP layer. BLOCKING: none for architecture preparation.

## AA. OWNER EVIDENCE REQUESTS → `CITYEE_G0_OWNER_EVIDENCE_REQUESTS.md` (batched into the already-scheduled T+14 pulls; none blocking).

## AB. FUTURE IMPLEMENTATION WAVES
Wave 0 (now): observe 1A + O1 + Ads validation; prepare briefs/specs. Wave 1 (after O1 T+14, ET approval): ET valuation CRO
contract fix (1 URL). Wave 1b (after 1A T+21): `/ru/kinnisvara-muuk/` title de-confliction; prodat authority repair; district CTA
fix. Wave 2 (ET): ET sell de-confliction (root H1 vs kinnisvara-muuk); ET homepage/service audit-first fix; ET failed-sale umbrella
(if evidence). Wave 3: house-sale LP (if gate passes). Wave 4: knowledge→money contextual links; intent-gate v2 tooling. Wave 5:
Price Corridor tool. Wave 6: geo/property expansion only on evidence.

## AC. DO-NOT-TOUCH REGISTER
`/ru/`, `/ru/makler-v-tallinne/`, `/ru/tallinn/` (+ districts), `/ru/prodat…`, `/ru/ocenka…`, `/ru/agentstvo…`, `/ru/kinnisvara-muuk/`
(title affects prodat set — until 1A gate), ET production pages, EN pages incl. market-analysis 2026, GTM/GA4/Ads/CMP, forms and
tracking logic, canonical/hreflang/schema/redirect/sitemap logic, `search_intents.php` runtime registry.

## AD. DO-NOT-CREATE REGISTER
service×district pages (makler-lasnamae…, sell-apartment-mustamae…); риелтор vs риэлтор duplicate LPs; one LP per Ads keyword;
one page per room count ("1-комнатная…"); tiny-locality pages without distinct value; AI-generated market pages without dated,
sourced data; literal RU→ET clones; any `hindamisakt`/оценочный акт page (service not provided); FAQ-schema-for-rich-results pages;
new RU URLs competing with the broker/sell clusters during Batch 1A.

## AE. NON-REGRESSION / ROLLBACK FRAMEWORK (for every future batch)
PRIMARY KPI per change type (ownership → query×URL; CRO → qualified lead conversion; new LP → qualified seller visibility + leads) ·
PROTECTED KPI (existing owner rankings, brand, other clusters) · REGRESSION SURFACE (which frozen URLs/anchors) · CHANGE BUDGET
(1 URL / 1 field or 1 module) · OBSERVATION (T+3–7 sanity, T+14 directional, T+21 gate, low volume → HOLD) · ROLLBACK (exact
prior value, single commit). Experiment isolation status recorded per item in the backlog.

## AF. NEXT RECOMMENDED TASK
After O1's T+14 read (≈2026-10-04) and a separate ET approval: **"ET CRO O1: valuation-first contract on
`/kinnisvara-hinnaanaluus-tallinn/`"** — config-gated (same pattern as RU O1: per-page CTA targets + form order), 1 URL, 0 SEO
fields, no RU cluster interference. Parallel, after Batch 1A T+21: Batch 1C evidence check on the RU sell cluster.

## AG. MACHINE-READABLE VERDICT
```
G0_STATUS=COMPLETE_READ_ONLY
PRODUCTION_CHANGED=NO
RUNTIME_FILES_CHANGED=0
P0_DISCOVERED=NO
STRONGEST_ARCHITECTURE=RU_PHASE3_SELLER_STACK
PRIMARY_GAP_TYPE=CRO_CONTRACT_SYSTEMIC (audit-first forms / audit-targeted primary CTAs)
SECONDARY_GAP_TYPES=TITLE_OVERLAP_A3EA5C0 (RU sell, ET sell) · LANGUAGE_GAP_ET (broker/agency/valuation-CRO/geo/failed-sale umbrella) · PROPERTY_TYPE_GAP (house/land/commercial) · AUTHORITY (prodat under-linked)
RU_SELL_CLUSTER_OVERLAP=PROVEN_SIGNAL (/ru/kinnisvara-muuk/ title vs /ru/prodat…) · GSC_IMPACT=EVIDENCE_REQUIRED · STATUS=BLOCKED_UNTIL_BATCH_1A_GATE
ET_SELL_CLUSTER_OVERLAP=PROVEN_SIGNAL (root H1 == /kinnisvara-muuk/ H1) · GSC_IMPACT=EVIDENCE_REQUIRED · STATUS=ET_DEFERRED
ET_BROKER_OWNER=NO_OWNER (root by title) · ACTION=HOLD_DECONFLICT_BEFORE_BUILD
ET_VALUATION_CRO=MATERIAL_MISMATCH (primary CTA → audit form; audit-first) · STATUS=NEXT_TASK_CANDIDATE_AFTER_O1_T14
RU_DISTRICT_CRO=MATERIAL_MISMATCH (primary CTA → audit) · STATUS=WAIT_BATCH_1A+O1
HOUSE_SALE_LP=NEW_LP_CANDIDATE_GATED_ON_EVIDENCE
PRICE_CORRIDOR_TOOL=TOOL_CANDIDATE
MARKET_DATA_LABELLING=GAP_REPORTED (no source/date/asking-price labels)
BATCH_1A_INTERFERENCE=NONE · O1_INTERFERENCE=NONE · ADS_CHANGES=0 · ET_PRODUCTION_CHANGES=0 · BATCH_1B=DEFERRED_WATCH_ONLY · O2=NOT_STARTED
OWNER_EVIDENCE_BLOCKING=NO
SERP_LAYER_STATUS=UNAVAILABLE
NEXT_TASK=ET valuation-first CRO contract fix on /kinnisvara-hinnaanaluus-tallinn/ (after O1 T+14 + ET approval)
```
