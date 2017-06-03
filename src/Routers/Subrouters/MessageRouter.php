<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class MessageRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class MessageRouter extends BaseRouter
{
    /**
     * Get a message URL (user perspective)
     *
     * @param string $messageId message ID
     * @param string $userId user ID
     *
     * @return string
     */
    public function getMessageUserURL(string $messageId, string $userId): string
    {
        return $this->genereteURL('users/:user_id/messages/:message_id', [
            ':user_id'    => $userId,
            ':message_id' => $messageId
        ]);
    }

    /**
     * Get a message URL (system perspective)
     *
     * @param string $messageId message ID
     * @param string $conversationId user ID
     *
     * @return string
     */
    public function getMessageSytemURL(string $messageId, string $conversationId): string
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
        return $this->genereteURL('conversations/:conversation_id/messages', [':conversation_id' => $conversationId]);
    }

    /**
     * Get a conversation user URL
     *
     * @param string $conversationId conversation ID
     * @param string $userId user ID
     *
     * @return string
     */
    public function getConversationUserURL(string $conversationId, string $userId): string
    {
        return $this->genereteURL('users/:user_id/conversations/:conversation_id/messages', [
            ':user_id'         => $userId,
            ':conversation_id' => $conversationId,
        ]);
    }

    /**
     * Get a notification request URL
     *
     * @return string
     */
    public function getNotificationURL(): string
    {
        return $this->genereteURL('notifications', []);
    }
}
