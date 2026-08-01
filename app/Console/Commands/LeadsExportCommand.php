<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Read-only lead export (X999^5 §6). CLI-only — never a web route.
 * Defaults: no raw PII (masked), private storage path, last 30 days, ≤10 000 rows,
 * UTF-8 CSV with formula-injection escaping. Raw PII only with --include-pii.
 */
class LeadsExportCommand extends Command
{
    protected $signature = 'leads:export
        {--from= : ISO date/time lower bound (default: 30 days ago)}
        {--to= : ISO date/time upper bound (default: now)}
        {--form-type= : callback|inquiry|audit|price_calculator}
        {--source= : filter by last_touch_source}
        {--mail-status= : sent|failed|pending}
        {--limit=10000 : max rows}
        {--output= : filename under storage/app/private/exports}
        {--include-pii : include raw name/phone/email (audited, private only)}';

    protected $description = 'Export leads to a private CSV (masked by default; read-only).';

    public function handle(): int
    {
        $from = $this->option('from') ? \Carbon\Carbon::parse($this->option('from')) : now()->subDays(30);
        $to   = $this->option('to') ? \Carbon\Carbon::parse($this->option('to')) : now();
        $limit = min((int) $this->option('limit') ?: 10000, 50000);
        $pii = (bool) $this->option('include-pii');

        $q = Lead::query()->whereBetween('created_at', [$from, $to]);
        if ($f = $this->option('form-type'))  $q->where('form_type', $f);
        if ($s = $this->option('source'))     $q->where('last_touch_source', $s);
        if ($m = $this->option('mail-status')) $q->where('mail_status', $m);
        $rows = $q->orderBy('created_at')->limit($limit)->get();

        $headers = $this->headers($pii);
        $csv = implode(',', $headers) . "\r\n";
        foreach ($rows as $lead) {
            $csv .= implode(',', array_map([$this, 'cell'], $this->row($lead, $pii))) . "\r\n";
        }

        $dir = 'private/exports';
        Storage::makeDirectory($dir);
        $name = $this->option('output') ?: 'leads-' . now()->format('Ymd-His') . '.csv';
        $name = basename($name);                           // no path traversal
        $path = $dir . '/' . $name;
        Storage::put($path, "\xEF\xBB\xBF" . $csv);         // UTF-8 BOM

        if ($pii) {
            $this->warn('PII EXPORT: raw name/phone/email included. Handle per retention policy.');
            Log::channel('single')->warning('leads:export --include-pii', [
                'rows' => $rows->count(), 'from' => $from->toIso8601String(), 'to' => $to->toIso8601String(),
                'file' => $name,               // filename only — no PII in log
            ]);
        }
        $this->info("Exported {$rows->count()} lead(s) → storage/app/{$path}" . ($pii ? ' (with PII)' : ' (masked)'));
        return self::SUCCESS;
    }

    private function headers(bool $pii): array
    {
        $base = ['public_id', 'created_at', 'form_type', 'first_touch_source', 'first_touch_medium',
            'first_touch_campaign', 'first_landing_page', 'last_touch_source', 'last_touch_medium',
            'last_touch_campaign', 'submission_page', 'has_gclid', 'has_gbraid', 'has_wbraid',
            'mail_status', 'analytics_status', 'is_test'];
        return $pii ? array_merge($base, ['name', 'phone', 'email']) : array_merge($base, ['masked_email', 'masked_phone']);
    }

    private function row(Lead $lead, bool $pii): array
    {
        $first = $lead->first_touch_json ?? [];
        $base = [
            $lead->public_id, (string) $lead->created_at, $lead->form_type,
            $lead->first_touch_source, $lead->first_touch_medium, $lead->first_touch_campaign,
            $first['landing_page'] ?? $lead->landing_page,
            $lead->last_touch_source, $lead->last_touch_medium, $lead->last_touch_campaign,
            $lead->submission_page,
            $lead->first_touch_gclid || $lead->last_touch_gclid ? '1' : '0',
            !empty(($lead->last_touch_json ?? [])['gbraid']) ? '1' : '0',
            !empty(($lead->last_touch_json ?? [])['wbraid']) ? '1' : '0',
            $lead->mail_status, $lead->analytics_status, $lead->is_test ? '1' : '0',
        ];
        return $pii
            ? array_merge($base, [$lead->name, $lead->phone, $lead->email])
            : array_merge($base, [$this->mask($lead->email, 'email'), $this->mask($lead->phone, 'phone')]);
    }

    private function mask(?string $v, string $kind): string
    {
        if (! $v) return '';
        if ($kind === 'email') {
            $parts = explode('@', $v, 2);
            return mb_substr($parts[0], 0, 1) . '***' . (isset($parts[1]) ? '@' . $parts[1] : '');
        }
        $digits = preg_replace('/\D/', '', $v);
        return '***' . mb_substr($digits, -3);
    }

    /** Escape a CSV cell; neutralize spreadsheet formula injection (= + - @). */
    private function cell($v): string
    {
        $v = (string) $v;
        if ($v !== '' && in_array($v[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            $v = "'" . $v;
        }
        return '"' . str_replace('"', '""', $v) . '"';
    }
}
