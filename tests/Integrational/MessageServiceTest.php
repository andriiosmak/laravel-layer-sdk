<?php

namespace Aosmak\Laravel\Layer\Sdk\Integrational;

class MessageServiceTest extends BaseClass
{
    /**
     * Test message creation
     */
    public function testCreateMessage()
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

        $convId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ]);

        $id = $this->getMessageService()->create($data, $convId);

        $this->assertInternalType('string', $id);
        $this->assertNull($this->getMessageService()->create([], $convId));

        return $id;
    }

    /**
     * Test getListSystem method
     */
    public function testGetListSystemMessage()
    {
        $convId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ]);

        $this->assertInternalType('array', $this->getMessageService()->allLikeSystem($convId));
        $this->assertNull($this->getMessageService()->allLikeSystem('wrongId'));
    }

    /**
     * Test getListsUser method
     */
    public function testgGetListsUserMessage()
    {
        $convId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ]);

        $this->assertInternalType('array', $this->getMessageService()->allLikeUser($convId, 'tu1'));
        $this->assertNull($this->getMessageService()->allLikeUser('wrongId', 'tu1'));
        $this->assertNull($this->getMessageService()->allLikeUser($convId, 'wrongId'));
    }

    /**
     * Test getLikeSystem method
     */
    public function testgetLikeSystemMessage()
    {
        $convId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ]);
        $id = $this->testCreateMessage();

        $this->assertArrayHasKey('id', $this->getMessageService()->getLikeSystem($id, $convId));
        $this->assertNull($this->getMessageService()->getLikeSystem($id, 'wrongId'));
        $this->assertNull($this->getMessageService()->getLikeSystem('wrongId', $convId));
    }

    /**
     * Test getLikeUser method
     */
    public function testgetLikeUserMessage()
    {
        $userId = "tu1";
        $id     = $this->testCreateMessage();

        $this->assertArrayHasKey('id', $this->getMessageService()->getLikeUser($id, $userId));
        $this->assertNull($this->getMessageService()->getLikeUser($id, 'wrongId'));
        $this->assertNull($this->getMessageService()->getLikeUser('wrongId', $userId));
    }

    /**
     * Test message deletion
     */
    public function testDeleteMessage()
    {
        $convId = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
        ]);
        $id = $this->testCreateMessage();

        $this->assertTrue($this->getMessageService()->delete($id, $convId));
        $this->assertFalse($this->getMessageService()->delete('wrongId', 'wrongId'));
    }

    /**
     * Test announcement creation
     */
    public function testCreateAnnouncement()
    {
        $data = [
            'recipients' => [
                "tu1",
                "tu2",
            ],
            'sender' => [
                'name' => 'The System',
            ],
            'parts' => [
                [
                    'body'      => 'Hello, World!',
                    'mime_type' => 'text/plain'
                ],
            ],
        ];

        $this->assertInternalType('string', $this->getMessageService()->createAnnouncement($data));
        $this->assertNull($this->getMessageService()->createAnnouncement([]));
    }

    /**
     * Test notification creation
     */
    public function testCreateNotification()
    {
        $data = [
            'recipients' => [
                "tu1",
                "tu2",
            ],
            'notification' => [
                'text'  => 'This is the alert text to include with the Push Notification.',
                'sound' => 'chime.aiff',
            ],
        ];

        $this->assertNull($this->getMessageService()->createNotification($data));
        $this->assertNull($this->getMessageService()->createNotification([]));
    }
}