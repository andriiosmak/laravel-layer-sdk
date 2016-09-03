<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class ConversationRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class ConversationRouter extends BaseRouter
{
    /**
     * Get conversation request URL
     *
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function getConversationURL(string $conversationId) : string
    {
        return $this->genereteURL('conversations/:conversation_uuid', [':conversation_uuid' => $conversationId]);
    }

    /**
     * Get conversations request URL
     *
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function getConversationsURL(string $userId) : string
    {
        return $this->genereteURL('users/:user_id/conversations', [':user_id' => $userId]);
    }

    /**
     * Get request URL
     *
     * @return string
     */
    public function getURL() : string
    {
        return $this->genereteURL('conversations', []);
    }
}
