<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Traits\ClientTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ResponseStatusTrait;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\BaseService;

/**
 * Class LayerService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services
 */
class LayerService implements LayerServiceInterface
{
    use ClientTrait, ConfigTrait, ResponseStatusTrait;

    /**
     * Conversation service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    private $conversationService;

    /**
     * Message service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    private $messageService;

    /**
     * User service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    private $userService;

    /**
     * Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Router
     */
    private $router;

    /**
     * Constructor
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService $userService
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService $conversationService
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService $messageService
     *
     * @return void
     */
    public function __construct(
        UserService $userService,
        ConversationService $conversationService,
        MessageService $messageService
    ) {
        $this->userService         = $userService;
        $this->conversationService = $conversationService;
        $this->messageService      = $messageService;
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
    public function getRouter(): Router
    {
        $router = $this->router;
        $router->setAppId($this->config['LAYER_SDK_APP_ID']);
        return $router;
    }

    /**
     * Get conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    public function getConversationService(): ConversationService
    {
        return $this->getService($this->conversationService, $this->getRouter()->getConversationRouter());
    }

    /**
     * Get message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    public function getMessageService(): MessageService
    {
        return $this->getService($this->messageService, $this->getRouter()->getMessageRouter());
    }

    /**
     * Get user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    public function getUserService(): UserService
    {
        return $this->getService($this->userService, $this->getRouter()->getUserRouter());
    }

    /**
     * Get service
     *
     * @param Aosmak\Laravel\Layer\Sdk\Services\Subservices\BaseService $service
     * @param Aosmak\Laravel\Layer\Sdk\Services\Subrouters\BaseRouter $router
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\BaseService
     */
    private function getService($service, $router): BaseService
    {
        $service->setConfig($this->config);
        $service->setClient($this->client);
        $service->setResponseStatus($this->responseStatus);
        $service->setRouter($router);

        return $service;
    }
}
