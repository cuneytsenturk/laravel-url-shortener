<?php

namespace CuneytSenturk\UrlShortener;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/Config/url_shortener.php' => config_path('url_shortener.php'),
            __DIR__ . '/Migrations/2024_08_03_000000_create_url_shortener_table.php' => database_path('migrations/2024_08_03_000000_create_url_shortener_table.php'),

        ], 'url_shortener');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('url_shortener.manager', function ($app) {
            return new Manager($app);
        });

        $this->app->singleton('url_shortener', function ($app) {
            return $app['url_shortener.manager']->driver();
        });

        $this->mergeConfigFrom(__DIR__ . '/Config/url_shortener.php', 'url_shortener');
    }
}
