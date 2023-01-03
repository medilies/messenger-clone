<?php

namespace App\Repositories;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ConversationRepository
{
    public function findDirectConversation(int|User $user_1, int|User $user_2): ?Conversation
    {
        return Conversation::join('conversation_user', 'conversations.id', '=', 'conversation_user.conversation_id')
            ->select([
                'conversations.*',
                'conversation_user.conversation_id as conversation_id',
                'conversation_user.user_id as user_id',
            ])
            ->addSelect(DB::raw('COUNT(user_id) as count'))
            ->whereIn('user_id', [
                $user_1 instanceof User ? $user_1->id : $user_1,
                $user_2 instanceof User ? $user_2->id : $user_2,
            ])
            ->having('count', 2)
            ->direct()
            ->groupBy('conversation_id')
            ->first();
    }

    public function createDirectConversation(int|User $initiator_user, int|User $user): Conversation
    {
        /** @var Conversation */
        $conversation = Conversation::create(['type' => 'direct']);

        $conversation->users()->attach($initiator_user);

        $conversation->users()->attach($user);

        $conversation->setRelation('users', new Collection([$user, $initiator_user]));

        return $conversation;
    }

    public function findOrCreateDirectConversation(int|User $user_1, int|User $user_2): Conversation
    {
        $conversation = $this->findDirectConversation($user_1, $user_2);

        if ($conversation) {
            return $conversation->load('users');
        }

        return $this->createDirectConversation($user_1, $user_2);
    }
}
