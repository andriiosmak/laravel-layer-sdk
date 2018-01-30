<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;

/**
 * Class RichContentServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class RichContentServiceTest extends BaseClass
{
    /**
     * Conversation ID
     *
     * @var string
     */
    public static $conversationId;

    /**
     * Sender ID
     *
     * @var string
     */
    public static $senderId;

    /**
     * Request ID
     *
     * @var string
     */
    public static $requestId;

    /**
     * Upload URL
     *
     * @var string
     */
    public static $uploadUrl;

    /**
     * Upload size
     *
     * @var string
     */
    public static $uploadSize;

    /**
     * Request full Id
     *
     * @var string
     */
    public static $requestFullId;

    /**
     * Test rich content upload request
     *
     * @return void
     */
    public function testRequestUpload(): void
    {
        $path     = dirname(__FILE__) . '/../TestFiles/upload.png';
        $userData = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $this->getUserService()->create($userData, 'testUserOne');
        $response       = $this->getUserService()->get('testUserOne');
        $userId         = $response->getContents()['id'];
        self::$senderId = $userId;

        $response = $this->getConversationService()->create([
            'participants' => [
                $userId,
                "tu2",
            ],
        ]);

        self::$conversationId = $response->getCreatedItemId();
        $response             = $this->getRichContentService()->requestUpload(
            self::$conversationId,
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
        $this->assertArrayHasKey('size', $content);
        $this->assertArrayHasKey('refresh_url', $content);
        $this->assertArrayHasKey('download_url', $content);
        $this->assertArrayHasKey('upload_url', $content);
        $this->assertArrayHasKey('expiration', $content);
        self::$requestId     = $response->getCreatedItemId();
        self::$requestFullId = $content['id'];
        self::$uploadUrl     = $content['upload_url'];
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
            self::$uploadUrl,
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
        $this->assertArrayHasKey('kind', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('selfLink', $content);
        $this->assertArrayHasKey('name', $content);
        $this->assertArrayHasKey('bucket', $content);
        $this->assertArrayHasKey('generation', $content);
        $this->assertArrayHasKey('metageneration', $content);
        $this->assertArrayHasKey('contentType', $content);
        $this->assertArrayHasKey('timeCreated', $content);
        $this->assertArrayHasKey('updated', $content);
        $this->assertArrayHasKey('storageClass', $content);
        $this->assertArrayHasKey('timeStorageClassUpdated', $content);
        $this->assertArrayHasKey('size', $content);
        $this->assertArrayHasKey('md5Hash', $content);
        $this->assertArrayHasKey('mediaLink', $content);
        $this->assertArrayHasKey('crc32c', $content);
        $this->assertArrayHasKey('etag', $content);
        self::$uploadSize = intval($content['size']);
    }

    /**
     * Test refresh Url
     *
     * @return void
     */
    public function testRefreshUrl(): void
    {
        $response = $this->getRichContentService()->refreshUrl(
            self::$conversationId,
            self::$requestId
        );
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $content = $response->getContents();
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('size', $content);
        $this->assertArrayHasKey('refresh_url', $content);
        $this->assertArrayHasKey('download_url', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('upload_url', $content);
        $this->assertArrayHasKey('expiration', $content);
    }

    /**
     * Test send uploaded image
     *
     * @return void
     */
    public function testSendUpload(): void
    {
        $data = [
            'sender_id' => self::$senderId,
            'parts'     => [
                [
                    'mime_type' => 'text/plain',
                    'body'      => 'This is the message.'
                ],
                [
                    'mime_type' => 'image/png',
                    'content'   => [
                        'id'   => self::$requestFullId,
                        'size' => self::$uploadSize,
                    ]
                ]
            ]
        ];

        $response = $this->getRichContentService()->sendUpload(self::$conversationId, $data);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201
        $content = $response->getContents();
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('url', $content);
        $this->assertArrayHasKey('conversation', $content);
        $this->assertArrayHasKey('parts', $content);
        $this->assertArrayHasKey('sent_at', $content);
        $this->assertArrayHasKey('sender', $content);
        $this->assertArrayHasKey('recipient_status', $content);
    }
}
