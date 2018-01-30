<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

/**
 * Class RichContentServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
class RichContentServiceTest extends BaseClass
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
                ResponseStatus::HTTP_CREATED,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(
                ResponseStatus::HTTP_CREATED,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test rich content upload request
     *
     * @return void
     */
    public function testRequestUpload(): void
    {
        $path     = dirname(__FILE__) . '/../TestFiles/upload.png';
        $response = $this->getRichContentService()->requestUpload(
            'conersationId',
            $path
        );

        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201
        $content = $response->getContents();
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('id', $content);
    }

    /**
     * Test refresh Url
     *
     * @return void
     */
    public function testUploadFile(): void
    {
        $path     = dirname(__FILE__) . '/../TestFiles/upload.png';
        $response = $this->getRichContentService()->uploadFile(
            'url',
            $path
        );
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $content = $response->getContents();
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('id', $content);
    }

    /**
     * Test refresh Url
     *
     * @return void
     */
    public function testRefreshUrl(): void
    {
        $response = $this->getRichContentService()->refreshUrl(
            'conersationId',
            'requestId'
        );
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $content = $response->getContents();
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('id', $content);
    }

    /**
     * Test send uploaded image
     *
     * @return void
     */
    public function testSendUpload(): void
    {
        $data = [
            'sender_id' => 'sender_id',
            'parts'     => [
                [
                    'mime_type' => 'text/plain',
                    'body'      => 'This is the message.'
                ],
                [
                    'mime_type' => 'image/png',
                    'content'   => [
                        'id'   => 'id',
                        'size' => 'size',
                    ]
                ]
            ]
        ];

        $response = $this->getRichContentService()->sendUpload('conersationId', $data);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201
        $content = $response->getContents();
        $this->assertArrayHasKey('id', $content);
    }
}
