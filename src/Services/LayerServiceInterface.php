<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Laravel\Layer\Sdk;
 */
interface LayerServiceInterface
{
    /**
     * Get user service
     */
    public function getUserService();

    /**
     * Get conversation service
     */
    public function getConversationService();

    /**
     * Get message service
     */
    public function getMessageService();
}
