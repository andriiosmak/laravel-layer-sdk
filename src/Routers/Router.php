<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter;

/**
 * Class Router
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class Router implements RouterInterface
{
    /**
     * Container
     *
     * @var \Illuminate\Container\Container
     */
    private $container;

    /**
     * Application ID
     *
     * @var string application ID
     */
    protected $appId;

    /**
     * Set an application ID
     *
     * @param string $appId application ID
     *
     * @return void
     */
    public function setAppId(string $appId): void
    {
        $this->appId = $appId;
    }

    /**
     * Set an Container
     *
     * @param \Illuminate\Container\Container $container
     *
     * @return void
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }

    /**
     * Generate a request URL
     *
     * @param integer $id user ID
     * @param array $data user data
     *
     * @return string
     */
    public function genereteURL(string $url, array $data): string
    {
        $data[':app_id'] = $this->appId;

        if (!empty($url)) {
            $url = '/' . $url;
        }

        return str_replace(array_keys($data), $data, ':app_id' . $url);
    }

    /**
     * Get a URL
     *
     * @param string $pattern base uri pattern
     * @param string $entityId entity ID
     * @param string $path path
     *
     * @return string
     */
    public function getShortUrl(string $pattern, string $entityId = null, string $path = null): string
    {
        $data = [];

        if (!empty($entityId)) {
            $data    = [':entity_id' => $entityId];
            $pattern = implode([$pattern, '/:entity_id']);
        }

        if (!empty($path)) {
            $pattern = implode([
                $pattern,
                '/',
                $path
            ]);
        }

        return $this->genereteURL($pattern, [':entity_id' => $entityId]);
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
        return $this->genereteURL('conversations/:conversation_id/content/:content_id', [
            ':conversation_id' => $conversationId,
            ':content_id'      => $contentId
        ]);
    }

    /**
     * Send message URL
     *
     * @param string $userId user ID
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function sendMessagesURL(string $userId, string $conversationId): string
    {
        return $this->genereteURL('users/:user_id/conversations/:conversation_id/messages', [
            ':user_id'         => $userId,
            ':conversation_id' => $conversationId,
        ]);
    }

    /**
     * Get user message receipts URL
     *
     * @param string $userId user ID
     * @param string $messageId message ID
     *
     * @return string
     */
    public function getMessageReceiptsURL(string $userId, string $messageId): string
    {
        return $this->genereteURL('users/:user_id/messages/:message_id/receipts', [
            ':user_id'    => $userId,
            ':message_id' => $messageId,
        ]);
    }

    /**
     * Get a user message URL
     *
     * @param string $userId user ID
     * @param string $messageId message ID
     *
     * @return string
     */
    public function deleteMessageURL(string $userId, string $messageId): string
    {
        return $this->genereteURL('users/:user_id/messages/:message_id?mode=all_participants', [
            ':user_id'    => $userId,
            ':message_id' => $messageId,
        ]);
    }

    /**
     * Get a message URL
     *
     * @param string $messageId message ID
     * @param string $conversationId user ID
     *
     * @return string
     */
    public function getMessageURL(string $messageId, string $conversationId): string
    {
        return $this->genereteURL('conversations/:conversation_id/messages/:message_id', [
            ':conversation_id' => $conversationId,
            ':message_id'      => $messageId
        ]);
    }
}
