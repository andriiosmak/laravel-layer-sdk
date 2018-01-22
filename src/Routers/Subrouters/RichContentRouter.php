<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class RichContentRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class RichContentRouter extends BaseRouter
{
    /**
     * Get a URL
     *
     * @param string $conversationId user ID
     * @param string $path path
     *
     * @return string
     */
    public function getUrl(string $conversationId, string $path = ''): string
    {
        $pattern = 'conversations/:conversation_id';
        if (!empty($path)) {
            $pattern = implode([
                $pattern,
                '/',
                $path
            ]);
        }

        return $this->genereteURL($pattern, [':conversation_id' => $conversationId]);
    }

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
        $pattern = 'conversations/:conversation_id/content/:content_id';

        return $this->genereteURL($pattern, [
            ':conversation_id' => $conversationId,
            ':content_id'      => $contentId
        ]);
    }
}
