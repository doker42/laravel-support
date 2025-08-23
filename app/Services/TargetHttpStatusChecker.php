<?php

namespace App\Services;

use App\Models\Target;
use App\Models\TargetStatus;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TargetHttpStatusChecker
{
    public function check(Target $target)
    {
        if (config('telegramlog.test') == 'test') {
            Log::info('TEST Telegram : ');

            $this->sendToTelegram([
                'text' => 'TargetSite Test',
                'message' => 'TargetSite Test Message',
            ]);
        }

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
            }
        }
    }


    public function sendToTelegram($message): void
    {
        $logger = new TelegramLogger($message, TelegramLogger::TYPE_INFO);
        $logger->handle();
    }
}