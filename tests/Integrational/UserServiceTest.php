<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7;

class UserServiceTest extends BaseClass
{
    /**
     * Set Up Client
     */
    public static function setUpBeforeClass()
    {
        $mock = new MockHandler([
            new Response(ResponseStatus::HTTP_CREATED, ['Content-Type' => 'application/json']),
            new Response(ResponseStatus::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']),
            new Response(ResponseStatus::HTTP_NO_CONTENT, ['Content-Type' => 'application/json']),
            new Response(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY, ['Content-Type' => 'application/json']),
            new Response(ResponseStatus::HTTP_NO_CONTENT, ['Content-Type' => 'application/json']),
            new Response(ResponseStatus::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']),
            new Response(
                ResponseStatus::HTTP_OK, 
                ['Content-Type' => 'application/json'], 
                Psr7\stream_for('{"first_name":"Andy"}')
            ),
            new Response(ResponseStatus::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']),
            new Response(ResponseStatus::HTTP_NO_CONTENT, ['Content-Type' => 'application/json']),
            new Response(ResponseStatus::HTTP_NOT_FOUND, ['Content-Type' => 'application/json']),
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
}