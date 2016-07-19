<?php

namespace Aosmak\Larevel\Layer\Sdk;

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

        $this->app->bind('Aosmak\Larevel\Layer\Sdk\Services\LayerServiceInterface', function ($app) {
            $router = $app->make('Aosmak\Larevel\Layer\Sdk\Routers\Router');
            $router->setConfig($app['config']['layer']);

            $service = $app->make('Aosmak\Larevel\Layer\Sdk\Services\LayerService');
            $service->setConfig($app['config']['layer']);
            $service->setClient($app->make('GuzzleHttp\Client'));
            $service->setRouter($router);
            $service->setResponseStatus($app->make('Aosmak\Larevel\Layer\Sdk\Models\ResponseStatus'));

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
