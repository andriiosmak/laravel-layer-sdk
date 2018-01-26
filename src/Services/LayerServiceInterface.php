<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\AnnouncementServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\ConversationServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\IdentityServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserDataServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RichContentServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\MessageServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\NotificationServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\DataServiceInterface;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services;
 */
interface LayerServiceInterface
{
    /**
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\ConversationServiceInterface
     */
    public function getConversationService(): ConversationServiceInterface;

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageServiceInterface\MessageService
     */
    public function getMessageService(): MessageServiceInterface;

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserServiceInterface
     */
    public function getUserService(): UserServiceInterface;

    /**
     * Get an identity service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\IdentityServiceInterface
     */
    public function getIdentityService(): IdentityServiceInterface;

    /**
     * Get a user data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserDataServiceInterface
     */
    public function getUserDataService(): UserDataServiceInterface;

    /**
     * Get an announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\AnnouncementServiceInterface
     */
    public function getAnnouncementService(): AnnouncementServiceInterface;

    /**
     * Get a notification service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\NotificationServiceInterface
     */
    public function getNotificationService(): NotificationServiceInterface;

    /**
     * Get a data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\DataServiceInterface
     */
    public function getDataService(): DataServiceInterface;

    /**
     * Get a rich content service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RichContentServiceInterface
     */
    public function getRichContentService(): RichContentServiceInterface;
}
