<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use GuzzleHttp\Psr7\Response;

/**
 * Class MessageService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services;
 */
class MessageService extends Service
{
    /**
     * Send a message
     *
     * @param array $data conversation data
     * @param string $conversationId conversation ID
     *
     * @return mixed
     */
    public function create(array $data, string $conversationId)
    {
        $response = $this->makePostRequest($this->router->getConversationURL($conversationId), $data);

        return $this->getCreateItemId($response, 'HTTP_CREATED', 'messages');
    }

    /**
     * Get messages (user perspective)
     *
     * @param string $conversationId conversation ID
     * @param string $userId user ID
     *
     * @return mixed
     */
    public function allLikeUser(string $conversationId, string $userId)
    {
        $response = $this->makeGetRequest($this->router->getConversationUserURL($conversationId, $userId));

        return $this->getResponse($response, 'HTTP_OK', true);
    }

    /**
     * Get messages (system perspective)
     *
     * @param string $conversationId conversation ID
     *
     * @return mixed
     */
    public function allLikeSystem(string $conversationId)
    {
        $response = $this->makeGetRequest($this->router->getConversationURL($conversationId));

        return $this->getResponse($response, 'HTTP_OK', true);
    }

    /**
     * Get message (user perspective)
     *
     * @param string $messageId message ID
     * @param string $userId user ID
     *
     * @return mixed
     */
    public function getLikeUser(string $messageId, string $userId)
    {
        $response = $this->makeGetRequest($this->router->getMessageUserURL($messageId, $userId));

        return $this->getResponse($response, 'HTTP_OK', true);
    }

    /**
     * Get message (system perspective)
     *
     * @param string $messageId message ID
     * @param string $conversationId conversation ID
     *
     * @return mixed
     */
    public function getLikeSystem(string $messageId, string $conversationId)
    {
        $response = $this->makeGetRequest($this->router->getMessageSytemURL($messageId, $conversationId));

        return $this->getResponse($response, 'HTTP_OK', true);
    }

    /**
     * Delete a message
     *
     * @param string $messageId message ID
     * @param string $conversationId conversation ID
     *
     * @return bool
     */
    public function delete(string $messageId, string $conversationId) : bool
    {
        $response = $this->makeDeleteRequest($this->router->getMessageSytemURL($messageId, $conversationId));

        return $this->getResponse($response, 'HTTP_NO_CONTENT');
    }
}
