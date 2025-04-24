<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\MaintenanceMode;
use Illuminate\Foundation\MaintenanceModeManager;
use Illuminate\Support\ServiceProvider;

class MaintenanceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MaintenanceMode::class, function ($app) {
            return new MaintenanceModeManager($app);
        });
    }
}