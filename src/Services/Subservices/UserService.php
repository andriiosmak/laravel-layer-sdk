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
        $response = $this->getRequestService()->makePostRequest($this->router->getURL($userId), $data);

        return $this->getRequestService()->getResponse($response, 'HTTP_CREATED');
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
        $response = $this->getRequestService()->makePatchRequest($this->router->getURL($userId), $data);

        return $this->getRequestService()->getResponse($response, 'HTTP_NO_CONTENT');
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
        $response = $this->getRequestService()->makePutRequest($this->router->getURL($userId), $data);

        return $this->getRequestService()->getResponse($response, 'HTTP_NO_CONTENT');
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
        $response = $this->getRequestService()->makeGetRequest($this->router->getURL($userId));

        return $this->getRequestService()->getResponse($response, 'HTTP_OK', true);
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
        $response = $this->getRequestService()->makeDeleteRequest($this->router->getURL($userId));

        return $this->getRequestService()->getResponse($response, 'HTTP_NO_CONTENT');
    }
}
