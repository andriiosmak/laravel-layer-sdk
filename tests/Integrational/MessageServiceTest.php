<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

class MessageServiceTest extends BaseClass
{
    /**
     * Set Up Client
     */
    public static function setUpBeforeClass()
    {
        $mock = new MockHandler([
            self::getResponse(
                ResponseStatus::HTTP_CREATED, 
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_OK),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_OK),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(
                ResponseStatus::HTTP_OK, 
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
             self::getResponse(
                ResponseStatus::HTTP_OK, 
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(
                ResponseStatus::HTTP_ACCEPTED, 
                Psr7\stream_for('{"id":"layer:///announcements/fbdd0bc4-e75d-46e5-b615-cca97e62601e"}')
            ),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
            self::getResponse(
                ResponseStatus::HTTP_ACCEPTED, 
                Psr7\stream_for('{"id":"layer:///notifications/fbdd0bc4-e75d-46e5-b615-cca97e62601e"}')
            ),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test message creation
     */
    public function testCreateMessage()
    {
        $data = [
            'sender' => [
                "user_id" => "tu1",
            ],
            'parts' => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain'
                ],
            ],
        ];

        $this->assertInternalType('string', $this->getMessageService()->create($data, 'test'));
        $this->assertNull($this->getMessageService()->create([], 'test'));
    }

    /**
     * Test getListSystem method
     */
    public function testGetListSystemMessage()
    {
        $this->assertInternalType('array', $this->getMessageService()->allLikeSystem('test'));
        $this->assertFalse($this->getMessageService()->allLikeSystem('wrongId'));
    }

    /**
     * Test getListsUser method
     */
    public function testgGetListsUserMessage()
    {
        $this->assertInternalType('array', $this->getMessageService()->allLikeUser('convId', 'tu1'));
        $this->assertFalse($this->getMessageService()->allLikeUser('wrongConvId', 'tu1'));
        $this->assertFalse($this->getMessageService()->allLikeUser('convId', 'wrongId'));
    }

    /**
     * Test getLikeSystem method
     */
    public function testGetLikeSystemMessage()
    {
        $this->assertArrayHasKey('id', $this->getMessageService()->getLikeSystem('messageId', 'convId'));
        $this->assertFalse($this->getMessageService()->getLikeSystem('messageId', 'wrongConvId'));
        $this->assertFalse($this->getMessageService()->getLikeSystem('wrongMessageId', 'convId'));
    }

    /**
     * Test getLikeUser method
     */
    public function testGetLikeUserMessage()
    {
        $this->assertArrayHasKey('id', $this->getMessageService()->getLikeUser('messagwId', 'userId'));
        $this->assertFalse($this->getMessageService()->getLikeUser('messagwId', 'wrongUserId'));
        $this->assertFalse($this->getMessageService()->getLikeUser('wrongMessagwId', 'userId'));
    }

    /**
     * Test message deletion
     */
    public function testDeleteMessage()
    {
        $this->assertTrue($this->getMessageService()->delete('messageId', 'ConvId'));
        $this->assertFalse($this->getMessageService()->delete('wrongMessageId', 'wrongConvId'));
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

        $this->assertInternalType('string', $this->getMessageService()->createAnnouncement($data));
        $this->assertNull($this->getMessageService()->createAnnouncement([]));
    }

    /**
     * Test notification creation
     */
    public function testCreateNotification()
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

        $this->assertInternalType('string', $this->getMessageService()->createNotification($data));
        $this->assertNull($this->getMessageService()->createNotification([]));
    }
}