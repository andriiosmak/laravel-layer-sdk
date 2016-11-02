<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

class UserServiceTest extends BaseClass
{
    /**
     * Set Up Client
     */
    public static function setUpBeforeClass()
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
        ]);
        self::setUpService($mock);
    }

    /**
     * Test user creation
     */
    public function testCreateUser()
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
     */
    public function testReplaceUser()
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
     */
    public function testUpdateUser()
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
     */
    public function testGetUser()
    {
        $this->assertArrayHasKey('first_name', $this->getUserService()->get('userId'));
        $this->assertFalse($this->getUserService()->get('wrongUserId'));
    }

    /**
     * Test user deletion
     */
    public function testDeleteUser()
    {
        $this->assertTrue($this->getUserService()->delete('userId'));
        $this->assertFalse($this->getUserService()->delete('wrongUserId'));
    }

    /**
     * Test badge creation
     */
    public function testCreateBadge()
    {
        $data = [
            "external_unread_count" => 15,
        ];

        $this->assertTrue($this->getUserService()->createBadge($data, 'testUserOne'));
        $this->assertFalse($this->getUserService()->createBadge([], time()));
    }

    /**
     * Test obtaining information about user badges
     */
    public function testGetBadge()
    {
        $this->assertArrayHasKey('external_unread_count', $this->getUserService()->getBadges('testUserOne'));
    }


    /**
     * Test block list update
     */
    public function testBlockListUpdate()
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
     */
    public function testGetBlockList()
    {
        $this->assertInternalType('array', $this->getUserService()->getBlockList('testUserOne'));
    }
}