<?php

namespace Aosmak\Laravel\Layer\Sdk\Traits;

use GuzzleHttp\Psr7\Response;

/**
 * Trait ResponseContentTrait
 * @package namespace Aosmak\Laravel\Layer\Sdk\Traits;
 */
trait ResponseContentTrait
{
    /**
     * Response content
     *
     * @var array
     */
    protected $responseContent;

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
    public function getResponseContent(): array
    {
        return $this->responseContent;
    }
}
