<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Interface RouterInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
interface RouterInterface
{
    /**
     * Set an application ID
     *
     * @param string $appId application ID
     *
     * @return void
     */
    public function setAppId(string $appId): void;

    /**
     * Generate a request URL
     *
     * @param integer $id user ID
     * @param array $data user data
     *
     * @return string
     */
    public function genereteURL(string $url, array $data): string;

    /**
     * Get a URL
     *
     * @param string $pattern base uri pattern
     * @param string $entityId entity ID
     * @param string $path path
     *
     * @return string
     */
    public function getShortUrl(string $pattern, string $entityId = null, string $path = null): string;

    /**
     * Get a content URL
     *
     * @param string $conversationId user ID
     * @param string $contentId contentId content item ID
     *
     * @return string
     */
    public function getContentUrl(string $conversationId, string $contentId): string;

    /**
     * Send message URL
     *
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function sendMessagesURL(string $userId, string $conversationId): string;

    /**
     * Get user message receipts URL
     *
     * @param string $userId user ID
     * @param string $messageId message ID
     *
     * @return string
     */
    public function getMessageReceiptsURL(string $userId, string $messageId): string;

    /**
     * Get a user message URL
     *
     * @param string $userId user ID
     * @param string $messageId message ID
     *
     * @return string
     */
    public function deleteMessageURL(string $userId, string $messageId): string;

    /**
     * Get a message URL
     *
     * @param string $messageId message ID
     * @param string $conversationId user ID
     *
     * @return string
     */
    public function getMessageURL(string $messageId, string $conversationId): string;
}
