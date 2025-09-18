<?php

namespace App\Events;

use App\Models\Target;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TargetStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $targetId;
    public int $status;


    /**
     * Create a new event instance.
     */
    public function __construct(int $targetId, int|null $status)
    {
        $this->targetId = $targetId;
        $this->status   = $status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
