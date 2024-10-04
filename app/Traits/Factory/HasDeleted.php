<?php declare(strict_types = 1);

namespace App\Traits\Factory;

trait HasDeleted
{
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
        ]);
    }
}
