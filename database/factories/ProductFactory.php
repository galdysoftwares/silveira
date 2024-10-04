<?php declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Category;
use App\Traits\Factory\HasDeleted;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    use HasDeleted;

    public function definition(): array
    {
        return [
            'title'       => fake()->company(),
            'code'        => Str::random(10),
            'description' => fake()->paragraph(),
            'amount'      => fake()->numberBetween(100, 10000),
            'category_id' => Category::factory(),
        ];
    }
}
