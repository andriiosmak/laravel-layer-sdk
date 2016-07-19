<?php

namespace Aosmak\Larevel\Layer\Sdk\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Aosmak\Larevel\Layer\Sdk\Models\ResponseStatus;

/**
 * Trait SetterTrait
 * @package namespace Aosmak\Larevel\Layer\Sdk\Traits;
 */
trait SetterTrait
{
    /**
     * Config
     *
     * @var array contains configuration variables
     */
    protected $config;

    /**
     * Guzzle client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Response Status object
     *
     * @var \Aosmak\Larevel\Layer\Sdk\Models\ResponseStatus
     */
    protected $responseStatus;

    /**
     * Last error
     *
     * @var array contains last error details
     */
    protected $lastError;

    /**
     * Response content
     *
     * @var array
     */
    protected $responseContent;

    /**
     * Set config
     *
     * @param array $config contains configuration variables
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
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
        $this->client = $client;
    }

    /**
     * Set response status object
     *
     * @param \Aosmak\Larevel\Layer\Sdk\Models\ResponseStatus $responseStatus
     *
     * @return void
     */
    public function setResponseStatus(ResponseStatus $responseStatus)
    {
        $this->responseStatus = $responseStatus;
    }

    /**
     * Set last layer exception
     *
     * @param \GuzzleHttp\Psr7\Response $response Guzzle response
     *
     * @return void
     */
    public function setResponseContent(Response $response)
    {
        $this->responseContent = $this->obtainResponseContent($response);
    }

    /**
     * Set last layer exception
     *
     * @return array
     */
    public function getResponseContent() : array
    {
        return $this->responseContent;
    }
}
