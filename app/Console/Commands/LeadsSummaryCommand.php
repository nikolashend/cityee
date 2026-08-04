<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Illuminate\Console\Command;

/**
 * Read-only revenue snapshot (X999^5 §13). CLI-only — no web route, no PII.
 * Aggregates leads by source/campaign/landing/form + mail/duplicate/test/unknown rates.
 *
 * Usage: php artisan leads:summary [--from=] [--to=] [--exclude-test] [--json]
 */
class LeadsSummaryCommand extends Command
{
    protected $signature = 'leads:summary
        {--from= : ISO date lower bound (default 30 days ago)}
        {--to= : ISO date upper bound (default now)}
        {--exclude-test : exclude is_test leads from counts}
        {--json : output JSON instead of tables}';

    protected $description = 'Read-only lead attribution summary (no PII).';

    public function handle(): int
    {
        $from = $this->option('from') ? \Carbon\Carbon::parse($this->option('from')) : now()->subDays(30);
        $to   = $this->option('to') ? \Carbon\Carbon::parse($this->option('to')) : now();

        $q = Lead::whereBetween('created_at', [$from, $to]);
        if ($this->option('exclude-test')) $q->where('is_test', false);
        $leads = $q->get();

        $total = $leads->count();
        $byCount = fn ($col) => $leads->groupBy($col)->map->count()->sortDesc();

        $data = [
            'range'                => ['from' => $from->toDateString(), 'to' => $to->toDateString()],
            'total_leads'          => $total,
            'test_leads'           => $leads->where('is_test', true)->count(),
            'by_source_class'      => $this->countBy($leads, fn ($l) => $l->last_touch_source ?: $l->first_touch_source ?: 'unknown'),
            'by_first_touch'       => $this->countBy($leads, fn ($l) => $l->first_touch_source ?: 'unknown'),
            'by_form_type'         => $byCount('form_type')->toArray(),
            'by_campaign'          => $this->countBy($leads, fn ($l) => $l->last_touch_campaign ?: $l->first_touch_campaign ?: '(none)'),
            'by_landing_page'      => $this->countBy($leads, fn ($l) => ($l->first_touch_json['landing_page'] ?? $l->landing_page) ?: '(unknown)'),
            'by_submission_page'   => $this->countBy($leads, fn ($l) => $l->submission_page ?: '(unknown)'),
            'mail_success_rate'    => $this->rate($leads, fn ($l) => $l->mail_status === 'sent'),
            'duplicate_note'       => 'duplicates collapse pre-insert; not counted as separate leads',
            'unknown_attr_rate'    => $this->rate($leads, fn ($l) => in_array($l->last_touch_source ?: $l->first_touch_source, [null, '', 'unknown', 'direct'], true)),
        ];

        if ($this->option('json')) {
            $this->line(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            return self::SUCCESS;
        }

        $this->line("<options=bold>Leads {$data['range']['from']} → {$data['range']['to']}</> · total: <fg=green>{$total}</> · test: {$data['test_leads']}");
        if ($total === 0) { $this->info('No leads in range.'); return self::SUCCESS; }
        $this->section('By source class', $data['by_source_class']);
        $this->section('By form type', $data['by_form_type']);
        $this->section('By campaign', $data['by_campaign']);
        $this->line("Mail success rate: <fg=green>{$data['mail_success_rate']}%</> · Unknown/direct attribution: {$data['unknown_attr_rate']}%");
        return self::SUCCESS;
    }

    private function countBy($leads, callable $key): array
    {
        return $leads->groupBy($key)->map->count()->sortDesc()->toArray();
    }

    private function rate($leads, callable $pred): float
    {
        $n = $leads->count();
        return $n === 0 ? 0.0 : round($leads->filter($pred)->count() / $n * 100, 1);
    }

    private function section(string $title, array $rows): void
    {
        $this->newLine();
        $this->line("<options=bold>{$title}</>");
        foreach ($rows as $k => $v) {
            $this->line('  ' . str_pad((string) ($k === '' ? '(none)' : $k), 40) . $v);
        }
    }
}
