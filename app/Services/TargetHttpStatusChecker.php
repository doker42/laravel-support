<?php

namespace App\Services;

use App\Models\Target;
use App\Models\TargetStatus;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TargetHttpStatusChecker
{
    public function check(Target $target)
    {
        if (config('telegramlog.test')) {
            Log::info('TEST Telegram : ');

            $this->sendToTelegram([
                'text' => 'TargetSite Test',
                'message' => 'TargetSite Test Message',
            ]);
        }

        $tlgChat = TelegraphChat::find($target->telegraph_chat_id);


        try {
            $response = Http::timeout(10)->get($target->url);
            $statusCode = $response->status();

        } catch (\Throwable $e) {
            $statusCode = 0; // ошибка соединения
            Log::info('Error : ' . $e->getMessage());
        }

        $lastStatus = TargetStatus::where('target_id', $target->id)->latest()->first();

        if ($statusCode === 200) {
            if ($lastStatus && $lastStatus->stop_date && !$lastStatus->start_date) {
                $lastStatus->update([
                    'start_date' => Carbon::now()
                ]);

                /** to Telegram chat messaging */
                $this->sendToTelegram([
                    'text' => 'TargetSite restored',
                    'message' => $target->url . ' again works!',
                ]);

                if ($tlgChat) $tlgChat->message($target->url . ' again works!')->send();
            }
        } else {
            if (!$lastStatus || $lastStatus->start_date) {
                TargetStatus::create([
                    'target_id' => $target->id,
                    'stop_date' => Carbon::now(),
                ]);

                $this->sendToTelegram([
                    'text' => 'TargetSite down',
                    'message' => $target->url . ' doesnt works!',
                ]);

                if ($tlgChat) $tlgChat->message($target->url . ' doesnt works!')->send();
            }
        }
    }


    public function sendToTelegram($message): void
    {
        $logger = new TelegramLogger($message, TelegramLogger::TYPE_INFO);
        $logger->handle();
    }


    public static function checkUrlComplex(string $url)
    {
        if (empty($url)) {
            return [
                'message' => "URL cant be empty. Try again",
                'status'  => false,
            ];
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return [
                'message' => "Invalid URL. Try again",
                'status'  => false,
            ];
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);
        if (!in_array($scheme, ['http', 'https'])) {
            return [
                'message' => "URL should begin from http:// или https://. Try again",
                'status'  => false,
            ];
        }

        try {
            $response = Http::timeout(5)->get($url); // можно настроить таймаут
            if ($response->status() === 200) {
                return [
                    'message' => "HTTP status " . $response->status(),
                    'status'  => true,
                ];
            } else {
                return [
                    'message' => "URL come back status " . $response->status(),
                    'status'  => false,
                ];
            }
        } catch (\Exception $e) {
            return [
                'message' => "Error URL: " . $e->getMessage(),
                'status'  => false,
            ];
        }
    }


    public static function checkUrlStatus(string $url)
    {
        try {
            $response = Http::timeout(5)->get($url); // можно настроить таймаут
            if ($response->status() === 200) {
                return  "HTTP status " . $response->status();
            } else {
                return "URL come back status " . $response->status();
            }
        } catch (\Exception $e) {
            return  "Error URL: " . $e->getMessage();
        }
    }

}