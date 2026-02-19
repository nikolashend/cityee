<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * 301 redirect old / dead URLs to prevent 404s in Search Console.
 * Handles: legacy WordPress paths, old index.php/index.html, common crawl errors.
 */
class RedirectOldUrls
{
    /**
     * Static redirect map: old path → new path (all relative to domain root).
     * Add entries here when Search Console reports 404s.
     */
    private const REDIRECTS = [
        // Legacy index files
        '/index.php'  => '/',
        '/index.html' => '/',

        // Common WordPress legacy paths
        '/wp-admin'          => '/',
        '/wp-login.php'      => '/',
        '/wp-content'        => '/',
        '/xmlrpc.php'        => '/',

        // Old Estonian pages (if URLs changed)
        '/teenused'          => '/kinnisvara-muuk/',
        '/kontakt'           => '/kontaktid/',

        // Old Russian pages without prefix (moved to /ru/)
        '/prodazha-nedvizhimosti' => '/ru/kinnisvara-muuk/',
        '/arenda-nedvizhimosti'   => '/ru/kinnisvara-uur/',

        // Old English pages without prefix (moved to /en/)
        '/sell'         => '/en/sell-property/',
        '/rent'         => '/en/rent-out-property/',
        '/consultation' => '/en/consultation/',
        '/contacts'     => '/en/contacts/',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $path = '/' . ltrim($request->path(), '/');

        // 1. Exact match redirect
        if (isset(self::REDIRECTS[$path])) {
            return redirect(self::REDIRECTS[$path], 301);
        }

        // 2. Strip trailing /index.php or /index.html from any path
        if (preg_match('#^(.+?)/index\.(php|html)$#', $path, $m)) {
            $target = rtrim($m[1], '/') . '/';
            return redirect($target, 301);
        }

        return $next($request);
    }
}
