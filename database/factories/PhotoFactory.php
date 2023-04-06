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
        return [
            'path'=>fake()->imageUrl(480, 480),
            'file_name'=>md5(time()).'.'.fake()->randomElement(['jpg','png','webp']),
            'size' => fake()->randomNumber(5),
            'caption'=> fake()->sentence(),
            'tags' => fake()->randomElement(fake()->words(5)),
            'user_id'=>User::factory()->create()->id
        ];
    }
}
