<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Class ConversationService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices
 */
class ConversationService extends BaseService
{
    /**
     * Create a conversation
     *
     * @param array $data conversation data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function create(array $data): Response
    {
        //set default value
        if (!isset($data['distinct'])) {
            $data['distinct'] = true;
        }

        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->genereteURL('conversations', []), $data);
    }

    /**
     * Update a conversation
     *
     * @param array $data conversation data
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function update(array $data, string $conversationId): Response
    {
        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getUrl($conversationId), $data);
    }

    /**
     * Get conversation details
     *
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function get(string $conversationId): Response
    {
        return $this->getRequestService()->makeGetRequest($this->getRouter()->getUrl($conversationId));
    }

    /**
     * Delete a conversation
     *
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function delete(string $conversationId): Response
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getUrl($conversationId));
    }
}
