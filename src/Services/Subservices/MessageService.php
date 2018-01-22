<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Class MessageService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class MessageService extends BaseService
{
    /**
     * Send a message
     *
     * @param array $data conversation data
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function create(array $data, string $conversationId): Response
    {
        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->getConversationURL($conversationId), $data);
    }

    /**
     * Get all messages by a conversation ID
     *
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function all(string $conversationId): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getConversationURL($conversationId));
    }

    /**
     * Get a message by ID
     *
     * @param string $messageId message ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function get(string $messageId, string $conversationId): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getMessageURL($messageId, $conversationId));
    }

    /**
     * Delete a message
     *
     * @param string $messageId message ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function delete(string $messageId, string $conversationId): Response
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getMessageURL($messageId, $conversationId));
    }
}
