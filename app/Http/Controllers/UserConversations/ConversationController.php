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
            $current_user->conversations()->latest('id')
                ->get()
                ->load('otherUsers')
        );
    }

    public function getConversationMessages(Conversation $conversation)
    {
        return $conversation->messages;
    }

    public function newConversationMessage(Request $request, Conversation $conversation): array
    {
        return (new MessageService($request, $conversation))->store()->getMessageModel()->resource();
    }
}
