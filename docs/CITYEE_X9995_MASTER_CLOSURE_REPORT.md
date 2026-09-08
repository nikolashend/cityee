# CITYEE X999⁵ — Полный отчёт закрытия: P0 Production Attribution + 72H Observability

**Дата:** 08.09.2026 · **Репозиторий:** ветка `main`, последние коммиты `58bae18` / `57c67bd` /
`b526649` · **GTM:** `GTM-5DRRX5ZJ` (cityee.ee), версия 11 «last».
**Покрывает:** изначальное TZ *«CLAUDE CODE TASK — CITYEE X999⁵ P0 PRODUCTION ATTRIBUTION CLOSURE +
72H REVENUE OBSERVABILITY»* + owner-evidence handoff-протокол + batch-схему + разбор пакета
скриншотов Александра (GTM/GA4/Ads).

---

## 0. Итоговый вердикт

> ## GLOBAL FAIL — доказанный дефект конфигурации GTM (реализация — PASS)
> Код Laravel/сайта корректен и без регрессий (**IMPLEMENTATION_PASS**). Но пакет владельца (GA4 +
> Google Ads + GTM) выявил **доказанный конфигурационный дефект** в контейнере `GTM-5DRRX5ZJ`,
> из-за которого лиды считаются неверно. Доказан дефект → это FAIL, не PENDING. Чинится тремя
> действиями в GTM (+ одна правка сайта, уже в коде). Серверная/почтовая/72ч части остаются
> заблокированы доступом и временем.

**Почему это не «PASS для сделанного» и не выдуманный PASS:** ни один production-proof,
требующий чужого доступа, не помечен PASS без реального доказательства; дефект GTM помечен FAIL,
потому что он **виден в самой конфигурации** (не предположение).

## §26 — Финальный формат вердикта
```
CITYEE X999⁵  PRODUCTION ATTRIBUTION CLOSURE

Commit:              17cc665 (impl) · 58bae18 (evidence/reports)
Production release:  UNKNOWN — сессия на локальном чекауте (APP_ENV=local); прод-доступа нет
Baseline start:      NOT STARTED

Proof 1 — Production schema:          SERVER_ACCESS_PENDING   (3 read-only команды на проде)
Proof 2 — Four live forms + email:    OWNER_EVIDENCE_PENDING  (инбокс + DebugView QA)
Proof 3 — GA4 exactly-once:           FAIL (config)           (F1 дубль + F2 all-pages + F3 mismatch + F6 нет event_id)
Proof 4 — Google Ads single Primary:  PASS (config)           (одна CityEE Primary, счёт «Одна»; зависит от F1/F6)
Proof 5 — Consent Mode:               OWNER_EVIDENCE_PENDING  (снимок «Обзор согласований» — Action C)

Dedup (код):          CONTAINED_UNREACHABLE   (серверный путь полный; но event_id не проброшен в GTM → F6)
SEO non-regression:   PASS (code-side)        (render-check 44/44; прод HTTP — pending)
Security red-team:    PASS (22) / 1 PARTIAL / 2 PENDING (GTM/Ads)

72H monitoring:       NOT STARTED (заблокировано до фикса GTM + повторной проверки)
14-day baseline:      NOT STARTED

Дефекты реализации (Laravel/сайт): 0
Дефекты измерения в GTM: P1 ×5 (F1,F3,F4,F6 + F7-pending), латентный P0 ×1 (F2)

GLOBAL VERDICT:  GLOBAL FAIL — доказанный дефект конфигурации GTM (реализация PASS)

NEXT SAFE ACTION:
  Александр применяет GTM Action A + B (убрать дубль/all-pages generate_lead;
  перевести единственный лид-тег на Custom Event `generate_lead` + проброс event_id),
  подтверждает в GA4 DebugView (реальная форма + клик WhatsApp). Затем сервер/почта/72ч.
```

## 1. Реальность доступа (кто что держит)
| Возможность | Держатель | За что отвечает |
|---|---|---|
| Репозиторий / код | Claude Code + Николай | реализация (доказано) |
| Прод-сервер (SSH/БД) | Николай / DevOps | миграции на проде, схема, кол-во лидов, mail pipeline |
| GA4 / GTM / Google Ads | Александр | аналитика, конверсии, consent |
| Почтовый ящик лидов | владелец инбокса | доказательство доставки письма |

Эта сессия работает на **локальном чекауте** (`APP_ENV=local`, прод-хоста CityEE в SSH нет) →
серверные proof’ы = `SERVER_ACCESS_PENDING`, аккаунтовые = `OWNER_EVIDENCE_PENDING`.

## 2. Что доказано на стороне кода (IMPLEMENTATION_PASS)
Основание: **38 PHP-тестов / 190 assertions** + **JS-матрица 50/50** (`tests/js/lead-tracking.test.cjs`) +
**render-check 44/44**.

| Инвариант | Доказательство |
|---|---|
| Save-before-mail (лид не теряется при сбое почты) | `test_lead_saved_even_when_mail_fails`, `test_no_js_server_post_still_persists_lead` |
| Одна отправка → один лид (дедуп) | `test_duplicate_submissions_create_one_lead` (HMAC-fingerprint, 10 мин) |
| Детерминированный не-PII `event_id` | `test_event_id_is_deterministic_and_non_pii` |
| Синтетический/тестовый клик ≠ реальная конверсия | `test_synthetic_gclid_is_flagged_test_and_suppresses_event`; JS-матрица 3/4/4b/5 |
| Нет PII в аналитике и логах | `test_analytics_payload_has_no_pii`; PII-логирование убрано из `ContactController` |
| Согласие отклонено — лид всё равно сохраняется | `test_consent_denied_still_persists_lead` |
| Экспорт маскирует PII + гасит CSV-инъекции | `test_export_masks_pii_by_default`, `test_export_escapes_csv_formula_injection` |
| Exactly-once emission (allowlist успеха, fail-closed) | JS-матрица 50/50 (JSON/legacy/HTML-200/204/422/500/net-fail/double-click/4 формы) |
| 4 формы — один attribution-safe пайплайн | все handler’ы `→ $this->ok($lead)`; `test_all_four_form_types_create_leads` |
| Дедуп-fallback | `dedup-production-verdict.md` — CONTAINED_UNREACHABLE |
| Ноль SEO/render регрессий (code-side) | `cityee:render-check` 44/44; `seo:audit-links`/`seo:audit-intents` PASS |
| Локальный контракт схемы | `production-attribution-schema-proof.txt` (33 колонки, is_test, unique public_id, 8 индексов) |

**Правка сайта F4 (уже в коде, деплой ПОСЛЕ GTM Action B):** клики по контактам теперь пушат
`contact_link_click` вместо `lead_submit_success` → клики не могут попасть в лид-конверсию.

## 3. Дефект конфигурации GTM — из пакета Александра (F1–F8)
Скриншоты доказывают **конфигурацию**, не runtime; масштаб подтверждается в DebugView.

| # | Находка | Серьёзность | Фикс |
|---|---|---|---|
| F1 | Два тега шлют `generate_lead` на один триггер `lead_submit_success` | P1 | Action A |
| F2 | «Google Analytics Configuration» шлёт `generate_lead` на **All Pages** (фантомный `G-56M1W9H0W`) | P1 (латентный P0) | Action A |
| F3 | Сайт пушит `generate_lead`, но единственный лид-триггер — `lead_submit_success` (триггера `generate_lead` нет) → формы могут не считаться | P1 | Action B |
| F4 | Клики по контактам пушат `lead_submit_success` → считаются как формы | P1 | сайт (после B) |
| F6 | `event_id` не проброшен ни на один GA4-тег → дедуп GA4↔Ads не доставлен | P1 | Action B |
| F7 | Consent Mode нигде не виден (ни в контейнере, ни в коде) | PENDING | Action C |
| F8 | Google Ads: единственная CityEE Primary `cityee.ee (web) generate_lead`, счёт «Одна» | ✅ PASS | не трогать |

Аккаунт Google Ads — **общий (ADME)**: другие Primary-конверсии принадлежат другим бизнесам
(Positum, Coralclean, adme), не CityEE. Подробный разбор + current state:
`docs/CITYEE_OWNER_EVIDENCE_ANALYSIS_GTM_GA4_ADS.md`.

## 4. Действия для закрытия
**GTM (Александр)** — детально в `docs/CITYEE_REPORT_FOR_ALEKSANDR.md` / `..._GTM_OWNER_ACTIONS_A_B_C.md`:
- **A** — убрать дубль-тег `GA4 - G-56M1W9H0W` и all-pages `Google Analytics Configuration` (F1/F2/F5).
- **B** — создать переменную `event_id` + Custom-Event триггер `generate_lead`; перевести единственный лид-тег на него и пробросить `event_id` (F3/F6).
- **C** — снять «Обзор согласований» (F7).
- Проверить в DebugView: форма → 1× `generate_lead` с `event_id` без PII; клик WhatsApp → 0×.

**Сайт (Claude, после B):** деплой правки F4 (`contact_link_click`).
**Сервер (Николай):** 3 read-only команды (`migrate:status | grep lead`, `hasColumn is_test`, `Lead::count()`).
**Почта (владелец инбокса):** одно письмо на каждую тестовую заявку.

## 5. Матрица изначального TZ (§1–§20) → статус → доказательство
| Раздел TZ | Статус | Доказательство / где |
|---|---|---|
| §1 Hard freeze (не менять SEO/контент/формы) | ✅ соблюдён | правки только в аналитике/тестах; render-check 44/44 |
| §2 Discovery | ✅ | `attribution-production-discovery.md` |
| §3 Инварианты INV-001…016 | ✅ (код) | тест-сьют §2 выше |
| §4 Backup + schema proof | ⏳ SERVER_ACCESS_PENDING | `production-attribution-schema-proof.txt` (локально GREEN + шаблон прод) |
| §5/§6 4 формы live QA + БД | ⏳ OWNER/SERVER_PENDING | `production-form-qa-results.csv` (скелет) |
| §7 GA4 exactly-once | ❌ FAIL (config) | analysis (F1/F2/F3/F6) |
| §8 Google Ads single Primary | ✅ PASS (config) | analysis (F8), `google-ads-conversion-inventory.csv` |
| §9 Дедуп event_id | ⚠️ не проброшен в GTM (F6) | `dedup-production-verdict.md` |
| §10 Consent Mode | ⏳ OWNER_EVIDENCE_PENDING | `consent-mode-production-proof.md` (Action C) |
| §11 Email delivery | ⏳ OWNER_EVIDENCE_PENDING | `form-mail-delivery-proof.csv` (скелет) |
| §12/§19 72ч мониторинг | `NOT_STARTED` | `CITYEE_72H_PRODUCTION_MONITORING_LOG.md` (шаблон) |
| §13 Read-only снапшот | ✅ | `LeadsSummaryCommand.php` (`leads:summary`) |
| §14 14-дневный baseline | `NOT_STARTED` | `CITYEE_14_DAY_REVENUE_INTELLIGENCE_BASELINE.md` (шаблон) |
| §15 Security red-team | ✅ 22 PASS / 1 PARTIAL / 2 PENDING | `CITYEE_ATTRIBUTION_RED_TEAM_EVIDENCE.md` |
| §16 SEO/UX no-regression | ✅ code-side | render-check 44/44; audit-links/intents PASS (прод HTTP — pending) |
| §17 Rollback | ✅ | `CITYEE_ATTRIBUTION_ROLLBACK_RUNBOOK.md` |
| §18 Deliverables | ✅ присутствуют | см. §6 ниже |
| §19/§26 Финальный вердикт | ✅ | этот отчёт + `CITYEE_X9995_P0_CLOSURE_FINAL_REPORT.md` |
| §20 Verdict rule | ✅ применён | GLOBAL FAIL (доказан дефект) |

## 6. Deliverables (§25) — индекс
`attribution-production-discovery.md` · `production-attribution-schema-proof.txt` ·
`production-form-qa-results.csv` · `ga4-production-lead-proof.md` ·
`google-ads-conversion-inventory.csv` · `consent-mode-production-proof.md` ·
`dedup-production-verdict.md` · `CITYEE_ATTRIBUTION_RED_TEAM_EVIDENCE.md` ·
`CITYEE_72H_PRODUCTION_MONITORING_LOG.md` · `CITYEE_14_DAY_REVENUE_INTELLIGENCE_BASELINE.md` ·
`CITYEE_PRODUCTION_ATTRIBUTION_CLOSURE_VERDICT.md` · `CITYEE_X9995_P0_CLOSURE_FINAL_REPORT.md` ·
`CITYEE_OWNER_EVIDENCE_HANDOFF_PROTOCOL.md` · `CITYEE_OWNER_EVIDENCE_REQUESTS.md` ·
`CITYEE_OWNER_EVIDENCE_ANALYSIS_GTM_GA4_ADS.md` · `CITYEE_GTM_OWNER_ACTIONS_A_B_C.md` ·
`CITYEE_REPORT_FOR_ALEKSANDR.md` · operator + rollback runbooks · **этот мастер-отчёт**.

## 7. Путь к GLOBAL PASS (последовательность)
1. Александр применяет **A + B (+ C)** в GTM, проверяет в DebugView, публикует, шлёт скрины.
2. Claude валидирует: форма = 1× `generate_lead` с `event_id`; клик = 0×. → §7 FAIL→PASS.
3. Николай выкатывает сайт (правка F4 уже в коде): `git pull` + `php artisan view:clear`. Порядок: **после** B.
4. Николай запускает 3 read-only команды на проде → §4 PASS.
5. Контролируемое live-QA 4 форм + проверка инбокса → §5/§6/§11 PASS.
6. Решение по Consent Mode (Action C) → §10.
7. Чистые **72 часа** → затем 14-дневный baseline.
8. Повторный вердикт: **GLOBAL PASS** только когда §4/§5/§7/§8/§10/§11 GREEN и 72ч без P0/P1.

## 8. Что НЕ трогали (freeze соблюдён)
URL/титулы/H1/canonical/hreflang/схема (кроме аналитики)/контент/дизайн/навигация/CTA/формы/
исторические лиды/кампании Google Ads/ставки/бюджеты/другие бизнесы аккаунта. Изменения только в
аналитическом слое (сайт F4 + предложенные GTM-действия) и в документации/тестах.
