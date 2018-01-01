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
        return $this->getRequestService()->makePostRequest($this->getRouter()->getURL($userId), $data);
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
        return $this->getRequestService()->makePatchRequest($this->getRouter()->getURL($userId), $data);
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
        return $this->getRequestService()->makePutRequest($this->getRouter()->getURL($userId), $data);
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
        return $this->getRequestService()->makeGetRequest($this->getRouter()->getURL($userId));
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
        return $this->getRequestService()->makeDeleteRequest($this->getRouter()->getURL($userId));
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
        return $this->getRequestService()->makePutRequest($this->getRouter()->getBadgeURL($userId), $data);
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
        return $this->getRequestService()->makeGetRequest($this->getRouter()->getBadgeURL($userId));
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
            ->makePatchRequest($this->getRouter()->getBlockListUpdateURL($userId), $data);
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
        return $this->getRequestService()->makeGetRequest($this->getRouter()->getBlockListURL($userId));
    }
}
