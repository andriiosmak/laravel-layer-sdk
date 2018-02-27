<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface AnnouncementServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces
 */
interface AnnouncementServiceInterface extends BaseServiceInterface
{
    /**
     * Create an announcement
     *
     * @param array $data announcement data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data): ResponseInterface;
}
