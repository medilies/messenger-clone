<?php

namespace Database\Seeders;

use _Modules\Chat\Seeders\ConversationSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        $this->call(UsersSeeder::class);
        // $this->call(ConversationSeeder::class);
    }
}
