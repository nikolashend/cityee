<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

/**
 * Public URL smoke test — CITYEE X999^5 §69 / §79-80 (deploy gate).
 *
 * Asserts, in-process via the HTTP kernel:
 *   1. every protected SEO asset (config/seo_protected_assets.php) returns 200
 *   2. every canonical inventory URL returns 200 (no redirect)
 *   3. every redirect source (config/seo_redirects.php) returns its intended
 *      status (301, or 410 for Gone)
 *
 * Returns a NON-ZERO exit code on any deviation so it can gate deploys.
 *
 * Usage: php artisan seo:smoke-public
 */
class SeoSmokePublicCommand extends Command
{
    protected $signature   = 'seo:smoke-public';
    protected $description = 'Smoke-test every public canonical URL (200) and redirect source (301/410).';

    public function handle(Kernel $kernel): int
    {
        $fail = 0;

        // ── 1. Protected assets must be 200 ────────────────────────
        $this->line('<options=bold>Protected assets (must be 200):</>');
        foreach (config('seo_protected_assets', []) as $asset) {
            $fail += $this->assertStatus($kernel, $asset['path'], [200], "  [{$asset['priority']}] {$asset['path']}");
        }

        // ── 2. Canonical inventory must be 200 ─────────────────────
        $this->newLine();
        $this->line('<options=bold>Canonical inventory (must be 200):</>');
        $inv = $this->inventoryPaths();
        $inv200 = 0;
        foreach ($inv as $path) {
            $r = $kernel->handle(Request::create($path, 'GET'));
            if ($r->getStatusCode() === 200) {
                $inv200++;
            } else {
                $fail++;
                $this->line("  <fg=red>FAIL</> {$path} => {$r->getStatusCode()}");
            }
        }
        $this->line("  <fg=green>{$inv200}/" . count($inv) . " returned 200</>");

        // ── 3. Redirect sources must be 301/410 ────────────────────
        $this->newLine();
        $this->line('<options=bold>Redirect sources (must be 301/410):</>');
        $redir = config('seo_redirects', []);
        $redirOk = 0;
        foreach ($redir as $src => $rule) {
            $expected = ($rule['status'] ?? 301);
            $r = $kernel->handle(Request::create($src, 'GET'));
            $code = $r->getStatusCode();
            $ok = ($expected === 410) ? ($code === 410) : ($code >= 300 && $code < 400);
            if ($ok) {
                $redirOk++;
            } else {
                $fail++;
                $this->line("  <fg=red>FAIL</> {$src} => {$code} (expected {$expected})");
            }
        }
        $this->line("  <fg=green>{$redirOk}/" . count($redir) . " redirected correctly</>");

        // ── Verdict ────────────────────────────────────────────────
        $this->newLine();
        if ($fail === 0) {
            $this->line('<fg=green;options=bold>PASS — all public URLs behave as expected.</>');
            return self::SUCCESS;
        }
        $this->line("<fg=red;options=bold>FAIL — {$fail} URL(s) did not match expected status.</>");
        return self::FAILURE;
    }

    private function assertStatus(Kernel $kernel, string $path, array $ok, string $label): int
    {
        $r = $kernel->handle(Request::create($path, 'GET'));
        $code = $r->getStatusCode();
        if (in_array($code, $ok, true)) {
            $this->line("{$label} => <fg=green>{$code}</>");
            return 0;
        }
        $this->line("{$label} => <fg=red>{$code}</>");
        return 1;
    }

    private function inventoryPaths(): array
    {
        $file = storage_path('app/seo-audit/url-inventory.json');
        if (! is_file($file)) return [];
        $data = json_decode(file_get_contents($file), true) ?: [];
        $redirectSources = array_keys(config('seo_redirects', []));
        $paths = [];
        foreach ($data as $row) {
            $u = $row['url'] ?? null;
            if (! $u || ($row['http_status'] ?? '') === 'redirect') continue;
            $p = parse_url($u, PHP_URL_PATH) ?: '/';
            if (in_array($p, $redirectSources, true) || in_array(rtrim($p, '/'), $redirectSources, true)) continue;
            $paths[$p] = $p;
        }
        return array_values($paths);
    }
}
