<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DirectMessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserConversationController;
use Illuminate\Support\Facades\Route;

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

    Route::post('/conversations/direct/{user}', [UserConversationController::class, 'createDirectConversation'])
        ->name('conversations.direct.create');

    Route::get('/conversations', [UserConversationController::class, 'list'])
        ->name('conversations.list');
});
