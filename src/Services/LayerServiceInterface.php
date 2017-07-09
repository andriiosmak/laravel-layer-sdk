<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services;
 */
interface LayerServiceInterface
{
    /**
     * Get an announcement service
     */
    public function getAnnouncementService();

    /**
     * Get a conversation service
     */
    public function getConversationService();

    /**
     * Get a message service
     */
    public function getMessageService();

    /**
     * Get a notification service
     */
    public function getNotificationService();

    /**
     * Get a user service
     */
    public function getUserService();

    /**
     * Get a user data service
     */
    public function getUserDataService();
}
