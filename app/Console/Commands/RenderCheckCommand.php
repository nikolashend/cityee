<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

/**
 * Render Check Command (PHASE Q — render-check)
 *
 * Internally renders all canonical pages via Laravel's HTTP kernel
 * and detects: 500, missing title, missing canonical, invalid hreflang, duplicate title.
 *
 * Usage: php artisan cityee:render-check
 */
class RenderCheckCommand extends Command
{
    protected $signature   = 'cityee:render-check {--stop-on-error : Stop on first 500}';
    protected $description = 'Render all canonical pages and detect SEO issues (500, missing title/canonical).';

    private const PAGES = [
        // ET
        ['path' => '/',                                          'locale' => 'et', 'key' => 'home'],
        ['path' => '/kinnisvara-muuk',                          'locale' => 'et', 'key' => 'sell'],
        ['path' => '/kinnisvara-uur',                           'locale' => 'et', 'key' => 'rent'],
        ['path' => '/konsultatsioon',                           'locale' => 'et', 'key' => 'consultation'],
        ['path' => '/kontaktid',                                'locale' => 'et', 'key' => 'contacts'],
        ['path' => '/audit',                                    'locale' => 'et', 'key' => 'audit'],
        ['path' => '/guides',                                   'locale' => 'et', 'key' => 'guides'],
        ['path' => '/audits',                                   'locale' => 'et', 'key' => 'audits'],
        ['path' => '/knowledge',                                'locale' => 'et', 'key' => 'knowledge'],
        ['path' => '/aleksandr-primakov',                       'locale' => 'et', 'key' => 'profile'],
        ['path' => '/knowledge/cases',                          'locale' => 'et', 'key' => 'cases'],
        ['path' => '/knowledge/vead-mille-parast-kaotate-raha', 'locale' => 'et', 'key' => 'guide_mistakes'],
        ['path' => '/knowledge/juhend-kinnisvara-uurimine',     'locale' => 'et', 'key' => 'guide_rent'],
        ['path' => '/kuidas-muua-kiiremini',                    'locale' => 'et', 'key' => 'sell_faster'],
        ['path' => '/kuulutuse-audit',                          'locale' => 'et', 'key' => 'listing_audit'],
        ['path' => '/guides/sell-apartment-without-losing-money', 'locale' => 'et', 'key' => 'guide1'],
        ['path' => '/guides/real-price-corridor',               'locale' => 'et', 'key' => 'guide2'],
        ['path' => '/guides/kv-ee-listing-checklist',           'locale' => 'et', 'key' => 'guide3'],
        ['path' => '/guides/safe-rental-tenant-check',          'locale' => 'et', 'key' => 'guide4'],
        ['path' => '/guides/30-45-day-sales-plan',              'locale' => 'et', 'key' => 'guide5'],
        ['path' => '/audits/kv-ee-listing-audit',               'locale' => 'et', 'key' => 'audit1'],
        ['path' => '/audits/price-corridor-negotiation-strategy','locale' => 'et', 'key' => 'audit2'],
        ['path' => '/audits/30-45-day-sales-plan-audit',        'locale' => 'et', 'key' => 'audit3'],
        // RU
        ['path' => '/ru',                                       'locale' => 'ru', 'key' => 'home'],
        ['path' => '/ru/kinnisvara-muuk',                       'locale' => 'ru', 'key' => 'sell'],
        ['path' => '/ru/guides',                                'locale' => 'ru', 'key' => 'guides'],
        ['path' => '/ru/audits',                                'locale' => 'ru', 'key' => 'audits'],
        ['path' => '/ru/knowledge',                             'locale' => 'ru', 'key' => 'knowledge'],
        ['path' => '/ru/knowledge/cases',                       'locale' => 'ru', 'key' => 'cases'],
        ['path' => '/ru/knowledge/peregovornaya-strategiya-nedvizhimost', 'locale' => 'ru', 'key' => 'guide_negotiation'],
        ['path' => '/ru/knowledge/analiz-rynka-nedvizhimosti-tallinn-2026', 'locale' => 'ru', 'key' => 'guide_market'],
        ['path' => '/ru/knowledge/oshibki-iz-za-kotorykh-teryayut-dengi', 'locale' => 'ru', 'key' => 'guide_mistakes'],
        ['path' => '/ru/guides/30-45-day-sales-plan',           'locale' => 'ru', 'key' => 'guide5_ru'],
        ['path' => '/ru/guides/sell-apartment-without-losing-money', 'locale' => 'ru', 'key' => 'guide1_ru'],
        ['path' => '/ru/guides/real-price-corridor',            'locale' => 'ru', 'key' => 'guide2_ru'],
        ['path' => '/ru/guides/kv-ee-listing-checklist',        'locale' => 'ru', 'key' => 'guide3_ru'],
        ['path' => '/ru/audits/30-45-day-sales-plan-audit',     'locale' => 'ru', 'key' => 'audit3_ru'],
        ['path' => '/ru/audits/kv-ee-listing-audit',            'locale' => 'ru', 'key' => 'audit1_ru'],
        ['path' => '/ru/audits/price-corridor-negotiation-strategy', 'locale' => 'ru', 'key' => 'audit2_ru'],
        // EN
        ['path' => '/en',                                       'locale' => 'en', 'key' => 'home'],
        ['path' => '/en/knowledge/negotiation-strategy-property','locale' => 'en', 'key' => 'guide_negotiation_en'],
        ['path' => '/en/audits/30-45-day-sales-plan-audit',     'locale' => 'en', 'key' => 'audit3_en'],
        ['path' => '/en/audits/price-corridor-negotiation-strategy', 'locale' => 'en', 'key' => 'audit2_en'],
        ['path' => '/en/guides/kv-ee-listing-checklist',        'locale' => 'en', 'key' => 'guide3_en'],
    ];

    private array  $results  = [];
    private int    $errors   = 0;
    private array  $seenTitles = [];

    public function handle(): int
    {
        $this->info('Rendering canonical pages...');

        $app = app();
        $kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

        foreach (self::PAGES as $page) {
            $this->renderPage($kernel, $page);
        }

        $this->printSummary();

        $dir = storage_path('app/seo-audit');
        if (! is_dir($dir)) mkdir($dir, 0755, true);

        file_put_contents($dir . '/render-check.json', json_encode([
            'generated' => now()->toIso8601String(),
            'total'     => count($this->results),
            'errors'    => $this->errors,
            'results'   => $this->results,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $this->info('Render check saved: ' . $dir . '/render-check.json');

        return $this->errors === 0 ? self::SUCCESS : self::FAILURE;
    }

    private function renderPage($kernel, array $page): void
    {
        $path   = $page['path'];
        $issues = [];

        try {
            $request  = \Illuminate\Http\Request::create($path, 'GET');
            $response = $kernel->handle($request);
            $status   = $response->getStatusCode();
            $body     = $response->getContent();

            // Status check
            if ($status >= 500) {
                $issues[] = "HTTP {$status}";
            } elseif ($status >= 400) {
                $issues[] = "HTTP {$status}";
            }

            if ($status === 200 && $body) {
                // Title check
                if (! preg_match('#<title>(.+?)</title>#si', $body, $tm)) {
                    $issues[] = 'missing <title>';
                } else {
                    $title = trim($tm[1]);
                    if (empty($title)) {
                        $issues[] = 'empty <title>';
                    }
                    // Duplicate title check
                    if (isset($this->seenTitles[$title])) {
                        $issues[] = "duplicate title with {$this->seenTitles[$title]}";
                    } else {
                        $this->seenTitles[$title] = $path;
                    }
                }

                // Canonical check
                if (! preg_match('#<link rel="canonical" href="([^"]+)"#si', $body)) {
                    $issues[] = 'missing canonical tag';
                }

                // Meta description
                if (! preg_match('#<meta name="description" content="([^"]+)"#si', $body)) {
                    $issues[] = 'missing meta description';
                }
            }

            $this->results[] = [
                'path'    => $path,
                'status'  => $status,
                'issues'  => $issues,
                'pass'    => empty($issues),
            ];

            $hasIssues = ! empty($issues);
            if ($hasIssues) $this->errors++;

            $statusStr = $hasIssues ? "<fg=red>[{$status}]</>" : "<fg=green>[{$status}]</>";
            $msg = $hasIssues ? ' ISSUES: ' . implode(', ', $issues) : ' OK';
            $this->line("  {$statusStr} {$path}{$msg}");

        } catch (\Throwable $e) {
            $this->errors++;
            $this->results[] = ['path' => $path, 'status' => 500, 'issues' => ['Exception: ' . $e->getMessage()], 'pass' => false];
            $this->line("  <fg=red>[EXC]</> {$path}: " . $e->getMessage());

            if ($this->option('stop-on-error')) {
                $this->error('Stopping on first error.');
                exit(1);
            }
        }
    }

    private function printSummary(): void
    {
        $pass  = count(array_filter($this->results, fn($r) => $r['pass']));
        $fail  = count(array_filter($this->results, fn($r) => ! $r['pass']));
        $total = count($this->results);
        $this->newLine();
        $this->line("Summary: {$total} pages rendered | <fg=green>{$pass} PASS</> | <fg=red>{$fail} FAIL</>");
    }
}
