<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use GuzzleHttp\ClientInterface;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface RequestServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces
 */
interface RequestServiceInterface
{
    /**
     * Set Guzzle client
     *
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return void
     */
    public function setClient(ClientInterface $client): void;

    /**
     * Set config
     *
     * @param array $config contains configuration variables
     *
     * @return void
     */
    public function setConfig(array $config): void;

    /**
     * Make a POST request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makePostRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface;

    /**
     * Make a PUT request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makePutRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface;

    /**
     * Make a PATCH request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makePatchRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface;

    /**
     * Make a GET request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makeGetRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface;

    /**
     * Make a DELETE request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makeDeleteRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface;
}
