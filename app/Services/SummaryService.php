<?php declare(strict_types = 1);

namespace App\Services;

use App\Services\Prompts\Summary\DescriptiveSummaryPrompt;
use GuzzleHttp\Client;

class SummaryService
{
    protected LLMService $llmService;

    public function __construct(
        protected OpenRouterApiService $openRouterApiService
    ) {
        // Inicializa a fábrica do modelo e o cliente HTTP
        $client         = new Client();
        $model          = LLMModelFactory::create('llama'); // passar model no construtor
        $promptStrategy = new DescriptiveSummaryPrompt(); // passar strategy no construtor

        // Injeta no serviço
        $this->llmService = new LLMService($client, $promptStrategy, $model);
    }

    public function generateSummary(array $captions)
    {
        $summary = $this->llmService->generateSummaryFromCaptions($captions);

        return $this->llmService->getSummary($summary);
    }

    public function generateSummaryOld(array $captions): string
    {
        $summaryResponse = $this->openRouterApiService->generateSummaryFromCaptionsStreaming($captions);

        return $this->openRouterApiService->getMessageContent($summaryResponse);
    }
}
