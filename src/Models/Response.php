<?php

namespace Aosmak\Laravel\Layer\Sdk\Models;

use Psr\Http\Message\ResponseInterface as GuzzleResponseInterface;

/**
 * Class Response
 * @package namespace Aosmak\Laravel\Layer\Sdk\Models
 */
class Response implements ResponseInterface
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
     * Headers
     *
     * @var array
     */
    private $headers;

    /**
     * Get status code
     *
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     */
    public function __construct(GuzzleResponseInterface $response)
    {
        $this->statusCode = $response->getStatusCode();
        $this->headers    = $response->getHeaders();
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
     * Get request headers
     *
     * @return array request headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Check whether a request was successful
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return ($this->statusCode >= 200 && $this->statusCode <= 299) ? true : false;
    }

    /**
     * Get an item ID
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
     * @param string $contents request contents
     *
     * @return array
     */
    private function obtainResponseContent(string $contents): array
    {
        if (strlen($contents) > 1) {
            $contents = json_decode($contents, 1);
            return is_array($contents) ? $contents: [];
        }

        return [];
    }
}
