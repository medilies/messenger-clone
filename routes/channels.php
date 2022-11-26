<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('direct-messages.{target_user_id}', function ($user, $target_user_id): bool {
    return $user->id === User::find($target_user_id)->id;
});

// Broadcast::channel('chat', function ($user) {
//     return [$user];
// });
