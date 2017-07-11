<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

/**
 * Class UserServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
class UserServiceTest extends BaseClass
{
    /**
     * Set Up Client
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        $mock = new MockHandler([
            self::getResponse(ResponseStatus::HTTP_CREATED),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"first_name":"Andy"}')
            ),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"external_unread_count":"15"}')
            ),
            self::getResponse(ResponseStatus::HTTP_ACCEPTED),
            self::getResponse(
                ResponseStatus::HTTP_OK,
                Psr7\stream_for('{"test":"test"}')
            ),
            self::getResponse(
                ResponseStatus::HTTP_CREATED,
                Psr7\stream_for('{"id":"layer:///messages/712e7754-22c1-402b-8e09-7254d1b95e43"}')
            ),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test user creation
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        $data = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $this->assertTrue($this->getUserService()->create($data, 'userId'));
        $this->assertFalse($this->getUserService()->create([], 'userId'));
    }

    /**
     * Test user replacement
     *
     * @return void
     */
    public function testReplaceUser(): void
    {
        $data = [
            "first_name"   => 'testNameUpdated',
            "last_name"    => 'testSurnameUpdated',
            "display_name" => 'testDisplayNameUpdated',
            "phone_number" => 'testPhoneNumberUpdated',
        ];

        $result = $this->getUserService()->replace($data, 'userId');
        $this->assertFalse($this->getUserService()->replace([], 'userId'));

        $this->assertTrue($result);
    }

    /**
     * Test user update
     *
     * @return void
     */
    public function testUpdateUser(): void
    {
        $data = [
            [
                'operation' => 'set',
                'property'  => 'last_name',
                'value'     => 'test921',
            ],
        ];

        $result = $this->getUserService()->update($data, 'userId');

        $this->assertTrue($result);
        $this->assertFalse($this->getUserService()->update($data, 'wrongUserId'));
    }

    /**
     * Test obtaining information about a user
     *
     * @return void
     */
    public function testGetUser(): void
    {
        $this->assertArrayHasKey('first_name', $this->getUserService()->get('userId'));
        $this->assertNull($this->getUserService()->get('wrongUserId'));
    }

    /**
     * Test user deletion
     *
     * @return void
     */
    public function testDeleteUser(): void
    {
        $this->assertTrue($this->getUserService()->delete('userId'));
        $this->assertFalse($this->getUserService()->delete('wrongUserId'));
    }

    /**
     * Test badge creation
     */
    public function testCreateBadge(): void
    {
        $data = [
            "external_unread_count" => 15,
        ];

        $this->assertTrue($this->getUserService()->createBadge($data, 'testUserOne'));
        $this->assertFalse($this->getUserService()->createBadge([], time()));
    }

    /**
     * Test obtaining information about user badges
     *
     * @return void
     */
    public function testGetBadge(): void
    {
        $this->assertArrayHasKey('external_unread_count', $this->getUserService()->getBadges('testUserOne'));
    }


    /**
     * Test block list update
     *
     * @return void
     */
    public function testBlockListUpdate(): void
    {
        $data = [
            0 => [
                'operation' => 'add',
                'property'  => 'blocks',
                'id'        => 'layer:///identities/blockMe1',
            ]
        ];

        $this->assertTrue($this->getUserService()->updateBlockList($data, 'testUserOne'));
    }

    /**
     * Test block list
     *
     * @return void
     */
    public function testGetBlockList(): void
    {
        $this->assertInternalType('array', $this->getUserService()->getBlockList('testUserOne'));
    }

    /**
     * Test message creation
     *
     * @return void
     */
    public function testSendMessage(): void
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

        $this->assertInternalType('string', $this->getUserDataService()
            ->sendMessage($data, 'userId', 'conversationId'));
        $this->assertNull($this->getUserDataService()->sendMessage([], 'wrongUserId', 'wrongConversationId'));
    }
}