<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share company and agent config globally with all views
        View::composer('*', function ($view) {
            $locale = app()->getLocale() ?: 'et';

            $view->with('locale', $view->getData()['locale'] ?? $locale);
            $view->with('ui', $view->getData()['ui'] ?? config("cityee.ui.{$locale}", []));
            $view->with('nav', $view->getData()['nav'] ?? config("cityee.nav.{$locale}", []));
        });
    }
}
