<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Adds <meta name="robots" content="noindex, follow"> header
 * when the request URL contains tracking/filter query parameters.
 * Prevents duplicate/thin pages from being indexed.
 */
class NoIndexQueryParams
{
    /**
     * Query parameter prefixes/names that trigger noindex.
     */
    private const NOINDEX_PARAMS = [
        'utm_',
        'fbclid',
        'gclid',
        'trk',
        'ref',
        'sort',
        'page',
        'filter',
        'source',
        'campaign',
        'mc_cid',
        'mc_eid',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($this->hasNoIndexParam($request)) {
            $response->headers->set('X-Robots-Tag', 'noindex, follow');
        }

        return $response;
    }

    private function hasNoIndexParam(Request $request): bool
    {
        $queryKeys = array_keys($request->query());

        foreach ($queryKeys as $key) {
            foreach (self::NOINDEX_PARAMS as $param) {
                if (str_starts_with($key, $param) || $key === $param) {
                    return true;
                }
            }
        }

        return false;
    }
}
