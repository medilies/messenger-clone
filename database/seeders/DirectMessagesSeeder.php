<?php

namespace Database\Seeders;

use App\Models\DirectMessage;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DirectMessagesSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run($users_ids, $count = 1000)
    {
        $faker = Factory::create();

        $direct_messages = [];

        for ($i = 0; $i < $count; $i++) {
            $users = [
                'user_id' => $faker->randomElement($users_ids),
                'target_user_id' => $faker->randomElement($users_ids),
            ];

            $direct_messages[] = DirectMessage::factory($users)->make()->toArray();
        }

        DirectMessage::insert($direct_messages);
    }
}
