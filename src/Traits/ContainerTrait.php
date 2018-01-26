<?php

namespace Aosmak\Laravel\Layer\Sdk\Traits;

use Illuminate\Contracts\Container\Container;

/**
 * Trait ContainerTrait
 * @package namespace Aosmak\Laravel\Layer\Sdk\Traits
 */
trait ContainerTrait
{
    /**
     * Container
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * Set Container
     *
     * @param \Illuminate\Contracts\Container\Container
     *
     * @return void
     */
    public function setContainer(Container $container): void
    {
        $this->container = $container;
    }
}
