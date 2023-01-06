<?php

namespace _Modules\Chat\Concerns;

use _Modules\Chat\Models\Conversation;
use _Modules\Chat\Models\Message;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait IsChatUser
{
    // --------------------------------------------
    // Relations
    // --------------------------------------------

    public function conversations(): BelongsToMany
    {
        return $this->belongsToMany(Conversation::class)->withTimestamps();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
