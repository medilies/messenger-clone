<?php

namespace App\Modules\Chat\Controllers\UserConversations;

use App\Models\User;
use App\Modules\Chat\Models\Conversation;
use App\Modules\Chat\Resources\UserConversationResource;
use App\Modules\Chat\Services\MessageService;
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
