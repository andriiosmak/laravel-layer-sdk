<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Services\LayerService;
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
 * Class BaseClass
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
abstract class BaseClass extends TestCase
{
    /**
     * Layer Service
     *
     * @var Aosmak\Laravel\Layer\Sdk\Services\LayerService
     */
    public $service;

    /**
     * Set up Layer Service
     *
     * @return void
     */
    public function setUp(): void
    {
        if (file_exists(dirname(__FILE__) . '/config.php')) {
            $config = require(dirname(__FILE__) . '/config.php');
        } else {
            $config = [
                'LAYER_SDK_APP_ID'           => getenv('LAYER_SDK_APP_ID'),
                'LAYER_SDK_AUTH'             => getenv('LAYER_SDK_AUTH'),
                'LAYER_SDK_BASE_URL'         => getenv('LAYER_SDK_BASE_URL'),
                'LAYER_SDK_API_VERSION'      => '3.0',
                'LAYER_SDK_SHOW_HTTP_ERRORS' => false
            ];
        }

        $container = new Container;
        $service   = $container->make('Aosmak\Laravel\Layer\Sdk\Services\LayerService');
        $service->setConfig($config);
        $this->service = $service;
    }

    /**
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\ConversationService
     */
    public function getConversationService(): ConversationServiceInterface
    {
        return $this->service->getConversationService();
    }

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\MessageService
     */
    public function getMessageService(): MessageServiceInterface
    {
        return $this->service->getMessageService();
    }

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserService
     */
    public function getUserService(): UserServiceInterface
    {
        return $this->service->getUserService();
    }

    /**
     * Get an identity service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\IdentityService
     */
    public function getIdentityService(): IdentityServiceInterface
    {
        return $this->service->getIdentityService();
    }

    /**
     * Get a user data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserDataService
     */
    public function getUserDataService(): UserDataServiceInterface
    {
        return $this->service->getUserDataService();
    }

    /**
     * Get an announcement service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\AnnouncementService
     */
    public function getAnnouncementService(): AnnouncementServiceInterface
    {
        return $this->service->getAnnouncementService();
    }

    /**
     * Get a notification service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\NotificationService
     */
    public function getNotificationService(): NotificationServiceInterface
    {
        return $this->service->getNotificationService();
    }

    /**
     * Get a data service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\DataService
     */
    public function getDataService(): DataServiceInterface
    {
        return $this->service->getDataService();
    }

    /**
     * Get a rich content service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RichContentService
     */
    public function getRichContentService(): RichContentServiceInterface
    {
        return $this->service->getRichContentService();
    }
}
