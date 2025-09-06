<?php

namespace App\Services;

use DefStudio\Telegraph\Models\TelegraphChat;

class TelegramNotifier
{
    /**
     * Отправить сообщение в конкретный чат
     */
    public static function sendToChat(int $chatId, string $message, bool $html = false): void
    {
        $chat = TelegraphChat::find($chatId);

        if (!$chat) {
            return; // или логируем, если чат не найден
        }

        if ($html) {
            $chat->html($message)->send();
        } else {
            $chat->message($message)->send();
        }
    }

    /**
     * Отправить сообщение с помощью TelegramLogger (если он у тебя используется)
     */
    public static function log(array $message): void
    {
        $logger = new TelegramLogger($message, TelegramLogger::TYPE_INFO);
        $logger->handle();
    }
}