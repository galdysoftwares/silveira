<?php declare(strict_types = 1);

namespace Database\Factories;

use App\Traits\Factory\HasDeleted;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    use HasDeleted;

    public function definition(): array
    {
        return [
            'title' => fake()->name(),
        ];
    }
}
