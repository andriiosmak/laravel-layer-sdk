<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

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
     * @return mixed
     */
    public function create(array $data): ?string
    {
        $response = $this->getRequestService()->makePostRequest($this->getRouter()->getAnnouncementURL(), $data);

        return $this->getRequestService()
            ->getCreateItemId($response, $this->getResponseStatus()::HTTP_ACCEPTED, 'announcements');
    }
}
