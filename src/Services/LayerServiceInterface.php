<?php

namespace Aosmak\Larevel\Layer\Sdk\Services;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Larevel\Layer\Sdk;
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
