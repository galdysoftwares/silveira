<?php declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'url'         => fake()->url(),
            'youtube_id'  => fake()->uuid(),
            'title'       => fake()->title(),
            'description' => fake()->realText(),
        ];
    }
}
