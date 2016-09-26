<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\BaseService;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class LayerService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services
 */
class LayerService implements LayerServiceInterface
{
    use ConfigTrait;

    /**
     * Client
     *
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * Conversation service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    private $conversationService;

    /**
     * Message service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    private $messageService;

    /**
     * User service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    private $userService;

    /**
     * Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Router
     */
    private $router;

    /**
     * Container
     *
     * @var \Illuminate\Container\Container
     */
    private $container;

    /**
     * Response status
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus
     */
    private $responseStatus;

    /**
     * Constructor
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService $userService
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService $conversationService
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService $messageService
     * @param \Illuminate\Container\Container $container
     * @param \GuzzleHttp\Client $client
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\Router $client
     * @param \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus $responseStatus
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        ConversationService $conversationService,
        MessageService $messageService,
        Container $container,
        Client $client,
        Router $router,
        ResponseStatus $responseStatus
    ) {
        $this->userService         = $userService;
        $this->conversationService = $conversationService;
        $this->messageService      = $messageService;
        $this->container           = $container;
        $this->client              = $client;
        $this->router              = $router;
        $this->responseStatus      = $responseStatus;
    }

    /**
     * Set router
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\Router $router
     *
     * @return void
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Get router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\Router $router
     */
    public function getRouter(): Router
    {
        $router = $this->router;
        $router->setAppId($this->config['LAYER_SDK_APP_ID']);
        return $router;
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    public function getConversationService(): ConversationService
    {
        return $this->getService('ConversationService', $this->getRouter()->getConversationRouter());
    }

    /**
     * Get message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    public function getMessageService(): MessageService
    {
        return $this->getService('MessageService', $this->getRouter()->getMessageRouter());
    }

    /**
     * Get user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    public function getUserService(): UserService
    {
        return $this->getService('UserService', $this->getRouter()->getUserRouter());
    }

    /**
     * Get service
     *
     * @param string $serviceName service name
     * @param Aosmak\Laravel\Layer\Sdk\Services\Subrouters\BaseRouter $router
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\BaseService
     */
    private function getService($serviceName, $router): BaseService
    {
        $service = $this->container->make('Aosmak\Laravel\Layer\Sdk\Services\Subservices\\'. $serviceName);
        $service->setConfig($this->config);
        $service->setClient($this->client);
        $service->setRouter($router);

        return $service;
    }
}
