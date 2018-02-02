<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\IdentityServiceInterface;

/**
 * Class IdentityService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices
 */
class IdentityService extends BaseService implements IdentityServiceInterface
{
    /**
     * Create a identity
     *
     * @param array $data identity data
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data, string $identityId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'), $data);
    }

    /**
     * Update identity details
     *
     * @param array $data identity data
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function update(array $data, string $identityId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'), $data);
    }

    /**
     * Replace a identity
     *
     * @param array $data identity data
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function replace(array $data, string $identityId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'), $data);
    }

    /**
     * Get identity details
     *
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function get(string $identityId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'));
    }

    /**
     * Delete an identity
     *
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function delete(string $identityId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'));
    }
}
