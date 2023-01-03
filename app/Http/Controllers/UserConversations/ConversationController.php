<?php

namespace App\Http\Controllers\UserConversations;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserConversationResource;
use App\Models\Conversation;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Http\Request;

class ConversationController extends Controller
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
