<?php

namespace _Modules\Chat\Providers;

use _Modules\Chat\Models\Conversation;
use _Modules\Chat\Policies\ConversationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Conversation::class => ConversationPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
