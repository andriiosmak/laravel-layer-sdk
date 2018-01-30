<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;

/**
 * Class DataServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class DataServiceTest extends BaseClass
{
    /**
     * Report ID
     *
     * @var string
     */
    public static $reportId;

    /**
     * Test public key registration
     *
     * @return void
     */
    public function testRegisterPublicKey(): void
    {
        $response = $this->getDataService()->registerPublicKey(
            file_get_contents(dirname(__FILE__) . '/../TestFiles/publickey')
        );
        $content = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('public_key', $content);

        $response = $this->getDataService()->registerPublicKey('wrongKey');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }

    /**
     * Test public key obtaining
     *
     * @return void
     */
    public function testGetPublicKey(): void
    {
        $response = $this->getDataService()->getPublicKey();
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('public_key', $content);
    }

    /**
     * Request historical export
     *
     * @return void
     */
    public function testRequestHistoricalExport(): void
    {
        $response = $this->getDataService()->requestHistoricalExport();
        if ($response->getStatusCode() === ResponseStatus::HTTP_ACCEPTED) {
            $content  = $response->getContents();
            $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
            $this->assertTrue($response->isSuccessful());
            $this->assertEquals(
                ResponseStatus::HTTP_ACCEPTED,
                $response->getStatusCode()
            ); //202
            $this->assertInternalType('array', $content);
            $this->assertArrayHasKey('id', $content);
            $this->assertArrayHasKey('type', $content);
            $this->assertArrayHasKey('public_key', $content);
            $this->assertArrayHasKey('status', $content);
            $this->assertArrayHasKey('created_at', $content);
            $this->assertArrayHasKey('started_at', $content);
            $this->assertArrayHasKey('completed_at', $content);
            $this->assertArrayHasKey('expired_at', $content);
            $this->assertArrayHasKey('download_url', $content);
            $this->assertArrayHasKey('download_url_expires_at', $content);
            $this->assertArrayHasKey('encrypted_aes_key', $content);
            $this->assertArrayHasKey('aes_iv', $content);
            $this->assertArrayHasKey('status_url', $content);
        } else {
            $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
            $this->assertFalse($response->isSuccessful());
            $this->assertEquals(
                ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
                $response->getStatusCode()
            ); //422
        }
    }

    /**
     * Get exports
     *
     * @return void
     */
    public function testGetExports(): void
    {
        $response      = $this->getDataService()->getExports();
        $content       = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        if (!empty($content)) {
            $this->assertArrayHasKey('aes_iv', $content[0]);
            $this->assertArrayHasKey('completed_at', $content[0]);
            $this->assertArrayHasKey('created_at', $content[0]);
            $this->assertArrayHasKey('download_url', $content[0]);
            $this->assertArrayHasKey('download_url_expires_at', $content[0]);
            $this->assertArrayHasKey('encrypted_aes_key', $content[0]);
            $this->assertArrayHasKey('expired_at', $content[0]);
            $this->assertArrayHasKey('id', $content[0]);
            $this->assertArrayHasKey('public_key', $content[0]);
            $this->assertArrayHasKey('started_at', $content[0]);
            $this->assertArrayHasKey('status', $content[0]);
            $this->assertArrayHasKey('status_url', $content[0]);
            $this->assertArrayHasKey('type', $content[0]);
            self::$reportId = $content[0]['id'];
        }
    }

    /**
     * Track export status
     *
     * @return void
     */
    public function testTrackExportStatus(): void
    {
        if (!empty(self::$reportId)) {
            $response = $this->getDataService()->trackExportStatus(self::$reportId);
            $content  = $response->getContents();
            $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
            $this->assertTrue($response->isSuccessful());
            $this->assertEquals(
                ResponseStatus::HTTP_OK,
                $response->getStatusCode()
            ); //200
            $this->assertInternalType('array', $content);
            $this->assertArrayHasKey('aes_iv', $content);
            $this->assertArrayHasKey('completed_at', $content);
            $this->assertArrayHasKey('created_at', $content);
            $this->assertArrayHasKey('download_url', $content);
            $this->assertArrayHasKey('download_url_expires_at', $content);
            $this->assertArrayHasKey('encrypted_aes_key', $content);
            $this->assertArrayHasKey('expired_at', $content);
            $this->assertArrayHasKey('id', $content);
            $this->assertArrayHasKey('public_key', $content);
            $this->assertArrayHasKey('started_at', $content);
            $this->assertArrayHasKey('status', $content);
            $this->assertArrayHasKey('status_url', $content);
            $this->assertArrayHasKey('type', $content);
        }

        $response = $this->getDataService()->trackExportStatus('09c97940-d9a8-11e5-921b-0242ac110029');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }

    /**
     * Test scheduled export configuration
     *
     * @return void
     */
    public function testConfigureScheduledExport(): void
    {
        $data = [
            "interval" => "daily",
            "events"   => [
                "message.sent",
                "message.delivered",
                "message.read",
                "message.deleted",
                "conversation.created",
                "conversation.updated.participants",
                "conversation.updated.metadata",
                "conversation.deleted"
            ]
        ];

        $response = $this->getDataService()->configureScheduledExport($data);
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('interval', $content);
        $this->assertArrayHasKey('events', $content);
        $this->assertArrayHasKey('last_export_at', $content);
        $this->assertArrayHasKey('last_export_id', $content);
        $this->assertArrayHasKey('next_export_at', $content);
    }

    /**
     * Test get export schedule config
     *
     * @return void
     */
    public function testGetExportScheduleConfiguration(): void
    {
        $response = $this->getDataService()->getExportScheduleConfiguration();
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('interval', $content);
        $this->assertArrayHasKey('last_export_at', $content);
        $this->assertArrayHasKey('last_export_id', $content);
        $this->assertArrayHasKey('next_export_at', $content);
    }

    /**
     * Test delete export
     *
     * @return void
     */
    public function testDeleteExport(): void
    {
        $response = $this->getDataService()->deleteExport('09c97940-d9a8-11e5-921b-0242ac110029');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }
}
