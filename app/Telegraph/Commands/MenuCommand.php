<?php

namespace App\Telegraph\Commands;

use App\Telegraph\Services\MenuService;
use DefStudio\Telegraph\Models\TelegraphChat;

class MenuCommand
{
    public function __invoke(TelegraphChat $chat): void
    {
        app(MenuService::class)->startMenu($chat);
    }
}