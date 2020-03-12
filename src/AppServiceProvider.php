<?php

namespace LaravelEnso\Categories;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->load();
        $this->publish();
    }

    private function load()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/categories.php', 'categories');
    }

    private function publish()
    {
        $this->publishes([
            __DIR__.'/config' => config_path('laravel-enso'),
        ], 'categories-config');

        $this->publishes([
            __DIR__.'/client/src/js' => base_path('client/src/js'),
        ], 'categories-assets');

        $this->publishes([
            __DIR__.'/database/factories' => database_path('factories'),
        ], ['categories-factories', 'enso-factories']);

        return $this;
    }

    public function register()
    {
        //
    }
}
