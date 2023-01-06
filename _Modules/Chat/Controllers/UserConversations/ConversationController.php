<?php

namespace _Modules\Chat\Controllers\UserConversations;

use _Modules\Chat\Models\Conversation;
use _Modules\Chat\Resources\UserConversationResource;
use _Modules\Chat\Services\MessageService;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationController
{
    public function list()
    {
        /** @var User */
        $current_user = auth()->user();

        return UserConversationResource::collection(
            $current_user->conversations()->latest('updated_at')
                ->get()
                ->load('otherUsers')
        );
    }

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
