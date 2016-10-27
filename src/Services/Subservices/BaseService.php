<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter;

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
     * Response status
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService
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
     * Set Guzzle client
     *
     * @param \GuzzleHttp\Client $client
     *
     * @return void
     */
    public function setClient(Client $client)
    {
        $this->requestService->setClient($client);
    }

    /**
     * Set config
     *
     * @param array $config
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->requestService->setConfig($config);
    }

    /**
     * Get request service
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService
     */
    public function getRequestService()
    {
        return $this->requestService;
    }

    /**
     * Set router
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter $router
     *
     * @return void
     */
    public function setRouter(BaseRouter $router)
    {
        $this->router = $router;
    }

    /**
     * Get router
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Generate request URL
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

    /**
     * Get create item ID
     *
     * @return \GuzzleHttp\Psr7\Response $response
     * @return string $statusId
     * @return string $path
     *
     * @return mixed conversation ID
     */
    public function getCreateItemId(Response $response, string $statusId, string $path)
    {
        $responseObject = $this->requestService->getResponse($response, $statusId, true);
        if ($responseObject && isset($responseObject['id'])) {
            return explode('layer:///' . $path . '/', $responseObject['id'], 2)[1];
        }

        return false;
    }
}
