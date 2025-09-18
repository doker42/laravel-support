<?php

namespace App\Jobs;

use App\Models\Target;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTargetStatusJob implements ShouldQueue
{
    use Queueable;

    public array $targets;

    /**
     * Create a new job instance.
     */
    public function __construct(array $targets)
    {
        $this->targets = $targets;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ids = array_column($this->targets, 'id');
        $oldStatuses = Target::whereIn('id', $ids)
            ->pluck('last_status', 'id')
            ->toArray();

        $responses = Http::pool(fn($pool) =>
            array_map(fn($target) =>
            $pool->as($target['id'])->timeout(5)->get($target['url']),
                $this->targets
            )
        );

        $retriesIds = [];
        $retries = [];

        foreach ($this->targets as $target) {
            $id = $target['id'];
            $url = $target['url'];

            $response = $responses[$id] ?? null;
            $oldStatus = $oldStatuses[$id] ?? null;

            if ($response instanceof \Illuminate\Http\Client\Response) {
                $newStatus = $response->status();
            } else {
                // это ошибка (RequestException или ConnectionException)
                $newStatus = -1;
                Log::channel('checked_status')->warning("Connection error for {$url}: " . ($response?->getMessage() ?? 'Unknown error'));
            }

            Log::channel('checked_status')->info("Checked {$url} -> {$newStatus} (was {$oldStatus})");

            if ($oldStatus !== $newStatus) {
//                $retries[] = ['id' => $id, 'url' => $url, 'oldStatus' => $oldStatus];
                $retriesIds[] = $id;
            }
        }

        // mass update last_checked_at for not changed
        $ids = $this->removeElems($ids, $retriesIds);
        Target::whereIn('id', $ids)
            ->update([
                'last_checked_at' => now(),
            ]);

        // Диспетчим повторные проверки
//        foreach ($retries as $retry) {
//            RetryCheckTargetStatusJob::dispatch(
//                $retry['id'],
//            )->delay(now()->addSeconds(15));
//        }
        foreach ($retriesIds as $retryId) {
            RetryCheckTargetStatusJob::dispatch($retryId)->delay(now()->addSeconds(15));
        }
    }


    private function removeElem(int $elemToRemove, array $array)
    {
        $array = array_filter($array, fn($el) => $el !== $elemToRemove);
        return array_values($array);
    }

    private function removeElems(array $array, array $elemsRemove)
    {
        $array = array_diff($array, $elemsRemove);
        return array_values($array);
    }
}
