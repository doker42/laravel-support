<?php

namespace App\Listeners;

use App\Models\Target;
use App\Models\TargetStatus;
use App\Services\TelegramLogger;
use Carbon\Carbon;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class TargetStatusChangedListener  implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $targetId = $event->targetId;
        $status   = $event->status;
        $target   = Target::find($targetId);
        $controlMessage = [
            'text' => 'Control message',
            'message' => 'Default message',
        ];

        $lastStatus = TargetStatus::where('target_id', $targetId)->latest()->first();
        $tlgChat    = TelegraphChat::find($target->telegraph_chat_id);

        if ($status === Target::STATUS_OK) {

            if ($lastStatus && $lastStatus->stop_date && !$lastStatus->start_date) {
                $lastStatus->update([
                    'start_date' => Carbon::now()
                ]);

                $controlMessage = [
                    'text' => 'Resource available again',
                    'message' => $target->url . ' is working again!',
                ];

                if ($tlgChat) $tlgChat->message($target->url . ' available again!')->send();
            }
        }
        else {

            if (!$lastStatus || $lastStatus->start_date) {
                TargetStatus::create([
                    'target_id' => $targetId,
                    'stop_date' => Carbon::now(),
                ]);

                $controlMessage = [
                    'text' => 'Resource unavailable',
                    'message' => $target->url . ' isn’t working!',
                ];

                if ($tlgChat) $tlgChat->message($target->url . ' unavailable!')->send();
            }
        }

        if (config('admin.control_monitoring')) {
            $this->sendToTelegram($controlMessage);
        }
    }


    public function sendToTelegram($message): void
    {
        $logger = new TelegramLogger($message, TelegramLogger::TYPE_INFO);
        $logger->handle();
    }

}
