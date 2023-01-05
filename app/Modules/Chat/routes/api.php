<?php

use App\Modules\Chat\Controllers\UserConversations\ConversationController;
use App\Modules\Chat\Controllers\UserConversations\DirectConversationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/conversations/direct/{user}', [DirectConversationController::class, 'getConversation'])
        ->name('conversations.direct.get');

    Route::get('/conversations', [ConversationController::class, 'list'])
        ->name('conversations.list');

    Route::post('/conversations/{conversation}/messages', [ConversationController::class, 'newConversationMessage'])
        ->name('conversations.messages.new');

    Route::get('/conversations/{conversation}/messages', [ConversationController::class, 'getConversationMessages'])
        ->name('conversations.messages.get');
});
