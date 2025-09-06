<?php

namespace App\Jobs;

use App\Models\Target;
use App\Models\TelegraphClient;
use App\Services\SubscriptionEndHandler;
use App\Services\TargetHttpStatusChecker;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SubscriptionsUpdateJob implements ShouldQueue
{
    use Queueable;

    public TelegraphClient $client;

    /**
     * Create a new job instance.
     */
    public function __construct(TelegraphClient $client)
    {
        $this->client = $client;
    }

    /**
     * Execute the job.
     */
    public function handle(SubscriptionEndHandler $handler)
    {
        $handler->handle();
    }
}