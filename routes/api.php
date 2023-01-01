<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserConversations\ConversationController;
use App\Http\Controllers\UserConversations\DirectConversationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/sanctum/token', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);

    Route::get('/conversations/direct/{user}', [DirectConversationController::class, 'getConversation'])
        ->name('conversations.direct.get');

    Route::get('/conversations', [ConversationController::class, 'list'])
        ->name('conversations.list');

    Route::post('/conversations/{conversation}/messages', [ConversationController::class, 'newConversationMessage'])
        ->name('conversations.messages.new');

    Route::get('/conversations/{conversation}/messages', [ConversationController::class, 'getConversationMessages'])
        ->name('conversations.messages.get');
});
