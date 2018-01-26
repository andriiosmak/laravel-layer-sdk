<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface UserDataServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;
 */
interface UserDataServiceInterface
{
    /**
     * Get user conversations
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getConversations(string $userId): ResponseInterface;

    /**
     * Send a message
     *
     * @param array $data request data
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function sendMessage(array $data, string $userId, string $conversationId): ResponseInterface;

    /**
     * Send a receipt
     *
     * @param array $data request data
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function sendReceipt(string $type, string $userId, string $messageId): ResponseInterface;

    /**
     * Delete a message
     *
     * @param string $userId user ID
     * @param string $messageId conversation ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function deleteMessage(string $userId, string $messageId): ResponseInterface;
}
