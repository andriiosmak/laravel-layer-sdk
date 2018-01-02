<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function create(array $data): Response
    {
        return $this->getRequestService()->makePostRequest($this->getRouter()->getAnnouncementURL(), $data);
    }
}
