# CITYEE — P0 Measurement Closure Gate (short gate before Search Revenue work)

**Дата:** 2026-09-10 · **GTM:** `GTM-5DRRX5ZJ` · **GA4:** `G-569W1W9H0W` · **Авторитетное событие:**
`generate_lead`. Задача: быстро и безопасно закрыть остаточную неопределённость измерения. **Не**
GLOBAL FAIL за отсутствие owner-скрина — шкала: `PASS / FAIL / OWNER_EVIDENCE_PENDING / NOT_APPLICABLE`.

> ## ИТОГОВЫЙ ВЕРДИКТ: **OWNER_EVIDENCE_PENDING**
> P0-дефектов **нет**. Ранее найденный дефект GTM снят owner-действиями (контролируемый тест: 1
> отправка формы → ровно один `generate_lead` в GA4 DebugView с `event_id`; `lead_form_submit`
> переведён в Secondary; Consent Mode с privacy-first default + update после Reject All). Для полного
> `MEASUREMENT_CLOSED` осталось **3 минимальных owner-подтверждения** (публикация GTM, инвентарь Ads
> целей, инбокс письма) — все нижеблокирующие по смыслу, но обязательные для честного закрытия.

---

## §2 — Четыре production-формы (обнаружены из кода, не угаданы)

| TEST_ID | FORM_NAME | FORM_TYPE | PUBLIC_URL (где показывается) | ENDPOINT | Success resp | DB | Email | dataLayer event |
|---|---|---|---|---|---|---|---|---|
| QA-01 | Callback (попап «Обратный звонок») | `callback` | глобальный попап (layout) на всех страницах | `POST /contact/callback` | `200 {status:OK, lead}` | 1 lead | 1 mail → info@cityee.ee | `generate_lead` |
| QA-02 | Inquiry (попап «Заявка») | `inquiry` | глобальный попап (layout); `/contact/inquiry` | `POST /contact/inquiry` | `200 {status:OK, lead}` | 1 lead | 1 mail | `generate_lead` |
| QA-03 | Audit request (v3) | `audit` | home, service-v3, intent, phase3-*, location, contacts, pillar-guide, cases | `POST /contact/audit-request` | `200 {status:OK, lead}` | 1 lead | 1 mail | `generate_lead` |
| QA-04 | Price calculator (v3) | `price_calculator` | те же v3-страницы | `POST /contact/price-calculator` | `200 {status:OK, lead}` | 1 lead | 1 mail | `generate_lead` |

Все 4 идут через один пайплайн: `ContactController::{handler}` → `LeadService::record()`
(**save-before-mail**) → `$this->ok($lead)` = `{status:OK, lead: analyticsPayload()}`. Событие лида —
только `generate_lead` (одно и то же для всех четырёх). callback/inquiry — обработчик `.ajax-form`
(main.js), audit/price — `[data-v3-form]` (form-scripts) — оба пушат `generate_lead` с `event_id`.

## §14 — Матрица приёмки

| PROOF | STATUS | Основание |
|---|---|---|
| Production schema | **PASS** | контролируемый inquiry-тест дал реальный `lead_public_id 01M23R7SE4KBB9TYHA6MVJN6P5` (ULID) + `event_id` → значит на проде таблица `leads` создала запись и `analyticsPayload` отработал |
| Form 1 (inquiry) DB | **PASS** | тот же live `lead_public_id` |
| Form 1 email | **OWNER_EVIDENCE_PENDING** | нужен один скрин инбокса info@cityee.ee по этому тесту |
| Form 1 generate_lead | **PASS (LIVE OWNER PROOF)** | 1× в GA4 DebugView, `event_id`, key event, без PII |
| Form 2 (callback) DB / email / generate_lead | **PASS (code-path) / PENDING / PASS (code-path)** | тот же handler и пайплайн, что inquiry; JS-матрица покрывает все 4 form_type |
| Form 3 (audit) DB / email / generate_lead | **PASS (code-path) / PENDING / PASS (code-path)** | тот же `record()`+`ok()`; `test_all_four_form_types_create_leads` |
| Form 4 (price) DB / email / generate_lead | **PASS (code-path) / PENDING / PASS (code-path)** | там же |
| Duplicate prevention | **PASS** | 10-мин HMAC `duplicate_fingerprint` + детерминированный `event_id`; `test_duplicate_submissions_create_one_lead`; в GTM теперь один тег на `generate_lead` → одна отправка = одно событие |
| Fallback production reachability | **UNREACHABLE_IN_PRODUCTION (PASS)** | прод `main.js?v=5` пушит `generate_lead` с `event_id` из объекта lead; `ContactController` всегда возвращает `lead` → ветка без `event_id` недостижима; owner-тест подтвердил наличие `event_id` |
| GA4 exactly-once architecture | **PASS** (+ §11 verify) | live inquiry: ровно один `generate_lead`; событие только после backend-успеха (success-allowlist), не на валидации/ошибке/failure — JS-матрица; нужно лишь подтвердить, что дубль-тег и all-pages-тег приостановлены (см. §11) |
| Google Ads conversion architecture | **OWNER_EVIDENCE_PENDING** | `lead_form_submit`→Secondary подтверждён; нужен скрин целей seller-кампаний + проверка кастом-цели |
| Consent default | **PASS** | owner: ad/analytics/ad_user_data/ad_personalization/functionality/personalization = denied, security = granted |
| Consent reject update | **PASS** | owner: отдельный consent update после Reject All |
| PII safety | **PASS** | `analyticsPayload` содержит только event_id/lead_public_id/form_type/source_class/submission_page/has_gclid; `test_analytics_payload_has_no_pii`; owner подтвердил отсутствие PII в payload |
| SEO non-regression | **PASS** | `cityee:render-check` 44/44; `seo:audit-links`/`seo:audit-intents` PASS; аналитический слой не трогает URL/canonical/hreflang/H1/контент |

## §4 — Реконсиляция (business truth = сохранённый лид)
Инвариант `1 успешная отправка = 1 канонический лид ≤ 1 бизнес-событие` держится:
- `lead_public_id` (ULID) генерится на создании Lead; `event_id = HMAC(public_id)` детерминирован (`test_event_id_is_deterministic_and_non_pii`).
- Owner-пример сходится: `form_type=inquiry`, `submission_page=/contact/inquiry`, `source_class=google_organic`, `has_gclid=false`, `event_id 948d59…a12c9`, `lead_public_id 01M23R7SE4KBB9TYHA6MVJN6P5`.
- Никогда: 1 submit → 2 DB-лида / 2 письма / 2 `generate_lead` (dedup §5 + один GTM-тег).

## §6 — Fallback
`UNREACHABLE_IN_PRODUCTION`. Основание выше; закрыто, P1-фикс не требуется.

## §12 — PII
`generate_lead` payload: `event_id, lead_public_id, form_type, source_class, submission_page,
has_gclid, form_name` — без name/email/phone/message. **PASS.** В артефактах реальные PII не печатаются.

---

## Осталось (минимальные owner-действия — только это блокирует MEASUREMENT_CLOSED)

### OWNER ACTION 1 — подтвердить ПУБЛИКАЦИЮ GTM + инвентарь (§11)
```
SYSTEM:  GTM (GTM-5DRRX5ZJ)
SCREEN:  Версии — какая версия ОПУБЛИКОВАНА (не только Preview); + список Теги
WHAT TO VERIFY / KEEP-REMOVE-VERIFY:
  - CookieScript CMP (Consent Initialization) ........ KEEP
  - GA4 тег generate_lead, триггер = Custom Event `generate_lead`, параметр event_id .. KEEP (проверить)
  - переменная event_id (DLV) ........................ KEEP
  - «GA4 - G-56M1W9H0W» (дубль generate_lead) ........ ПРИОСТАНОВЛЕН/УДАЛЁН?  (должно: да)
  - «Google Analytics Configuration» (generate_lead на All Pages) ... ПРИОСТАНОВЛЕН/УДАЛЁН? (должно: да)
  - любые несвязанные изменения в рабочей области ..... не должно быть
PASS: опубликована версия, где лид-тег на `generate_lead`+event_id, а дубль- и all-pages-теги выключены; посторонних изменений нет.
DO NOT CHANGE: contact_* теги, базовый Ter Google, поток G-569W1W9H0W.
```

### OWNER ACTION 2 — Google Ads: цели seller-кампаний (§9)
```
SYSTEM:  Google Ads → Кампании (релевантные seller Search) → Цели/Конверсии кампании
WHAT TO VERIFY:
  - Submit lead forms = ВЫБРАНО
  - Phone call leads  = ВЫБРАНО
  - Contacts / Get directions / Page views = НЕ выбрано
  - Единственное авторитетное website-form действие = `cityee.ee (web) generate_lead` (Primary)
  - `lead_form_submit` = Secondary (подтверждено)
  - Кастом-цель `ADME | REAL LEAD | Form Submit` — НЕ добавляет второй website-form сигнал в ставки
  - Нет другого Primary website-form действия, считающего ту же заявку CityEE
PASS: одна Primary website-form конверсия на заявку; телефон — отдельное реальное действие; лишние категории не выбраны.
DO NOT CHANGE: ничего не удалять/не менять — сначала прислать скрин; правки — отдельным шагом.
```

### OWNER ACTION 3 — инбокс письма (§7)
```
SYSTEM:  Почтовый ящик info@cityee.ee (или реальный ящик лидов)
WHAT TO VERIFY: письмо по контролируемому inquiry-тесту (тема «Новая заявка / Saada päring»), 1 шт, без дублей
PASS: одно письмо на одну принятую заявку.
```
*(Опционально: по одной контролируемой отправке для callback/audit/price + `php artisan leads:summary` —
чтобы поднять их с CODE-PATH до LIVE; не обязательно для закрытия при доказанной эквивалентности.)*

---

## Деплой сайта — НЕ требуется для закрытия
Прод уже отдаёт `generate_lead` c `event_id` (`main.js?v=5`), что совпадает с новым GTM-триггером.
Правки в репозитории (`main.js v=6` + `cityee-lead-tracking.js` + F4 `contact_link_click`) — **необязательная
уборка**; выкатывать **только после** подтверждения публикации GTM (иначе риск обвала измерения в ноль).

## §16 — 72 часа
Стартуют **после** трёх owner-подтверждений выше. Во время окна: стек измерения заморожен (кроме P0),
собираем реальные лиды/события, следим за duplicate rate и реконсиляцией DB/email/GA4/Ads. **Параллельно
можно начинать Search Revenue Regression Forensic — только READ-ONLY**, без прод-SEO-изменений.

## §17 — Граница
После закрытия и старта 72ч — СТОП измерения. Следующий приоритет: Search Revenue Regression Forensic +
Historical Winner Recovery + ET Seller Dominance. Эту задачу не расширять.
