<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
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
     * Request service
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService
     */
    private $requestService;

    /**
     * Response status
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus
     */
    private $responseStatus;

    /**
     * Constructor
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService $requestService
     * @param \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus $responseStatus
     *
     * @return void
     */
    public function __construct(RequestService $requestService, ResponseStatus $responseStatus)
    {
        $this->requestService = $requestService;
        $this->responseStatus = $responseStatus;
    }

    /**
     * Get a response status model
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus
     */
    public function getResponseStatus(): ResponseStatus
    {
        return $this->responseStatus;
    }

    /**
     * Set a Guzzle client
     *
     * @param \GuzzleHttp\Client $client
     *
     * @return void
     */
    public function setClient(Client $client): void
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
     * @return \Aosmak\Laravel\Layer\Sdk\Services\Subservices\RequestService
     */
    public function getRequestService(): RequestService
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

    /**
     * Get an item ID
     *
     * @return \GuzzleHttp\Psr7\Response $response
     * @return string $statusId
     * @return string $path
     *
     * @return mixed conversation ID
     */
    public function getCreateItemId(Response $response, string $statusId, string $path): ?string
    {
        $responseObject = $this->requestService->getResponse($response, $statusId);
        if ($responseObject && isset($responseObject['id'])) {
            return explode('layer:///' . $path . '/', $responseObject['id'], 2)[1];
        }

        return null;
    }
}
