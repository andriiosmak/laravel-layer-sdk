<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Class NotificationService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class NotificationService extends BaseService
{
    /**
     * Create a notification
     *
     * @param array $data notification data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function create(array $data): Response
    {
        return $this->getRequestService()->makePostRequest($this->getRouter()->getNotificationURL(), $data);
    }
}
