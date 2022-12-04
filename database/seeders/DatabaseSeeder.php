<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        User::factory()->create([
            'name' => 'medilies',
            'email' => 'y@y.y',
        ]);

        User::factory()->create([
            'name' => 'dummy',
            'email' => 'e@e.e',
        ]);

        User::factory(30)->create();
    }
}
