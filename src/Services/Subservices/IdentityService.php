<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Class IdentityService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class IdentityService extends BaseService
{
    /**
     * Create a identity
     *
     * @param array $data identity data
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function create(array $data, string $identityId): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function update(array $data, string $identityId): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function replace(array $data, string $identityId): Response
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'), $data);
    }

    /**
     * Get identity details
     *
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function get(string $identityId): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'));
    }

    /**
     * Delete a identity
     *
     * @param string $identityId identity ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function delete(string $identityId): Response
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getShortUrl('users', $identityId, 'identity'));
    }
}
