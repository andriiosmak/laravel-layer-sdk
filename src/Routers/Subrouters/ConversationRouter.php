<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class ConversationRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class ConversationRouter extends BaseRouter
{
    /**
     * Get a URL
     *
     * @param string $userId conversation ID
     * @param string $path path
     *
     * @return string
     */
    public function getUrl(string $conversationId, string $path = ''): string
    {
        $pattern = 'conversations/:conversationId';
        if (!empty($path)) {
            $pattern = implode([
                $pattern,
                '/',
                $path
            ]);
        }

        return $this->genereteURL($pattern, [':conversationId' => $conversationId]);
    }
}
