<?php

namespace App\Http\Controllers\UserConversations;

use App\Http\Controllers\Controller;
use App\Models\User;

class ConversationController extends Controller
{
    public function list(): array
    {
        /** @var User */
        $current_user = auth()->user();

        // TODO: optimize query and returned JSON
        return $current_user->conversations()->latest('id')->get()->load('users')->toArray();
    }
}
