<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force trailing slash on all GET requests for canonical URL consistency.
 * All SeoLinks canonical URLs use trailing slashes — this ensures
 * the browser URL always matches the canonical to prevent
 * "Alternate page with canonical tag" in Search Console.
 *
 * Excludes: files with extensions (.xml, .txt, .css, .js, .png etc.),
 * sitemap routes, robots.txt, and POST/PUT/DELETE etc.
 */
class TrailingSlash
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply to GET requests
        if (!$request->isMethod('GET')) {
            return $next($request);
        }

        $path = $request->getPathInfo();

        // Skip root path (already has implicit trailing slash)
        if ($path === '/' || $path === '') {
            return $next($request);
        }

        // Skip paths with file extensions (sitemap.xml, robots.txt, images, etc.)
        if (preg_match('/\.\w{2,5}$/', $path)) {
            return $next($request);
        }
        // Add trailing slash if missing
        if (!str_ends_with($path, '/')) {
            $query = $request->getQueryString();
            $target = $path . '/' . ($query ? '?' . $query : '');
            return redirect($target, 301);
        }

        return $next($request);
    }
}
