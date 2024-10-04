<?php declare(strict_types = 1);

namespace Database\Factories;

use App\Traits\Factory\HasDeleted;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    use HasDeleted;

    public function definition(): array
    {
        return [
            'name'  => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber,
            'type'  => 'customer',

            'linkedin'  => 'https://linkedin.com/in/' . fake()->userName,
            'facebook'  => 'https://facebook.com/' . fake()->userName,
            'instagram' => 'https://instagram.com/' . fake()->userName,
            'twitter'   => 'https://x.com/' . fake()->userName,

            'address' => fake()->address,
            'city'    => fake()->city,
            'state'   => fake()->state,
            'zip'     => fake()->postcode,
            'country' => fake()->country,

            'age'    => fake()->numberBetween(18, 65),
            'gender' => fake()->randomElement(['male', 'female', 'other']),

            'company'  => fake()->company,
            'position' => fake()->jobTitle,

        ];
    }
}
