<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class ConversationServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class ConversationServiceTest extends BaseClass
{
    /**
     * Conversation ID
     *
     * @var string
     */
    public static $conversationId;

    /**
     * Test conversation creation
     *
     * @return void
     */
    public function testCreateConversation(): void
    {
        self::$conversationId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ]);

        $this->assertTrue(in_array($this->getConversationService()->getStatusCode(), [
            ResponseStatus::HTTP_OK, 
            ResponseStatus::HTTP_CREATED
        ])); //200|201
        $this->assertInternalType('string', self::$conversationId);
        $this->assertNull($this->getConversationService()->create([]));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getConversationService()->getStatusCode()
        ); //422
    }

    /**
     * Test conversation update
     *
     * @return void
     */
    public function testUpdateUser(): void
    {
        $result = $this->getConversationService()->update([
            [
                'operation' => 'set',
                'property'  => 'participants',
                'value'     =>  ["tu2", "tu1"],
            ],
        ], self::$conversationId);

        $this->assertTrue($result);
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getConversationService()->getStatusCode()
        ); //204
    }

    /**
     * Test obtaining information about a conversation
     *
     * @return void
     */
    public function testGetConversation(): void
    {
        $result = $this->getConversationService()->get(self::$conversationId);
        $this->assertArrayHasKey('url', $result);
        $this->assertArrayHasKey('participants', $result);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('distinct', $result);
        $this->assertArrayHasKey('metadata', $result);
        $this->assertArrayHasKey('created_at', $result);
        $this->assertArrayHasKey('messages_url', $result);
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getConversationService()->getStatusCode()
        ); //200

        $this->assertNull($this->getConversationService()->get('wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getConversationService()->getStatusCode()
        ); //404
    }

    /**
     * Test obtaining information about conversations
     *
     * @return void
     */
    public function testGetConversations(): void
    {
        $result = $this->getConversationService()->all('tu1');
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('url', $result[0]);
        $this->assertArrayHasKey('messages_url', $result[0]);
        $this->assertArrayHasKey('created_at', $result[0]);
        $this->assertArrayHasKey('last_message', $result[0]);
        $this->assertArrayHasKey('participants', $result[0]);
        $this->assertArrayHasKey('distinct', $result[0]);
        $this->assertArrayHasKey('unread_message_count', $result[0]);
        $this->assertArrayHasKey('metadata', $result[0]);
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getConversationService()->getStatusCode()
        ); //200
        $this->assertEmpty($this->getConversationService()->all('wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getConversationService()->getStatusCode()
        ); //200
    }

    /**
     * Test get user conversations
     *
     * @return void
     */
    public function testGetUserConversations(): void
    {
        $result = $this->getUserDataService()->getConversations('tu1');
        $this->assertInternalType('array', $result);
        $this->assertArrayHasKey('id', $result[0]);
        $this->assertArrayHasKey('url', $result[0]);
        $this->assertArrayHasKey('messages_url', $result[0]);
        $this->assertArrayHasKey('created_at', $result[0]);
        $this->assertArrayHasKey('last_message', $result[0]);
        $this->assertArrayHasKey('participants', $result[0]);
        $this->assertArrayHasKey('distinct', $result[0]);
        $this->assertArrayHasKey('unread_message_count', $result[0]);
        $this->assertArrayHasKey('metadata', $result[0]);
    }

    /**
     * Test conversation deletion
     *
     * @return void
     */
    public function testDeleteConversation(): void
    {
        $this->assertTrue($this->getConversationService()->delete(self::$conversationId));
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getConversationService()->getStatusCode()
        ); //204
        $this->assertFalse($this->getConversationService()->delete('wrongId'));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getConversationService()->getStatusCode()
        ); //404
    }
}