<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Services\LayerService;
use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService;

/**
 * Class BaseClass
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
abstract class BaseClass extends \PHPUnit_Framework_TestCase
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
    public function setUp() : void
    {
        if (file_exists(dirname(__FILE__) . '/config.php')) {
            $config = require(dirname(__FILE__) . '/config.php');
        } else {
            $config = [
                'LAYER_SDK_APP_ID'           => getenv('LAYER_SDK_APP_ID'),
                'LAYER_SDK_AUTH'             => getenv('LAYER_SDK_AUTH'),
                'LAYER_SDK_BASE_URL'         => getenv('LAYER_SDK_BASE_URL'),
                'LAYER_SDK_SHOW_HTTP_ERRORS' => false,
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
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\ConversationService
     */
    public function getConversationService() : ConversationService
    {
        return $this->service->getConversationService();
    }

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\MessageService
     */
    public function getMessageService() : MessageService
    {
        return $this->service->getMessageService();
    }

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Subservices\UserService
     */
    public function getUserService() : UserService
    {
        return $this->service->getUserService();
    }
}