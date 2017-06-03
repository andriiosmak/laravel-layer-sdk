<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

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
     * @return mixed
     */
    public function create(array $data): ?string
    {
        $response = $this->getRequestService()->makePostRequest($this->getRouter()->getNotificationURL(), $data);

        return $this->getRequestService()
            ->getCreateItemId($response, $this->getResponseStatus()::HTTP_ACCEPTED, 'notifications');
    }
}
