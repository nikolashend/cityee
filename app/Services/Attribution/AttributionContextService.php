<?php

namespace App\Services\Attribution;

use Illuminate\Http\Request;

/**
 * First-party attribution (X999^5 §6 variant B / §7 / §8).
 *
 * Captures first-touch (once) and last-touch (updated on each qualifying event)
 * into the server-side session, surviving internal navigation. The server is the
 * source of truth; hidden form fields are NOT trusted over server context.
 *
 * Rules enforced (§7.3):
 *   • first-touch is set once (first landing) and never overwritten by a direct return;
 *   • last-touch updates only on a NEW qualifying event (paid click / UTM / external referrer);
 *   • internal referrers are ignored;
 *   • all values are sanitized + length-limited; oversized/HTML payloads are rejected.
 */
class AttributionContextService
{
    private const SESSION_FIRST = '_attr_first';
    private const SESSION_LAST  = '_attr_last';
    private const MAX = ['source' => 60, 'medium' => 60, 'campaign' => 120, 'term' => 120, 'content' => 120, 'id' => 200, 'url' => 500];

    private const PAID_MEDIUMS = ['cpc', 'ppc', 'paid', 'paidsearch', 'paid_search', 'display', 'cpm'];

    /** Update session first/last touch from the current request (called by middleware on GET). */
    public function updateSession(Request $request): void
    {
        if (! $request->hasSession()) {
            return;
        }
        $touch = $this->touchFromRequest($request);

        // First touch: capture the first landing (even if direct) exactly once.
        if (! $request->session()->has(self::SESSION_FIRST)) {
            $request->session()->put(self::SESSION_FIRST, $touch);
        }

        // Last touch: update only on a NEW qualifying event (never on a plain direct return).
        if ($this->isQualifying($touch)) {
            $request->session()->put(self::SESSION_LAST, $touch);
        }
    }

    /** Full attribution context to persist on a Lead, resolved at submit time. */
    public function contextForLead(Request $request): array
    {
        $first = $request->hasSession() ? $request->session()->get(self::SESSION_FIRST) : null;
        $last  = $request->hasSession() ? $request->session()->get(self::SESSION_LAST) : null;

        // If nothing was captured (e.g. session lost), fall back to this request.
        $now = $this->touchFromRequest($request);
        $first = $first ?: $now;
        $last  = $last ?: ($this->isQualifying($now) ? $now : $first);

        return [
            'first'          => $first,
            'last'           => $last,
            'landing_page'   => $this->limit($first['landing_page'] ?? null, self::MAX['url']),
            'submission_page'=> $this->limit($this->pathAndQuery($request), self::MAX['url']),
            'referrer'       => $this->limit($request->headers->get('referer'), self::MAX['url']),
            'ga_client_id'   => $this->gaClientId($request),
            'ga_session_id'  => $this->gaSessionId($request),
        ];
    }

    /** Build a sanitized touch snapshot from the request. */
    public function touchFromRequest(Request $request): array
    {
        $referrer = $request->headers->get('referer');
        $touch = [
            'source'       => $this->s($request->query('utm_source'), 'source'),
            'medium'       => $this->s($request->query('utm_medium'), 'medium'),
            'campaign'     => $this->s($request->query('utm_campaign'), 'campaign'),
            'term'         => $this->s($request->query('utm_term'), 'term'),
            'content'      => $this->s($request->query('utm_content'), 'content'),
            'gclid'        => $this->s($request->query('gclid'), 'id'),
            'gbraid'       => $this->s($request->query('gbraid'), 'id'),
            'wbraid'       => $this->s($request->query('wbraid'), 'id'),
            'referrer'     => $this->limit($referrer, self::MAX['url']),
            'landing_page' => $this->limit($this->pathAndQuery($request), self::MAX['url']),
            'seen_at'      => now()->toIso8601String(),
        ];
        $touch['class'] = $this->classify($touch, $request);
        return $touch;
    }

    /** Deterministic source classifier (§8). */
    public function classify(array $touch, ?Request $request = null): string
    {
        // 1) paid click identifiers
        if (! empty($touch['gclid']) || ! empty($touch['gbraid']) || ! empty($touch['wbraid'])) {
            return 'google_ads';
        }
        // 2) explicit UTM
        $src = strtolower((string) ($touch['source'] ?? ''));
        $med = strtolower((string) ($touch['medium'] ?? ''));
        if ($src !== '') {
            if (str_contains($src, 'google') && in_array($med, self::PAID_MEDIUMS, true)) {
                return 'google_ads';
            }
            if (str_contains($src, 'google')) return 'google_organic';
            if (str_contains($src, 'bing'))   return 'bing_organic';
            if (in_array($src, ['whatsapp', 'wa'], true))  return 'whatsapp';
            if (in_array($src, ['telegram', 'tg'], true))  return 'telegram';
            if (in_array($med, ['referral'], true))        return 'referral';
            return 'other_organic';
        }
        // 3) external referrer
        $host = $this->referrerHost($touch['referrer'] ?? null, $request);
        if ($host !== null && ! $this->isInternalHost($host, $request)) {
            if (str_contains($host, 'google.'))          return 'google_organic';
            if (str_contains($host, 'bing.'))            return 'bing_organic';
            if (preg_match('#(yahoo|duckduckgo|yandex|ecosia)\.#', $host)) return 'other_organic';
            return 'referral';
        }
        // 4) nothing → direct (or unknown if we truly can't tell)
        return 'direct';
    }

    /** A touch is "qualifying" for last-touch update if it carries real attribution. */
    public function isQualifying(array $touch, ?Request $request = null): bool
    {
        if (! empty($touch['gclid']) || ! empty($touch['gbraid']) || ! empty($touch['wbraid'])) return true;
        if (! empty($touch['source'])) return true;
        $host = $this->referrerHost($touch['referrer'] ?? null, $request);
        return $host !== null && ! $this->isInternalHost($host, $request);
    }

    // ── helpers ──────────────────────────────────────────────────

    private function s(?string $v, string $kind): ?string
    {
        if ($v === null) return null;
        $v = strip_tags(trim($v));
        if ($v === '') return null;
        // reject payloads with HTML/script or control chars beyond plausible params
        if (preg_match('/[<>{}]|javascript:|script/i', $v)) return null;
        return $this->limit($v, self::MAX[$kind] ?? 120);
    }

    private function limit(?string $v, int $max): ?string
    {
        if ($v === null) return null;
        $v = trim($v);
        return $v === '' ? null : mb_substr($v, 0, $max);
    }

    private function pathAndQuery(Request $request): string
    {
        $qs = $request->getQueryString();
        return $request->getPathInfo() . ($qs ? '?' . $qs : '');
    }

    private function referrerHost(?string $referrer, ?Request $request): ?string
    {
        if (! $referrer) return null;
        return strtolower((string) parse_url($referrer, PHP_URL_HOST)) ?: null;
    }

    private function isInternalHost(string $host, ?Request $request): bool
    {
        $internal = ['cityee.ee', 'www.cityee.ee', 'localhost', '127.0.0.1'];
        if ($request) {
            $internal[] = strtolower($request->getHost());
            $appHost = strtolower((string) parse_url((string) config('app.url'), PHP_URL_HOST));
            if ($appHost) $internal[] = $appHost;
        }
        return in_array($host, $internal, true);
    }

    /** GA4 client id from the _ga cookie (GA1.1.<cid1>.<cid2>) — non-PII. */
    private function gaClientId(Request $request): ?string
    {
        $ga = $request->cookie('_ga');
        if (! $ga || ! preg_match('/^GA\d\.\d\.(\d+\.\d+)$/', $ga, $m)) return null;
        return $m[1];
    }

    private function gaSessionId(Request $request): ?string
    {
        foreach ($request->cookies->all() as $name => $val) {
            if (str_starts_with($name, '_ga_') && preg_match('/GS\d\.\d\.(\d+)/', (string) $val, $m)) {
                return $m[1];
            }
        }
        return null;
    }
}
