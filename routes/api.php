<?php

use App\Events\NewMessage;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/sanctum/token', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/messages', function (Request $request) {
        broadcast(new NewMessage($request->message));

        return response($request->all());
    });
});
