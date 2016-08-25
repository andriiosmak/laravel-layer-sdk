<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Laravel\Layer\Sdk;
 */
interface LayerServiceInterface
{
    /**
     * Get conversation service
     */
    public function getConversationService();

    /**
     * Get message service
     */
    public function getMessageService();

    /**
     * Get user service
     */
    public function getUserService();
}
