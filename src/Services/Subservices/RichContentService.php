<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class RichContentService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class RichContentService extends BaseService
{
    /**
     * Request rich content upload
     *
     * @param string $conversationId conversation ID
     * @param string $url file URL
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function requestUpload(string $conversationId, string $path): ?Response
    {
        $headers['headers'] = [
            'Upload-Content-Type'   => mime_content_type($path),
            'Upload-Content-Length' => filesize($path) + 161,
        ];

        return $this->getRequestService()->makePostRequest(
            $this->getRouter()->getShortUrl('conversations', $conversationId, 'content'),
            [],
            $headers
        );
    }

    /**
     * Upload a file
     *
     * @param string $uploadUrl upload URL
     * @param string $url file URL
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function uploadFile(string $uploadUrl, string $path): ?Response
    {
        return $this->getRequestService()->uploadFile(
            $uploadUrl,
            $path
        );
    }

    /**
     * Send message that contains rich content
     *
     * @param string $conversationId conversation ID
     * @param string $data data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function sendUpload(string $conversationId, array $data): Response
    {
        return $this->getRequestService()->makePostRequest(
            $this->getRouter()->getShortUrl('conversations', $conversationId, 'messages'),
            $data
        );
    }

    /**
     * Refresh URL
     *
     * @param string $conversationId conversation ID
     * @param string $contentId content item ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function refreshUrl(string $conversationId, string $contentId): Response
    {
        return $this->getRequestService()->makeGetRequest(
            $this->getRouter()->getContentUrl($conversationId, $contentId)
        );
    }
}
