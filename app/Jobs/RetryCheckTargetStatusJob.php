<?php

namespace App\Jobs;

use App\Events\TargetStatusChanged;
use App\Models\Target;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RetryCheckTargetStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $targetId;

    public function __construct(int $targetId)
    {
        $this->targetId = $targetId;
    }


    public function handle(): void
    {
        $target = Target::find($this->targetId);
        if (! $target) {
            return; // уже удалён
        }

        try {

            $response = Http::retry(3, 200)   // до 3 попыток, пауза 200мс
            ->timeout(10)     // ждем до 10 сек
            ->get($target->url);

//            $response = Http::timeout(5)->get($target->url);
            $status = $response->status();
        } catch (\Throwable $e) {
            $status = 0;
            Log::info('Get HTTP Error : ' . $e->getMessage());
        }


        // сетевые ошибки (timeout, DNS, SSL) → Laravel возвращает 0
        if ($status === 0) {
            $status = -1;
        }

        Log::channel('checked_status')->info("Retry check for {$target->url}: {$status}");

        $oldStatus = $target->last_status;

        // если статус реально изменился (и отличается от того, что мы ждали)
        if ($status !== $oldStatus) {
            $target->update([
                'last_status'     => $status,
                'last_checked_at' => now(),
            ]);

            event(new TargetStatusChanged($target->id, $status));
        }
    }
}
