<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/sanctum/token', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);

    Route::post('/messages', [DirectMessageController::class, 'new']);
    Route::get('/messages/{target_user}', [DirectMessageController::class, 'list']);
});
