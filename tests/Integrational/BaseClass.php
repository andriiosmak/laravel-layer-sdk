<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Services\LayerService;
use Illuminate\Container\Container;

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
    public function setUp()
    {
        $container = new Container;
        $service   = $container->make('Aosmak\Laravel\Layer\Sdk\Services\LayerService');
        $service->setConfig([
            'LAYER_SDK_APP_ID'           => env('LAYER_SDK_APP_ID'),
            'LAYER_SDK_AUTH'             => env('LAYER_SDK_AUTH'),
            'LAYER_SDK_BASE_URL'         => env('LAYER_SDK_BASE_URL'),
            'LAYER_SDK_SHOW_HTTP_ERRORS' => false,
        ]);
        $this->service = $service;
    }

    /**
     * Get a user service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\User\UserService
     */
    public function getUserService()
    {
        return $this->service->getUserService();
    }

    /**
     * Get a conversation service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Conversation\ConversationService
     */
    public function getConversationService()
    {
        return $this->service->getConversationService();
    }

    /**
     * Get a message service
     *
     * @return Aosmak\Laravel\Layer\Sdk\Services\Message\MessageService
     */
    public function getMessageService()
    {
        return $this->service->getMessageService();
    }
}