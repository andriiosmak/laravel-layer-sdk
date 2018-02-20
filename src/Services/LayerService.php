<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\AnnouncementServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\ConversationServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\IdentityServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserDataServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RichContentServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\MessageServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\NotificationServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\DataServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\BaseServiceInterface;

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
     * RequestService
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService
     */
    private $requestService;

    /**
     * Constructor
     *
     * @param \Illuminate\Container\Container $container
     * @param \GuzzleHttp\Client $client
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\Router $router
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService $requestService
     *
     * @return void
     */
    public function __construct(Container $container, Client $client, Router $router, RequestService $requestService)
    {
        $this->container = $container;
        $this->client    = $client;
        $this->router    = $router;
        $requestService->setContainer($container);
        $this->requestService = $requestService;
    }

    /**
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\ConversationServiceInterface
     */
    public function getConversationService(): ConversationServiceInterface
    {
        return $this->getService('ConversationService');
    }

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\MessageServiceInterface
     */
    public function getMessageService(): MessageServiceInterface
    {
        return $this->getService('MessageService');
    }

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserServiceInterface
     */
    public function getUserService(): UserServiceInterface
    {
        return $this->getService('UserService');
    }

    /**
     * Get an identity service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\IdentityServiceInterface
     */
    public function getIdentityService(): IdentityServiceInterface
    {
        return $this->getService('IdentityService');
    }

    /**
     * Get a user data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserDataServiceInterface
     */
    public function getUserDataService(): UserDataServiceInterface
    {
        return $this->getService('UserDataService');
    }

    /**
     * Get an announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\AnnouncementServiceInterface
     */
    public function getAnnouncementService(): AnnouncementServiceInterface
    {
        return $this->getService('AnnouncementService');
    }

    /**
     * Get a notification service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\NotificationServiceInterface
     */
    public function getNotificationService(): NotificationServiceInterface
    {
        return $this->getService('NotificationService');
    }

    /**
     * Get a data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\DataServiceInterface
     */
    public function getDataService(): DataServiceInterface
    {
        return $this->getService('DataService');
    }

    /**
     * Get a rich content service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RichContentServiceInterface
     */
    public function getRichContentService(): RichContentServiceInterface
    {
        return $this->getService('RichContentService');
    }

    /**
     * Get a service
     *
     * @param string $serviceName service name
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\BaseServiceInterface
     */
    private function getService(string $serviceName): BaseServiceInterface
    {
        $propName = lcfirst($serviceName);
        if (empty($this->$propName)) {
            $service = $this->container->make('Aosmak\Laravel\Layer\Sdk\Services\Subservices\\'. $serviceName);
            $service->setRequestService($this->requestService);
            $service->setConfig($this->config);
            $service->setClient($this->client);
            $service->setRouter($this->getRouter());
            $this->$propName = $service;
        } else {
            $service = $this->$propName;
        }

        return $service;
    }

    /**
     * Get a router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface $router
     */
    private function getRouter(): RouterInterface
    {
        $router = $this->router;
        $router->setContainer($this->container);
        $router->setAppId($this->config['LAYER_SDK_APP_ID']);
        return $router;
    }
}
