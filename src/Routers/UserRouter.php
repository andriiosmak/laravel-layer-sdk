<?php

namespace Aosmak\Layer\Routers;

/**
 * Class UserRouter
 * @package namespace Aosmak\Layer\Routers;
 */
class UserRouter extends BaseRouter
{
    /**
     * Get request URL
     *
     * @param string $userId user ID
     *
     * @return string
     */
    public function getURL(string $userId) : string
    {
        $data = [
            ':app_id'  => $this->config['LAYER_APP_ID'],
            ':user_id' => $userId
        ];

        return $this->genereteURL(':app_id/users/:user_id/identity', $data);
    }
}
