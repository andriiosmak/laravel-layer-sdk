<?php

namespace Aosmak\Layer\Routers;

/**
 * Class AnnouncementRouter
 * @package namespace Aosmak\Layer\Routers;
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
        $data = [
            ':app_id' => $this->config['LAYER_SDK_APP_ID'],
        ];

        return $this->genereteURL(':app_id/announcements', $data);
    }
}
