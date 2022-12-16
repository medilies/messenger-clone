<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * index
     *
     * @group UserController
     *
     * @response status=200 scenario=success
     * [
     *     {
     *         "id": 1,
     *         "name": "medilies",
     *         "email": "y@y.y",
     *         "email_verified_at": "2022-12-07T21:47:00.000000Z",
     *         "created_at": "2022-12-07T21:47:00.000000Z",
     *         "updated_at": "2022-12-07T21:47:00.000000Z"
     *     },
     *     {
     *         "id": 2,
     *         "name": "dummy",
     *         "email": "e@e.e",
     *         "email_verified_at": "2022-12-07T21:47:00.000000Z",
     *         "created_at": "2022-12-07T21:47:00.000000Z",
     *         "updated_at": "2022-12-07T21:47:00.000000Z"
     *     }
     * ]
     */
    public function index(): array
    {
        return User::all()->toArray();
    }
}
