<?php

namespace Database\Seeders;

use App\Models\TelegraphClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultTelegraphClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultClient = TelegraphClient::where('name', 'Admin')->first();

        if (!$defaultClient) {
            TelegraphClient::create([
                'chat_id'  => 9999999999999,
                'await'    => 0,
                'name'     => 'Admin',
                'end_subscription' => '2200-12-31',
            ]);
        }
    }
}
