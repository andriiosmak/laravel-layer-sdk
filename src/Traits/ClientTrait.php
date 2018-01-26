<?php

namespace Aosmak\Laravel\Layer\Sdk\Traits;

use GuzzleHttp\ClientInterface;

/**
 * Trait ClientTrait
 * @package namespace Aosmak\Laravel\Layer\Sdk\Traits
 */
trait ClientTrait
{
    /**
     * Guzzle client
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * Set Guzzle client
     *
     * @param \GuzzleHttp\ClientInterface $client
     *
     * @return void
     */
    public function setClient(ClientInterface $client): void
    {
        $this->client = $client;
    }
}
