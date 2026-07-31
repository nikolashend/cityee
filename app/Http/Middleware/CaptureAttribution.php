<?php

namespace App\Http\Middleware;

use App\Services\Attribution\AttributionContextService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Persist first/last-touch attribution into the session on page views (X999^5 §7).
 * GET HTML requests only — never touches POST (form submits read the session).
 * Best-effort: any failure here must never affect the page or a lead.
 */
class CaptureAttribution
{
    public function __construct(private AttributionContextService $attribution)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('GET') && $request->hasSession() && ! $request->ajax()) {
            try {
                $this->attribution->updateSession($request);
            } catch (\Throwable $e) {
                // Attribution is auxiliary; never break the request.
            }
        }

        return $next($request);
    }
}
