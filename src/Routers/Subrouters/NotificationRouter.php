<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class NotificationRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class NotificationRouter extends BaseRouter
{
    /**
     * Get a notification request URL
     *
     * @return string
     */
    public function getNotificationURL(): string
    {
        return $this->genereteURL('notifications', []);
    }
}
