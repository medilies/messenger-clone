<?php

namespace App\Services\Conversations;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CreateConversationService
{
    public function create(User $initiator_user, User $user): Conversation
    {
        /** @var Conversation */
        $conversation = Conversation::create(['type' => 'direct']);

        $conversation->users()->attach($initiator_user);

        $conversation->users()->attach($user);

        $conversation->setRelation('users', new Collection([$user, $initiator_user]));

        return $conversation;
    }
}
