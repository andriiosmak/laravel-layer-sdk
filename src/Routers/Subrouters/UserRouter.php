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

    /**
     * Get badge request URL
     *
     * @param string $userId user ID
     *
     * @return string
     */
    public function getBadgeURL(string $userId): string
    {
        return $this->genereteURL('users/:user_id/badge', [':user_id' => $userId]);
    }

    /**
     * Get block list update URL
     *
     * @param string $ownerUserId owner user ID
     *
     * @return string
     */
    public function getBlockListUpdateURL(string $ownerUserId): string
    {
        return $this->genereteURL('users/:owner_user_id', [':owner_user_id' => $ownerUserId]);
    }

    /**
     * Get block list URL
     *
     * @param string $ownerUserId owner user ID
     *
     * @return string
     */
    public function getBlockListURL(string $ownerUserId): string
    {
        return $this->genereteURL('users/:owner_user_id/blocks', [':owner_user_id' => $ownerUserId]);
    }
}
