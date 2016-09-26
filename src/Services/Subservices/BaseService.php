<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use GuzzleHttp\Psr7\Response;
use Aosmak\Laravel\Layer\Sdk\Traits\ConfigTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ClientTrait;
use Aosmak\Laravel\Layer\Sdk\Traits\ResponseContentTrait;
use Aosmak\Laravel\Layer\Sdk\Routers\Subrouters\BaseRouter;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use Aosmak\Laravel\Layer\Sdk\Routers\Router;

/**
 * Class BaseService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
abstract class BaseService
{
    use ConfigTrait, ClientTrait, ResponseContentTrait;

    /**
     * Router
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Routers\Router
     */
    protected $router;

    /**
     * Response status
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus
     */
    private $responseStatus;

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
     * Get layer response content
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
     * Make POST request
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
     * Make PUT request
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
     * Make PATCH request
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
     * Make GET request
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
     * Make DELETE request
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
     * Get response
     *
     * @param \GuzzleHttp\Psr7\Response $result Guzzle response
     * @param string $successStatus success status
     * @param boolean $returnContent should method return content or not
     *
     * @return mixed
     */
    public function getResponse(Response $result, string $successStatus, bool $returnContent = false)
    {
        $statusCode = $this->responseStatus->getStatusCode($successStatus);
        if ($result->getStatusCode() === $statusCode) {
            if ($returnContent) {
                return $this->getResponseContent();
            }

            return true;
        }

        return false;
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
        $responseObject = $this->getResponse($response, $statusId, true);
        if ($responseObject && isset($responseObject['id'])) {
            return explode('layer:///' . $path . '/', $responseObject['id'], 2)[1];
        }

        return false;
    }

    /**
     * Make HTTP request
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
                'Accept'        => 'application/vnd.layer+json; version=1.0',
                'Content-Type'  => 'application/json',
            ],
            'json'           => $data,
            'decode_content' => false,
            'http_errors'    => $this->config['LAYER_SDK_SHOW_HTTP_ERRORS'],
        ];

        $headers  = array_replace_recursive($defaultHeaders, $requestHeaders);
        $response = $this->client->request($method, $this->config['LAYER_SDK_BASE_URL'] . $url, $headers);
        $this->setResponseContent($response);

        return $response;
    }
}
