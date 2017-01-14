<?php

namespace Aosmak\Laravel\Layer\Sdk\Old;

class ConversationServiceTest extends BaseClass
{
    /**
     * Test conversation creation
     */
    public function testCreateConversation()
    {
        $id = $this->getConversationService()->create([
            'participants' => [
                "tu1",
                "tu2",
            ],
            //'distinct' => true,
        ]);

        $this->assertInternalType('string', $id);
        $this->assertNull($this->getConversationService()->create([]));

        return $id;
    }

    /**
     * Test conversation update
     */
    public function testUpdateUser()
    {
        $id = $this->testCreateConversation();
        $result = $this->getConversationService()->update([
            [
                'operation' => 'set',
                'property'  => 'participants',
                'value'     =>  ["tu2", "tu1"],
            ],
        ], $id);

        $this->assertTrue($result);
    }

    /**
     * Test obtaining information about a conversation
     */
    public function testGetConversation()
    {
        $id = $this->testCreateConversation();
        $this->assertArrayHasKey('url', $this->getConversationService()->get($id));
        $this->assertNull($this->getConversationService()->get('wrongId'));
    }

    /**
     * Test obtaining information about conversations
     */
    public function testGetConversations()
    {
        $this->assertInternalType('array', $this->getConversationService()->all('tu1'));
        $this->assertEmpty($this->getConversationService()->all('wrongId'));
    }

    /**
     * Test conversation deletion
     */
    public function testDeleteConversation()
    {
        $id = $this->testCreateConversation();
        $this->assertTrue($this->getConversationService()->delete($id));
        $this->assertFalse($this->getConversationService()->delete('wrongId'));
    }
}