<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

/**
 * Class ConversationServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
class ConversationServiceTest extends BaseClass
{
    /**
     * Set Up Client
     *
     * @return void
     */
    public static function setUpBeforeClass() : void
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
     *
     * @return void
     */
    public function testCreateConversation() : void
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
     *
     * @return void
     */
    public function testUpdateUser() : void
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
     *
     * @return void
     */
    public function testGetConversation() : void
    {
        $this->assertArrayHasKey('url', $this->getConversationService()->get('convId'));
        $this->assertNull($this->getConversationService()->get('wrongConvId'));
    }

    /**
     * Test obtaining information about conversations
     *
     * @return void
     */
    public function testGetConversations() : void
    {
        $this->assertInternalType('array', $this->getConversationService()->all('userId'));
        $this->assertEmpty($this->getConversationService()->all('wrongUserId'));
    }

    /**
     * Test conversation deletion
     *
     * @return void
     */
    public function testDeleteConversation() : void
    {
        $this->assertTrue($this->getConversationService()->delete('convId'));
        $this->assertFalse($this->getConversationService()->delete('wrongConvId'));
    }
}