<?php

namespace Aosmak\Laravel\Layer\Sdk\Models;

/**
 * Interface ResponseInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Models
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
     * @return bool
     */
    public function isSuccessful(): bool;

    /**
     * Get an item ID
     *
     * @return string|null conversation ID
     */
    public function getCreatedItemId(): ?string;
}
