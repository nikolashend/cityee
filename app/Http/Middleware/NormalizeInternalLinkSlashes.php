<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Point every internal <a href> at the trailing-slash canonical URL.
 * CITYEE X999^5 §8 — trailing-slash contract (KEEP slash policy).
 *
 * Production nginx enforces a trailing slash and 301s non-slash URLs, but
 * Laravel's route()/url() emit non-slash URLs, so internal links traverse a
 * redirect (INV: internal_links_to_301 = 0 was violated). This normalizer
 * rewrites internal anchor hrefs to their slash form in the rendered HTML —
 * one central, reversible place — instead of editing dozens of templates.
 *
 * ONLY rewrites href values that are:
 *   • root-relative ("/...", not "//host")
 *   • without a query (?) or fragment (#)
 *   • whose last path segment has NO file extension (skip assets)
 *   • not already ending in "/"
 * It never touches mailto:/tel:/http(s):// links, form actions, <link> assets,
 * or JSON-LD. Both /x and /x/ resolve, so worst case is a no-op — no lead path
 * can break from this.
 */
class NormalizeInternalLinkSlashes
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only HTML responses; skip redirects, files, JSON/XML, streamed.
        $ct = (string) $response->headers->get('Content-Type');
        if (! str_contains($ct, 'text/html')) {
            return $response;
        }
        $content = $response->getContent();
        if ($content === false || $content === '' || ! str_contains($content, '<a')) {
            return $response;
        }

        // Hosts that count as internal (prod route() emits ABSOLUTE URLs).
        $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));
        $internalHosts = array_values(array_filter(array_unique([
            $appHost, strtolower($request->getHost()), 'cityee.ee', 'www.cityee.ee',
        ])));

        $content = preg_replace_callback(
            '/\bhref=(["\'])([^"\']*)\1/i',
            static function (array $m) use ($internalHosts): string {
                $q = $m[1];
                $href = $m[2];
                if ($href === '') {
                    return $m[0];
                }

                if (str_contains($href, '?') || str_contains($href, '#')) {
                    return $m[0];                                   // query / fragment
                }

                // Split into "$prefix" (scheme://host, empty for root-relative) + "$path".
                $prefix = '';
                if ($href[0] === '/' && ! str_starts_with($href, '//')) {
                    $path = $href;                                  // root-relative
                } elseif (preg_match('#^(https?://[^/]+)(/.*)$#i', $href, $u)) {
                    $host = strtolower((string) parse_url($u[1], PHP_URL_HOST));
                    if (! in_array($host, $internalHosts, true)) {
                        return $m[0];                               // external host
                    }
                    $prefix = $u[1];                                // scheme://host
                    $path = $u[2];
                } else {
                    return $m[0];                                   // mailto:/tel:/relative/root-only
                }
                if ($path === '/' || str_ends_with($path, '/')) {
                    return $m[0];                                   // already canonical
                }
                $lastSegment = substr($path, strrpos($path, '/') + 1);
                if (str_contains($lastSegment, '.')) {
                    return $m[0];                                   // asset (has extension)
                }
                return "href={$q}{$prefix}{$path}/{$q}";
            },
            $content
        );

        $response->setContent($content);
        return $response;
    }
}
