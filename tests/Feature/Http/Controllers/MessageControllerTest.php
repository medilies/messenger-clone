<?php

namespace Tests\Feature\Http\Controllers;

use _Modules\Chat\Events\NewMessageEvent;
use _Modules\Chat\Models\Conversation;
use _Modules\Chat\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MessageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function newConversationMessage()
    {
        Event::fake(NewMessageEvent::class);

        // -------------------------------------
        // DB setup
        // -------------------------------------

        $this->authenticate();

        $user_2 = User::factory()->create();

        $conversation = Conversation::factory()
            ->hasAttached(auth()->user())
            ->hasAttached($user_2)
            ->create();

        $message = Message::factory()->make();

        // -------------------------------------
        // POST
        // -------------------------------------

        $this->post(route('chat.conversations.messages.new', ['conversation' => $conversation->id]), ['content' => $message->content])
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) => $json
                    ->where('content', $message->content)
                    ->where('conversation_id', $conversation->id)
                    ->where('user_id', auth()->id())
                    ->etc()
            );

        // -------------------------------------
        // DB assertions
        // -------------------------------------

        $this->assertDatabaseCount(tableNameFromModel(Conversation::class), 1);
        $this->assertDatabaseHas(tableNameFromModel(Conversation::class), ['id' => $conversation->id, 'type' => 'direct']);

        $this->assertDatabaseCount('conversation_user', 2);
        $this->assertDatabaseHas('conversation_user', ['conversation_id' => $conversation->id, 'user_id' => auth()->id()]);
        $this->assertDatabaseHas('conversation_user', ['conversation_id' => $conversation->id, 'user_id' => $user_2->id]);

        $this->assertDatabaseCount(tableNameFromModel(Message::class), 1);
        $this->assertDatabaseHas(tableNameFromModel(Message::class), [
            'content' => $message->content,
            'user_id' => auth()->id(),
            'conversation_id' => $conversation->id,
        ]);

        // -------------------------------------
        // Event assertions
        // -------------------------------------

        Event::assertDispatched(NewMessageEvent::class);
        Event::assertDispatchedTimes(NewMessageEvent::class, 1);
        Event::assertDispatched(
            fn (NewMessageEvent $event): bool =>
            // ! need to assert used channel
            count($event->message['conversation']['other_users']) === 1
        );
    }
}
