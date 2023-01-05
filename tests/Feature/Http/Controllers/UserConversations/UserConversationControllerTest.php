<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Modules\Chat\Models\Conversation;
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
}
