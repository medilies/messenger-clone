<?php

use _Modules\Chat\Controllers\ConversationController;
use _Modules\Chat\Controllers\DirectConversationController;
use _Modules\Chat\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->prefix('/chat')
    ->group(function () {
        Route::get('/inbox', [ConversationController::class, 'inbox'])
            ->name('chat.inbox');

        Route::get('/conversations/direct/{user}', [DirectConversationController::class, 'getConversation'])
            ->name('chat.conversations.direct.get');

        Route::get('/conversations/{conversation}/messages', [MessageController::class, 'getConversationMessages'])
            ->name('chat.conversations.messages.get');

        Route::post('/conversations/{conversation}/messages', [MessageController::class, 'newConversationMessage'])
            ->name('chat.conversations.messages.new');
    });
