<?php

namespace Database\Seeders;

use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bot = TelegraphBot::first();

        if (!$bot) {
            TelegraphBot::create([
                'name'  => env('LASER_BOT_NAME'),
                'token' => env('LASER_BOT_TOKEN'),
            ]);
        }
    }
}
