<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();

        return [
            'path'=>md5($user->id),
            'file_name'=>md5(time()).'.'.fake()->randomElement(['jpg','png','webp']),
            'size' => fake()->randomNumber(5),
            'caption'=> fake()->sentence(),
            'tags' => fake()->randomElements(fake()->words(5)),
            'user_id'=>$user->id
        ];
    }
}
