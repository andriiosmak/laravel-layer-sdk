<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserDataServiceInterface;

/**
 * Class UserDataService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class UserDataService extends BaseService implements UserDataServiceInterface
{
    /**
     * Get user conversations
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getConversations(string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $userId, 'conversations'));
    }

    /**
     * Send a message
     *
     * @param array $data request data
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function sendMessage(array $data, string $userId, string $conversationId): ResponseInterface
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function sendReceipt(string $type, string $userId, string $messageId): ResponseInterface
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function deleteMessage(string $userId, string $messageId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->deleteMessageURL($userId, $messageId));
    }
}
