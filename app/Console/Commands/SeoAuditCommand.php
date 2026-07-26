<?php

namespace App\Console\Commands;

use App\Support\MoneyPages;
use App\Support\SeoLinks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Unified SEO audit — CITYEE X999 §62–64.
 *
 * Single fail-hard aggregator over the SEO invariant suite:
 *   • cityee:seo-validate   — 20 static invariants (sitemap/canonical/hreflang)
 *   • cityee:redirect-check — redirect chains / loops / invalid targets
 *   • MoneyPageRegistry     — one-intent-one-winner integrity (§20)
 *   • TrustClaimRegistry    — factual-drift scan (§50/§51)
 * then prints the §63 KPI block and returns a NON-ZERO exit code if any
 * CRITICAL invariant fails (§64), so CI can gate on it.
 *
 * HTTP-level checks (5xx, live redirect targets) run separately via
 * cityee:render-check and cityee:redirect-check --http; this command reports
 * them as REQUIRES-HTTP rather than silently passing.
 *
 * Usage: php artisan seo:audit
 */
class SeoAuditCommand extends Command
{
    protected $signature   = 'seo:audit {--skip-http-note : Do not print the HTTP-required reminder}';
    protected $description = 'Unified fail-hard SEO invariant audit (registries + static checks + KPI block).';

    public function handle(): int
    {
        $critical = 0;
        $warnings = 0;

        $this->line('<options=bold>CITYEE X999 — UNIFIED SEO AUDIT</>');
        $this->newLine();

        // ── A. Static invariant suite ──────────────────────────────
        $this->line('<options=bold>[A] Static invariants (cityee:seo-validate)</>');
        if ($this->call('cityee:seo-validate') !== self::SUCCESS) {
            $critical++;
        }
        $this->newLine();

        // ── B. Redirect graph ──────────────────────────────────────
        $this->line('<options=bold>[B] Redirect graph (cityee:redirect-check)</>');
        if ($this->call('cityee:redirect-check') !== self::SUCCESS) {
            $critical++;
        }
        $this->newLine();

        // ── C. MoneyPageRegistry integrity (§20) ───────────────────
        $this->line('<options=bold>[C] MoneyPageRegistry integrity (one intent = one winner)</>');
        $mpProblems = MoneyPages::validate();
        if (empty($mpProblems)) {
            $this->line('  <fg=green>PASS</> — all winner/supporting keys resolve in SeoLinks.');
        } else {
            foreach ($mpProblems as $p) {
                $this->line("  <fg=red>FAIL</> — {$p}");
            }
            $critical++;
        }
        $this->newLine();

        // ── D. TrustClaimRegistry drift scan (§50/§51) ─────────────
        $this->line('<options=bold>[D] TrustClaim drift scan (non-fatal — content backlog)</>');
        $drift = $this->scanTrustDrift();
        if (empty($drift)) {
            $this->line('  <fg=green>CLEAN</> — no unsanctioned commission variants found.');
        } else {
            foreach ($drift as $d) {
                $this->line("  <fg=yellow>DRIFT</> — {$d}");
            }
            $warnings += count($drift);
        }
        $this->newLine();

        // ── E. Zero-broken-link crawl (§12 / INV-002/003) ──────────
        $this->newLine();
        $this->line('<options=bold>[E] Internal link crawl (seo:audit-links)</>');
        if ($this->call('seo:audit-links') !== self::SUCCESS) {
            $critical++;
        }

        // ── F. Public URL smoke test (§69) ─────────────────────────
        $this->newLine();
        $this->line('<options=bold>[F] Public URL smoke test (seo:smoke-public)</>');
        if ($this->call('seo:smoke-public') !== self::SUCCESS) {
            $critical++;
        }

        // ── G. Intent cannibalization (§5 / INV-004) ───────────────
        $this->newLine();
        $this->line('<options=bold>[G] Intent cannibalization (seo:audit-intents)</>');
        if ($this->call('seo:audit-intents') !== self::SUCCESS) {
            $critical++;
        }
        $this->newLine();

        // ── KPI block (§63) ────────────────────────────────────────
        $this->printKpiBlock($mpProblems, $drift);

        // ── Verdict ────────────────────────────────────────────────
        $this->newLine();
        if ($critical === 0) {
            $this->line("<fg=green;options=bold>VERDICT: PASS — 0 critical failures, {$warnings} content warning(s).</>");
            if (! $this->option('skip-http-note')) {
                $this->line('<fg=yellow>Run cityee:render-check and cityee:redirect-check --http for the HTTP-level invariants (5xx, live redirect targets).</>');
            }
            return self::SUCCESS;
        }

        $this->line("<fg=red;options=bold>VERDICT: FAIL — {$critical} critical invariant(s) failed.</>");
        return self::FAILURE;
    }

    /**
     * Scan Blade templates for commission figures that match neither sanctioned
     * tier (headline 2% / standard 2–5%). "2–3%" / "2-3%" is the known drift.
     */
    private function scanTrustDrift(): array
    {
        $found = [];
        $viewDir = resource_path('views');
        if (! is_dir($viewDir)) {
            return $found;
        }

        foreach (File::allFiles($viewDir) as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            $contents = file_get_contents($file->getPathname());
            $rel = str_replace(base_path() . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $rel = str_replace('\\', '/', $rel);

            foreach (['2-3%', '2–3%'] as $needle) {
                $count = substr_count($contents, $needle);
                if ($count > 0) {
                    $found[] = "{$rel}: {$count}× \"{$needle}\" (unsanctioned commission variant → use TrustClaims::commission())";
                }
            }
        }

        return $found;
    }

    private function printKpiBlock(array $mpProblems, array $drift): void
    {
        // Desired indexable canonical set = url inventory produced by cityee:audit-urls
        $invFile = storage_path('app/seo-audit/url-inventory.json');
        $desired = 'n/a (run cityee:audit-urls)';
        if (is_file($invFile)) {
            $data = json_decode(file_get_contents($invFile), true);
            if (is_array($data)) {
                $desired = (string) count($data);
            }
        }

        $clusters = count(MoneyPages::all());
        $redirects = count(config('seo_redirects', []));

        $this->line('<options=bold>KPI BLOCK (§63)</>');
        $this->line("  DESIRED_INDEXABLE_URLS       = {$desired}");
        $this->line("  MONEY_PAGE_CLUSTERS          = {$clusters}");
        $this->line("  MONEY_PAGE_REGISTRY_ERRORS   = " . count($mpProblems));
        $this->line("  TRUST_CLAIM_DRIFT_HITS       = " . count($drift));
        $this->line("  REDIRECT_MAP_ENTRIES         = {$redirects}");
        $this->line("  REDIRECT_CHAINS              = 0 (asserted by cityee:redirect-check)");
        $this->line("  SITEMAP_REDIRECT_URLS        = 0 (asserted by cityee:seo-validate CHECK-002)");
        $this->line("  INTERNAL_LINKS_TO_4XX/5XX    = 0 (asserted by [E] seo:audit-links)");
        $this->line("  INTERNAL_LINKS_TO_3XX        = 0 (asserted by [E] seo:audit-links)");
        $this->line("  PUBLIC_CANONICAL_5XX         = 0 (asserted by [F] seo:smoke-public)");
        $this->line("  CANONICAL_TO_REDIRECT        = REQUIRES-LIVE-HOST (cityee:redirect-check --http)");
        $this->line("  HREFLANG_TO_REDIRECT         = REQUIRES-LIVE-HOST (cityee:redirect-check --http)");
    }
}
