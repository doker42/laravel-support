<?php

namespace App\Telegraph;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

trait BotTrait
{
    public function t(string $key): string
    {
//        $locale = $this->chat->locale ?? config('app.locale'); // берем локаль чата или дефолт
        $locale = App::getLocale() ?? config('app.locale'); // берем локаль чата или дефолт

//        Log::info('locale '. $locale);

        return trans("messages.$key", [], $locale);
    }

//    public function getClient($chat_id)
//    {
//
//    }
}