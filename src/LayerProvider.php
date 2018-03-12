<?php

namespace Aosmak\Laravel\Layer\Sdk;

use Illuminate\Support\ServiceProvider;

/**
 * Class LayerProvider
 * @package namespace Aosmak\Laravel\Layer\Sdk
 */
class LayerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/layer.php' => $this->app->make('path.config') . '/layer.php'
        ], 'config');

        $this->app->bind('Aosmak\Laravel\Layer\Sdk\Services\LayerServiceInterface', function ($app) {
            $service = $app->make('Aosmak\Laravel\Layer\Sdk\Services\LayerService');
            $service->setConfig($app['config']['layer']);

            return $service;
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
