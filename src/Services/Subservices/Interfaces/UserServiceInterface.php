<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface UserServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces
 */
interface UserServiceInterface
{
    /**
     * Create a user
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function create(array $data, string $userId): ResponseInterface;

    /**
     * Update user details
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function update(array $data, string $userId): ResponseInterface;

    /**
     * Replace a user
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function replace(array $data, string $userId): ResponseInterface;

    /**
     * Get user details
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function get(string $userId): ResponseInterface;

    /**
     * Delete a user
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function delete(string $userId): ResponseInterface;

    /**
     * Create a badge
     *
     * @param array $data badge data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function createBadge(array $data, string $userId): ResponseInterface;

    /**
     * Get user`s badges
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getBadges(string $userId): ResponseInterface;

    /**
     * Update block list
     *
     * @param array $data user data
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function updateBlockList(array $data, string $userId): ResponseInterface;

    /**
     * Get block list
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getBlockList(string $userId): ResponseInterface;

    /**
     * Set suspended property
     *
     * @param string $userId user ID
     * @param bool $value user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function suspend(string $userId, bool $value): ResponseInterface;

    /**
     * Set TTL in seconds
     *
     * @param bool $value user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function setTtl(int $value): ResponseInterface;

    /**
     * Get user status
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getUserStatus(string $userId): ResponseInterface;

    /**
     * Delete user sessions
     *
     * @param string $userId user ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function deleteSessions(string $userId): ResponseInterface;
}
