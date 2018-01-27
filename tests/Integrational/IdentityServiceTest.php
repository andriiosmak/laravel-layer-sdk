<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

use Aosmak\Laravel\Layer\Sdk\Models\ResponseStatus;

/**
 * Class IdentityServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Integrational
 */
class IdentityServiceTest extends BaseClass
{
    /**
     * Test user creation
     *
     * @return void
     */
    public function testCreateIdentity(): void
    {
        //delete if exists
        $this->getIdentityService()->delete('testBotOne');

        $data = [
            "first_name"    => 'testName',
            "last_name"     => 'testSurname',
            "display_name"  => 'testDisplayName',
            "phone_number"  => 'testPhoneNumber',
            "identity_type" => 'bot',
        ];

        $response = $this->getIdentityService()->create($data, 'testBotOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $content);
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201

        $response = $this->getUserService()->create([], 'testBotOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertInternalType('array', $content);
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }

    /**
     * Test user replacement
     *
     * @return void
     */
    public function testReplaceUser(): void
    {
        $data = [
            "first_name"    => 'testName',
            "last_name"     => 'testSurname',
            "display_name"  => 'testDisplayName',
            "phone_number"  => 'testPhoneNumber',
            "identity_type" => 'bot',
        ];

        $response = $this->getUserService()->replace($data, 'testBotOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getUserService()->replace([], 'testBotOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
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

        $response = $this->getUserService()->update($data, 'testBotOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204
    }

    /**
     * Test obtaining information about a user
     *
     * @return void
     */
    public function testGetUser(): void
    {
        $response = $this->getUserService()->get('testBotOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200

        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('first_name', $content);
        $this->assertArrayHasKey('phone_number', $content);
        $this->assertArrayHasKey('email_address', $content);
        $this->assertArrayHasKey('url', $content);
        $this->assertArrayHasKey('display_name', $content);
        $this->assertArrayHasKey('identity_type', $content);
        $this->assertArrayHasKey('public_key', $content);
        $this->assertArrayHasKey('user_id', $content);
        $this->assertArrayHasKey('id', $content);
        $this->assertArrayHasKey('last_name', $content);
        $this->assertArrayHasKey('metadata', $content);
        $this->assertArrayHasKey('avatar_url', $content);

        //get user with wrong id
        $response = $this->getUserService()->get(time());
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }

    /**
     * Test user deletion
     *
     * @return void
     */
    public function testDeleteUser(): void
    {
        $response = $this->getUserService()->delete('testBotOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getUserService()->delete(time());
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }
}
