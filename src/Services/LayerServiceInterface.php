<?php

namespace Aosmak\Layer\Services;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Layer;
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
