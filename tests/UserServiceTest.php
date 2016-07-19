<?php

namespace Aosmak\Layer;

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

        $result = $this->getUserService()->update($data, 'testUserOne');

        $this->assertTrue($result);
        $this->assertFalse($this->getUserService()->update($data, 'wrongUserId'));
    }

    /**
     * Test obtaining information about a user
     */
    public function testGetUser()
    {
        $this->assertArrayHasKey('first_name', $this->getUserService()->get('testUserOne'));
        $this->assertFalse($this->getUserService()->get('wrongUserId'));
    }

    /**
     * Test user deletion
     */
    public function testDeleteUser()
    {
        $this->assertTrue($this->getUserService()->delete('testUserOne'));
        $this->assertFalse($this->getUserService()->delete('wrongUserId'));
    }
}