<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DirectConversationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function start()
    {
        $this->authenticate();

        $user = User::factory()->create();

        $this->post(route('conversations.direct.start', ['user' => $user]))
            ->assertCreated();

        $this->assertDatabaseCount(tableNameFromModel(Conversation::class), 1)
            ->assertDatabaseHas(tableNameFromModel(Conversation::class), ['type' => 'direct']);

        $this->assertDatabaseCount('conversation_user', 2)
            ->assertDatabaseHas('conversation_user', ['user_id' => auth()->id()])
            ->assertDatabaseHas('conversation_user', ['user_id' => $user->id]);
    }
}
