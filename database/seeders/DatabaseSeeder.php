<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use App\Repositories\ConversationRepository;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $first_user = User::factory()->create([
            'name' => 'medilies',
            'email' => 'y@y.y',
        ]);

        $second_user = User::factory()->create([
            'name' => 'dummy',
            'email' => 'e@e.e',
        ]);

        $other_users = User::factory(30)->create();

        $users_ids = range(1, $other_users->count() + 2);

        /** @var ConversationRepository */
        $conversation_repo = app()->make(ConversationRepository::class);

        foreach ($other_users as $user) {
            $conversation = $conversation_repo->createDirectConversation($first_user, $user);

            Message::factory()->for($conversation)->for($user)->count(2)->create();
        }
    }
}
