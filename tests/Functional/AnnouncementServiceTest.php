<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

/**
 * Class AnnouncementServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
class AnnouncementServiceTest extends BaseClass
{
    /**
     * Set Up Client
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
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
     *
     * @return void
     */
    public function testCreateAnnouncement(): void
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

        $response = $this->getAnnouncementService()->create($data);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertInternalType('array', $response->getContents());
        $this->assertInternalType('string', $response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $response->getStatusCode()
        ); //202
    }
}
