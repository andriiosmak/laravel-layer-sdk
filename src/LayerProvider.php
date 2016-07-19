<?php

namespace Aosmak\Layer;

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

        $this->app->bind('Aosmak\Layer\Services\LayerServiceInterface', function ($app) {
            $router = $app->make('Aosmak\Layer\Routers\Router');
            $router->setConfig($app['config']['layer']);

            $service = $app->make('Aosmak\Layer\Services\LayerService');
            $service->setConfig($app['config']['layer']);
            $service->setClient($app->make('GuzzleHttp\Client'));
            $service->setRouter($router);
            $service->setResponseStatus($app->make('Aosmak\Layer\Models\ResponseStatus'));

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
