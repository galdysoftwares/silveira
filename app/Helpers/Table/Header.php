<?php declare(strict_types = 1);

namespace App\Helpers\Table;

readonly class Header
{
    public function __construct(
        public string $key,
        public string $label,
    ) {
    }

    public static function make(string $key, string $label): self
    {
        return new self($key, $label);
    }
}
