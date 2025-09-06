<?php

namespace App\Console\Commands;

use App\Models\Target;
use App\Models\TelegraphClient;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionsUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions-update';

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
        $today = Carbon::today();

        Target::whereIn('telegraph_client_id', function ($query) use ($today) {
            $query->select('id')
                ->from('telegraph_clients')
                ->whereDate('end_subscription', '<', $today);
        })->update(['active' => 0]);

//        $expiredClientIds = TelegraphClient::whereDate('end_subscription', '<', $today)
//            ->pluck('id');
//        Target::whereIn('telegraph_client_id', $expiredClientIds)
//            ->update(['active' => 0]);

        $this->info("Subscriptions updated.");
    }
}
