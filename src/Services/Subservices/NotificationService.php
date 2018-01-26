<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\NotificationServiceInterface;

/**
 * Class NotificationService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class NotificationService extends BaseService implements NotificationServiceInterface
{
    /**
     * Create a notification
     *
     * @param array $data notification data
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data): ResponseInterface
    {
        return $this->getRequestService()->makePostRequest($this->getRouter()->getShortUrl('notifications'), $data);
    }
}
