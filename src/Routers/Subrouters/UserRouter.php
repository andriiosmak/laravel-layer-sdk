<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class UserRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
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
    public function getURL(string $userId): string
    {
        return $this->genereteURL('users/:user_id/identity', [':user_id' => $userId]);
    }
}
