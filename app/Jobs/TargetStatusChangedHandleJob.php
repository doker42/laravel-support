<?php

namespace App\Jobs;

use App\Models\Setting;
use App\Models\Target;
use App\Models\TargetStatus;
use App\Services\TelegramLogger;
use App\Telegraph\ClientMessages;
use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TargetStatusChangedHandleJob implements ShouldQueue
{
    use Queueable;

    public int $targetId;

    public int $status;
    public string|null $errorInfo;

    /**
     * Create a new job instance.
     */
    public function __construct(int $targetId, int $status, string|null $errorInfo = null)
    {
        $this->targetId = $targetId;
        $this->status   = $status;
        $this->errorInfo = $errorInfo;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $targetId = $this->targetId;
        $status   = $this->status;
        $errorInfo = $this->errorInfo;
        $target   = Target::find($targetId);

        $lastStatus = TargetStatus::where('target_id', $targetId)->latest()->first();

        if ($status === Target::STATUS_OK) {

            if ($lastStatus && $lastStatus->stop_date && !$lastStatus->start_date) {
                $lastStatus->update([
                    'start_date' => Carbon::now()
                ]);

                $controlMessage = ClientMessages::controlTargetDown($target);
                $clientMessage = ClientMessages::targetRestore($target, $status);
            }
        }
        else {

            if (!$lastStatus || $lastStatus->start_date) {
                TargetStatus::create([
                    'target_id' => $targetId,
                    'stop_date' => Carbon::now(),
                    'status'    => $status,
                ]);

                $controlMessage = ClientMessages::controlTargetRestore($target);
                $clientMessage = ClientMessages::targetDown($target, $status, $errorInfo);
            }
        }

        if (isset($clientMessage)) {
            $this->informClients($target, $clientMessage);
        }

        if (config('admin.control_log_enabled') && !empty($controlMessage)) {
            $this->sendToTelegram($controlMessage);
        }
    }


    private function informClients(Target $target, $clientMessage): void
    {
        $clients = $target->clients()->wherePivot('active', 1)->get();

        if (!count($clients)) {
            return;
        }

        foreach ($clients as $client) {
            $tlgChat = TelegraphChat::where('chat_id', $client->chat_id)->first();
            if ($tlgChat) {
                $tlgChat->html($clientMessage)->send();
            }
        }
    }

    public function sendToTelegram($message): void
    {
        if (!Setting::CLIENT_INFORM_ENABLED) {
            return;
        }
        $logger = new TelegramLogger($message, TelegramLogger::TYPE_INFO);
        $logger->handle();
    }
}
