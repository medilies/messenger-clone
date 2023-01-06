<?php

namespace _Modules\Chat\Models;

use _Modules\Chat\Factories\ConversationFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return ConversationFactory::new();
    }

    // --------------------------------------------
    // Relations
    // --------------------------------------------

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function otherUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->whereNot('user_id', auth()->id())->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // --------------------------------------------
    // Scopes
    // --------------------------------------------

    public function scopeDirect(Builder|EloquentBuilder $query): void
    {
        $query->where('type', 'direct');
    }

    public function scopeDirectConversationBetween(Builder|EloquentBuilder $query, int|User $user_1, int|User $user_2): void
    {
        $query->join('conversation_user', 'conversations.id', '=', 'conversation_user.conversation_id')
            ->select([
                'conversations.*',
                'conversation_user.conversation_id as conversation_id',
                'conversation_user.user_id as user_id',
            ])
            ->addSelect(DB::raw('COUNT(user_id) as _count_participants'))
            ->whereIn('user_id', [
                $user_1 instanceof User ? $user_1->id : $user_1,
                $user_2 instanceof User ? $user_2->id : $user_2,
            ])
            ->having('_count_participants', 2)
            ->direct()
            ->groupBy('conversation_id');
    }
}
