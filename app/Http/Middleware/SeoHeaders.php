<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PHASE 1 SEO — Response headers for all HTML pages.
 *
 * 1. Content-Language based on the active locale.
 * 2. X-Robots-Tag: index, follow for indexable pages (default).
 *    noindex, follow for pages with query params (handled by NoIndexQueryParams).
 * 3. Vary: Accept-Language (tells caches the response varies by language).
 */
class SeoHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only add headers to HTML responses
        $contentType = $response->headers->get('Content-Type', '');
        if (!str_contains($contentType, 'text/html') && $contentType !== '') {
            return $response;
        }

        $locale = app()->getLocale() ?: 'et';

        // Content-Language — tells crawlers and CDN caches what language this page is
        $langMap = ['et' => 'et-EE', 'ru' => 'ru-EE', 'en' => 'en-EE'];
        $response->headers->set('Content-Language', $langMap[$locale] ?? 'et-EE');

        // Vary: Accept-Language — important for CDN and proxy caches
        $response->headers->set('Vary', 'Accept-Language');

        return $response;
    }
}
