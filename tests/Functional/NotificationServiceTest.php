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
    public static function setUpBeforeClass() : void
    {
        $mock = new MockHandler([
            self::getResponse(
                ResponseStatus::HTTP_CREATED,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test notification creation
     *
     * @return void
     */
    public function testCreateNotification() : void
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

        self::getResponse(ResponseStatus::HTTP_CREATED);
        $this->assertNull($this->getNotificationService()->create([]));
    }
}