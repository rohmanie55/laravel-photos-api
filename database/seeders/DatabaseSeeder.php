<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Photo;
use App\Models\User;
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
        $user= User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Photo::factory(5)->create(['user_id'=>$user->id]);
    }
}
