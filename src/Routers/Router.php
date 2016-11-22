<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\ConversationRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\MessageRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\UserRouter;

/**
 * Class Router
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class Router
{
    /**
     * Conversation Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\ConversationRouter
     */
    private $conversationRouter;

    /**
     * Message Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\MessageRouter
     */
    private $messageRouter;

    /**
     * User Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\UserRouter
     */
    private $userRouter;

    /**
     * Application ID
     *
     * @var string application ID
     */
    protected $appId;

    /**
     * Set application ID
     *
     * @param string $appId application ID
     *
     * @return void
     */
    public function setAppId(string $appId)
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
