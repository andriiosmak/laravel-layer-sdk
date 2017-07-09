<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

/**
 * Class MessageServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
class MessageServiceTest extends BaseClass
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
                ResponseStatus::HTTP_CREATED,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_OK),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
        ]);
        self::setUpService($mock);
    }

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

        $this->assertInternalType('string', $this->getMessageService()->create($data, 'test'));
        $this->assertNull($this->getMessageService()->create([], 'test'));
    }

    /**
     * Test all method
     *
     * @return void
     */
    public function testGetAll() : void
    {
        $this->assertInternalType('array', $this->getMessageService()->all('test'));
        $this->assertNull($this->getMessageService()->all('wrongId'));
    }

    /**
     * Test get method
     *
     * @return void
     */
    public function testGetMessage() : void
    {
        $this->assertArrayHasKey('id', $this->getMessageService()->get('messageId', 'convId'));
        $this->assertNull($this->getMessageService()->get('messageId', 'wrongConvId'));
        $this->assertNull($this->getMessageService()->get('wrongMessageId', 'convId'));
    }

    /**
     * Test message deletion
     *
     * @return void
     */
    public function testDeleteMessage() : void
    {
        $this->assertTrue($this->getMessageService()->delete('messageId', 'ConvId'));
        $this->assertFalse($this->getMessageService()->delete('wrongMessageId', 'wrongConvId'));
    }
}