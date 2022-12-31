<?php

namespace App\Http\Controllers\UserConversations;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Conversations\CreateConversationService;

class DirectConversationController extends Controller
{
    public function getConversation(CreateConversationService $createConversationService, User $user)
    {
        return $createConversationService->create(auth()->user(), $user);
    }
}
