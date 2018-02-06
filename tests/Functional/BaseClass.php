<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use PHPUnit\Framework\TestCase;
use Aosmak\Laravel\Layer\Sdk\Services\LayerService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserDataService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\DataService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\IdentityService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\RichContentService;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Container\Container;

/**
 * Class BaseClass
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
abstract class BaseClass extends TestCase
{
    /**
     * Layer Service
     *
     * @var Aosmak\Laravel\Layer\Sdk\Services\LayerService
     */
    protected static $service;

    /**
     * Set Up Guzzle Service
     *
     * @param GuzzleHttp\Handler\MockHandler $mock
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Services\LayerService
     */
    protected static function setUpService(MockHandler $mock): void
    {
        $handler   = HandlerStack::create($mock);
        $container = new Container;
        $service   = $container->make('Aosmak\Laravel\Layer\Sdk\Services\LayerService');
        $service->setConfig([
            'LAYER_SDK_APP_ID'           => 'id',
            'LAYER_SDK_AUTH'             => 'key',
            'LAYER_SDK_BASE_URL'         => 'url',
            'LAYER_SDK_SHOW_HTTP_ERRORS' => false
        ]);
        $reflection = new \ReflectionClass($service);
        $reflection_property = $reflection->getProperty('client');
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($service, new Client(['handler' => $handler]));

        self::$service = $service;
    }

    /**
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    public function getConversationService(): ConversationService
    {
        return self::$service->getConversationService();
    }

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    public function getMessageService(): MessageService
    {
        return self::$service->getMessageService();
    }


    /**
     * Get an identity service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\IdentityService
     */
    public function getIdentityService(): IdentityService
    {
        return self::$service->getIdentityService();
    }

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    public function getUserService(): UserService
    {
        return self::$service->getUserService();
    }

    /**
     * Get an announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService
     */
    public function getAnnouncementService(): AnnouncementService
    {
        return self::$service->getAnnouncementService();
    }

    /**
     * Get a notification service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService
     */
    public function getNotificationService(): NotificationService
    {
        return self::$service->getNotificationService();
    }

    /**
     * Get a user data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserDataService
     */
    public function getUserDataService(): UserDataService
    {
        return self::$service->getUserDataService();
    }

    /**
     * Get a data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\DataService
     */
    public function getDataService(): DataService
    {
        return self::$service->getDataService();
    }

    /**
     * Get a rich content service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\RichContentService
     */
    public function getRichContentService(): RichContentService
    {
        return self::$service->getRichContentService();
    }

    /**
     * Set Up Guzzle Service
     *
     * @param GuzzleHttp\Handler\MockHandler $mock
     * @param string $content response content
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getResponse(int $status, $content = false): Response
    {
        return new Response($status, ['Content-Type' => 'application/json'], $content);
    }
}