<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;
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
    public static function setUpBeforeClass(): void
    {
        $mock = new MockHandler([
            self::getResponse(
                ResponseStatus::HTTP_ACCEPTED,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_BAD_REQUEST),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_BAD_REQUEST),
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
    public function testCreateMessage(): void
    {
        $data = [
            [
                'sender_id' => 'userId',
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

        $response  = $this->getMessageService()->create($data, 'conversationId');
        $messageId = $response->getCreatedItemId();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', $messageId);
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $response->getStatusCode()
        ); //202

        $response = $this->getMessageService()->create([], 'conversationId');
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
        $response = $this->getMessageService()->all('conversationId');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $content);
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
        $response = $this->getMessageService()->get('messageId', 'conversationId');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);

        $response = $this->getMessageService()->get('messageId', 'wrongId');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404

        $response = $this->getMessageService()->get('wrongId', 'conversationId');
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
        $response = $this->getMessageService()->delete('wrongId', 'conversationId');
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
