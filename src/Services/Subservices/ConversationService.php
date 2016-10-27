<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

/**
 * Class ConversationService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class ConversationService extends BaseService
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
        //set default value
        if (!isset($data['distinct'])) {
            $data['distinct'] = true;
        }

        $response = $this->getRequestService()->makePostRequest($this->getRouter()->getURL(), $data);

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
    public function update(array $data, string $conversationId): bool
    {
        $response = $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getConversationURL($conversationId), $data);

        return $this->getRequestService()->getResponse($response, 'HTTP_NO_CONTENT');
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
        $response = $this->getRequestService()->makeGetRequest($this->getRouter()->getConversationURL($conversationId));

        return $this->getRequestService()->getResponse($response, 'HTTP_OK', true);
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
        $response = $this->getRequestService()->makeGetRequest($this->getRouter()->getConversationsURL($userId));

        return $this->getRequestService()->getResponse($response, 'HTTP_OK', true);
    }

    /**
     * Delete a conversation
     *
     * @param string $conversationId conversation ID
     *
     * @return bool
     */
    public function delete(string $conversationId): bool
    {
        $response = $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getConversationURL($conversationId));

        return $this->getRequestService()->getResponse($response, 'HTTP_NO_CONTENT');
    }
}
