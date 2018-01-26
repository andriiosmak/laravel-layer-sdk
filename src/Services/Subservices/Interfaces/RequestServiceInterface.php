<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface RequestService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;
 */
interface RequestServiceInterface
{
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
