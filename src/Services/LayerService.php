<?php

namespace Aosmak\Layer\Services;

use Aosmak\Layer\Traits\SetterTrait;
use Aosmak\Layer\Services\UserService;
use Aosmak\Layer\Services\ConversationService;
use Aosmak\Layer\Services\MessageService;
use Aosmak\Layer\Services\AnnouncementService;
use Aosmak\Layer\Routers\Router;

/**
 * Class LayerService
 * @package namespace Aosmak\Layer
 */
class LayerService implements LayerServiceInterface
{
    use SetterTrait;

    /**
     * User service
     *
     * @var \Aosmak\Layer\Services\UserService
     */
    private $userService;

    /**
     * Conversation service
     *
     * @var \Aosmak\Layer\Services\ConversationService
     */
    private $conversationService;

    /**
     * Message service
     *
     * @var \Aosmak\Layer\Services\MessageService
     */
    private $messageService;

    /**
     * Announcement service
     *
     * @var \Aosmak\Layer\Services\AnnouncementService
     */
    private $announcementService;

    /**
     * Router
     *
     * @var \Aosmak\Layer\Routers\Router
     */
    private $router;

    /**
     * Constructor
     *
     * @param \Aosmak\Layer\Services\UserService $userService
     * @param \Aosmak\Layer\Services\ConversationService $conversationService
     * @param \Aosmak\Layer\Services\MessageService $messageService
     * @param \Aosmak\Layer\Services\AnnouncementService $announcementService
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
     * @param \Aosmak\Layer\Routers\Router $router
     *
     * @return void
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Get user service
     *
     * @return Aosmak\Layer\Services\UserService
     */
    public function getUserService() : UserService
    {
        return $this->getService($this->userService, $this->router->getUserRouter());
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Layer\Services\ConversationService
     */
    public function getConversationService() : ConversationService
    {
        return $this->getService($this->conversationService, $this->router->getConversationRouter());
    }

    /**
     * Get message service
     *
     * @return Aosmak\Layer\Services\MessageService
     */
    public function getMessageService() : MessageService
    {
        return $this->getService($this->messageService, $this->router->getMessageRouter());
    }

    /**
     * Get announcement service
     *
     * @return Aosmak\Layer\Services\AnnouncementService
     */
    public function getAnnouncementService() : AnnouncementService
    {
        return $this->getService($this->announcementService, $this->router->getAnnouncementRouter());
    }

    /**
     * Get service
     *
     * @param Aosmak\Layer\Services\Service $service
     * @param Aosmak\Layer\Services\BaseRouter $router
     *
     * @return Aosmak\Layer\Services\Service
     */
    private function getService($service, $router)
    {
        $service->setConfig($this->config);
        $service->setClient($this->client);
        $service->setResponseStatus($this->responseStatus);
        $service->router = $router;

        return $service;
    }
}
