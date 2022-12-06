<?php

namespace Database\Seeders;

use App\Models\User;
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

        $this->call(DirectMessagesSeeder::class, false, ['users_ids' => $users_ids]);

        $this->call(DirectMessagesSeeder::class, false, ['users_ids' => [$first_user->id, $second_user->id], 'count' => 50]);
    }
}
