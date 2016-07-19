<?php

namespace Aosmak\Layer\Routers;

/**
 * Class Router
 * @package namespace Aosmak\Layer\Routers;
 */
class Router
{
    /**
     * Announcement Router
     *
     * @var \Aosmak\Layer\Routers\AnnouncementRouter
     */
    private $announcementRouter;

    /**
     * Conversation Router
     *
     * @var \Aosmak\Layer\Routers\ConversationRouter
     */
    private $conversationRouter;

    /**
     * Message Router
     *
     * @var \Aosmak\Layer\Routers\MessageRouter
     */
    private $messageRouter;

    /**
     * User Router
     *
     * @var \Aosmak\Layer\Routers\UserRouter
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
     * @param \Aosmak\Layer\Routers\AnnouncementRouter $announcementRouter
     * @param \Aosmak\Layer\Routers\ConversationRouter $conversationRouter
     * @param \Aosmak\Layer\Routers\MessageRouter $messageRouter
     * @param \Aosmak\Layer\Routers\UserRouter $userRouter
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
     * @return \Aosmak\Layer\Routers\AnnouncementRouter $announcementRouter
     */
    public function getAnnouncementRouter() : AnnouncementRouter
    {
        return $this->getRouter($this->announcementRouter);
    }

    /**
     * Get Conversation Router
     *
     * @return \Aosmak\Layer\Routers\ConversationRouter $conversationRouter
     */
    public function getConversationRouter() : ConversationRouter
    {
        return $this->getRouter($this->conversationRouter);
    }

    /**
     * Get Message Router
     *
     * @return \Aosmak\Layer\Routers\MessageRouter $messageRouter
     */
    public function getMessageRouter() : MessageRouter
    {
        return $this->getRouter($this->messageRouter);
    }

    /**
     * Get User Router
     *
     * @return \Aosmak\Layer\Routers\UserRouter $userRouter
     */
    public function getUserRouter() : UserRouter
    {
        return $this->getRouter($this->userRouter);
    }

    /**
     * Get router
     *
     * @param Aosmak\Layer\Routers\BaseRouter $router
     *
     * @return Aosmak\Layer\Routers\BaseRouter $router
     */
    private function getRouter($router) : BaseRouter
    {
        $router->setConfig($this->config);
        return $router;
    }
}
