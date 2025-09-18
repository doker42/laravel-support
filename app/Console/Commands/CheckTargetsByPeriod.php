<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Target;
use App\Jobs\CheckTargetJob;

class CheckTargetsByPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'targets:check {period}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check targets by given period (60, 300, 1800, 3600 minutes)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $interval = (int) $this->argument('period');

        $targets = Target::where('interval', $interval)->active()->get();

        if (count($targets)) {
            foreach ($targets as $target) {
                CheckTargetJob::dispatch($target);
            }
        }

        $this->info("Dispatched check jobs for period = {$interval} min ({$targets->count()} targets).");
    }
}
