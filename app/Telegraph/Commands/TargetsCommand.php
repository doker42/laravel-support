<?php

namespace App\Telegraph\Commands;

use App\Models\TelegraphClient;
use App\Telegraph\Services\AddTargetService;
use App\Telegraph\Services\TargetsService;
use DefStudio\Telegraph\Models\TelegraphChat;

class TargetsCommand
{
    public static function handle(TelegraphChat $chat, TelegraphClient $client): void
    {
        app(TargetsService::class)->targets($chat, $client);
    }
}