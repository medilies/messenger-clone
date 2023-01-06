<?php

namespace Tests\Feature\Http\Controllers;

use _Modules\Chat\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ConversationControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function inbox()
    {
        $this->authenticate();

        $c = Conversation::factory()
            ->hasAttached(auth()->user())
            ->hasAttached(User::factory())
            ->count(5)
            ->create();

        $this->get(route('chat.inbox'))
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json->has('data', 5)
            );

        $this->assertDatabaseCount(tableNameFromModel(Conversation::class), 5);

        $this->assertDatabaseCount('conversation_user', 10);
    }
}
