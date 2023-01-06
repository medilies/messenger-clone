<?php

namespace _Modules\Chat\Seeders;

use _Modules\Chat\Models\Message;
use _Modules\Chat\Repositories\ConversationRepository;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $users = User::latest('id')->get();

        $first_user = $users->pop();

        /** @var ConversationRepository */
        $conversation_repo = app()->make(ConversationRepository::class);

        foreach ($users as $user) {
            $conversation = $conversation_repo->createDirectConversation($first_user, $user);

            // TODO: use new message service
            Message::factory()
                ->for($conversation)
                ->for($user)
                ->count(2)
                ->create();
        }
    }
}
