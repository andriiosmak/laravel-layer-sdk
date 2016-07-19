<?php

namespace Aosmak\Layer;

use Aosmak\Layer\Services\LayerService;
use Aosmak\Layer\Services\UserService;
use Aosmak\Layer\Services\ConversationService;
use Aosmak\Layer\Services\MessageService;
use Aosmak\Layer\Services\AnnouncementService;
use GuzzleHttp\Client;
use Aosmak\Layer\Models\ResponseStatus;
use Aosmak\Layer\Routers\Router;
use Aosmak\Layer\Routers\AnnouncementRouter;
use Aosmak\Layer\Routers\ConversationRouter;
use Aosmak\Layer\Routers\MessageRouter;
use Aosmak\Layer\Routers\UserRouter;

abstract class BaseClass extends \PHPUnit_Framework_TestCase
{
    /**
     * Layer Service
     *
     * @var Aosmak\Layer\Services\LayerService
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
     * @return Aosmak\Layer\Services\User\UserService
     */
    public function getUserService()
    {
        return $this->service->getUserService();
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Layer\Services\Conversation\ConversationService
     */
    public function getConversationService()
    {
        return $this->service->getConversationService();
    }

    /**
     * Get message service
     *
     * @return Aosmak\Layer\Services\Message\MessageService
     */
    public function getMessageService()
    {
        return $this->service->getMessageService();
    }

    /**
     * Get announcement service
     *
     * @return Aosmak\Layer\Services\Announcements\AnnouncementService
     */
    public function getAnnouncementService()
    {
        return $this->service->getAnnouncementService();
    }
}