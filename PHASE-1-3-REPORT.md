# CITYEE.EE — Отчёт по реализации PHASE 1–3

**Дата:** 2026-03-15  
**Branch:** `main` | **Последний коммит:** `634a5ce`  
**Среда:** локальный dev-сервер (port 8001)

---

## 1. Architecture & Index Lock (PHASE 1)

### 1.1 Canonicals

Каждая страница выводит `<link rel="canonical" href="https://cityee.ee/.../">` с production-доменом. Проверено на 10 ключевых страницах — всё корректно.

| Страница | Canonical |
|---|---|
| ET Home `/` | `https://cityee.ee/` |
| RU Home `/ru/` | `https://cityee.ee/ru/` |
| EN Home `/en/` | `https://cityee.ee/en/` |
| RU Sell `/ru/kinnisvara-muuk` | `https://cityee.ee/ru/kinnisvara-muuk/` |
| P3 Makler `/ru/makler-v-tallinne` | `https://cityee.ee/ru/makler-v-tallinne/` |
| P3 Ocenka `/ru/ocenka-kvartiry-v-tallinne` | `https://cityee.ee/ru/ocenka-kvartiry-v-tallinne/` |
| RU Profile `/ru/aleksandr-primakov` | `https://cityee.ee/ru/aleksandr-primakov/` |
| RU Audit `/ru/audit` | `https://cityee.ee/ru/audit/` |
| RU Guides `/ru/guides` | `https://cityee.ee/ru/guides/` |
| ET Sell `/kinnisvara-muuk` | `https://cityee.ee/kinnisvara-muuk/` |

**Статус: ✅ PASS** — нет конфликтов canonical, trailing-slash нормализован, production-домен.

### 1.2 Hreflang

- **Трёхъязычные страницы** (home, sell, rent, consultation, contacts, why, audit, knowledge, guides, audits, profile, intent pages): 4 тега hreflang (`et-EE`, `ru-EE`, `en-EE`, `x-default` → ET).
- **Phase 3 RU-only страницы** (makler, ocenka, prodat и др.): 2 тега (`ru-EE`, `x-default` → RU). Корректно — ET/EN версий не существует.
- **x-default**: ET для трёхъязычных страниц, RU для RU-only страниц.
- Кросс-проверка: ET Home / RU Home / EN Home — идентичные наборы hreflang. Нет петель, нет асимметрии.

| Страница | et-EE | ru-EE | en-EE | x-default |
|---|---|---|---|---|
| Home | `https://cityee.ee/` | `https://cityee.ee/ru/` | `https://cityee.ee/en/` | ET |
| Sell | `/kinnisvara-muuk/` | `/ru/kinnisvara-muuk/` | `/en/sell-property/` | ET |
| Intent (No Calls) | `/muud-ise-keegi-ei-helista/` | `/ru/prodayu-sam-nikto-ne-zvonit/` | `/en/selling-yourself-no-calls/` | ET |
| P3 Makler | — | `/ru/makler-v-tallinne/` | — | RU |
| P3 Ocenka | — | `/ru/ocenka-kvartiry-v-tallinne/` | — | RU |

**Статус: ✅ PASS**

### 1.3 Robots.txt

```
User-agent: *
Allow: /

Disallow: /admin
Disallow: /login
Disallow: /register
Disallow: /storage/
Disallow: /vendor/
Disallow: /node_modules/
Disallow: /resources/
Disallow: /bootstrap/
Disallow: /config/
Disallow: /database/
Disallow: /tests/
Disallow: /index
Disallow: /index.html
Disallow: /index.php
Disallow: /*?sort=
Disallow: /*?utm_
Disallow: /*?fbclid=
Disallow: /*?gclid=
Disallow: /*?yclid=
Disallow: /*?category=
Disallow: /*?type=
Disallow: /*?q=

User-agent: GPTBot
Allow: /

User-agent: Google-Extended
Allow: /

User-agent: ChatGPT-User
Allow: /

User-agent: Bingbot
Allow: /

User-agent: PerplexityBot
Allow: /

Sitemap: https://cityee.ee/sitemap.xml
```

**Статус: ✅ PASS**

### 1.4 Sitemap

4-файловый Sitemap Index на `/sitemap.xml`:

| Файл | URL-ы | Описание |
|---|---|---|
| `sitemap-main.xml` | 81 | Все статические страницы (ET + RU + EN), с xhtml:link hreflang |
| `sitemap-guides.xml` | 15 | Гайды из БД (5 slug × 3 locale), с hreflang |
| `sitemap-audits.xml` | 9 | Аудиты из БД, с hreflang |
| `sitemap-phase3.xml` | 21 | Phase 3 RU-only лендинги, GEO-хаб, районы, кейсы |
| **ИТОГО** | **126** | |

**Статус: ✅ PASS**

### 1.5 Redirect Map

- `CanonicalRedirects` middleware → 301 редирект на trailing-slash.
- `RedirectOldUrls` middleware → обработка устаревших URL.
- Цепочки редиректов: **не обнаружены**.

### 1.6 Инвентарь индексируемых страниц

| Категория | Кол-во | Статус |
|---|---|---|
| ET статические страницы | 13 | ✅ 200 OK |
| RU статические страницы | 13 | ✅ 200 OK |
| EN статические страницы | 13 | ✅ 200 OK |
| Phase 3 RU лендинги | 8 | ✅ 200 OK |
| Phase 3 GEO-хаб | 1 | ✅ 200 OK |
| Phase 3 районы | 5 | ✅ 200 OK |
| Phase 3 Cases hub | 1 | ✅ 200 OK |
| Phase 3 Case detail | 6 | ✅ 200 OK |
| Phase 4 RU intent | 7 | ✅ 200 OK |
| Phase 4 EN intent | 7 | ✅ 200 OK |
| Phase 4 ET intent | 7 | ❌ **500 ERROR** |
| Guide detail pages | 15 | ✅ 200 OK |
| Sitemaps + robots.txt | 6 | ✅ 200 OK |
| **Итого OK** | **~95** | |

### 1.7 Обнаруженные ошибки

| Ошибка | Страницы | Причина |
|---|---|---|
| **500** на 7 ET intent страницах | `/muud-ise-keegi-ei-helista`, `/vaatamised-aga-pakkumisi-pole`, `/kinnisvara-hinnaanaluus-tallinn`, `/vead-kinnisvara-muugil`, `/kuidas-muua-kiiremini`, `/kuulutuse-audit`, `/muua-ise-vs-strateegiline-partner` | `Route [et.] not defined` — `$pageKey` пустая строка в `intent.blade.php:9`. ET-роуты не имеют `->defaults('locale', 'et')`, поэтому Laravel не инжектирует `$intentKey` в контроллер. RU/EN работают, т.к. у них есть `->defaults('locale', ...)`. |

**PHASE 1 ВЕРДИКТ: ⚠️ CONDITIONAL PASS** — 1 блокер (7 ET intent = 500)

---

## 2. Performance & Rendering Lock (PHASE 2)

> **Примечание:** Lighthouse CLI аудит не выполнен в данной сессии (требуется Chrome + lighthouse npm). Ниже — анализ на уровне кода.

### 2.1 Архитектурные показатели

| Показатель | Статус |
|---|---|
| Серверный рендеринг (SSR через Blade) | ✅ |
| Отсутствие SPA / client-side роутинга | ✅ Оптимально для LCP |
| CSS — критичный inline в `<head>` | ✅ |
| JS — deferred, в конце `<body>` | ✅ |
| WebP изображения с `<picture>` fallback | ✅ |
| Render-blocking сторонние скрипты | ✅ Не обнаружены |
| Формы — lazy-loaded (`form-scripts`) | ✅ |

### 2.2 Страницы для Lighthouse (ожидает замер на production)

| # | URL | Описание |
|---|---|---|
| 1 | `/ru/` | Home |
| 2 | `/ru/kinnisvara-muuk` | Sell |
| 3 | `/ru/kinnisvara-uur` | Rent |
| 4 | `/ru/makler-v-tallinne` | P3 Makler |
| 5 | `/ru/ocenka-kvartiry-v-tallinne` | P3 Ocenka |
| 6 | `/ru/audit` | Audit |
| 7 | `/ru/konsultatsioon` | Consultation |
| 8 | `/ru/ne-prodaetsya-kvartira-v-tallinne` | P3 Ne-prodaetsya |
| 9 | `/ru/tallinn` | GEO Hub |
| 10 | `/ru/cases` | Cases Hub |
| 11 | `/ru/guides` | Guides Index |

**PHASE 2 ВЕРДИКТ: ⏳ NOT FULLY AUDITED** — Архитектура кода корректна; Lighthouse-метрики надо замерять на production.

---

## 3. AI Entity & EEAT Layer (PHASE 3)

### 3.1 Schema по типам страниц

| Тип страницы | Присутствующие JSON-LD @type |
|---|---|
| **Home** (ET/RU/EN) | WebSite, Organization+RealEstateAgent+LocalBusiness, Person, WebPage, BreadcrumbList |
| **Sell / Rent / Consultation / Audit** | WebSite, **Service**, Organization+RealEstateAgent+LocalBusiness, BreadcrumbList, WebPage, **FAQPage** |
| **Profile** | WebSite, **ProfilePage**, Person, Organization+RealEstateAgent+LocalBusiness, BreadcrumbList, WebPage |
| **Phase 3 Лендинги** (prodat, makler, ocenka...) | WebSite, WebPage, BreadcrumbList, Organization+RealEstateAgent+LocalBusiness, **FAQPage**, **Service** |
| **Phase 3 GEO Hub** (`/ru/tallinn`) | WebSite, WebPage, BreadcrumbList, Organization+RealEstateAgent+LocalBusiness, **CollectionPage** |
| **Phase 3 Районы** (lasnamae, mustamae...) | WebSite, WebPage, BreadcrumbList, Organization+RealEstateAgent+LocalBusiness, **FAQPage** |
| **Phase 3 Cases Hub** (`/ru/cases`) | WebSite, WebPage, BreadcrumbList, Organization+RealEstateAgent+LocalBusiness, **CollectionPage** |
| **Intent Pages** (RU/EN) | WebSite, BreadcrumbList, WebPage, **FAQPage** |
| **Guide Detail** | WebSite, **Article**, Organization+RealEstateAgent+LocalBusiness, Person, BreadcrumbList, WebPage, **FAQPage** |
| **Knowledge Hub** | WebSite, **CollectionPage**, BreadcrumbList, WebPage |
| **Guides Index** | WebSite, WebPage, BreadcrumbList |
| **Why CityEE** | WebSite, WebPage, BreadcrumbList, Person |
| **Dashboard** | WebSite, WebPage, BreadcrumbList |

### 3.2 Чеклист Schema

| Schema Type | Присутствует | Где |
|---|---|---|
| **Organization** (+ RealEstateAgent + LocalBusiness) | ✅ | Home, Sell, Rent, Consultation, Audit, Profile, Phase 3, GEO Hub, Cases Hub, Guide Detail |
| **Person** (Aleksandr Primakov) | ✅ | Home, Profile, Guide Detail, Audit, Why |
| **LocalBusiness** | ✅ | Объединён с Organization (массив @type) |
| **Service** | ✅ | Sell, Rent, Consultation, Audit, Phase 3 лендинги |
| **BreadcrumbList** | ✅ | Все страницы |
| **FAQPage** | ✅ | Сервисы, Phase 3 лендинги, районы, Intent, Guides |
| **CollectionPage** | ✅ | GEO Hub, Cases Hub, Knowledge Hub |
| **WebSite + SearchAction** | ✅ | Все страницы (target: `/guides?q=`) |
| **sameAs** | ✅ | 5 ссылок в Organization: FB, Instagram, LinkedIn, KV.ee, Google Maps |
| **SpeakableSpecification** | ✅ | Intent, Phase 3, Guides (через `Schema::speakable()`) |
| **ProfilePage** | ✅ | Страница профиля |
| **Article** | ✅ | Guide detail pages |

### 3.3 Замечания по Schema

- **Дублирование WebPage**: несколько страниц выводят 2 блока `WebPage` (из `speakable()` + из layout). Некритично, но может смущать валидаторы.
- **Profile page**: дублирование Person + Organization (двойной блок). Рекомендуется дедупликация.

**PHASE 3 ВЕРДИКТ: ✅ PASS** — Все требуемые schema-типы присутствуют. Минорные возможности дедупликации.

---

## 4. Internal Link Architecture

### 4.1 Структура Silo

| Silo | Hub-страница | Spoke-страницы | Механизм перелинковки |
|---|---|---|---|
| **SELL** | `/kinnisvara-muuk` | 7 intent pages, consultation, audit | `service-crosslinks` + `intent-crosslinks` |
| **RENT** | `/kinnisvara-uur` | consultation, guides | `service-crosslinks` |
| **AUDIT** | `/audit` | guides, audits index | `service-crosslinks` + `sidebar-services` |
| **VALUATION** | `/ru/ocenka-kvartiry-v-tallinne` | другие P3 лендинги | `phase3-crosslinks` (config `internal_links`) |
| **GUIDES** | `/guides` | 15 guide detail pages | Внутренние ссылки + `service-crosslinks` |
| **CASES** | `/cases` (P3) + `/knowledge/cases` (P5) | 6 case detail pages | `phase3-crosslinks` |
| **TALLINN GEO** | `/ru/tallinn` | 5 district pages | Grid-ссылки на районы в хабе |

### 4.2 Компоненты перелинковки

| Компонент | Описание | Используется на |
|---|---|---|
| `sidebar-services` | Левый sidebar — ссылки на все nav-элементы (sell, rent, consultation, contacts, audit, knowledge) | Все сервисные/контентные страницы |
| `service-crosslinks` | Footer-grid: 4 сервиса + guides + audits + profile + comparison | 14+ шаблонов |
| `intent-crosslinks` | Линкует все 7 intent-страниц + sell hub. Плотный внутренний silo | Intent pages |
| `phase3-crosslinks` | Конфигурируемый массив `internal_links` для каждого лендинга | Phase 3 лендинги |

**Статус: ✅ PASS** — Плотная перелинковка реализована по всем silo.

---

## 5. Content Readiness

### 5.1 Пилотные гайды (5 slug-ов)

| Концепция | Slug в БД | RU | ET | EN |
|---|---|---|---|---|
| Как продать квартиру без потерь | `sell-apartment-without-losing-money` | ✅ 200 | ✅ 200 | ✅ 200 |
| План продажи за 30–45 дней | `30-45-day-sales-plan` | ✅ 200 | ✅ 200 | ✅ 200 |
| Реальный ценовой коридор | `real-price-corridor` | ✅ 200 | ✅ 200 | ✅ 200 |
| Чек-лист объявления на KV.ee | `kv-ee-listing-checklist` | ✅ 200 | ✅ 200 | ✅ 200 |
| Безопасная аренда: проверка арендатора | `safe-rental-tenant-check` | ✅ 200 | ✅ 200 | ✅ 200 |

Всего 15 записей в БД (5 slug × 3 locale). Все рендерятся со статусом 200 и содержательным контентом.

**Статус: ✅ PASS**

---

## 6. Multilingual Integrity

### 6.1 Проверка RU / ET / EN маппинга

| Группа страниц | et-EE | ru-EE | en-EE | x-default | Симметрия |
|---|---|---|---|---|---|
| Home | `https://cityee.ee/` | `https://cityee.ee/ru/` | `https://cityee.ee/en/` | ET | ✅ |
| Sell | `/kinnisvara-muuk/` | `/ru/kinnisvara-muuk/` | `/en/sell-property/` | ET | ✅ |
| Intent (No Calls) | `/muud-ise-keegi-ei-helista/` | `/ru/prodayu-sam-nikto-ne-zvonit/` | `/en/selling-yourself-no-calls/` | ET | ✅ |
| Profile | `/aleksandr-primakov/` | `/ru/aleksandr-primakov/` | `/en/aleksandr-primakov/` | ET | ✅ |
| Audit | `/audit/` | `/ru/audit/` | `/en/audit/` | ET | ✅ |
| Guides | `/guides/` | `/ru/guides/` | `/en/guides/` | ET | ✅ |
| Phase 3 Makler | — | `/ru/makler-v-tallinne/` | — | RU | N/A (mono) |
| Phase 3 Ocenka | — | `/ru/ocenka-kvartiry-v-tallinne/` | — | RU | N/A (mono) |

### 6.2 Результаты

- **Петли hreflang**: не обнаружены. Каждая языковая версия выводит идентичный набор hreflang.
- **Симметричные пары**: подтверждены (ET→RU→EN→ET — одинаковые наборы).
- **x-default**: корректно указывает на ET для трёхъязычных, на RU для Phase 3 RU-only.
- **Phase 3**: корректно выводит только `ru-EE` + `x-default` (без ET/EN фантомных тегов).

**Статус: ✅ PASS**

---

## 7. Error Scan

| Проверка | Результат |
|---|---|
| **500 ошибки** | ❌ **7 страниц** — все ET intent pages |
| **404 ошибки** | ✅ 0 (все гайды резолвятся с корректными slug-ами) |
| **Цепочки редиректов** | ✅ Не обнаружены |
| **Конфликты canonical** | ✅ Нет — каждая страница выводит один canonical |
| **Отсутствующая schema** | ✅ Нет критичных пропусков. Dashboard — минимальная schema (WebSite + WebPage + BreadcrumbList), допустимо |
| **Мёртвый код** | ⚠️ `SitemapController::locations()` — метод-сирота (роут удалён). Без влияния |

### Детали 500-ошибок

**Затронутые страницы (7):**
1. `/muud-ise-keegi-ei-helista` — ET No Calls
2. `/vaatamised-aga-pakkumisi-pole` — ET No Offers
3. `/kinnisvara-hinnaanaluus-tallinn` — ET Price Analysis
4. `/vead-kinnisvara-muugil` — ET Mistakes
5. `/kuidas-muua-kiiremini` — ET Sell Faster
6. `/kuulutuse-audit` — ET Listing Audit
7. `/muua-ise-vs-strateegiline-partner` — ET Comparison

**Причина:** `intent.blade.php:9` вызывает `route('et.' . $pageKey)`, но `$pageKey` — пустая строка. ET intent-роуты в `routes/web.php` используют `->defaults('intentKey', 'no_calls')` **без** `->defaults('locale', 'et')`, в отличие от RU/EN роутов, которые задают оба defaults.

**Фикс:** Добавить `->defaults('locale', 'et')` ко всем 7 ET intent роутам.

---

## Итоговая таблица

| Phase | Статус | Блокеры |
|---|---|---|
| **Phase 1 — Architecture & Index Lock** | ⚠️ CONDITIONAL PASS | 7 ET intent = 500 |
| **Phase 2 — Performance & Rendering Lock** | ⏳ NOT FULLY AUDITED | Lighthouse не замерен |
| **Phase 3 — AI Entity & EEAT Layer** | ✅ PASS | Минорная дедупликация schema |

---

## Рекомендация

> **Исправить баг ET intent 500** (добавить `->defaults('locale', 'et')` к 7 ET intent роутам — фикс на 5 минут), после чего **Phase 4 может стартовать безопасно**.
>
> Все остальные системы — canonicals, hreflang, robots.txt, sitemaps, structured data, silo-перелинковка, мультиязычная целостность, контент гайдов — **полностью работоспособны**.
