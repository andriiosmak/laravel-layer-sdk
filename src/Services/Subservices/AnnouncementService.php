<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Class AnnouncementService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class AnnouncementService extends BaseService
{
    /**
     * Create an announcement
     *
     * @param array $data announcement data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data): ResponseInterface
    {
        return $this->getRequestService()->makePostRequest($this->getRouter()->getShortUrl('announcements'), $data);
    }
}
