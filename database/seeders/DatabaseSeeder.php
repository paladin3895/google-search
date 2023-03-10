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
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Dat Pham',
            'email' => 'duydatyds@gmail.com',
        ]);

        $user->createToken('Initial');

        $keyword = \App\Models\Keyword::factory()->create([
            'user_id' => $user->id,
        ]);
    }
}
