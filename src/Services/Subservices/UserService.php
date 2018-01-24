<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Class UserService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class UserService extends BaseService
{
    /**
     * Create a user
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function create(array $data, string $userId): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function update(array $data, string $userId): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function replace(array $data, string $userId): Response
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('users', $userId, 'identity'), $data);
    }

    /**
     * Get user details
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function get(string $userId): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $userId, 'identity'));
    }

    /**
     * Delete a user
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function delete(string $userId): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function createBadge(array $data, string $userId): Response
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('users', $userId, 'badge'), $data);
    }

    /**
     * Get user`s badges
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function getBadges(string $userId): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function updateBlockList(array $data, string $userId): Response
    {
        return $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getShortUrl('users', $userId), $data);
    }

    /**
     * Get block list
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function getBlockList(string $userId): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function suspend(string $userId, bool $value): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function setTtl(int $value): Response
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
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function getGetSuspensionStatus(string $userId): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('users', $userId));
    }

    /**
     * Delete a user
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function deleteSessions(string $userId): Response
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getShortUrl('users', $userId, 'sessions'));
    }
}
