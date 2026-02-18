{{-- SEO/UX Dashboard Scorecard view --}}
@extends('layouts.app')

@section('title', $locale === 'ru' ? 'SEO Dashboard — Scorecard & Метрики | CityEE' : ($locale === 'en' ? 'SEO Dashboard — Scorecard & Metrics | CityEE' : 'SEO Dashboard — Scorecard & Mõõdikud | CityEE'))
@section('description', $locale === 'ru' ? 'SEO Scorecard: технические метрики, Core Web Vitals, EEAT-сигналы, AI-видимость. UX Metric Sheet по эвристикам Нильсена.' : ($locale === 'en' ? 'SEO Scorecard: technical metrics, Core Web Vitals, EEAT signals, AI visibility. UX Metric Sheet by Nielsen heuristics.' : 'SEO Scorecard: tehnilised mõõdikud, Core Web Vitals, EEAT-signaalid, AI-nähtavus.'))
@section('logo_text', $ui['logo_text'] ?? '')
@section('footer_class', 'footer--page')

@section('lang_et_url', route('et.dashboard'))
@section('lang_ru_url', route('ru.dashboard'))
@section('lang_en_url', route('en.dashboard'))

@push('jsonld')
{!! \App\Support\JsonLd::webPage(
    $locale === 'ru' ? 'SEO Dashboard CityEE' : ($locale === 'en' ? 'CityEE SEO Dashboard' : 'CityEE SEO Dashboard'),
    url()->current(),
    $locale === 'ru' ? 'SEO scorecard, UX метрики, EEAT оценка.' : ($locale === 'en' ? 'SEO scorecard, UX metrics, EEAT assessment.' : 'SEO scorecard, UX mõõdikud, EEAT hinnang.')
) !!}
{!! \App\Support\JsonLd::breadcrumbs([
    ['name' => $nav[0]['label'] ?? 'Home', 'url' => route("{$locale}.home")],
    ['name' => $locale === 'ru' ? 'База знаний' : ($locale === 'en' ? 'Knowledge Hub' : 'Teadmistebaas'), 'url' => route("{$locale}.knowledge")],
    ['name' => 'SEO Dashboard'],
]) !!}
@endpush

@php
$t = [
    'heading' => ['ru' => 'SEO Dashboard & Scorecard', 'en' => 'SEO Dashboard & Scorecard', 'et' => 'SEO Dashboard & Scorecard'],
    'subtitle' => [
        'ru' => 'Комплексная оценка: техническое SEO, Core Web Vitals, EEAT, AI-видимость, UX',
        'en' => 'Comprehensive assessment: technical SEO, Core Web Vitals, EEAT, AI visibility, UX',
        'et' => 'Terviklik hinnang: tehniline SEO, Core Web Vitals, EEAT, AI-nähtavus, UX',
    ],
    'seo_title' => ['ru' => 'SEO Scorecard', 'en' => 'SEO Scorecard', 'et' => 'SEO Scorecard'],
    'ux_title' => ['ru' => 'UX Metric Sheet', 'en' => 'UX Metric Sheet', 'et' => 'UX Metric Sheet'],
    'eeat_title' => ['ru' => 'EEAT Assessment', 'en' => 'EEAT Assessment', 'et' => 'EEAT Hinnang'],
    'category' => ['ru' => 'Категория', 'en' => 'Category', 'et' => 'Kategooria'],
    'metric' => ['ru' => 'Метрика', 'en' => 'Metric', 'et' => 'Mõõdik'],
    'target' => ['ru' => 'Таргет', 'en' => 'Target', 'et' => 'Sihtmärk'],
    'status' => ['ru' => 'Статус', 'en' => 'Status', 'et' => 'Staatus'],
    'heuristic' => ['ru' => 'Эвристика', 'en' => 'Heuristic', 'et' => 'Heuristika'],
    'finding' => ['ru' => 'Находка', 'en' => 'Finding', 'et' => 'Leid'],
    'priority' => ['ru' => 'Приоритет', 'en' => 'Priority', 'et' => 'Prioriteet'],
    'signal' => ['ru' => 'Сигнал', 'en' => 'Signal', 'et' => 'Signaal'],
    'score' => ['ru' => 'Оценка', 'en' => 'Score', 'et' => 'Hinne'],
];

// SEO Scorecard data
$seoMetrics = [
    ['cat' => 'Technical', 'metric' => 'Lighthouse SEO Score', 'target' => '> 95', 'status' => '✅'],
    ['cat' => 'Technical', 'metric' => 'Indexation Rate', 'target' => '> 98%', 'status' => '✅'],
    ['cat' => 'Technical', 'metric' => 'Crawl Errors', 'target' => '0', 'status' => '✅'],
    ['cat' => 'Technical', 'metric' => 'Redirect Chains', 'target' => '0', 'status' => '✅'],
    ['cat' => 'Performance', 'metric' => 'LCP (p75)', 'target' => '< 2.5s', 'status' => '✅'],
    ['cat' => 'Performance', 'metric' => 'INP (p75)', 'target' => '< 200ms', 'status' => '✅'],
    ['cat' => 'Performance', 'metric' => 'CLS (p75)', 'target' => '< 0.1', 'status' => '✅'],
    ['cat' => 'Performance', 'metric' => 'TTFB', 'target' => '< 800ms', 'status' => '✅'],
    ['cat' => 'On-Page', 'metric' => 'Pages with Schema', 'target' => '100%', 'status' => '✅'],
    ['cat' => 'On-Page', 'metric' => 'Unique Meta Titles', 'target' => '100%', 'status' => '✅'],
    ['cat' => 'On-Page', 'metric' => 'Orphan Pages', 'target' => '0', 'status' => '✅'],
    ['cat' => 'Content', 'metric' => 'Content Freshness (30d)', 'target' => '> 80%', 'status' => '🔄'],
    ['cat' => 'Content', 'metric' => 'FAQ Coverage', 'target' => '> 60% pages', 'status' => '✅'],
    ['cat' => 'EEAT', 'metric' => 'Author Bio Present', 'target' => '100%', 'status' => '✅'],
    ['cat' => 'EEAT', 'metric' => 'Sources Cited', 'target' => '> 3/page', 'status' => '🔄'],
    ['cat' => 'AI', 'metric' => 'Rich Results Active', 'target' => '100%', 'status' => '✅'],
    ['cat' => 'AI', 'metric' => 'Quick Answer Blocks', 'target' => 'All guides', 'status' => '✅'],
    ['cat' => 'Local', 'metric' => 'GBP Completeness', 'target' => '100%', 'status' => '✅'],
];

// Nielsen-Norman UX Heuristics
$uxHeuristics = [
    ['id' => 1, 'name' => ['ru' => 'Видимость статуса системы', 'en' => 'Visibility of system status', 'et' => 'Süsteemi oleku nähtavus'], 'finding' => ['ru' => 'Breadcrumbs, lazy load индикаторы, language switcher', 'en' => 'Breadcrumbs, lazy load indicators, language switcher', 'et' => 'Breadcrumbs, lazyload indikaatorid, keelevalija'], 'priority' => 'P3'],
    ['id' => 2, 'name' => ['ru' => 'Соответствие реальному миру', 'en' => 'Match with real world', 'et' => 'Vastavus reaalsusele'], 'finding' => ['ru' => 'Мультиязычность: et/ru/en — знакомый язык для 100% аудитории', 'en' => 'Multilingual: et/ru/en — familiar language for 100% audience', 'et' => 'Mitmekeelne: et/ru/en — tuttav keel 100% publikule'], 'priority' => '✅'],
    ['id' => 3, 'name' => ['ru' => 'Свобода и контроль', 'en' => 'User control & freedom', 'et' => 'Kasutaja kontroll'], 'finding' => ['ru' => 'Навигация, language switch, breadcrumbs, back to hub', 'en' => 'Navigation, language switch, breadcrumbs, back to hub', 'et' => 'Navigatsioon, keelevahetaja, breadcrumbs'], 'priority' => '✅'],
    ['id' => 4, 'name' => ['ru' => 'Последовательность', 'en' => 'Consistency & standards', 'et' => 'Järjepidevus'], 'finding' => ['ru' => 'Единый шаблон для всех страниц, единые CTA', 'en' => 'Uniform template for all pages, consistent CTAs', 'et' => 'Ühtne mall kõikidel lehtedel'], 'priority' => '✅'],
    ['id' => 5, 'name' => ['ru' => 'Предотвращение ошибок', 'en' => 'Error prevention', 'et' => 'Vigade ennetamine'], 'finding' => ['ru' => 'Валидация форм, NoIndex для query pages', 'en' => 'Form validation, NoIndex for query pages', 'et' => 'Vormide valideerimine, NoIndex query lehtedele'], 'priority' => '✅'],
    ['id' => 6, 'name' => ['ru' => 'Узнавание, не запоминание', 'en' => 'Recognition over recall', 'et' => 'Äratundmine'], 'finding' => ['ru' => 'Визуальная навигация, иконки, sidebar', 'en' => 'Visual navigation, icons, sidebar', 'et' => 'Visuaalne navigatsioon, ikoonid, sidebar'], 'priority' => '✅'],
    ['id' => 7, 'name' => ['ru' => 'Гибкость', 'en' => 'Flexibility & efficiency', 'et' => 'Paindlikkus'], 'finding' => ['ru' => 'WhatsApp/Telegram/Phone — выбор канала', 'en' => 'WhatsApp/Telegram/Phone — channel choice', 'et' => 'WhatsApp/Telegram/Telefon — kanali valik'], 'priority' => '✅'],
    ['id' => 8, 'name' => ['ru' => 'Минимализм', 'en' => 'Aesthetic & minimal design', 'et' => 'Minimaalne disain'], 'finding' => ['ru' => 'Чистый layout, critical CSS, no clutter', 'en' => 'Clean layout, critical CSS, no clutter', 'et' => 'Puhas paigutus, kriitiline CSS'], 'priority' => '✅'],
    ['id' => 9, 'name' => ['ru' => 'Помощь при ошибках', 'en' => 'Help with errors', 'et' => 'Vigade abi'], 'finding' => ['ru' => '404 страница с навигацией', 'en' => '404 page with navigation', 'et' => '404 leht navigatsiooniga'], 'priority' => 'P2'],
    ['id' => 10, 'name' => ['ru' => 'Документация', 'en' => 'Help & documentation', 'et' => 'Dokumentatsioon'], 'finding' => ['ru' => 'База знаний, гайды, FAQ на каждой странице', 'en' => 'Knowledge hub, guides, FAQ on every page', 'et' => 'Teadmistebaas, juhendid, FAQ igal lehel'], 'priority' => '✅'],
];

// EEAT Assessment
$eeatSignals = [
    ['signal' => 'Experience', 'desc' => ['ru' => '18+ лет, 300+ сделок, кейсы с результатами', 'en' => '18+ years, 300+ deals, case studies with results', 'et' => '18+ aastat, 300+ tehingut, tulemustega juhtumiuuringud'], 'score' => '⭐⭐⭐⭐⭐'],
    ['signal' => 'Expertise', 'desc' => ['ru' => 'Авторские данные, рыночная аналитика, credentials', 'en' => 'Author credentials, market analytics, professional bio', 'et' => 'Autori andmed, turuanalüütika, professionaalne bio'], 'score' => '⭐⭐⭐⭐⭐'],
    ['signal' => 'Authoritativeness', 'desc' => ['ru' => 'Портальные профили, цитирование, JSON-LD Organization', 'en' => 'Portal profiles, citations, JSON-LD Organization', 'et' => 'Portaaliprofiilid, tsitaadid, JSON-LD Organization'], 'score' => '⭐⭐⭐⭐'],
    ['signal' => 'Trustworthiness', 'desc' => ['ru' => 'SSL, отзывы, полный контакт, прозрачность', 'en' => 'SSL, reviews, full contact, transparency', 'et' => 'SSL, arvustused, täielik kontakt, läbipaistvus'], 'score' => '⭐⭐⭐⭐⭐'],
];
@endphp

@section('content')

<div class="page-title" style="background: url(/assets/templates/offshors/img/offshors.jpg) no-repeat; background-position: center top; background-size: cover;">
  <div class="container">
    <h1 class="page-title__name">{{ $t['heading'][$locale] ?? $t['heading']['en'] }}</h1>
    <p class="page-title__text">{{ $t['subtitle'][$locale] ?? $t['subtitle']['en'] }}</p>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-3 col-sm-3 text-center">
      @include('partials.sidebar-services', ['locale' => $locale, 'pageKey' => $pageKey])
    </div>
    <div class="col-md-9 col-sm-9">
      <div class="content">

        {{-- ═══ SEO SCORECARD ═══ --}}
        <section class="dashboard-section" aria-labelledby="seo-scorecard">
          <h2 id="seo-scorecard" class="content__title">{{ $t['seo_title'][$locale] ?? 'SEO Scorecard' }}</h2>
          <div class="table-responsive">
            <table class="dashboard-table" role="table">
              <thead>
                <tr>
                  <th>{{ $t['category'][$locale] }}</th>
                  <th>{{ $t['metric'][$locale] }}</th>
                  <th>{{ $t['target'][$locale] }}</th>
                  <th>{{ $t['status'][$locale] }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($seoMetrics as $row)
                <tr>
                  <td><strong>{{ $row['cat'] }}</strong></td>
                  <td>{{ $row['metric'] }}</td>
                  <td><code>{{ $row['target'] }}</code></td>
                  <td>{{ $row['status'] }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </section>

        {{-- ═══ UX METRIC SHEET ═══ --}}
        <section class="dashboard-section" aria-labelledby="ux-metrics" style="margin-top: 3rem;">
          <h2 id="ux-metrics" class="content__title">{{ $t['ux_title'][$locale] ?? 'UX Metric Sheet' }}</h2>
          <p>{{ $locale === 'ru' ? '10 эвристик юзабилити по Nielsen-Norman Group.' : ($locale === 'en' ? '10 usability heuristics by Nielsen-Norman Group.' : '10 kasutusheuristikat Nielsen-Norman Groupi järgi.') }}</p>
          <div class="table-responsive">
            <table class="dashboard-table" role="table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>{{ $t['heuristic'][$locale] }}</th>
                  <th>{{ $t['finding'][$locale] }}</th>
                  <th>{{ $t['priority'][$locale] }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($uxHeuristics as $h)
                <tr>
                  <td>{{ $h['id'] }}</td>
                  <td><strong>{{ $h['name'][$locale] ?? $h['name']['en'] }}</strong></td>
                  <td>{{ $h['finding'][$locale] ?? $h['finding']['en'] }}</td>
                  <td>{{ $h['priority'] }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </section>

        {{-- ═══ EEAT ASSESSMENT ═══ --}}
        <section class="dashboard-section" aria-labelledby="eeat-assessment" style="margin-top: 3rem;">
          <h2 id="eeat-assessment" class="content__title">{{ $t['eeat_title'][$locale] ?? 'EEAT Assessment' }}</h2>
          <div class="table-responsive">
            <table class="dashboard-table" role="table">
              <thead>
                <tr>
                  <th>{{ $t['signal'][$locale] }}</th>
                  <th>{{ $t['finding'][$locale] }}</th>
                  <th>{{ $t['score'][$locale] }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($eeatSignals as $sig)
                <tr>
                  <td><strong>{{ $sig['signal'] }}</strong></td>
                  <td>{{ $sig['desc'][$locale] ?? $sig['desc']['en'] }}</td>
                  <td>{{ $sig['score'] }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </section>

        {{-- ═══ AUDIT CHECKLISTS SUMMARY ═══ --}}
        <section class="dashboard-section" aria-labelledby="audit-templates" style="margin-top: 3rem;">
          <h2 id="audit-templates" class="content__title">
            {{ $locale === 'ru' ? 'Шаблоны аудитов' : ($locale === 'en' ? 'Audit Templates' : 'Auditi mallid') }}
          </h2>
          <p>{{ $locale === 'ru' ? 'CityEE использует 4 профессиональных шаблона аудита:' : ($locale === 'en' ? 'CityEE uses 4 professional audit templates:' : 'CityEE kasutab 4 professionaalset auditi malli:') }}</p>

          @php $templates = config('cityee.audit_templates', []); @endphp
          <div class="knowledge-grid">
            @foreach (['seo' => '🔍', 'geo' => '🤖', 'ux' => '⚡', 'eeat' => '🛡️'] as $key => $icon)
              @if(isset($templates[$key]))
              <div class="knowledge-card">
                <span class="knowledge-card__icon">{{ $icon }}</span>
                <h3 class="knowledge-card__title">{{ $templates[$key]['name'] }}</h3>
                <p class="knowledge-card__desc">{{ $templates[$key]['description'] }}</p>
                <p class="knowledge-card__desc"><strong>{{ count($templates[$key]['categories'] ?? []) }}</strong> {{ $locale === 'ru' ? 'категорий' : ($locale === 'en' ? 'categories' : 'kategooriat') }}</p>
              </div>
              @endif
            @endforeach
          </div>
        </section>

        @include('partials.trust-layer', ['locale' => $locale])

        {{-- CTA --}}
        <section class="guide-cta" style="margin-top: 3rem;" aria-label="CTA">
          <h3>{{ $locale === 'ru' ? 'Хотите полный SEO-аудит?' : ($locale === 'en' ? 'Want a full SEO audit?' : 'Soovid täielikku SEO-auditi?') }}</h3>
          <p>{{ $locale === 'ru' ? 'Получите комплексный аудит: технический SEO + Core Web Vitals + EEAT + GEO за 24 часа.' : ($locale === 'en' ? 'Get a comprehensive audit: technical SEO + Core Web Vitals + EEAT + GEO within 24 hours.' : 'Saa terviklik audit: tehniline SEO + Core Web Vitals + EEAT + GEO 24 tunni jooksul.') }}</p>
          <a href="https://wa.me/3725113411" class="btn-v3" rel="nofollow noopener" target="_blank">
            {{ $locale === 'ru' ? 'Заказать аудит через WhatsApp' : ($locale === 'en' ? 'Order audit via WhatsApp' : 'Telli audit WhatsAppi kaudu') }}
          </a>
        </section>

      </div>
    </div>
  </div>
</div>

@include('partials.about', ['ui' => $ui, 'isPage' => true])

@endsection

<style>
.dashboard-table { width: 100%; border-collapse: collapse; font-size: .95rem; }
.dashboard-table th, .dashboard-table td { padding: .6rem .8rem; text-align: left; border-bottom: 1px solid #e5e5e5; }
.dashboard-table th { background: #f8f9fa; font-weight: 600; position: sticky; top: 0; }
.dashboard-table tbody tr:hover { background: #f0f7ff; }
.dashboard-table code { background: #eef; padding: 2px 6px; border-radius: 3px; font-size: .85rem; }
.table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.dashboard-section + .dashboard-section { border-top: 2px solid #e5e5e5; padding-top: 2rem; }
</style>
