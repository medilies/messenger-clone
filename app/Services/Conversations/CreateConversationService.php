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
        $conversation = Conversation::create([
            'type' => 'direct',
            'name' => $this->formatDirectConversationName($initiator_user, $user),
        ]);

        $conversation->users()->attach($initiator_user);

        $conversation->users()->attach($user);

        $conversation->setRelation('users', new Collection([$user, $initiator_user]));

        return $conversation;
    }

    public function formatDirectConversationName(int|User $user_1, int|User $user_2)
    {
        return 'D:'.implode(
            ',',
            $this->getSorted([
                $user_1 instanceof User ? $user_1->id : $user_1,
                $user_2 instanceof User ? $user_2->id : $user_2,
            ])
        );
    }

    public function getSorted(array $arr): array
    {
        sort($arr, SORT_NUMERIC);

        return $arr;
    }
}
