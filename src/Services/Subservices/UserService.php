<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\UserServiceInterface;

/**
 * Class UserService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class UserService extends BaseService implements UserServiceInterface
{
    /**
     * Create a user
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data, string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->getShortUrl('users', $userId, 'identity'), $data);
    }

    /**
     * Update user details
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function update(array $data, string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getShortUrl('users', $userId, 'identity'), $data);
    }

    /**
     * Replace a user
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function replace(array $data, string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('users', $userId, 'identity'), $data);
    }

    /**
     * Get user details
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function get(string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $userId, 'identity'));
    }

    /**
     * Delete a user
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function delete(string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getShortUrl('users', $userId, 'identity'));
    }

    /**
     * Create a badge
     *
     * @param array $data badge data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function createBadge(array $data, string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('users', $userId, 'badge'), $data);
    }

    /**
     * Get user`s badges
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getBadges(string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $userId, 'badge'));
    }

    /**
     * Update block list
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function updateBlockList(array $data, string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getShortUrl('users', $userId), $data);
    }

    /**
     * Get block list
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getBlockList(string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $userId, 'blocks'));
    }

    /**
     * Set suspended property
     *
     * @param string $userId user ID
     * @param bool $value user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function suspend(string $userId, bool $value): ResponseInterface
    {
        $data = [
            [
                'operation' => 'set',
                'property'  => 'suspended',
                'value'     => $value
            ]
        ];

        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getShortUrl('users', $userId), $data);
    }

    /**
     * Set TTL in seconds
     *
     * @param bool $value user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function setTtl(int $value): ResponseInterface
    {
        $data = [
            [
                'operation' => 'set',
                'property'  => 'session_ttl_in_seconds',
                'value'     => $value
            ]
        ];

        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->genereteURL('', []), $data);
    }

    /**
     * Get suspension status
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getGetSuspensionStatus(string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $userId));
    }

    /**
     * Delete a user
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function deleteSessions(string $userId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getShortUrl('users', $userId, 'sessions'));
    }
}
