<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class Router
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class Router
{
    /**
     * Announcement Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\AnnouncementRouter
     */
    private $announcementRouter;

    /**
     * Conversation Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\ConversationRouter
     */
    private $conversationRouter;

    /**
     * Message Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\MessageRouter
     */
    private $messageRouter;

    /**
     * User Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\UserRouter
     */
    private $userRouter;

    /**
     * Application ID
     *
     * @var string application ID
     */
    protected $appId;

    /**
     * Constructor
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\AnnouncementRouter $announcementRouter
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\ConversationRouter $conversationRouter
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\MessageRouter $messageRouter
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\UserRouter $userRouter
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
     * Set application ID
     *
     * @param string $appId application ID
     *
     * @return void
     */
    public function setAppId(string $appId)
    {
        $this->appId = $appId;
    }

    /**
     * Get Announcement Router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\AnnouncementRouter $announcementRouter
     */
    public function getAnnouncementRouter() : AnnouncementRouter
    {
        return $this->getRouter($this->announcementRouter);
    }

    /**
     * Get Conversation Router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\ConversationRouter $conversationRouter
     */
    public function getConversationRouter() : ConversationRouter
    {
        return $this->getRouter($this->conversationRouter);
    }

    /**
     * Get Message Router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\MessageRouter $messageRouter
     */
    public function getMessageRouter() : MessageRouter
    {
        return $this->getRouter($this->messageRouter);
    }

    /**
     * Get User Router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\UserRouter $userRouter
     */
    public function getUserRouter() : UserRouter
    {
        return $this->getRouter($this->userRouter);
    }

    /**
     * Get router
     *
     * @param Aosmak\Laravel\Layer\Sdk\Routers\BaseRouter $router
     *
     * @return Aosmak\Laravel\Layer\Sdk\Routers\BaseRouter $router
     */
    private function getRouter($router) : BaseRouter
    {
        $router->setAppId($this->appId);
        return $router;
    }
}
