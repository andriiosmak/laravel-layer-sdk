<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class MessageServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class MessageServiceTest extends BaseClass
{
    /**
     * Conversation ID
     *
     * @var string
     */
    public static $conversationId;

    /**
     * Message ID
     *
     * @var string
     */
    public static $messageId;

    /**
     * Test message creation
     *
     * @return void
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

        self::$conversationId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ]);

        self::$messageId = $this->getMessageService()->create($data, self::$conversationId);

        $this->assertInternalType('string', self::$messageId);
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $this->getMessageService()->getStatusCode()
        ); //201
        $this->assertNull($this->getMessageService()->create([], self::$conversationId));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getMessageService()->getStatusCode()
        ); //422
    }

    /**
     * Test getListSystem method
     *
     * @return void
     */
    public function testGetListSystemMessage()
    {
        $response = $this->getMessageService()->allLikeSystem(self::$conversationId);
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('id', $response[0]);
        $this->assertArrayHasKey('url', $response[0]);
        $this->assertArrayHasKey('receipts_url', $response[0]);
        $this->assertArrayHasKey('position', $response[0]);
        $this->assertArrayHasKey('conversation', $response[0]);
        $this->assertArrayHasKey('parts', $response[0]);
        $this->assertArrayHasKey('sent_at', $response[0]);
        $this->assertArrayHasKey('received_at', $response[0]);
        $this->assertArrayHasKey('sender', $response[0]);
        $this->assertArrayHasKey('is_unread', $response[0]);
        $this->assertArrayHasKey('recipient_status', $response[0]);
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getMessageService()->getStatusCode()
        ); //200
        $this->assertNull($this->getMessageService()->allLikeSystem('wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
    }

    /**
     * Test getListsUser method
     *
     * @return void
     */
    public function testgGetListsUserMessage()
    {
        $response = $this->getMessageService()->allLikeUser(self::$conversationId, 'tu1');
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('id', $response[0]);
        $this->assertArrayHasKey('url', $response[0]);
        $this->assertArrayHasKey('receipts_url', $response[0]);
        $this->assertArrayHasKey('position', $response[0]);
        $this->assertArrayHasKey('conversation', $response[0]);
        $this->assertArrayHasKey('parts', $response[0]);
        $this->assertArrayHasKey('sent_at', $response[0]);
        $this->assertArrayHasKey('received_at', $response[0]);
        $this->assertArrayHasKey('sender', $response[0]);
        $this->assertArrayHasKey('is_unread', $response[0]);
        $this->assertArrayHasKey('recipient_status', $response[0]);
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getMessageService()->getStatusCode()
        ); //200
        $this->assertNull($this->getMessageService()->allLikeUser('wrongId', 'tu1'));
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $this->getMessageService()->getStatusCode()
        ); //400
        $this->assertNull($this->getMessageService()->allLikeUser(self::$conversationId, 'wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
    }

    /**
     * Test getLikeSystem method
     *
     * @return void
     */
    public function testGetLikeSystemMessage()
    {
        $response = $this->getMessageService()->getLikeSystem(self::$messageId, self::$conversationId);
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getMessageService()->getStatusCode()
        ); //200
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('url', $response);
        $this->assertArrayHasKey('receipts_url', $response);
        $this->assertArrayHasKey('position', $response);
        $this->assertArrayHasKey('conversation', $response);
        $this->assertArrayHasKey('parts', $response);
        $this->assertArrayHasKey('sent_at', $response);
        $this->assertArrayHasKey('received_at', $response);
        $this->assertArrayHasKey('sender', $response);
        $this->assertArrayHasKey('is_unread', $response);
        $this->assertArrayHasKey('recipient_status', $response);
        $this->assertNull($this->getMessageService()->getLikeSystem(self::$messageId, 'wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
        $this->assertNull($this->getMessageService()->getLikeSystem('wrongId', self::$conversationId));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
    }

    /**
     * Test getLikeUser method
     *
     * @return void
     */
    public function testgetLikeUserMessage()
    {
        $response = $this->getMessageService()->getLikeUser(self::$messageId, "tu1");
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getMessageService()->getStatusCode()
        ); //200
        $this->assertArrayHasKey('id', $response);
        $this->assertArrayHasKey('url', $response);
        $this->assertArrayHasKey('receipts_url', $response);
        $this->assertArrayHasKey('position', $response);
        $this->assertArrayHasKey('conversation', $response);
        $this->assertArrayHasKey('parts', $response);
        $this->assertArrayHasKey('sent_at', $response);
        $this->assertArrayHasKey('received_at', $response);
        $this->assertArrayHasKey('sender', $response);
        $this->assertArrayHasKey('is_unread', $response);
        $this->assertArrayHasKey('recipient_status', $response);
        $this->assertNull($this->getMessageService()->getLikeUser(self::$messageId, 'wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
        $this->assertNull($this->getMessageService()->getLikeUser('wrongId', "tu1"));
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $this->getMessageService()->getStatusCode()
        ); //400
    }

    /**
     * Test message deletion
     *
     * @return void
     */
    public function testDeleteMessage()
    {
        $this->assertTrue($this->getMessageService()->delete(self::$messageId, self::$conversationId));
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getMessageService()->getStatusCode()
        ); //204
        $this->assertFalse($this->getMessageService()->delete('wrongId', 'wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
    }

    /**
     * Test announcement creation
     *
     * @return void
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

        $this->assertInternalType('string', $this->getMessageService()->createAnnouncement($data));
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $this->getMessageService()->getStatusCode()
        ); //202
        $this->assertNull($this->getMessageService()->createAnnouncement([]));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getMessageService()->getStatusCode()
        ); //422
    }

    /**
     * Test notification creation
     *
     * @return void
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

        $this->assertNull($this->getMessageService()->createNotification($data));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_IMPLEMENTED,
            $this->getMessageService()->getStatusCode()
        ); //501
        $this->assertNull($this->getMessageService()->createNotification([]));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_IMPLEMENTED,
            $this->getMessageService()->getStatusCode()
        ); //501
    }
}