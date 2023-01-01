<?php

namespace App\Models;

use Exception;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use BroadcastsEvents, HasFactory;

    protected $guarded = ['id'];

    // --------------------------------------------
    // Relations
    // --------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    // --------------------------------------------
    // Scopes
    // --------------------------------------------

    // --------------------------------------------
    // Methods
    // --------------------------------------------

    /**
     * @throws Exception
     */
    public function resource(): array
    {
        if (! $this->relationLoaded('user')) {
            throw new Exception('Load user relation before calling this');
        }

        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ],
        ];
    }

    // --------------------------------------------
    // Broadcasting
    // --------------------------------------------

    public function broadcastOn($event)
    {
        return match ($event) {
            'created' => [new PrivateChannel("direct-messages.{$this->target_user_id}")],
            default => [],
        };
    }

    public function broadcastAs($event)
    {
        return match ($event) {
            'created' => 'DirectMessage',
            default => null,
        };
    }

    public function broadcastWith($event)
    {
        $this->load('user');

        return match ($event) {
            default => $this->resource(),
        };
    }

    protected function newBroadcastableEvent($event)
    {
        return (new BroadcastableModelEventOccurred(
            $this,
            $event
        ))->dontBroadcastToCurrentUser();
    }
}
