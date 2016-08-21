<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Services\LayerService;
use Aosmak\Laravel\Layer\Sdk\Services\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\AnnouncementService;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Routers\AnnouncementRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\ConversationRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\MessageRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\UserRouter;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Exception\RequestException;

use GuzzleHttp\Psr7;

abstract class BaseClass extends \PHPUnit_Framework_TestCase
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
     */
    protected static function setUpService(MockHandler $mock)
    {
        $handler = HandlerStack::create($mock);
        $client  = new Client(['handler' => $handler]);
        $router  = new Router(new AnnouncementRouter, new ConversationRouter, new MessageRouter, new UserRouter); 
        $router->setConfig(require('Config/layer.php'));
        $service = new LayerService(new UserService, new ConversationService, new MessageService, new AnnouncementService);
        $service->setConfig(require('Config/layer.php'));
        $service->setClient($client);
        $service->setRouter($router);
        $service->setResponseStatus(new ResponseStatus);

        self::$service = $service;
    }

    /**
     * Get user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\User\UserService
     */
    public function getUserService()
    {
        return self::$service->getUserService();
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Conversation\ConversationService
     */
    public function getConversationService()
    {
        return self::$service->getConversationService();
    }

    /**
     * Get message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Message\MessageService
     */
    public function getMessageService()
    {
        return self::$service->getMessageService();
    }

    /**
     * Get announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Announcements\AnnouncementService
     */
    public function getAnnouncementService()
    {
        return self::$service->getAnnouncementService();
    }
}