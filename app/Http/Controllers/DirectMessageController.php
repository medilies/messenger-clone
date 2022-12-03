<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use App\Models\User;
use App\Packages\MessageEntity;
use Illuminate\Http\Request;

class DirectMessageController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function new(Request $request)
    {
        return (new MessageEntity($request))->store()->broadcast()->resource();
    }

    public function list(User $target_user)
    {
        $messages = DirectMessage::where(function ($q) use ($target_user) {
            $q->where('user_id', auth()->id())->where('target_user_id', $target_user->id);
        })
            ->orWhere(function ($q) use ($target_user) {
                $q->where('user_id', $target_user->id)->where('target_user_id', auth()->id());
            })
            ->latest()->limit(50)->get();

        return $messages;
    }
}
