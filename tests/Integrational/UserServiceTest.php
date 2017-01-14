<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class UserServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class UserServiceTest extends BaseClass
{
    /**
     * Test user creation
     *
     * @return void
     */
    public function testCreateUser()
    {
        //delete if exists
        $this->getUserService()->delete('testUserOne');

        $data = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $result  = $this->getUserService()->create($data, 'testUserOne');
        $this->assertTrue($result);
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $this->getUserService()->getStatusCode()
        ); //201
        $this->assertFalse($this->getUserService()->create([], 'testUserOne'));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getUserService()->getStatusCode()
        ); //422
    }

    /**
     * Test user replacement
     *
     * @return void
     */
    public function testReplaceUser()
    {
        $data = [
            "first_name"   => 'testNameUpdated',
            "last_name"    => 'testSurnameUpdated',
            "display_name" => 'testDisplayNameUpdated',
            "phone_number" => 'testPhoneNumberUpdated',
        ];

        $result = $this->getUserService()->replace($data, 'testUserOne');
        $this->assertTrue($result);
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getUserService()->getStatusCode()
        ); //204
        $this->assertFalse($this->getUserService()->replace([], 'testUserOne'));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getUserService()->getStatusCode()
        ); //422
    }

    /**
     * Test user update
     *
     * @return void
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

        $this->assertTrue($this->getUserService()->update($data, 'testUserOne'));
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getUserService()->getStatusCode()
        ); //204
    }

    /**
     * Test obtaining information about a user
     *
     * @return void
     */
    public function testGetUser()
    {
        $user = $this->getUserService()->get('testUserOne');
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getUserService()->getStatusCode()
        ); //200
        $this->assertInternalType('array', $user);
        $this->assertArrayHasKey('first_name', $user);
        $this->assertArrayHasKey('is_bot', $user);
        $this->assertArrayHasKey('phone_number', $user);
        $this->assertArrayHasKey('email_address', $user);
        $this->assertArrayHasKey('display_name', $user);
        $this->assertArrayHasKey('public_key', $user);
        $this->assertArrayHasKey('user_id', $user);
        $this->assertArrayHasKey('last_name', $user);
        $this->assertArrayHasKey('metadata', $user);
        $this->assertArrayHasKey('avatar_url', $user);

        //get user with wrong id
        $this->assertNull($this->getUserService()->get(time()));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getUserService()->getStatusCode()
        ); //404
    }

    /**
     * Test user deletion
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $this->assertTrue($this->getUserService()->delete('testUserOne'));
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getUserService()->getStatusCode()
        ); //204
        $this->assertFalse($this->getUserService()->delete(time()));
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $this->getUserService()->getStatusCode()
        ); //404
    }

    /**
     * Test badge creation
     *
     * @return void
     */
    public function testCreateBadge()
    {
        $data = [
            "external_unread_count" => 15,
        ];

        $this->assertTrue($this->getUserService()->createBadge($data, 'testUserOne'));
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $this->getUserService()->getStatusCode()
        ); //204
        $this->assertFalse($this->getUserService()->createBadge([], time()));
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $this->getUserService()->getStatusCode()
        ); //422
    }

    /**
     * Test obtaining information about user badges
     *
     * @return void
     */
    public function testGetBadge()
    {
        $badge = $this->getUserService()->getBadges('testUserOne');
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getUserService()->getStatusCode()
        ); //200
        $this->assertArrayHasKey('external_unread_count', $badge);
        $this->assertArrayHasKey('unread_message_count', $badge);
        $this->assertArrayHasKey('unread_conversation_count', $badge);
        $this->assertArrayHasKey('external_unread_count', $badge);
    }

    /**
     * Test block list update
     *
     * @return void
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
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $this->getUserService()->getStatusCode()
        ); //202
    }

    /**
     * Test block list
     *
     * @return void
     */
    public function testGetBlockList()
    {
        $list = $this->getUserService()->getBlockList('testUserOne');
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $this->getUserService()->getStatusCode()
        ); //200
        $this->assertInternalType('array', $list);
        $this->assertArrayHasKey('user_id', $list[0]);
    }
}