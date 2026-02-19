# ЭТАП 6 — QA Checklist: UI Discipline & Design Lock

> Run through every row. Mark ✅ when verified, ❌ if broken.
> Test at widths: 390px (mobile), 768px (tablet), 1024px, 1440px (desktop).

## Tokens & Architecture

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 1 | tokens.css | File loads before style.css | View source → `<link>` order: tokens → style → v3 → overrides | |
| 2 | tokens.css | All `--ce-*` variables defined | DevTools → `:root` computed → 50+ vars | |
| 3 | overrides | No raw `#7b1f45` outside tokens.css | Ctrl+F `#7b1f45` in overrides → 0 hits (only `rgba(123,31,69,*)`) | |
| 4 | overrides | No raw `#25D366` outside tokens.css | Ctrl+F `#25D366` in overrides → 0 hits | |

## Header (desktop 1440px)

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 5 | Logo | Width 160–210px (clamp) | Inspect `.logo__img img` → computed width | |
| 6 | Slogan | Beneath logo, opacity 0.85 | Visual check: text below, not beside, logo | |
| 7 | Phone | `tel:` link, no underline | Hover phone → no underline, cursor pointer | |
| 8 | WhatsApp | Green text, icon+text visible | `.main-phone__whatsapp` → min-width 140px | |
| 9 | Contacts links | No underline on hover | Hover email/City24/FB/IG/LinkedIn → none | |
| 10 | Header links | Brand colour on hover | Hover any header link → `#7b1f45` or inherit | |

## Navigation

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 11 | Nav links | No blue underline ever | Hover all nav items → text-decoration: none | |
| 12 | Active nav | Bottom border indicator | Active page → `border-bottom-color` visible | |
| 13 | Languages | Segmented control look | `.languages` → inline-flex, gap:2px, bg pill | |
| 14 | Languages | No burgundy border-bottom | Hover Est/Rus/Eng → no border-bottom leakage | |
| 15 | Languages | Active state distinct | Active lang → brighter bg, font-weight 600 | |

## Hero ↔ Advantages

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 16 | Hero | Min-height 650px (desktop) | `.banners__item` → min-height:650px | |
| 17 | Advantages | Overlaps hero gradient | `.advantages` → margin-top:-100px, gradient bg | |
| 18 | Advantages | No clip at 768px | Tablet → advantages visible, no cut-off | |
| 19 | Advantages | Level at 390px | Mobile → margin-top:0, solid white bg | |
| 20 | Icons | CSS circles, not PNG sprites | `.advantages__img` → border-radius:9999px, ::before | |

## Buttons / CTA

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 21 | Any button | No underline on hover | Hover every .btn/.intent-btn/.mini-btn/.ui-btn | |
| 22 | Primary CTA | Burgundy bg, white text | `.ui-btn--primary` → bg `#7b1f45`, color `#fff` | |
| 23 | WhatsApp CTA | Green bg, white text | `.ui-btn--whatsapp` → bg `#25D366`, color `#fff` | |
| 24 | Accent CTA | Graphite gradient + burgundy border | `.ui-btn--accent` → inspect gradient | |
| 25 | Hover lift | translateY(-1px) on hover | Hover CTA → slight rise + shadow increase | |
| 26 | UiButton comp | Renders as `<a>` with href | `<x-ui-button href="#x">` → `<a class="ui-btn">` | |

## FAQ / Accordion

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 27 | Old FAQ | Smooth expand/collapse | Click question → `max-height + opacity` transition | |
| 28 | UiAccordion | Chevron rotates 180° on open | Click → `.ui-accordion__chevron` rotate | |
| 29 | UiAccordion | Schema.org FAQPage markup | View source → `itemtype="FAQPage"` present | |
| 30 | UiAccordion | aria-expanded toggles | Click → `aria-expanded="true"/"false"` | |
| 31 | UiAccordion | Box shadow on open | `.ui-accordion__item.open` → `var(--ce-sh-lg)` | |

## Footer

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 32 | Footer links | Zero underline everywhere | Hover all footer links → none | |
| 33 | Phone | `tel:` clickable, brand hover | Footer phone → `<a href="tel:">`, hover = burgundy | |
| 34 | WhatsApp | Green, inline-flex, icon+text | Footer `.main-phone__whatsapp` visual | |
| 35 | Email | No underline, brand hover | Footer email link → hover colour `#7b1f45` | |
| 36 | Columns | 40/25/25 desktop layout | `.footer__menu` 40%, `__contacts` 25%, `__phones` 25% | |
| 37 | Mobile | Stacked, centered, menu hidden | 390px → flex-column, `__menu` display:none | |
| 38 | Copyright | Full width below columns | `__copy` flex:0 0 100% | |

## Mobile (390px)

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 39 | Header | 2-row layout (logo, phone+WA+buttons) | 390px → flex-column, centered | |
| 40 | Mobile btn | Contacts/Objects visible | `.header__btn-wrapp` → width:auto | |
| 41 | Sticky btns | Above JivoSite | `.sticky-buttons` z:1010, jdiv z:999 | |
| 42 | Sticky btns | Safe offset from Jivo | `bottom: calc(70px + 12px)` at mobile | |
| 43 | Advantages | 2-column grid, 45% each | `.advantages__item` → width:45%, smaller icons | |
| 44 | CTA row | Stacked vertically | `.ui-cta-row` → flex-direction:column at 767px | |

## CLS / Performance

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 45 | Hero | No layout shift on load | Lighthouse → CLS < 0.1 | |
| 46 | Logo | aspect-ratio set | `.logo__img` → aspect-ratio:200/60 | |
| 47 | Gallery | aspect-ratio 4/3 | `.popup-gallery a` → aspect-ratio present | |
| 48 | Fonts | font-display:swap | `@font-face` rules → `font-display:swap` | |
| 49 | Hero img | Preloaded | `<link rel="preload" ... as="image">` present | |
| 50 | FA/bxslider | Lazy-loaded CSS | `media="print" onload="this.media='all'"` present | |

## Service Pages (v3 components)

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 51 | v3-hero | Gradient bg, h1 clamped | `/et/kinnisvara-muuk` → inspect `.v3-hero__h1` | |
| 52 | v3-hero CTA | 2 buttons, gap 12px | `.v3-hero__ctas` → flex, gap:12px | |
| 53 | Trust bullets | Check icon green | `.v3-hero__check` → color `#25D366` | |
| 54 | JTBD cards | White bg, subtle shadow | `.v3-jtbd__item` → shadow present | |
| 55 | Process | Numbered circles, burgundy | `.v3-process__num` → bg `#7b1f45` | |
| 56 | Price table | Sticky header row, burgundy | `.v3-table th` → bg primary | |
| 57 | Cases | Card grid, hover shadow | `.v3-cases__card:hover` → box-shadow | |
| 58 | Trust agent | Photo + bio flex layout | `.v3-trust-agent__inner` → flex | |
| 59 | Forms | Focus ring burgundy | `.v3-form__input:focus` → box-shadow | |

## Cross-cutting

| # | Block | Criterion | Test | Status |
|---|-------|-----------|------|--------|
| 60 | All pages | No blue link anywhere | Scan all pages → no `color: -webkit-link` | |
| 61 | All pages | Consistent font PT Sans Narrow | Body computed font → `PT Sans Narrow` | |
| 62 | Print | Sticky/Jivo hidden | `@media print` → `display:none !important` | |
| 63 | View cache | `php artisan view:cache` passes | Terminal → `Blade templates cached successfully` | |
| 64 | Routes | 46+ GET routes | `php artisan route:list` → 46 GET | |

---

**Total checks: 64**
**Tested by:** ___________
**Date:** ___________
**Browser:** Chrome ___ / Firefox ___ / Safari ___
