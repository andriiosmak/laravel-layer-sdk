<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

class UserServiceTest extends BaseClass
{
    /**
     * Test user creation
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
        $this->assertFalse($this->getUserService()->create([], 'testUserOne'));
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

        $result = $this->getUserService()->replace($data, 'testUserOne');
        $this->assertFalse($this->getUserService()->replace([], 'testUserOne'));
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

        $this->assertTrue($this->getUserService()->update($data, 'testUserOne'));
        //$this->assertNull($this->getUserService()->update($data, time()));
    }

    /**
     * Test obtaining information about a user
     */
    public function testGetUser()
    {
        $this->assertArrayHasKey('first_name', $this->getUserService()->get('testUserOne'));
        $this->assertNull($this->getUserService()->get(time()));
    }

    /**
     * Test user deletion
     */
    public function testDeleteUser()
    {
        $this->assertTrue($this->getUserService()->delete('testUserOne'));
        $this->assertFalse($this->getUserService()->delete(time()));
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