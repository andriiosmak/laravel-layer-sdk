<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use GuzzleHttp\ClientInterface;
use Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\BaseServiceInterface;

/**
 * Class BaseService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices
 */
abstract class BaseService implements BaseServiceInterface
{
    /**
     * Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface
     */
    protected $router;

    /**
     * Request service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface
     */
    private $requestService;

    /**
     * Set a Guzzle client
     *
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return void
     */
    public function setClient(ClientInterface $client): void
    {
        $this->requestService->setClient($client);
    }

    /**
     * Set a request service
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface $requestService
     *
     * @return void
     */
    public function setRequestService(RequestServiceInterface $requestService): void
    {
        $this->requestService = $requestService;
    }

    /**
     * Set a configuration array
     *
     * @param array $config configuration array
     *
     * @return void
     */
    public function setConfig(array $config): void
    {
        $this->requestService->setConfig($config);
    }

    /**
     * Set a router
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface $router router
     *
     * @return void
     */
    public function setRouter(RouterInterface $router): void
    {
        $this->router = $router;
    }

    /**
     * Get a request service
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface
     */
    public function getRequestService(): RequestServiceInterface
    {
        return $this->requestService;
    }

    /**
     * Get a router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }
}
