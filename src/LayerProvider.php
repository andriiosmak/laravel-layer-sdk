<?php

namespace Aosmak\Laravel\Layer\Sdk;

use Illuminate\Support\ServiceProvider;

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
            __DIR__ . '/../config/layer.php' => config_path('layer.php')
        ], 'config');

        $this->app->bind('Aosmak\Laravel\Layer\Sdk\Services\LayerServiceInterface', function ($app) {
            $service = $app->make('Aosmak\Laravel\Layer\Sdk\Services\LayerService');
            $service->setConfig($app['config']['layer']);
            $service->setClient($app->make('GuzzleHttp\Client'));
            $service->setRouter($app->make('Aosmak\Laravel\Layer\Sdk\Routers\Router'));
            $service->setResponseStatus($app->make('Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus'));

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
