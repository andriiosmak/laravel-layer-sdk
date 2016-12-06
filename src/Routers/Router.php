<?php

declare(strict_types=1);

namespace Aosmak\Laravel\Layer\Sdk\Routers;

use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\
{
    BaseRouter,
    ConversationRouter,
    MessageRouter,
    UserRouter
};

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
     * @param string $value method value
     *
     * @return Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter
     */
    public function __call($name, $value): BaseRouter
    {
        $methods = [
            'getConversationRouter',
            'getMessageRouter',
            'getUserRouter',
        ];
        if (in_array($name, $methods)) {
            return $this->getRouter(str_replace('get', '', $name));
        }

        throw new \Exception('Unable to find a router.');
    }

    /**
     * Get a router
     *
     * @param string $routerName router name
     *
     * @return Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter $router
     */
    private function getRouter($routerName): BaseRouter
    {
        $propName = lcfirst($routerName);
        if (empty($this->$propName)) {
            $router = $this->container->make('Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\\'. $routerName);
            $router->setAppId($this->appId);
            $this->$propName = $router;
        } else {
            $router = $this->$propName;
        }

        return $router;
    }
}
