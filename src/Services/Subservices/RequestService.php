<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ClientTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ContainerTrait;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\RequestServiceInterface;

/**
 * Class RequestService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class RequestService implements RequestServiceInterface
{
    use ConfigTrait, ClientTrait, ContainerTrait;

    /**
     * Make a POST request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makePostRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface
    {
        return $this->prepareRequest('POST', $url, $data, $requestHeaders);
    }

    /**
     * Make a PUT request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makePutRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface
    {
        return $this->prepareRequest('PUT', $url, $data, $requestHeaders);
    }

    /**
     * Make a PATCH request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makePatchRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface
    {
        $defaultHeaders = [
            'headers' => [
                'Content-Type' => 'application/vnd.layer-patch+json'
            ],
        ];

        $headers = array_replace_recursive($defaultHeaders, $requestHeaders);

        return $this->prepareRequest('PATCH', $url, $data, $headers);
    }

    /**
     * Make a GET request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makeGetRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface
    {
        return $this->prepareRequest('GET', $url, $data, $requestHeaders);
    }

    /**
     * Make a DELETE request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makeDeleteRequest(string $url, array $data = [], array $requestHeaders = []): ResponseInterface
    {
        return $this->prepareRequest('DELETE', $url, $data, $requestHeaders);
    }

    /**
     * Prepare a HTTP request
     *
     * @param string $method HTTP method
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    private function prepareRequest(string $method, string $url, array $data, array $requestHeaders): ResponseInterface
    {
        $defaultHeaders = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config['LAYER_SDK_AUTH'],
                'Accept'        => 'application/vnd.layer+json; version=' . $this->config['LAYER_SDK_API_VERSION'],
                'Content-Type'  => 'application/json',
            ],
            'json'           => $data,
            'decode_content' => false,
            'http_errors'    => $this->config['LAYER_SDK_SHOW_HTTP_ERRORS'],
        ];

        $headers = array_replace_recursive($defaultHeaders, $requestHeaders);
        $url     = $this->config['LAYER_SDK_BASE_URL'] . $url;

        return $this->makeRequest($method, $url, $headers);
    }

    /**
     * Make a HTTP request
     *
     * @param string $method HTTP method
     * @param string $url request url
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function makeRequest(string $method, string $url, array $headers): ResponseInterface
    {
        $response = $this->client->request($method, $url, $headers);

        return $this->container->make('Aosmak\Laravel\Layer\Sdk\Models\Response', ['response' => $response]);
    }

    /**
     * Upload file request
     *
     * @param string $url request url
     * @param string $path file path
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function uploadFile(string $url, string $path)
    {
        $headers = [
            'multipart' => [
                [
                    'name'     => 'file',
                    'contents' => file_get_contents($path)
                ]
            ],
        ];

        return $this->makeRequest('POST', $url, $headers);
    }
}
