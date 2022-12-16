<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Http\Request;

class DirectMessageController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function new(Request $request)
    {
        return (new MessageService($request))->store()->getMessageModel()->resource();
    }

    public function list(User $target_user)
    {
        // TODO: fix returned data according to resource
        return DirectMessage::with('user')->whereCorrespondent($target_user->id)->latest('id')->limit(50)->get()->reverse()->values();
    }
}
