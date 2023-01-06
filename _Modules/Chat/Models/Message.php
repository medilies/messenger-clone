<?php

namespace _Modules\Chat\Models;

use _Modules\Chat\Factories\MessageFactory;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return MessageFactory::new();
    }

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
        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at,
            'conversation_id' => $this->conversation_id,
        ];
    }
}
