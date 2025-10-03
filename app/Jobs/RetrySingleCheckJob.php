<?php

namespace App\Jobs;

//use Illuminate\Foundation\Queue\Queueable;

use App\Helpers\LogHelper;
use App\Models\Target; // твоя модель с урлами
use App\Services\TargetHttpStatusChecker;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class RetrySingleCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $id;

    /**
     * @param int $id ID сайта для повторной проверки
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }


    public function handle(): void
    {
        $target = Target::find($this->id);

        if (!$target) {
            Log::channel('target_error')
                ->warning("RetrySingleCheckJob: target #{$this->id} not found");
            return;
        }

        $errorInfo = null;

        // до 2 попыток проверки (в т.ч. если статус != 200)
        for ($i = 1; $i <= 2; $i++) {
            try {
                $response = Http::timeout(5)
                    ->withHeaders(TargetHttpStatusChecker::CHECK_HEADERS)
                    ->get($target->url);

                // Сервер ответил — получаем HTTP-код
                $status = $response->status();

                if ($status === 200) {
                    break;
                }

                // если не 200 → ждём немного и пробуем снова
                usleep(200_000);

            } catch (ConnectionException $e) {
                // Network errors (DNS, timeout, SSL)
                $status = -1;
                $errorInfo = $e->getMessage();
                $message = "RetrySingleCheckJob: {$target->url} attempt {$i} network error: {$e->getMessage()}";
                Log::channel(LogHelper::CHANNEL_TARGET_ERROR)->info($message);

                usleep(200_000);

            } catch (\Throwable $e) {
                // any errors
                $status = -2;
                $errorInfo = $e->getMessage();
                $message = "RetrySingleCheckJob: {$target->url} attempt {$i} unexpected error: {$e->getMessage()}";
                Log::channel(LogHelper::CHANNEL_TARGET_ERROR)->info($message);

                break;
            }
        }

        $oldStatus = $target->last_status;

        if ($status !== $oldStatus) {

            TargetStatusChangedHandleJob::dispatch($target->id, $status, $errorInfo)
                ->onQueue('low');

            $message = "Retry check for {$target->url}: status changed, now {$status} (was {$oldStatus})";
            Log::channel(LogHelper::CHANNEL_RETRY_CHECK)->info($message);
        }

        $target->update([
            'previous_status' => $oldStatus,
            'last_status'     => $status,
            'last_checked_at' => now(),
        ]);
    }
}
