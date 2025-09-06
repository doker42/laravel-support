<?php

namespace Database\Seeders;

use App\Models\TelegraphClient;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultTelegraphChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultChat = TelegraphChat::where('name', 'Admin')->first();

        if (!$defaultChat) {
            TelegraphChat::create([
                'chat_id'  => 9999999999999,
                'name'     => 'Admin',
                'locale'   => 'en',
                'telegraph_bot_id' => 1,
            ]);
        }
    }
}
