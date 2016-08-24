<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

class AnnouncementServiceTest extends BaseClass
{
    /**
     * Set Up Client
     */
    public static function setUpBeforeClass()
    {
        $mock = new MockHandler([
            self::getResponse(
                ResponseStatus::HTTP_ACCEPTED, 
                Psr7\stream_for('{"id":"layer:///announcements/fbdd0bc4-e75d-46e5-b615-cca97e62601e"}')
            ),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test announcement creation
     */
    public function testCreateAnnouncement()
    {
        $data = [
            'recipients' => [
                "userId1",
                "userId2",
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
        $this->assertFalse($this->getAnnouncementService()->create([]));
    }
}