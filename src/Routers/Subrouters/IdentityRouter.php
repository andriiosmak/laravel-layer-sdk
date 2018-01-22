<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class IdentityRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class IdentityRouter extends BaseRouter
{
    /**
     * Get a URL
     *
     * @param string $identityId identity ID
     *
     * @return string
     */
    public function getUrl(string $identityId): string
    {
        $pattern = 'users/:identity_id/identity';
        if (!empty($path)) {
            $pattern = implode([
                $pattern,
                '/',
                $path
            ]);
        }

        return $this->genereteURL($pattern, [':identity_id' => $identityId]);
    }
}
