<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\Response;
use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class AnnouncementServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class AnnouncementServiceTest extends BaseClass
{
    /**
     * Test announcement creation
     *
     * @return void
     */
    public function testCreateAnnouncement(): void
    {
        $data = [
            'recipients' => [
                "tu1",
                "tu2",
            ],
            'sender' => [
                'name' => 'The System',
            ],
            'parts' => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain'
                ],
            ],
        ];

        $response = $this->getAnnouncementService()->create($data);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertInternalType('string', $response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $response->getStatusCode()
        ); //202
        $response = $this->getAnnouncementService()->create([]);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertInternalType('null', $response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }
}
