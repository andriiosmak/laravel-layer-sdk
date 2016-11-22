<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

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
     * @return bool
     */
    public function create(array $data, string $userId): bool
    {
        $response = $this->getRequestService()->makePostRequest($this->getRouter()->getURL($userId), $data);

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_CREATED);
    }

    /**
     * Update user details
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return bool
     */
    public function update(array $data, string $userId): bool
    {
        $response = $this->getRequestService()->makePatchRequest($this->getRouter()->getURL($userId), $data);

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_NO_CONTENT);
    }

    /**
     * Replace a user
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return bool
     */
    public function replace(array $data, string $userId): bool
    {
        $response = $this->getRequestService()->makePutRequest($this->getRouter()->getURL($userId), $data);

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_NO_CONTENT);
    }

    /**
     * Get user details
     *
     * @param string $userId user ID
     *
     * @return mixed
     */
    public function get(string $userId)
    {
        $response = $this->getRequestService()->makeGetRequest($this->getRouter()->getURL($userId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_OK, true);
    }

    /**
     * Delete a user
     *
     * @param string $userId user ID
     *
     * @return bool
     */
    public function delete(string $userId): bool
    {
        $response = $this->getRequestService()->makeDeleteRequest($this->getRouter()->getURL($userId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_NO_CONTENT);
    }

    /**
     * Create a badge
     *
     * @param array $data badge data
     * @param string $userId user ID
     *
     * @return bool
     */
    public function createBadge(array $data, string $userId): bool
    {
        $response = $this->getRequestService()->makePutRequest($this->getRouter()->getBadgeURL($userId), $data);

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_NO_CONTENT);
    }

    /**
     * Get user`s badges
     *
     * @param string $userId user ID
     *
     * @return mixed
     */
    public function getBadges(string $userId)
    {
        $response = $this->getRequestService()->makeGetRequest($this->getRouter()->getBadgeURL($userId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_OK, true);
    }

    /**
     * Update block list
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return bool
     */
    public function updateBlockList(array $data, string $userId): bool
    {
        $response = $this->getRequestService()
            ->makePatchRequest($this->getRouter()->getBlockListUpdateURL($userId), $data);

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_ACCEPTED);
    }

    /**
     * Get block list
     *
     * @param string $userId user ID
     *
     * @return mixed
     */
    public function getBlockList(string $userId)
    {
        $response = $this->getRequestService()->makeGetRequest($this->getRouter()->getBlockListURL($userId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_OK, true);
    }
}
