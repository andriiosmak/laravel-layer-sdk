<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

/**
 * Class NotificationServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
class NotificationServiceTest extends BaseClass
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
                ResponseStatus::HTTP_CREATED,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test notification creation
     *
     * @return void
     */
    public function testCreateNotification(): void
    {
        $data = [
            'recipients' => [
                "tu1",
                "tu2",
            ],
            'notification' => [
                'text'  => 'This is the alert text to include with the Push Notification.',
                'sound' => 'chime.aiff',
            ],
        ];

        $response = $this->getNotificationService()->create($data);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //202;

        $response = $this->getNotificationService()->create([]);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }
}
