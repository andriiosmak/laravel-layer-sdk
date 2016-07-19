<?php

namespace Aosmak\Layer\Services;

use Aosmak\Layer\Services\Service;

/**
 * Class ConversationService
 * @package namespace Aosmak\Layer\Services;
 */
class ConversationService extends Service
{
    /**
     * Create a conversation
     *
     * @param array $data conversation data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        if (!isset($data['distinct'])) {
            $data['distinct'] = true;
        }

        $response = $this->makePostRequest($this->router->getURL(), $data);

        if ($this->getCreateItemId($response, 'HTTP_OK', 'conversations')) {
            $content = $this->getCreateItemId($response, 'HTTP_OK', 'conversations');
        } else {
            $content = $this->getCreateItemId($response, 'HTTP_CREATED', 'conversations');
        }

        return !empty($content)? $content : false;
    }

    /**
     * Update conversation details
     *
     * @param array $data conversation data
     * @param string $conversationId conversation ID
     *
     * @return bool
     */
    public function update(array $data, string $conversationId) : bool
    {
        $response = $this->makePatchRequest($this->router->getConversationURL($conversationId), $data);

        return $this->getResponse($response, 'HTTP_NO_CONTENT');
    }

    /**
     * Get conversation details
     *
     * @param string $conversationId conversation ID
     *
     * @return mixed
     */
    public function get(string $conversationId)
    {
        $response = $this->makeGetRequest($this->router->getConversationURL($conversationId));

        return $this->getResponse($response, 'HTTP_OK', true);
    }

    /**
     * Get all conversations by user ID
     *
     * @param string $userId user ID
     *
     * @return mixed
     */
    public function all(string $userId)
    {
        $response = $this->makeGetRequest($this->router->getConversationsURL($userId));

        return $this->getResponse($response, 'HTTP_OK', true);
    }

    /**
     * Delete a conversation
     *
     * @param string $conversationId conversation ID
     *
     * @return bool
     */
    public function delete(string $conversationId) : bool
    {
        $response = $this->makeDeleteRequest($this->router->getConversationURL($conversationId));

        return $this->getResponse($response, 'HTTP_NO_CONTENT');
    }
}
