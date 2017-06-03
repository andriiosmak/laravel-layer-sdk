<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\BaseService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService;

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
     * @param \Illuminate\Container\Container $container
     * @param \GuzzleHttp\Client $client
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\Router $client
     * @param \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus $responseStatus
     *
     * @return void
     */
    public function __construct(
        Container $container,
        Client $client,
        Router $router,
        ResponseStatus $responseStatus
    ) {
        $this->container      = $container;
        $this->client         = $client;
        $this->router         = $router;
        $this->responseStatus = $responseStatus;
    }

    /**
     * Get a router
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
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    public function getConversationService(): ConversationService
    {
        return $this->getService('ConversationService', $this->getRouter()->getConversationRouter());
    }

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    public function getMessageService(): MessageService
    {
        return $this->getService('MessageService', $this->getRouter()->getMessageRouter());
    }

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    public function getUserService(): UserService
    {
        return $this->getService('UserService', $this->getRouter()->getUserRouter());
    }

    /**
     * Get an announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService
     */
    public function getAnnouncementService(): AnnouncementService
    {
        return $this->getService('AnnouncementService', $this->getRouter()->getAnnouncementRouter());
    }

    /**
     * Get a notification service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService
     */
    public function getNotificationService(): NotificationService
    {
        return $this->getService('NotificationService', $this->getRouter()->getNotificationRouter());
    }

    /**
     * Get a service
     *
     * @param string $serviceName service name
     * @param Aosmak\Laravel\Layer\Sdk\Services\Subrouters\BaseRouter $router
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\BaseService
     */
    private function getService($serviceName, $router): BaseService
    {
        $propName = lcfirst($serviceName);
        if (empty($this->$propName)) {
            $service = $this->container->make('Aosmak\Laravel\Layer\Sdk\Services\Subservices\\'. $serviceName);
            $service->setConfig($this->config);
            $service->setClient($this->client);
            $service->setRouter($router);
            $this->$propName = $service;
        } else {
            $service = $this->$propName;
        }

        return $service;
    }
}
