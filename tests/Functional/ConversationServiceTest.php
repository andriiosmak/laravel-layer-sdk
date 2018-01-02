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
    public static function setUpBeforeClass(): void
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
            self::getResponse(ResponseStatus::HTTP_OK),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test conversation creation
     *
     * @return void
     */
    public function testCreateConversation(): void
    {
        $id = $this->getConversationService()->create([
            'participants' => [
                "userId1",
                "userId2",
            ],
        ])->getCreatedItemId();

        $this->assertInternalType('string', $id);
        $this->assertNull($this->getConversationService()->create([])->getCreatedItemId());
    }

    /**
     * Test conversation update
     *
     * @return void
     */
    public function testUpdateConversation(): void
    {
        $response = $this->getConversationService()->update([
            [
                'operation' => 'set',
                'property'  => 'participants',
                'value'     =>  ["tu2", "tu1"],
            ],
        ], 'convId');

        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertInternalType('array', $response->getContents());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204
    }

    /**
     * Test obtaining information about a conversation
     *
     * @return void
     */
    public function testGetConversation(): void
    {
        $response = $this->getConversationService()->get('convId');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertInternalType('array', $response->getContents());
    }

    /**
     * Test obtaining information about conversations
     *
     * @return void
     */
    public function testGetConversations(): void
    {
        $response = $this->getConversationService()->all('tu1');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertInternalType('array', $content);
    }

    /**
     * Test get user conversations
     *
     * @return void
     */
    public function testGetUserConversations(): void
    {
        $response = $this->getUserDataService()->getConversations('userId');
        $this->assertInternalType('array', $response->getContents());
    }

    /**
     * Test conversation deletion
     *
     * @return void
     */
    public function testDeleteConversation(): void
    {
        $response = $this->getConversationService()->delete('convId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
    }
}
