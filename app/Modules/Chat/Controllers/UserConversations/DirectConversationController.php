<?php

namespace App\Modules\Chat\Controllers\UserConversations;

use App\Models\User;
use App\Modules\Chat\Repositories\ConversationRepository;

class DirectConversationController
{
    public function getConversation(
        ConversationRepository $conversation_repository,
        User $user
    ) {
        return $conversation_repository->findOrCreateDirectConversation(auth()->user(), $user);
    }
}
