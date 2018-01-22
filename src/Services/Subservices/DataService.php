<?php

namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;

use Aosmak\Laravel\Layer\Sdk\Models\Response;

/**
 * Class DataService
 * @package namespace Aosmak\Laravel\Layer\Sdk\Services\Subservices;
 */
class DataService extends BaseService
{
    /**
     * Register public key
     *
     * @param string $key public key
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function registerPublicKey(string $key): Response
    {
        $data = [
            'public_key' => $key
        ];

        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->genereteURL('export_security', []), $data);
    }

    /**
     * Get public key
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function getPublicKey(): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->genereteURL('export_security', []));
    }

    /**
     * Request historical export
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function requestHistoricalExport(): Response
    {
        return $this->getRequestService()
            ->makePostRequest($this->getRouter()->genereteURL('exports', []));
    }

    /**
     * Track export status
     *
     * @param string $exportId export ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function trackExportStatus(string $exportId): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->getExportUrl($exportId, 'status'));
    }

    /**
     * Get exports
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function getExports(): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->genereteURL('exports', []));
    }

    /**
     * Configure scheduled export
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function configureScheduledExport(array $data): Response
    {
        return $this->getRequestService()
            ->makePutRequest($this->getRouter()->genereteURL('export_schedule', []), $data);
    }

    /**
     * Get export schedule configuration
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function getExportScheduleConfiguration(): Response
    {
        return $this->getRequestService()
            ->makeGetRequest($this->getRouter()->genereteURL('export_schedule', []));
    }

    /**
     * Delete export
     *
     * @param string $exportId export ID
     *
     * @return \Aosmak\Laravel\Layer\Sdk\Models\Response
     */
    public function deleteExport(string $exportId): Response
    {
        return $this->getRequestService()
            ->makeDeleteRequest($this->getRouter()->getExportUrl($exportId));
    }
}
