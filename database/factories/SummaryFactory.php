<?php declare(strict_types = 1);

namespace Database\Factories;

use App\Models\{User, Video};
use Illuminate\Database\Eloquent\Factories\Factory;

class SummaryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title'    => fake()->title(),
            'content'  => fake()->realText(),
            'user_id'  => User::factory(),
            'video_id' => Video::factory(),
        ];
    }
}
