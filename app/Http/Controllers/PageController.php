<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home($locale = 'et')
    {
        app()->setLocale($locale);
        return view("pages.{$locale}.home");
    }

    public function kinnisvaraMuuk($locale = 'et')
    {
        app()->setLocale($locale);
        return view("pages.{$locale}.kinnisvara-muuk");
    }

    public function kinnisvaraUur($locale = 'et')
    {
        app()->setLocale($locale);
        return view("pages.{$locale}.kinnisvara-uur");
    }

    public function konsultatsioon($locale = 'et')
    {
        app()->setLocale($locale);
        return view("pages.{$locale}.konsultatsioon");
    }

    public function kontaktid($locale = 'et')
    {
        app()->setLocale($locale);
        return view("pages.{$locale}.kontaktid");
    }
}
