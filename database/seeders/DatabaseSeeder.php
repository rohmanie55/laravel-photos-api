<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Photo;
use App\Models\PhotoLike;
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

        $photos = Photo::factory(5)->create(['user_id'=>$user->id]);

        $userIds= User::select('id')->pluck('id');

        foreach($photos as $key=>$photo){
            $inputs =[];
            $ids = $userIds->random(rand(1,$userIds->count()))->all();

            foreach($ids as $user_id){
                $inputs[]=[
                    'photo_id'=>$photo->id,
                    'user_id' =>$user_id,
                    'created_at'=>now()->toDateTimeString()
                ];
            }

            PhotoLike::insert($inputs);
        }
    }
}
