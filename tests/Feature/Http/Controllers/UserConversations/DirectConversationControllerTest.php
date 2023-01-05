<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Modules\Chat\Models\Conversation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DirectConversationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getConversation()
    {
        $this->authenticate();

        $user = User::factory()->create();

        $this->get(route('conversations.direct.get', ['user' => $user]))
            ->assertCreated();

        $this->assertDatabaseCount(tableNameFromModel(Conversation::class), 1)
            ->assertDatabaseHas(tableNameFromModel(Conversation::class), ['type' => 'direct']);

        $this->assertDatabaseCount('conversation_user', 2)
            ->assertDatabaseHas('conversation_user', ['user_id' => auth()->id()])
            ->assertDatabaseHas('conversation_user', ['user_id' => $user->id]);
    }
}
