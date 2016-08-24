<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use Aosmak\Laravel\Layer\Sdk\Traits\SetterTrait;
use Aosmak\Laravel\Layer\Sdk\Services\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\AnnouncementService;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;

/**
 * Class LayerService
 * @package namespace Aosmak\Laravel\Layer\Sdk
 */
class LayerService implements LayerServiceInterface
{
    use SetterTrait;

    /**
     * User service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\UserService
     */
    private $userService;

    /**
     * Conversation service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\ConversationService
     */
    private $conversationService;

    /**
     * Message service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\MessageService
     */
    private $messageService;

    /**
     * Announcement service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\AnnouncementService
     */
    private $announcementService;

    /**
     * Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Router
     */
    private $router;

    /**
     * Constructor
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\UserService $userService
     * @param \Aosmak\Laravel\Layer\Sdk\Services\ConversationService $conversationService
     * @param \Aosmak\Laravel\Layer\Sdk\Services\MessageService $messageService
     * @param \Aosmak\Laravel\Layer\Sdk\Services\AnnouncementService $announcementService
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        ConversationService $conversationService,
        MessageService $messageService,
        AnnouncementService $announcementService
    ) {
        $this->userService         = $userService;
        $this->conversationService = $conversationService;
        $this->messageService      = $messageService;
        $this->announcementService = $announcementService;
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
    public function getRouter() : Router
    {
        $router = $this->router;
        $router->setAppId($this->config['LAYER_SDK_APP_ID']);
        return $router;
    }

    /**
     * Get user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\UserService
     */
    public function getUserService() : UserService
    {
        return $this->getService($this->userService, $this->getRouter()->getUserRouter());
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\ConversationService
     */
    public function getConversationService() : ConversationService
    {
        return $this->getService($this->conversationService, $this->getRouter()->getConversationRouter());
    }

    /**
     * Get message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\MessageService
     */
    public function getMessageService() : MessageService
    {
        return $this->getService($this->messageService, $this->getRouter()->getMessageRouter());
    }

    /**
     * Get announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\AnnouncementService
     */
    public function getAnnouncementService() : AnnouncementService
    {
        return $this->getService($this->announcementService, $this->getRouter()->getAnnouncementRouter());
    }

    /**
     * Get service
     *
     * @param Aosmak\Laravel\Layer\Sdk\Services\Service $service
     * @param Aosmak\Laravel\Layer\Sdk\Services\BaseRouter $router
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Service
     */
    private function getService($service, $router) : Service
    {
        $service->setConfig($this->config);
        $service->setClient($this->client);
        $service->setResponseStatus($this->responseStatus);
        $service->setRouter($router);

        return $service;
    }
}
