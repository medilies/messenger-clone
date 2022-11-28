<?php

namespace App\Http\Controllers;

use App\Events\DirectMessageEvent;
use App\Http\Requests\DirectMessage\StoreDirectMessageRequest;
use App\Models\DirectMessage;
use App\Models\User;

class DirectMessageController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function new(StoreDirectMessageRequest $request)
    {
        /** @var DirectMessage */
        $direct_message = DirectMessage::create($request->validated() + ['user_id' => auth()->id()]);

        $direct_message->setRelation('user', auth()->user());

        // TODO: dispatch and broadcast less user data
        DirectMessageEvent::broadcast($direct_message)->toOthers();

        return $direct_message;
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
