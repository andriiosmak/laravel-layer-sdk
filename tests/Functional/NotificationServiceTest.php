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

        $this->assertInternalType('string', $this->getNotificationService()->create($data));
        $this->assertNull($this->getNotificationService()->create([]));
    }
}