<?php

use _Modules\Chat\Controllers\ConversationController;
use _Modules\Chat\Controllers\DirectConversationController;
use _Modules\Chat\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/conversations', [ConversationController::class, 'list'])
        ->name('conversations.list');

    Route::get('/conversations/direct/{user}', [DirectConversationController::class, 'getConversation'])
        ->name('conversations.direct.get');

    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'getConversationMessages'])
        ->name('conversations.messages.get');

    Route::post('/conversations/{conversation}/messages', [MessageController::class, 'newConversationMessage'])
        ->name('conversations.messages.new');
});
