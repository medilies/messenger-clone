<?php

namespace App\Http\Controllers;

use App\Models\DirectMessage;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Http\Request;

class DirectMessageController extends Controller
{
    /**
     * new
     *
     * @group DirectMessageController
     *
     * @bodyParam content string required   Example: ikr
     * @bodyParam target_user_id int required   Example: 2
     *
     * @response status=200 scenario=success
     * {
     *     "id": 1119,
     *     "content": "ikr",
     *     "created_at": "2022-12-16T17:58:33.000000Z",
     *     "user_id": 1,
     *     "target_user_id": 2,
     *     "user": {
     *         "id": 1,
     *         "name": "medilies"
     *     }
     * }
     */
    public function new(Request $request): array
    {
        return (new MessageService($request))->store()->getMessageModel()->resource();
    }

    /**
     * list
     *
     * @group DirectMessageController
     *
     * @urlParam target_user_id int required  Example: 2
     *
     * @response status=200 scenario=success
     * [
     *     {
     *         "id": 1070,
     *         "created_at": "2022-12-10T11:47:39.000000Z",
     *         "updated_at": "2022-12-10T11:47:39.000000Z",
     *         "content": "hooray",
     *         "target_user_id": 2,
     *         "user_id": 1,
     *         "user": {
     *             "id": 1,
     *             "name": "medilies",
     *             "email": "y@y.y",
     *             "email_verified_at": "2022-12-07T21:47:00.000000Z",
     *             "created_at": "2022-12-07T21:47:00.000000Z",
     *             "updated_at": "2022-12-07T21:47:00.000000Z"
     *         }
     *     },
     *     {
     *         "id": 1071,
     *         "created_at": "2022-12-10T11:48:18.000000Z",
     *         "updated_at": "2022-12-10T11:48:18.000000Z",
     *         "content": "hip",
     *         "target_user_id": 1,
     *         "user_id": 2,
     *         "user": {
     *             "id": 2,
     *             "name": "dummy",
     *             "email": "e@e.e",
     *             "email_verified_at": "2022-12-07T21:47:00.000000Z",
     *             "created_at": "2022-12-07T21:47:00.000000Z",
     *             "updated_at": "2022-12-07T21:47:00.000000Z"
     *         }
     *     }
     * ]
     */
    public function list(User $target_user): array
    {
        // TODO: fix returned data according to resource
        return DirectMessage::with('user')->whereCorrespondent($target_user->id)->latest('id')->limit(50)
            ->get()
            ->reverse()->values()->toArray();
    }
}
