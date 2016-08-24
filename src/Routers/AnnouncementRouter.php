<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class AnnouncementRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
class AnnouncementRouter extends BaseRouter
{
    /**
     * Get request URL
     *
     * @return string
     */
    public function getURL() : string
    {
        return $this->genereteURL(':app_id/announcements', []);
    }
}
