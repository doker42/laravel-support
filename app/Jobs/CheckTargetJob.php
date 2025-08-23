<?php

namespace App\Jobs;

use App\Models\Target;
use App\Services\TargetHttpStatusChecker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckTargetJob implements ShouldQueue
{
    use Queueable;

    public Target $target;

    /**
     * Create a new job instance.
     */
    public function __construct(Target $target)
    {
        $this->target = $target;
    }

    /**
     * Execute the job.
     */
    public function handle(TargetHttpStatusChecker $checker)
    {
        $checker->check($this->target);
    }
}
