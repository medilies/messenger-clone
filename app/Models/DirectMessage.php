<?php

namespace App\Models;

use Exception;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Database\Eloquent\BroadcastableModelEventOccurred;
use Illuminate\Database\Eloquent\BroadcastsEvents;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DirectMessage extends Model
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

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }

    // --------------------------------------------
    // Scopes
    // --------------------------------------------

    public function scopeWhereCorrespondent(Builder $query, int $target_user_id): void
    {
        $query->where(function ($q) use ($target_user_id) {
            $q->where('user_id', auth()->id())->where('target_user_id', $target_user_id);
        })
            ->orWhere(function ($q) use ($target_user_id) {
                $q->where('user_id', $target_user_id)->where('target_user_id', auth()->id());
            });
    }

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
            'target_user_id' => $this->target_user_id,
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
