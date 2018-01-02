<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function getConversations(string $userId): Response
    {
        return $this->getRequestService()->makeGetRequest($this->getRouter()->getConversationsURL($userId));
    }

    /**
     * Send a message
     *
     * @param array $data request data
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function sendMessage(array $data, string $userId, string $conversationId): Response
    {
        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->sendMessagesURL($userId, $conversationId), $data);
    }

    /**
     * Send a receipt
     *
     * @param array $data request data
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function sendReceipt(string $type, string $userId, string $messageId): Response
    {
        return $this->getRequestService()
            ->makePostRequest(
                $this->getRouter()->getMessageReceiptsURL($userId, $messageId),
                ['type' => $type]
            );
    }

    /**
     * Delete a message
     *
     * @param string $userId user ID
     * @param string $messageId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function deleteMessage(string $userId, string $messageId): Response
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->deleteMessageURL($userId, $messageId));
    }
}
