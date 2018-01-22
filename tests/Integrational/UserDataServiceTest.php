<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class UserDataServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class UserDataServiceTest extends BaseClass
{
    /**
     * Message ID
     *
     * @var string
     */
    public static $messageId;

    /**
     * Get all conversations by user
     *
     * @return void
     */
    public function testGetConversations(): void
    {
        //delete if exists
        $this->getUserService()->delete('testUserOne');

        $data = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $this->getUserService()->create($data, 'testUserOne');

        $response = $this->getUserDataService()->getConversations('testUserOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('url', $content[0]);
        $this->assertArrayHasKey('messages_url', $content[0]);
        $this->assertArrayHasKey('created_at', $content[0]);
        $this->assertArrayHasKey('last_message', $content[0]);
        $this->assertInternalType('array', $content[0]['last_message']);

        $response = $this->getUserDataService()->getConversations('wrongId');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertEmpty($content);
    }

    /**
     * Test message creation
     *
     * @return void
     */
    public function testSendMessage(): void
    {
        $data = [
            'parts' => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain'
                ],
            ],
        ];

        $conversationId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ])->getCreatedItemId();

        $response = $this->getUserDataService()->sendMessage($data, "tu1", $conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', $response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201

        $response = $this->getUserDataService()->sendMessage([], "tu1", $conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }

    /**
     * Send Read/Delivery Receipt
     *
     * @return void
     */
    public function testSendReceipt(): void
    {
        $response = $this->getUserService()->get('testUserOne');
        $userId   = $response->getContents()['id'];

        $conversationId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                $userId
            ],
        ])->getCreatedItemId();

        $data = [
            'sender_id' => $userId,
            'parts'     => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain',
                ],
            ],
        ];

        $response  = $this->getMessageService()->create($data, $conversationId);
        self::$messageId = $response->getCreatedItemId();
        $response  = $this->getUserDataService()->sendReceipt('read', 'tu1', self::$messageId);
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
