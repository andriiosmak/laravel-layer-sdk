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
    public function testCreateMessage() : void
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
     * Test all method
     *
     * @return void
     */
    public function testGetAll() : void
    {
        $response = $this->getMessageService()->all(self::$conversationId);
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
        $this->assertNull($this->getMessageService()->all('wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
    }

    /**
     * Test get method
     *
     * @return void
     */
    public function testGetMessage() : void
    {
        $response = $this->getMessageService()->get(self::$messageId, self::$conversationId);
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
        $this->assertNull($this->getMessageService()->get(self::$messageId, 'wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
        $this->assertNull($this->getMessageService()->get('wrongId', self::$conversationId));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getMessageService()->getStatusCode()
        ); //404
    }

    /**
     * Test message deletion
     *
     * @return void
     */
    public function testDeleteMessage() : void
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
     * Send Read/Delivery Receipt
     *
     * @return void
     */
    public function testSendReceipt() : void
    {
        $this->testCreateMessage();
        $response = $this->getUserDataService()->sendReceipt('read', 'tu1', self::$messageId);
        $this->assertTrue($response);
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getUserDataService()->getStatusCode()
        ); //204
        $this->assertFalse($this->getUserDataService()->sendReceipt('read', 'wrongId', 'wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $this->getUserDataService()->getStatusCode()
        ); //400
        $this->assertFalse($this->getUserDataService()->sendReceipt('test', 'tu1', self::$messageId));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getUserDataService()->getStatusCode()
        ); //400
    }

    /**
     * Test message deletion
     *
     * @return void
     */
    public function testUserDataDeleteMessage() : void
    {
        $this->assertTrue($this->getUserDataService()->deleteMessage('tu1', self::$messageId));
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getUserDataService()->getStatusCode()
        ); //204
        $this->assertFalse($this->getUserDataService()->deleteMessage('wrongId', 'wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $this->getUserDataService()->getStatusCode()
        ); //400
    }
}