<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use GuzzleHttp\ClientInterface;
use Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface;

/**
 * Interface BaseServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;
 */
interface BaseServiceInterface
{
    /**
     * Set a Guzzle client
     *
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return void
     */
    public function setClient(ClientInterface $client): void;

    /**
     * Set a request service
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface $requestService
     *
     * @return void
     */
    public function setRequestService(RequestServiceInterface $requestService): void;

    /**
     * Set a configuration array
     *
     * @param array $config
     *
     * @return void
     */
    public function setConfig(array $config): void;
    /**
     * Set a router
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface $router
     *
     * @return void
     */
    public function setRouter(RouterInterface $router): void;

    /**
     * Get a request service
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestServiceInterface
     */
    public function getRequestService(): RequestServiceInterface;

    /**
     * Get a router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface
     */
    public function getRouter(): RouterInterface;

    /**
     * Generate a request URL
     *
     * @param integer $id user ID
     * @param array $data user data
     *
     * @return string
     */
    public function genereteURL(string $url, array $data): string;
}
