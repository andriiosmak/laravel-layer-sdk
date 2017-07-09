<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

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
     * @return mixed
     */
    public function create(array $data, string $conversationId): ?string
    {
        $response = $this->getRequestService()
            ->makePostRequest($this->getRouter()->getConversationURL($conversationId), $data);

        return $this->getRequestService()
            ->getCreateItemId($response, $this->getResponseStatus()::HTTP_CREATED, 'messages');
    }

    /**
     * Get messages (system perspective)
     *
     * @param string $conversationId conversation ID
     *
     * @return mixed
     */
    public function allLikeSystem(string $conversationId): ?array
    {
        $response = $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getConversationURL($conversationId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_OK);
    }

    /**
     * Get a message (system perspective)
     *
     * @param string $messageId message ID
     * @param string $conversationId conversation ID
     *
     * @return mixed
     */
    public function getLikeSystem(string $messageId, string $conversationId): ?array
    {
        $response = $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getMessageSytemURL($messageId, $conversationId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_OK);
    }

    /**
     * Delete a message
     *
     * @param string $messageId message ID
     * @param string $conversationId conversation ID
     *
     * @return bool
     */
    public function delete(string $messageId, string $conversationId): bool
    {
        $response = $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getMessageSytemURL($messageId, $conversationId));

        return $this->getRequestService()->checkResponse($response, $this->getResponseStatus()::HTTP_NO_CONTENT);
    }
}
