<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use GuzzleHttp\Client;
use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\BaseService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\IdentityService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserDataService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\RichContentService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\DataService;

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
     * Constructor
     *
     * @param \Illuminate\Container\Container $container
     * @param \GuzzleHttp\Client $client
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\Router $client
     *
     * @return void
     */
    public function __construct(Container $container, Client $client, Router $router)
    {
        $this->container = $container;
        $this->client    = $client;
        $this->router    = $router;
    }

    /**
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    public function getConversationService(): ConversationService
    {
        return $this->getService('ConversationService');
    }

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    public function getMessageService(): MessageService
    {
        return $this->getService('MessageService');
    }

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    public function getUserService(): UserService
    {
        return $this->getService('UserService');
    }

    /**
     * Get an identity service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\IdentityService
     */
    public function getIdentityService(): IdentityService
    {
        return $this->getService('IdentityService');
    }

    /**
     * Get a user data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserDataService
     */
    public function getUserDataService(): UserDataService
    {
        return $this->getService('UserDataService');
    }

    /**
     * Get an announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService
     */
    public function getAnnouncementService(): AnnouncementService
    {
        return $this->getService('AnnouncementService');
    }

    /**
     * Get a notification service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService
     */
    public function getNotificationService(): NotificationService
    {
        return $this->getService('NotificationService');
    }

    /**
     * Get a data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\DataService
     */
    public function getDataService(): DataService
    {
        return $this->getService('DataService');
    }

    /**
     * Get a rich content service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\RichContentService
     */
    public function getRichContentService(): RichContentService
    {
        return $this->getService('RichContentService');
    }

    /**
     * Get a service
     *
     * @param string $serviceName service name
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\BaseService
     */
    private function getService(string $serviceName): BaseService
    {
        $propName = lcfirst($serviceName);
        if (empty($this->$propName)) {
            $service = $this->container->make('Aosmak\Laravel\Layer\Sdk\Services\Subservices\\'. $serviceName);
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
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\Router $router
     */
    private function getRouter(): Router
    {
        $router = $this->router;
        $router->setAppId($this->config['LAYER_SDK_APP_ID']);
        return $router;
    }
}
