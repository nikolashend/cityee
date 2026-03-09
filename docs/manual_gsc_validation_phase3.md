# Phase 3 — Google Search Console Validation Manual

## Цель
Проверить индексацию и корректность всех Phase 3 страниц после деплоя.

## Шаг 1: Проверка sitemap
1. Открыть GSC → Sitemaps
2. Отправить (или обновить) `https://cityee.ee/sitemap.xml`
3. Убедиться, что `sitemap-phase3.xml` указан в индексе
4. Проверить статус: «Успех» для всех sub-sitemaps

## Шаг 2: Проверка индексации URL
Каждый URL проверить через «Проверка URL» (URL Inspection):

### Intent Landing Pages
- https://cityee.ee/ru/prodat-kvartiru-v-tallinne/
- https://cityee.ee/ru/sdat-kvartiru-v-tallinne/
- https://cityee.ee/ru/makler-v-tallinne/
- https://cityee.ee/ru/agentstvo-nedvizhimosti-tallinn/
- https://cityee.ee/ru/ocenka-kvartiry-v-tallinne/
- https://cityee.ee/ru/ne-prodaetsya-kvartira-v-tallinne/
- https://cityee.ee/ru/audit-nedvizhimosti-tallinn/
- https://cityee.ee/ru/o-kompanii/

### GEO Hub + Districts
- https://cityee.ee/ru/tallinn/
- https://cityee.ee/ru/tallinn/lasnamae/
- https://cityee.ee/ru/tallinn/mustamae/
- https://cityee.ee/ru/tallinn/kesklinn/
- https://cityee.ee/ru/tallinn/haabersti/
- https://cityee.ee/ru/tallinn/kristiine/

### Cases
- https://cityee.ee/ru/cases/
- https://cityee.ee/ru/cases/prodali-3-komnatnuyu-kvartiru-v-kesklinn-za-16-dney/
- https://cityee.ee/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kadriorg-za-24-dnya/
- https://cityee.ee/ru/cases/prodali-1-komnatnuyu-kvartiru-v-lasnamae/
- https://cityee.ee/ru/cases/prodali-3-komnatnuyu-kvartiru-v-lasnamae/
- https://cityee.ee/ru/cases/prodali-2-komnatnuyu-kvartiru-v-kristiine-za-18-dney/
- https://cityee.ee/ru/cases/prodali-4-komnatnuyu-kvartiru-v-tiskre/

## Шаг 3: Запросить индексацию
Для каждого URL:
1. Ввести URL в «Проверка URL»
2. Нажать «Запросить индексацию»
3. Дождаться подтверждения

## Шаг 4: Проверка через 48–72 часа
- Проверить, что страницы появились в Coverage (Покрытие)
- Убедиться, что нет ошибок:
  - soft 404
  - redirect loops
  - blocked by robots.txt
  - noindex

## Шаг 5: Проверка FAQ Schema
Для страниц с FAQ:
1. Rich Results Test: https://search.google.com/test/rich-results
2. Вставить URL каждой Phase 3 страницы
3. Убедиться, что FAQ detected (обнаружен)

## Шаг 6: Проверка через site:
Через 1–2 недели проверить в Google:
```
site:cityee.ee/ru/prodat-kvartiru
site:cityee.ee/ru/tallinn
site:cityee.ee/ru/cases
site:cityee.ee/ru/makler
```

## Шаг 7: Мониторинг
- Еженедельно: проверять Coverage на новые ошибки
- Ежемесячно: проверять позиции по целевым запросам
- Целевые запросы для мониторинга:
  - маклер в таллине
  - продать квартиру в таллине
  - агентство недвижимости таллинн
  - оценка квартиры в таллине
  - квартира не продаётся таллинн
  - аудит недвижимости таллинн
  - сдать квартиру в таллине
