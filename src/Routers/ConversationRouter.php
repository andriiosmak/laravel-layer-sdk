<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class ConversationRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class ConversationRouter extends BaseRouter
{
    /**
     * Get conversation request URL
     *
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function getConversationURL(string $conversationId) : string
    {
        $data = [
            ':app_id'            => $this->config['LAYER_SDK_APP_ID'],
            ':conversation_uuid' => $conversationId
        ];

        return $this->genereteURL(':app_id/conversations/:conversation_uuid', $data);
    }

    /**
     * Get conversations request URL
     *
     * @param string $conversationId conversation ID
     *
     * @return string
     */
    public function getConversationsURL(string $userId) : string
    {
        $data = [
            ':app_id'  => $this->config['LAYER_SDK_APP_ID'],
            ':user_id' => $userId
        ];

        return $this->genereteURL(':app_id/users/:user_id/conversations', $data);
    }

    /**
     * Get request URL
     *
     * @return string
     */
    public function getURL() : string
    {
        $data = [
            ':app_id' => $this->config['LAYER_SDK_APP_ID'],
        ];

        return $this->genereteURL(':app_id/conversations', $data);
    }
}
