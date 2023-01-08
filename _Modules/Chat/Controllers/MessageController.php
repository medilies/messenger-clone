<?php

namespace _Modules\Chat\Controllers;

use _Modules\Chat\Models\Conversation;
use _Modules\Chat\Services\NewMessageService;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MessageController
{
    // use AuthorizesRequests;

    public function getConversationMessages(Conversation $conversation)
    {
        $conversation->load('users');
        // $this->authorize('view', $conversation);

        return $conversation->messages->load('user');
    }

    public function newConversationMessage(Request $request, Conversation $conversation, NewMessageService $message_service): array
    {
        $conversation->load('users');

        return $message_service->consume($request, $conversation);
    }
}
