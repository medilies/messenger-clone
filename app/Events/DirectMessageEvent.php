<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DirectMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // /** The name of the queue connection to use when broadcasting the event. */
    // public string $connection = 'redis';

    // /** The name of the queue on which to place the broadcasting job. */
    // public string $queue = 'default';

    // public $afterCommit = true;

    public function __construct(
        protected Collection $message
    ) {
        //
    }

    // /** The event's broadcast name. */
    // public function broadcastAs(): string
    // {
    //     return 'DirectMessageEvent';
    // }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("direct-messages.{$this->message->get('target_user_id')}");
    }

    /** Get the data to broadcast. */
    public function broadcastWith(): array
    {
        return $this->message->toArray();
    }

    /** Determine if this event should broadcast. */
    public function broadcastWhen(): bool
    {
        return true;
    }
}
