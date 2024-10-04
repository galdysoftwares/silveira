<?php declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Customer;
use App\Traits\Factory\HasDeleted;
use Illuminate\Database\Eloquent\Factories\Factory;

class OpportunityFactory extends Factory
{
    use HasDeleted;

    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'title'       => fake()->sentence(),
            'status'      => fake()->randomElement(['open', 'won', 'lost']),
            'amount'      => fake()->numberBetween(100, 10000),
        ];
    }
}
