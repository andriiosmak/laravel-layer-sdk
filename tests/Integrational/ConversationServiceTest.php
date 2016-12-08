<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

class ConversationServiceTest extends BaseClass
{
    /**
     * Set Up Client
     */
    public static function setUpBeforeClass()
    {
        $mock = new MockHandler([
            self::getResponse(
                ResponseStatus::HTTP_OK, 
                Psr7\stream_for('{"id":"layer:///conversations/5055b704-f980-43c1-88c0-3705bad5beca"}')
            ),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
            self::getResponse(
                ResponseStatus::HTTP_NO_CONTENT, 
                Psr7\stream_for('{"id":"layer:///conversations/5055b704-f980-43c1-88c0-3705bad5beca"}')
            ),
            self::getResponse(
                ResponseStatus::HTTP_OK, 
                Psr7\stream_for('{"url":"layer:///conversations/5055b704-f980-43c1-88c0-3705bad5beca"}')
            ),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
            self::getResponse(ResponseStatus::HTTP_OK),
            self::getResponse(ResponseStatus::HTTP_OK),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test conversation creation
     */
    public function testCreateConversation()
    {
        $id = $this->getConversationService()->create([
            'participants' => [
                "userId1",
                "userId2",
            ],
        ]);

        $this->assertInternalType('string', $id);
        $this->assertNull($this->getConversationService()->create([]));
    }

    /**
     * Test conversation update
     */
    public function testUpdateUser()
    {
        $result = $this->getConversationService()->update([
            [
                'operation' => 'set',
                'property'  => 'participants',
                'value'     =>  ["tu2", "tu1"],
            ],
        ], 'convId');

        $this->assertTrue($result);
    }

    /**
     * Test obtaining information about a conversation
     */
    public function testGetConversation()
    {
        $this->assertArrayHasKey('url', $this->getConversationService()->get('convId'));
        $this->assertFalse($this->getConversationService()->get('wrongConvId'));
    }

    /**
     * Test obtaining information about conversations
     */
    public function testGetConversations()
    {
        $this->assertInternalType('array', $this->getConversationService()->all('userId'));
        $this->assertEmpty($this->getConversationService()->all('wrongUserId'));
    }

    /**
     * Test conversation deletion
     */
    public function testDeleteConversation()
    {
        $this->assertTrue($this->getConversationService()->delete('convId'));
        $this->assertFalse($this->getConversationService()->delete('wrongConvId'));
    }
}