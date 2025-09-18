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
        $targets = Target::where('active', 1)->get(['id', 'url']);
        if ($targets->isEmpty()) {
            return;
        }
        $targetsArray = $targets->toArray();

        CheckSitesJob::dispatch($targetsArray)->onQueue('default');


        $message = "Check started " . count($targets) . " targets.";
        LogHelper::control('info', $message);
    }
}
