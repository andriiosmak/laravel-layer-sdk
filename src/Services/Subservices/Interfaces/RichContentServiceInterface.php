<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface RichContentServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces
 */
interface RichContentServiceInterface
{
    /**
     * Request rich content upload
     *
     * @param string $conversationId conversation ID
     * @param string $url file URL
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function requestUpload(string $conversationId, string $path): ?ResponseInterface;

    /**
     * Upload a file
     *
     * @param string $uploadUrl upload URL
     * @param string $url file URL
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function uploadFile(string $uploadUrl, string $path): ?ResponseInterface;

    /**
     * Send message that contains rich content
     *
     * @param string $conversationId conversation ID
     * @param string $data data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function sendUpload(string $conversationId, array $data): ResponseInterface;

    /**
     * Refresh URL
     *
     * @param string $conversationId conversation ID
     * @param string $contentId content item ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function refreshUrl(string $conversationId, string $contentId): ResponseInterface;
}
