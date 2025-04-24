<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        // Registrar servicios esenciales manualmente con namespaces completos
        $this->app->register(\Illuminate\Filesystem\FilesystemServiceProvider::class);
        $this->app->register(\Illuminate\Cache\CacheServiceProvider::class);
        $this->app->register(\Illuminate\Database\DatabaseServiceProvider::class);
        $this->app->singleton(MaintenanceMode::class, function ($app) {
            return $app->loadComponent('foundation', FoundationServiceProvider::class, 'Illuminate\Contracts\Foundation\MaintenanceMode');
        });
        $this->app->alias('hash', \Illuminate\Hashing\HashManager::class);
 
    
    
    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
