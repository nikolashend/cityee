<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Form submission routes
Route::post('/contact/callback', [ContactController::class, 'callback'])->name('contact.callback');
Route::post('/contact/inquiry', [ContactController::class, 'inquiry'])->name('contact.inquiry');

// Estonian routes (default)
Route::get('/', [PageController::class, 'home'])->name('et.home');
Route::get('/kinnisvara-muuk', [PageController::class, 'kinnisvaraMuuk'])->name('et.kinnisvara-muuk');
Route::get('/kinnisvara-uur', [PageController::class, 'kinnisvaraUur'])->name('et.kinnisvara-uur');
Route::get('/konsultatsioon', [PageController::class, 'konsultatsioon'])->name('et.konsultatsioon');
Route::get('/kontaktid', [PageController::class, 'kontaktid'])->name('et.kontaktid');

// Russian routes
Route::prefix('ru')->group(function () {
    Route::get('/', [PageController::class, 'home'])->defaults('locale', 'ru')->name('ru.home');
    Route::get('/kinnisvara-muuk', [PageController::class, 'kinnisvaraMuuk'])->defaults('locale', 'ru')->name('ru.kinnisvara-muuk');
    Route::get('/kinnisvara-uur', [PageController::class, 'kinnisvaraUur'])->defaults('locale', 'ru')->name('ru.kinnisvara-uur');
    Route::get('/konsultatsioon', [PageController::class, 'konsultatsioon'])->defaults('locale', 'ru')->name('ru.konsultatsioon');
    Route::get('/kontaktid', [PageController::class, 'kontaktid'])->defaults('locale', 'ru')->name('ru.kontaktid');
});
