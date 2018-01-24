<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter;

/**
 * Class Router
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class Router
{
    /**
     * Container
     *
     * @var \Illuminate\Container\Container
     */
    private $container;

    /**
     * Application ID
     *
     * @var string application ID
     */
    protected $appId;

    /**
     * Constructor
     *
     * @param \Illuminate\Container\Container $container
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Set an application ID
     *
     * @param string $appId application ID
     *
     * @return void
     */
    public function setAppId(string $appId): void
    {
        $this->appId = $appId;
    }

    /**
     * Return a router
     *
     * @param string $name method name
     * @param array $value method value
     *
     * @return mixed
     */
    public function __call(string $name, array $value)
    {
        if ($response = $this->getSubRouter(str_replace('get', '', $name))) {
            return $response;
        }

        throw new \Exception('Unable to find a router.');
    }

    /**
     * Get a router
     *
     * @param string $routerName router name
     *
     * @return mixed Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter|null
     */
    private function getSubRouter(string $routerName): ?BaseRouter
    {
        $propName = lcfirst($routerName);
        if (empty($this->$propName)) {
            $this->$propName = $this->resolveSubRouter($propName, 'Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\\'. $routerName);
        }

        return !empty($this->$propName)? $this->$propName : null;
    }

    /**
     * Resolve a router
     *
     * @param string $propName property name
     * @param string $routerPath full path
     *
     * @return mixed Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter|null
     */
    private function resolveSubRouter(string $propName, string $routerPath): ?BaseRouter
    {
        if (class_exists($routerPath)) {
            $router = $this->container->make($routerPath);
            $router->setAppId($this->appId);
            $this->$propName = $router;
            return $router;
        } else {
            return null;
        }
    }
}
