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
    public function testCreateMessage(): void
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
        ])->getCreatedItemId();

        $response        = $this->getMessageService()->create($data, self::$conversationId);
        self::$messageId = $response->getCreatedItemId();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', self::$messageId);
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201

        $response = $this->getMessageService()->create([], self::$conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_IMPLEMENTED,
            $response->getStatusCode()
        ); //501
    }

    /**
     * Test all method
     *
     * @return void
     */
    public function testGetAll(): void
    {
        $response = $this->getMessageService()->all(self::$conversationId);
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('url', $content[0]);
        $this->assertArrayHasKey('receipts_url', $content[0]);
        $this->assertArrayHasKey('position', $content[0]);
        $this->assertArrayHasKey('conversation', $content[0]);
        $this->assertArrayHasKey('parts', $content[0]);
        $this->assertArrayHasKey('sent_at', $content[0]);
        $this->assertArrayHasKey('received_at', $content[0]);
        $this->assertArrayHasKey('sender', $content[0]);
        $this->assertArrayHasKey('is_unread', $content[0]);
        $this->assertArrayHasKey('recipient_status', $content[0]);
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $response = $this->getMessageService()->all('wrongid');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }

    /**
     * Test get method
     *
     * @return void
     */
    public function testGetMessage(): void
    {
        $response = $this->getMessageService()->get(self::$messageId, self::$conversationId);
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('url', $content);
        $this->assertArrayHasKey('receipts_url', $content);
        $this->assertArrayHasKey('position', $content);
        $this->assertArrayHasKey('conversation', $content);
        $this->assertArrayHasKey('parts', $content);
        $this->assertArrayHasKey('sent_at', $content);
        $this->assertArrayHasKey('received_at', $content);
        $this->assertArrayHasKey('sender', $content);
        $this->assertArrayHasKey('is_unread', $content);
        $this->assertArrayHasKey('recipient_status', $content);

        $response = $this->getMessageService()->get(self::$messageId, 'wrongId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404

        $response = $this->getMessageService()->get('wrongId', self::$conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $response->getStatusCode()
        ); //400
    }

    /**
     * Test message deletion
     *
     * @return void
     */
    public function testDeleteMessage(): void
    {
        $response = $this->getMessageService()->delete(self::$messageId, self::$conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getMessageService()->delete('wrongId', 'wrongId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }

    /**
     * Send Read/Delivery Receipt
     *
     * @return void
     */
    public function testSendReceipt(): void
    {
        $this->testCreateMessage();
        $response = $this->getUserDataService()->sendReceipt('read', 'tu1', self::$messageId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getUserDataService()->sendReceipt('read', 'wrongId', 'wrongId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $response->getStatusCode()
        ); //400

        $response = $this->getUserDataService()->sendReceipt('test', 'tu1', self::$messageId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //400
    }

    /**
     * Test message deletion
     *
     * @return void
     */
    public function testUserDataDeleteMessage(): void
    {
        $response = $this->getUserDataService()->deleteMessage('tu1', self::$messageId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getUserDataService()->deleteMessage('wrongId', 'wrongId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $response->getStatusCode()
        ); //400
    }
}
