<?php

namespace _Modules\Chat\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public array $message
    ) {
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return array_map(
            fn ($user) => new PrivateChannel("chat.{$user['id']}"),
            $this->message['conversation']['other_users']
        );
    }

    public function broadcastWith(): array
    {
        return $this->message;
    }

    public function broadcastAs(): string
    {
        return 'NewMessageEvent';
    }
}
