<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\ConversationServiceInterface;

/**
 * Class ConversationService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices
 */
class ConversationService extends BaseService implements ConversationServiceInterface
{
    /**
     * Create a conversation
     *
     * @param array $data conversation data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data): ResponseInterface
    {
        //set default value
        if (!isset($data['distinct'])) {
            $data['distinct'] = true;
        }

        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->getShortUrl('conversations'), $data);
    }

    /**
     * Update a conversation
     *
     * @param array $data conversation data
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function update(array $data, string $conversationId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getShortUrl('conversations', $conversationId), $data);
    }

    /**
     * Get conversation details
     *
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function get(string $conversationId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('conversations', $conversationId));
    }

    /**
     * Delete a conversation
     *
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function delete(string $conversationId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getShortUrl('conversations', $conversationId));
    }
}
