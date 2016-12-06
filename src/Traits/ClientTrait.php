<?php

declare(strict_types=1);

namespace Aosmak\Laravel\Layer\Sdk\Traits;

use GuzzleHttp\Client;

/**
 * Trait ClientTrait
 * @package namespace Aosmak\Laravel\Layer\Sdk\Traits;
 */
trait ClientTrait
{
    /**
     * Guzzle client
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Set Guzzle client
     *
     * @param \GuzzleHttp\Client $client
     *
     * @return void
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
