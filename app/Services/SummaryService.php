<?php declare(strict_types = 1);

namespace App\Services;

class SummaryService
{
    public function __construct(
        protected OpenRouterApiService $openRouterApiService
    ) {
    }

    public function generateSummary(array $captions): string
    {
        $summaryResponse = $this->openRouterApiService->generateSummaryFromCaptionsStreaming($captions);

        return $this->openRouterApiService->getMessageContent($summaryResponse);
    }
}
