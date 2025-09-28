<?php

namespace App\Jobs;

use App\Helpers\LogHelper;
use App\Models\Target;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class CheckSitesJob implements ShouldQueue
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

        $client = new Client([
            'timeout' => 10,
            'allow_redirects' => true,
            'http_errors' => false, // не кидать исключения на 4xx/5xx
            'headers' => [
                'Referer'    => 'https://google.com',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ],
        ]);

        $retriesIds = [];

        $requests = function ($targets) use ($client) {
            foreach ($targets as $target) {
                yield $target['id'] => function () use ($client, $target) {
                    return $client->getAsync($target['url']);
                };
            }
        };

        $pool = new Pool($client, $requests($this->targets), [
            'concurrency' => 20, // сколько одновременно проверять
            'fulfilled' => function ($response, $id) use (&$oldStatuses, &$retriesIds) {
                $url = $this->getUrlById($id);
                $newStatus = $response->getStatusCode();
                $oldStatus = $oldStatuses[$id] ?? null;

                $message = "Checked {$url} -> {$newStatus} (was {$oldStatus})";
                LogHelper::control('info', $message);

                if ($oldStatus !== $newStatus) {
                    $retriesIds[] = $id;
                }
            },
            'rejected' => function ($reason, $id) use (&$oldStatuses, &$retriesIds) {
                $url = $this->getUrlById($id);
                $newStatus = -1;
                $oldStatus = $oldStatuses[$id] ?? null;

                $message = "Connection error for {$url}: " . $reason->getMessage();
                LogHelper::control('info', $message);

                if ($oldStatus !== $newStatus) {
                    $retriesIds[] = $id;
                }
            },
        ]);

        // ждём завершения всех запросов
        $pool->promise()->wait();

        // обновляем last_checked_at для тех, что не изменились
        $unchangedIds = array_diff($ids, $retriesIds);
        if (!empty($unchangedIds)) {
            Target::whereIn('id', $unchangedIds)
                ->update([
                    'last_checked_at' => now(),
                ]);
        }

        // диспатчим повторные проверки
        foreach ($retriesIds as $retryId) {
            RetrySingleCheckJob::dispatch($retryId)
                ->delay(now()->addSeconds(15))->onQueue('high');
        }
    }

    private function getUrlById($id): string
    {
        foreach ($this->targets as $target) {
            if ($target['id'] === $id) {
                return $target['url'];
            }
        }
        return 'unknown-url';
    }
}
