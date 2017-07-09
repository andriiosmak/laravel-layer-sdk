<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class UserDataRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class UserDataRouter extends BaseRouter
{
    /**
     * Get user conversations URL
     *
     * @param string $userId user ID
     *
     * @return string
     */
    public function getConversationsURL(string $userId): string
    {
        return $this->genereteURL('users/:user_id/conversations', [':user_id' => $userId]);
    }

    /**
     * Send message URL
     *
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function sendMessagesURL(string $userId, string $conversationId): string
    {
        return $this->genereteURL('users/:user_id/conversations/:conversation_id/messages', [
            ':user_id'         => $userId,
            ':conversation_id' => $conversationId,
        ]);
    }

    /**
     * Get user message receipts URL
     *
     * @param string $userId user ID
     * @param string $messageId message ID
     *
     * @return string
     */
    public function getMessageReceiptsURL(string $userId, string $messageId): string
    {
        return $this->genereteURL('users/:user_id/messages/:message_id/receipts', [
            ':user_id'    => $userId,
            ':message_id' => $messageId,
        ]);
    }

    /**
     * Get a user message URL
     *
     * @param string $userId user ID
     * @param string $messageId message ID
     *
     * @return string
     */
    public function deleteMessageURL(string $userId, string $messageId): string
    {
        return $this->genereteURL('users/:user_id/messages/:message_id?mode=all_participants', [
            ':user_id'    => $userId,
            ':message_id' => $messageId,
        ]);
    }
}
