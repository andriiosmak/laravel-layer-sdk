<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class NotificationServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class NotificationServiceTest extends BaseClass
{
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
                'title' => 'New notification',
                'text'  => 'This is the alert text to include with the Push Notification.',
                'sound' => 'chime.aiff',
            ],
        ];

        $this->assertNull($this->getNotificationService()->create($data));
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $this->getNotificationService()->getStatusCode()
        ); //202
        $this->assertNull($this->getNotificationService()->create([]));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getNotificationService()->getStatusCode()
        ); //422
    }
}