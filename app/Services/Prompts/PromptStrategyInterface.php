<?php declare(strict_types = 1);

namespace App\Services\Prompts;

interface PromptStrategyInterface
{
    public function generatePrompt(array $captionsText): string;
}
