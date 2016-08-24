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
use GuzzleHttp\Psr7\Response;

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
     * @param GuzzleHttp\Handler\MockHandler $mock
     *
     */
    protected static function setUpService(MockHandler $mock)
    {
        $handler = HandlerStack::create($mock);
        $service = new LayerService(new UserService, new ConversationService, new MessageService, new AnnouncementService);
        $service->setConfig([
            'LAYER_SDK_APP_ID'           => 'id',
            'LAYER_SDK_AUTH'             => 'key',
            'LAYER_SDK_BASE_URL'         => 'url',
            'LAYER_SDK_SHOW_HTTP_ERRORS' => false
        ]);
        $service->setClient(new Client(['handler' => $handler]));
        $service->setRouter(new Router(new AnnouncementRouter, new ConversationRouter, new MessageRouter, new UserRouter));
        $service->setResponseStatus(new ResponseStatus);

        self::$service = $service;
    }

    /**
     * Get announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Announcements\AnnouncementService
     */
    public function getAnnouncementService() : AnnouncementService
    {
        return self::$service->getAnnouncementService();
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Conversation\ConversationService
     */
    public function getConversationService() : ConversationService
    {
        return self::$service->getConversationService();
    }

    /**
     * Get message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Message\MessageService
     */
    public function getMessageService() : MessageService
    {
        return self::$service->getMessageService();
    }

    /**
     * Get user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\User\UserService
     */
    public function getUserService() : UserService
    {
        return self::$service->getUserService();
    }

    /**
     * Set Up Guzzle Service
     *
     * @param GuzzleHttp\Handler\MockHandler $mock
     * @param string $content response content
     *
     * @return GuzzleHttp\Psr7\Response
     */
    public static function getResponse(int $status, $content = false) : Response
    {
        return new Response($status, ['Content-Type' => 'application/json'], $content);
    }
}