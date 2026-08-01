<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Prune old leads per retention policy (X999^5 §15). Dry-run by default; deletes
 * only with --execute, and never leads younger than the safety floor. Shows counts
 * before deletion and writes a non-PII audit line.
 */
class LeadsPruneCommand extends Command
{
    protected $signature = 'leads:prune {--execute : Actually delete (default is dry-run)}';
    protected $description = 'Delete leads older than the retention window (dry-run by default).';

    public function handle(): int
    {
        $retention = (int) config('attribution.lead_retention_days', 400);
        $floor     = (int) config('attribution.prune_min_age_days', 90);
        // Never delete newer than max(retention, floor).
        $cutoff = now()->subDays(max($retention, $floor));

        $query = Lead::where('created_at', '<', $cutoff);
        $count = $query->count();

        $this->line("Retention: {$retention} days · safety floor: {$floor} days");
        $this->line("Cutoff: leads created before {$cutoff->toDateString()}");
        $this->line("Eligible for deletion: <fg=yellow>{$count}</> lead(s)");

        if (! $this->option('execute')) {
            $this->info('DRY-RUN — nothing deleted. Re-run with --execute to delete.');
            return self::SUCCESS;
        }

        if ($count === 0) {
            $this->info('Nothing to delete.');
            return self::SUCCESS;
        }

        $deleted = $query->delete();
        Log::channel('single')->warning('leads:prune executed', [
            'deleted' => $deleted, 'cutoff' => $cutoff->toIso8601String(), 'retention_days' => $retention,
        ]);
        $this->info("Deleted {$deleted} lead(s) older than {$cutoff->toDateString()}.");
        return self::SUCCESS;
    }
}
