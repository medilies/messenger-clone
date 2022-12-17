<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserConversationController extends Controller
{
    public function createDirectConversation(User $user)
    {
        /** @var Conversation */
        $conversation = Conversation::create(['type' => 'direct']);

        $conversation->users()->attach($user);

        $conversation->users()->attach(auth()->user());

        $conversation->setRelation('users', new Collection([$user, auth()->user()]));

        return $conversation;
    }
}
