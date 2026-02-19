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
            \App\Http\Middleware\NoIndexQueryParams::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
