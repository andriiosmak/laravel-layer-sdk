<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;

/**
 * Interface DataServiceInterface
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces
 */
interface DataServiceInterface extends BaseServiceInterface
{
    /**
     * Register public key
     *
     * @param string $key public key
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function registerPublicKey(string $key): ResponseInterface;

    /**
     * Get public key
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getPublicKey(): ResponseInterface;

    /**
     * Request historical export
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function requestHistoricalExport(): ResponseInterface;

    /**
     * Track export status
     *
     * @param string $exportId export ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function trackExportStatus(string $exportId): ResponseInterface;

    /**
     * Get exports
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getExports(): ResponseInterface;

    /**
     * Configure scheduled export
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function configureScheduledExport(array $data): ResponseInterface;

    /**
     * Get export schedule configuration
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getExportScheduleConfiguration(): ResponseInterface;

    /**
     * Delete export
     *
     * @param string $exportId export ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function deleteExport(string $exportId): ResponseInterface;
}
