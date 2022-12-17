<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UserConversationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function list()
    {
        $this->authenticate();

        Conversation::factory()
            ->hasAttached(auth()->user())
            ->hasAttached(User::factory())
            ->count(5)
            ->create();

        $this->get(route('conversations.list'))
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->has(5)
            );

        $this->assertDatabaseCount(tableNameFromModel(Conversation::class), 5);

        $this->assertDatabaseCount('conversation_user', 10);
    }

    /**
     * @test
     */
    public function createDirectConversation()
    {
        $this->authenticate();

        $user = User::factory()->create();

        $this->post(route('conversations.direct.create', ['user' => $user]))
            ->assertCreated();

        $this->assertDatabaseCount(tableNameFromModel(Conversation::class), 1)
            ->assertDatabaseHas(tableNameFromModel(Conversation::class), ['type' => 'direct']);

        $this->assertDatabaseCount('conversation_user', 2)
            ->assertDatabaseHas('conversation_user', ['user_id' => auth()->id()])
            ->assertDatabaseHas('conversation_user', ['user_id' => $user->id]);
    }
}
