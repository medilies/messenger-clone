<?php

namespace _Modules\Chat\Repositories;

use _Modules\Chat\Models\Conversation;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class ConversationRepository
{
    public function findDirectConversation(int|User $user_1, int|User $user_2): ?Conversation
    {
        $conversation = Conversation::directConversationBetween($user_1, $user_2)->get();

        if ($conversation->count() > 1) {
            throw new Exception('BROKEN SYSTEM: many direct conversations between two users found');
        }

        return $conversation->first();
    }

    public function createDirectConversation(int|User $initiator_user, int|User $user): Conversation
    {
        /** @var Conversation */
        $conversation = Conversation::create(['type' => 'direct']);

        $conversation->users()->attach($initiator_user);

        $conversation->users()->attach($user);

        $conversation->setRelation('users', new EloquentCollection([$user, $initiator_user]));

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
