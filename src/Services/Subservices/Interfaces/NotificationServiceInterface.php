<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface NotificationServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;
 */
interface NotificationServiceInterface
{
    /**
     * Create a notification
     *
     * @param array $data notification data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data): ResponseInterface;
}
