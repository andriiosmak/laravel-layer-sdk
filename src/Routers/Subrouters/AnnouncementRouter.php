<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class AnnouncementRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class AnnouncementRouter extends BaseRouter
{
    /**
     * Get an announcement request URL
     *
     * @return string
     */
    public function getAnnouncementURL(): string
    {
        return $this->genereteURL('announcements', []);
    }
}
