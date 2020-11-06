<?php

namespace Pdmfc\DatabaseEnv;

use Illuminate\Support\ServiceProvider;

class DatabaseEnvServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            // Registering package commands.
            $this->commands([
                DatabaseEnvCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register the main class to use with the facade
        $this->app->singleton('database-env', function () {
            return new DatabaseEnv;
        });
    }
}
