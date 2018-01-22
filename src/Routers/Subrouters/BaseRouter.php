<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class BaseRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
abstract class BaseRouter
{
    /**
     * Application ID
     *
     * @var string application ID
     */
    protected $appId;

    /**
     * Set an application ID
     *
     * @param string $appId application ID
     *
     * @return void
     */
    public function setAppId(string $appId): void
    {
        $this->appId = $appId;
    }

    /**
     * Generate a request URL
     *
     * @param integer $id user ID
     * @param array $data user data
     *
     * @return string
     */
    public function genereteURL(string $url, array $data): string
    {
        $data[':app_id'] = $this->appId;

        if (!empty($url)) {
            $url = '/' . $url;
        }

        return str_replace(array_keys($data), $data, ':app_id' . $url);
    }
}
