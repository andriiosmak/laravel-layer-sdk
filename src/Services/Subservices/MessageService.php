<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\MessageServiceInterface;

/**
 * Class MessageService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class MessageService extends BaseService implements MessageServiceInterface
{
    /**
     * Send a message
     *
     * @param array $data conversation data
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data, string $conversationId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->getShortUrl('conversations', $conversationId, 'messages'), $data);
    }

    /**
     * Get all messages by a conversation ID
     *
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function all(string $conversationId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('conversations', $conversationId, 'messages'));
    }

    /**
     * Get a message by ID
     *
     * @param string $messageId message ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function get(string $messageId, string $conversationId): ResponseInterface
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function delete(string $messageId, string $conversationId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getMessageURL($messageId, $conversationId));
    }
}
