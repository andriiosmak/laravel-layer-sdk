<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

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
    public function testCreateAnnouncement() : void
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

        $this->assertInternalType('string', $this->getAnnouncementService()->create($data));
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $this->getAnnouncementService()->getStatusCode()
        ); //202
        $this->assertNull($this->getAnnouncementService()->create([]));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getAnnouncementService()->getStatusCode()
        ); //422
    }
}