<?php

namespace Aosmak\Larevel\Layer\Sdk\Routers;

/**
 * Class Router
 * @package namespace Aosmak\Larevel\Layer\Sdk\Routers;
 */
class Router
{
    /**
     * Announcement Router
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Routers\AnnouncementRouter
     */
    private $announcementRouter;

    /**
     * Conversation Router
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Routers\ConversationRouter
     */
    private $conversationRouter;

    /**
     * Message Router
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Routers\MessageRouter
     */
    private $messageRouter;

    /**
     * User Router
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Routers\UserRouter
     */
    private $userRouter;

    /**
     * Config
     *
     * @var array contains configuration variables
     */
    private $config;

    /**
     * Constructor
     *
     * @param \Aosmak\Larevel\Layer\Sdk\Routers\AnnouncementRouter $announcementRouter
     * @param \Aosmak\Larevel\Layer\Sdk\Routers\ConversationRouter $conversationRouter
     * @param \Aosmak\Larevel\Layer\Sdk\Routers\MessageRouter $messageRouter
     * @param \Aosmak\Larevel\Layer\Sdk\Routers\UserRouter $userRouter
     *
     * @return void
     */
    public function __construct(
        AnnouncementRouter $announcementRouter,
        ConversationRouter $conversationRouter,
        MessageRouter $messageRouter,
        UserRouter $userRouter
    ) {
        $this->announcementRouter = $announcementRouter;
        $this->conversationRouter = $conversationRouter;
        $this->messageRouter      = $messageRouter;
        $this->userRouter         = $userRouter;
    }

    /**
     * Set config
     *
     * @param array $config contains configuration variables
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get Announcement Router
     *
     * @return \Aosmak\Larevel\Layer\Sdk\Routers\AnnouncementRouter $announcementRouter
     */
    public function getAnnouncementRouter() : AnnouncementRouter
    {
        return $this->getRouter($this->announcementRouter);
    }

    /**
     * Get Conversation Router
     *
     * @return \Aosmak\Larevel\Layer\Sdk\Routers\ConversationRouter $conversationRouter
     */
    public function getConversationRouter() : ConversationRouter
    {
        return $this->getRouter($this->conversationRouter);
    }

    /**
     * Get Message Router
     *
     * @return \Aosmak\Larevel\Layer\Sdk\Routers\MessageRouter $messageRouter
     */
    public function getMessageRouter() : MessageRouter
    {
        return $this->getRouter($this->messageRouter);
    }

    /**
     * Get User Router
     *
     * @return \Aosmak\Larevel\Layer\Sdk\Routers\UserRouter $userRouter
     */
    public function getUserRouter() : UserRouter
    {
        return $this->getRouter($this->userRouter);
    }

    /**
     * Get router
     *
     * @param Aosmak\Larevel\Layer\Sdk\Routers\BaseRouter $router
     *
     * @return Aosmak\Larevel\Layer\Sdk\Routers\BaseRouter $router
     */
    private function getRouter($router) : BaseRouter
    {
        $router->setConfig($this->config);
        return $router;
    }
}
