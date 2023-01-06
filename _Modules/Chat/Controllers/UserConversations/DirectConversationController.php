<?php

namespace _Modules\Chat\Controllers\UserConversations;

use _Modules\Chat\Repositories\ConversationRepository;
use App\Models\User;

class DirectConversationController
{
    public function getConversation(
        ConversationRepository $conversation_repository,
        User $user
    ) {
        return $conversation_repository->findOrCreateDirectConversation(auth()->user(), $user);
    }
}
