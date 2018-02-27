<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface IdentityServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces
 */
interface IdentityServiceInterface extends BaseServiceInterface
{
    /**
     * Create a identity
     *
     * @param array $data identity data
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data, string $identityId): ResponseInterface;

    /**
     * Update identity details
     *
     * @param array $data identity data
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function update(array $data, string $identityId): ResponseInterface;

    /**
     * Replace a identity
     *
     * @param array $data identity data
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function replace(array $data, string $identityId): ResponseInterface;

    /**
     * Get identity details
     *
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function get(string $identityId): ResponseInterface;

    /**
     * Delete a identity
     *
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function delete(string $identityId): ResponseInterface;
}
