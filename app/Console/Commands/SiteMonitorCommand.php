<?php

namespace App\Console\Commands;

use App\Helpers\LogHelper;
use App\Jobs\CheckSitesJob;
use App\Models\Target;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SiteMonitorCommand extends Command
{
    protected $signature = 'monitor:start';
    protected $description = 'Dispatch job to check active sites';

    public function handle()
    {
        $targets = Target::whereHas('clients', function ($query) {
            $query->where('target_client.active', 1);
        })->get(['id', 'url'])->toArray();

        if (!count($targets)) {
            return;
        }

        CheckSitesJob::dispatch($targets)->onQueue('default');

        $message = "Check started " . count($targets) . " targets.";
        LogHelper::control('info', $message);
    }
}
