<?php

namespace App\Traits;

use App\Services\TelegramLogger;

trait TelegramTrait
{
    public function sendToTelegram($message): void
    {
        $logger = new TelegramLogger($message, TelegramLogger::TYPE_INFO);
        $logger->handle();
    }
}
