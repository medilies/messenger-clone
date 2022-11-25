<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Http\Requests\DirectMessage\StoreDirectMessageRequest;
use App\Http\Requests\DirectMessage\UpdateDirectMessageRequest;
use App\Models\DirectMessage;

class DirectMessageController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectMessageRequest $request)
    {
        // TODO: fix target
        /** @var DirectMessage */
        $direct_message = DirectMessage::create($request->validated() + ['user_id' => auth()->id()] + ['target_user_id' => auth()->id()]);

        $direct_message->setRelation('user', auth()->user());

        broadcast(new NewMessage($direct_message->toArray()));

        return $direct_message;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function show(DirectMessage $directMessage)
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDirectMessageRequest $request, DirectMessage $directMessage)
    {
        //
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function destroy(DirectMessage $directMessage)
    {
        //
    }
}
