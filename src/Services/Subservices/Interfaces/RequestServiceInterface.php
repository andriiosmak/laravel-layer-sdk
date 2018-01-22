<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Interface RequestService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makePostRequest(string $url, array $data = [], array $requestHeaders = []): Response;

    /**
     * Make a PUT request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makePutRequest(string $url, array $data = [], array $requestHeaders = []): Response;

    /**
     * Make a PATCH request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makePatchRequest(string $url, array $data = [], array $requestHeaders = []): Response;

    /**
     * Make a GET request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makeGetRequest(string $url, array $data = [], array $requestHeaders = []): Response;

    /**
     * Make a DELETE request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makeDeleteRequest(string $url, array $data = [], array $requestHeaders = []): Response;
}
