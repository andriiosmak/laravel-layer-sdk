<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\Response;
use Symfony\Component\HttpFoundation\Response as ResponseStatus;

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
        $userId = self::getUniqueEntityId('testUserOne');
        $botId  = self::getUniqueEntityId('testBotOne');
        $data   = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $this->getUserService()->create($data, $userId);
        $response = $this->getUserService()->get($userId);
        $useId    = $response->getContents()['id'];
        $data     = [
            "first_name"    => 'testName',
            "last_name"     => 'testSurname',
            "display_name"  => 'testDisplayName',
            "phone_number"  => 'testPhoneNumber',
            "identity_type" => 'bot',
        ];

        $response = $this->getIdentityService()->create($data, $botId);
        $response = $this->getIdentityService()->get($botId);
        $botId    = $response->getContents()['id'];
        $data     = [
            'recipients' => [
                $useId
            ],
            'sender_id' => $botId,
            'parts'     => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain'
                ],
            ],
            "notification" => [
                "title" => "New Alert",
                "text"  => "This is the alert text to include with the Push Notification.",
                "sound" => "chime.aiff"
            ]
        ];

        $response = $this->getAnnouncementService()->create($data);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertInternalType('array', $response->getHeaders());
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
