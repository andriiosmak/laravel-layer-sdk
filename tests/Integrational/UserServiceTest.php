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
     * Conversation ID
     *
     * @var string
     */
    public static $conversationId;

    /**
     * Message ID
     *
     * @var string
     */
    public static $messageId;

    /**
     * Test user creation
     *
     * @return void
     */
    public function testCreateUser(): void
    {
        //delete if exists
        $this->getUserService()->delete('testUserOne');

        $data = [
            "first_name"   => 'testName',
            "last_name"    => 'testSurname',
            "display_name" => 'testDisplayName',
            "phone_number" => 'testPhoneNumber',
        ];

        $response = $this->getUserService()->create($data, 'testUserOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('array', $content);
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201

        $response = $this->getUserService()->create([], 'testUserOne');
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
            "first_name"   => 'testNameUpdated',
            "last_name"    => 'testSurnameUpdated',
            "display_name" => 'testDisplayNameUpdated',
            "phone_number" => 'testPhoneNumberUpdated',
        ];

        $response = $this->getUserService()->replace($data, 'testUserOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getUserService()->replace([], 'testUserOne');
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

        $response = $this->getUserService()->update($data, 'testUserOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204
    }

    /**
     * Test message creation
     *
     * @return void
     */
    public function testSendMessage(): void
    {
        $data = [
            'parts' => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain'
                ],
            ],
        ];

        $conversationId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ])->getCreatedItemId();

        $response = $this->getUserDataService()->sendMessage($data, "tu1", $conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertInternalType('string', $response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_CREATED,
            $response->getStatusCode()
        ); //201

        $response = $this->getUserDataService()->sendMessage([], "tu1", $conversationId);
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertNull($response->getCreatedItemId());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }

    /**
     * Test obtaining information about a user
     *
     * @return void
     */
    public function testGetUser(): void
    {
        $response = $this->getUserService()->get('testUserOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('first_name', $content);
        $this->assertArrayHasKey('is_bot', $content);
        $this->assertArrayHasKey('phone_number', $content);
        $this->assertArrayHasKey('email_address', $content);
        $this->assertArrayHasKey('display_name', $content);
        $this->assertArrayHasKey('public_key', $content);
        $this->assertArrayHasKey('user_id', $content);
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
     * Test badge creation
     *
     * @return void
     */
    public function testCreateBadge(): void
    {
        $data = [
            "external_unread_count" => 15,
        ];

        $response = $this->getUserService()->createBadge($data, 'testUserOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_NO_CONTENT,
            $response->getStatusCode()
        ); //204

        $response = $this->getUserService()->createBadge([], time());
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_UNPROCESSABLE_ENTITY,
            $response->getStatusCode()
        ); //422
    }

    /**
     * Test obtaining information about user badges
     *
     * @return void
     */
    public function testGetBadge(): void
    {
        $response = $this->getUserService()->getBadges('testUserOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertArrayHasKey('external_unread_count', $content);
        $this->assertArrayHasKey('unread_message_count', $content);
        $this->assertArrayHasKey('unread_conversation_count', $content);
        $this->assertArrayHasKey('external_unread_count', $content);
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

        $response = $this->getUserService()->updateBlockList($data, 'testUserOne');
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_ACCEPTED,
            $response->getStatusCode()
        ); //202
    }

    /**
     * Test block list
     *
     * @return void
     */
    public function testGetBlockList(): void
    {
        $response = $this->getUserService()->getBlockList('testUserOne');
        $content  = $response->getContents();
        $this->assertInstanceOf('Aosmak\Laravel\Layer\Sdk\Models\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertEquals(
            ResponseStatus::HTTP_OK,
            $response->getStatusCode()
        ); //200
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('user_id', $content[0]);
    }

    /**
     * Test user deletion
     *
     * @return void
     */
    public function testDeleteUser(): void
    {
        $response = $this->getUserService()->delete('testUserOne');
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
