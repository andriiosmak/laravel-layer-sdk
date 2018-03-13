<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;

/**
 * Class UserDataServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class UserDataServiceTest extends BaseClass
{
    /**
     * User ID
     *
     * @var string
     */
    public static $userId;

    /**
     * Second User ID
     *
     * @var string
     */
    public static $secondUserId;

    /**
     * Message ID
     *
     * @var string
     */
    public static $messageId;

    /**
     * Conversation ID
     *
     * @var string
     */
    public static $conversationId;

    /**
     * Get all conversations by user
     *
     * @return void
     */
    public function testGetConversations(): void
    {
        self::$userId       = self::getUniqueEntityId('testUserOne');
        self::$secondUserId = self::getUniqueEntityId('testUserTwo');

        //delete if exists
        $this->getUserService()->delete(self::$userId);

        $data = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $this->getUserService()->create($data, self::$userId);

        self::$conversationId = $this->getConversationService()->create([
            'participants' => [
                self::$userId,
                self::$secondUserId
            ],
        ])->getCreatedItemId();

        $response = $this->getUserDataService()->getConversations(self::$userId);
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertContains(
            $response->getStatusCode(),
            [
                ResponseStatus::HTTP_OK, //200
                ResponseStatus::HTTP_PARTIAL_CONTENT //206
            ]
        );
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('id', $content[0]);
        $this->assertArrayHasKey('url', $content[0]);
        $this->assertArrayHasKey('messages_url', $content[0]);
        $this->assertArrayHasKey('created_at', $content[0]);
        $this->assertArrayHasKey('last_message', $content[0]);

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

        $response = $this->getUserDataService()->sendMessage($data, self::$userId, self::$conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', $response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201

        $response = $this->getUserDataService()->sendMessage([], self::$userId, self::$conversationId);
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
        $response = $this->getUserService()->get(self::$userId);
        $userId   = $response->getContents()['id'];
        $data     = [
            'sender_id' => $userId,
            'parts'     => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain',
                ],
            ],
        ];

        $response        = $this->getMessageService()->create($data, self::$conversationId);
        self::$messageId = $response->getCreatedItemId();
        $response        = $this->getUserDataService()->sendReceipt('read', self::$secondUserId, self::$messageId);
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

        $response = $this->getUserDataService()->sendReceipt('test', self::$secondUserId, self::$messageId);
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
        $response = $this->getUserDataService()->deleteMessage(self::$secondUserId, self::$messageId);
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
        $this->getConversationService()->delete(self::$conversationId);
        $this->getUserService()->delete(self::$secondUserId);
        $this->getUserService()->delete(self::$userId);
    }
}
