<?php

namespace Aosmak\Laravel\Layer\Sdk\Traits;

/**
 * Trait ConfigTrait
 * @package namespace Aosmak\Laravel\Layer\Sdk\Traits
 */
trait ConfigTrait
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
    public function setConfig(array $config): void
    {
        $this->config = $config;
    }
}
