<?php declare(strict_types = 1);

namespace App\Services;

class LLMModelFactory
{
    public static function create(string $modelType): string
    {
        $models = [
            'liquid' => 'liquid/lfm-40b:free',
            'gpt'    => 'gpt-3.5-turbo',
            'mytho'  => 'gryphe/mythomist-7b:free',
            'llama'  => 'meta-llama/llama-3.2-3b-instruct:free',
        ];

        return $models[$modelType] ?? $models['liquid'];
    }
}
