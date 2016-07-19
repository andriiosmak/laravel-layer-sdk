<?php

namespace Aosmak\Laravel\Layer\Sdk;

use Aosmak\Laravel\Layer\Sdk\Services\LayerService;
use Aosmak\Laravel\Layer\Sdk\Services\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\AnnouncementService;
use GuzzleHttp\Client;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Routers\AnnouncementRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\ConversationRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\MessageRouter;
use Aosmak\Laravel\Layer\Sdk\Routers\UserRouter;

abstract class BaseClass extends \PHPUnit_Framework_TestCase
{
    /**
     * Layer Service
     *
     * @var Aosmak\Laravel\Layer\Sdk\Services\LayerService
     */
    public $service;
    
    /**
     * Set up Layer Service
     *
     * @return void
     */
    public function setUp()
    {
        $router  = new Router(new AnnouncementRouter, new ConversationRouter, new MessageRouter, new UserRouter); 
        $router->setConfig(require('Config/layer.php'));

        $service = new LayerService(new UserService, new ConversationService, new MessageService, new AnnouncementService);

        $service->setConfig(require('Config/layer.php'));
        $service->setClient(new Client);
        $service->setRouter($router);
        $service->setResponseStatus(new ResponseStatus);

        $this->service = $service;
    }

    /**
     * Get user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\User\UserService
     */
    public function getUserService()
    {
        return $this->service->getUserService();
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Conversation\ConversationService
     */
    public function getConversationService()
    {
        return $this->service->getConversationService();
    }

    /**
     * Get message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Message\MessageService
     */
    public function getMessageService()
    {
        return $this->service->getMessageService();
    }

    /**
     * Get announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Announcements\AnnouncementService
     */
    public function getAnnouncementService()
    {
        return $this->service->getAnnouncementService();
    }
}