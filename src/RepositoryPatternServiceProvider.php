<?php

namespace Morshadun\RepositoryPattern;

use Illuminate\Support\ServiceProvider;

class RepositoryPatternServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Morshadun\RepositoryPattern\Commands\DesignPatternCommand'
    ];
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'morshadun');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'morshadun');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {

        // Register the service the package provides.
        $this->app->singleton('repositorypattern', function ($app) {
            return new RepositoryPattern;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['repositorypattern'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {


//         Registering package commands.
         $this->commands($this->commands);
    }
}
