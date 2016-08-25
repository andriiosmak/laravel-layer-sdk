<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class MessageRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class MessageRouter extends BaseRouter
{
    /**
     * Get message URL (user perspective)
     *
     * @param string $messageId message ID
     * @param string $userId user ID
     *
     * @return string
     */
    public function getMessageUserURL(string $messageId, string $userId) : string
    {
        $data = [
            ':user_id'    => $userId,
            ':message_id' => $messageId
        ];

        return $this->genereteURL(':app_id/users/:user_id/messages/:message_id', $data);
    }

    /**
     * Get message URL (system perspective)
     *
     * @param string $messageId message ID
     * @param string $conversationId user ID
     *
     * @return string
     */
    public function getMessageSytemURL(string $messageId, string $conversationId) : string
    {
        $data = [
            ':conversation_id' => $conversationId,
            ':message_id'      => $messageId
        ];

        return $this->genereteURL(':app_id/conversations/:conversation_id/messages/:message_id', $data);
    }

    /**
     * Get conversation URL
     *
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function getConversationURL(string $conversationId) : string
    {
        $data = [
            ':conversation_id' => $conversationId
        ];

        return $this->genereteURL(':app_id/conversations/:conversation_id/messages', $data);
    }

    /**
     * Get conversation user URL
     *
     * @param string $conversationId conversation ID
     * @param string $userId user ID
     *
     * @return string
     */
    public function getConversationUserURL(string $conversationId, string $userId) : string
    {
        $data = [
            ':user_id'         => $userId,
            ':conversation_id' => $conversationId
        ];

        return $this->genereteURL(':app_id/users/:user_id/conversations/:conversation_id/messages', $data);
    }

    /**
     * Get announcement request URL
     *
     * @return string
     */
    public function getAnnouncementURL() : string
    {
        return $this->genereteURL(':app_id/announcements', []);
    }
}
