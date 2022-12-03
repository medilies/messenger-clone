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
        return DirectMessage::whereCorrespondent($target_user->id)->latest()->limit(50)->get()->reverse()->values();
    }
}
