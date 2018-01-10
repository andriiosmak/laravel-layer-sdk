<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Illuminate\Container\Container;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ClientTrait;
use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Class RequestService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class RequestService
{
    use ConfigTrait, ClientTrait;

    /**
     * Constructor
     *
     * @param \Illuminate\Container\Container $container
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Make a POST request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makePostRequest(string $url, array $data = [], array $requestHeaders = []): Response
    {
        return $this->makeRequest('POST', $url, $data, $requestHeaders);
    }

    /**
     * Make a PUT request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makePutRequest(string $url, array $data = [], array $requestHeaders = []): Response
    {
        return $this->makeRequest('PUT', $url, $data, $requestHeaders);
    }

    /**
     * Make a PATCH request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makePatchRequest(string $url, array $data = [], array $requestHeaders = []): Response
    {
        $defaultHeaders = [
            'headers' => [
                'Content-Type' => 'application/vnd.layer-patch+json'
            ],
        ];

        $headers = array_replace_recursive($defaultHeaders, $requestHeaders);

        return $this->makeRequest('PATCH', $url, $data, $headers);
    }

    /**
     * Make a GET request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makeGetRequest(string $url, array $data = [], array $requestHeaders = []): Response
    {
        return $this->makeRequest('GET', $url, $data, $requestHeaders);
    }

    /**
     * Make a DELETE request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function makeDeleteRequest(string $url, array $data = [], array $requestHeaders = []): Response
    {
        return $this->makeRequest('DELETE', $url, $data, $requestHeaders);
    }

    /**
     * Make a HTTP request
     *
     * @param string $method HTTP method
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    private function makeRequest(string $method, string $url, array $data, array $requestHeaders): Response
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

        $headers  = array_replace_recursive($defaultHeaders, $requestHeaders);
        $response = $this->client->request($method, $this->config['LAYER_SDK_BASE_URL'] . $url, $headers);

        return $this->container->make('Aosmak\Laravel\Layer\Sdk\Models\Response', ['response' => $response]);
    }
}
