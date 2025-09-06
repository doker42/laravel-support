<?php

namespace App\Services;

use App\Models\Target;
use App\Models\TelegraphClient;
use Carbon\Carbon;

class SubscriptionEndHandler
{
    public function handle()
    {
        $telegraphClients = TelegraphClient::all();

        if (!count($telegraphClients)) {
            foreach ($telegraphClients as $client) {

                $today = Carbon::today();
                $endSubscription = $client->end_subscription;

                if ($today > $endSubscription) {
                    Target::where('telegraph_client_id', $client->id)
                        ->update([
                            'active' => 0
                        ]);
                }
            }
        }
    }
}