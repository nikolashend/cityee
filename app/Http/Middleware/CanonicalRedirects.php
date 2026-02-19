<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ЭТАП 3 — SEO Canonical Redirects
 *
 * 1. Strips /index, /index.html, /index.php → 301 to clean path
 * 2. Prevents double slashes
 */
class CanonicalRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only process GET requests
        if (! $request->isMethod('GET')) {
            return $next($request);
        }

        $path = $request->getPathInfo();
        $original = $path;

        // Skip static assets
        if (preg_match('#\.(xml|txt|css|js|png|jpg|jpeg|gif|svg|ico|woff2?|ttf|eot|map)$#i', $path)) {
            return $next($request);
        }

        // 1. Remove /index, /index.html, /index.php suffixes
        $path = preg_replace('#/index(\.html?|\.php)?$#i', '/', $path);

        // 2. Collapse double slashes
        $path = preg_replace('#/{2,}#', '/', $path);

        // Redirect if path changed
        if ($path !== $original) {
            $query = $request->getQueryString();
            $target = $path . ($query ? '?' . $query : '');
            return redirect($target, 301);
        }

        return $next($request);
    }
}
