<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class RichContentRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class RichContentRouter extends BaseRouter
{
    /**
     * Get a content URL
     *
     * @param string $conversationId user ID
     * @param string $contentId contentId content item ID
     *
     * @return string
     */
    public function getContentUrl(string $conversationId, string $contentId): string
    {
        return $this->genereteURL('conversations/:conversation_id/content/:content_id', [
            ':conversation_id' => $conversationId,
            ':content_id'      => $contentId
        ]);
    }
}
