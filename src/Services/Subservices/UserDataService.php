<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

/**
 * Class UserDataService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class UserDataService extends BaseService
{
    /**
     * Get user conversations
     *
     * @param string $userId user ID
     *
     * @return array
     */
    public function getConversations(string $userId): ?array
    {
        $response = $this->getRequestService()->makeGetRequest($this->getRouter()->getConversationsURL($userId));

        return $this->getRequestService()->getResponse($response, $this->getResponseStatus()::HTTP_OK);
    }
}
