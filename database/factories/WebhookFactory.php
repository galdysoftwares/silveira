<?php declare(strict_types = 1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class WebhookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'provider' => fake()->companySuffix(),
            'headers'  => fake()->json(),
            'payload'  => fake()->json(),
        ];
    }
}
