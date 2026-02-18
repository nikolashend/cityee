<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\AuditContentController;
use Illuminate\Support\Facades\Route;

// ─── Form submission routes (shared) ────────────────────────
Route::post('/contact/callback', [ContactController::class, 'callback'])->name('contact.callback');
Route::post('/contact/inquiry', [ContactController::class, 'inquiry'])->name('contact.inquiry');

// ─── Sitemap & robots ───────────────────────────────────────
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/sitemap-main.xml', [SitemapController::class, 'main'])->name('sitemap.main');
Route::get('/sitemap-guides.xml', [SitemapController::class, 'guides'])->name('sitemap.guides');
Route::get('/sitemap-audits.xml', [SitemapController::class, 'audits'])->name('sitemap.audits');
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
Route::get('/audits/{slug}',     [AuditContentController::class, 'show'])->name('et.audits.show');

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
    Route::get('/audits/{slug}',   [AuditContentController::class, 'show'])->defaults('locale', 'ru')->name('ru.audits.show');
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
    Route::get('/audits/{slug}',     [AuditContentController::class, 'show'])->defaults('locale', 'en')->name('en.audits.show');
});


