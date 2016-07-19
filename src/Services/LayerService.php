<?php

namespace Aosmak\Larevel\Layer\Sdk\Services;

use Aosmak\Larevel\Layer\Sdk\Traits\SetterTrait;
use Aosmak\Larevel\Layer\Sdk\Services\UserService;
use Aosmak\Larevel\Layer\Sdk\Services\ConversationService;
use Aosmak\Larevel\Layer\Sdk\Services\MessageService;
use Aosmak\Larevel\Layer\Sdk\Services\AnnouncementService;
use Aosmak\Larevel\Layer\Sdk\Routers\Router;

/**
 * Class LayerService
 * @package namespace Aosmak\Larevel\Layer\Sdk
 */
class LayerService implements LayerServiceInterface
{
    use SetterTrait;

    /**
     * User service
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Services\UserService
     */
    private $userService;

    /**
     * Conversation service
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Services\ConversationService
     */
    private $conversationService;

    /**
     * Message service
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Services\MessageService
     */
    private $messageService;

    /**
     * Announcement service
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Services\AnnouncementService
     */
    private $announcementService;

    /**
     * Router
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Routers\Router
     */
    private $router;

    /**
     * Constructor
     *
     * @param \Aosmak\Larevel\Layer\Sdk\Services\UserService $userService
     * @param \Aosmak\Larevel\Layer\Sdk\Services\ConversationService $conversationService
     * @param \Aosmak\Larevel\Layer\Sdk\Services\MessageService $messageService
     * @param \Aosmak\Larevel\Layer\Sdk\Services\AnnouncementService $announcementService
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
     * @param \Aosmak\Larevel\Layer\Sdk\Routers\Router $router
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
     * @return Aosmak\Larevel\Layer\Sdk\Services\UserService
     */
    public function getUserService() : UserService
    {
        return $this->getService($this->userService, $this->router->getUserRouter());
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Larevel\Layer\Sdk\Services\ConversationService
     */
    public function getConversationService() : ConversationService
    {
        return $this->getService($this->conversationService, $this->router->getConversationRouter());
    }

    /**
     * Get message service
     *
     * @return Aosmak\Larevel\Layer\Sdk\Services\MessageService
     */
    public function getMessageService() : MessageService
    {
        return $this->getService($this->messageService, $this->router->getMessageRouter());
    }

    /**
     * Get announcement service
     *
     * @return Aosmak\Larevel\Layer\Sdk\Services\AnnouncementService
     */
    public function getAnnouncementService() : AnnouncementService
    {
        return $this->getService($this->announcementService, $this->router->getAnnouncementRouter());
    }

    /**
     * Get service
     *
     * @param Aosmak\Larevel\Layer\Sdk\Services\Service $service
     * @param Aosmak\Larevel\Layer\Sdk\Services\BaseRouter $router
     *
     * @return Aosmak\Larevel\Layer\Sdk\Services\Service
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
