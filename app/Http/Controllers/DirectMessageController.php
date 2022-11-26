<?php

namespace App\Http\Controllers;

use App\Events\DirectMessageEvent;
use App\Http\Requests\DirectMessage\StoreDirectMessageRequest;
use App\Models\DirectMessage;

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
}
