<?php

namespace App\Modules\Chat\Providers;

use Illuminate\Support\ServiceProvider;

class ConversationSerivceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(BroadcastServiceProvider::class);
        $this->app->register(MigrationServiceProvider::class);
    }
}
