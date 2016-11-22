<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services;
 */
interface LayerServiceInterface
{
    /**
     * Get a conversation service
     */
    public function getConversationService();

    /**
     * Get a message service
     */
    public function getMessageService();

    /**
     * Get a user service
     */
    public function getUserService();
}
