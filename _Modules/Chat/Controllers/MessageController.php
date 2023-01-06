<?php

namespace _Modules\Chat\Controllers;

use _Modules\Chat\Models\Conversation;
use _Modules\Chat\Services\MessageService;
use Illuminate\Http\Request;

class MessageController
{
    public function getConversationMessages(Conversation $conversation)
    {
        return $conversation->messages->load('user');
    }

    public function newConversationMessage(Request $request, Conversation $conversation, MessageService $message_service): array
    {
        $conversation->load('users');

        return $message_service->consume($request, $conversation);
    }
}
