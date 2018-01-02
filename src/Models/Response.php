<?php

namespace Aosmak\Laravel\Layer\Sdk\Models;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Class Response
 * @package namespace Aosmak\Laravel\Layer\Sdk\Models;
 */
class Response
{
    /**
     * Request status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * Request content
     *
     * @var array
     */
    private $contents;

    /**
     * Get status code
     *
     * @return GuzzleHttp\Psr7\Response $response
     *
     * @return void
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->contents   = $this->obtainResponseContent($response->getBody()->getContents());
    }

    /**
     * Get status code
     *
     * @return int status code
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * Get request content
     *
     * @return array request content
     */
    public function getContents(): array
    {
        return $this->contents;
    }

    /**
     * Get an item ID
     *
     * @return string $statusId
     * @return string $path
     *
     * @return string|null conversation ID
     */
    public function getCreatedItemId(): ?string
    {
        if (!empty($this->contents['id']) && strpos($this->contents['id'], 'layer:///') !== false) {
            return substr(strrchr($this->contents['id'], '/'), 1);
        }

        return null;
    }

    /**
     * Get a response content
     *
     * @return string $contents
     *
     * @var array
     */
    private function obtainResponseContent(string $contents): array
    {
        if (strlen($contents) > 1) {
            return is_array(json_decode($contents, 1))? json_decode($contents, 1): [];
        }

        return [];
    }
}