<?php

namespace App\Http\Controllers\UserConversations;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\User;
use App\Services\Conversations\CreateConversationService;

class DirectConversationController extends Controller
{
    public function getConversation(CreateConversationService $create_conversation_service, User $user)
    {
        $conversation_name = $create_conversation_service->formatDirectConversationName(auth()->user(), $user);

        /** @var Conversation */
        $conversation = Conversation::where('name', $conversation_name)->first();

        if ($conversation) {
            return $conversation->load('users');
        }

        return $create_conversation_service->create(auth()->user(), $user);
    }
}
