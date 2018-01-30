<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;

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
        $userData = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $this->getUserService()->create($userData, 'testUserOne');
        $response = $this->getUserService()->get('testUserOne');
        $userId   = $response->getContents()['id'];

        self::$conversationId = $this->getConversationService()->create([
            'participants' => [
                $userId,
                "tu2",
            ],
        ])->getCreatedItemId();

        $data = [
            'sender_id' => $userId,
            'parts'     => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain',
                ],
                [
                    'body'      => 'YW55IGNhcm5hbCBwbGVhc3VyZQ==',
                    'mime_type' => 'image/jpeg',
                    'encoding'  => 'base64',
                ],
            ],
            'notification' => [
                'title' => 'New Alert',
                'text'  => 'This is the alert text to include with the Push Notification.',
                'sound' => 'chime.aiff',
            ],
        ];

        $response        = $this->getMessageService()->create($data, self::$conversationId);
        self::$messageId = $response->getCreatedItemId();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', self::$messageId);
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201

        $data = [
            'sender_id' => $userId,
            'parts'     => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain',
                ],
            ],
            'notification' => [
                'title' => 'New Alert',
                'text'  => 'This is the alert text to include with the Push Notification.',
                'sound' => 'chime.aiff',
            ],
            'schedule' => [
                'delay_in_seconds'            => 8.2,
                'typing_indicator_in_seconds' => 3.8,
            ]
        ];

        $response        = $this->getMessageService()->create($data, self::$conversationId);
        $messageId = $response->getCreatedItemId();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', self::$messageId);
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $response->getStatusCode()
        ); //202

        $data = [
            [
                'sender_id' => $userId,
                'schedule'  => [
                    'delay_in_seconds'            => 7.0,
                    'typing_indicator_in_seconds' => 3.8,
                ],
                'parts' => [
                    [
                        'mime_type' => 'text/plain',
                        'body'      => 'Thanks for your inquiry. Let me see what rooms we have available...',
                    ]
                ]
            ]
        ];

        $response  = $this->getMessageService()->create($data, self::$conversationId);
        $messageId = $response->getCreatedItemId();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', self::$messageId);
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $response->getStatusCode()
        ); //202

        $response = $this->getMessageService()->create([], self::$conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_BAD_REQUEST,
            $response->getStatusCode()
        ); //400

        $response = $this->getMessageService()->create([], 'wrongId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404;
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
        $this->assertTrue(in_array($response->getStatusCode(),
            [
                ResponseStatus::HTTP_OK,
                ResponseStatus::HTTP_PARTIAL_CONTENT
            ]
        ));

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
}
