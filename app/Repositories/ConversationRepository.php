<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\User;

class ConversationRepository
{
    public function findDirectConversation(int|User $user_1, int|User $user_2): ?Conversation
    {
        return Conversation::join('conversation_user', 'conversations.id', '=', 'conversation_user.conversation_id')
            ->select(['conversations.*', 'conversation_user.conversation_id', 'conversation_user.user_id'])
            ->whereIn('user_id', [
                $user_1 instanceof User ? $user_1->id : $user_1,
                $user_2 instanceof User ? $user_2->id : $user_2,
            ])
            ->direct()
            ->first();
    }
}
