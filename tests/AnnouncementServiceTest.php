<?php

namespace Aosmak\Laravel\Layer\Sdk;

class AnnouncementServiceTest extends BaseClass
{
    /**
     * Test announcement creation
     */
    public function testCreateAnnouncement()
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
        $this->assertFalse($this->getAnnouncementService()->create([]));
    }
}