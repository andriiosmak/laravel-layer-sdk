<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use GuzzleHttp\Psr7\Response;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ClientTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ResponseContentTrait;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class RequestService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class RequestService
{
    use ConfigTrait, ClientTrait, ResponseContentTrait;

    /**
     * Response status
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus
     */
    private $responseStatus;

    /**
     * Status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * Constructor
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus $responseStatus
     *
     * @return void
     */
    public function __construct(ResponseStatus $responseStatus)
    {
        $this->responseStatus = $responseStatus;
    }

    /**
     * Get status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
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
        $responseObject = $this->getResponse($response, $statusId);
        if ($responseObject && isset($responseObject['id'])) {
            return explode('layer:///' . $path . '/', $responseObject['id'], 2)[1];
        }

        return null;
    }


    /**
     * Get a response content
     *
     * @param \Guzzle\Psr7\Response $response Guzzle response
     *
     * @var array
     */
    public function obtainResponseContent(Response $response): array
    {
        $content = $response->getBody()->getContents();
        if (strlen($content) > 1) {
            return is_array(json_decode($content, 1))? json_decode($content, 1) : [];
        }

        return [];
    }

    /**
     * Make a POST request
     *
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
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
     * @return \Guzzle\Psr7\Response
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
     * @return \Guzzle\Psr7\Response
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
     * @return \Guzzle\Psr7\Response
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
     * @return \Guzzle\Psr7\Response
     */
    public function makeDeleteRequest(string $url, array $data = [], array $requestHeaders = []): Response
    {
        return $this->makeRequest('DELETE', $url, $data, $requestHeaders);
    }

    /**
     * Get a response
     *
     * @param \GuzzleHttp\Psr7\Response $result Guzzle response
     * @param int $successStatus success status
     *
     * @return mixed
     */
    public function getResponse(Response $result, int $successStatus): ?array
    {
        if ($result->getStatusCode() === $successStatus) {
            return $this->getResponseContent();
        }

        return null;
    }

    /**
     * Check a response
     *
     * @param \GuzzleHttp\Psr7\Response $result Guzzle response
     * @param int $successStatus success status
     *
     * @return bool
     */
    public function checkResponse(Response $result, int $successStatus): bool
    {
        return ($result->getStatusCode() === $successStatus)? true : false;
    }

    /**
     * Make a HTTP request
     *
     * @param string $method HTTP method
     * @param string $url request url
     * @param array $data request data
     * @param array $requestHeaders request headers
     *
     * @return \Guzzle\Psr7\Response
     */
    private function makeRequest(string $method, string $url, array $data, array $requestHeaders): Response
    {
        $defaultHeaders = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->config['LAYER_SDK_AUTH'],
                'Accept'        => 'application/vnd.layer+json; version=1.1',
                'Content-Type'  => 'application/json',
            ],
            'json'           => $data,
            'decode_content' => false,
            'http_errors'    => $this->config['LAYER_SDK_SHOW_HTTP_ERRORS'],
        ];

        $headers   = array_replace_recursive($defaultHeaders, $requestHeaders);
        $response  = $this->client->request($method, $this->config['LAYER_SDK_BASE_URL'] . $url, $headers);
        $this->statusCode = $response->getStatusCode();
        $this->setResponseContent($response);

        return $response;
    }
}
