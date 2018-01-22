<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class MessageRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class MessageRouter extends BaseRouter
{
    /**
     * Get a message URL
     *
     * @param string $messageId message ID
     * @param string $conversationId user ID
     *
     * @return string
     */
    public function getMessageURL(string $messageId, string $conversationId): string
    {
        return $this->genereteURL('conversations/:conversation_id/messages/:message_id', [
            ':conversation_id' => $conversationId,
            ':message_id'      => $messageId
        ]);
    }

    /**
     * Get a conversation URL
     *
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function getConversationURL(string $conversationId): string
    {
        return $this->genereteURL('conversations/:conversation_id/messages', [
            ':conversation_id' => $conversationId
        ]);
    }
}
