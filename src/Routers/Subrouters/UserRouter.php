<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class UserRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class UserRouter extends BaseRouter
{
    /**
     * Get a URL
     *
     * @param string $userId user ID
     * @param string $path path
     *
     * @return string
     */
    public function getUrl(string $userId, string $path = ''): string
    {
        $pattern = 'users/:user_id';
        if (!empty($path)) {
            $pattern = implode([
                $pattern,
                '/',
                $path
            ]);
        }

        return $this->genereteURL($pattern, [':user_id' => $userId]);
    }
}
