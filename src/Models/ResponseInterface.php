<?php

namespace Aosmak\Laravel\Layer\Sdk\Models;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * Interface ResponseInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Models;
 */
interface ResponseInterface
{
    /**
     * Get status code
     *
     * @return int status code
     */
    public function getStatusCode(): int;

    /**
     * Get request content
     *
     * @return array request content
     */
    public function getContents(): array;

    /**
     * Get request headers
     *
     * @return array request headers
     */
    public function getHeaders(): array;

    /**
     * Check whether a request was successful
     *
     * @return array request content
     */
    public function isSuccessful(): bool;

    /**
     * Get an item ID
     *
     * @return string $statusId
     * @return string $path
     *
     * @return string|null conversation ID
     */
    public function getCreatedItemId(): ?string;
}
