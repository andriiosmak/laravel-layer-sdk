<?php

namespace Aosmak\Laravel\Layer\Sdk\Functional;

use Symfony\Component\HttpFoundation\Response as ResponseStatus;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7;

/**
 * Class IdentityServiceTest
 * @package namespace Aosmak\Laravel\Layer\Sdk\Functional
 */
class IdentityServiceTest extends BaseClass
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
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_UNPROCESSABLE_ENTITY),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_OK),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
            self::getResponse(ResponseStatus::HTTP_NO_CONTENT),
            self::getResponse(ResponseStatus::HTTP_NOT_FOUND),
        ]);
        self::setUpService($mock);
    }

    /**
     * Test user creation
     *
     * @return void
     */
    public function testCreateIdentity(): void
    {
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

        $response = $this->getIdentityService()->create([], 'testBotOne');
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

        $response = $this->getIdentityService()->replace($data, 'testBotOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getIdentityService()->replace([], 'testBotOne');
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

        $response = $this->getIdentityService()->update($data, 'testBotOne');
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
        $response = $this->getIdentityService()->get('testBotOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);

        //get user with wrong id
        $response = $this->getIdentityService()->get(time());
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
        $response = $this->getIdentityService()->delete('testBotOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getIdentityService()->delete(time());
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NOT_FOUND,
            $response->getStatusCode()
        ); //404
    }
}
