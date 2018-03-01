<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;

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
        $response = $this->getConversationService()->create([
            'participants' => [
                'tu1' . time(),
                'tu3' . time()
            ],
        ]);
        $content              = $response->getContents();
        self::$conversationId = $response->getCreatedItemId();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $content);
        $this->assertInternalType('string', self::$conversationId);
        $this->assertTrue(in_array($response->getStatusCode(), [
            ResponseStatus::HTTP_OK,
            ResponseStatus::HTTP_CREATED
        ])); //200|201
        $response = $this->getConversationService()->create([]);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertInternalType('null', $response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }

    /**
     * Test conversation update
     *
     * @return void
     */
    public function testConversationUser(): void
    {
        $response = $this->getConversationService()->update([
            [
                'operation' => 'set',
                'property'  => 'participants',
                'value'     =>  ["tu2", "tu1"],
            ],
        ], self::$conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204
        $response = $this->getConversationService()->update([
            [
                'operation' => 'set',
                'property'  => 'participants',
                'value'     =>  ["tu2", "tu1"],
            ],
        ], 'wrongid');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }

    /**
     * Test obtaining information about a conversation
     *
     * @return void
     */
    public function testGetConversation(): void
    {
        $response = $this->getConversationService()->get(self::$conversationId);
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertArrayHasKey('url', $content);
        $this->assertArrayHasKey('participants', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('distinct', $content);
        $this->assertArrayHasKey('metadata', $content);
        $this->assertArrayHasKey('created_at', $content);
        $this->assertArrayHasKey('messages_url', $content);
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200

        $response = $this->getConversationService()->get('wrongid');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInternalType('array', $response->getContents());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }

    /**
     * Test conversation deletion
     *
     * @return void
     */
    public function testDeleteConversation(): void
    {
        $response = $this->getConversationService()->delete(self::$conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getConversationService()->delete('wrongId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }
}
