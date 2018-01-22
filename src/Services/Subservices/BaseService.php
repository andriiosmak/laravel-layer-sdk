<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\ClientInterface;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface;

/**
 * Class BaseService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
abstract class BaseService
{
    /**
     * Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter
     */
    protected $router;

    /**
     * Request service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestServiceInterface
     */
    private $requestService;

    /**
     * Constructor
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService $requestService
     *
     * @return void
     */
    public function __construct(RequestService $requestService)
    {
        $this->requestService = $requestService;
    }

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
     * Set a configuration array
     *
     * @param array $config
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
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter $router
     *
     * @return void
     */
    public function setRouter(BaseRouter $router): void
    {
        $this->router = $router;
    }

    /**
     * Get a request service
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestServiceInterface
     */
    public function getRequestService(): RequestServiceInterface
    {
        return $this->requestService;
    }

    /**
     * Get a router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter
     */
    public function getRouter(): BaseRouter
    {
        return $this->router;
    }

    /**
     * Generate a request URL
     *
     * @param integer $id user ID
     * @param array $data user data
     *
     * @return string
     */
    public function genereteURL(string $url, array $data): string
    {
        return str_replace(array_keys($data), $data, $url);
    }
}
