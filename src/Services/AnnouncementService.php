<?php

namespace Aosmak\Larevel\Layer\Sdk\Services;

use Aosmak\Larevel\Layer\Sdk\Services\Service;

/**
 * Class AnnouncementService
 * @package namespace Aosmak\Larevel\Layer\Sdk\Services;
 */
class AnnouncementService extends Service
{
    /**
     * Create an announcement
     *
     * @param array $data announcement data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        $response = $this->makePostRequest($this->router->getURL(), $data);

        return $this->getCreateItemId($response, 'HTTP_ACCEPTED', 'announcements');
    }
}
