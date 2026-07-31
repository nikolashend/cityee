<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // SEO middleware order: old URL redirects → canonical cleanup
        // NOTE: TrailingSlash is intentionally disabled — Laravel registers routes
        // without trailing slashes (Symfony strips them), so adding slashes via
        // middleware creates an infinite redirect loop. SEO canonicalization is
        // handled by <link rel="canonical"> and hreflang tags in the HTML <head>.
        $middleware->prepend(\App\Http\Middleware\CanonicalRedirects::class);
        $middleware->prepend(\App\Http\Middleware\RedirectOldUrls::class);
        $middleware->web(append: [
            // X999^5 §7 — capture first/last-touch attribution into the session (GET only)
            \App\Http\Middleware\CaptureAttribution::class,
            \App\Http\Middleware\NoIndexQueryParams::class,
            \App\Http\Middleware\SeoHeaders::class,
            // X999^5 §8 — internal <a href> → trailing-slash canonical (kills internal 301s)
            \App\Http\Middleware\NormalizeInternalLinkSlashes::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
