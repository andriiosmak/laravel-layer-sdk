<?php

namespace Aosmak\Laravel\Layer\Sdk\Services;

use Aosmak\Laravel\Layer\Sdk\Services\Subservices\BaseService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\IdentityService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserDataService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\RichContentService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\DataService;

/**
 * Interface LayerServiceInterface.
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services;
 */
interface LayerServiceInterface
{
    /**
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    public function getConversationService(): ConversationService;

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    public function getMessageService(): MessageService;

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    public function getUserService(): UserService;

    /**
     * Get an identity service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\IdentityService
     */
    public function getIdentityService(): IdentityService;

    /**
     * Get a user data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserDataService
     */
    public function getUserDataService(): UserDataService;

    /**
     * Get an announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\AnnouncementService
     */
    public function getAnnouncementService(): AnnouncementService;

    /**
     * Get a notification service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\NotificationService
     */
    public function getNotificationService(): NotificationService;

    /**
     * Get a data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\DataService
     */
    public function getDataService(): DataService;

    /**
     * Get a rich content service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\RichContentService
     */
    public function getRichContentService(): RichContentService;
}
