<?php

namespace Beaplat\Swal;

use Illuminate\Support\ServiceProvider;

class SwalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'SweetAlert');

        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/vendor/swal'),
            __DIR__.'/config/swal.php' => config_path('swal.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['swal'] = $this->app->share(function ($app) {
            return new Swal($app['session'], $app['config']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        // return ['swal'];
    }
}
