<?php

namespace _Modules\Chat\Providers;

use Illuminate\Support\ServiceProvider;

class MigrationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__.'/../migrations');
        }
    }

    protected function shouldMigrate()
    {
        return true;
    }
}
