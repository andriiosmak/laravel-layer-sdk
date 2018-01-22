<?php

namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;

/**
 * Class DataRouter
 * @package namespace Aosmak\Laravel\Layer\Sdk\Routers\Subrouters;
 */
class DataRouter extends BaseRouter
{
    /**
     * Get a URL
     *
     * @param string $exportId export ID
     * @param string $path path
     *
     * @return string
     */
    public function getExportUrl(string $exportId, string $path = ''): string
    {
        $pattern = 'exports/:exportId';
        if (!empty($path)) {
            $pattern = implode([
                $pattern,
                '/',
                $path
            ]);
        }

        return $this->genereteURL($pattern, [':exportId' => $exportId]);
    }
}
