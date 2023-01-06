<?php

namespace _Modules\Chat\Controllers;

use _Modules\Chat\Resources\UserConversationResource;
use App\Models\User;

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
}
