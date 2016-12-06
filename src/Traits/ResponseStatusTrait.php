<?php

namespace Aosmak\Laravel\Layer\Sdk\Traits;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Trait ResponseStatusTrait
 * @package namespace Aosmak\Laravel\Layer\Sdk\Traits;
 */
trait ResponseStatusTrait
{
    /**
     * Response Status object
     *
     * @var \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus
     */
    protected $responseStatus;

    /**
     * Set response status object
     *
     * @param \Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus $responseStatus
     *
     * @return void
     */
    public function setResponseStatus(ResponseStatus $responseStatus): void
    {
        $this->responseStatus = $responseStatus;
    }
}
