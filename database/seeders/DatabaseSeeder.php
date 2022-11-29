<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(15)->create();

        \App\Models\User::factory()->create([
            'name' => 'medilies',
            'email' => 'y@y.y',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'dummy',
            'email' => 'e@e.e',
        ]);
    }
}
