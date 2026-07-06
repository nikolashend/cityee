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
        '/teenused'          => '/kinnisvara-muuk',
        '/kontakt'           => '/kontaktid',

        // Old Russian pages without prefix (moved to /ru/)
        '/prodazha-nedvizhimosti' => '/ru/kinnisvara-muuk',
        '/arenda-nedvizhimosti'   => '/ru/kinnisvara-uur',

        // Old English pages without prefix (moved to /en/)
        '/sell'         => '/en/sell-property',
        '/rent'         => '/en/rent-out-property',
        '/consultation' => '/en/consultation',
        '/contacts'     => '/en/contacts',

        // Phase 3 — /locations/ → /tallinn/ migration
        '/ru/locations/tallinn'    => '/ru/tallinn',
        '/ru/locations/lasnamae'   => '/ru/tallinn/lasnamae',
        '/ru/locations/mustamae'   => '/ru/tallinn/mustamae',
        '/ru/locations/kesklinn'   => '/ru/tallinn/kesklinn',
        '/ru/locations/haabersti'  => '/ru/tallinn/haabersti',
        '/ru/locations/kristiine'  => '/ru/tallinn/kristiine',
        '/locations/tallinn'       => '/ru/tallinn',
        '/locations/lasnamae'      => '/ru/tallinn/lasnamae',
        '/locations/mustamae'      => '/ru/tallinn/mustamae',
        '/locations/kesklinn'      => '/ru/tallinn/kesklinn',
        '/locations/haabersti'     => '/ru/tallinn/haabersti',
        '/locations/kristiine'     => '/ru/tallinn/kristiine',
        '/en/locations/tallinn'    => '/ru/tallinn',
        '/en/locations/lasnamae'   => '/ru/tallinn/lasnamae',
        '/en/locations/mustamae'   => '/ru/tallinn/mustamae',
        '/en/locations/kesklinn'   => '/ru/tallinn/kesklinn',
        '/en/locations/haabersti'  => '/ru/tallinn/haabersti',
        '/en/locations/kristiine'  => '/ru/tallinn/kristiine',

        // GSC — index duplicates (INV-9: /index → /)
        '/index'     => '/',
        '/ru/index'  => '/ru',
        '/en/index'  => '/en',
    ];

    /**
     * Query-parameter redirect map: path → clean canonical path.
     * When a path has filter/tracking query params, redirect to clean base URL.
     * This ensures Google sees the 301 and consolidates crawl to canonical URL.
     * RULE-006: query URL → redirect to clean canonical.
     */
    private const QUERY_REDIRECTS = [
        '/ru/guides'    => '/ru/guides',
        '/ru/audits'    => '/ru/audits',
        '/en/guides'    => '/en/guides',
        '/en/audits'    => '/en/audits',
        '/guides'       => '/guides',
        '/audits'       => '/audits',
        '/knowledge'    => '/knowledge',
        '/ru/knowledge' => '/ru/knowledge',
        '/en/knowledge' => '/en/knowledge',
    ];

    /**
     * Legacy hosts that must 301 to the canonical path-based equivalent.
     * host => [prefix to prepend, ...]. Belt-and-suspenders for the server rule
     * (see docs/seo-indexation-diagnosis.md §6). Only fires if the subdomain
     * actually reaches this app; harmless otherwise.
     */
    private const LEGACY_HOSTS = [
        'ru.cityee.ee'     => '/ru',
        'www.cityee.ee'    => '',
    ];

    private const CANONICAL_HOST = 'cityee.ee';

    public function handle(Request $request, Closure $next): Response
    {
        // 0. Legacy subdomain / www → canonical host (path-based), one hop.
        $host = strtolower($request->getHost());
        if (isset(self::LEGACY_HOSTS[$host])) {
            $prefix = self::LEGACY_HOSTS[$host];
            $target = 'https://' . self::CANONICAL_HOST . $prefix . $request->getRequestUri();
            return redirect($target, 301);
        }

        $path = '/' . ltrim($request->path(), '/');

        // 1. Config-driven redirect map (config/seo_redirects.php) — single source
        //    of truth, also consumed by seo:audit-* and RedirectCheck commands.
        //    Supports status 410 (Gone) with a null/absent target.
        $configRedirects = config('seo_redirects', []);
        if (isset($configRedirects[$path])) {
            $rule   = $configRedirects[$path];
            $status = $rule['status'] ?? 301;
            if ($status === 410) {
                abort(410);
            }
            if (! empty($rule['target'])) {
                return redirect($rule['target'], $status);
            }
        }

        // 2. Hardcoded legacy exact-match redirect (backward compat)
        if (isset(self::REDIRECTS[$path])) {
            return redirect(self::REDIRECTS[$path], 301);
        }

        // 3. Query-param cleanup: strip filter/tracking params and redirect to clean URL
        //    Apply only on known content paths with query params (RULE-006)
        if ($request->getQueryString() && isset(self::QUERY_REDIRECTS[$path])) {
            return redirect(self::QUERY_REDIRECTS[$path], 301);
        }

        // 4. Strip trailing /index.php or /index.html from any path
        if (preg_match('#^(.+?)/index\.(php|html)$#', $path, $m)) {
            $target = rtrim($m[1], '/') ?: '/';
            return redirect($target, 301);
        }

        return $next($request);
    }
}
