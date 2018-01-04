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

        $response = $this->getNotificationService()->create($data);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $response->getStatusCode()
        ); //202

        $response = $this->getNotificationService()->create([]);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }
}
