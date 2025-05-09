<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    public static function handle(array $data)
    {
        $message = "📬 New Contact Request:\n\n"
            . "👤 Name: {$data['name']}\n"
            . "✉️ Email: {$data['email']}\n"
            . "📝 Message:\n{$data['message']}\n";

        $token = env('TELEGRAM_BOT_TOKEN');
        $chat_id = env('TELEGRAM_CHAT_ID');

        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chat_id,
            'text'    => $message,
        ]);
    }
}
