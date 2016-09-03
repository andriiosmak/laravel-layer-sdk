<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class BaseRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
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
     * Set application ID
     *
     * @param string $appId application ID
     *
     * @return void
     */
    public function setAppId(string $appId)
    {
        $this->appId = $appId;
    }
    
    /**
     * Generate request URL
     *
     * @param integer $id user ID
     * @param array $data user data
     *
     * @return string
     */
    public function genereteURL(string $url, array $data) : string
    {
        $data[':app_id'] = $this->appId;

        return str_replace(array_keys($data), $data, ':app_id/' . $url);
    }
}
