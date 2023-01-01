<?php

namespace App\Http\Controllers\UserConversations;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserConversationResource;
use App\Models\User;

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
}
