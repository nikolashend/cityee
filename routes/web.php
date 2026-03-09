<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\AuditContentController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\Phase3Controller;
use Illuminate\Support\Facades\Route;

// ─── Form submission routes (shared) ────────────────────────
Route::post('/contact/callback', [ContactController::class, 'callback'])->name('contact.callback');
Route::post('/contact/inquiry', [ContactController::class, 'inquiry'])->name('contact.inquiry');
Route::post('/contact/audit-request', [ContactController::class, 'auditRequest'])->name('contact.audit-request');
Route::post('/contact/price-calculator', [ContactController::class, 'priceCalculator'])->name('contact.price-calculator');

// ─── Sitemap & robots ───────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap-main.xml', [SitemapController::class, 'main'])->name('sitemap.main');
Route::get('/sitemap-guides.xml', [SitemapController::class, 'guides'])->name('sitemap.guides');
Route::get('/sitemap-audits.xml', [SitemapController::class, 'audits'])->name('sitemap.audits');
Route::get('/sitemap-locations.xml', [SitemapController::class, 'locations'])->name('sitemap.locations');
Route::get('/sitemap-phase3.xml', [SitemapController::class, 'phase3'])->name('sitemap.phase3');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// ─── Estonian routes (cityee.ee) — default ──────────────────
Route::get('/',                  [PageController::class, 'home'])->name('et.home');
Route::get('/kinnisvara-muuk',   [PageController::class, 'sell'])->name('et.sell');
Route::get('/kinnisvara-uur',    [PageController::class, 'rent'])->name('et.rent');
Route::get('/konsultatsioon',    [PageController::class, 'consultation'])->name('et.consultation');
Route::get('/kontaktid',         [PageController::class, 'contacts'])->name('et.contacts');
Route::get('/miks-cityee',       [PageController::class, 'whyCityee'])->name('et.why');
Route::get('/audit',             [PageController::class, 'audit'])->name('et.audit');
Route::get('/knowledge',         [PageController::class, 'knowledge'])->name('et.knowledge');
Route::get('/dashboard',         [PageController::class, 'dashboard'])->name('et.dashboard');
Route::get('/guides',            [GuideController::class, 'index'])->name('et.guides');
Route::get('/guides/{slug}',     [GuideController::class, 'show'])->name('et.guides.show');
Route::get('/audits',            [AuditContentController::class, 'index'])->name('et.audits');
Route::get('/audits/{slug}',     [AuditContentController::class, 'show'])->name('et.audits.show');
Route::get('/locations/{slug}',  [LocationController::class, 'show'])->name('et.location');
Route::get('/aleksandr-primakov', [PageController::class, 'profile'])->name('et.profile');

// ─── Estonian pillar guides + cases (Phase 5) ───────────────
Route::get('/knowledge/cases',  [PageController::class, 'casesPage'])->name('et.cases');
Route::get('/knowledge/{slug}', [PageController::class, 'pillarGuide'])->name('et.pillar');

// ─── Estonian intent pages (Phase 4) ────────────────────────
Route::get('/muud-ise-keegi-ei-helista',      [PageController::class, 'intentPage'])->defaults('intentKey', 'no_calls')->name('et.no_calls');
Route::get('/vaatamised-aga-pakkumisi-pole',   [PageController::class, 'intentPage'])->defaults('intentKey', 'no_offers')->name('et.no_offers');
Route::get('/kinnisvara-hinnaanaluus-tallinn', [PageController::class, 'intentPage'])->defaults('intentKey', 'price_analysis')->name('et.price_analysis');
Route::get('/vead-kinnisvara-muugil',          [PageController::class, 'intentPage'])->defaults('intentKey', 'mistakes')->name('et.mistakes');
Route::get('/kuidas-muua-kiiremini',           [PageController::class, 'intentPage'])->defaults('intentKey', 'sell_faster')->name('et.sell_faster');
Route::get('/kuulutuse-audit',                 [PageController::class, 'intentPage'])->defaults('intentKey', 'listing_audit')->name('et.listing_audit');
Route::get('/muua-ise-vs-strateegiline-partner', [PageController::class, 'intentPage'])->defaults('intentKey', 'comparison')->name('et.comparison');

// ─── Russian routes (/ru prefix) ────────────────────────────
Route::prefix('ru')->group(function () {
    Route::get('/',                [PageController::class, 'home'])->defaults('locale', 'ru')->name('ru.home');
    Route::get('/kinnisvara-muuk', [PageController::class, 'sell'])->defaults('locale', 'ru')->name('ru.sell');
    Route::get('/kinnisvara-uur',  [PageController::class, 'rent'])->defaults('locale', 'ru')->name('ru.rent');
    Route::get('/konsultatsioon',  [PageController::class, 'consultation'])->defaults('locale', 'ru')->name('ru.consultation');
    Route::get('/kontaktid',       [PageController::class, 'contacts'])->defaults('locale', 'ru')->name('ru.contacts');
    Route::get('/pochemu-cityee',  [PageController::class, 'whyCityee'])->defaults('locale', 'ru')->name('ru.why');
    Route::get('/audit',           [PageController::class, 'audit'])->defaults('locale', 'ru')->name('ru.audit');
    Route::get('/knowledge',       [PageController::class, 'knowledge'])->defaults('locale', 'ru')->name('ru.knowledge');
    Route::get('/dashboard',       [PageController::class, 'dashboard'])->defaults('locale', 'ru')->name('ru.dashboard');
    Route::get('/guides',          [GuideController::class, 'index'])->defaults('locale', 'ru')->name('ru.guides');
    Route::get('/guides/{slug}',   [GuideController::class, 'show'])->defaults('locale', 'ru')->name('ru.guides.show');
    Route::get('/audits',          [AuditContentController::class, 'index'])->defaults('locale', 'ru')->name('ru.audits');
    Route::get('/audits/{slug}',   [AuditContentController::class, 'show'])->defaults('locale', 'ru')->name('ru.audits.show');
    Route::get('/locations/{slug}', [LocationController::class, 'show'])->defaults('locale', 'ru')->name('ru.location');
    Route::get('/aleksandr-primakov', [PageController::class, 'profile'])->defaults('locale', 'ru')->name('ru.profile');

    // Russian pillar guides + cases (Phase 5)
    Route::get('/knowledge/cases',  [PageController::class, 'casesPage'])->defaults('locale', 'ru')->name('ru.cases');
    Route::get('/knowledge/{slug}', [PageController::class, 'pillarGuide'])->defaults('locale', 'ru')->name('ru.pillar');

    // Russian intent pages (Phase 4)
    Route::get('/prodayu-sam-nikto-ne-zvonit',       [PageController::class, 'intentPage'])->defaults('locale', 'ru')->defaults('intentKey', 'no_calls')->name('ru.no_calls');
    Route::get('/prosmotry-est-predlozheniy-net',    [PageController::class, 'intentPage'])->defaults('locale', 'ru')->defaults('intentKey', 'no_offers')->name('ru.no_offers');
    Route::get('/analiz-ceny-nedvizhimosti-tallinn', [PageController::class, 'intentPage'])->defaults('locale', 'ru')->defaults('intentKey', 'price_analysis')->name('ru.price_analysis');
    Route::get('/oshibki-pri-prodazhe',              [PageController::class, 'intentPage'])->defaults('locale', 'ru')->defaults('intentKey', 'mistakes')->name('ru.mistakes');
    Route::get('/kak-prodat-bystree',                [PageController::class, 'intentPage'])->defaults('locale', 'ru')->defaults('intentKey', 'sell_faster')->name('ru.sell_faster');
    Route::get('/audit-obyavleniya',                 [PageController::class, 'intentPage'])->defaults('locale', 'ru')->defaults('intentKey', 'listing_audit')->name('ru.listing_audit');
    Route::get('/prodat-samomu-vs-partner',          [PageController::class, 'intentPage'])->defaults('locale', 'ru')->defaults('intentKey', 'comparison')->name('ru.comparison');

    // ─── Phase 3 — SEO/AI/GEO landing pages (RU only) ──────
    Route::get('/prodat-kvartiru-v-tallinne',         [Phase3Controller::class, 'landing'])->defaults('landingKey', 'prodat-kvartiru-v-tallinne')->name('ru.phase3.prodat-kvartiru');
    Route::get('/sdat-kvartiru-v-tallinne',           [Phase3Controller::class, 'landing'])->defaults('landingKey', 'sdat-kvartiru-v-tallinne')->name('ru.phase3.sdat-kvartiru');
    Route::get('/makler-v-tallinne',                  [Phase3Controller::class, 'landing'])->defaults('landingKey', 'makler-v-tallinne')->name('ru.phase3.makler');
    Route::get('/agentstvo-nedvizhimosti-tallinn',    [Phase3Controller::class, 'landing'])->defaults('landingKey', 'agentstvo-nedvizhimosti-tallinn')->name('ru.phase3.agentstvo');
    Route::get('/ocenka-kvartiry-v-tallinne',         [Phase3Controller::class, 'landing'])->defaults('landingKey', 'ocenka-kvartiry-v-tallinne')->name('ru.phase3.ocenka');
    Route::get('/ne-prodaetsya-kvartira-v-tallinne',  [Phase3Controller::class, 'landing'])->defaults('landingKey', 'ne-prodaetsya-kvartira-v-tallinne')->name('ru.phase3.ne-prodaetsya');
    Route::get('/audit-nedvizhimosti-tallinn',        [Phase3Controller::class, 'landing'])->defaults('landingKey', 'audit-nedvizhimosti-tallinn')->name('ru.phase3.audit');
    Route::get('/o-kompanii',                         [Phase3Controller::class, 'landing'])->defaults('landingKey', 'o-kompanii')->name('ru.phase3.o-kompanii');

    // Phase 3 — GEO hub + districts
    Route::get('/tallinn',                            [Phase3Controller::class, 'geoHub'])->name('ru.phase3.geo-hub');
    Route::get('/tallinn/{slug}',                     [Phase3Controller::class, 'district'])->name('ru.phase3.district');

    // Phase 3 — Cases hub + individual cases
    Route::get('/cases',                              [Phase3Controller::class, 'casesHub'])->name('ru.phase3.cases-hub');
    Route::get('/cases/{slug}',                       [Phase3Controller::class, 'caseDetail'])->name('ru.phase3.case');
});

// ─── English routes (/en prefix) ────────────────────────────
Route::prefix('en')->group(function () {
    Route::get('/',                  [PageController::class, 'home'])->defaults('locale', 'en')->name('en.home');
    Route::get('/sell-property',     [PageController::class, 'sell'])->defaults('locale', 'en')->name('en.sell');
    Route::get('/rent-out-property', [PageController::class, 'rent'])->defaults('locale', 'en')->name('en.rent');
    Route::get('/consultation',      [PageController::class, 'consultation'])->defaults('locale', 'en')->name('en.consultation');
    Route::get('/contacts',          [PageController::class, 'contacts'])->defaults('locale', 'en')->name('en.contacts');
    Route::get('/why-cityee',        [PageController::class, 'whyCityee'])->defaults('locale', 'en')->name('en.why');
    Route::get('/audit',             [PageController::class, 'audit'])->defaults('locale', 'en')->name('en.audit');
    Route::get('/knowledge',         [PageController::class, 'knowledge'])->defaults('locale', 'en')->name('en.knowledge');
    Route::get('/dashboard',         [PageController::class, 'dashboard'])->defaults('locale', 'en')->name('en.dashboard');
    Route::get('/guides',            [GuideController::class, 'index'])->defaults('locale', 'en')->name('en.guides');
    Route::get('/guides/{slug}',     [GuideController::class, 'show'])->defaults('locale', 'en')->name('en.guides.show');
    Route::get('/audits',            [AuditContentController::class, 'index'])->defaults('locale', 'en')->name('en.audits');
    Route::get('/audits/{slug}',     [AuditContentController::class, 'show'])->defaults('locale', 'en')->name('en.audits.show');
    Route::get('/locations/{slug}',  [LocationController::class, 'show'])->defaults('locale', 'en')->name('en.location');
    Route::get('/aleksandr-primakov', [PageController::class, 'profile'])->defaults('locale', 'en')->name('en.profile');

    // English pillar guides + cases (Phase 5)
    Route::get('/knowledge/cases',  [PageController::class, 'casesPage'])->defaults('locale', 'en')->name('en.cases');
    Route::get('/knowledge/{slug}', [PageController::class, 'pillarGuide'])->defaults('locale', 'en')->name('en.pillar');

    // English intent pages (Phase 4)
    Route::get('/selling-yourself-no-calls',          [PageController::class, 'intentPage'])->defaults('locale', 'en')->defaults('intentKey', 'no_calls')->name('en.no_calls');
    Route::get('/viewings-but-no-offers',             [PageController::class, 'intentPage'])->defaults('locale', 'en')->defaults('intentKey', 'no_offers')->name('en.no_offers');
    Route::get('/property-price-analysis-tallinn',    [PageController::class, 'intentPage'])->defaults('locale', 'en')->defaults('intentKey', 'price_analysis')->name('en.price_analysis');
    Route::get('/mistakes-selling-property',          [PageController::class, 'intentPage'])->defaults('locale', 'en')->defaults('intentKey', 'mistakes')->name('en.mistakes');
    Route::get('/how-to-sell-faster',                 [PageController::class, 'intentPage'])->defaults('locale', 'en')->defaults('intentKey', 'sell_faster')->name('en.sell_faster');
    Route::get('/listing-audit',                      [PageController::class, 'intentPage'])->defaults('locale', 'en')->defaults('intentKey', 'listing_audit')->name('en.listing_audit');
    Route::get('/sell-yourself-vs-strategy-partner',  [PageController::class, 'intentPage'])->defaults('locale', 'en')->defaults('intentKey', 'comparison')->name('en.comparison');
});


