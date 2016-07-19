<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers;

/**
 * Class BaseRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers;
 */
abstract class BaseRouter
{
    /**
     * Config
     *
     * @var array contains configuration variables
     */
    protected $config;

    /**
     * Set config
     *
     * @param array $config contains configuration variables
     *
     * @return void
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
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
        return str_replace(array_keys($data), $data, $url);
    }
}
