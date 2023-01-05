<?php

namespace App\Http\Controllers\UserConversations;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ConversationRepository;

class DirectConversationController extends Controller
{
    public function getConversation(
        ConversationRepository $conversation_repository,
        User $user
    ) {
        return $conversation_repository->findOrCreateDirectConversation(auth()->user(), $user);
    }
}
