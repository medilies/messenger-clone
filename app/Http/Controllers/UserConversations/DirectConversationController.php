<?php

namespace App\Http\Controllers\UserConversations;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ConversationRepository;
use App\Services\Conversations\CreateConversationService;

class DirectConversationController extends Controller
{
    public function getConversation(
        ConversationRepository $conversation_repository,
        CreateConversationService $create_conversation_service,
        User $user
    ) {
        $conversation = $conversation_repository->findDirectConversation(auth()->user(), $user);

        if ($conversation) {
            return $conversation->load('users');
        }

        return $create_conversation_service->create(auth()->user(), $user);
    }
}
