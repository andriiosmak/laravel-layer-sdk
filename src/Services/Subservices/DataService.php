<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface;
use Aosmak\Laravel\Layer\Sdk\Services\Subservices\Interfaces\DataServiceInterface;

/**
 * Class DataService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices
 */
class DataService extends BaseService implements DataServiceInterface
{
    /**
     * Register public key
     *
     * @param string $key public key
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function registerPublicKey(string $key): ResponseInterface
    {
        $data = [
            'public_key' => $key
        ];

        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('export_security'), $data);
    }

    /**
     * Get public key
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getPublicKey(): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('export_security'));
    }

    /**
     * Request historical export
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function requestHistoricalExport(): ResponseInterface
    {
        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->getShortUrl('exports'));
    }

    /**
     * Track export status
     *
     * @param string $exportId export ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function trackExportStatus(string $exportId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('exports', $exportId, 'status'));
    }

    /**
     * Get exports
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getExports(): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('exports'));
    }

    /**
     * Configure scheduled export
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function configureScheduledExport(array $data): ResponseInterface
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->getShortUrl('export_schedule'), $data);
    }

    /**
     * Get export schedule configuration
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function getExportScheduleConfiguration(): ResponseInterface
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getShortUrl('export_schedule'));
    }

    /**
     * Delete export
     *
     * @param string $exportId export ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\ResponseInterface
     */
    public function deleteExport(string $exportId): ResponseInterface
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getShortUrl('exports', $exportId));
    }
}
