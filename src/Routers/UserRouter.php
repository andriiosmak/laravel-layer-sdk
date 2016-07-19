<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class UserRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
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
            ':app_id'  => $this->config['LAYER_SDK_APP_ID'],
            ':user_id' => $userId
        ];

        return $this->genereteURL(':app_id/users/:user_id/identity', $data);
    }
}
