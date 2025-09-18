<?php

namespace App\Console\Commands;

use App\Jobs\CheckTargetStatusJob;
use App\Models\Target;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class HandleTargetStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'handle-target-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        Target::chunk(50, function ($chunk) use ($now) {
            $toCheck = $chunk->filter(function ($target) use ($now) {
                return is_null($target->last_checked_at) ||
                    $target->last_checked_at->addSeconds($target->check_interval) <= $now;
            })->toArray();

            $count = count($toCheck);

            if ($count) {
                CheckTargetStatusJob::dispatch($toCheck);
            }
        });
    }
}
