<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

/**
 * Class UserDataService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class UserDataService extends BaseService
{
    /**
     * Get user conversations
     *
     * @param string $userId user ID
     *
     * @return array
     */
    public function getConversations(string $userId): ?array
    {
        $response = $this->getRequestService()->makeGetRequest($this->getRouter()->getConversationsURL($userId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_OK);
    }

    /**
     * Send a message
     *
     * @param array $data request data
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return array
     */
    public function sendMessage(array $data, string $userId, string $conversationId): ?array
    {
        $response = $this->getRequestService()
            ->makePostRequest($this->getRouter()->sendMessagesURL($userId, $conversationId), $data);

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_CREATED);
    }

    /**
     * Send a receipt
     *
     * @param array $data request data
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return array
     */
    public function sendReceipt(string $type, string $userId, string $messageId): ?array
    {
        $response = $this->getRequestService()
            ->makePostRequest(
                $this->getRouter()->getMessageReceiptsURL($userId, $messageId), [
                    'type' => $type
                ]);

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_NO_CONTENT);
    }

    /**
     * Delete a message
     *
     * @param string $userId user ID
     * @param string $messageId conversation ID
     *
     * @return array
     */
    public function deleteMessage(string $userId, string $messageId): ?array
    {
        $response = $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->deleteMessageURL($userId, $messageId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_NO_CONTENT);
    }
}
