<?php

namespace App\Console\Commands;

use App\Helpers\LogHelper;
use App\Jobs\CheckTargetsJob;
use App\Models\Target;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SiteMonitorCommand extends Command
{
    protected $signature = 'monitor:start';

    protected $description = 'Dispatch job to check active sites';

    public function handle()
    {
        $now = now();

        $targets = Target::whereHas('clients', function ($query) {
            $query->where('target_client.active', 1);
        })
            ->where(function ($q) use ($now) {
                $q->whereNull('last_checked_at')
                    ->orWhereRaw('GREATEST(TIMESTAMPDIFF(SECOND, last_checked_at, ?), 0) >= `targets`.`interval`', [$now]);
            })
            ->get(['id', 'url'])
            ->toArray();

        if (!count($targets)) {
            return;
        }

        CheckTargetsJob::dispatch($targets)->onQueue('default');

        $message = "Check started " . count($targets) . " targets.";
        LogHelper::control('info', $message);
    }
}
